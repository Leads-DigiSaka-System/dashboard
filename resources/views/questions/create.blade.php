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
	                    <li class="breadcrumb-item active">Create New Question
	                    </li>
	                </ol>
	            </div>
	        </div>
	    </div>
	</div>
   
    <div class="row">
		<div class=" col-xl-6 col-lg-8 col-md-12">
			<form method="POST" action="{{ route('questions.store') }}">
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
								      value="{{ old('field_name') }}">
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
										{{ old('required_field') == "" ? "" : 'checked' }}>
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
										{{ old('conditional') == "" ? "" : 'checked' }}>
										<label class="form-check-label" for="conditional">
										Conditional Question?
										</label>
									</div>

								</div>
							</div>

							

							<div class="row mb-1 d-none" id="question_list_div">
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
											<option value="{{ $questionnaire->id }}">{{ $questionnaire->title }}</option>
										@endforeach
									</select>
								</div>
							</div>
							
							<div class="row mb-1">
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
										<option value="Textbox">Textbox</option>
										<option value="Dropdown">Dropdown</option>
										<option value="Checkbox">Checkbox</option>
										<option value="Radio Button">Radio Button</option>
										<option value="Date Picker">Date Picker</option>
										<option value="Ratings">Ratings</option>
										<option value="Image">Image</option>
										<option value="Coordinates">Coordinates</option>
									</select>
								</div>
								@if ($errors->has('field_type'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('field_type') }}</strong>
                                    </span>
                                @endif
							</div>

							

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
@endpush