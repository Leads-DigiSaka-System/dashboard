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
	                    <li class="breadcrumb-item"><a href="{{route('survey_set.index')}}">Survey Set</a>
	                    </li>
	                    <li class="breadcrumb-item active">Create New Survey Set
	                    </li>
	                </ol>
	            </div>
	        </div>
	    </div>
	</div>
   
    <div class="row">
    	<form method="POST" action="{{ route('survey_set.update',$id) }}">
			@method('PUT')
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
											<input type="text" name="title" id="title" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ $survey_set['title'] }}">
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
											<textarea type="text" name="description" id="description" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}"
											>{{ $survey_set['description'] }}</textarea>

											@if ($errors->has('description'))
		                                        <span class="invalid-feedback" role="alert">
		                                            <strong>{{ $errors->first('description') }}</strong>
		                                        </span>
		                                    @endif
										</div>
									    
									</div>
								</div>

								@foreach($survey_set['question_data']->question_ids as  $question_id)
									<div class="row mb-1 {{ !$loop->first ? 'additional_option' :'' }}">
										<div class="col-sm-12">
											<div class="form-group">
												<label 
												for="questions" 
												class="fs-5 fw-bold ">
													Question *
												</label>
												@if(!$loop->first)
													<i class="float-end fas fa-times mr-2 remove_btn text-danger fs-3"></i>
												@endif
												<select 
												class="form-select rounded-0 {{ $errors->has('questions') ? ' is-invalid' : '' }}" 
												name="questions[]" 
												id="questions" 
												aria-label="Default select example">
													<option selected disabled>Select Question</option>
													@foreach($questions as $question)
														<option value="{{ $question['id'] }}" {{ $question['id'] == $question_id ? 'selected' :'' }}>{{ $question['field_name'] }}</option>
													@endforeach
												</select>

												@if($loop->first)
													@if ($errors->has('questions'))
				                                        <span class="invalid-feedback" role="alert">
				                                            <strong>{{ $errors->first('questions') }}</strong>
				                                        </span>
				                                    @endif
				                                @endif
											</div>
										    
										</div>
									</div>
								@endforeach
								
							
						</div>
						<!-- /.card-body -->
						<div class="card-footer d-flex justify-content-center">
							<a href="{{ route('survey_set.index') }}" class="btn btn-secondary me-1">Cancel</a>
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