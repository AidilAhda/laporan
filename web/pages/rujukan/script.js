var controller='/rujukan/';
$('.btn-create').click(function(e){
    e.preventDefault();
    var btn=$(this);
    var htm=btn.html();
    formModal({url:base_url+controller+'form',loading:{btn:btn,html:htm,txt:'Loading...'}});
});
function editBtn(){
    $('#grid-rujukan .table tbody tr td').on('click','.btn-edit',function(e){
        e.preventDefault();
        var id=$(this).attr('data-id');
        var btn=$(this);
        var htm=btn.html();
        formModal({url:base_url+controller+'form',data:{id:id},loading:{btn:btn,html:htm}});
    });
}
function detailBtn(){
    $('#grid-rujukan .table tbody tr td').on('click','.btn-detail',function(e){
        e.preventDefault();
        var id=$(this).attr('data-id');
        var btn=$(this);
        var htm=btn.html();
        formModal({url:base_url+controller+'view',data:{id:id},loading:{btn:btn,html:htm}});
    });
}
function deleteBtn(){
    $('#grid-rujukan .table tbody tr td').on('click','.btn-delete',function(e){
        e.preventDefault();
        var btn=$(this);
        var htm=btn.html();
        var id=$(this).attr('data-id');
        if(confirm('Yakin hapus rujukan ?')){
            setLoadingBtn(btn);
            $.ajax({
                url:base_url+controller+'delete',
                type:'post',
                dataType:'json',
                data:{id:id},
                success:function(result){
                    if(result.status){
                        successMsg(result.msg);
                        $.pjax.reload({container: '#pjax-rujukan', async: false});
                    }else{
                        errorMsg(result.msg);
                    }
                    resetLoadingBtn(btn,htm);
                },
                error:function(xhr,status,error){
                    toastr['error'](error);
                    resetLoadingBtn(btn,htm);
                }
            });
        }
        return false;
    });
}
function setFormSepRujukan(data){
    if(data){
        var fr=$('.form-biodata');
        $.each(data,function(i,v){
            if(i=='no_rm'){
                $('#rujukan-pasien_kode').val(v);
            }else if(i=='nama'){
                $('#rujukan-nama').val(v);
            }else if(i=='no_kartu'){
                $('#rujukan-no_kartu').val(v);
            }
            if(i=='jkel'){
                $('#rujukan-jkel').val(v).change();
            }else{
                fr.find('input[name=\''+i+'\']').val(v);
            }
            
        });
    }else{
        errorMsg('Data SEP tidak ditemukan');
    }
}
function cetakRujukan(sep,rujukan){
    if(sep && rujukan){
        var w=window.open(base_url+controller+'cetak?sep='+sep+'&rujukan='+rujukan, '_blank');
        if(w){
            w.focus();
        }else{
            errorMsg('Cetak Surat Rujukan diblock oleh browser anda, izinkan popup untuk mencetak Surat Rujukan');
        }
    }else{
        errorMsg('Silahkan simpan rujukan terlebih dahulu');
    }
}
detailBtn();
editBtn();
deleteBtn();
$(document).on('ready pjax:success',function(){
    editBtn();
    deleteBtn();
    detailBtn();
});