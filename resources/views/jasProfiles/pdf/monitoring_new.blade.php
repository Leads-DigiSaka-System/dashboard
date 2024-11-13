<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JAS MONITORING Form</title>
    <style type="text/css">
        @page {
            margin: 15px 0px 30px 0px;
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
        footer {
            position: fixed; 
            bottom: 9px; 
            left: -10px; 
            right: 0px;
            height: 25px; 
        }

        table {
            width: 90%;
            border-collapse: collapse;
            margin: 0 auto;
        }
        th {
            background-color: #f0ea3e;
            color: black;
        }

        th,
        td {
            border: 1px solid #858585;
            text-align: center;
            padding: 8px;
            font-size: 12px;
        }

        .form-info tr th {
            width: 30%;
            font-size: 14px;
            font-weight: bold;
        }

        table.form-activity tbody>tr>td:first-child {
            width: 25% !important;
            text-transform: uppercase;
            padding-top: 50px;
            padding-bottom: 50px;
        }

        table.form-activity {
            margin-bottom: 30px;
        }

        .form-activity {
            margin-top: 35px;
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

        .form-group .underline {
            border-bottom: 1px solid black;
            display: inline-block;
            /* padding-left: 50px; */
            text-align: center;
        }
    </style>
</head>

<body>

    <footer>
        <table style="width:100%;">
            <tr>
                <td style="text-align:left;border: 0">
                    <img style="width:90%;" src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path('images/effooter_new.png'))) }}"
                alt="Logo">
                </td>
            </tr>
        </table>
    </footer>

    <div>
        <table style="width:90%;">
            <tr>
                <td  style="border:0 !important; text-align:left; padding-left:50px;">
                    <img style="width:50%;" src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path('images/leadsAgri.png'))) }}"
                alt="Logo">
                </td>
                <td  style="border:0 !important; text-align: right;">
                    <img style="width:50%;" src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path('images/jasLogo.png'))) }}"
                alt="Logo">
                </td>
            </tr>
        </table>

        <table class="form-info" style="width:90%;">
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
                @php
                    $activities = collect($monitoring_data);
                @endphp
                @foreach ($second_activity as $a)
                    @php
                        $activity = $activities->where('activity_id', '=', $a->activity_id)->first();
                    @endphp
                    <tr>
                        @if($loop->iteration > 3)
                            <td style="padding-top:100px;padding-bottom: 100px;">{{ $a->title }}</td>
                        @else
                            <td>{{ $a->title }}</td>
                        @endif
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

                @foreach ($first_activity as $a)
                    @php
                        $activity = $activities->where('activity_id', '=', $a->activity_id)->first();
                    @endphp
                    <tr>
                        @if($loop->iteration >= $loop->count - 1 )
                            <td>{{ $a->title }}</td>
                        @else
                            <td style="padding-top:100px;padding-bottom: 100px;">{{ $a->title }}</td>
                        @endif
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

        <div
            style="width: 90%; margin: 0 auto; text-align: center;font-size: 20px;margin-top: 20px">
            <p>Please record all pesticides used in the participating farm with corresponding dosage rate and timing
            </p>
        </div>

        <table style="width: 90%">
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

        <table style="width: 90%; margin-top: 35px;">
            <tr>
                <td style="text-align:left; padding-left:15px; font-size: 14px; font-weight: bold; border:0px;" width="50%">
                    Monitored By:
                </td>
                <td width="50%" style="text-align:left; font-size: 14px; font-weight: bold; border:0px;">Noted By:</td>
            </tr>
            <tr>
                <td style="border:0px;">&nbsp;</td>
                <td style="text-align:left; border:0px;">
                    <div class="form-group">
                        <label >Area Manager:</label>
                        <div class="underline" style="width: calc(100% - 170px);"></div>
                    </div>
                </td>
            </tr>

            <tr>
                <td style="text-align:left; border:0px;">
                    <div class="form-group">
                        <label >Sales Representative:</label>
                        <div class="underline" style="width: calc(100% - 170px);"></div>
                    </div>
                </td>
                <td style="text-align:left; border:0px;">
                    <div class="form-group">
                        <label >Regional Manager:</label>
                        <div class="underline" style="width: calc(100% - 170px);"></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="border:0px;">&nbsp;</td>
                <td style="text-align:left; border:0px;">
                    <div class="form-group">
                        <label>VP Sales for Visayas</label>
                        <div class="underline" style="width: calc(100% - 170px);"></div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
