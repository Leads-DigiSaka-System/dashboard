<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            width: 100% !important;
            border-collapse: collapse;
            font-size: 8px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
        }

        .header {
            font-weight: bold;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
        }

        .green-background {
            background-color: #90ee90;
        }

        /* Add page breaks after 15 rows */
        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    @foreach ($profiles->groupBy('area') as $location => $locationProfiles)
        <div class="section-title">{{ strtoupper($location) }}</div>

        @php 
            $totalRows = 0; // To keep track of row count for page break
            $no = 1;
        @endphp

        @foreach ($locationProfiles->chunk(15) as $chunkedProfiles)
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Sales Support</th>
                        <th>Enrollment Form</th>
                        <th>Hectarage Size</th>
                        <th>Jackpot Batch no</th>
                        <th>Seed Bed Preparation Phase 1</th>
                        <th>Seed Bed Preparation Phase 2</th>
                        <th>Seed Soaking</th>
                        <th>Seed Sowing</th>
                        <th>Basal Fertilization</th>
                        <th>Transplanting</th>
                        <th>Irrigation</th>
                        <th>1st Top Dress</th>
                        <th>2nd Top Dress</th>
                        <th>3rd Top Dress</th>
                        <th>De-irrigate</th>
                        <th>Harvesting</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach ($chunkedProfiles->groupBy(function($profile) {
                        return $profile->technician;
                    }) as $technician => $technicianProfiles)

                        @php 
                            $rowspan = $technicianProfiles->count(); 
                        @endphp

                        @foreach ($technicianProfiles as $index => $profile)
                            <tr>
                                <td style="text-align: left">{{ $no }}. {{ optional($profile)->first_name ?? '' }} {{ optional($profile)->middle ?? '' }} {{ optional($profile)->last_name ?? '' }}</td>
                                @if ($index == 0)
                                    <td rowspan="{{ $rowspan }}">{{ is_numeric($technician) ?  $profile->technician_profile->full_name ?? 'N/A' : $technician }}</td>
                                @endif
                                <td class="green-background"></td>
                                <td></td>
                                @php
                                    $monitoring = $profile->monitoring;
                                @endphp
                                <td>{{ optional($monitoring->first())->batch ?? '' }}</td>

                                @php
                                    $monitoringData = $profile->monitoringData;
                                @endphp
                                @for ($i = 1; $i <= 12; $i++)
                                    @php
                                        $md = $monitoringData->where('activity_id', $i)->first()->created_at ?? null;
                                        $formattedDate = $md ? date('m-d', strtotime($md)) : '';
                                    @endphp
                                    <td class="{{ $md ? 'green-background' : '' }}">
                                        {{ $formattedDate }}
                                    </td>
                                @endfor
                            </tr>
                            @php
                                $no++;
                                $totalRows++;
                            @endphp
                        @endforeach
                        
                    @endforeach
                </tbody>
            </table>

            @if ($totalRows % 15 === 0)
                <div class="page-break"></div>
            @endif
        @endforeach
        <div class="page-break"></div>
    @endforeach
</body>

</html>
