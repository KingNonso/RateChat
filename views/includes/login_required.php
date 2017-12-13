<!-- Modal -->
<div id="loginRequiredModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="glyphicon glyphicon-warning-sign"></i> Alert!</h4>
                    <h4 class="modal-title">Login is Required to proceed:</h4>
                </div>

                <h4 class="modal-title">Login Here:</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo(URL.'login/login'); ?>" method="post" onsubmit="return false;">
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
                                <input type="email" id="modal_email" name="modal_email" class="form-control" placeholder="Enter Email address" required>
                            </div>

                        </div>
                        <div class="col-sm-12 form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i> </span>
                                <input type="password" id="modal_password"  name="password"  class="form-control" placeholder="Enter Password: " required>
                            </div>

                        </div>
                        <div class="col-sm-12 form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Keep me logged in (this is my device) :
                                <input type="checkbox" value="remember" id="login_me" name="login_me">
                                </span>

                            </div>

                            <p id="modal_status"></p>



                        </div>
                        <div class="col-sm-12 form-group" id="modal_submit">
                            <button type="submit" class="btn btn-primary btn-block btn-flat" onclick="Login()">Log In</button>
                        </div>

                        <div class="col-sm-12 form-group">
                            <a href="<?php echo(URL); ?>login/recovery">I forgot my password</a><br>
                            <a href="<?php echo(URL); ?>reg/start" class="text-center">Register a new membership</a>
                        </div>
                    </div>


                </form>

            </div>
            <div class="modal-footer">
                <a href="<?php echo (backToSender()); ?>" class="btn btn-default">Go Back</a>
            </div>
        </div>

    </div>
</div>
<?php
    $url = isset($_GET['url']) ? $_GET['url'] : null;
    $url = rtrim($url, '/');
    $url = filter_var($url, FILTER_SANITIZE_URL);
    $url = explode('/', $url);
    $url_count = count($url);

?>

<!-- Trigger the modal with a button -->
<script type="text/javascript">
    $("#loginRequiredModal").modal({backdrop: "static"});
    var url = <?php echo($url_count); ?>

    function Login(){
        var login_me;
        var email = _("modal_email").value;
        var password = _("modal_password").value;
        if(_("login_me").checked){
             login_me = _("login_me").value;
        }else{
             login_me = false;
        }
        if(email == "" || password ==""){
            _("modal_status").innerHTML = '<h2 class="btn btn-danger"> Please Fill out the form data </h3>';
        } else {
            var text = "";
            for (i = 1; i < url; i++) {
                text += "../";
            }

            _("modal_submit").style.display = "none";
            //_("modal_status").style.display = "block";
            _("modal_status").innerHTML = '<h2 class="btn btn-default">Please wait ...<h3>';
            var ajax = ajaxObj("POST", text +"login/run");
            ajax.onreadystatechange = function() {
                if(ajax.readyState == 1){
                    _("modal_status").innerHTML = '<h2 class="btn btn-info">Processing ...<h3>';
                }
                if(ajax.readyState == 2){
                    _("modal_status").innerHTML = '<h2 class="btn btn-warning "> Authorizing...<h3>';
                }
                if(ajax.readyState == 3){
                    _("modal_status").innerHTML = '<h2 class="btn btn-primary btn-lg "> Authenticating...<h3>';
                }

                if(ajax.readyState == 4 && ajax.status == 200){
                    if((ajax.responseText.replace(/^-+/, '').replace(/-+$/, '')) === "success"){
                        _("modal_status").innerHTML = '<h2 class="btn btn-success "> Login in ...<h3>';
                        $("#loginRequiredModal").modal('hide');                    } if(ajax.responseText == "no_match"){
                        _("modal_status").innerHTML = '<h2 class="btn btn-warning "> Username/password combination is incorrect.<br />Please make sure your caps lock key is off and try again..<h3>';
                        _("modal_submit").style.display = "block";

                    }
                }else {
                    _("modal_status").innerHTML = '<h3 class="btn btn-warning ">There seems to be a problem submitting ...</h3>';
                    _("modal_submit").style.display = "block";
                }
            }
            ajax.send("login_email="+email+"&login_pwd="+password+"&login_me="+login_me);

        }
    }

</script>
