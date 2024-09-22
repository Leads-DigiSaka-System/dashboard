@extends('layouts.admin')

@section('title')
    Webinar Management
@endsection

@push('page_style')
    <!-- Include Flatpickr CSS -->
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">

   
@endpush

@section('content')
    <!-- Main content -->
    <section>
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Webinars</li>
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
                            <h4 class="m-0"><i class="fas fa-video mr-2"></i>&nbsp;{{ __('Webinars') }}</h4>
                        </div>
                        <div class="text-right">
                            <button id="createWebinar" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add Webinar
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="webinarTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th data-orderable="false">Link</th>
                                    <th>Status</th>
                                    <th>Start Date</th>
                                    <th>Image</th>
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

        <div class="modal fade" id="webinarModal" tabindex="-1" role="dialog" aria-labelledby="webinarModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="webinarModalLabel">Add Webinar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="webinarForm">
                            @csrf
                            {{-- <input type="hidden" name="_method" id="method" value="PATCH"> --}}
                            <input type="hidden" id="webinarId" name="webinarId">
                            <div class="form-group mt-1">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="form-group mt-1">
                                <label for="type">Type</label>
                                <select class="form-control" id="type" name="type" required>
                                    <option value="0">Webinar</option>
                                    <option value="1">Conference</option>
                                </select>
                            </div>
                            <div class="form-group mt-1">
                                <label for="link">Link</label>
                                <input type="url" class="form-control" id="link" name="link" required>
                            </div>
                            <div class="form-group mt-1">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="2">Not Started</option>
                                    <option value="1">Active</option>
                                    <option value="0">Finished</option>
                                </select>
                            </div>
                            <div class="form-group mt-1">
                                <label for="start_date">Start Date</label>
                                <input type="datetime-local" class="form-control" id="start_date" name="start_date"
                                    required>
                            </div>
                            <div class="form-group mt-1">
                                <label for="image_source">Image</label>
                                <input type="file" class="form-control" id="image_source" name="image_source"
                                    accept="image/*">
                            </div>
                            <div class="text-right mt-3">
                                <button type="submit" class="btn btn-primary" id="saveWebinar">Save Webinar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('page_script')
        @include('include.dataTableScripts')
         <!-- Include Flatpickr JS -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        <script src="{{ asset('js/pages/webinars/index.js') }}"></script>
    @endpush
@endsection
