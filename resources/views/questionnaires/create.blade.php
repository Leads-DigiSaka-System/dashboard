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
	                    <li class="breadcrumb-item"><a href="{{route('survey.index')}}">Survey</a>
	                    </li>
	                    <li class="breadcrumb-item active">Create New Questionnaire
	                    </li>
	                </ol>
	            </div>
	        </div>
	    </div>
	</div>
   
    <div class="row">
    	<form method="POST" action="{{ route('questionnaires.store') }}">
			@csrf
			<div class=" col-xl-8 col-lg-8 col-md-12">
				
					<div class="card data-table">
						<div class="card-header">
						  <div class="heading-text">
						    <h4 class="m-0"><i class="fas fa-plus mr-2"></i>&nbsp;{{ __('Create New Questionnaire') }}</h4>
						  </div>
						</div>
						<!-- /.card-header -->
						
						<div class="card-body mt-2 px-5" id="form-body">
								<div class="row mb-1">
									<div class="col-sm-12">
										<div class="form-group">
											<label 
											for="title" 
											class="fs-5 fw-bold">
												Title *
											</label>
											<input type="text" name="title" id="title" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}">
											@if ($errors->has('title'))
		                                        <span class="invalid-feedback" role="alert">
		                                            <strong>{{ $errors->first('title') }}</strong>
		                                        </span>
		                                    @endif
										</div>
									    
									</div>
								</div>

								<div class="row mb-1">
									<div class="col-sm-12">
										<div class="form-group">
											<label 
											for="description" 
											class="fs-5 fw-bold ">
												Description *
											</label>
											<textarea type="text" name="description" id="description" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}"></textarea>

											@if ($errors->has('description'))
		                                        <span class="invalid-feedback" role="alert">
		                                            <strong>{{ $errors->first('description') }}</strong>
		                                        </span>
		                                    @endif
										</div>
									    
									</div>
								</div>

								<div class="row mb-1">
									<div class="col-sm-12">
										<div class="form-group">
											<label 
											for="questions" 
											class="fs-5 fw-bold ">
												Question *
											</label>
											<select 
											class="form-select rounded-0 {{ $errors->has('questions') ? ' is-invalid' : '' }}" 
											name="questions[]" 
											id="questions" 
											aria-label="Default select example">
												<option selected disabled>Select Question</option>
												@foreach($questions as $question)
													<option value="{{ $question['id'] }}">{{ $question['field_name'] }}</option>
												@endforeach
											</select>

											@if ($errors->has('questions'))
		                                        <span class="invalid-feedback" role="alert">
		                                            <strong>{{ $errors->first('questions') }}</strong>
		                                        </span>
		                                    @endif
										</div>
									    
									</div>
								</div>
							
						</div>
						<!-- /.card-body -->
						<div class="card-footer d-flex justify-content-center">
							<a href="{{ route('questionnaires.index') }}" class="btn btn-secondary me-1">Cancel</a>
							<button type="button" id="add_question_btn" class="btn btn-info me-1">Add Question</button>
							<button type="submit" class="btn btn-success">Submit</button>
						</div>
					</div>
					<!-- /.card -->
				
			</div>

		</form>
   </div>    
  <!-- /.container-fluid -->
</section>

@endsection

@push('page_script')
	<script>
		const questions = {!! json_encode($questions) !!}
	</script>
	<script src="{{ asset('js/pages/questionnaires/add.js') }}"></script>
@endpush