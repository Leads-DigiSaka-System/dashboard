@extends('layouts.admin')

@section('title') JAS Activities @endsection


@section('content')
    
    <section>

        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('user.home')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item active">JAS Activities
                            </li>
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
                            <h4 class="m-0">{{ __('JAS Activities') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                            {{-- <a href="{{ route('export.items',$ab) }}" class="btn btn-primary">Export Items</a> --}}
                        <table id="jasActivitiesTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="10%">#</th>
                                    <th width="70%">Title</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('jasActivities.modal.observation')
@endsection

@push('page_script')

      @include('include.dataTableScripts')   
      <script src="{{ asset('js/pages/jasActivities/index.js') }}"></script>


  @endpush