
function picturePost(){
    var url = 'dashboard/picturePost';
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
    //_("status").innerHTML = event.target.responseText;
    document.getElementById("post").innerHTML = '<button type="submit" class="btn btn-default btn-sm" onclick="callCrudAction(\'post\',1)"><span class="glyphicon glyphicon-pencil"></span> Post</button>';

    //Post to db
    callCrudAction('post', event.target.responseText);
}
function errorHandler(event){
    //_("status").innerHTML = "Upload Failed";
}
function abortHandler(event){
    //_("status").innerHTML = "Upload Aborted";
}