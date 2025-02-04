<div class="tab-pane fade" id="ghg_tab" style="padding-right: 10px;">
    <div class="row">
        <div class="col-12">
            <div class="card data-table">
                <div class="card-header d-flex">
                    <div class="heading-text me-auto">
                        <h4 class="m-0"><i class="fas fa-users mr-2"></i>&nbsp;{{ __('GHG Profiles') }}</h4>
                    </div>
                </div>

                <div class="card-body">
                    <table id="ghgProfilesTable" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Phone</th>
                                <th>Year</th>
                                <th class="{{ Auth::user()->role == 0 || Auth::user()->role == 1 ? 'filter' : '' }}">
                                    Technician</th>
                                <th>Area</th>
                                <th>Created At</th>
                                <th>Modified At</th>
                                <th data-orderable="false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated by DataTables -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>