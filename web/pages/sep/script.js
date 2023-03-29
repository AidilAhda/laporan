var controller="/sep/";
function setIdSep(id){
    $('#sep-id').val(id);
}
function getNomor(){
    return $("input[name='nomor']").val();
}
function getNoSep(){
    return $("input[name='no_sep']").val();
}
function searchSepRujukan(no_rujukan=null){
    var data={};

    if(no_rujukan==null){
        var jenis=$("input[name='searchby']:checked").val();
        data.jenis=jenis;
        if(jenis==1){ // pencarian berdasarkan no sep
            data.nosep=getNoSep();
        }else if(jenis==2){ //pencarian berdasarkan no kartu
            data.multi=$("input[name='multi']:checked").val();
            data.tingkat_faskes=$("select[name='tingkat_faskes1']").val();
            data.no_kartu=$("input[name='no_kartu']").val();
        }else{ //pencarian berdasarkan no rujukan
            data.tingkat_faskes=$("select[name='tingkat_faskes2']").val();
            data.no_rujukan=$("input[name='no_rujukan']").val();
        }
    }else{
        //pencarian no rujukan dari list rujukan
        data.jenis=4;
        data.no_rujukan=no_rujukan;
    }

    //kontrol post rawatinap
    var post_ri='';
    if($('#sep-is_kontrol_post_ri').prop('checked')){
        post_ri='on';
    }
    data.post_ri=post_ri;
    if(data){
        var btn=$('.btn-sep-search');
        var htm=btn.html();
        setLoadingBtn(btn,'Mencari...');
        hideListTableRujukan();
        $.ajax({
            url:base_url+'/sep/search',
            type:'post',
            dataType:'json',
            data:data,
            success:function(result){
                console.log(result);
                if(result.status){
                    if(jenis==2 && data.multi==1){
                        displayListRujukan(result.rujukan);
                    }else{
                        var rm=$("input[name='Sep[pasien_kode]'").val();
                        if(rm!='' && result.peserta.peserta.norm!=''){ //jika ada no rm 
                            if(rm!=result.peserta.peserta.norm){ //periksa apakah no rm simrs sama dengan no rm bpjskes
                                errorMsg('No. RM tidak sesuai !<br>No. RM SIMRS : <b>'+rm+'</b><br>No. RM BPJSKES : <b>'+result.peserta.peserta.norm+'</b>');
                                resetLoadingBtn(btn,htm);
                                return false;
                            }
                        }
                        //periksa no_kartu dari peserta n sep/rujukan
                        if(result.peserta.peserta.nokartu!=result.sep.no_kartu){
                            errorMsg('No. KARTU BPJS tidak sesuai !<br>No. Kartu Peserta : <b>'+result.peserta.nokartu+'</b><br>No. Kartu di Rujukan/SEP : <b>'+result.sep.no_kartu+'</b>');
                            resetLoadingBtn(btn,htm);
                            return false;
                        }
                        setFormPeserta(result.peserta);
                        setFormSep(result.sep);
                    }
                }else{
                    errorMsg(result.msg);
                }
                resetLoadingBtn(btn,htm);
            },
            error:function(xhr,status,error){
                errorMsg(error);
                resetLoadingBtn(btn,htm);
            }
        });
    }else{
        errorMsg('Silahkan lengkapi form pencarian');
    }
}
function resetFormPeserta(){
    var form=$('#peserta-bpjs-search-form');
    form[0].reset();
}
function setFormPeserta(data,jenis=null){
    resetFormPeserta();
    var tmp=data.peserta;
    if(data.status){
        successMsg(data.msg);
    }else{
        warningMsg(data.msg);
    }
    var form=$('#peserta-bpjs-search-form');
    $.each(tmp,function(i,v){ 
        if(i=='nokartu' && (jenis=='1' || jenis=='2')){
            form.find("input[name='nomor']").val(v);
            $('#sep-no_kartu').val(v);
        }else if(i=='nokartu' && jenis==null){
            form.find("input[type='radio'][value='1']").prop('checked',true);
            form.find("input[name='nomor']").val(v);
        }else if(i=='no_telp'){
            form.find("input[name='"+i+"']").val(v);
            $('#sep-no_telp').val(v);
        }else if(i=='norm'){
            var rm=$('#sep-pasien_kode').val();
            if(!rm){
                $('#sep-pasien_kode').val(v);
            }
        }else if(i=='kelas_kode'){
            $('#sep-kelas').val(v);
        }
        form.find("input[name='"+i+"']").val(v);
    });
}
function resetFormSep(){
    var form=$('#sep-form');
    form[0].reset();
    form.find('select').val('').trigger('change');
    form.find('.btn-sep-submit').attr('disabled',false);
}
function setFormSep(data){
    resetFormSep();
    if(data.status){
        successMsg(data.msg);
    }else{
        warningMsg(data.msg);
    }
    var form=$('#sep-form');
    $.each(data,function(i,v){ 
        if((i=='tingkat_faskes' || i=='jenis_pelayanan') && v){
            form.find("select[name='Sep["+i+"]']").val(v).change();
        }else if((i=='asal_rujukan_kode' || i=='diagnosa_kode' || i=='poli_kode') && v){
            form.find("select[name='Sep["+i+"]']").html("<option value='"+v.id+"|#|"+v.text+"'>"+v.text+"</option>");
        }else if(i=='is_poli_eksekutif' || i=='is_kontrol_post_ri'){
            if(v==1){
                form.find("input[name='Sep["+i+"]']").prop('checked',true);
            }
        }else if(i=='dpjp_kode' && v){
            form.find("select[name='Sep["+i+"]']").html(v);
        }else if(i=='submit_button'){
            form.find('.btn-sep-submit').attr('disabled',v);
        }else{  
            form.find("input[name='Sep["+i+"]']").val(v);
        }
    });
}
function displayListRujukan(rujukan){
    if(rujukan){
        var wrap=$('.wrap-list-rujukan');
        var tb=wrap.find('.tb-list-rujukan');
        var tr='';
        $.each(rujukan.rujukan,function(i,v){
            tr+='<tr class=\'tr-list-rujukan\' title=\'klik untuk menampilkan data rujukan ini\' data-rujukan=\''+v.noKunjungan+'\'>'+
                '<td>'+v.noKunjungan+'</td>'+
                '<td>'+v.tglKunjungan+'</td>'+
                '<td>'+v.peserta.nama+'</td>'+
                '<td>'+v.provPerujuk.nama+'</td>'+
                '<td>'+v.poliRujukan.nama+'</td>'+
            '</tr>';
        });
        wrap.show();
        tb.find('tbody').html(tr);
    }else{
        errorMsg('Rujukan tidak tersedia');
    }
}
function hideListTableRujukan(){
    $('.wrap-list-rujukan').hide();
}
function setFormCheckoutSep(data){
    var w=$('.wrap-sep-checkout');
    var tb=w.find('table');
    w.show();
    $.each(data,function(i,v){
        tb.find('td.'+i).html(v);
    });
}
function resetFormCheckoutSep(){
    var w=$('.wrap-sep-checkout');
    var tb=w.find('table');
    tb.find('td').empty();
    w.hide();
}

function cetakSep(sep){
    if(sep){
        var w=window.open(base_url+'/sep/cetak?sep='+sep, '_blank');
        if(w){
            w.focus();
        }else{
            errorMsg('Cetak SEP diblock oleh browser anda, izinkan popup untuk mencetak SEP');
        }
    }else{
        errorMsg('No. SEP BPJS gagal diterbitkan');
    }
}

//halaman list sep
//detail sep
function detailBtn(){
    $('#grid-sep .table tbody tr td').on('click','.btn-detail',function(e){
        e.preventDefault();
        var btn=$(this);
        var htm=btn.html();
        var id=$(this).attr('data-id');
        formModal({url:base_url+controller+'detail',data:{id:id},loading:{btn:btn,html:htm}});
    });
}
detailBtn();
$(document).on('ready pjax:success',function(){
    detailBtn();
});