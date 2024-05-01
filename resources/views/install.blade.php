<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install Digisaka App</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <style>
        .container{
            display:flex;
            align-items: center;
            justify-content: center;
            font-family: 'Open Sans', sans-serif;
        }
        a{
            text-decoration: none;
            color: white;
        }
        .button{
            padding: 10px 20px;
            border-radius: 5px;
            background-color: #008540;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="button">
            <a href="https://a3.files.diawi.com/app-file/{{$diawi}}.apk">Download Digisaka App</a>
        </div>
    </div>
    <script>
        document.querySelector('.container').style.height = window.innerHeight + "px";
    </script>
</body>
</html>