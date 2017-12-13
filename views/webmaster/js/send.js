//$("#justnow").hide();
function Supporter(action,id) {
    var queryString;
    var url;

    switch (action) {
        case "support":
            var messages = $("#message_"+id).val(); //for post

            queryString = 'action=' + action + '&messages='+messages ;
            url = '../admin/messages/' + id;
            break;


    }
    jQuery.ajax({
        url: url,
        data: queryString,
        type: "POST",
        success: function (data) {
            switch (action) {

                case "support":
                    //$("#justnow").show();
                    $("#chatnow"+ id).fadeIn().append(data);
                    $("#message_"+ id).val(''); //for post

                    break;

            }

        },
        error: function () {
        }
    });
}

