function subscriptions(type, style){
    var author = _("blog_author").value;
    var category = _("blog_category").value;
    var comment_email = _("comment_email").value;
    var url = '../../../blog/subscriptions/'+type+'/'+ style;
    var queryString = 'author='+author+'&category='+ category+'&comment_email='+ comment_email;


    jQuery.ajax({
        url: url,
        data:queryString,
        type: "POST",
        success:function(data){
            var author_id = $("#author_subscription");
            var category_id = $("#category_subscription");
            switch (type){
                case 'subscribe':
                    switch (style) {
                        case 'category':
                            category_id.html('<p class="text-success"> <span class="glyphicon glyphicon-ok-circle"></span> Successfully Subscribed to Posts from this category<br> <small>Alerts will be sent to your mail</small></p>');

                            break;
                        case 'author':
                            author_id.html('<p class="text-success"> <span class="glyphicon glyphicon-ok-circle"></span> Successfully Subscribed to Posts from this Author<br> <small>Alerts will be sent to your mail</small></p>');
                            break;
                    }
                    break;
                case 'unsubscribe':
                    switch (style) {
                        case 'category':
                            category_id.html('<p class="text-success"> <span class="glyphicon glyphicon-ok-circle"></span> Successfully Opted-Out to Posts from this category <br> <small>Alerts will no longer be sent to your mail</small></p>');
                            break;
                        case 'author':
                            author_id.html('<p class="text-success"> <span class="glyphicon glyphicon-ok-circle"></span> Successfully Opted-Out to Posts from this Author<br> <small>Alerts will no longer be sent to your mail</small></p>');
                            break;
                    }
                    break;


            }

        },
        error:function (){}
    });


}

function commentFromInside(){
    var name = _("comment_name").value;
    var user_id = _("user_id").value;
    var email = _("comment_email").value;
    var message = _("comment").value;
    var blog_id = _("comment_blog").value;


    if(message == "" ){
        _("status").innerHTML = '<h3> Please Fill out the comment field </h3>';
    } else {
        _("submit").style.display = "none";
        _("status").innerHTML = '<h3>Please wait ...<h3>';
        //you can only comment on a specific post in a yy/mm/dd
        var ajax = ajaxObj("POST", "../../../blog/comment");
        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                if(ajax.responseText === "success"){
                    _("status").innerHTML = '<h3>Successfully submitted ...</h3>';
                    $('#comment').val('');
                    $("span#comment_count").text(function (i, origText) {
                        if (isNaN(parseInt(origText))) {
                            return  1;// + " Comment";
                        } else {
                            var sum = parseInt(origText) + 1;
                            return sum; // + " Comments";
                        }

                    });

                    _("new_addition").innerHTML += '<div class="col-sm-2 text-center"><img src="'+put_image()+'" class="img-circle" height="65" width="65" alt="'+name+'"/></div><div class="col-sm-10"><h4><a href="#" class="author">'+name+' </a><small> Today @ '+current_time()+'</small></h4><p>'+message+'</p><br></div>';

                } else {
                    _("status").innerHTML = '<h3>There seems to be a problem submitting ...</h3>';
                    _("submit").style.display = "block";
                }
            }
        }
        ajax.send("name="+name+"&email="+email+"&message="+message+"&blog_id="+blog_id+"&user_id="+user_id);

    }
}

function commentFromOutside(){
    var recaptcha = _("g-recaptcha-response").value;
    //var recaptcha = 12345;
    var name = _("comment_name").value;
    var user_id = _("user_id").value;
    var email = _("comment_email").value;
    var message = _("comment").value;
    var blog_id = _("comment_blog").value;

    if(message == "" ){
        _("status").innerHTML = '<h3> Please Fill out the comment field </h3>';
    } else {
        _("submit").style.display = "none";
        _("status").innerHTML = '<h3>Please wait ...<h3>';
        //you can only comment on a specific post in a yy/mm/dd
        var ajax = ajaxObj("POST", "../../../blog/comment/outside");
        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                if(ajax.responseText === "success"){
                    _("status").innerHTML = '<h3>Successfully submitted ...</h3>';
                    $('#comment').val('');
                    $("span#comment_count").text(function (i, origText) {
                        if (isNaN(parseInt(origText))) {
                            return  1;// + " Comment";
                        } else {
                            var sum = parseInt(origText) + 1;
                            return sum; // + " Comments";
                        }

                    });

                    _("new_addition").innerHTML += '<div class="col-sm-2 text-center"><img src="'+put_image()+'" class="img-circle" height="65" width="65" alt="'+name+'"/></div><div class="col-sm-10"><h4><a href="#" class="author">'+name+' </a><small> Today @ '+current_time()+'</small></h4><p>'+message+'</p><br></div>';

                } else {
                    _("status").innerHTML = '<h3>There seems to be a problem submitting ...</h3>';
                    _("submit").style.display = "block";
                }
            }
        }
        ajax.send("name="+name+"&email="+email+"&message="+message+"&blog_id="+blog_id+"&user_id="+user_id+"&recaptcha="+recaptcha);

    }
}


function emptyElement(x){
    _(x).innerHTML = "";
}

function current_time(){
    var d = new Date();
    return d.toLocaleTimeString();
}

function put_image(){
    var x = document.images.namedItem("image_path").src;
//document.getElementById("demo").innerHTML = x;
    return(x);
}

function showEditBox(id) {
    var particularPoint = $("#message_"+id+ " .message-content");
    var replyID = $('#reply'+id);
    replyID.slideUp();
    $('#span_holder_'+id).hide();
    var currentMessage = particularPoint.text();

    var editMarkUp = '<label for="moderate">Moderate:</label><textarea rows="3" class="form-control" id="txtmessage'+id+'">'+currentMessage+'</textarea>';

    var sender = '<a href="javascript:void(0);" class="btn reply-btn btn-sm" onClick="blogBoxAction(\'edit\','+id+')">Save </a> <a href="javascript:void(0);" class="btn btn-default btn-xs"  onClick="cancelEdit('+id+')">Cancel</a>';
    replyID.slideDown();
    $('#moderate_'+id).html(editMarkUp);
    $('#sender_'+id).html(sender);
}

function showReplyBox(id) {
    var replyID = $('#reply'+id);

    var editMarkUp = '<label for="moderate">Comment:</label><textarea rows="3" class="form-control" placeholder="Reply to this comment..."   id="txtmessage'+id+'"></textarea>';

    var sender = '<a href="javascript:void(0);" class="btn reply-btn btn-sm" onClick="blogBoxAction(\'add\','+id+')">Send </a> <a href="javascript:void(0);" class="btn btn-default btn-xs"  onClick="toggle(\'reply'+id+'\')">Cancel</a>';
    replyID.slideDown();
    $('#moderate_'+id).html(editMarkUp);
    $('#sender_'+id).html(sender);
}

function cancelEdit(id) {
    showReplyBox(id);
    $('#span_holder_'+id).show();

    var replyID = $('#reply'+id);
    replyID.slideUp();

}


function blogBoxAction(action,id) {

    var queryString;
    var url = '../../../blog/comment_action/'+ action;
    var msg = $("#txtmessage" + id).val(); //for comments
    var post = $("#blog_id").val();
    var name = $("#comment_name").val();
    switch(action) {
        case "add":
            queryString = 'action='+action+'&comment_id='+ id +'&txtmessage='+ msg;

            break;
        case "edit":
            queryString = 'action='+action+'&comment_id='+ id + '&txtmessage='+ msg;
            break;
        case "delete":
            queryString = 'action='+action+'&comment_id='+ id;
            break;
    }
    jQuery.ajax({
        url: url,
        data:queryString,
        type: "POST",
        success:function(data){
            var replyID = $('#reply'+id);
            switch(action) {
                       case "add":
                    replyID.slideUp();

                    $("#appendix"+ id).append('<div class="col-sm-2 text-center"><img src="'+put_image()+'" class="img-rounded" height="45" width="45" alt="'+name+'"/></div><div class="col-sm-10"><h4><a href="#" class="author">'+name+' </a><small> Today @ '+current_time()+'</small></h4><p>'+msg+'</p><br></div>');
                    $("span#appendix-count"+ id).text(function (i, origText) {
                        if (isNaN(parseInt(origText))) {
                            return  1;// + " Comment";
                        } else {
                            var sum = parseInt(origText) + 1;
                            return sum; // + " Comments";
                        }

                    });


                    break;
                case "edit":

                    $("#message_" + id + " .message-content").html(msg);
                    showReplyBox(id);
                    $('#span_holder_'+id).show();
                    replyID.slideUp();
                    break;

                case "delete":
                    $('#message_'+id).fadeOut();
                    $("span#comment_count").text(function (i, origText) {
                        if (isNaN(parseInt(origText))) {
                            return  0;// + " Comment";
                        } else {
                            var sum = parseInt(origText) - 1;
                            return sum; // + " Comments";
                        }

                    });

                    break;
            }
            $("#txtmessage" + id).val('');
        },
        error:function (){}
    });
}

