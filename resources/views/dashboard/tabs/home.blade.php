<div class="tab-pane fade " id="content5" style="padding-right: 10px;">
            <div class="row">
                <div class="col-md-6">
                    
                    <div class="card rounded-3 shadow-sm">
                        <div class="card-body">
                            <div class="row pb-3">
                                <div class="col-md-12 d-flex justify-content-end">
                                    <div class="col-md-2">
                                        <select class="form-control" id="recom_year">
                                            <option value="2024">2024</option>
                                            <option value="2023">2023</option>
                                            <option value="2022">2022</option>
                                            <option value="2021">2021</option>
                                            <option value="2020">2020</option>
                                        </select>  
                                    </div>
                                    
                                </div>
                            </div>
                            <figure class="highcharts-figure">
                                <div id="recommendations"></div>
                            </figure>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card rounded-3 shadow-sm">
                        <div class="card-body">
                            {{-- <div class="row pb-3">
                                <div class="col-md-12 d-flex justify-content-end">
                                    <div class="col-md-2">
                                        <select class="form-control" id="recom_year">
                                            <option value="2024">2024</option>
                                            <option value="2023">2023</option>
                                            <option value="2022">2022</option>
                                            <option value="2021">2021</option>
                                            <option value="2020">2020</option>
                                        </select>  
                                    </div>
                                    
                                </div>
                            </div> --}}
                            <figure class="highcharts-figure">
                                <div id="surveys_conducted"></div>
                            </figure>
                        </div>
                    </div>

                </div>

                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card rounded-3 shadow-sm">
                                <div class="card-body">
                                    <div class="row pb-3">
                                        <div class="col-md-6">
                                            <h4>Total Number of Farmers Registered</h4>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            <h2>{{ number_format('2615750') }}</h2>
                                        </div>
                                    </div>
                                    <figure class="highcharts-figure">
                                        <div id="registered_farmers"></div>
                                    </figure>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card rounded-3 shadow-sm">
                                <div class="card-body">
                                    <div class="row pb-3">
                                        <div class="col-md-6">
                                            <h4>Total Number of Farmer with ID Card</h4>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            <h2>{{ number_format('8244') }}</h2>
                                        </div>
                                    </div>
                                    <figure class="highcharts-figure">
                                        <div id="farmers_id"></div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-4">
                    <div class="col h-auto">
                        <div class="card rounded-3 shadow-sm">
                            <div class="card-body p-1">
                                <div class="card bg-black m-0">
                                    <div class="text-center pt-1 text-white fw-bold">Total Area Measured</div>
                                    <div class="d-flex justify-content-center pt-1">

                                        <div class="me-2">
                                            <div class="">
                                                <i data-feather="map-pin" style="width: 30px; height: 30px; color:white;"></i>
                                            </div>
                                        </div>
                                        <div class="my-auto text-left">
                                            <p class="mb-0 fw-bolder fs-2 text-white" style="font-size: 20px;">266,504.53</p>
                                            <h1 class="fw-bolder mb-0" style="font-size: 3rem;"></h1>
                                        </div>
                                    </div>
                                    <div class="text-center pt-0 text-white fw-bold">(hectares)</div>

                                    <div class="text-end pt-2 px-1 text-white fw-bold">View Details</div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col h-auto">
                        <div class="card rounded-3 shadow-sm">
                            <div class="card-body p-1">
                                <div class="card bg-success m-0">
                                    <div class="text-center pt-1 text-white fw-bold">Number of SMS Provided To Farmers</div>
                                    <div class="d-flex justify-content-center pt-1">

                                        <div class="me-2">
                                            <div class="">
                                                <i data-feather="mail" style="width: 30px; height: 30px; color:white;"></i>
                                            </div>
                                        </div>
                                        <div class="my-auto text-left">
                                            <p class="mb-0 fw-bolder fs-2 text-white" style="font-size: 20px;">2,084,253</p>
                                            <h1 class="fw-bolder mb-0"  style="font-size: 3rem;"></h1>
                                        </div>
                                    </div>

                                    <div class="text-end pt-2 px-1 text-white fw-bold">View Details</div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col h-auto">
                        <div class="card rounded-3 shadow-sm">
                            <div class="card-body p-1">
                                <div class="card bg-warning m-0">
                                    <div class="text-center pt-1 text-white fw-bold">Total Number of Registered Users</div>
                                    <div class="d-flex justify-content-center pt-1">

                                        <div class="me-2">
                                            <div class="">
                                                <i data-feather="user" style="width: 30px; height: 30px; color:white;"></i>
                                            </div>
                                        </div>
                                        <div class="my-auto text-left">
                                            <p class="mb-0 fw-bolder fs-2 text-white" style="font-size: 20px;">17,487</p>
                                            <h1 class="fw-bolder mb-0" style="font-size: 3rem;"></h1>
                                        </div>
                                    </div>

                                    <div class="text-end pt-2 px-1 text-white fw-bold">View Details</div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div> --}}
            </div>
        </div>

