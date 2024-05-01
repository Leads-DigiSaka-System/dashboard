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

    axios.get('/dashboard/getAreaPlantedPerVariety').then(response => {
        const data = response.data; // Assuming the data is present in the 'data' property of the response

        // Create the Highcharts pie chart with dynamic data
        Highcharts.chart('area_planted', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Area Planted Per Variety'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        distance: -70, // Adjust the distance of the data labels from the pie slices
                        filter: {
                            property: 'percentage',
                            operator: '>',
                            value: 4 // Display data labels only if the percentage is greater than 4
                        },
                        style: {
                            textOutline: 'none',
                        }
                    }
                }
            },
            series: [{
                name: 'Variety',
                data: data.categories.map(function(category, index) {
                    return {
                        name: category,
                        y: data.data[index]
                    };
                })
            }]
        });
    });


    axios.get('/dashboard/getVarietyPlantedPerRegion').then(response => {
        const data = response.data;
        var categories = data.categories;
        var inputData = data.series;

        // Transform the data
        const seriesData = inputData.reduce((result, dataPoint) => {
            Object.entries(dataPoint).forEach(([name, value], index) => {
                if (!result[index]) {
                    result[index] = {
                        name: name,
                        data: []
                    };
                }
                result[index].data.push(value);
            });
            return result;
        }, []);

        const stringCategories = data.categories.map(category => category.toString());

        // Use Highcharts to create a column chart
        Highcharts.chart('variety_planted', { // Use 'variety_planted' as the ID
            chart: {
                type: 'column'
            },
            title: {
                text: 'Variety Planted per Region'
            },
            xAxis: {
                "categories": categories
            },
            credits: {
                enabled: false
            },
            yAxis: {
                title: {
                    text: 'Total Area (ha)'
                }
            },
            "series": seriesData,
        });
    })
    .catch(error => {
        console.error('Error fetching data:', error);
    });

</script>
