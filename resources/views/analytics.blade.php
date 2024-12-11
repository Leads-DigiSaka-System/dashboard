@extends('layouts.admin')

@section('title') Dashboard @endsection

@section('header_scripts')
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/accessibility.js"></script>
@endsection

@section('content')
	
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<select class="form-select" id="activity">
								<option disabled selected>Select Activity</option>
								<option value="all">All</option>
								@if(!$activities->isEmpty())
									@foreach($activities as $activity)
										<option value="{{ $activity->activity_id }}">{{ $activity->title }}</option>
									@endforeach
								@endif
							</select>
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<select class="form-select" id="area">
								<option disabled selected>Select Area</option>
								<option value="all">All</option>
								@if(!$jas_area->isEmpty())
									@foreach($jas_area as $area)
										<option value="{{ $area }}">{{ $area }}</option>
									@endforeach
								@endif
							</select>
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<select class="form-select" id="product">
								<option disabled selected>Select Product used</option>
								<option value="all">All</option>
								@if(!$jas_product->isEmpty())
									@foreach($jas_product as $product)
										<option value="{{ $product }}">{{ $product }}</option>
									@endforeach
								@endif
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<div class="row" id="append_analytics">
			{{-- @foreach($data as $arr)
        		<div class="col-md-6">
        			<div class="card">
        				<div class="card-body">
        					<div class="row">
	        					<div class="col-md-12 text-center">
	                                <h3>{{ $arr['title'] }}</h3>
	                            </div>

	                            <div class="col-md-6">
	                            	<figure class="highcharts-figure">
			                            <div id="{{ $arr['div_id'] }}_timing"></div>
			                        </figure>
	                            </div>
	                            
	                            <div class="col-md-6">
	                            	<figure class="highcharts-figure">
			                            <div id="{{ $arr['div_id'] }}_observation"></div>
			                        </figure>
	                            </div>
	                        </div>
        				</div>
        			</div>
        		</div>
        	@endforeach --}}
		</div>
    </div>
@endsection

@push('page_script')
	<script src="{{ asset('js/analytics.js') }}"></script>
@endpush