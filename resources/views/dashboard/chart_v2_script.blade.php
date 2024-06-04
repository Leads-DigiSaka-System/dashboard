<script>
    function chartScriptV2(data) {

	    return {
	        chart: {
	            type: 'bar'
	        },
	        title: {
	            text: data.title,
	            align: 'left'
	        },
	        subtitle: {
	            text: 'Answered: ' + data.answeredCount + '  Skipped: ' + data.skippedCount,
	            align: 'left'
	        },
	        xAxis: {
	            categories: data.categories,
	        },
	        yAxis: {
	            title: {
	                text: ''
	            },
	            min: 0,
	            max: 100,
	            tickInterval: 10,
	            labels: {
	                format: '{value}%'
	            }
	        },
	        credits: {
	            enabled: false
	        },
	        legend: {
	            enabled: false
	        },
	        tooltip: {
	            enabled: false
	        },
	        plotOptions: {
	            bar: {
	                colorByPoint: true,
	                colors: ['#28c76f']
	            }
	        },
	        series: [{
	            data: data.data
	        }]
	    };
    }

    axios.get('/dashboard/getSurveyV2').then(response => {

    	for(const data of Object.values(response.data)) {
    		Highcharts.chart(data.element_id, chartScriptV2(data));
    	}
        
    });
</script>