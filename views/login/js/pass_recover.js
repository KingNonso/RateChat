function submitEmail(){
    var email = _("email_recover").value;
    var recaptcha = _("g-recaptcha-response").value;

    if(email == "" || recaptcha == ""){
        _("status").innerHTML = '<h3> Please Fill out the form data </h3>';
    } else {
        _("submit").style.display = "none";
        _("status").innerHTML = '<h3>Please wait ...<h3>';
        var ajax = ajaxObj("POST", "../login/recaptcha");
        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                if(ajax.responseText == "success"){
                    _("contact_form").innerHTML = '<div class="row"><div class="col-sm-12"><h1>The reset link has been sent to the registered email...</h1><p>Please login to your email client to access it. Thanks.</p></div></div>';

                }
                if(ajax.responseText == "not_found"){
                    _("status").innerHTML = '<h3>The email does not match with anything or was not found ...</h3>';
                    _("submit").style.display = "block";

                }
                else {
                    _("status").innerHTML = '<h3>There seems to be a problem resetting ...</h3>';
                    _("submit").style.display = "block";
                }
            }
        }
        ajax.send("email="+email+"&recaptcha="+recaptcha);

    }
}

