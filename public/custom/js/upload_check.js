
function countFiles(e) {
    if (this.files != undefined) {
        var elems = this.form.elements,
            submitButton, //defines input type button
            len = this.files.length,
            max = document.getElementsByName('MAX_FILE_SIZE')[0].value,
            maxfiles = this.getAttribute('data-maxfiles'),
            maxpost = this.getAttribute('data-postmax'),
            displaymax = this.getAttribute('data-displaymax'),
            filesize,
            toobig = [],
            total = 0,
            message = '';

        for (var i = 0; i < elems.length; i++) {
            if (elems[i].type == 'submit' || elems[i].type == 'button') {
                submitButton = elems[i];
                break;
            }
        }

        for (i = 0; i < len; i++) {
            filesize = this.files[i].size;
            if (filesize > max) {
                toobig.push(this.files[i].name);
            }
            total += filesize;
        }
        if (toobig.length > 0) {
            /*
             message = 'The following file(s) are too big:\n'
             + toobig.join('\n') + '\n\n';

             */
            message = 'The following file is too big:\n'
                + toobig.join('\n') + '\n\n';
            message += 'Max size must not exceed ' + convertFromBytes(max) + '\n\n';
        }
        if (total > maxpost) {
            message += 'The combined total exceeds ' + displaymax + '\n\n';
        }
        if (len > maxfiles) {
            message += 'You have selected more than ' + maxfiles + ' files';
        }
        var output = document.getElementById("output");
        if (message.length > 0) {
            //show a generic error msg
            submitButton.disabled = true;
            Output(
                "<p style='color: #ff0000'>" +"<span class=\"glyphicon glyphicon-remove-circle\"></span>  "+
                    " <strong> "+message+"</strong> </p>"
            );
        } else {
            submitButton.disabled = false;
            Output(
                "<p style='color:#008000'>" +"<span class=\"glyphicon glyphicon-ok-circle\"></span>  "+
                    "<strong>This file can be uploaded</strong> </p>"
            );

        }
    }
}

/*###############################    UPLOAD PREVIEW   ###############################*/
        // output information
        function Output(msg) {
            var m = document.getElementById("output");
            m.innerHTML = msg + m.innerHTML;
        }


        // drop box hover effect
        function FileHover(e) {
            e.preventDefault();
            e.target.className = (e.type == "dragover" ? "hover" : "");
        }


        // file selection
        function FileSelect(e) {
            FileHover(e);

            var files = e.target.files || e.dataTransfer.files;

            // process all files
            for (var i = 0, f; f = files[i]; i++) {
                ParseFile(f);
            }

        }


        function convertFromBytes($bytes)
        {
            $bytes /= 1024;
            var fileSize ;
            if ($bytes > 1024) {
                fileSize = ($bytes/1024).toFixed(2);
                return fileSize + ' MB';
            } else {
                fileSize = ($bytes).toFixed(2);
                return fileSize + ' KB';
            }
        }
        // output file information
        function ParseFile(file) {
            var fileSize ;


            // file information
            Output(

                "<p>File information: <strong>" + file.name +
                    "</strong> type: <strong>" + file.type +
                    "</strong> size: <strong>" + convertFromBytes(file.size)
                +"</p>"
            );

            // display an image
            if (file.type.indexOf("image") == 0) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    Output(
                        "<p><strong>" + file.name + " :</strong><br />" +
                            '<img src="' + e.target.result +
                            '" width="150px" height="150px" /></p>'

                    );
                }
                reader.readAsDataURL(file);
            }

            // display text
            if (file.type.indexOf("text") == 0) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    Output(
                        "<p>" + file.name +
                            ": <p><pre>" + e.target.result +
                            "</pre>"
                    );
                }
                reader.readAsText(file);
            }

        }


        // initialization
        if (window.File && window.FileList && window.FileReader) {

            // select box used
            var filename = document.getElementById("filename");
            filename.addEventListener("change", FileSelect, false);
            //count all files and display error
            filename.addEventListener('change', countFiles, false);
            // drop box used
            /*var filedrop = document.getElementById("filedrop");
            filedrop.addEventListener("dragover", FileHover, false);
            filedrop.addEventListener("drop", FileSelect, false);*/

        }


