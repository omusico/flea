<? $current_page = $_SERVER['SCRIPT_NAME']; ?>
<script>
    //from http://robertnyman.com/html5/fileapi-upload/fileapi-upload.html
    (function () {
        var filesUpload = document.getElementById("files-upload"),
            dropArea = document.getElementById("drop-area"),
            fileList = document.getElementById("file-list");
            
        function uploadFile (file) {
            var img,
                progressBarContainer = document.createElement("div"),
                progressBar = document.createElement("div"),
                reader,
                xhr,
                fileInfo;

            progressBarContainer.className = "progress-bar-container";
            progressBar.className = "progress-bar";
            progressBarContainer.appendChild(progressBar);
            fileList.appendChild(progressBarContainer);
            
            // Uploading - for Firefox, Google Chrome and Safari
            xhr = new XMLHttpRequest();
            
            // Update progress bar
            xhr.upload.addEventListener("progress", function (evt) {
                if (evt.lengthComputable) {
                    progressBar.style.width = (evt.loaded / evt.total) * 100 + "%";
                }
                else {
                    // No data to calculate on
                }
            }, false);
            
            // File uploaded
            xhr.addEventListener("load", function () {
                fileList.innerHTML = "上傳成功！";
                <? if($current_page=='/flea/flea_src/content/my_page/settings.php'){ ?>
                update_icon_src(200);
                <? } else if($current_page=='/flea/flea_src/content/my_page/fleaitem.php') { ?>
                //get_item_block_new();
                get_itemlist_block();
                <? } else if($current_page=='/flea/flea_src/content/my_page/specialitem.php') { ?>
                get_sitemlist_block();
                <? } ?>
            }, false);
            
            <? if($current_page=='/flea/flea_src/content/my_page/settings.php'){ ?>
            xhr.open("post", '/flea/flea_src/action/upload_user_icon_action.php', true);
            <? } else if($current_page=='/flea/flea_src/content/my_page/fleaitem.php') { ?>
            xhr.open("post", '/flea/flea_src/action/upload_item_icon_action.php', true);
            <? } else if($current_page=='/flea/flea_src/content/my_page/specialitem.php') { ?>
            xhr.open("post", '/flea/flea_src/action/upload_sitem_icon_action.php', true);
            <? } ?>
            
            // Set appropriate headers
            xhr.setRequestHeader("Content-Type", "multipart/form-data");
            xhr.setRequestHeader("X-File-Name", file.fileName);
            xhr.setRequestHeader("X-File-Size", file.fileSize);
            xhr.setRequestHeader("X-File-Type", file.type);

            // Send the file (doh)
            xhr.send(file);
        }
        
        function traverseFiles (files) {
            if (typeof files !== "undefined") {
                for (var i=0, l=files.length; i<l; i++) {
                    uploadFile(files[i]);
                }
            }
            else {
                fileList.innerHTML = "目前您的瀏覽器沒有支援此功能";
            }	
        }
        
        filesUpload.addEventListener("change", function () {
            traverseFiles(this.files);
        }, false);
        
        dropArea.addEventListener("dragleave", function (evt) {
            var target = evt.target;
            
            if (target && target === dropArea) {
                this.className = "";
            }
            evt.preventDefault();
            evt.stopPropagation();
        }, false);
        
        dropArea.addEventListener("dragenter", function (evt) {
            this.className = "over";
            evt.preventDefault();
            evt.stopPropagation();
        }, false);
        
        dropArea.addEventListener("dragover", function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
        }, false);
        
        dropArea.addEventListener("drop", function (evt) {
            traverseFiles(evt.dataTransfer.files);
            this.className = "";
            evt.preventDefault();
            evt.stopPropagation();
        }, false);										
    })();
</script>