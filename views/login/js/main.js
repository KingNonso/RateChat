
function Login(){
    var email = _("email").value;
    var password = _("password").value;
    if(_("login_me").checked){
        var login_me = _("login_me").value;
    }else{
        var login_me = false;
    }
    if(email == "" || password ==""){
    _("status").innerHTML = '<h2 class="btn btn-danger"> Please Fill out the form data </h3>';
    } else {
        _("submit").style.display = "none";
        //_("status").style.display = "block";
    _("status").innerHTML = '<h2 class="btn btn-default">Please wait ...<h3>';
    var ajax = ajaxObj("POST", "login/run");
    ajax.onreadystatechange = function() {
        if(ajax.readyState == 1){
            _("status").innerHTML = '<h2 class="btn btn-info">Processing ...<h3>';
        }
        if(ajax.readyState == 2){
            _("status").innerHTML = '<h2 class="btn btn-warning "> Authorizing...<h3>';
        }
        if(ajax.readyState == 3){
            _("status").innerHTML = '<h2 class="btn btn-primary btn-lg "> Authenticating...<h3>';
        }

        if(ajax.readyState == 4 && ajax.status == 200){
        if(ajax.responseText == "success"){
            _("status").innerHTML = '<h2 class="btn btn-success "> Login in ...<h3>';
            //get the protocol
            var protocol = window.location.protocol;
            //get the hostname
            var host = window.location.hostname;
            //get the pathname
            var path = window.location.pathname;
            //get where to redirect to
            var page = 'wall';
            //now go there protocol+host+path+
            window.location.assign(page);
        } if(ajax.responseText == "no_match"){
                _("status").innerHTML = '<h2 class="btn btn-warning "> Username/password combination is incorrect.<br />Please make sure your caps lock key is off and try again..<h3>';
                _("submit").style.display = "block";

            }
}else {
            _("status").innerHTML = '<h3 class="btn btn-warning ">There seems to be a problem submitting ...</h3>';
            _("submit").style.display = "block";
        }
}
ajax.send("login_email="+email+"&login_pwd="+password+"&login_me="+login_me);

}
}
