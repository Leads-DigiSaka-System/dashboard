@extends('templates.app')
@section('title')
    Dashboard
@endsection

@section('header_css')
    <style>
        .gm-style .gm-style-iw-c {
            max-height:500px !important;
        }
    </style>
@endsection
@section('header_scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
@endsection

@section('content')
    <div class="row">
        <!-- Button trigger modal -->
        <ul class="nav nav-tabs" id="myTabs" style="background: #fff; margin-top: -1rem;">
            <li class="nav-item">
                <a class="nav-link active" id="tab5" data-toggle="tab" href="#content5">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab5" data-toggle="tab" href="#content6">Links</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab1" data-toggle="tab" href="#content1">Summary</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab4" data-toggle="tab" href="#content4">Maps</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" id="tab2" data-toggle="tab" href="#content2">Survey Results</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab3" data-toggle="tab" href="#content3">Rice Derby</a>
            </li>
        </ul>
    </div>
    <div class="tab-content">
        @include('dashboard.tabs.home')
        @include('dashboard.tabs.links')
        <div class="tab-pane fade" id="content1">
            <div class="container-fluid px-6 pt-6">
                <div class="row row-cols-1 row-cols-md-3">
                    <div class="col h-auto">
                        <div class="card rounded-3 shadow-sm">
                            <a style="text-decoration: none;" href="{{ route('farmers.index') }}">
                                <div class="d-flex py-2 px-5">
                                    <div class="me-2">
                                        <div class="p-2 rounded-circle" style="background-color: #28c76f;">
                                            <i data-feather="user" style="width: 30px; height: 30px; color:white;"></i>
                                        </div>
                                    </div>
                                    <div class="my-auto text-left">
                                        <p class="mb-0" style="font-size: 17px;">Farmers</p>
                                        <h1 class="fw-bolder mb-0">{{ $users }}</h1>
                                    </div>
                                </div>
                            </a>
                            <hr>
                            <div class="text-center">
                                <p>1pan class="font-weight-bold" style="color: #28c76f;">{{ $farmerPercent . '%' }}</span>
                                    than
                                    last
                                    week</p>
                            </div>
                        </div>
                    </div>
                    <div class="col h-auto">
                        <div class="card rounded-3 shadow-sm">
                            <a style="text-decoration: none;" href="{{ route('farms.index') }}">
                                <div class="d-flex py-2 px-5">
                                    <div class="me-2">
                                        <div class="p-2 rounded-circle" style="background-color: #ffc107;">
                                            <i data-feather="grid" style="width: 30px; height: 30px; color:white;"></i>
                                        </div>
                                    </div>
                                    <div class="my-auto text-left">
                                        <p class="mb-0" style="font-size: 17px;">Farms</p>
                                        <h1 class="fw-bolder mb-0">{{ $farms }}</h1>
                                    </div>
                                </div>
                            </a>
                            <hr>
                            <div class="text-center">
                                <p><span class="font-weight-bold" style="color: #28c76f;">{{ $farmPercent . '%' }}</span>
                                    than last
                                    week</p>
                            </div>
                        </div>
                    </div>
                    <div class="col h-auto">
                        <div class="card rounded-3 shadow-sm">
                            <a style="text-decoration: none;" href="{{ route('survey.index') }}">
                                <div class="d-flex py-2 px-5">
                                    <div class="me-2">
                                        <div class="p-2 rounded-circle" style="background-color: #4bc79d;">
                                            <i data-feather="pie-chart" style="width: 30px; height: 30px; color:white;"></i>
                                        </div>
                                    </div>
                                    <div class="my-auto text-left">
                                        <p class="mb-0" style="font-size: 17px;">Survey</p>
                                        <h1 class="fw-bolder mb-0">{{ $survey }}</h1>
                                    </div>
                                </div>
                            </a>
                            <hr>
                            <div class="text-center">
                                <p><span class="font-weight-bold" style="color: #28c76f;">{{ $surveyPercent . '%' }}</span>
                                    than
                                    last
                                    week</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-8">
                        @if (!empty($allFarms))
                            @include('dashboard.map-viewer')
                        @endif
                        
                        @if(!empty($randomFarms))
                            <div class="card mb-1">
                                <div class="card-body">
                                    <h3 class="text-center">Featured Farms</h3>
                                </div>
                            </div>
                            @foreach($randomFarms as $rand)
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
                                                @foreach(explode(',', $rand->farm_image) as $image)
                                                    <a href="{{ asset('') }}{{ $image }}" target="_blank"><img src="{{ asset('') }}{{ $image }}" alt="Farm Image" width="150px" height="150px" style="padding: 5px;"></a>
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
                                <h4 class="">Top Performing Technician</h4>
                                <div class="d-flex flex-row w-100 pt-2 justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="h-3 w-3 bg-success rounded-circle" style="padding:5px;"></div>
                                        <div style="width: 5px;"></div>
                                        <span>{{ $top_performer->first_name.' '.$top_performer->last_name; }}</span>
                                    </div>
                                    <div class="align-items-left">
                                        <span class="font-weight-bold">{{ $top_performer->user_count }}</span>
                                        <span class="font-weight-light">farmers</span>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                                    <div id="area_planted"></div>
                                </figure>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card rounded-3 shadow-sm">
                            <div class="card-body">
                                <figure class="highcharts-figure">
                                    <div id="variety_planted"></div>
                                </figure>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-md-6">
                        <div class="card rounded-3 shadow-sm">
                            <div class="card-body">
                                <figure class="highcharts-figure">
                                    <div id="crop_stand"></div>
                                </figure>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="content4" style="padding-right: 10px;">
            <div class="row">
                <div class="col-md-3">
                    <div class="card mb-1 shadow-sm rounded-3">
                        <div class="card-body">
                            <select class="form-select" id="map_selection">
                                <option id="demo_map" value="demo_map">Demo</option>
                                <option id="product_map" value="product_map">Product</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            

            <div class="row" id="demo_map_div">
                <div class="col-md-8">
                    <div class="card rounded-3 shadow-sm">
                        <div class="card-body">
                            <h4 class="mb-1">Filters</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label" for="product">Product</label>
                                    <select class="form-select" id="product" name="product">
                                        <option value="All">All</option>
                                        <option value="1">Frontier</option>
                                        <option value="2">Ceres</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="region_demo">Region</label>
                                    <select class="form-select" id="region_demo" name="region_demo">
                                        <option value="All">All</option>
                                        @foreach ($allRegion as $region)
                                            <option value="{{ $region['regcode'] }}">{{ $region['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="province_demo">Province</label>
                                    <select class="form-select" id="province_demo" name="province_demo">
                                        <option value="All">All</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary mt-2" type="button" id="filter">Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card rounded-3 shadow-sm">
                        <div class="card-body">
                            <h4 class="mb-1">Demo Farms Locations</h4>
                            @include('dashboard.demo-map-viewer')
                            <div id="legend"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col h-auto">
                        <div class="card rounded-3 shadow-sm">
                            <div class="d-flex py-2 px-5">
                                <div class="me-2">
                                    <div class="p-2 rounded-circle" style="background-color: #28c76f;">
                                        <i data-feather="calendar" style="width: 30px; height: 30px; color:white;"></i>
                                    </div>
                                </div>
                                <div class="my-auto text-left">
                                    <p class="mb-0" style="font-size: 20px;">Demo Performed</p>
                                    <h1 class="fw-bolder mb-0" id="demoPerformed" style="font-size: 3rem;"></h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col h-auto">
                        <div class="card rounded-3 shadow-sm">
                            <div class="d-flex py-2 px-5">
                                <div class="me-2">
                                    <div class="p-2 rounded-circle" style="background-color: #28c76f;">
                                        <i data-feather="package" style="width: 30px; height: 30px; color:white;"></i>
                                    </div>
                                </div>
                                <div class="my-auto text-left">
                                    <p class="mb-0" style="font-size: 20px;">Sample Used</p>
                                    <h1 class="fw-bolder mb-0" id="sampleUsed" style="font-size: 3rem;"></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="card rounded-3 shadow-sm">
                        <div class="p-2">
                            <figure class="highcharts-figure">
                                <div id="sample-pie"></div>
                            </figure>
                        </div>
                    </div> --}}
                </div>
            </div>

            <div class="row d-none" id="product_map_div">
                <div class="col-md-8">
                    <div class="card rounded-3 shadow-sm">
                        <div class="card-body">
                            <h4 class="mb-1">Product Locations</h4>
                            @include('dashboard.product-map-viewer')
                            <div id="legend"></div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
@endsection

@section('footer_scripts')
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script async src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_KEY') }}&loading=async&&libraries=geometry">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
@endsection
@push('scripts')
    @include('dashboard.chartScript')
    <script>
  window.onload = function () {
        // fetchDistinctFilters();
        fetchProvinceFilters();
        setDropdownEventListeners();
    };

function setDropdownEventListeners() {
    document.getElementById('region').addEventListener('change', function () {
        fetchProvinceFilters('region');
    });
}

    function fetchProvinceFilters(selectedFilter) {
        var region = document.getElementById('region').value;
        var province = document.getElementById('province').value;

        $.get('/dashboard/getDistinctFilters', { region: region, province: province })
        .done(function (data) {
            updateFilterOptions(data, selectedFilter);
            applyFilters();
        })
        .fail(function (error) {
            console.error('Error fetching distinct filters:', error);
        });
    }

    function updateFilterOptions(filters, selectedFilter) {
        var provinceDropdown = document.getElementById('province');
        updateDropdownOptions(provinceDropdown, filters.provinces);
    }

    function updateDropdownOptions(dropdown, options) {
        var selectedValue = dropdown.value;

        dropdown.innerHTML = '<option value="">Select ' + dropdown.id.charAt(0).toUpperCase() + dropdown.id.slice(1) + '</option>';

        options.forEach(function (option) {
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

        axios.get('/dashboard/getAreaPlantedPerVariety', { params: { region, province } })
            .then(function (response) {
                updateAreaPlantedChart(response.data);
            })
            .catch(function (error) {
                console.error('Error fetching Area Planted data:', error);
            });
            var flag = '';
        if (region && province) {
            flag = ' Province';
        } else if (region){
            flag = ' Region';
        } else {
            flag = ' Region';
        }
        axios.get('/dashboard/getVarietyPlantedPerRegion', { params: { region, province } })
            .then(function (response) {
                updateVarietyPlantedChart(response.data, flag);
            })
            .catch(function (error) {
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
                text: 'Area Planted Per Variety'
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
                $('#filter').click();
            });
        });
        //count demo performed when filter is clicked
        $('#filter').on('click', function() {
            var product = $('#product').val();
            var region = $('#region_demo').val();
            var province = $('#province_demo').val();
            axios.get('/dashboard/getDemoPerformed/' + product + '/' + region + '/' + province).then(response => {
                $('#demoPerformed').text(response.data);
            });
            axios.get('/dashboard/getSampleUsed/' + product + '/' + region + '/' + province).then(response => {
                $('#sampleUsed').text(response.data);

                // Load Google Map and add markers
                loadDemoMap(product, region, province);
            });
        });

        $('#map_selection').on('change', function() {
            const value = $(this).val();
            console.log(value)
            if(value == 'demo_map') {
                $('#demo_map_div').removeClass('d-none').addClass('d-flex')
                $('#product_map_div').removeClass('d-flex').addClass('d-none')
            } else {
                $('#product_map_div').removeClass('d-none').addClass('d-flex')
                $('#demo_map_div').removeClass('d-flex').addClass('d-none')
            }
        })

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
            axios.get('/dashboard/getLegend/').then(response => {
                var legends = response.data;
                legends.forEach(legend => {
                    legendContent += '<div class="legend-entry">' +
                    '<img src="http://maps.google.com/mapfiles/ms/icons/' + legend.colorcode + '-dot.png" alt="Marker" />' +
                    '<span>' + legend.productname + '</span>' +
                    '</div>';
                })
            // Make AJAX request to get points data
            axios.get('/dashboard/getPoints/' + product + '/' + region + '/' + province).then(response => {
                var points = response.data;

                // Add markers to the map
                points.forEach(point => {
                    // Ensure that latitude and longitude are valid numbers
                    var latitude = parseFloat(point.location_latitude);
                    var longitude = parseFloat(point.location_longitude);

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
                                url: 'http://maps.google.com/mapfiles/ms/icons/'+point.colorcode+'-dot.png', // URL to the purple marker icon
                                scaledSize: new google.maps.Size(40, 40) // Adjust the size if needed
                            },
                        });

                        // Create farm images HTML
                        var farmImagesHTML = '';
                        point.farm_image.split(',').forEach(function(image) {
                            console.log(image)
                            farmImagesHTML += '<a href="' + image + '" target="_blank"><img src="https://digisaka.info/' +
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
                                        <td class="fw-bold fs-5"> ${point.area}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold fs-5"> Leads Farmer:</td>
                                        <td class="fw-bold fs-5"> ${point.full_name}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold fs-5"> Product:</td>
                                        <td class="fw-bold fs-5"> ${point.productname}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold fs-5"> Quantity:</td>
                                        <td class="fw-bold fs-5"> ${point.quantity}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold fs-5"> Unit:</td>
                                        <td class="fw-bold fs-5"> ${point.unit}</td>
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
        })
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
        Highcharts.chart('sample-pie', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Sample Chart'
            },
            tooltip: {
                valueSuffix: '%'
            },
            subtitle: {
                text: 'Source:<a href="https://www.mdpi.com/2072-6643/11/3/684/htm" target="_default">MDPI</a>'
            },
            plotOptions: {
                series: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: [{
                        enabled: true,
                        distance: 20
                    }, {
                        enabled: true,
                        distance: -40,
                        format: '{point.percentage:.1f}%',
                        style: {
                            fontSize: '1.2em',
                            textOutline: 'none',
                            opacity: 0.7
                        },
                        filter: {
                            operator: '>',
                            property: 'percentage',
                            value: 10
                        }
                    }]
                }
            },
            series: [{
                name: 'Percentage',
                colorByPoint: true,
                data: [{
                        name: 'Water',
                        y: 55.02
                    },
                    {
                        name: 'Fat',
                        sliced: true,
                        selected: true,
                        y: 26.71
                    },
                    {
                        name: 'Carbohydrates',
                        y: 1.09
                    },
                    {
                        name: 'Protein',
                        y: 15.5
                    },
                    {
                        name: 'Ash',
                        y: 1.68
                    }
                ]
            }]
        });


    </script>
@endpush
