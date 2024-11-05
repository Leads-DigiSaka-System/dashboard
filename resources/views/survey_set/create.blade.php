@extends('layouts.admin')

@section('title')Survey Set @endsection

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
	                </ol>
	            </div>
	        </div>
	    </div>
	</div>
   
    <div class="row">
    	<form method="POST" action="{{ route('survey_set.store') }}">
			@csrf
			<div class=" col-xl-8 col-lg-8 col-md-12">
				
					<div class="card data-table">
						<div class="card-header">
						  <div class="heading-text">
						    <h4 class="m-0"><i class="fas fa-plus mr-2"></i>&nbsp;{{ __('Create New Survey Set') }}</h4>
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
									<div class="col-sm-7">
										<div class="form-check form-check-inline">
										  <input class="form-check-input" 
										  type="radio" 
										  name="farm_categ" 
										  id="farm_categ_personal"
										  value="1" 
										  >
										  <label 
										  class="form-check-label" 
										  for="farm_categ_personal">
										    Personal
										  </label>
										</div>
										<div class="form-check form-check-inline">
										  <input class="form-check-input" 
										  type="radio" 
										  name="farm_categ" 
										  id="farm_categ_farm"
										  value="0"
										  >
										  <label class="form-check-label" 
										  for="farm_categ_farm">
										    Farm
										  </label>
										</div>
									</div>
								</div>

								<div class="row mb-1">
									<div class="col-sm-12">
										<div class="form-group">
											<label 
											for="description" 
											class="fs-5 fw-bold ">
												Expiry Date *
											</label>
											<input type="date" name="expiry_date" class="form-control">

											@if ($errors->has('expiry_date'))
		                                        <span class="invalid-feedback" role="alert">
		                                            <strong>{{ $errors->first('expiry_date') }}</strong>
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
												Questionnaire *
											</label>
											<select 
											class="form-select rounded-0 {{ $errors->has('questionnaires') ? ' is-invalid' : '' }}" 
											name="questionnaires[]" 
											id="questionnaires" 
											aria-label="Default select example">
												<option selected disabled>Select Questionnaires</option>
												@foreach($questionnaires as $questionnaire)
													<option value="{{ $questionnaire['id'] }}">{{ $questionnaire['title'] }}</option>
												@endforeach
											</select>

											@if ($errors->has('questions'))
		                                        <span class="invalid-feedback" role="alert">
		                                            <strong>{{ $errors->first('questionnaires') }}</strong>
		                                        </span>
		                                    @endif
										</div>
									    
									</div>
								</div>
							
						</div>
						<!-- /.card-body -->
						<div class="card-footer d-flex justify-content-center">
							<a href="{{ route('survey_set.index') }}" class="btn btn-secondary me-1">Cancel</a>
							<button type="button" id="add_questionnaire_btn" class="btn btn-info me-1">Add Questionnaire</button>
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
		const questionnaires = {!! json_encode($questionnaires) !!}
	</script>
	<script src="{{ asset('js/pages/survey_set/add.js') }}"></script>
@endpush