@extends('templates.app')
@section('title')
    Dashboard
@endsection

@section('header_scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
@endsection

@section('content')


<div class="container-fluid px-6 pt-6">
    <div class="row">
        <div class="col-md-6 col-lg-6">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <figure class="highcharts-figure">
                        <div id="age"></div>
                    </figure>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <figure class="highcharts-figure">
                        <div id="gender"></div>
                    </figure>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <figure class="highcharts-figure">
                        <div id="farmCount"></div>
                    </figure>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <figure class="highcharts-figure">
                        <div id="farmOwnership"></div>
                    </figure>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <figure class="highcharts-figure">
                        <div id="farmEquip"></div>
                    </figure>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <figure class="highcharts-figure">
                        <div id="farmIrrigated"></div>
                    </figure>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <figure class="highcharts-figure">
                        <div id="harvest"></div>
                    </figure>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <figure class="highcharts-figure">
                        <div id="seedType"></div>
                    </figure>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <figure class="highcharts-figure">
                        <div id="cropPractice"></div>
                    </figure>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <figure class="highcharts-figure">
                        <div id="fertilizer"></div>
                    </figure>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <figure class="highcharts-figure">
                        <div id="farmProblem"></div>
                    </figure>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <figure class="highcharts-figure">
                        <div id="farmNotice"></div>
                    </figure>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <figure class="highcharts-figure">
                        <div id="commonPest"></div>
                    </figure>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <figure class="highcharts-figure">
                        <div id="sell"></div>
                    </figure>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <figure class="highcharts-figure">
                        <div id="priceFactor"></div>
                    </figure>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <figure class="highcharts-figure">
                        <div id="appBased"></div>
                    </figure>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <figure class="highcharts-figure">
                        <div id="initiatives"></div>
                    </figure>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <figure class="highcharts-figure">
                        <div id="phoneClass"></div>
                    </figure>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <figure class="highcharts-figure">
                        <div id="smartphoneApp"></div>
                    </figure>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <figure class="highcharts-figure">
                        <div id="farmGroupApp"></div>
                    </figure>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
@endsection
@push('scripts')
<script>
    const colorChart = ['#7cb5ec', '#434348', '#90ed7d', '#f7a35c', '#8085e9', '#f15c80', '#e4d354', '#2b908f', '#f45b5b', '#91e8e1'];
    axios.get('/dashboard/getAgeChartData').then(response => {
        // console.log(response.data);
        const ageChart = Highcharts.chart('age', {
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
        })
    });

    axios.get('/dashboard/getGenderChartData').then(response => {
        const genderChart = Highcharts.chart('gender', {
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
        })
    });

    axios.get('/dashboard/getfarmCountChartData').then(response => {
        const chart = Highcharts.chart('farmCount', {
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
        })
    });

    axios.get('/dashboard/getfarmOwnershipChartData').then(response => {
        const farmChart = Highcharts.chart('farmOwnership', {
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
        })
    });

    axios.get('/dashboard/getfarmEquipChartData').then(response => {
        const farmChart = Highcharts.chart('farmEquip', {
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
        })
    });

    axios.get('/dashboard/getfarmIrrigatedChartData').then(response => {
        const farmChart = Highcharts.chart('farmIrrigated', {
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
        })
    });

    axios.get('/dashboard/getharvestChartData').then(response => {
        const harvestChart = Highcharts.chart('harvest', {
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
        })
    });

    axios.get('/dashboard/getseedTypeChartData').then(response => {
        const seedsChart = Highcharts.chart('seedType', {
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
        })
    });

    axios.get('/dashboard/getcropPracticeChartData').then(response => {
        const rotationChart = Highcharts.chart('cropPractice', {
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
        })
    });

    axios.get('/dashboard/getfertilizerChartData').then(response => {
        const fertilizersChart = Highcharts.chart('fertilizer', {
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
        })
    });

    axios.get('/dashboard/getfarmProblemChartData').then(response => {
        const farmingProblemsChart = Highcharts.chart('farmProblem', {
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
        })
    });

    axios.get('/dashboard/getfarmNoticeChartData').then(response => {
        const farmObservationsChart = Highcharts.chart('farmNotice', {
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
        })
    });

    axios.get('/dashboard/getcommonPestChartData').then(response => {
        const commonPestsChart = Highcharts.chart('commonPest', {
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
        })
    });

    axios.get('/dashboard/getsellChartData').then(response => {
        const sellLocationChart = Highcharts.chart('sell', {
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
        })
    });

    axios.get('/dashboard/getpriceFactorChartData').then(response => {
        const priceFactorsChart = Highcharts.chart('priceFactor', {
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
        })
    });

    axios.get('/dashboard/getappBasedChartData').then(response => {
        const appBasedChart = Highcharts.chart('appBased', {
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
        })
    });

    axios.get('/dashboard/getinitiativesChartData').then(response => {
        const initiativesChart = Highcharts.chart('initiatives', {
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
        })
    });

    axios.get('/dashboard/getphoneClassChartData').then(response => {
        const phoneClassChart = Highcharts.chart('phoneClass', {
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
        })
    });

    axios.get('/dashboard/getsmartphoneAppChartData').then(response => {
        const smartphoneAppChart = Highcharts.chart('smartphoneApp', {
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
        })
    });

    axios.get('/dashboard/getfarmGroupAppChartData').then(response => {
        const farmGroupAppChart = Highcharts.chart('farmGroupApp', {
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
        })
    });
</script>
@endpush
