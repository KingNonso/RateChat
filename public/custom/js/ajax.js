/**
 * Created by Nonny on 6/1/16.
 */
// JavaScript Document

function _(x){
    if(document.getElementById(x) === null || document.getElementById(x) === undefined) {
        //logic
        return false;
    }else{
        return document.getElementById(x);

    }
}

function toggleElement(x){
    var x = _(x);
    if(x.style.display == 'block'){
        x.style.display = 'none';
    }else{
        x.style.display = 'block';
    }
}

function ajaxObj( meth, url ) {
    var x = new XMLHttpRequest();
    x.open( meth, url, true );
    x.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    return x;
}
function ajaxReturn(x){
    if(x.readyState == 4 && x.status == 200){
        return true;
    }
}
function emptyElement(x){
    _(x).innerHTML = "";
}

function toggle(id){
    $("div#"+id).slideToggle();
}