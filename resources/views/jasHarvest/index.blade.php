@extends('layouts.admin')

@section('title') 
    JAS Harvest
@endsection

@section('content')
    <section>
        <!-- Breadcrumbs -->
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">JAS Harvest</li>
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
                        <h4 class="m-0">{{ __('JAS Harvest') }}</h4>
                        <a href="{{ route('jasHarvest.export') }}" class="btn btn-success">
                            <i class="fas fa-file-excel"></i> Export to Excel
                        </a>
                    </div>
                    </div>
                    <div class="card-body">
                        {{-- <a href="{{ route('export.items', $ab) }}" class="btn btn-primary">Export Items</a> --}}
                        <table id="jasHarvestTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="10%">#</th>
                                    <th width="20%">Full Name</th>
                                    <th width="20%">Farm Location</th>
                                    <th width="15%">Planting Date</th>
                                    <th width="15%">Harvesting Date</th>
                                    <th width="10%">Method</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <thead>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('jasHarvest.modal.observation')
@endsection

@push('page_script')
    @include('include.dataTableScripts') 
    <script src="{{ asset('js/pages/jasHarvest/index.js') }}"></script>
@endpush
