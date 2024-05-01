<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install Digisaka App</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{url('/css/custom_css/install.css')}}">
</head>
<body>
    <div class="container">
        <p class="title">Digisaka <span class="bold">{{$app->version}}</span></p>
        <div class="changelog">
            <p class="bold">Changelog</p>
            <ul class="borderLeft">
                
            </ul>
        </div>
        <div class="button">
            <a href="https://digisaka.info/upload/files/upload/app_files/{{$app->filename}}" download>Download Digisaka App</a>
        </div>
        <div style="height:20px"></div>
        <div class="stats">
            <div class="views">{{$app->views}} views</div>
            <div class="downloads">{{$app->downloads}} downloads</div>
        </div>
        <p class="bold">Subscribe to updates</p>
        <div class="column">
            <input class="input" type="text" placeholder="Input email..">
            <div style="height:10px"></div>
            <button class="button" onclick="joinMe()">Join me in</button>
        </div>
    </div>
    <script>
        document.querySelector('.container').style.height = window.innerHeight + "px";
        function joinMe(){
            alert("this function is under construction!")
        }
        str = "{{$app->changelog}}".substring(0, "{{$app->changelog}}".length - 1);
        let changelog = str.split("|");
        console.log(changelog)
        changelog.forEach(change => {
            let ul = document.querySelector(".borderLeft")
            let a = document.createElement("li")
            a.textContent = change;
            ul.append(a);
        });
    </script>
</body>
</html>