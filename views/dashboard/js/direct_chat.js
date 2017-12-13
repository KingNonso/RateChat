/**
 * Created by King on 13/12/17.
 */
function directChat() {
    var queryString;
    var url;
    var directMsg = $("#directMsg").val(); //for post
    var receiver_id = $("#receiver_id").val(); //for post

    queryString = 'message=' + directMsg+'&receiver_id=' + receiver_id;
    url = 'dashboard/directChat';

    jQuery.ajax({
        url: url,
        data: queryString,
        type: "POST",
        success: function (data) {
            $("#directAppend").fadeIn().before(data);
            $("#directMsg").val('');
            scrollToView();
        },
        error: function () {
        }
    });
}

function scrollToView(){
    var myElement = document.getElementById('directAppend');
    var topPos = myElement.offsetTop;
    document.getElementById('scrolling_div').scrollTop = topPos;
}



function GetDirectChat(person) {

    //var queryString = 'message=' + directMsg+'&receiver_id=' + receiver_id;
    var url = 'dashboard/GetDirectChat/'+person;

    jQuery.ajax({
        url: url,
        //data: queryString,
        type: "POST",
        success: function (data) {
            $("#receiver_id").val(person);
            $("#scrolling_div").html(data);
            scrollToView();
        },
        error: function () {
        }
    });
}

setInterval(function(){GetNewChat() }, 3000);

function GetNewChat() {
    var person = $("#receiver_id").val();

    //var queryString = 'message=' + directMsg+'&receiver_id=' + receiver_id;
    var url = 'dashboard/GetNewChat/'+person;

    jQuery.ajax({
        url: url,
        //data: queryString,
        type: "POST",
        success: function (data) {
            $("#directAppend").fadeIn().before(data);
            scrollToView();
        },
        error: function () {
        }
    });
}
