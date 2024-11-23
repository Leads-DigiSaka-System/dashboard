@extends('layouts.admin')

@section('title') Dashboard @endsection

@section('header_scripts')
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/accessibility.js"></script>
@endsection

@section('content')
	
	<div class="col-md-12">
		<div class="row">
			@foreach($data as $arr)
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
        	@endforeach
		</div>
    </div>

    <script type="text/javascript">

    	const sample = {!! json_encode($data) !!};

    	for(arr of sample) {

    		if(arr.timing.length !== 0) {
    			Highcharts.chart(`${arr.div_id}_timing`, {
		            chart: {
		                type: 'pie'
		            },
		            title: {
		                text: 'Timing',
		            },
		            plotOptions: {
		            	series: {
		            		allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: [{
							enabled: true,
							distance: 20
						},{
							enabled: true,
					        distance: -40,
					        format: '{point.y:.0f}',
						}]
		            	}
		            },
		            credits: {
		                enabled: false
		            },
		            series: [{
		                name: 'Timing',
		                colorByPoint:true,
		                data: arr.timing,
		            }]
		        });
    		}
    		
    		if(arr.observation.length !== 0) {
    			Highcharts.chart(`${arr.div_id}_observation`, {
		            chart: {
		                type: 'pie'
		            },
		            title: {
		                text: 'Observation',
		            },
		            plotOptions: {
		            	series: {
		            		allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: [{
							enabled: true,
							distance: 20
						},{
							enabled: true,
					        distance: -40,
					        format: '{point.y:.0f}',
						}]
		            	}
		            },
		            credits: {
		                enabled: false
		            },
		            series: [{
		                name: 'Observation',
		                colorByPoint:true,
		                data: arr.observation,
		            }]
		        });
    		}
    	}
	    
    </script>
@endsection