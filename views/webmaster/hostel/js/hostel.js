/**
 * Created by King on 10/04/17.
 */

function SearchHostel(str) {
    //this function is to be globally available
    //hence we need to iterate through the depth of url
    if (str.length==0) {
        document.getElementById("hostel_search_results").innerHTML="";
        document.getElementById("hostel_search_results").style.border="0px";
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
            document.getElementById("hostel_search_results").innerHTML=xmlhttp.responseText;
            //document.getElementById("hostel_search_results").style.backgroundColor="#f4511e";
        }
    }

    xmlhttp.open("GET","index/hostel_search/"+str,true);
    xmlhttp.send();
}

