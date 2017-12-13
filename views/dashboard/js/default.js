// Select all elements with data-toggle="popover" in the document
$('[data-toggle="popover"]').popover({html: true, placement: "top"});


$('.liveTime').liveTimeAgo();

$('.box-comments').slideUp();

//slide out the full post///
$(".posted_hidden").hide();
function showFullStory(id){
    $("div#part_post_"+id).hide();
    $("div#full_post_"+id).slideDown();
}

function toggle(id){
    $("div#"+id).slideToggle();
}

var filename = document.getElementById("filename");
filename.addEventListener("change", changePost, false);

function changePost(){
    document.getElementById("post").innerHTML = '<button type="submit" class="btn btn-default btn-sm" onclick="picturePost()"><span class="glyphicon glyphicon-pencil"></span> Post</button>';
}

function callCrudAction(action, id) {
    //$("#loaderIcon").show();
    var queryString;
    var url;
    var date = new Date();
        //date = date.replace(/ /g,'T');
    switch (action) {
        case "post":
            var main_post = $("#post_message").val(); //for post
            var group_type = $("#group_type").val(); //for post

            queryString = 'message=' + main_post+'&picture=' + id;
            url = 'dashboard/post/'+group_type;
            break;

        case "comment":
            var test = $("#txtmessage" + id).val(); //for comments
            queryString = 'action=' + action + '&txtmessage=' + test + '&post_id=' + id+'&date=' + date;
             url = "dashboard/comment";
            break;

        case "delete_post":
            //alert('post delete');
            queryString = 'action=' + action + '&post_id=' + id;
            var url = "dashboard/delete/post/"+id;
            break;

        case "delete_comment":
            queryString = 'action=' + action + '&comment_id=' + id;
            var url = "dashboard/delete/comment/"+id;
            break;

        case "like_post":
            $('#like-btn' + id).replaceWith('<a href="javascript:void(0);" class="btn btn-default btn-sm" onClick="callCrudAction(\'unlike_post\','+id+')" title="Like it" id="like-btn'+ id+'"><span class="glyphicon glyphicon-thumbs-down"></span> Unlike</a>');

            queryString = 'action=' + action + '&post_id=' + id;
            var url = "dashboard/like/post/"+id;
            break;

        case "unlike_post":
            $('#like-btn' + id).replaceWith('<a href="javascript:void(0);" class="btn btn-default btn-sm" onClick="callCrudAction(\'like_post\','+id+')" title="Like it" id="like-btn'+ id+'"><span class="glyphicon glyphicon-thumbs-up"></span> Like</a>');

            queryString = 'action=' + action + '&post_id=' + id;
            var url = "dashboard/unlike/post/"+id;
            break;

    }
    jQuery.ajax({
        url: url,
        data: queryString,
        type: "POST",
        success: function (data) {
            switch (action) {

                case "post":
                    $("#wall_post").fadeIn().after(data);
                    $("#post_message").val('');
                    $("#filename").val('');
                    $('#output').empty();
                    $('.box-comments').slideUp();
                    break;
                case "comment":
                    //$("div#all_replies"+id).slideDown();
                    $("#post-reply" + id).fadeIn().before(data);
                    $("span#reply-count" + id).text(function (i, origText) {
                        if (isNaN(parseInt(origText))) {
                            return  1;// + " Comment";
                        } else {
                            var sum = parseInt(origText) + 1;
                            return sum; // + " Comments";
                        }

                    });

                    break;

                case "delete_post":
                    $('#post_holder' + id).fadeOut();
                    break;

                case "delete_comment":
                    $('#reply' + id).fadeOut();
                    //var parents = $('#reply' + id).parentsUntil("#father");
                    //var wanted = parents.find('a.view_comment');
                    //var link = wanted.attr('id');
                    $("span#reply-count" + data).text(function (i, origText) {

                        var sum = parseInt(origText) - 1;
                        return sum; // + " Comments"

                    });
                    break;

                case "like_post":
                    $('#like-count' + id).replaceWith(data);
                    break;

                case "unlike_post":
                    $('#like-count' + id).html(data);
                    break;

            }
            //$('.liveTime').liveTimeAgo();
            $('[data-toggle="popover"]').popover();
            $("#reactMsg" + id).val('');
            $("#txtmessage" + id).val('');

            $("#loaderIcon").hide();
        },
        error: function () {
        }
    });
}
/*******************************Not Used yet */
function toggle_visibility(show, hide) {
    $("div#"+hide).hide();
    $("div#"+show).slideDown();
    return false;
}


