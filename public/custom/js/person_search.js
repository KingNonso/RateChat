//This function checks to see when you click outside of the navbar
$(document).click(function (event) {
    var clickover = $(event.target);
    var $navbar = $(".navbar-collapse");
    var _opened = $navbar.hasClass("in");
    if (_opened === true && !clickover.hasClass("navbar-toggle")) {
        $navbar.collapse('hide');
    }
});

function viewDashBoard(){
    //show the topBody
    _("topBody").style.display = "block";
    var $navbar = $(".navbar-collapse");
    $navbar.collapse('hide');

    //now scroll to that place
    // Prevent default anchor click behavior
    event.preventDefault();

    // Store hash
    var hash = '#topBody';
    console.log('has hash'+hash);

    // Using jQuery's animate() method to add smooth page scroll
    // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
    $('html, body').animate({
        scrollTop: $(hash).offset().top
    }, 900, function(){

        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
    });

        $(window).scroll(function() {
            $(".slideanim").each(function(){
                var pos = $(this).offset().top;

                var winTop = $(window).scrollTop();
                if (pos < winTop + 600) {
                    $(this).addClass("slide");
                }
            });
        });

    // Select tab by name
    $('.tab-content#search').addClass('active');
    $('.nav-tabs a[href="#search"]').tab('show');

}

function Search(str, url) {
    //this function is to be globally available
    //hence we need to iterate through the depth of url
    if (str.length==0) {
        document.getElementById("livesearch").innerHTML="";
        document.getElementById("livesearch").style.border="0px";
        return;
    }

    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {  // code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            document.getElementById("livesearch").innerHTML=xmlhttp.responseText;
            //document.getElementById("livesearch").style.border="1px solid #A5ACB2";
        }
    }
    var text = "";
    for (i = 1; i < url; i++) {
        text += "../";
    }
    //console.log(text+" url count is  "+url);

    xmlhttp.open("GET",text+"wall/search_for_person/"+str,true);
    xmlhttp.send();
}
