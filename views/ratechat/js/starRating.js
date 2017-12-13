
$('.ratings_stars').bind('click', function() {
    var url = '../../ratechat/starRater';

    var star = this;
    var widget = $(this);

    var clicked_data = {
        clicked_on : $(star).val(),
        widget_id : widget.attr('id')
    };
    jQuery.ajax({
        url: url,
        data: clicked_data,
        dataType: 'json',
        type: 'POST',
        success: function (data) {

        },
        error: function () {
        }
    });


});


function ratechatAnswers(content,rate) {
    var url;
    var queryString;

    var rate_comment = $("#rate_comment").val();
    queryString = 'content='+content + '&rate=' + rate +'&rate_comment='+rate_comment;
    url += '../../../../ratechat/ratechatAnswers';

    jQuery.ajax({
        url: url,
        data: queryString,
        type: "POST",
        success: function (data) {
            var status = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-check"></i> Success!</h4><p>Thanks. Response was received</p></div>';
            $("#content_"+rate+"_"+content).slideUp();
            $("#status").slideDown();
            $("#status").html(status);
            setInterval(function(){$("#status").slideUp(); },3000);
        },
        error: function () {
        }
    });
}
