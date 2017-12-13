function account_setup(){

    var person_state = _("person_state").value;
    var person_slug = _("person_slug").value;

    if(person_state == "" || person_slug == "" ){
        _("status").innerHTML = '<h3> Please, form fields cannot be empty. </h3>';

    } else{

        emptyElement('status');
        _("submit").style.display = "none";
        _("status").innerHTML = '<h3>Processing... Please wait ...<h3>';
        var ajax = ajaxObj("POST", "../wall/member_status");

        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                if((ajax.responseText) == 'error'){
                    _("status").innerHTML = '<h3 class="error-code">There seems to be a problem updating your profile ...</h3>';

                    _("status").style.display = "block";
                } else {
                    uploadFile(ajax.responseText);
                }
            }
        }
        ajax.send("person_state="+person_state+"&person_slug="+person_slug);

    }


}


function uploadFile(value){
    var url = '../wall/photo_status/'+value;
    var max = _("MAX_FILE_SIZE").value;

    var file = _("filename").files[0];

    if(file != ''){ //if not empty
        var formdata = new FormData();
        formdata.append("file1", file);
        formdata.append("max", max);

        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        ajax.open("POST", url);
        ajax.send(formdata);

    }else{
        var page = '../wall/'; //first for first timers online
        window.location.assign(page);
    }

}
function progressHandler(event){
    ///_("progressBar").innerHTML ;
    //_("loaded_n_total").innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
    var percent = (event.loaded / event.total) * 100;
    // _("progressBar").value = Math.round(percent);
    _("status").innerHTML = Math.round(percent)+"% uploaded... please wait";
}
function completeHandler(event){
    _("status").innerHTML = event.target.responseText;
    //_("progressBar").value = 0;
    //get where to redirect to
    var page = '../wall/'; //first for first timers online
    window.location.assign(page);
}
function errorHandler(event){
    _("status").innerHTML = "Upload Failed";
}
function abortHandler(event){
    _("status").innerHTML = "Upload Aborted";
}