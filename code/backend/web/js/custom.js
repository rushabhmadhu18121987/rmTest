String.prototype.replaceAll = function (search, replacement) {
    var target = this;
    return target.split(search).join(replacement);
};

/*
 (function () {
 var sz = document.forms['dynamic-form'].elements['size'];
 for (var i = 0, len = sz.length; i < len; i++) {
 sz[i].onclick = function () {
 this.form.elements.total.value = this.value;
 };
 }
 }());
 */


//function getStatus(id, itemClass) {
//    var ids = $('#' + id).val();
//    if (ids == 2) {
//        $('#' + itemClass).length();
//    }
//    /*  window.alert($('#' + itemClass).length());
//     window.alert(ids); */
//}
//
//
//function availablenight(id) {
//    var available = $('#' + id).val();
//    if (available == '0') {
//        $(".fRatePerHourNight").attr("readonly", true);
//        $(".fRatePerHourNight").val('0');
//        $(".Hour-Night").hide();
//    } else if (available == '1') {
//        $(".fRatePerHourNight").val('0');
//        $(".fRatePerHourNight").attr("readonly", true);
//        $(".Hour-Night").show();
//    }
//
//}
//function isNumber(evt) {
//    evt = (evt) ? evt : window.event;
//    var charCode = (evt.which) ? evt.which : evt.keyCode;
//    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
//        return false;
//    }
//    return true;
//    /*  onkeypress="return isNumber(event)" */
//}
/*
 function setdivdata() {
 var p1 = $('#parkinglots-1-itotallots').val();
 var p2 = $('#parkinglots-2-itotallots').val();
 var p3 = $('#parkinglots-3-itotallots').val(); 
 
 if (p1 == '0') { 
 $("#arkinglots-1-frateperhournight").attr("readonly", true);
 $("#arkinglots-1-frateperhournight").val('0');
 } else {
 $("#arkinglots-1-frateperhournight").attr("readonly", false);
 $("#arkinglots-1-frateperhournight").val('');
 }
 if (p2 == '0') { 
 $("#arkinglots-2-frateperhournight").attr("readonly", true);
 $("#arkinglots-2-frateperhournight").val('0');
 } else {
 $("#arkinglots-2-frateperhournight").attr("readonly", false);
 $("#arkinglots-2-frateperhournight").val('');
 }
 
 if (p3 == '0') { 
 $("#arkinglots-3-frateperhournight").attr("readonly", true);
 $("#arkinglots-3-frateperhournight").val('0');
 } else {
 $("#arkinglots-3-frateperhournight").attr("readonly", false);
 $("#arkinglots-3-frateperhournight").val('');
 } 
 }setInterval(setdivdata, 1000);
 */
$(document).ready(function () {

    var timezone_offset_minutes = new Date().getTimezoneOffset();
    timezone_offset_minutes = timezone_offset_minutes == 0 ? 0 : -timezone_offset_minutes;
    var d = new Date();
    d.setTime(d.getTime() + (10 * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = "timezone_offset_minutes=" + (new Date().getTimezoneOffset()) + ";" + expires + ";path=/";

//
//    $("[id^='parkinglots-']").keyup(function () {
//        var Table = $(this).attr('id').split('-')[0];
//        var Offset = $(this).attr('id').split('-')[1];
//        var column = $(this).attr('id').split('-')[2];
//        var rowid = Table + '-' + Offset + '-' + column;
//        var tOffset = Table + '-' + Offset + '-';
//        var totallots = $('#' + rowid).val();
//        if (column == 'itotallots') {
//            if (totallots == 0 || totallots == "") {
//                $("#" + tOffset + 'vprefix').attr("readonly", true);
//                $("#" + tOffset + 'vprefix').val('0');
//                $("#" + tOffset + 'vsuffix').attr("readonly", true);
//                $("#" + tOffset + 'vsuffix').val('0');
//                $("#" + tOffset + 'vparkinglotno').attr("readonly", true);
//                $("#" + tOffset + 'vparkinglotno').val('0');
//                $("#" + tOffset + 'frateperhournight').attr("readonly", true);
//                $("#" + tOffset + 'frateperhournight').val('0');
//                $("#" + tOffset + 'frateperhour').attr("readonly", true);
//                $("#" + tOffset + 'frateperhour').val('0');
//                $("#" + tOffset + 'frateperday').attr("readonly", true);
//                $("#" + tOffset + 'frateperday').val('0');
//                $("#" + tOffset + 'fratepermonth').attr("readonly", true);
//                $("#" + tOffset + 'fratepermonth').val('0');
//            } else {
//                $("#" + tOffset + 'vprefix').attr("readonly", false);
//                $("#" + tOffset + 'vprefix').val('');
//                $("#" + tOffset + 'vsuffix').attr("readonly", false);
//                $("#" + tOffset + 'vsuffix').val('');
//                $("#" + tOffset + 'vparkinglotno').attr("readonly", false);
//                $("#" + tOffset + 'vparkinglotno').val('');
//                $("#" + tOffset + 'frateperhournight').attr("readonly", false);
//                $("#" + tOffset + 'frateperhournight').val('');
//                $("#" + tOffset + 'frateperhour').attr("readonly", false);
//                $("#" + tOffset + 'frateperhour').val('');
//                $("#" + tOffset + 'frateperday').attr("readonly", false);
//                $("#" + tOffset + 'frateperday').val('');
//                $("#" + tOffset + 'fratepermonth').attr("readonly", false);
//                $("#" + tOffset + 'fratepermonth').val('');
//            }
//        }
//    });



//    if ($(".btn-success").length > 0) {
//        $('.btn-success').on('click', function () {
//            /* $(".desitnationselect").select2("destroy");*/
//            //  $('select').select2('destroy');
//
//            var $item = $(this).closest('#clonedestination').clone(); /*parkinglots  */
//            $item.find('.btn').removeClass('btn-success').addClass('btn-danger');
//            $item.find('.btn').html('<span class="glyphicon glyphicon-remove"></span> Remove');
//            $item.find('.btn').attr('onClick', '$(this).closest("#clonedestination").remove();');
//            /* Start Set NUll Value */
//            $item.find("#parkingspotmaster-vparkinglotno").val(null);
//            $item.find("#parkingspotmaster-vparkinglotpin").val(null);
//            $item.find("#parkingspotmaster-frateperhour").val(null);
//            $item.find("#parkingspotmaster-frateperday").val(null);
//            $item.find("#parkingspotmaster-fratepermonth").val(null);
//            /* End Set NUll Value */
//            $item.appendTo('.basket');/* Copy Full Div */
//            /*  $(".desitnationselect").select2();*/
//            /* $('.basket').children('select').select2();*/
//        });
//    }

    /**/
    /**/



});

