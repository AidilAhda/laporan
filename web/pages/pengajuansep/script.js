var controller='/sep-pengajuan/';
$('.btn-create').click(function(e){
    e.preventDefault();
    var btn=$(this);
    var htm=btn.html();
    formModal({url:base_url+controller+'form',data:{user:'rm'},loading:{btn:btn,html:htm,txt:'Loading...'}});
});
function editBtn(){
    $('#grid-pengajuan-sep .table tbody tr td').on('click','.btn-edit',function(e){
        e.preventDefault();
        var id=$(this).attr('data-id');
        var btn=$(this);
        var htm=btn.html();
        formModal({url:base_url+controller+'form',data:{id:id,user:'coder'},loading:{btn:btn,html:htm}});
    });
}
function detailBtn(){
    $('#grid-pengajuan-sep .table tbody tr td').on('click','.btn-detail',function(e){
        e.preventDefault();
        var id=$(this).attr('data-id');
        var btn=$(this);
        var htm=btn.html();
        formModal({url:base_url+controller+'view',data:{id:id},loading:{btn:btn,html:htm}});
    });
}
detailBtn();
editBtn();
$(document).on('ready pjax:success',function(){
    editBtn();
    detailBtn();
});