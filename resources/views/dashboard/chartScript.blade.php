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

    function getRecommendations(year) {
        axios.get(`/dashboard/getRecommendations?year=${year}`).then(response => {
            const data = response.data;
            let xaxis = [];
            let yaxis = [];

            for (const [x, y] of Object.entries(data)) {
                xaxis.push(x);
                yaxis.push(y);
            }

            // Use Highcharts to create a column chart
            Highcharts.chart('recommendations', { // Use 'recommendations' as the ID
                chart: {
                    type: 'column',
                    height: '300'
                },
                title: {
                    text: 'Number of Sample Data',
                    align: 'left',
                    style: {
                        fontSize: '18px', // Increase title font size
                        fontWeight: 'bold'
                    }
                },
                xAxis: {
                    categories: xaxis,
                    title: {
                        text: 'Month of the year',
                        style: {
                            fontSize: '16px' // Increase x-axis title font size
                        }
                    },
                    labels: {
                        style: {
                            fontSize: '14px' // Increase x-axis labels font size
                        }
                    }
                },
                yAxis: {
                    title: {
                        text: 'Number of Recommendations',
                        style: {
                            fontSize: '16px' // Increase y-axis title font size
                        }
                    },
                    labels: {
                        style: {
                            fontSize: '14px' // Increase y-axis labels font size
                        }
                    }
                },
                legend: {
                    enabled: false
                },
                series: [{
                    name: 'Recommendations',
                    data: yaxis
                }],
                plotOptions: {
                    column: {
                        colorByPoint: true,
                        colors: colorChart
                    }
                }
            });
        });
    }


    Highcharts.chart('reco_sum', {
        chart: {
            height: 300
        },
        title: {
            text: 'Recommendations / Alerts provided to farmers',
            align: 'left',
            style: {
                fontSize: '18px' // Larger font size
            }
        },
        yAxis: {
            title: {
                text: 'No. of Alerts Provided',
                style: {
                    fontSize: '16px' // Larger font size
                }
            },
            labels: {
                style: {
                    fontSize: '14px' // Axis labels font size
                }
            }
        },
        xAxis: {
            accessibility: {
                rangeDescription: 'Range: 2010 to 2020'
            },
            labels: {
                style: {
                    fontSize: '14px' // Axis labels font size
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            itemStyle: {
                fontSize: '14px' // Legend font size
            }
        },
        tooltip: {
            shared: true,
            borderColor: '#666',
            style: {
                fontSize: '16px' // Tooltip font size
            }
        },
        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                },
                pointStart: 2010
            }
        },
        series: [{
            name: 'Rice',
            data: [
                43934, 48656, 65165, 81827, 112143, 142383,
                171533, 165174, 155157, 161454, 154610
            ]
        }, {
            name: 'Corn',
            data: [
                24916, 37941, 29742, 29851, 32490, 30282,
                38121, 36885, 33726, 34243, 31050
            ]
        }, {
            name: 'Sugarcane',
            data: [
                11744, 30000, 16005, 19771, 20185, 24377,
                32147, 30912, 29243, 29213, 25663
            ]
        }, {
            name: 'Etc',
            data: [
                null, null, null, null, null, null, null,
                null, 11164, 11218, 10077
            ]
        }],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom',
                        itemStyle: {
                            fontSize: '10px' // Smaller font size for mobile
                        }
                    },
                    title: {
                        style: {
                            fontSize: '16px' // Smaller title for mobile
                        }
                    }
                }
            }]
        }
    });


    Highcharts.chart('surveys_conducted', {
        chart: {
            height: 300
        },
        title: {
            text: 'Surveys Conducted',
            align: 'left',
            style: {
                fontSize: '18px', // Increase title font size
                fontWeight: 'bold'
            }
        },

        yAxis: {
            title: {
                text: 'Number of Surveys Conducted',
                style: {
                    fontSize: '16px' // Increase Y-axis title font size
                }
            },
            labels: {
                style: {
                    fontSize: '14px' // Increase Y-axis labels font size
                }
            }
        },

        xAxis: {
            accessibility: {
                rangeDescription: 'Range: 2010 to 2020'
            },
            labels: {
                style: {
                    fontSize: '14px' // Increase X-axis labels font size
                }
            }
        },

        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            itemStyle: {
                fontSize: '14px' // Increase legend font size
            }
        },

        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                },
                pointStart: 2010
            }
        },

        series: [{
            name: 'Installation & Developers',
            data: [
                43934, 48656, 65165, 81827, 112143, 142383,
                171533, 165174, 155157, 161454, 154610
            ]
        }, {
            name: 'Manufacturing',
            data: [
                24916, 37941, 29742, 29851, 32490, 30282,
                38121, 36885, 33726, 34243, 31050
            ]
        }, {
            name: 'Sales & Distribution',
            data: [
                11744, 30000, 16005, 19771, 20185, 24377,
                32147, 30912, 29243, 29213, 25663
            ]
        }, {
            name: 'Operations & Maintenance',
            data: [
                null, null, null, null, null, null, null,
                null, 11164, 11218, 10077
            ]
        }, {
            name: 'Other',
            data: [
                21908, 5548, 8105, 11248, 8989, 11816, 18274,
                17300, 13053, 11906, 10073
            ]
        }],

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom',
                        itemStyle: {
                            fontSize: '10px' // Adjust font size for smaller screens
                        }
                    }
                }
            }]
        }
    });


    //Total Number of Farmers Registered Chart
    Highcharts.chart('registered_farmers', {
        chart: {
            type: 'pie'
        },
        title: {
            text: ''
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Registered Farmers',
            data: [{
                    name: 'Region I',
                    y: 300
                },
                {
                    name: 'Region II',
                    y: 200
                },
                {
                    name: 'Region III',
                    y: 500
                }
            ],
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '16px', // Adjust the font size as needed
                    fontWeight: 'bold',
                    color: '#000'
                },
                format: '{point.name}: {point.y}' // Format of the label
            }
        }]
    });

    //Total Number of Farmers with ID Card Chart
    Highcharts.chart('farmers_id', {
        chart: {
            type: 'pie'
        },
        title: {
            text: ''
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Registered Farmers',
            data: [{
                    name: 'Region I',
                    y: 151
                },
                {
                    name: 'Region II',
                    y: 93
                },
                {
                    name: 'Region III',
                    y: 243
                }
            ],
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '16px', // Adjust the font size as needed
                    fontWeight: 'bold',
                    color: '#000'
                },
                format: '{point.name}: {point.y}' // Format of the label
            }
        }]
    });

    /*axios.get('/dashboard/getAgeChartData').then(response => {
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
    });*/

    axios.get('/dashboard/getAreaPlantedPerVariety').then(response => {
        const data = response.data; // Assuming the data is present in the 'data' property of the response

        // Create the Highcharts pie chart with dynamic data
        demoAreaPlanted('area_planted', data);
        demoAreaPlanted('area_planted1', data);
        demoAreaPlanted('commercial_area_planted', data);
        demoAreaPlanted('corporate_area_planted', data);
        demoAreaPlanted('financing_area_planted', data);
        demoAreaPlanted('provincial_area_planted', data);
        demoAreaPlanted('recipient_area_planted', data);
        demoAreaPlanted('progress_area_planted', data);
        /*Highcharts.chart('area_planted', {
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
        });*/


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
            // Highcharts.chart('variety_planted', { // Use 'variety_planted' as the ID
            //     chart: {
            //         type: 'column'
            //     },
            //     title: {
            //         text: 'Variety Planted per Region'
            //     },
            //     xAxis: {
            //         "categories": categories
            //     },
            //     credits: {
            //         enabled: false
            //     },
            //     yAxis: {
            //         title: {
            //             text: 'Total Area (ha)'
            //         }
            //     },
            //     "series": seriesData,
            // });
            demoVarietyPlanted('variety_planted', categories, seriesData);
            demoVarietyPlanted('variety_planted1', categories, seriesData);
            demoVarietyPlanted('commercial_variety_planted', categories, seriesData);
            demoVarietyPlanted('corporate_variety_planted', categories, seriesData);
            demoVarietyPlanted('financing_variety_planted', categories, seriesData);
            demoVarietyPlanted('provincial_variety_planted', categories, seriesData);
            demoVarietyPlanted('recipient_variety_planted', categories, seriesData);
            demoVarietyPlanted('progress_variety_planted', categories, seriesData);
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });

    function demoAreaPlanted(element, data) {
        Highcharts.chart(element, {
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
    }

    function demoVarietyPlanted(element, categories, seriesData) {
        Highcharts.chart(element, { // Use 'variety_planted' as the ID
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
    }
    $("#recom_year").on('change', function() {
        const value = $(this).val();
        getRecommendations(value);
    })

    $(document).ready(function() {
        const recom_year = $('#recom_year').val();

        getRecommendations(recom_year);
    })
</script>
