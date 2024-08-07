@extends('layouts.admin')

@section('title')
    JAS Profile
@endsection

@section('content')
    <!-- Main content -->
    <section>
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('jasProfiles.index') }}">JAS Profiles</a></li>
                            <li class="breadcrumb-item active">Profile List</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card data-table">
                    <div class="card-header">
                        <div class="heading-text">
                            <h4 class="m-0"><i class="fas fa-users mr-2"></i>&nbsp;{{ __('JAS Profiles') }}</h4>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="jasProfilesTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Phone</th>
                                    <th>Year</th>
                                    <th>Technician</th>
                                    <th>Area</th>
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
    </section>


    @push('page_script')
        @include('include.dataTableScripts')

        <script src="{{ asset('js/pages/jas/index.js') }}"></script>
    @endpush
@endsection
