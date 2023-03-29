var controller='/rawat-inap/';
function getRm(){
    return $('#pasien-kode').val();
}
function getNoReg(){
    
}

//pencarian pendaftaran pasien
$('#pasien-search-form').on('beforeSubmit',function(e){
    e.preventDefault();
    searchPasien();
}).on('submit',function(e){
    e.preventDefault();
});
function searchPasien(){
    var btn=$('.btn-search-pasien');
    var htm=btn.html();
    setLoadingBtn(btn,'Mencari...');
    $.ajax({
        url:base_url+controller+'pasien-search',
        type:'post',
        dataType:'json',
        data:$('#pasien-search-form').serialize(),
        success:function(result){
            if(result.status){
                resetFormPendaftaran();
                resetFormBiodata();
                if(result.layanan){
                    setFormPendaftaran(result.layanan);
                    setFormBiodata(result.biodata);
                }
                successMsg(result.msg);
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
}

//list terdaftar rawatpoli
$('.btn-list-pasien').click(function(e){
    e.preventDefault();
    var rm=getRm();
    var btn=$(this);
    var htm=btn.html();
    formModal({url:base_url+'/pasien/daftar-rawatpoli',data:{rm:rm},loading:{btn:btn,html:htm}});
});

$('#Layanan').find('.btn-reset').click(function(e){
    e.preventDefault();
    resetFormPendaftaran();
});

//reset form biodata 
function resetFormBiodata(){
    var form=$('#pasien-form');
    form[0].reset();
    form.find('select').val('').trigger('change');
    $('.tb-anak-detail').hide().find('tbody').empty();
    $('.tb-penanggung tbody').empty();
}

//set form biodata
function setFormBiodata(data){
    var form=$('#pasien-form');
    var wp=$('.wrap-pasangan');
    var wak=$('.wrap-anak-ke');
    var wai=$('.wrap-anak-istri');
    var wik=$('.wrap-istri-ke');
    var wja=$('.wrap-jml-anak');
    var wad=$('.wrap-anak-detail');
    $.each(data,function(i,v){
        if(i=='tgl_lahir'){
            var d=v.split("-");
            var e=d[2]+'-'+d[1]+'-'+d[0];
            $('#pasien-umur').val(getUmur(e));
            form.find("input[name='Pasien["+i+"]']").val(v);
        }else if(i=='kebiasaan'){
            form.find("input[name='Pasien["+i+"]']").val(v.join(','));
        }else if(i=='riwayat_penyakit'){
            form.find("input[name='Pasien["+i+"]']").val(v.join(','));
        }else if(i=='penanggung'){
            var h='';
            var no=1;
            $.each(v,function(i,v){
                h+='<tr>'+
                    '<td>'+no+'</td>'+
                    '<td>'+v.debitur+'</td>'+
                    '<td>'+v.nomor+'</td>'+
                '</tr>';
                no++;
            });
            $('.tb-penanggung tbody').html(h);
        }else if(i=='jml_anak'){
            if(v){
                wja.show();
                form.find("input[name='Pasien["+i+"]']").val(v);
            }else{
                wja.hide();
            }
        }else if(i=='anak'){
            if(v){
                wad.show();
                setTableAnak(v);
            }else{
                wad.hide();
            }
        }else{
            if(i=='nama_pasangan'){
                if(v){
                    wp.show();
                }else{
                    wp.hide();
                }
            }
            if(i=='anak_ke'){
                if(v){
                    wai.show();
                    wak.show();
                }else{
                    wak.hide();
                }
            }
            if(i=='istri_ke'){
                if(v){
                    wai.show();
                    wik.show();
                }else{
                    wik.hide();
                }
            }
            form.find("input[name='Pasien["+i+"]']").val(v);
        }
    });
}

function setTableAnak(data){
    var h='';
    $.each(data,function(i,v){
        var t=v.tgl_lahir.split('-');
        h+='<tr>'+
            '<td>'+v.nama+'</td>'+
            '<td>'+t[2]+'-'+t[1]+'-'+t[0]+'</td>'+
            '<td>'+( v.status==1 ? 'Anak Kandung' : 'Anak Tiri' )+'</td>'+
            '<td>'+v.no_rekam_medis+'</td>'+
        '</tr>';
    });
    $('.tb-anak-detail tbody').html(h);
}

//reset form pendaftaran ri
function resetFormPendaftaran(){
    var form=$('#Layanan');
    form[0].reset();
    $('.tb-dpjp').find('tbody').empty();
    form.find('select').val('').trigger('change');
}

//set form pendaftaran
function setFormPendaftaran(data){
    var form = $('#Layanan');
    $.each(data,function(i,v){
        if(i=='id'){
            if(v){
                form.find("input[name='"+i+"']").val(v);
            }
        }else if(i=='dokter'){
            if(v.length>0){
                var dokter=[];
                $.each(v,function(i,v){
                    dokter.push(v.id);
                    dpjpRow(v.id,v.status);
                });
                listRuang();
            }
        }else if(i=='unit_kode'){
            setTimeout(function(){
                form.find("select[name='Layanan["+i+"][]']").val(v).change();
            },3000);
        }else if(i=='cara_masuk_unit_kode'){
            form.find("select[name='Layanan["+i+"]']").val(v).change();
        }else{
            form.find("input[name='Layanan["+i+"]']").val(v);
        }
    });
}

//pendaftaran rawatinap
//display list ruang
$('.btn-list-ruang').click(function(e){
    e.preventDefault();
    var btn=$(this);
    var htm=btn.html();
    var unit=$('#layanan-unit_kode').val();
    if(unit){
        formModal({url:base_url+controller+'list-bed',data:{unit:unit},loading:{btn:btn,html:htm}});
    }else{
        errorMsg('Silahkan pilih unit terlebih dahulu');
    }
});

//sep
$('.btn-sep-form').click(function(e){
    e.preventDefault();
    var btn=$(this);
    var htm=btn.html();
    var rm=getRm();
    var noreg=getNoReg();
    var inap=true;
    var sep=$('#registrasi-no_sep').val();
    formModal({url:base_url+'/sep/form',data:{inap:inap,rm:rm,noreg:noreg,sep:sep},loading:{btn:btn,html:htm}});
});

//dpjp
//get id dokter dpjp from table
function getDpjp(){
    var row_dpjp = $(".tb-dpjp tbody").find("select[name=\"dokter[]\"]").find(":selected");
    dokter=[];
    if(row_dpjp.length>0){
        $.each(row_dpjp,function(i,v){
            var id = $(v.outerHTML).prop("value");
            dokter.push(id);
        });
    }
    return dokter;
}
//call list ruang based on dpjp
function listRuang(){
    var dokter=getDpjp();
    $.ajax({
        url:base_url+controller+'ruang-list',
        type:'post',
        data:{dokter:dokter},
        success:function(result){
            $("#layanan-unit_kode").html(result.data);
        },
        error:function(xhr,status,error){
            errorMsg(error);
        }
    });
}
//function add row dpjp
function dpjpRow(dokter=null,status=null){
    dpjp="";
    if(dpjp_dokter.length>0){
        dpjp+="<option value=''>- pilih DPJP -</option>";
        $.each(dpjp_dokter,function(i,v){
            var s="";
            if(dokter){
                if(dokter==v.id){
                    s="selected";
                }
            }
            dpjp+="<option value='"+v.id+"' "+s+">"+v.text+"</option>";
        });
    }
    var dpjp_el="<tr class='tr-dpjp'>"+
        "<td width='70%'><select name='dokter[]' class='form-control input-sm list-dpjp' style='width:100%'>"+dpjp+"</select></td>"+
        "<td>"+
            "<select name='status[]' class='form-control input-sm status'>"+
                "<option value='1' "+(status ? (status==1 ? 'selected' : '') : '')+">Dokter Utama</option>"+
                "<option value='2' "+(status ? (status==2 ? 'selected' : '') : '')+">Dokter Pendukung</option>"+
            "</select>"+
        "</td>"+
        "<td><button type='button' class='btn btn-sm btn-danger btn-flat btn-delete' title='hapus DPJP'><i class='fa fa-close'></i></button></td>";
    var tb=$('.tb-dpjp');
    tb.find('tbody').append(dpjp_el);
    tb.find('.list-dpjp').select2();
    tb.find('.list-dpjp').on('select2:select', function (e) {
        e.preventDefault();
        listRuang();
    });
    $(document).find('.tb-dpjp tbody tr td').on('click','.btn-delete',function(e){
        e.preventDefault();
        $(this).parent().parent().remove();
        listRuang();
    });
}
//click btn add row
$('.tb-dpjp').find('.btn-add-dpjp').click(function(e){
    e.preventDefault();
    dpjpRow();
});

//save rawatinap
$('#Layanan').on('beforeSubmit',function(e){
    e.preventDefault();
    var form=$(this);
    var btn=form.find('.btn-submit');
    var htm=btn.html();
    setLoadingBtn(btn,'Menyimpan...');
    $.ajax({
        url:base_url+controller+'save',
        type:'post',
        dataType:'json',
        data:form.serialize(),
        success:function(result){
            if(result.status){
                $("input[name='id']").val(result.id);
                successMsg(result.msg);
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
}).on('submit',function(e){
    e.preventDefault();
});