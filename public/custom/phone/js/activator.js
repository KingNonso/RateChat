$(document).ready(function(){
    var url = $('#url_path').val();
    //var modal = $('#insert-modal');

    $("#telephone").intlTelInput({
        // allowDropdown: false,
        // autoHideDialCode: false,
        // autoPlaceholder: false,
        dropdownContainer: "body",
        // excludeCountries: ["us"],
        // geoIpLookup: function(callback) {
        //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
        //     var countryCode = (resp && resp.country) ? resp.country : "";
        //     callback(countryCode);
        //   });
        // },
        initialCountry: "ng",
        // nationalMode: false,
        numberType: "MOBILE",
        // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
        preferredCountries: ['ng','us','gb','gh'],
        // separateDialCode: true,
        utilsScript: url+'public/custom/phone/js/utils.js'
    });

});

function intlNumber(){
    // Get the current number in the given format
    var intlNumber = $("#telephone").intlTelInput("getNumber");

    //var str = intlNumber;
    //var re = /^\+234\d+$/; //check if it is a nigerian no
    var res = intlNumber.replace("+", "");
    $("#phone_number").val(res);
    //checkNumber(res);


}

function checkNumber(phone){
    _("call_center_status").innerHTML = 'Checking Phone Number..?';
    var ajax = ajaxObj("POST", "login/check_details/phone_no");
    ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
            //var str = ajax.responseText;
            //str = str.replace(/\s+/g,'');
            jQuery.trim(ajax.responseText);
            if(jQuery.trim(ajax.responseText) === "detail_ok"){
                _("call_center_status").style.color = "blue";
                _("call_center_status").innerHTML = 'Phone Number OK';
                _("call_center").style.backgroundColor = "";
                submit.style.display = 'block';
            } else {
                submit.style.display = 'none';
                _("call_center_status").innerHTML = 'The Phone number already exists';
                _("call_center").style.backgroundColor = "red";
                _("call_center_status").style.color = "red";
            }
        }
    }
    ajax.send("phone_no="+phone);

}
