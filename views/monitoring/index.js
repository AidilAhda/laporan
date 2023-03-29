var monitoring_controller='/monitoring';
function getTanggalMonitoringMulai(){
    return $("input[name='TanggalMonitoring']").val();
}
function getTanggalMonitoringMSelesai(){
    return $("input[name='TanggalMonitoring_selesai']").val();
}
function getDebiturMonitoring(){
    return $('#DebiturMonitoring').val();
}
function getLayananMonitoring(){
    return $('#LayananMonitoring').val();
}
function getUnitMonitoring(){
    return $('#unitMonitoring').val();
}

//tampil data monitoring
$('.btn-show-data').click(function(e){
    e.preventDefault();
    var btn=$(this);
    var htm=btn.html();
    var tanggal_mulai=getTanggalMonitoringMulai();
    var tanggal_selesai = getTanggalMonitoringMSelesai();
    var debitur=getDebiturMonitoring();
    var layanan=getLayananMonitoring();
    var unit = getUnitMonitoring();
    if(typeof tanggal_mulai != 'undefined' && tanggal_mulai != ''){
        window.open(base_url+monitoring_controller+"/index?tgl_mulai="+tanggal_mulai+"&tgl_selesai="+tanggal_selesai+"&Debitur="+debitur+"&Layanan="+layanan+"&unit="+unit, '_self');
    } else {
        errorMsg('Silahkan pilih tanggal terlebih dahulu');
    }
});



//list registrasi
$('.btn-detail-pembayaran').click(function(e){
    e.preventDefault();
    var btn=$(this);
    var htm=btn.html();
    var id=this.id;
    var myArr = id.split("_");
    var kodePasien = myArr[0];
    var kodeRegistrasi = myArr[1];
    var namaPasien = myArr[2];
    var tglDaftar = myArr[3];


    if (id) {


        formModal({url:base_url+'/monitoring/input-data-klaim',data:{rm:kodePasien, noreg:kodeRegistrasi, tgldftr:tglDaftar, nmpasien:namaPasien},loading:{btn:btn,html:htm}});        
    }

});

 function filter() {

      var str = $('#CariNamaMonitoring').val();
      var filter, table, tr, td, i, txtValue;
      filter = str.toUpperCase();
      table = document.getElementById("TabelDaftar");
      tr = table.getElementsByTagName("tr");
      // Loop through all table rows, and hide those who dont match the search query
      for (i = 1; i < tr.length; i++) {
      // No Pasien
        td3 = tr[i].getElementsByTagName("td")[3]; 
      // Nama
        td4 = tr[i].getElementsByTagName("td")[4];
        if (td3 || td4) {
          txtValue = tr[i].textContent || tr[i].innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
  }