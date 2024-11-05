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
	                    <li class="breadcrumb-item active">Edit Question
	                    </li>
	                </ol>
	            </div>
	        </div>
	    </div>
	</div>
   
    <div class="row">
		<div class=" col-xl-6 col-lg-8 col-md-12">
			<form method="POST" action="{{ route('questions.update',$id) }}">
				@method('PUT')
				@csrf
				<div class="card data-table">
					<div class="card-header">
					  <div class="heading-text">
					    <h4 class="m-0"><i class="fas fa-plus mr-2"></i>&nbsp;{{ __('Create New Question') }}</h4>
					  </div>
					</div>
					<!-- /.card-header -->
					
					<div class="card-body mt-2 px-5" id="form-body">
							<div class="row mb-1">
								<div class="col-sm-3 text-right">
									<label 
									for="staticEmail" 
									class="col-form-label fw-bold">
										Field Name *
									</label>
								</div>
								<div class="col-sm-7">
									<div class="input-group">
								    	<span 
								    	class="input-group-text rounded-0">
									    	<i class="fas fa-tag mr-2"></i>
									    </span>
								      <input 
								      type="text" 
								      name="field_name" 
								      class="form-control rounded-0 {{ $errors->has('field_name') ? ' is-invalid' : '' }}" 
								      id="field_name"
								      value="{{ $question['field_name'] }}">
								    </div>
								    @if ($errors->has('field_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('field_name') }}</strong>
                                        </span>
                                    @endif
								</div>
							</div>

							<div class="row mb-1">
								<div class="col-sm-7 offset-sm-3">
									<div class="form-check">
										<input 
										class="form-check-input" 
										type="checkbox" 
										id="required_field" 
										name="required_field"
										{{ $question['required_field'] == 1 ? 'checked' : '' }}
										>
										<label class="form-check-label" for="required_field">
										Required
										</label>
									</div>

								</div>
							</div>

							<div class="row mb-1">
								<div class="col-sm-7 offset-sm-3">
									<div class="form-check">
										<input 
										class="form-check-input" 
										type="checkbox" 
										id="conditional" 
										name="conditional"
										{{ $question['conditional'] == 1 ? 'checked' : '' }}>
										<label class="form-check-label" for="conditional">
										Conditional Question?
										</label>
									</div>

								</div>
							</div>

							

							<div class="row mb-1 {{ $question['conditional'] == 0 ? 'd-none' : '' }}" id="question_list_div">
								<div class="col-sm-3 text-right">
									<label 
									for="staticEmail" 
									class="col-form-label fw-bold" 
									id="questionnaire_label">
										Questionnaire List *
									</label>
								</div>
								
								<div class="col-sm-7">
									<select 
									class="form-select rounded-0" 
									name="questionnaire" 
									id="questionnaire" 
									aria-label="Default select example">
										<option selected disabled>Select Questionnaire</option>
										@foreach($questionnaires as $questionnaire)
											<option value="{{ $questionnaire->id }}" {{ $question['questionnaire_id'] == $questionnaire->id ? 'selected' : '' }}>{{ $questionnaire->title }}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="row mb-1 ">
								<div class="col-sm-3 text-right">
									<label 
									for="staticEmail" 
									class="col-form-label fw-bold"
									id="field_type_label">
										Field Type *
									</label>
								</div>
								<div class="col-sm-7">
									<select 
									class="form-select rounded-0 {{ $errors->has('field_type') ? ' is-invalid' : '' }}" 
									name="field_type" 
									id="field_type" 
									aria-label="Default select example">
										<option selected disabled>Select Field Type</option>
										<option value="Textbox" {{ $question['field_type'] == 'Textbox' ? 'selected' : '' }}>Textbox</option>
										<option value="Dropdown" {{ $question['field_type'] == 'Dropdown' ? 'selected' : '' }}>Dropdown</option>
										<option value="Checkbox" {{ $question['field_type'] == 'Checkbox' ? 'selected' : '' }}>Checkbox</option>
										<option value="Radio Button" {{ $question['field_type'] == 'Radio Button' ? 'selected' : '' }}>Radio Button</option>
										<option value="Date Picker" {{ $question['field_type'] == 'Date Picker' ? 'selected' : '' }}>Date Picker</option>
										<option value="Ratings" {{ $question['field_type'] == 'Ratings' ? 'selected' : '' }}>Ratings</option>
										<option value="Image" {{ $question['field_type'] == 'Image' ? 'selected' : '' }}>Image</option>
										<option value="Coordinates" {{ $question['field_type'] == 'Coordinates' ? 'selected' : '' }}>Coordinates</option>
									</select>
								</div>
								@if ($errors->has('field_type'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('field_type') }}</strong>
                                    </span>
                                @endif
							</div>

							@if(!empty($question['sub_field_type']->choices))
								@foreach($question['sub_field_type']->choices as $choice)
									@if($loop->first)
										<div class="row mb-1">
											<div class="col-sm-3 text-right">
												<label 
												for="staticEmail" 
												class="col-form-label fw-bold" 
												id="sub_field_type_label">
													{{ $question['field_type'] == 'Checkbox' || $question['field_type'] == 'Radio Button' || $question['field_type'] == 'Dropdown' || $question['field_type'] == 'Ratings' ? 'Choices *' : 'Sub-Field Type *' }}
												</label>
											</div>
											<div class="col-sm-7" id="append_sub">
												@if($question['field_type'] == 'Checkbox' || $question['field_type'] == 'Radio Button' || $question['field_type'] == 'Dropdown' || $question['field_type'] == 'Ratings')
													<div class="input-group">
														<span class="input-group-text rounded-0">
															<i class="fas fa-list mr-2"></i>
														</span>
														<input type="text" name="sub_field_type[]" class="form-control rounded-0" id="sub_field_type" value="{{ $choice }}">
													</div>
												@else
												<select class="form-select rounded-0" name="sub_field_type[]" id="sub_field_type" aria-label="Default select example">
													<option selected="" disabled="">Select Sub-Field Type</option>
													<option value="Short Text" {{ $choice == 'Short Text' ? 'selected' : '' }}>Short Text</option>
													<option value="Long Text" {{ $choice == 'Long Text' ? 'selected' : '' }}>Long Text</option>
													<option value="Number" {{ $choice == 'Number' ? 'selected' : '' }}>Number</option>
												</select>
												@endif
											</div>

											@if ($errors->has('sub_field_type'))
			                                    <span class="invalid-feedback" role="alert">
			                                        <strong>{{ $errors->first('sub_field_type') }}</strong>
			                                    </span>
			                                @endif
										</div>
									@else
										<div class="row mb-1 additional_option">
											<div class="col-sm-7 offset-sm-3" id="append_sub">
												@if($question['field_type'] == 'Checkbox' || $question['field_type'] == 'Radio Button' || $question['field_type'] == 'Dropdown' || $question['field_type'] == 'Ratings')
													<div class="input-group">
														<span class="input-group-text rounded-0">
															<i class="fas fa-list mr-2"></i>
														</span>
														<input type="text" name="sub_field_type[]" class="form-control rounded-0" id="sub_field_type" value="{{ $choice }}">
													</div>
												@else

												@endif
											</div>
											<div class="col-sm-1 d-flex align-items-center"><i class="fas fa-times mr-2 remove_btn text-danger"></i></div>
										</div>
									@endif
									
									
								@endforeach
							@else
								<div class="row mb-1 d-none">
									<div class="col-sm-3 text-right">
										<label 
										for="staticEmail" 
										class="col-form-label fw-bold" 
										id="sub_field_type_label">
											Sub-Field Type *
										</label>
									</div>
									<div class="col-sm-7" id="append_sub">
										
									</div>

									@if ($errors->has('sub_field_type'))
	                                    <span class="invalid-feedback" role="alert">
	                                        <strong>{{ $errors->first('sub_field_type') }}</strong>
	                                    </span>
	                                @endif
								</div>
							@endif

							

							{{-- <div class="row mb-1">
								<div class="col-sm-3 text-right">
									<label 
									for="staticEmail" 
									class="col-form-label fw-bold" 
									id="sub_field_type_label">
										{{ $question['field_type'] == 'Checkbox' || $question['field_type'] == 'Radio Button' || $question['field_type'] == 'Dropdown' || $question['field_type'] == 'Ratings' ? 'Choices *' : 'Sub-Field Type *' }}
									</label>
								</div>
								<div class="col-sm-7" id="append_sub">

								</div>

								@if ($errors->has('sub_field_type'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('sub_field_type') }}</strong>
                                    </span>
                                @endif
							</div> --}}
						
					</div>
					<!-- /.card-body -->
					<div class="card-footer d-flex justify-content-center">
						<a href="{{ route('questions.index') }}" class="btn btn-secondary me-1">Cancel</a>
						<button type="button" id="add_option_btn" class="btn btn-info me-1 d-none">Add Option</button>
						<button type="submit" class="btn btn-success">Submit</button>
					</div>
				</div>
				<!-- /.card -->
			</form>
		</div>
   </div>    
  <!-- /.container-fluid -->
</section>

@endsection

@push('page_script')
	<script src="{{ asset('js/pages/questions/add.js') }}"></script>
	<script>
		$(".form-select").select2();
		 $(document).on('select2:open', () => {
    	document.querySelector('.select2-search__field').focus();
  		});
	</script>
@endpush