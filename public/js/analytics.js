'use strict'

const timingChartScript = function(arr) {
	return {
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
            data: arr,
        }]
    };
}

const observationChartScript = function(arr) {
	return {
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
            data: arr,
        }]
    }
}

const generateDOMElement = function (array) {
	let html = "";

	if(array.length === 0 ) {
		html += `
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
					<h1 class="text-center">No data available</h1>
					</div>
				</div>
			</div>
		`
	} else {
		for(const arr of array ) {
			html += `
				<div class="col-md-6">
					<div class="card">
						<div class="card-body">
							<div class="row">
		    					<div class="col-md-12 text-center">
		                            <h3>${ arr.title }</h3>
		                        </div>

		                        <div class="col-md-6">
		                        	<figure class="highcharts-figure">
			                            <div id="${arr.div_id}_timing"></div>
			                        </figure>
		                        </div>
		                        
		                        <div class="col-md-6">
		                        	<figure class="highcharts-figure">
			                            <div id="${arr.div_id}_observation"></div>
			                        </figure>
		                        </div>
		                    </div>
						</div>
					</div>
				</div>
			`
		}
	}
	
	$('#append_analytics').html(html)
}

const generateAnalytics = function (array) {
	for(const arr of array) {
		if(arr.timing.length !== 0) {
			Highcharts.chart(`${arr.div_id}_timing`,timingChartScript(arr.timing))
		}
		
		if(arr.observation.length !== 0) {
			Highcharts.chart(`${arr.div_id}_observation`, observationChartScript(arr.observation));
		}
	}
}

const getAnalytics = async function () {
	const activity = $('#activity').val()
	const area = $('#area').val()
	const product = $('#product').val()


	const _token = $('meta[name="csrf-token"]').attr('content')

	const response = await fetch('/analytics/getAnalytics', {
		headers: {
	        "X-CSRF-Token": _token,
	        "Content-Type": "application/json"	
	      },
	      method: 'POST',
	      credentials: "same-origin",
	      body : JSON.stringify({activity:activity, area:area, product:product})
	})


	const json = await response.json()

	generateDOMElement(json)
	generateAnalytics(json)
}

$('#activity').on('change', getAnalytics)
$('#area').on('change', getAnalytics)
$('#product').on('change', getAnalytics)
