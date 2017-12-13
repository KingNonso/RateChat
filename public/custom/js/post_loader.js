/**
 * Created by Nonny on 9/24/16.
 * Javascript Scroll Tutorial Load Dynamic Content Into Page When User Reaches Bottom Ajax
 */

function showOlderPost(){
    var wrap = document.getElementById('load_more_wall_post');
    var group_type = document.getElementById('group_type').value;

    var ajax = ajaxObj("POST", "../load_more_wall_post/"+group_type);

    ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
            if((ajax.responseText) == 'nothing'){
                var end_of_doc = document.getElementById('end_of_doc');
                end_of_doc.innerHTML = 'You have reached the end of active posts/ conversations';
            } else {
                wrap.innerHTML += ''+ajax.responseText+'';
                $('.liveTime').liveTimeAgo();
                // Select all elements with data-toggle="popover" in the document
                $('[data-toggle="popover"]').popover({html: true, placement: "top"});
                $('.box-comments').slideUp();
                $(".posted_hidden").hide();

            }
        }
    }
    ajax.send();//"person_state="+person_state+"&person_slug="+person_slug

    //for testing and development purposes
    //var status = document.getElementById('status');
    //status.innerHTML = contentHeight+" | "+y;
}



