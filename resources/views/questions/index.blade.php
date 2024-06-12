@extends('layouts.admin')

@section('title')Questions @endsection

@section('content')

<!-- Main content -->
<section>

	<div class="content-header-left col-md-9 col-12 mb-2">
	    <div class="row breadcrumbs-top">
	        <div class="col-12">
	            <div class="breadcrumb-wrapper">
	                <ol class="breadcrumb">
	                    <li class="breadcrumb-item"><a href="{{route('user.home')}}">Home</a>
	                    </li>
	                    <li class="breadcrumb-item"><a href="{{route('questions.index')}}">Questions</a>
	                    </li>
	                    <li class="breadcrumb-item active">Question List
	                    </li>
	                </ol>
	            </div>
	        </div>
	    </div>
	</div>
   
    <div class="row">
		<div class="col-12">
			<div class="card data-table">
				@if($message = Session::get('success'))
					<div class="alert alert-success" role="alert">
			  			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    			<span aria-hidden="true">&times;</span>
			  			</button>
			  			<strong class="d-block d-sm-inline-block-force">Well done!</strong> {{$message}}
					</div><!-- alert -->
				@endif

				@if($message = Session::get('error'))
					<div class="alert alert-danger" role="alert">
			  			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    			<span aria-hidden="true">&times;</span>
			  			</button>
			  			<strong class="d-block d-sm-inline-block-force">Oh Snap!</strong> {{$message}}
					</div><!-- alert -->
				@endif
				
				<div class="card-header">
				  <div class="heading-text">
				    <h4 class="m-0"><i class="fas fa-book mr-2"></i>&nbsp;{{ __('Questions') }}</h4>
				  </div>
				
					<div class="right-side mr-2">
	                	<a href="{{ route('questions.create') }}" class="dt-button btn btn-primary"><i class="fas fa-plus"></i>&nbsp;&nbsp;Create New Question</a>
	            	</div>
				</div>
				<!-- /.card-header -->
				
				<div class="card-body">
					<table id="question_table" class="table table-bordered table-hover">
					  <thead>
					  <tr>
					    <th>#</th>
					    <th>Field Name</th>
					    <th>Field Type / Sub Question</th>
					    <th>Sub-Field Type / Choices Option</th>
					  	<th>Date Created</th>
					  	<th data-orderable="false">Status</th>
					    <th data-orderable="false">Action</th>
					  </tr>
					  </thead>

					</table>
				</div>
				<!-- /.card-body -->

			</div>
			<!-- /.card -->
		</div>
   </div>    
  <!-- /.container-fluid -->
</section>

@endsection

@push('page_script')
	@include('include.dataTableScripts')   
	<script src="{{ asset('js/pages/questions/index.js') }}"></script>
@endpush