<script>
    const colorChart = ['#28c76f'];

    function chartScript(response) {

    return {
        chart: {
            type: 'bar'
        },
        title: {
            text: response.data.question,
            align: 'left'
        },
        subtitle: {
            text: 'Answered: ' + response.data.answered + '  Skipped: ' + response.data.skipped,
            align: 'left'
        },
        xAxis: {
            categories: response.data.categories,
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
                colors: colorChart
            }
        },
        series: [{
            data: response.data.data
        }]
    };
}

    axios.get('/dashboard/getAgeChartData').then(response => {
        const ageChart = Highcharts.chart('age', chartScript(response));
    });

    axios.get('/dashboard/getGenderChartData').then(response => {
        const genderChart = Highcharts.chart('gender', chartScript(response));
    });

    axios.get('/dashboard/getfarmCountChartData').then(response => {
        const chart = Highcharts.chart('farmCount', chartScript(response));
    });

    axios.get('/dashboard/getfarmOwnershipChartData').then(response => {
        const farmChart = Highcharts.chart('farmOwnership', chartScript(response));
    });

    axios.get('/dashboard/getfarmEquipChartData').then(response => {
        const farmChart = Highcharts.chart('farmEquip', chartScript(response));
    });

    axios.get('/dashboard/getfarmIrrigatedChartData').then(response => {
        const farmChart = Highcharts.chart('farmIrrigated', chartScript(response));
    });

    axios.get('/dashboard/getharvestChartData').then(response => {
        const harvestChart = Highcharts.chart('harvest', chartScript(response));
    });

    axios.get('/dashboard/getseedTypeChartData').then(response => {
        const seedsChart = Highcharts.chart('seedType', chartScript(response));
    });

    axios.get('/dashboard/getcropPracticeChartData').then(response => {
        const rotationChart = Highcharts.chart('cropPractice', chartScript(response));
    });

    axios.get('/dashboard/getfertilizerChartData').then(response => {
        const fertilizersChart = Highcharts.chart('fertilizer', chartScript(response));
    });

    axios.get('/dashboard/getfarmProblemChartData').then(response => {
        const farmingProblemsChart = Highcharts.chart('farmProblem', chartScript(response));
    });

    axios.get('/dashboard/getfarmNoticeChartData').then(response => {
        const farmObservationsChart = Highcharts.chart('farmNotice', chartScript(response));
    });

    axios.get('/dashboard/getcommonPestChartData').then(response => {
        const commonPestsChart = Highcharts.chart('commonPest', chartScript(response));
    });

    axios.get('/dashboard/getsellChartData').then(response => {
        const sellLocationChart = Highcharts.chart('sell', chartScript(response));
    });

    axios.get('/dashboard/getpriceFactorChartData').then(response => {
        const priceFactorsChart = Highcharts.chart('priceFactor', chartScript(response));
    });

    axios.get('/dashboard/getappBasedChartData').then(response => {
        const appBasedChart = Highcharts.chart('appBased', chartScript(response));
    });

    axios.get('/dashboard/getinitiativesChartData').then(response => {
        const initiativesChart = Highcharts.chart('initiatives', chartScript(response));
    });

    axios.get('/dashboard/getphoneClassChartData').then(response => {
        const phoneClassChart = Highcharts.chart('phoneClass', chartScript(response));
    });

    axios.get('/dashboard/getsmartphoneAppChartData').then(response => {
        const smartphoneAppChart = Highcharts.chart('smartphoneApp', chartScript(response));
    });

    axios.get('/dashboard/getfarmGroupAppChartData').then(response => {
        const farmGroupAppChart = Highcharts.chart('farmGroupApp', chartScript(response));
    });

</script>
