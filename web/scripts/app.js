$(function(){
    $('[data-toggle="tooltip"]').tooltip();
    $('.form-control').addClass('input-sm');
});

paceOptions = {
    elements: false,
    ajax:true,
    restartOnPushState: false,
    restartOnRequestAfter: true,
    // minTime:50000,
    // ghostTime:120000,
    // maxProgressPerFrame:50
}
toastr.options.progressBar = true;
toastr.options.closeButton = true;
toastr.options.timeOut = 5000;
toastr.options.extendedTimeOut =3000;
$(document).ajaxStart(function() { Pace.restart(); });
$(document).ajaxStop(function() { Pace.stop(); });
function setLoadingBtn(btn,txt='')
{
    btn.html('<i class="fa fa-refresh fa-spin fa-fw"></i> '+txt).attr('disabled',true);
}
function resetLoadingBtn(btn,htm)
{
    btn.html(htm).removeAttr('disabled');
}
function errorMsg(txt){
    if(typeof txt =='object'){
        $.each(txt,function(i,v){
            toastr.error(v).css({"width": "400px","max-width": "400px" });
        });
    }else{
        toastr.error(txt).css({"width": "400px","max-width": "400px" });
    }
}
function warningMsg(txt){
    
    if(typeof txt =='object'){
        $.each(txt,function(i,v){
            toastr.warning(v).css({"width": "400px","max-width": "400px" });
        });
    }else{
        toastr.warning(txt).css({"width": "400px","max-width": "400px" });
    }
}
function successMsg(txt){
    toastr.success(txt).css({"width": "400px","max-width": "400px" });
}
function formModal(obj){
    if(obj.loading){
        setLoadingBtn(obj.loading.btn,obj.loading.txt?obj.loading.txt:'');
    }
    $.ajax({    
        url:obj.url,
        type:'post',
        dataType:'html',
        data:obj.data?obj.data:'',
        success:function(result){
            $(obj.modal ? (obj.modal.id ? obj.modal.id : '#mymodal') : '#mymodal').html(result).modal(obj.modal ? (obj.modal.config ? obj.modal.config : 'show') : 'show');
            if(obj.loading){
                resetLoadingBtn(obj.loading.btn,obj.loading.html);
            }
        },
        error:function(xhr,status,error){
            errorMsg(error);
            if(obj.loading){
                resetLoadingBtn(obj.loading.btn,obj.loading.html);
            }
        }
    });
}
function getUmur(dateString) {

    var now = new Date();
    var today = new Date(now.getYear(),now.getMonth(),now.getDate());

    var yearNow = now.getYear();
    var monthNow = now.getMonth();
    var dateNow = now.getDate();

    var date = dateString.split("-");
    var dob = new Date(date[2], date[1] - 1, date[0]);

    var yearDob = dob.getYear();
    var monthDob = dob.getMonth();
    var dateDob = dob.getDate();
    var age = {};
    var ageString = "";
    var yearString = "";
    var monthString = "";
    var dayString = "";


    yearAge = yearNow - yearDob;

    if (monthNow >= monthDob)
        var monthAge = monthNow - monthDob;
    else {
        yearAge--;
        var monthAge = 12 + monthNow -monthDob;
    }

    if (dateNow >= dateDob)
        var dateAge = dateNow - dateDob;
    else {
        monthAge--;
        var dateAge = 31 + dateNow - dateDob;

        if (monthAge < 0) {
            monthAge = 11;
            yearAge--;
        }
    }

    age = {
        years: yearAge,
        months: monthAge,
        days: dateAge
    };

    if ( age.years > 1 ) yearString = " Tahun";
    else yearString = " Tahun";
    if ( age.months> 1 ) monthString = " Bulan";
    else monthString = " Bulan";
    if ( age.days > 1 ) dayString = " Hari";
    else dayString = " Hari";


    if ( (age.years > 0) && (age.months > 0) && (age.days > 0) )
        ageString = age.years + yearString + ", " + age.months + monthString + ", " + age.days + dayString;
    else if ( (age.years == 0) && (age.months == 0) && (age.days > 0) )
        ageString = age.days + dayString;
    else if ( (age.years > 0) && (age.months == 0) && (age.days == 0) )
        ageString = age.years + yearString;
    else if ( (age.years > 0) && (age.months > 0) && (age.days == 0) )
        ageString = age.years + yearString + ", " + age.months + monthString;
    else if ( (age.years == 0) && (age.months > 0) && (age.days > 0) )
        ageString = age.months + monthString + ", " + age.days + dayString;
    else if ( (age.years > 0) && (age.months == 0) && (age.days > 0) )
        ageString = age.years + yearString + ", " + age.days + dayString;
    else if ( (age.years == 0) && (age.months > 0) && (age.days == 0) )
        ageString = age.months + monthString;
    else ageString = "0 Hari";

    return ageString;
}