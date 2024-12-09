<div class="tab-pane fade" id="content-techno">
    <div class="container-fluid px-6 pt-6">
        <div class="row">
            <div class="col-12">
                <div class="row row-cols-1 row-cols-md-3">
                    <div class="col h-auto">
                        <div class="card rounded-3 shadow-sm">
                            <div class="card-body p-1">
                                <div class="card m-0">
                                    <a style="text-decoration: none;" href="{{ route('farmers.index') }}">
                                        <div class="d-flex py-2 px-2">
                                            <div class="me-2">
                                                <div class="p-2 rounded-circle" style="background-color: #28c76f;">
                                                    <i data-feather="droplet"
                                                        style="width: 30px; height: 30px; color:white;"></i>
                                                </div>
                                            </div>
                                            <div class="my-auto text-left">
                                                <p class="mb-0" style="font-size: 20px;font-weight: bold" >Rice Derby</p>
                                                <h1 class="fw-bolder mb-0"></h1>
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
                                    <a style="text-decoration: none;" href="{{ route('farmers.index') }}">
                                        <div class="d-flex py-2 px-2">
                                            <div class="me-2">
                                                <div class="p-2 rounded-circle" style="background-color: #28c76f;">
                                                    <i data-feather="shopping-cart"
                                                        style="width: 30px; height: 30px; color:white;"></i>
                                                </div>
                                            </div>
                                            <div class="my-auto text-left">
                                                <p class="mb-0" style="font-size: 20px;font-weight: bold" >Commercial Demo</p>
                                                <h1 class="fw-bolder mb-0"></h1>
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
                                    <a style="text-decoration: none;" href="{{ route('farmers.index') }}">
                                        <div class="d-flex py-2 px-2">
                                            <div class="me-2">
                                                <div class="p-2 rounded-circle" style="background-color: #28c76f;">
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

                </div>
            </div>
        </div>
    </div>
</div>