/**
 * Created by Nonny on 3/10/17.
 */

window.jQuery(function ($) {

    "use strict";
    $('div, time').countDown();

});

function starter(action, id) {

    //$("#loaderIcon").show();
    var queryString;
    var url;
    var date = new Date();
    //date = date.replace(/ /g,'T');
    switch (action) {
        case "merge":
            var person = $("#person").val(); //for post
            var plan = $("#plan").val(); //for post

            queryString = 'action=' + action + '&person='+person + '&plan=' + plan;//+'&date=' + date;
            url = '../../admin/merger/'+plan;
            break;


    }
    jQuery.ajax({
        url: url,
        data: queryString,
        type: "POST",
        success: function (data) {
            switch (action) {

                case "merge":
                    $("#upline").fadeIn().after(data);
                    break;

            }

            $("#loaderIcon").hide();
        },
        error: function () {
        }
    });
}

