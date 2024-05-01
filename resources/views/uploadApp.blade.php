<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Digisaka App</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{url('/css/custom_css/uploadFile.css')}}">
</head>
<body>
    <div class="container">
        <div class="wrapper">
            <form action="#">
                <h3>Upload Digisaka New Version</h3>
                <div class="form" onclick="fileClick()">
                  <i class="fas fa-cloud-upload-alt"></i>
                  <p>Select file to upload</p>
                  <input name="file" type="file" class="file-input" hidden />
                </div>
                
                <div class="inputs">
                  <input type="text" name="version" placeholder="version">
                  
                  <input type="text" placeholder="changelog" class="cl">
                  <input type="text" name="changelog" placeholder="changelog" hidden class="ch">
                  <ul class="borderLeft">

                  </ul>
                  <button type="button" style="border:2px solid #008540;background:#fff;color:#008540" onclick="addChangelog()">Add More</button>
                  <div style="height:10px"></div>
                  <button type="button" class="upload" onclick="uploadd()">Upload</button>
                </div>
            </form>
            <div style="height:20px"></div>
            <section class="progress-area"></section>

            <section class="upload-area"></section>
        </div>
    </div>
    <script> 
        document.querySelector('.container').style.height = window.innerHeight + "px";
        let fileInput = document.querySelector(".file-input");
        let form = document.querySelector("form")
        let upload = document.querySelector(".upload");
        let progressArea = document.querySelector(".progress-area");
        let uploadArea = document.querySelector(".upload-area");
        let file;
        let fileName;
        let changelog = "";
        function addChangelog(){
          let ch = document.querySelector(".cl");
          changelog += `${ch.value}|`
          ch.value = "";
          createChangelog();
        }
        function createChangelog(){
          let change = changelog.split("|");
          let ul = document.querySelector(".borderLeft")
          ul.innerHTML = "";
          change.forEach(chng => {
            if(chng != ""){
              let li = document.createElement("li")
              li.textContent = chng;
              let b = document.createElement("span")
              b.innerHTML = "<span onclick=\"removeChangelog('"+chng+"')\">&times</span>"
              li.append(b);
              ul.append(li);
            }
            
          });
          let ch = document.querySelector(".ch");
          ch.value = changelog;
        }

        function removeChangelog(change){
          changelog = changelog.replace(change+"|","");
          createChangelog();
        }
      
        function fileClick(){ 
          fileInput.click() 
        }
        fileInput.onchange = ({ target }) => {
        //getting file from the files selected
         file = target.files[0];

        //if file selected
          if (file) {
            //getting file name
             fileName = file.name;

            if (fileName.length > 12) {
           
            let nameSplit = fileName.split(".");
            fileName = nameSplit[0].substring(0, 13) + "..." + nameSplit[1];
            }
            
          }
        };
        function uploadd(){
          if(file){
            uploadFile(fileName);
          }
        }
        function uploadFile(name) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "https://digisaka.info/api/v1/user/uploadApp");

        xhr.upload.addEventListener("progress", ({ loaded, total }) => {
            let fileLoaded = Math.floor((loaded / total) * 100);
            let fileTotal = Math.floor(total / 1000);
            let fileSize; 
            fileTotal < 1024
            ? (fileSize = fileTotal + "KB")
            : (fileSize = (loaded / (1024 * 1024)).toFixed(2) + "MB");

            
            let progressHTML = `<li class="row">
            <i class="fas fa-file-alt"></i>
            <div class="content">
            <div class="details">
                <span class="name">${name} . uploading...</span>
                <span class="percent">${fileLoaded}%</span>
            </div>
            <div class="progress-bar">
                <div class="progress" style="width: ${fileLoaded}%"></div>
            </div>
            </div>
        </li>`;
            progressArea.innerHTML = progressHTML;

            if (loaded == total) {
           
            progressArea.innerHTML = "";
          
            let uploadHTML = ` <li class="row">
            <div class="content">
                <i class="fas fa-file-alt"></i>
                <div class="details">
                <span class="name">${name} . uploaded</span>
                <span class="size">${fileSize}</span>
                </div>
            </div>
            <i class="fas fa-check"></i>
            </li>`;

            uploadArea.insertAdjacentHTML("afterbegin", uploadHTML);
            }
        });

        let formData = new FormData(form);

        xhr.send(formData);
        }
    </script>
</body>
</html>