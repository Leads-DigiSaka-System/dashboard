<div class="tab-pane fade" id="demo2" style="padding-right: 10px;">

            <div class="row">
                <div class="col-md-7">
                    <div class="card rounded-3 shadow-sm">
                        <div class="card-body">
                            <h4 class="mb-1">Rice Derby</h4>
                            @include('dashboard.product-map-viewer')
                            <div class="legend" id="product_legend"></div>
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
                                    <h1 class="fw-bolder mb-0" style="font-size: 3rem;">4</h1>
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
                                    <h1 class="fw-bolder mb-0"  style="font-size: 3rem;">14</h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card rounded-3 shadow-sm">
                        <div class="card-body">
                            <figure class="highcharts-figure">
                                <div id="area_planted1"></div>
                            </figure>
                        </div>
                    </div>

                    <div class="card rounded-3 shadow-sm">
                        <div class="card-body">
                            <figure class="highcharts-figure">
                                <div id="variety_planted1"></div>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>