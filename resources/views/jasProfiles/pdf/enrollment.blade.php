<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Form</title>
    <style>
        @page { margin: 0px; }
        body { margin: 0px; }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: white;
            height: 100vh;
        }
        .container {
            background-color: grey;
            /* padding: 20px; */
            /* border-radius: 10px; */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* width: 100%; */
            /* max-width: 800px; */
            margin: 0 50px;
            margin-right: 10px;
        }
        .header img{
            width: 100%;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .form-group {
            margin-bottom: 15px;
            width: 100%
        }
        .form-group label {
            display: inline-block;
            /* font-weight: bold; */
            /* margin-bottom: 5px; */
            font-size: 14px;
        }
        .form-group span {
            display: block;
            font-weight: normal;
            font-size: 12px;
            color: #666;
        }
        .form-group .underline {
            border-bottom: #000 solid black;
            display: inline-block;
        }
        .form-group input[type="text"],
        .form-group input[type="date"],
        .form-group input[type="tel"] {
            width: calc(50% - 10px);
            padding: 8px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group input[type="text"]:last-child,
        .form-group input[type="tel"]:last-child {
            margin-right: 0;
        }
        .form-group input[type="text"] {
            width: 100%;
        }
        .form-group .half {
            width: calc(50% - 10px);
        }
        .form-group .full {
            width: 100%;
        }
        .signature-section {
            text-align: center;
            margin-top: 20px;
        }
        .signature-section p {
            font-size: 14px;
        }
        .signature-section .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .signature-section .signatures div {
            width: calc(33.333% - 10px);
            text-align: center;
        }
        .signature-section .signatures div p {
            border-top: 1px solid #000;
            margin: 0;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path('images/efheader.jpg'))) }}" alt="Logo">
    </div>
    <div class="container">
        <form>
            <div class="form-group" style="margin-top: 30px">
                <label for="name">Name of Cooperator: </label>
                <div class="underline" style="width: calc(100% - 170px);"></div>
                <span>(Pangalan)</span>
            </div>
            <div class="form-group" style="margin-top: 20px">
                <div class="label-container">
                    <label for="address">Address: </label>
                    <div class="underline" style="width: calc(100% - 95px);"></div>
                </div>
                <span>(Tirahan)</span>
            </div>
            <div class="form-group" style="margin-top: 20px">
                <div class="label-container" style="width: 45%; display: inline-block">
                    <label for="birthdate">Birthdate: </label>
                    <div class="underline" style="width: calc(100% - 75px);"></div>
                    <span>(Petsa ng Kapanganakan)</span>
                </div>
                <div class="label-container" style="width:53%; display: inline-block">
                    <label for="phone">Cellphone No. (if any): </label>
                    <div class="underline" style="width: 220px"></div>
                    <span>(Numero ng Telepono, Kung Mayroon)</span>
                </div>
                
            </div>
            <div class="form-group" style="margin-top: 30px">
                <div class="label-container" style="width: 30%; display: inline-block; padding-bottom: 55px">
                    <label for="variety-wet">VARIETY USUALLY USED</label>
                    <span>(Binhing Ginagamit)</span>  
                </div>
                <div class="label-container" style="width: 68%; display: inline-block">
                    <label for="variety-wet">WET SEASON: </label>
                    <div class="underline" style="width: calc(100% - 130px);"></div>
                    <span>(Tag Ulan)</span>  

                    <label for="variety-dry" style="margin-top: 20px">DRY SEASON: </label>
                    <div class="underline" style="width: calc(100% - 130px);"></div>
                    <span>(Tag Tuyo)</span>
                </div>
                
            </div>
            <div class="form-group" style="margin-top: 20px">
                <div class="label-container" style="width: 30%; display: inline-block; padding-bottom: 55px">
                    <label for="variety-wet">AVERAGE YIELD PER HECTARE</label>
                    <span>(Dami ng Sako ng Ani)</span>  
                </div>
                <div class="label-container" style="width: 68%; display: inline-block">
                    <label for="variety-wet">WET SEASON: </label>
                    <div class="underline" style="width: calc(100% - 130px);"></div>
                    <span>(Tag Ulan)</span>  

                    <label for="variety-dry" style="margin-top: 20px">DRY SEASON: </label>
                    <div class="underline" style="width: calc(100% - 130px);"></div>
                    <span>(Tag Tuyo)</span>
                </div>
                
            </div>
           
            <div class="form-group">
                <div class="label-container">
                    <label for="dealers">DEALER(S) WHERE YOU BUY FROM: </label>
                    <div class="underline" style="width: calc(100% - 290px);"></div>
                </div>
                <span>(Suking Tindahan)</span>
            </div>
            <div class="form-group" style="margin-top: 40px;text-align: center">
                <label style="font-size: 16px">I hereby affix my signature to manifest my agreement to abide by the</label>
                <span>Kalakip nito ang aking lagda bilang pagpapatunay na susunod ako sa alituntunin</span>
                <label style="font-size: 16px">mechanics of this program.</label>
                <span>ng programang ito.</span>
            </div>
            <div class="signature-section">
                <div class="signatures">
                    <div>
                        <p>TPS or CPR/SIGNATURE: _________________</p>
                    </div>
                    <div>
                        <p>AM/SIGNATURE: _________________</p>
                    </div>
                    <div>
                        <p>SIGNATURE (Lagda): _________________</p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
