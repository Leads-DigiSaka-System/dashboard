@extends('templates.app')
@section('title')
    Dashboard
@endsection

@section('header_css')
    <style>
        .gm-style .gm-style-iw-c {
            max-height: 500px !important;
        }

        /*#content9 {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            grid-auto-rows: 10px;
            gap: 10px;
        }*/

        .grid-item {
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            box-sizing: border-box;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 5px;
        }

        .grid-item:nth-child(1) {
            grid-row: span 15;
        }

        .grid-item:nth-child(2) {
            grid-row: span 20;
        }

        .grid-item:nth-child(3) {
            grid-row: span 25;
        }

        .grid-item:nth-child(4) {
            grid-row: span 18;
        }

        .grid-item:nth-child(5) {
            grid-row: span 12;
        }

        .grid-item:nth-child(6) {
            grid-row: span 15;
        }

        .grid-item:nth-child(7) {
            grid-row: span 13;
        }

        .grid-item:nth-child(8) {
            grid-row: span 14;
        }

        .grid-item:nth-child(9) {
            grid-row: span 10;
        }

        #showCalendar {
            position: absolute;
            width: 100%;
            height: 100%;
            cursor: pointer;
            z-index: 1000;
            top: 0;
            left: 0;
            transition: background-color 0.3s ease;
            /* Add a transition for smooth fading */
        }

        #showCalendar:hover {
            background-color: rgba(156, 156, 156, 0.13);
            /* Change background color on hover */
        }
    </style>
@endsection
@section('header_scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Button trigger modal -->
                <ul class="nav nav-tabs" id="myTabs" style="background: #fff;">
                    {{-- <li class="nav-item dropdown">
                        <a class="nav-link navs active" data-bs-toggle="dropdown" href="#" role="button"
                            aria-expanded="false">
                            Home
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item navs" data-bs-toggle="tab" href="#content1">Data and Maps</a></li>
                            <li><a class="dropdown-item navs" data-bs-toggle="tab" href="#content5">Summary</a></li>
                        </ul>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link navs active" id="tab5" data-toggle="tab" href="#content1">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link navs" id="tab5" data-toggle="tab" href="#content5">Data Summary</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link navs" id="tab5" data-toggle="tab" href="#content6">Map Explorers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link navs" id="tab9" data-toggle="tab" href="#content9">Geospatial AI
                            Solutions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link navs" id="tab-techno" data-toggle="tab" href="#content-techno">Techno-Demo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link navs" id="tab-techno" data-toggle="tab" href="#demo9">
                            JAS <img src="/images/jasLogo.png" style="width:50px;    margin-left: 5px;" />
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link navs" id="tab1" data-toggle="tab" href="#content1">Summary</a>
                    </li> --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link navs" data-bs-toggle="dropdown" href="#" role="button"
                            aria-expanded="false">
                            Activities
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item navs" id="tab4" data-bs-toggle="tab"
                                    href="#demo1">Agri-Products</a></li>
                            <li><a class="dropdown-item navs" data-bs-toggle="tab" href="#demo2">Rice Derby</a></li>
                            <li><a class="dropdown-item navs" data-bs-toggle="tab" href="#demo3">Financing Program</a></li>
                            <li><a class="dropdown-item navs" data-bs-toggle="tab" href="#demo4">Commercial Demo</a></li>
                            <li><a class="dropdown-item navs" data-bs-toggle="tab" href="#demo5">Corporate Farming</a></li>
                            <li><a class="dropdown-item navs" data-bs-toggle="tab" href="#demo6">Provincial Rice Techno
                                    Forum</a></li>
                            <li><a class="dropdown-item navs" data-bs-toggle="tab" href="#demo7">Recipient /
                                    Beneficiary</a></li>
                            <li><a class="dropdown-item navs" data-bs-toggle="tab" href="#demo8">Progress and Results</a>
                            </li>
                            <li><a class="dropdown-item navs" data-bs-toggle="tab" href="#demo10">Product Trials</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">

                        <a class="nav-link navs" data-toggle="tab" id="tab10" href="#content8" aria-expanded="false">
                            Other Field Activities
                        </a>
                        <ul class="dropdown-menu">
                            {{-- <li><a class="dropdown-item navs" id="tab4" data-bs-toggle="tab" href="#content8">Field Tour</a></li>
                            <li><a class="dropdown-item navs" data-bs-toggle="tab" href="#content8">Farmer's day</a></li>
                            <li><a class="dropdown-item navs" data-bs-toggle="tab" href="#content8">Harvest Festival</a></li>
                            <li><a class="dropdown-item navs" data-bs-toggle="tab" href="#content8">Sibuyas Festival</a></li>
                            <li><a class="dropdown-item navs" data-bs-toggle="tab" href="#content8">Lakbay Palay</a></li> --}}
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link navs" data-bs-toggle="dropdown" href="#" role="button"
                            aria-expanded="false">
                            Agri Data PH
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link navs" id="tab5" data-toggle="tab" href="#content11">Reports</a></li>
                            <li><a class="nav-link navs" id="tab5" data-toggle="tab" href="#content12">Infographics</a>
                            </li>
                            <li><a class="nav-link navs" id="tab5" data-toggle="tab" href="#content13">Webinars</a>
                            </li>
                        </ul>
                    </li>
                    {{-- <li class="nav-item dropdown">
                        <a class="nav-link navs" data-bs-toggle="dropdown" href="#" role="button"
                            aria-expanded="false">
                            Survey Results
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link navs" id="tab2" data-toggle="tab" href="#content2">Version 1</a></li>
                            <li><a class="nav-link navs" id="tab2" data-toggle="tab" href="#content10">Version 2</a></li>
                        </ul>
                    </li> --}}
                    {{-- <li class="nav-item">
                        <a class="nav-link navs" id="tab3" data-toggle="tab" href="#content3">Rice Derby</a>
                    </li> --}}
                </ul>
            </div>
        </div>
    </div>
    <div class="tab-content">
        @include('dashboard.tabs.home')
        @include('dashboard.tabs.links')
        @include('dashboard.tabs.other_activities')
        @include('dashboard.tabs.techno-demo')
        <div class="tab-pane fade active show" id="content1">
            <div class="container-fluid px-6 pt-6">
                <div class="row">
                    <div class="col-lg-8 col-md-12">
                        <div class="row row-cols-1 row-cols-md-3">
                            <div class="col h-auto">
                                <div class="card rounded-3 shadow-sm">
                                    <div class="card-body p-1">
                                        <div class="card m-0">
                                            <a style="text-decoration: none;" href="{{ route('farmers.index') }}">
                                                <div class="d-flex py-2 px-2">
                                                    <div class="me-2">
                                                        <div class="p-2 rounded-circle"
                                                            style="background-color: #28c76f;">
                                                            <i data-feather="user"
                                                                style="width: 30px; height: 30px; color:white;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="my-auto text-left">
                                                        <p class="mb-0" style="font-size: 17px;">Farmers Registered</p>
                                                        <h1 class="fw-bolder mb-0">{{ number_format($users) }}</h1>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-footer p-1 text-center">
                                        <p class="m-0"><span class="font-weight-bold"
                                                style="color: #28c76f;">{{ $farmerPercent . '%' }}</span>
                                            than
                                            last
                                            week</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col h-auto">
                                <div class="card rounded-3 shadow-sm">
                                    <div class="card-body p-1">
                                        <div class="card m-0">
                                            <a style="text-decoration: none;" href="{{ route('farms.index') }}">
                                                <div class="d-flex py-2 px-2">
                                                    <div class="me-2">
                                                        <div class="p-2 rounded-circle"
                                                            style="background-color: #ffc107;">
                                                            <i data-feather="grid"
                                                                style="width: 30px; height: 30px; color:white;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="my-auto text-left">
                                                        <p class="mb-0" style="font-size: 17px;">Farms Digitized</p>
                                                        <h1 class="fw-bolder mb-0">{{ $farms }}</h1>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-footer p-1 text-center">
                                        <p class="m-0"><span class="font-weight-bold"
                                                style="color: #28c76f;">{{ $farmPercent . '%' }}</span>
                                            than
                                            last
                                            week</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col h-auto">
                                <div class="card rounded-3 shadow-sm">
                                    <div class="card-body p-1">
                                        <div class="card m-0">
                                            <a style="text-decoration: none;" href="{{ route('survey.index') }}">
                                                <div class="d-flex py-2 px-2">
                                                    <div class="me-2">
                                                        <div class="p-2 rounded-circle"
                                                            style="background-color: #4bc79d;">
                                                            <i data-feather="pie-chart"
                                                                style="width: 30px; height: 30px; color:white;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="my-auto text-left">
                                                        <p class="mb-0" style="font-size: 17px;">Surveyed for farm
                                                            practices</p>
                                                        <h1 class="fw-bolder mb-0">{{ $survey }}</h1>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-footer p-1 text-center">
                                        <p class="m-0"><span class="font-weight-bold"
                                                style="color: #28c76f;">{{ $surveyPercent . '%' }}</span>
                                            than
                                            last
                                            week</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col h-auto">
                                <div class="card rounded-3 shadow-sm">
                                    <div class="card-body p-1">
                                        <div class="card bg-secondary m-0">
                                            <div class="text-center pt-1 text-white fw-bold">Total Area Measured</div>
                                            <div class="d-flex justify-content-center pt-1">

                                                <div class="me-2">
                                                    <div class="">
                                                        <i data-feather="map-pin"
                                                            style="width: 30px; height: 30px; color:white;"></i>
                                                    </div>
                                                </div>
                                                <div class="my-auto text-left">
                                                    <p class="mb-0 fw-bolder fs-2 text-white" style="font-size: 20px;">
                                                        266,504.53</p>
                                                    <h1 class="fw-bolder mb-0" style="font-size: 3rem;"></h1>
                                                </div>
                                            </div>
                                            <div class="text-center pt-0 pb-1 text-white fw-bold">(hectares)</div>

                                        </div>
                                    </div>
                                    <div class="card-footer p-1 text-center">
                                        <p class="m-0"><span class="font-weight-bold"
                                                style="color: #28c76f;">{{ $surveyPercent . '%' }}</span>
                                            than
                                            last
                                            week</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col h-auto">
                                <div class="card rounded-3 shadow-sm">
                                    <div class="card-body p-1">
                                        <div class="card bg-success m-0">
                                            <div class="text-center pt-1 text-white fw-bold">No. of SMS</div>
                                            <div class="d-flex justify-content-center pt-1">

                                                <div class="me-2">
                                                    <div class="">
                                                        <i data-feather="mail"
                                                            style="width: 30px; height: 30px; color:white;"></i>
                                                    </div>
                                                </div>
                                                <div class="my-auto text-left">
                                                    <p class="mb-0 fw-bolder fs-2 text-white" style="font-size: 20px;">
                                                        266,504</p>
                                                    <h1 class="fw-bolder mb-0" style="font-size: 3rem;"></h1>
                                                </div>
                                            </div>
                                            <div class="text-center pt-0 pb-1 text-white fw-bold">&nbsp;</div>

                                        </div>
                                    </div>
                                    <div class="card-footer p-1 text-center">
                                        <p class="m-0"><a>More details >></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card rounded-3 shadow-sm">
                            <div class="card-body">
                                <div class="row pb-1">
                                </div>
                                <figure class="highcharts-figure">
                                    <div id="reco_sum"></div>
                                </figure>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-8">
                        @if (!empty($allFarms))
                            @include('dashboard.map-viewer')
                        @endif
                        <div class="card rounded-3 shadow-sm">
                            <div class="p-2">
                                <h4 class="">Latest Farmers</h4>
                                <div class="table-wrap table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <th>{{ __('ID') }}</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Phone') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Date Added') }}</th>
                                        </thead>

                                        <tbody>
                                            @if ($latest_farmers)
                                                @foreach ($latest_farmers as $farmer)
                                                    <tr>
                                                        <td>{{ $loop->index + 1 }}</td>
                                                        <td>{{ $farmer->full_name }}</td>
                                                        <td>{{ $farmer->phone_number }}</td>
                                                        <td><span
                                                                class="badge badge-light-{{ $farmer->getStatusBadge() }}">{{ $farmer->getStatus() }}</span>
                                                        </td>
                                                        <td>{{ $farmer->created_at->format('M d, Y') }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        @if (!empty($randomFarms))
                            <div class="card mb-1">
                                <div class="card-body">
                                    <h3 class="text-center">Featured Farms</h3>
                                </div>
                            </div>
                            @foreach ($randomFarms as $rand)
                                <div class="card mb-1">
                                    <div class="card-body py-0">
                                        <div class="row">
                                            <div class="col-md-5 d-flex justify-content-center align-items-center">
                                                <div class="row row-cols-1 ">
                                                    <div class="col text-center h2">
                                                        Farm Unique ID
                                                    </div>
                                                    <div class="col text-center h1 text-danger">
                                                        {{ $rand->farm_id }}
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-5 d-flex justify-content-center align-items-center">
                                                @foreach (explode(',', $rand->farm_image) as $image)
                                                    <a href="{{ asset('') }}{{ $image }}"
                                                        target="_blank"><img
                                                            src="{{ asset('') }}{{ $image }}"
                                                            alt="Farm Image" width="150px" height="150px"
                                                            style="padding: 5px;"></a>
                                                @endforeach
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        @endif

                    </div>
                    <div class="col-md-6 col-lg-4">

                        <div class="card rounded-3 shadow-sm">
                            <div class="p-2">
                                @include('dashboard.calendar')
                            </div>
                        </div>
                        {{-- <div class="card rounded-3 shadow-sm">
                            <div class="p-2">
                                <h4 class="">Top Performing Technician</h4>
                                @foreach ($top_performers as $performer)
                                <div class="d-flex flex-row w-100 pt-2 justify-content-between align-items-center">
                                    
                                    <div class="d-flex align-items-center">
                                        <div class="h-3 w-3 bg-success rounded-circle" style="padding:5px;"></div>
                                        <div style="width: 5px;"></div>
                                        <span>{{ $performer->first_name . ' ' . $performer->last_name }}</span>
                                    </div>
                                    <div class="align-items-left">
                                        <span class="font-weight-bold">{{ $performer->user_count }}</span>
                                        <span class="font-weight-light">farmers</span>
                                    </div>

                                </div>
                                @endforeach
                            </div>
                        </div> --}}
                        <div class="card rounded-3 shadow-sm">
                            <div class="p-2">
                                <h4 class="">Registered farmers</h4>
                                @foreach ($registeredFarmers as $farmer)
                                    <div class="d-flex flex-row w-100 pt-2 justify-content-between align-items-center">

                                        <div class="d-flex align-items-center">
                                            <div class="h-3 w-3 bg-success rounded-circle" style="padding:5px;"></div>
                                            <div style="width: 5px;"></div>
                                            <span>{{ $farmer->first_name . ' ' . $farmer->last_name }}</span>
                                        </div>
                                        {{-- <div class="align-items-left">
                                            @php
                                                $crop = explode(',', json_encode(json_decode($farmer->crops)));
                                            @endphp
                                            <span class="font-weight-bold">{{ implode(', ', $crop) }}</span>
                                        </div> --}}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-12">
                            <div class="col-md-12 col-lg-12">
                                <div class="card rounded-3 shadow-sm">
                                    <div class="card-body">
                                        <a class="twitter-timeline" data-lang="en" data-height="800"
                                            href="https://twitter.com/dost_pagasa?ref_src=twsrc%5Etfw">Tweets by
                                            dost_pagasa</a>
                                        <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-12">
                            <div class="card rounded-3 shadow-sm">
                                <div class="p-2">
                                    <h4 class="">Latest Farms</h4>
                                    <div class="table-wrap table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <th>{{ __('ID') }}</th>
                                                <th>{{ __('Farmer Name') }}</th>
                                                <th>{{ __('Farm ID') }}</th>
                                            </thead>

                                            <tbody>
                                                @if ($latest_farms)
                                                    @foreach ($latest_farms as $farm)
                                                        <tr>
                                                            <td>{{ $loop->index + 1 }}</td>
                                                            <td>{{ $farm->farmerDetails->full_name ?? 'N/A' }}</a></td>
                                                            <td>{{ $farm->farm_id }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="content2">

            <div class="row">
                <div class="col-md-6">
                    <div class="card rounded-3 shadow-sm">
                        <div class="card-body">
                            <figure class="highcharts-figure">
                                <div id="age"></div>
                            </figure>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card rounded-3 shadow-sm">
                        <div class="card-body">
                            <figure class="highcharts-figure">
                                <div id="gender"></div>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-6">
                    <div class="card rounded-3 shadow-sm">
                        <div class="p-2">
                            <figure class="highcharts-figure">
                                <div id="farmCount"></div>
                            </figure>
                        </div>
                    </div>

                    <div class="card rounded-3 shadow-sm">
                        <div class="p-2">
                            <figure class="highcharts-figure">
                                <div id="farmOwnership"></div>
                            </figure>
                        </div>
                    </div>

                    <div class="card rounded-3 shadow-sm">
                        <div class="p-2">
                            <figure class="highcharts-figure">
                                <div id="farmEquip"></div>
                            </figure>
                        </div>
                    </div>

                    <div class="card rounded-3 shadow-sm">
                        <div class="p-2">
                            <figure class="highcharts-figure">
                                <div id="farmIrrigated"></div>
                            </figure>
                        </div>
                    </div>

                    <div class="card rounded-3 shadow-sm">
                        <div class="p-2">
                            <figure class="highcharts-figure">
                                <div id="harvest"></div>
                            </figure>
                        </div>
                    </div>

                    <div class="card rounded-3 shadow-sm">
                        <div class="p-2">
                            <figure class="highcharts-figure">
                                <div id="seedType"></div>
                            </figure>
                        </div>
                    </div>

                    <div class="card rounded-3 shadow-sm">
                        <div class="p-2">
                            <figure class="highcharts-figure">
                                <div id="cropPractice"></div>
                            </figure>
                        </div>
                    </div>

                    <div class="card rounded-3 shadow-sm">
                        <div class="p-2">
                            <figure class="highcharts-figure">
                                <div id="fertilizer"></div>
                            </figure>
                        </div>
                    </div>

                    <div class="card rounded-3 shadow-sm">
                        <div class="p-2">
                            <figure class="highcharts-figure">
                                <div id="farmProblem"></div>
                            </figure>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="card rounded-3 shadow-sm">
                        <div class="p-2">
                            <figure class="highcharts-figure">
                                <div id="farmNotice"></div>
                            </figure>
                        </div>
                    </div>

                    <div class="card rounded-3 shadow-sm">
                        <div class="p-2">
                            <figure class="highcharts-figure">
                                <div id="commonPest"></div>
                            </figure>
                        </div>
                    </div>

                    <div class="card rounded-3 shadow-sm">
                        <div class="p-2">
                            <figure class="highcharts-figure">
                                <div id="sell"></div>
                            </figure>
                        </div>
                    </div>

                    <div class="card rounded-3 shadow-sm">
                        <div class="p-2">
                            <figure class="highcharts-figure">
                                <div id="priceFactor"></div>
                            </figure>
                        </div>
                    </div>

                    <div class="card rounded-3 shadow-sm">
                        <div class="p-2">
                            <figure class="highcharts-figure">
                                <div id="appBased"></div>
                            </figure>
                        </div>
                    </div>

                    <div class="card rounded-3 shadow-sm">
                        <div class="p-2">
                            <figure class="highcharts-figure">
                                <div id="initiatives"></div>
                            </figure>
                        </div>
                    </div>

                    <div class="card rounded-3 shadow-sm">
                        <div class="p-2">
                            <figure class="highcharts-figure">
                                <div id="phoneClass"></div>
                            </figure>
                        </div>
                    </div>

                    <div class="card rounded-3 shadow-sm">
                        <div class="p-2">
                            <figure class="highcharts-figure">
                                <div id="smartphoneApp"></div>
                            </figure>
                        </div>
                    </div>

                    <div class="card rounded-3 shadow-sm">
                        <div class="p-2">
                            <figure class="highcharts-figure">
                                <div id="farmGroupApp"></div>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="content3">
            <div class="row mb-3 p-2 ml-0" style="background: #fff;">
                <div class="col-md-2" style="display: flex; align-items: center;">
                    <i data-feather="filter" style="margin-right: 5px;"></i>
                    <p class="mb-0" style="font-weight: 700;">Filter options:</p>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="region" onchange="fetchProvinceFilters()">
                        <option value="">Select Region</option>
                        @foreach ($filters['regions'] as $region)
                            <option value="{{ $region }}">{{ 'Region ' . $region }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="province" onchange="applyFilters()">
                        <option value="">Select Province</option>
                    </select>
                </div>
            </div>

            <div class="container-fluid px-0 pt-6">
                <!-- Add filter dropdowns -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card rounded-3 shadow-sm">
                            <div class="card-body">
                                <figure class="highcharts-figure">
                                    <div id="area_planted_old"></div>
                                </figure>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card rounded-3 shadow-sm">
                            <div class="card-body">
                                <figure class="highcharts-figure">
                                    <div id="variety_planted_old"></div>
                                </figure>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-6">
                                <div class="card rounded-3 shadow-sm">
                                    <div class="card-body">
                                        <figure class="highcharts-figure">
                                            <div id="crop_stand"></div>
                                        </figure>
                                    </div>
                                </div>
                            </div> -->
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="content9">
            <div class="container-fluid">
                <div class="row row-cols-md-3 row-cols-lg-6">
                    <div class="col grid-item">
                        <strong>1. Extent maps and production area</strong>
                        <ul>
                            <li>Rice, Maize, Sugarcane, Coconut, Oil Palm</li>
                            <li>Cash crops and Root crops</li>
                            <li>Any other crop of interest</li>
                        </ul>
                    </div>
                    <div class="col grid-item">
                        <strong>2. Tree counts, area and yield</strong>
                        <ul>
                            <li>Banana</li>
                            <li>Mango</li>
                            <li>Pineapple</li>
                            <li>Coffee</li>
                        </ul>
                    </div>
                    <div class="col grid-item">
                        <strong>3. Climate and hydrological variables</strong>
                        <ul>
                            <li>Meteorological drought risk</li>
                            <li>Agricultural drought risk</li>
                            <li>Combined drought index</li>
                            <li>Impact-based forecasts</li>
                        </ul>
                    </div>
                    <div class="col grid-item">
                        <strong>4. Yield maps and forecast</strong>
                        <ul>
                            <li>Rice</li>
                            <li>Vegetables</li>
                        </ul>
                    </div>
                    <div class="col grid-item">
                        <strong>5. Cropping season advisories</strong>
                        <ul>
                            <li>Irrigation demand and scheduler</li>
                            <li>Rice age and harvest date</li>
                        </ul>
                    </div>
                    <div class="col grid-item">
                        <strong>6. Crop suggestions based on production area dynamics and value chain</strong>
                        <ul>
                            <li>Upcoming cropping season</li>
                            <li>In-between cropping season</li>
                        </ul>
                    </div>
                    <div class="col grid-item">
                        <strong>7. Crop resiliency indices</strong>
                        <ul>
                            <li>Disaster agricultural damage assessment tool</li>
                            <li>Risk Scores and crop insurance options</li>
                        </ul>
                    </div>
                    <div class="col grid-item">
                        <strong>8. Market information</strong>
                        <ul>
                            <li>Market price listings</li>
                            <li>Commodity price forecasts</li>
                            <li>POS system</li>
                        </ul>
                    </div>
                    <div class="col grid-item">
                        <strong>9. Suitability mapping</strong>
                        <ul>
                            <li>Any crop of interest</li>
                            <li>High yield trial sites</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- <div class="grid-item">
                <strong>1. Extent maps and production area</strong>
                <ul>
                    <li>Rice, Maize, Sugarcane, Coconut, Oil Palm</li>
                    <li>Cash crops and Root crops</li>
                    <li>Any other crop of interest</li>
                </ul>
            </div>
            <div class="grid-item">
                <strong>2. Tree counts, area and yield</strong>
                <ul>
                    <li>Banana</li>
                    <li>Mango</li>
                    <li>Pineapple</li>
                    <li>Coffee</li>
                </ul>
            </div>
            <div class="grid-item">
                <strong>3. Climate and hydrological variables</strong>
                <ul>
                    <li>Meteorological drought risk</li>
                    <li>Agricultural drought risk</li>
                    <li>Combined drought index</li>
                    <li>Impact-based forecasts</li>
                </ul>
            </div>
            <div class="grid-item">
                <strong>4. Yield maps and forecast</strong>
                <ul>
                    <li>Rice</li>
                    <li>Vegetables</li>
                </ul>
            </div>
            <div class="grid-item">
                <strong>5. Cropping season advisories</strong>
                <ul>
                    <li>Irrigation demand and scheduler</li>
                    <li>Rice age and harvest date</li>
                </ul>
            </div>
            <div class="grid-item">
                <strong>6. Crop suggestions based on production area dynamics and value chain</strong>
                <ul>
                    <li>Upcoming cropping season</li>
                    <li>In-between cropping season</li>
                </ul>
            </div>
            <div class="grid-item">
                <strong>7. Crop resiliency indices</strong>
                <ul>
                    <li>Disaster agricultural damage assessment tool</li>
                    <li>Risk Scores and crop insurance options</li>
                </ul>
            </div>
            <div class="grid-item">
                <strong>8. Market information</strong>
                <ul>
                    <li>Market price listings</li>
                    <li>Commodity price forecasts</li>
                    <li>POS system</li>
                </ul>
            </div>
            <div class="grid-item">
                <strong>9. Suitability mapping</strong>
                <ul>
                    <li>Any crop of interest</li>
                    <li>High yield trial sites</li>
                </ul>
            </div> --}}
        </div>

        @include('dashboard.demos.agri-products')
        @include('dashboard.demos.rice-derby')
        @include('dashboard.demos.financing')
        @include('dashboard.demos.commercial')
        @include('dashboard.demos.corporate')
        @include('dashboard.demos.provincial')
        @include('dashboard.demos.recipient')
        @include('dashboard.demos.progress')

        @include('jasProfiles.index')
        @include('dashboard.demos.product-trials')
        {{-- @include('dashboard.tabs.survey_v2') --}}

        @include('jasProfiles.modal')



    </div>

@endsection

@section('footer_scripts')
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('app.map_key') }}&libraries=geometry" async defer>
    </script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
@endsection
@push('scripts')
    @include('include.dataTableScripts')
    <script src="{{ asset('js/pages/jas/index.js') }}?v={{ time() }}"></script>

    @include('dashboard.chartScript')
    @include('dashboard.chart_v2_script')
    <script>
         window.onload = function() {
            // fetchDistinctFilters();
            fetchProvinceFilters();
            setDropdownEventListeners();
        };


        $(document).on('click', '.navs', function() {
            const elems = document.querySelectorAll('.navs');

            elems.forEach((item) => item.classList.remove("active"));

            $(this).addClass('active')
        })

        function setDropdownEventListeners() {
            document.getElementById('region').addEventListener('change', function() {
                fetchProvinceFilters('region');
            });
        }

        function fetchProvinceFilters(selectedFilter) {
            var region = document.getElementById('region').value;
            var province = document.getElementById('province').value;

            $.get('/dashboard/getDistinctFilters', {
                    region: region,
                    province: province
                })
                .done(function(data) {
                    updateFilterOptions(data, selectedFilter);
                    applyFilters();
                })
                .fail(function(error) {
                    console.error('Error fetching distinct filters:', error);
                });
        }

        function updateFilterOptions(filters, selectedFilter) {
            var provinceDropdown = document.getElementById('province');
            updateDropdownOptions(provinceDropdown, filters.provinces);
        }

        function updateDropdownOptions(dropdown, options) {
            var selectedValue = dropdown.value;

            dropdown.innerHTML = '<option value="">Select ' + dropdown.id.charAt(0).toUpperCase() + dropdown.id.slice(1) +
                '</option>';

            options.forEach(function(option) {
                var optionElement = document.createElement('option');
                optionElement.value = option;
                optionElement.text = option;
                dropdown.add(optionElement);
            });

            dropdown.value = selectedValue;
        }

        function applyFilters() {
            var region = document.getElementById('region').value;
            var province = document.getElementById('province').value;

            axios.get('/dashboard/getAreaPlantedPerVariety', {
                    params: {
                        region,
                        province
                    }
                })
                .then(function(response) {
                    updateAreaPlantedChart(response.data);
                })
                .catch(function(error) {
                    console.error('Error fetching Area Planted data:', error);
                });
            var flag = '';
            if (region && province) {
                flag = ' Province';
            } else if (region) {
                flag = ' Region';
            } else {
                flag = ' Region';
            }
            axios.get('/dashboard/getVarietyPlantedPerRegion', {
                    params: {
                        region,
                        province
                    }
                })
                .then(function(response) {
                    updateVarietyPlantedChart(response.data, flag);
                })
                .catch(function(error) {
                    console.error('Error fetching Variety Planted data:', error);
                });
        }

        function updateAreaPlantedChart(data) {
            // const data = response.data; // Assuming the data is present in the 'data' property of the response

            // Create the Highcharts pie chart with dynamic data
            Highcharts.chart('area_planted', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'No of Questions Answered'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                credits: {
                    enabled: false
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            distance: -70, // Adjust the distance of the data labels from the pie slices
                            filter: {
                                property: 'percentage',
                                operator: '>',
                                value: 4 // Display data labels only if the percentage is greater than 4
                            },
                            style: {
                                textOutline: 'none',
                            }
                        }
                    }
                },
                series: [{
                    name: 'Variety',
                    data: data.categories.map(function(category, index) {
                        return {
                            name: category,
                            y: data.data[index]
                        };
                    })
                }]
            });
        }

        function updateVarietyPlantedChart(data, flag) {
            // const data = response.data;
            var categories = data.categories;
            var inputData = data.series;

            // Transform the data
            const seriesData = inputData.reduce((result, dataPoint) => {
                Object.entries(dataPoint).forEach(([name, value], index) => {
                    if (!result[index]) {
                        result[index] = {
                            name: name,
                            data: []
                        };
                    }
                    result[index].data.push(value);
                });
                return result;
            }, []);

            const stringCategories = data.categories.map(category => category.toString());

            // Use Highcharts to create a column chart
            Highcharts.chart('variety_planted', { // Use 'variety_planted' as the ID
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Variety Planted per' + flag
                },
                xAxis: {
                    "categories": categories
                },
                credits: {
                    enabled: false
                },
                yAxis: {
                    title: {
                        text: 'Total Area (ha)'
                    }
                },
                "series": seriesData,
            });
        }
        $(document).ready(function() {
            // When #tab4 is clicked, trigger a click on #filter
            $('#tab4').on('click', function() {
                console.log('test');

                $('#filter').click();
            });

            $('#tab10').on('click', function() {
                $('#other_content1').addClass('active show');
            });
        });
        //count demo performed when filter is clicked
        $('#filter').on('click', function() {
            var product = $('#product').val();
            var region = $('#region_demo').val();
            var province = $('#province_demo').val();
            loadDemoMap(product, region, province);
            // axios.get('/dashboard/getDemoPerformed/' + product + '/' + region + '/' + province).then(response => {
            //     $('#demoPerformed').text(response.data);
            // });
            // axios.get('/dashboard/getSampleUsed/' + product + '/' + region + '/' + province).then(response => {
            //     $('#sampleUsed').text(response.data);

            //     // Load Google Map and add markers
            //     loadDemoMap(product, region, province);
            // });
        });


        function loadDemoMap(product, region, province) {
            // Initialize Google Map
            const map = new google.maps.Map(document.getElementById('demo_farm_location'), {
                center: {
                    lat: 12.8797,
                    lng: 121.7740
                },
                zoom: 6,
            });

            var currentInfoWindow = null;
            var farm_location = '';
            var legendContent = '<div class="legend-title">Legend</div>';
            axios.get('/dashboard/getAgriProducts').then(response => {
                var points = response.data.points;
                // Add markers to the map
                $('#demoPerformed').text(response.data.demo_performed);
                $('#sampleUsed').text(response.data.sample_used);
                points.forEach(point => {
                    // Ensure that latitude and longitude are valid numbers
                    var latitude = parseFloat(point.image_latitude);
                    var longitude = parseFloat(point.image_longitude);

                    if (!isNaN(latitude) && !isNaN(longitude)) {
                        var markerColor;


                        var marker = new google.maps.Marker({
                            position: {
                                lat: latitude,
                                lng: longitude
                            },
                            map: map,
                            title: point.farm_id,
                            icon: {
                                url: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQx0y1Ensv9-dF8rpNkXhfAEfQnyWF4kXMoE_OyWbI8GQ&s', //'http://maps.google.com/mapfiles/ms/icons/purple-dot.png', // URL to the purple marker icon
                                scaledSize: new google.maps.Size(40,
                                    40), // Adjust the size if needed
                                origin: new google.maps.Point(0, 0), // origin
                                anchor: new google.maps.Point(0, 0) // anchor
                            },
                        });

                        // Create farm images HTML
                        var farmImagesHTML = '';
                        point.farm_image.split(',').forEach(function(image) {

                            farmImagesHTML += '<a href="' + image +
                                '" target="_blank"><img src="https://digisaka.info/' +
                                image +
                                '" alt="Farm Image" width="150px" style="padding: 5px;"></a>';
                        });
                        var demoDate = new Date(point.created_at);
                        var formattedDate = demoDate.toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });
                        // Optional: Add an info window for each marker to display additional information
                        var infoWindow = new google.maps.InfoWindow({

                            content: `
                                <table width="100%">
                                    <tr>
                                        <td class="fw-bold fs-5" style="width:20%;"> Farm ID:</td>
                                        <td class="fw-bold fs-5"> ${point.farm_id}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold fs-5"> Farm Address:</td>
                                        <td class="fw-bold fs-5"> ${point.farm_location}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold fs-5"> Area:</td>
                                        <td class="fw-bold fs-5"> ${(point.area == null) ? '-': point.area}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold fs-5"> Leads Farmer:</td>
                                        <td class="fw-bold fs-5"> ${point.full_name}</td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="fw-bold fs-5">Demo Date:</td>
                                        <td class="fw-bold fs-5"> ${formattedDate}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold fs-5 d-flex">Feedback:</td>
                                        <td class="fw-bold fs-5"> Lorem Ipsum is simply dummy text of the printing and typesetting industry. .</td>
                                    </tr>
                                </table>
                                <hr/>
                                <table width="100%">
                                    <tr>
                                        <td class="text-center fw-bold fs-5">Before</td>
                                        <td class="text-center fw-bold fs-5">During</td>
                                        <td class="text-center fw-bold fs-5">After</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <a href="https://dummyimage.com/200x300/000/fff&text=No+image+available" target="_blank">
                                                <img src="https://dummyimage.com/200x300/000/fff&text=No+image+available" alt="Farm Image" width="150px" style="padding:5px;"></a>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="https://dummyimage.com/200x300/000/fff&text=No+image+available" target="_blank">
                                                <img src="https://dummyimage.com/200x300/000/fff&text=No+image+available" alt="Farm Image" width="150px" style="padding:5px;"></a>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="https://dummyimage.com/200x300/000/fff&text=No+image+available" target="_blank">
                                                <img src="https://dummyimage.com/200x300/000/fff&text=No+image+available" alt="Farm Image" width="150px" style="padding:5px;"></a>
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                                
                            `,
                            // <div class="map_image" style="text-align: center;">

                            //     </div>
                            maxWidth: 800, // Set the maximum width
                            minHeight: 300, // Set the minimum height
                        });

                        // Attach click event to marker to open info window
                        marker.addListener('click', function() {
                            // Close the current infoWindow if exists
                            if (currentInfoWindow) {
                                currentInfoWindow.close();
                            }

                            // Open the new infoWindow
                            infoWindow.open(map, marker);

                            // Update the currently open infoWindow
                            currentInfoWindow = infoWindow;
                        });

                    } else {
                        console.error('Invalid latitude or longitude:', point);
                    }
                });
                document.getElementById('legend').innerHTML = legendContent;
            });

            /*axios.get('/dashboard/getLegend/').then(response => {
                var legends = response.data;
                legends.forEach(legend => {
                    legendContent += '<div class="legend-entry">' +
                        '<img src="http://maps.google.com/mapfiles/ms/icons/' + legend.colorcode +
                        '-dot.png" alt="Marker" />' +
                        '<span>' + legend.productname + '</span>' +
                        '</div>';
                })
                // Make AJAX request to get points data
                //axios.get('/dashboard/getPoints/' + product + '/' + region + '/' + province).then(response => {
                axios.get('/dashboard/getAgriProducts').then(response => {
                    var points = response.data.points;
                    // Add markers to the map

                    points.forEach(point => {
                        // Ensure that latitude and longitude are valid numbers
                        var latitude = parseFloat(point.image_latitude);
                        var longitude = parseFloat(point.image_longitude);

                        if (!isNaN(latitude) && !isNaN(longitude)) {
                            var markerColor;

                            console.log(latitude,longitude);
                            var marker = new google.maps.Marker({
                                position: {
                                    lat: latitude,
                                    lng: longitude
                                },
                                map: map,
                                title: point.farm_id,
                                icon: {
                                    url: 'http://maps.google.com/mapfiles/ms/icons/purple-dot.png', // URL to the purple marker icon
                                    scaledSize: new google.maps.Size(40,
                                        40) // Adjust the size if needed
                                },
                            });

                            // Create farm images HTML
                            var farmImagesHTML = '';
                            point.farm_image.split(',').forEach(function(image) {
                                console.log(image)
                                farmImagesHTML += '<a href="' + image +
                                    '" target="_blank"><img src="https://digisaka.info/' +
                                    image +
                                    '" alt="Farm Image" width="150px" style="padding: 5px;"></a>';
                            });
                            var demoDate = new Date(point.created_at);
                            var formattedDate = demoDate.toLocaleDateString('en-US', {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            });
                            // Optional: Add an info window for each marker to display additional information
                            var infoWindow = new google.maps.InfoWindow({

                                content: `
                        <table width="100%">
                            <tr>
                                <td class="fw-bold fs-5" style="width:20%;"> Farm ID:</td>
                                <td class="fw-bold fs-5"> ${point.farm_id}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold fs-5"> Farm Address:</td>
                                <td class="fw-bold fs-5"> ${point.farm_location}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold fs-5"> Area:</td>
                                <td class="fw-bold fs-5"> ${(point.area == null) ? '-': point.area}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold fs-5"> Leads Farmer:</td>
                                <td class="fw-bold fs-5"> ${point.full_name}</td>
                            </tr>
                            
                            <tr>
                                <td class="fw-bold fs-5">Demo Date:</td>
                                <td class="fw-bold fs-5"> ${formattedDate}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold fs-5 d-flex">Feedback:</td>
                                <td class="fw-bold fs-5"> Lorem Ipsum is simply dummy text of the printing and typesetting industry. .</td>
                            </tr>
                        </table>
                        <hr/>
                        <table width="100%">
                            <tr>
                                <td class="text-center fw-bold fs-5">Before</td>
                                <td class="text-center fw-bold fs-5">During</td>
                                <td class="text-center fw-bold fs-5">After</td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <a href="https://dummyimage.com/200x300/000/fff&text=No+image+available" target="_blank">
                                        <img src="https://dummyimage.com/200x300/000/fff&text=No+image+available" alt="Farm Image" width="150px" style="padding:5px;"></a>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a href="https://dummyimage.com/200x300/000/fff&text=No+image+available" target="_blank">
                                        <img src="https://dummyimage.com/200x300/000/fff&text=No+image+available" alt="Farm Image" width="150px" style="padding:5px;"></a>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a href="https://dummyimage.com/200x300/000/fff&text=No+image+available" target="_blank">
                                        <img src="https://dummyimage.com/200x300/000/fff&text=No+image+available" alt="Farm Image" width="150px" style="padding:5px;"></a>
                                    </a>
                                </td>
                            </tr>
                        </table>
                        
                    `,
                                // <div class="map_image" style="text-align: center;">

                                //     </div>
                                maxWidth: 800, // Set the maximum width
                                minHeight: 300, // Set the minimum height
                            });

                            // Attach click event to marker to open info window
                            marker.addListener('click', function() {
                                // Close the current infoWindow if exists
                                if (currentInfoWindow) {
                                    currentInfoWindow.close();
                                }

                                // Open the new infoWindow
                                infoWindow.open(map, marker);

                                // Update the currently open infoWindow
                                currentInfoWindow = infoWindow;
                            });

                        } else {
                            console.error('Invalid latitude or longitude:', point);
                        }
                    });
                    document.getElementById('legend').innerHTML = legendContent;
                });
            })*/
        }

        //load the province option when region is changed
        $('#region_demo').on('change', function() {
            var region = $(this).val();
            axios.get('/dashboard/getProvinceByRegion/' + region).then(response => {
                $('#province_demo').empty();
                $('#province_demo').append('<option value="1">All</option>');
                response.data.forEach(element => {
                    $('#province_demo').append('<option value="' + element.provcode + '">' + element
                        .name + '</option>');
                });
            });
        });
        // Highcharts.chart('sample-pie', {
        //     chart: {
        //         type: 'pie'
        //     },
        //     title: {
        //         text: 'Sample Chart'
        //     },
        //     tooltip: {
        //         valueSuffix: '%'
        //     },
        //     subtitle: {
        //         text: 'Source:<a href="https://www.mdpi.com/2072-6643/11/3/684/htm" target="_default">MDPI</a>'
        //     },
        //     plotOptions: {
        //         series: {
        //             allowPointSelect: true,
        //             cursor: 'pointer',
        //             dataLabels: [{
        //                 enabled: true,
        //                 distance: 20
        //             }, {
        //                 enabled: true,
        //                 distance: -40,
        //                 format: '{point.percentage:.1f}%',
        //                 style: {
        //                     fontSize: '1.2em',
        //                     textOutline: 'none',
        //                     opacity: 0.7
        //                 },
        //                 filter: {
        //                     operator: '>',
        //                     property: 'percentage',
        //                     value: 10
        //                 }
        //             }]
        //         }
        //     },
        //     series: [{
        //         name: 'Percentage',
        //         colorByPoint: true,
        //         data: [{
        //                 name: 'Water',
        //                 y: 55.02
        //             },
        //             {
        //                 name: 'Fat',
        //                 sliced: true,
        //                 selected: true,
        //                 y: 26.71
        //             },
        //             {
        //                 name: 'Carbohydrates',
        //                 y: 1.09
        //             },
        //             {
        //                 name: 'Protein',
        //                 y: 15.5
        //             },
        //             {
        //                 name: 'Ash',
        //                 y: 1.68
        //             }
        //         ]
        //     }]
        // });
    </script>
@endpush
