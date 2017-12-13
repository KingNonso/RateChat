/*----------------       Static SEARCHING  --------------------------- */
function Search(str) {
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
            document.getElementById("livesearch").style.border="1px solid #A5ACB2";
        }
    }
    xmlhttp.open("GET","../search_for_person/"+str,true);
    xmlhttp.send();
}


function set_item(item) {
    document.getElementById("livesearch").innerHTML="";
    // hide proposition list
    document.getElementById("message_alert").innerHTML="";
    //document.getElementById(myDomElement).style.border="0px";

    //make assign the role to the user
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {  // code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            document.getElementById("setter").innerHTML = xmlhttp.responseText;
            //document.getElementById(eat).innerHTML=xmlhttp.responseText;
            //document.getElementById(use).style.border="1px solid #A5ACB2";
        }
    }
    //xmlhttp.open("GET","make_executive/"+item+"/"+eat,true);
    xmlhttp.open("GET","../make_executive/"+item,true);
    xmlhttp.send();


}

function RemoveExecutive(id){
    var page = '../step/parent'; //first for first timers online
    window.location.assign(page);


}
