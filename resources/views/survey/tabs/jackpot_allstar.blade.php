<div class="tab-pane fade" id="nav-jackpot-allstar">
    <div class="row">
        <div class="col-6">
            <div class="card data-table">
                <div class="card-header">
                    <div class="heading-text">
                        <h4 class="m-0"><i class="fas fa-user-check mr-2"></i>&nbsp;{{ __('Number of Registered Users') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <h1 id="total_number_of_registered_users" class="m-2">{{ number_format($user_count) }}</h1>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card data-table">
                <div class="card-header">
                    <div class="heading-text">
                        <h4 class="m-0"><i class="fas fa-map mr-2"></i>&nbsp;{{ __('Total Farms') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <h1 id="total_number_farms" class="m-2">{{ number_format($farms_count) }}</h1>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card data-table">
                <div class="card-header">
                    <div class="heading-text">
                        <h4 class="m-0"><i class="fas fa-chart-bar mr-2"></i>&nbsp;{{ __('Harvested per Season') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    {{-- <h1 id="harvest_per_season">Sample</h1> --}}
                    <canvas id="harvest_per_season"></canvas>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card data-table">
                <div class="card-header">
                    <div class="heading-text">
                        <h4 class="m-0"><i class="fas fa-users mr-2"></i>&nbsp;{{ __('Registered Users') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <table id="registered_users" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Full Name</th>
                                <th>Phone Number</th>
                                {{-- <th  style="width:50px;">Role</th> --}}
                                <th>Status</th>
                                <th>Registered via App</th>
                                {{-- <th name="registered_by" class="filter">Registered by</th> --}}
                                <th>Registered date</th>
                                {{-- <th>Region</th>
                                <th>Province</th> --}}
                                {{-- <th data-orderable="false">Action</th> --}}
                              </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>

        
    </div>
</div>
