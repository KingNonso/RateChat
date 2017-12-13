$("#loaderIcon").hide();

function voteCube(content,rate) {
    var path = $("#redirect_path").val();

    var url;

    $("#loaderIcon").show();
    $("#skip_next_nominate").hide();
    var queryString;

    var nominee_id = $("#nominee_id").val(); //for class
    queryString = 'content='+content + '&rate=' + rate ;
    url += '../../../../ratechat/voteCube/'+nominee_id;

    jQuery.ajax({
        url: url,
        data: queryString,
        type: "POST",
        success: function (data) {
            $("#vote_box").html(data);

            $("#loaderIcon").hide();
            $("#skip_next_nominate").show();
            window.location.assign(path);
        },
        error: function () {
        }
    });
}
