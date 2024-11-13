<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Form</title>
    <style>
        @page {
            margin: 0px;
        }

        body {
            margin: 0px;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: white;
            height: 100vh;
        }

        .container {
            /* background-color: grey; */
            /* padding: 20px; */
            /* border-radius: 10px; */
            /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); */
            /* width: 100%; */
            /* max-width: 800px; */
            margin: 0 50px;
            margin-right: 10px;
        }

        .header img {
            width: 100%;
            margin-bottom: 20px;
        }

        .footer {
            position: fixed;
            bottom: 0px;
        }

        .footer img {
            width: 100%;
            margin-top: 20px;
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
            /* padding-left: 50px; */
            text-align: center;
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

        table {
            width: 90%;
            border-collapse: collapse;
            margin: 0 auto;
        }

        th,
        td {
            border: 1px solid #858585;
            text-align: center;
            padding: 8px;
            font-size: 12px;
        }

        th {
            background-color: #f0ea3e;
            color: black;
        }

        tbody.big-padding tr td {
            padding-top: 35px;
            padding-bottom: 35px;
        }

        tbody.small-padding tr td {
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .no-lh {
            margin-top: 2px;
            line-height: 0px
        }

        .form-info tr th {
            width: 30%;
            font-size: 14px;
            font-weight: bold;
        }

        .form-info {
            width: 90%;
        }

        table.form-activity tbody>tr>td:first-child {
            width: 25% !important;
            text-transform: uppercase;
            padding-top: 35px;
            padding-bottom: 35px;
        }

        table.form-activity {
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path('images/efheader.jpg'))) }}"
            alt="Logo">
    </div>
    <div class="container">
        <form>
            <div class="form-group" style="margin-top: 30px">
                <label for="name">Name of Cooperator: </label>
                <div class="underline" style="width: calc(100% - 170px);">{{ $profile->first_name }}
                    {{ $profile->middle != '' ? $profile->middle . '.' : '' }} {{ $profile->last_name }}</div>
                <span>(Pangalan)</span>
            </div>
            <div class="form-group" style="margin-top: 20px">
                <div class="label-container">
                    <label for="address">Address: </label>
                    <div class="underline" style="width: calc(100% - 95px);">{{ $profile->address }}</div>
                </div>
                <span>(Tirahan)</span>
            </div>
            <div class="form-group" style="margin-top: 20px">
                <div class="label-container" style="width: 45%; display: inline-block">
                    <label for="birthdate">Birthdate: </label>
                    <div class="underline" style="width: calc(100% - 75px);">
                        {{ date('F d, Y', strtotime($profile->birthdate)) }}</div>
                    <span>(Petsa ng Kapanganakan)</span>
                </div>
                <div class="label-container" style="width:53%; display: inline-block">
                    <label for="phone">Cellphone No. (if any): </label>
                    <div class="underline" style="width: 220px">{{ $profile->phone }}</div>
                    <span>(Numero ng Telepono, Kung Mayroon)</span>
                </div>

            </div>
            <div class="form-group" style="margin-top: 30px">
                <div class="label-container" style="width: 30%; display: inline-block; padding-bottom: 53px">
                    <label for="variety-wet">VARIETY USUALLY USED</label>
                    <span>(Binhing Ginagamit)</span>
                </div>
                <div class="label-container" style="width: 68%; display: inline-block">
                    <label for="variety-wet">WET SEASON: </label>
                    <div class="underline" style="width: calc(100% - 130px);">{{ $profile->variety_used_wet }}</div>
                    <span>(Tag Ulan)</span>

                    <label for="variety-dry" style="margin-top: 20px">DRY SEASON: </label>
                    <div class="underline" style="width: calc(100% - 130px);">{{ $profile->variety_used_dry }}</div>
                    <span>(Tag Tuyo)</span>
                </div>

            </div>
            <div class="form-group" style="margin-top: 20px">
                <div class="label-container" style="width: 30%; display: inline-block; padding-bottom: 53px">
                    <label for="variety-wet">AVERAGE YIELD PER HECTARE</label>
                    <span>(Dami ng Sako ng Ani)</span>
                </div>
                <div class="label-container" style="width: 68%; display: inline-block">
                    <label for="variety-wet">WET SEASON: </label>
                    <div class="underline" style="width: calc(100% - 130px);">{{ $profile->average_yield_wet }}</div>
                    <span>(Tag Ulan)</span>

                    <label for="variety-dry" style="margin-top: 20px">DRY SEASON: </label>
                    <div class="underline" style="width: calc(100% - 130px);">{{ $profile->average_yield_dry }}</div>
                    <span>(Tag Tuyo)</span>
                </div>

            </div>

            <div class="form-group">
                <div class="label-container">
                    <label for="dealers">DEALER(S) WHERE YOU BUY FROM: </label>
                    <div class="underline" style="width: calc(100% - 290px);">{{ $profile->dealers }}</div>
                </div>
                <span>(Suking Tindahan)</span>
            </div>
            <div class="form-group" style="margin-top: 40px;text-align: center; z-index: 2">
                <label style="font-size: 16px">I hereby affix my signature to manifest my agreement to abide by
                    the</label>
                <span>Kalakip nito ang aking lagda bilang pagpapatunay na susunod ako sa alituntunin</span>
                <label style="font-size: 16px">mechanics of this program.</label>
                <span>ng programang ito.</span>
            </div>

            <div class="form-group" style="margin-top: 70px; margin-left: 65%;width: 215px;text-align:center">
                <div class="underline" style="width: 100%;margin-bottom: 0px;">
                    <div style="width: 100%;position: relative;">
                        @if (file_exists(public_path($profile->image)) && is_file(public_path($profile->image)))
                            <img src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path($profile->image))) }}"
                                alt="Signature"
                                style="width: 100%; position: absolute; top: -40px; left: 0; z-index: -1">
                        @else
                            <p>Image not available</p>
                        @endif

                    </div>

                </div><br>
                <label for="name" style="margin-top: 0px; line-height: 0px">SIGNATURE</label>
                <span style="margin-top: 0px; line-height: 0px">(Lagda)</span>
            </div>
            <div class="form-group">
                <div class="label-container">
                    <label for="dealers" style="font-size: 12px">TPS or CPR/SIGNATURE: </label>
                    <div class="underline" style="width: 150px"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label-container">
                    <label for="dealers" style="font-size: 12px">AM/SIGNATURE: </label>
                    <div class="underline" style="width: 150px"></div>
                </div>
            </div>
        </form>
    </div>
    <div class="footer">
        <img src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path('images/effooter.jpg'))) }}"
            alt="Logo">
    </div>
    <div style="page-break-before: always;">
        <div class="header">
            <img src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path('images/efheader2.jpg'))) }}"
                alt="Logo">
        </div>
        <div class="">
            <table>
                <thead>
                    <tr>
                        <th>Activity</th>
                        <th>Timing</th>
                        <th>Remarks</th>
                        <th>Observation</th>
                        <th>Signature</th>
                    </tr>
                </thead>
                @php
                    $activities = collect($monitoring_data);
                @endphp
                <tbody class="big-padding">
                    @foreach ($first_activity as $a)
                        @php
                            $activity = $activities->where('activity_id', '=', $a->activity_id)->first();
                        @endphp
                        <tr>
                            <td>{{ $a->title }}</td>
                            <td>{{ $activity->timing ?? '' }}</td>
                            <td>{{ $activity->remarks ?? '' }}</td>
                            <td>{{ $activity->observation ?? '' }}</td>
                            <td>{{ $activity->signature ?? '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div
                style="width: 90%; margin: 0 auto; text-align: center;font-size: 12px;font-weight: bold;margin-top: 20px">
                <p>Please record all pesticides used in the participating farm with corresponding dosage rate and timing
                </p>
            </div>

            <table style="width: 85%">
                <thead style="font-size: 12px;font-weight: bold;">
                    <tr>
                        <th>PRODUCT</th>
                        <th>PEST/DISEASE</th>
                        <th>RATE 16LI/WATER</th>
                        <th>FERTILIZER</th>
                        <th>TIMING OF APPLICATION</th>
                    </tr>
                </thead>
                <tbody class="small-padding">
                    @if($monitoring->isEmpty())
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @else
                        @foreach ($monitoring as $m)
                            <tr>
                                <td>{{ $m->product }}</td>
                                <td>{{ $m->pest_disease }}</td>
                                <td>{{ $m->rate_water }}</td>
                                <td>{{ $m->fertilizer }}</td>
                                <td>{{ $m->timing }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div style="position: absolute; right: 80px; bottom: 50px; z-index: 2">
        <div class="form-group">
            <div class="label-container" class="no-lh">
                <label for="dealers" style="font-size: 12px" class="no-lh">TPS or CPR/SIGNATURE: </label>
                <div class="underline no-lh" style="width: 153px"></div>
            </div>
        </div>
        <div class="form-group">
            <div class="label-container" class="no-lh">
                <label for="dealers" style="font-size: 12px" class="no-lh">AM/SIGNATURE: </label>
                <div class="underline no-lh" style="width: 200px"></div>
            </div>
        </div>
        <div class="form-group">
            <div class="label-container" class="no-lh">
                <label for="dealers" style="font-size: 12px" class="no-lh">VP for Sales: </label>
                <div class="underline no-lh" style="width: 225px"></div>
            </div>
        </div>
    </div>

    <div class="footer">
        <img src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path('images/effooter2.jpg'))) }}"
            alt="Logo">
    </div>
    <div style="page-break-before: always;">
        <div class="header">
            <img src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path('images/efheader3.jpg'))) }}"
                alt="Logo">
        </div>
        <table class="form-info">
            <tr>
                <th>Name of TPS:</th>
                <td>
                    @if (isset($profile->technician))
                        {{ $profile->technician->full_name ?? '' }}
                    @endif
                </td>
            </tr>
            <tr>
                <th>Participant:</th>
                <td>
                    @if (isset($profile->farmer))
                        {{ $profile->farmer->full_name ?? '' }}
                    @endif
                </td>
            </tr>
            <tr>
                <th>Area:</th>
                <td>{{ $profile->area }}</td>
            </tr>
            <tr>
                <th>Location:</th>
                <td>{{ $profile->location }}</td>
            </tr>
            <tr>
                <th>Duration:</th>
                <td>{{ $profile->duration }}</td>
            </tr>
            <tr>
                <th>Jackpot Batch No.:</th>
                <td>{{ $profile->batch }}</td>
            </tr>
        </table>

        <table class="form-activity">
            <thead>
                <tr>
                    <th>Activity</th>
                    <th>Date</th>
                    <th>Timing</th>
                    <th>Remarks</th>
                    <th>Observation</th>
                    <th>Signature</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($second_activity as $a)
                    @php
                        $activity = $activities->where('activity_id', '=', $a->activity_id)->first();
                    @endphp
                    <tr>
                        <td>{{ $a->title }}</td>
                        <td>{{ $activity->timing ?? '' }}</td>
                        <td>{{ $activity->timing ?? '' }}</td>
                        <td>{{ $activity->remarks ?? '' }}</td>
                        <td>{{ $activity->observation ?? '' }}</td>
                        <td>
                            @if (isset($activity->signature))
                                @if (file_exists(public_path($activity->signature)))
                                    <img src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path($activity->signature))) }}"
                                        alt="Signature" style="width: 80%;">
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    <div class="footer">
        <img src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path('images/effooter.jpg'))) }}"
            alt="Logo">
    </div>
</body>

</html>
