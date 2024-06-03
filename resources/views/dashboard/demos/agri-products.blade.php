<div class="tab-pane fade" id="demo1" style="padding-right: 10px;">

            <div class="row">
                <div class="col-md-7">
                    <div class="card rounded-3 shadow-sm d-none">
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
                            <h4 class="mb-1">Agri-Products</h4>
                            @include('dashboard.demo-map-viewer')
                            <div class="legend" id="legend"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
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

                    <div class="card rounded-3 shadow-sm">
                        <div class="card-body">
                            <figure class="highcharts-figure">
                                <div id="area_planted"></div>
                            </figure>
                        </div>
                    </div>

                    <div class="card rounded-3 shadow-sm">
                        <div class="card-body">
                            <figure class="highcharts-figure">
                                <div id="variety_planted"></div>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>