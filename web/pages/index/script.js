//set variable
var controller='/site/';
var wrap_kedudukan_keluarga=$('.wrap-kedudukan-keluarga');
var wrap_anak_istri=$('.wrap-anak-istri');
var wrap_pasangan=$('.wrap-pasangan');
var wrap_jml_anak=$('.wrap-jml-anak');

function getRm(){
    return $('#pasien-kode').val();
}
function setRm(no){
    $('#pasien-kode').val(no);
    $('#registrasi-pasien_kode').val(no);
}
function getNoReg(){
    return $('#registrasi-kode').val();
}
function setNoReg(noreg){
    $('#registrasi-kode').val(noreg);
}
function setNoSEP(nosep){
    var wrap=$('.wrap-bpjskes');
    if(nosep){
        wrap.show().find("input[type='text']").attr('required',true).val(nosep);
    }else{
        wrap.hide().find("input[type='text']").removeAttr('required').val('');
    }
}

//list pasien
$('.btn-list-pasien').click(function(e){
    e.preventDefault();
    var btn=$(this);
    var htm=btn.html();
    formModal({url:base_url+'/pasien/pasien-list',loading:{btn:btn,html:htm}});
});

//riwayat kunjungan
$('.btn-riwayat-kunjungan').click(function(e){
    e.preventDefault();
    var rm=getRm();
    var btn=$(this);
    var htm=btn.html();
    formModal({url:base_url+'/pasien/riwayat-kunjungan',data:{rm:rm},loading:{btn:btn,html:htm}});
});
//pencarian pasien
$('#pasien-search-form').on('beforeSubmit',function(e){
    e.preventDefault();
    searchPasien();
}).on('submit',function(e){
    e.preventDefault();
});
function searchPasien(data){
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
                setFormBiodata(result.data.biodata);
                setFormPendaftaran(result.data.layanan);
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

//---- BIODATA ---
//reset form biodata 
function resetFormBiodata(){
    var form=$('#pasien-form');
    form[0].reset();
    form.find('select').val('').trigger('change');
    $('.tb-anak-detail').find('tbody').empty();
    $('.tb-penanggung tbody').empty();
}

//set form biodata
function setFormBiodata(data){
    var form=$('#pasien-form');
    var select = ['jenis_identitas_kode','goldar','agama_kode','suku_kode','pendidikan_kode','pekerjaan_kode','kewarganegaraan_kode','jurusan_kode'];
    var select_multi=['kebiasaan','riwayat_penyakit'];
    $.each(data,function(i,v){
        if(i=='jkel'){
            form.find("input[name='Pasien["+i+"]'][value='"+v+"']").prop('checked',true);
        }else if(i=='tgl_lahir'){
            $('#pasien-umur').val(getUmur(v));
            form.find("input[name='Pasien["+i+"]']").val(v);
        }else if(select.includes(i)){
            form.find("select[name='Pasien["+i+"]']").val(v).change();
        }else if(i=='kelurahan' && v){
            form.find("select[name='Pasien[kelurahan_kode]'").html("<option value='"+v.id+"'>"+v.text+"</option>");
        }else if(i=='status_kawin_kode'){
            form.find("select[name='Pasien["+i+"]']").val(v).change();
            setKedudukanKeluarga();
            manageElementStatusKawin(v);
        }else if(i=='anak_detail' && v!=''){
            if(v.jml){
                form.find("input[name='Pasien[jml_anak]']").val(v.jml);
            }
            setFormAnak(v.jml,v.data);
        }else if(select_multi.includes(i)){
            form.find("select[name='Pasien["+i+"][]']").val(v).change();
        }else if(i=='penanggung'){
            var tbody=$('.tb-penanggung tbody');
            tbody.empty();
            $.each(v,function(ii,vv){
                tbody.append(tdPenanggung(vv)).find("input[type='text'],select").attr('required',true);
            });
            $('.tb-penanggung tbody tr td').on('click','.btn-del-penanggung',function(e){
                e.preventDefault();
                var tr=$(this);
                tr.parent().parent().remove();
            });
        }else{
            form.find("input[name='Pasien["+i+"]']").val(v);
        }
    });
}

$('#pasien-tgl_lahir').inputmask({
    regex:'[0-3][0-9]-[0-1][0-9]-[0-9]{4}'
});

$('#pasien-tgl_lahir').blur(function(){
    var v=$(this).val();
    if(v!=''){
        $('#pasien-umur').val(getUmur(v));
    }
});

$('#pasien-umur').blur(function(e){
    var v=$(this).val();
    if(v.length > 0 && v.length < 5){
        var today = new Date();
        var currentYear = today.getFullYear();
        var age = parseInt(v);
        var thn = '01'+'-'+'01'+'-'+(currentYear - age);
        $('#pasien-tgl_lahir').val(thn.toString());
    }
});

function setKedudukanKeluarga(){
    var data={};
    var status=$('#pasien-status_kawin_kode').val();
    if(status=='t'){
        data={'a':'Anak'};
    }else if(status=='k'){
        data={'k':'Kepala Keluarga','i':'Istri'};
    }else{
        data={};
    }
    if(Object.keys(data).length>0){
        var h='';
        $.each(data,function(i,v){
            h+="<option value='"+i+"'>"+v+"</option>";
        });
        wrap_kedudukan_keluarga.find('select').html(h);
    }else{
        wrap_kedudukan_keluarga.find('select').empty();
    }
}
function manageElementStatusKawin(v){
    if(v=='t'){
        wrap_kedudukan_keluarga.show();
        wrap_anak_istri.show().find('.wrap-anak-ke').show().find('input[type=\'text\']').attr('required',true);
        wrap_anak_istri.find('.wrap-istri-ke').hide().find('input[type=\'text\']').removeAttr('required');
        wrap_pasangan.hide().find('input[type=\'text\']').removeAttr('required');
        wrap_jml_anak.hide().find('input[type=\'text\']').removeAttr('required');
    }else{
        wrap_anak_istri.hide().find('input[type=\'text\']').removeAttr('required');
        wrap_jml_anak.show().find('input[type=\'text\']').attr('required',true);
        if(v=='k'){
            wrap_pasangan.show().find('input[type=\'text\']').attr('required',true);
            wrap_kedudukan_keluarga.show();
        }else{
            wrap_pasangan.hide().find('input[type=\'text\']').removeAttr('required');
            wrap_kedudukan_keluarga.hide();
        }
    }
}
setKedudukanKeluarga(); //set default kedudukan keluarga
$('#pasien-status_kawin_kode').change(function(e){
    var el=$(this);
    var v=el.val();
    if(v){
        setKedudukanKeluarga();
        manageElementStatusKawin(v);
    }
});
wrap_kedudukan_keluarga.find('select').change(function(e){
    var v=$(this).val();
    if(v=='a' || v=='i'){
        wrap_anak_istri.show();
        if(v=='a'){ //anak
            wrap_anak_istri.find('.wrap-anak-ke').show().find('input[type=\'text\']').attr('required',true);
            wrap_anak_istri.find('.wrap-istri-ke').hide().find('input[type=\'text\']').removeAttr('required');
        }else{ //istri
            wrap_anak_istri.find('.wrap-anak-ke').hide().find('input[type=\'text\']').removeAttr('required');
            wrap_anak_istri.find('.wrap-istri-ke').show().find('input[type=\'text\']').attr('required',true);
        }
    }else{
        wrap_anak_istri.hide().find('input[type=\'text\']').removeAttr('required');
    }
});

//tambah input anak
function tdAnak(i,data=null){
 return '<tr>'+
    '<td><input type="text" name="Pasien[anak_nama][]" class="form-control input-sm" value="'+(data!=null ? data[i]['nama'] :  '')+'"></td>'+
    '<td><input type="text" name="Pasien[anak_tgl][]" class="form-control input-sm" value="'+(data!=null ? data[i]['tgl_lahir'] :  '')+'"></td>'+
    '<td>'+
        '<select name="Pasien[anak_status][]" class="form-control input-sm">'+
            '<option value="1" '+(data!=null ? (data[i]['status']=='1' ? 'selected="selected"' : '') : '')+'>Anak Kandung</option>'+
            '<option value="2" '+(data!=null ? (data[i]['status']=='2' ? 'selected="selected"' : '') : '')+'>Anak Tiri</option>'+
        '</select>'+
    '</td>'+
    '<td><input type="text" name="Pasien[anak_mr][]" class="form-control input-sm"  value="'+(data!=null ? data[i]['rm'] : '0')+'"></td>'+
    '<td></td></tr>';
}
function setFormAnak(v,data=null){
    v=parseInt(v);
    var tb=$('.tb-anak-detail');
    if(v && v>0){
        var tbody='';
        for(var i=0; i<v; i++){
            tbody+=tdAnak(i,data);
        }
        if(tbody!=''){
            $('.tb-anak-detail tbody').html(tbody);
            $('.wrap-anak-detail').show('slow');
            tb.find("input[type='text']").attr('required',true);
            $(".tb-anak-detail tbody").find("input[name='Pasien[anak_tgl][]']").inputmask({
                regex:'[0-3][0-9]-[0-1][0-9]-[0-9]{4}'
            });
        }
    }else{
        $('.tb-anak-detail tbody').empty();
        $('.wrap-anak-detail').hide();
        tb.find("input[type='text'],select").removeAttr('required');
    }
}
$('#pasien-jml_anak').keyup(function(e){
    var v=$(this).val();
    setFormAnak(v);
});

//kebiasaan pasien
$('.btn-kebiasaan').click(function(e){
    e.preventDefault();
    var btn=$(this);
    var htm=btn.html();
    var selected=$('#pasien-kebiasaan').select2('data');
    var tmp=[];
    if(selected.length>0){
        $.each(selected,function(i,v){
            tmp.push(v.id);
        });
    }
    formModal({url:base_url+controller+'kebiasaan-list',data:{selected:tmp},loading:{btn:btn,html:htm}});
});

//riwayat penyakit pasien
$('.btn-riwayat-penyakit').click(function(e){
    e.preventDefault();
    var btn=$(this);
    var htm=btn.html();
    var selected=$('#pasien-riwayat_penyakit').select2('data');
    var tmp=[];
    if(selected.length>0){
        $.each(selected,function(i,v){
            tmp.push(v.id);
        });
    }
    formModal({url:base_url+controller+'riwayat-penyakit-list',data:{selected:tmp},loading:{btn:btn,html:htm}});
});

//penanggung
function tdPenanggung(data=null){
    var opt_list=penanggung_opt;
    var opt='';
    if(opt_list.length>0){
        var chk=false;
        $.each(opt_list,function(i,v){
            if(data!=null){
                if(v.id==data.debitur){
                    chk=true;
                }
            }
            opt+="<option value='"+v.id+"' "+( data!=null ? ( v.id==data.debitur ? "selected='selected'" : '' ) : '' )+">"+v.nama+"</option>";
        });
        return '<tr>'+
            '<td><select  name=\'Pasien[pen_nama][]\' class=\'form-control input-sm\'>'+opt+'</select></td>'+
            '<td><input type=\'text\' name=\'Pasien[pen_nomor][]\' class=\'form-control input-sm\' '+(data!=null ? ( chk ? "value='"+data.nomor+"'" : '' ) : '')+'></td>'+
            '<td><a href=\'#\' class=\'btn btn-xs btn-danger btn-del-penanggung\'><i class=\'fa fa-trash\'></i></a></td>'+
        '</tr>';
    }
    return false;
}
$('.btn-add-penanggung').click(function(e){
    e.preventDefault();
    var tr=tdPenanggung();
    $('.tb-penanggung').append(tr).find("input[type='text'],select").attr('required',true);
    $('.tb-penanggung tbody tr td').on('click','.btn-del-penanggung',function(e){
        e.preventDefault();
        var tr=$(this);
        tr.parent().parent().remove();
    });
});

//simpan pasien baru
$('#pasien-form').on('beforeSubmit',function(e){
    e.preventDefault();
    var btn=$('.btn-biodata-submit');
    var htm=btn.html();
    setLoadingBtn(btn,'Menyimpan...');
    $.ajax({
        url:base_url+controller+'biodata-save',
        type:'post',
        dataType:'json',
        data:$(this).serialize(),
        success:function(result){
            if(result.status){
                setRm(result.rm);
                $('#registrasi-kunjungan').val(result.kunjungan);
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
//reset form biodata
$('.btn-biodata-reset').click(function(e){
    e.preventDefault();
    resetFormBiodata();
});
// ---END BIODATA ---

//---PENDAFTARAN ----
//set form pendaftaran
function setFormPendaftaran(data){
    if(data.status){
        var form=$('#pendaftaran-form');
        $.each(data.registrasi,function(i,v){
            if(i=='kiriman' || i=='debitur'){
                form.find("select[name='Registrasi["+i+"]']").val(v).change();
            }else if(i=='unit'){
                form.find("select[name='Registrasi["+i+"]']").val(v.kode).change();
                if(v.status){
                    warningMsg('Pasien telah dilakukan pemeriksaan, <b>TIDAK BISA MENGGANTI UNIT POLIKLINIK</b>');
                    form.find("select[name='Registrasi["+i+"]']").attr('disabled',true);
                }else if(!v.status){
                    form.find("select[name='Registrasi["+i+"]']").removeAttr('disabled');
                }
            }else if(i=='kiriman_detail_kode' || i=='debitur_detail_kode'){
                setTimeout(function(){
                    form.find("select[name='Registrasi["+i+"]']").val(v).change();
                },1500);
            }else{
                form.find("input[name='Registrasi["+i+"]']").val(v);
            }
        });
    }
    if(data.msg){
        warningMsg(data.msg);
    }
}

//reset form pendaftaran
function resetFormPendaftaran(reset_rm=true){
    var form=$('#pendaftaran-form');
    form.find('input').not(reset_rm ? '#registrasi-kunjungan,#registrasi-pasien_kode' : '').val('');
    form.find('select').val('').trigger('change');
    form.find('#registrasi-unit').removeAttr('disabled');
    form.find('#registrasi-kiriman_detail_kode,#registrasi-debitur_detail_kode').val('').trigger('change').attr('disabled',true);
}

$('#registrasi-kiriman').change(function(e){
    var v=$(this).val();
    var detail=$('#registrasi-kiriman_detail_kode');
    if(v){
        $.ajax({
            url:base_url+controller+'kiriman-detail-list',
            type:'post',
            data:{id:v},
            success:function(result){
                var data=result.data;
                if(data.length>0){
                    var h='';
                    $.each(data,function(i,v){
                        h+='<option value="'+v.id+'">'+v.text+'</option>';
                    });
                    if(h!=''){
                        detail.removeAttr('disabled').html(h);
                    }
                }else{
                    detail.attr('disabled',true).html('');
                }
            },
            error:function(xhr,status,error){
                errorMsg(error);
                detail.attr('disabled',true).html('');
            }
        });
    }
});

$('#registrasi-debitur').change(function(e){
    var v=$(this).val();
    var detail=$('#registrasi-debitur_detail_kode');
    if(v){
        $('.wrap-bpjskes').hide();
        $.ajax({
            url:base_url+controller+'debitur-detail-list',
            type:'post',
            data:{id:v},
            success:function(result){
                var data=result.data;
                if(data.length>0){
                    var h='';
                    if(data.length>1){
                        h+="<option value=''>- pilih detail cara bayar -</option>";
                    }
                    $.each(data,function(i,v){
                        h+='<option value="'+v.kode+'">'+v.nama+'</option>';
                    });
                    if(h!=''){
                        detail.attr('required',true).removeAttr('disabled').html(h);
                    }
                }else{
                    detail.removeAttr('required').attr('disabled',true).html('');
                }
            },
            error:function(xhr,status,error){
                errorMsg(error);
                detail.removeAttr('required').attr('disabled',true).html('');
            }
        });
    }
});

$('#registrasi-debitur_detail_kode').change(function(e){
    var v=$(this).val();
    var wrap=$('.wrap-bpjskes');
    if(v==bpjs_id){
        wrap.show().find("input[type='text']").attr('required',true);
    }else{
        wrap.hide().find("input[type='text']").removeAttr('required');
    }
});

$('#pendaftaran-form').on('beforeSubmit',function(e){
    e.preventDefault();
    var btn=$('.btn-pendaftaran-submit');
    var htm=btn.html();
    setLoadingBtn(btn,'Menyimpan...');
    $.ajax({
        url:base_url+controller+'pendaftaran-save',
        type:'post',
        dataType:'json',
        data:$(this).serialize(),
        success:function(result){
            if(result.status){
                if(result.cetak){
                    cetakAntrian(result.noreg);
                }
                setNoReg(result.noreg);
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
$('.btn-reg-new').click(function(e){
    resetFormPendaftaran(true);
});
$('.btn-reg-cancel').click(function(e){
    e.preventDefault();
    var btn=$(this);
    var htm=btn.html();
    formModal({url:base_url+controller+'registrasi-batal-form',loading:{btn:btn,html:htm}});
});
function cetakAntrian(noreg){
    var w=window.open(base_url+'/cetak/cetak-antrian?noreg='+noreg, '_blank');
    if(w){
        w.focus();
    }else{
        errorMsg('Cetak SEP diblock oleh browser anda, izinkan popup untuk mencetak SEP');
    }
}
$('.btn-riwayat-bpjs').click(function(e){
    e.preventDefault();
    var btn=$(this);
    var htm=btn.html();
    var rm=getRm();
    if(rm){
        formModal({url:base_url+'/sep/riwayat-form',data:{rm:rm},loading:{btn:btn,html:htm}});
    }else{
        errorMsg('Silahkan cari pasien terlebih dahulu');
    }
});
$('.btn-sep-form').click(function(e){
    e.preventDefault();
    var btn=$(this);
    var htm=btn.html();
    var rm=getRm();
    var noreg=getNoReg();
    var inap=false;
    var sep=$('#registrasi-no_sep').val();
    formModal({url:base_url+'/sep/form',data:{inap:inap,rm:rm,noreg:noreg,sep:sep},loading:{btn:btn,html:htm}});
});

//shortcut
$(document).ready(function() {
    // $("*").on('keydown', null, 'f3', function () {
    //     resetFormBiodata();
    //     resetFormPendaftaran();
    //     return false;
    // });
});

//edit penanggungan
$('.btn-edit-penanggungan').click(function(e){
    e.preventDefault();
    var btn=$(this);
    var htm=btn.html();
    var rm=getRm();
    var noreg=getNoReg();
    formModal({url:base_url+'/penanggung/form',data:{rm:rm,noreg:noreg},loading:{btn:btn,html:htm}});
});

//cetak 
$('.btn-list-print .btn-group').on('click','a',function(e){
    e.preventDefault();
    var query=[];
    var rm=getRm();
    if(rm){
        var b=$(this);
        var t=b.attr('data-type');
        var href=b.attr('data-href');
        query.push('rm='+rm);
        if(t==5){
            var j=b.attr('data-jenis');
            if(j){
                query.push('j='+j);
            }
        }
        if(href){
            window.open(href+'?'+query.join('&'));
        }
    }else{
        errorMsg('Silahkan cari pasien terlebih dahulu');
    }
});