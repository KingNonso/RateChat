$(document).ready(function(e) {
    /*-----------------------SLUG GEN CALLER -------------------*/
//this function is to generate slug on mouse up
    $('#hostel_name').keyup(function(e) {
        generate('#hostel_name');
    });
    $("#hostel_name").change(function(){
        slugCheck();
    });

    $("#hostel_slug").on({
        focus: function(){
            //$(this).css("background-color", "lightgray");
            slugCheck();
        },
        keyup: function(){
            slugCheck();
        },
        blur: function(){
            generate('#slug');
            slugCheck();
        }
    });
    /*-----------------------SLUG GEN CALLER END -------------------*/



    function generate(from){
        var name = $(from).val();

        //alert($( this ).attr( "id" ));
        var map = {// remove accents, swap ñ for n, etc
            from: 'àáäãâèéëêìíïîòóöôõùúüûñç·/_,:;'
            , to  : 'aaaaaeeeeiiiiooooouuuunc------'
        };


        for (var i=0, j=map.from.length; i<j; i++) {
            name = name.replace(new RegExp(map.from.charAt(i), 'g'), map.to.charAt(i));
        }

        /* .replace(/\s+/g, '-')           // Replace spaces with -
         .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
         .replace(/\-\-+/g, '-')         // Replace multiple - with single -
         .replace(/^-+/, '')             // Trim - from start of text
         .replace(/-+$/, '');            // Trim - from end of text
         */
        name = name.toString().toLowerCase().replace(/\s+/g, '-').replace(/[^\w\-]+/g, '').replace(/\-\-+/g, '-').replace(/^-+/, '').replace(/-+$/, '');
        //check if slug already exist in database

        $("#hostel_slug").val(name);

    }

    function slugCheck() {
        var guard = $("#slug-guard");

        guard.text('Checking for availability of slug URL...');

        var submitButton = ($('button[type="submit"]').length) ? $('button[type="submit"]') : $('input[type="submit"]');

        var slug = $("#hostel_slug").val();
        var queryString;
        var url;
        queryString = 'hostel_slug=' + slug;
        url = 'slug_check';

        jQuery.ajax({
            url: url,
            data: queryString,
            type: "POST",
            success: function (data) {
                if(data == 'good'){
                    guard.text("Hurray!!! Slug URL is available for Use! ");
                    guard.css("color", "green");
                    submitButton.prop('disabled', false);

                }else{
                    guard.text("This Slug URL has cannot be used. Please edit the Slug URL to make it unique! ");
                    guard.css("color", "red");
                    submitButton.prop('disabled',true);

                }
            },
            error: function () {
            }
        });
        $("#hostel_slug").val(slug);

    }

});

