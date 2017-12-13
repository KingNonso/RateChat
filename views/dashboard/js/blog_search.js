function checkPattern(){
    var search_pattern = $("#search_pattern").val();
    var searcher = $("#searcher");
    if(search_pattern == 'category'){
        $("#search_input").slideUp();
        $("#d_cat").slideDown();
        searcher.html('<button type="submit" class="btn btn-success" onclick="searchBlog(search_category.value);">Search &raquo;</button>');
    }else{
        $("#search_input").slideDown();
        $("#d_cat").slideUp();
        searcher.html('<button type="submit" class="btn btn-success" onclick="searchBlog(search_term.value);">Search &raquo;</button>');

    }

}

function searchBlog(str){
    var search_pattern = $("#search_pattern").val();

    if (str.length==0) {
        document.getElementById("search_results").innerHTML="";
        document.getElementById("search_results").style.border="0px";
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
            if(xmlhttp.responseText == 'bad_search'){
                document.getElementById("search_results").innerHTML='<h4 class="text-danger"> <span class="glyphicon glyphicon-warning-sign"></span> Oops...<br> <small>Nothing was found for the given search term, please check it and try again!</small></h4>';

            }else{
                document.getElementById("search_results").innerHTML=xmlhttp.responseText;

            }
            //document.getElementById("livesearch").style.border="1px solid #A5ACB2";
        }
    }

    xmlhttp.open("GET","../blog/search_blog/"+search_pattern+'/'+str,true);
    xmlhttp.send();
}

function searchDate(){ //year, month, day
    var year = $("#blog_year").val();
    var month = $("#blog_month").val();
    var day = $("#blog_day").val();
    var url = '../blog/date/'+year+'/'+month+'/'+day;
    var queryString = 'year='+year+'&month='+ month+'&day='+ day;

    jQuery.ajax({
        url: url,
        data:queryString,
        type: "POST",
        success:function(data){
            var search_results = $("#search_results");
            switch (data){
                case 'bad_date':
                    search_results.html('<h4 class="text-danger"> <span class="glyphicon glyphicon-warning-sign"></span> Oops...<br> <small>Nothing was found for the given date, please check the dates and try again!</small></h4>');
                    break;
                default :
                    search_results.html(data);
                    break;


            }

        },
        error:function (){}
    });


}

