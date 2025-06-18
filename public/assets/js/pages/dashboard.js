document.addEventListener('DOMContentLoaded', function () {
//Get logged user role

async function loadUserRole() {
    try {
        const response = await fetch('/dashboard/roles');
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();

        if (data.success) {
            console.log('User role:', data.role);
            return data.role; // This allows you to use it with await
        }
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}

// Example of using the role outside
(async () => {
    const role = await loadUserRole();
    console.log('Outside async:', role);

    // You can call a function or perform conditional logic here
    if (role === 'support') {
        
        // Initialize empty chart first
        var options = {
            chart: {
                height: 350,
                type: 'area',
                toolbar: { show: false }
            },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            series: [
                { name: 'Support Requests', data: [] },
                { name: 'Resolved', data: [] },
                { name: 'Customers', data: [] }
            ],
            colors: ['#556ee6', '#34c38f', '#f46a6a'],
            xaxis: {
                type: 'datetime',
                categories: [] // Initialize empty, will be populated from API
            },
            grid: { borderColor: '#9ca3af20' },
            tooltip: { x: { format: 'MMM yyyy' } }
        };

        // Create chart instance only once
        var chart = new ApexCharts(document.querySelector("#support_activities"), options);
        chart.render();

        // Fetch data via AJAX
        function loadChartData() {
            fetch('/dashboard/users/support-chart') // Fixed route (no backticks needed)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        console.log(data)
                        // Update existing chart instead of creating new one
                        chart.updateOptions({
                            xaxis: {
                                categories: data.data.map(item => item.month_iso)
                            }
                        });
                        
                        chart.updateSeries([
                            {
                                name: 'Support Requests',
                                data: data.data.map(item => item.tickets)
                            },
                            {
                                name: 'Resolved',
                                data: data.data.map(item => item.resolved)
                            },
                            {
                                name: 'Customers',
                                data: data.data.map(item => item.customers)
                            }
                        ]);
                        
                        // Update stats display 
                        document.getElementById('total_tickets').textContent = data.stats.totalTicketCount ?? 0;
                        document.getElementById('resolution_rate').textContent = data.stats.resolution_rate + '%';
                        document.getElementById('total_rejected').textContent = data.stats.totalTicketRejectedCount ?? 0;
                        document.getElementById('total_customers').textContent = data.stats.total_customers ?? 0;
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }


        // Load data when page is ready
        //document.addEventListener('DOMContentLoaded', function() {
            loadChartData();
        //});
    }
    else if (role === 'qualitycontrol') {
        
        // Quality Control performance metrics

        var options = {
    chart: {
        height: 500,  
        type: 'pie',
        animations: {
            enabled: true,
            easing: 'easeinout',
            speed: 800
        }
    },
    series: [], // Will be populated with average_resolution_time in minutes
    labels: [], // Will be populated with support names
    colors: ["#34c38f", "#556ee6", "#f46a6a", "#50a5f1", "#f1b44c"],
    legend: {
        show: true,
        position: 'bottom',
        horizontalAlign: 'center',
        verticalAlign: 'middle',
        floating: false,
        fontSize: '14px',
        offsetX: 0,
        itemMargin: {
            horizontal: 8,
            vertical: 5
        }
    },
    tooltip: {
        enabled: true,
        y: {
            formatter: function(value) {
                return value + ' minutes'; // Show resolution time in minutes
            },
            title: {
                formatter: function(seriesName) {
                    return 'Avg Resolution Time:';
                }
            }
        }
    },
    plotOptions: {
        pie: {
            expandOnClick: true,
            donut: {
                labels: {
                    show: false,
                    total: {
                        show: false,
                        label: 'Total',
                        color: '#373d3f',
                        fontSize: '16px'
                    }
                }
            },
            customScale: 1,
            offsetY: 20
        }
    },
    stroke: {
        colors: ['transparent'],
        width: 1
    },
    dataLabels: {
        enabled: true,
        formatter: function(val, opts) {
            // Format as minutes
            return opts.w.config.labels[opts.seriesIndex] + ': ' + val.toFixed(0) + 'm';
        },
        style: {
            fontSize: '12px',
            fontWeight: 'bold'
        },
        dropShadow: {
            enabled: false
        }
    },
    responsive: [{
        breakpoint: 992,
        options: {
            chart: {
                height: 380
            }
        }
    }, {
        breakpoint: 768,
        options: {
            chart: {
                height: 320
            },
            legend: {
                position: 'bottom',
                fontSize: '12px'
            }
        }
    }, {
        breakpoint: 600,
        options: {
            chart: {
                height: 280
            },
            legend: {
                show: true,
                fontSize: '10px'
            },
            dataLabels: {
                enabled: false
            }
        }
    }]
};

var chart = new ApexCharts(
    document.querySelector("#quality_control_pie_chart"),
    options
);

chart.render();

function loadChartData() {
    fetch('/dashboard/users/support-metrics-pie')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success && data.chartData) {
                console.log(data);
                
                const series = [];
                const labels = [];
                
                data.chartData.forEach(support => {
                    // Use average_resolution_time in minutes
                    series.push(support.average_resolution_time);
                    
                    // Create label with support name and resolved tickets count
                    const supportName = support.support.user.fname + ' ' + support.support.user.lname;
                    labels.push(`${supportName} (${support.total_tickets_resolved} resolved)`);
                });
                
                // Update the chart
                chart.updateOptions({
                    series: series,
                    labels: labels
                });
                
                // Update stats display 
                document.getElementById('total_tickets').textContent = data.totalTicketCount || 0;
                document.getElementById('total_customers').textContent = data.totalCustomerCount || 0;
                document.getElementById('total_supports').textContent = data.totalSupportCount || 0;
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}

// Initial load
loadChartData();


// Optional: Refresh data periodically (e.g., every 30 seconds)
// setInterval(loadChartData, 30000);

        
        // // Support performance metrics

        // var options = {
        //     chart: {
        //         height: 500,  // Increased from 320 to 450
        //         type: 'pie',
        //         animations: {
        //             enabled: true,
        //             easing: 'easeinout',
        //             speed: 800
        //         }
        //     },
        //     series: [44, 55, 41, 17, 15],
        //     labels: ["Series 1", "Series 2", "Series 3", "Series 4", "Series 5"],
        //     colors: ["#34c38f", "#556ee6", "#f46a6a", "#50a5f1", "#f1b44c"],
        //     legend: {
        //         show: true,
        //         position: 'bottom',
        //         horizontalAlign: 'center',
        //         verticalAlign: 'middle',
        //         floating: false,
        //         fontSize: '14px',
        //         offsetX: 0,
        //         itemMargin: {
        //             horizontal: 8,
        //             vertical: 5
        //         }
        //     },
        //     plotOptions: {
        //         pie: {
        //             expandOnClick: true,
        //             donut: {
        //                 labels: {
        //                     show: false,
        //                     total: {
        //                         show: false,
        //                         label: 'Total',
        //                         color: '#373d3f',
        //                         fontSize: '16px'
        //                     }
        //                 }
        //             },
        //             customScale: 1,  // Adjust if needed (0.8-1.2)
        //             offsetY: 20       // Gives more space for legend
        //         }
        //     },
        //     stroke: {
        //         colors: ['transparent'],
        //         width: 1
        //     },
        //     dataLabels: {
        //         enabled: true,
        //         style: {
        //             fontSize: '12px',
        //             fontWeight: 'bold'
        //         },
        //         dropShadow: {
        //             enabled: false
        //         }
        //     },
        //     responsive: [{
        //         breakpoint: 992,
        //         options: {
        //             chart: {
        //                 height: 380
        //             }
        //         }
        //     }, {
        //         breakpoint: 768,
        //         options: {
        //             chart: {
        //                 height: 320
        //             },
        //             legend: {
        //                 position: 'bottom',
        //                 fontSize: '12px'
        //             }
        //         }
        //     }, {
        //         breakpoint: 600,
        //         options: {
        //             chart: {
        //                 height: 280
        //             },
        //             legend: {
        //                 show: true,
        //                 fontSize: '10px'
        //             },
        //             dataLabels: {
        //                 enabled: false
        //             }
        //         }
        //     }]
        // };

        // var chart = new ApexCharts(
        //     document.querySelector("#support_performance_pie_chart"),
        //     options
        // );

        // chart.render();
    }
    else if (role === 'supervisor') {
        
    }
    else if (role === 'administrator') {
        
    }
    else if (role === 'account') {
        
    //invoice financial Report
    var options = {
        chart: {
            height: 350,
            type: 'area',
            toolbar: {
                show: false,
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth',
            width: 3,
        },
        series: [{
            name: 'Processed',
            data: [34, 40, 28, 52, 42, 109, 100]
        }, {
            name: 'Pending',
            data: [32, 60, 34, 46, 34, 52, 41]
        }],
        colors: ['#556ee6', '#34c38f'],
        xaxis: {
            type: 'datetime',
            categories: ["2018-09-19T00:00:00", "2018-09-19T01:30:00", "2018-09-19T02:30:00", "2018-09-19T03:30:00", "2018-09-19T04:30:00", "2018-09-19T05:30:00", "2018-09-19T06:30:00"],
        },
        grid: {
            borderColor: '#9ca3af20',
        },
        tooltip: {
            x: {
                format: 'dd/MM/yy HH:mm'
            },
        }
    }

    var chart = new ApexCharts(
        document.querySelector("#invoiceFinancialReport"),
        options
    );

    chart.render();

    }
    else if (role === 'businessdeveloper') {
        
        // business_developer chart

        var options = {
            chart: {
                height: 350,
                type: 'bar',
                toolbar: {
                    show: false,
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '45%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            series: [{
                name: 'Net Profit',
                data: [46, 57, 59, 54, 62, 58, 64, 60, 66]
            }, {
                name: 'Revenue',
                data: [74, 83, 102, 97, 86, 106, 93, 114, 94]
            }, {
                name: 'Free Cash Flow',
                data: [37, 42, 38, 26, 47, 50, 54, 55, 43]
            }],
            colors: ['#34c38f', '#556ee6', '#f46a6a'],
            xaxis: {
                categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
            },
            yaxis: {
                title: {
                    text: '$ (thousands)',
                    style: {
                        fontWeight: '500',
                    },
                }
            },
            grid: {
                borderColor: '#9ca3af20',
            },
            fill: {
                opacity: 1

            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "$ " + val + " thousands"
                    }
                }
            }
        }

        var chart = new ApexCharts(
            document.querySelector("#business_developer"),
            options
        );

        chart.render();
    }
    else if (role === 'businessmanager') {
        // Sales Performance
        var options = {
            chart: {
                height: 350,
                type: 'area',
                toolbar: {
                    show: false,
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 3,
            },
            series: [{
                name: 'series1',
                data: [34, 40, 28, 52, 42, 109, 100, 90]
            }, {
                name: 'series2',
                data: [32, 60, 34, 46, 34, 52, 41, 67]
            }],
            colors: ['#556ee6', '#34c38f'],
            xaxis: {
                type: 'category',
                categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Sep"],
            },
            grid: {
                borderColor: '#9ca3af20',
            },
            tooltip: {
                x: {
                    show: true,
                    formatter: function(val) {
                        return val;
                    }
                }
            }
        }

        var chart = new ApexCharts(
            document.querySelector("#sales_performance_area"),
            options
        )

        chart.render();


    }
    else if (role === 'businesssupervisor') {
        
    }
    else if (role === 'customermanager') {
        // Generate the past 12 months in datetime format
        const customer_manager_months = [...Array(12)].map((_, i) => {
            const date = new Date();
            date.setMonth(date.getMonth() - (11 - i)); // oldest to newest
            return date.toISOString().split('T')[0] + "T00:00:00";
        });

        var options = {
            chart: {
                height: 350,
                type: 'area',
                toolbar: {
                    show: false,
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 3,
            },
            series: [{
                name: 'Support Requests',
                data: [34, 40, 28, 52, 42, 109, 100, 94, 88, 75, 61, 80] // 12 values
            }, {
                name: 'Resolved',
                data: [32, 60, 34, 46, 34, 52, 41, 60, 70, 66, 59, 75] // 12 values
            }],
            colors: ['#556ee6', '#34c38f'],
            xaxis: {
                type: 'datetime',
                categories: customer_manager_months, // dynamically generated 12 months
            },
            grid: {
                borderColor: '#9ca3af20',
            },
            tooltip: {
                x: {
                    format: 'MMM yyyy' // show Month Year format
                },
            }
        }

        var chart = new ApexCharts(
            document.querySelector("#customer_manager_metric"),
            options
        );

        chart.render();

    }
    else if (role === 'developer') {
        
    }
    else if (role === 'customer') {
        //   customer_activities 

        var options = {
            chart: {
                height: 350,
                type: 'area',
                toolbar: {
                    show: false,
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 3,
            },
            series: [{
                name: 'series1',
                data: [34, 40, 28, 52, 42, 109, 100]
            }, {
                name: 'series2',
                data: [32, 60, 34, 46, 34, 52, 41]
            }],
            colors: ['#556ee6', '#34c38f'],
            xaxis: {
                type: 'datetime',
                categories: ["2018-09-19T00:00:00", "2018-09-19T01:30:00", "2018-09-19T02:30:00", "2018-09-19T03:30:00", "2018-09-19T04:30:00", "2018-09-19T05:30:00", "2018-09-19T06:30:00"],
            },
            grid: {
                borderColor: '#9ca3af20',
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy HH:mm'
                },
            }
        }

        var chart = new ApexCharts(
            document.querySelector("#customer_activities"),
            options
        );

        chart.render();
    }
    else{


var colors = ["#3073F1", "#0acf97"];
var dataColors = document.querySelector("#crm-project-statistics").dataset.colors;

if (dataColors) {
    colors = dataColors.split(",");
}


var options = {
    chart: {
        height: 350,
        type: 'bar',
        toolbar: {
            show: false,
        }
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '45%',
            endingShape: 'rounded'
        },
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    series: [{
        name: 'Net Profit',
        data: [46, 57, 59, 54, 62, 58, 64, 60, 66]
    }, {
        name: 'Revenue',
        data: [74, 83, 102, 97, 86, 106, 93, 114, 94]
    }, {
        name: 'Free Cash Flow',
        data: [37, 42, 38, 26, 47, 50, 54, 55, 43]
    }],
    colors: ['#34c38f', '#556ee6', '#f46a6a'],
    xaxis: {
        categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
    },
    yaxis: {
        title: {
            text: '$ (thousands)',
            style: {
                fontWeight: '500',
            },
        }
    },
    grid: {
        borderColor: '#9ca3af20',
    },
    fill: {
        opacity: 1

    },
    tooltip: {
        y: {
            formatter: function (val) {
                return "$ " + val + " thousands"
            }
        }
    }
}

// var options = {
//     chart: {
//         height: 350,
//         type: 'bar',
//         toolbar: {
//             show: false
//         }
//     },
//     plotOptions: {
//         bar: {
//             horizontal: false,
//             endingShape: 'rounded',
//             columnWidth: '25%',
//         },
//     },
//     dataLabels: {
//         enabled: false
//     },
//     stroke: {
//         show: true,
//         width: 3,
//         colors: ['transparent']
//     },
//     colors: colors,
//     series: [{
//         name: 'Projects',
//         data: [56, 38, 85, 72, 28, 69, 55, 52, 69]
//     }, {
//         name: 'Working Hours',
//         data: [176, 185, 256, 240, 187, 205, 191, 114, 194]
//     }],
//     xaxis: {
//         categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
//     },
//     legend: {
//         offsetY: 7,
//     },
//     fill: {
//         opacity: 1

//     },
//     grid: {
//         row: {
//             colors: ['transparent', 'transparent'], // takes an array which will be repeated on columns
//             opacity: 0.2
//         },
//         borderColor: '#9ca3af20',
//         padding: {
//             bottom: 5,
//         }
//     }
// }

var chart = new ApexCharts(
    document.querySelector("#crm-project-statistics"),
    options
);

chart.render();



//
var colors = ["#3073F1", "#0acf97"];
var dataColors = document.querySelector("#monthly-target").dataset.colors;

if (dataColors) {
    colors = dataColors.split(",");
}

var options = {
    chart: {
        height: 280,
        type: 'donut',
    },
    legend: {
        show: false
    },
    stroke: {
        colors: ['transparent']
    },
    series: [82, 37],
    labels: ["Done Projects", "Pending Projects"],
    colors: colors,
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                width: 200
            },
            legend: {
                position: 'bottom'
            }
        }
    }]
}

var chart = new ApexCharts(
    document.querySelector("#monthly-target"),
    options
);

chart.render();


//
var colors = ["#3073F1", "#0acf97", "#fa5c7c", "#ffbc00"];
var dataColors = document.querySelector("#project-overview-chart").dataset.colors;
if (dataColors) {
    colors = dataColors.split(",");
}
var options = {
    chart: {
        height: 350,
        type: 'radialBar'
    },
    colors: colors,
    series: [85, 70, 80, 65],
    labels: ['Product Design', 'Web Development', 'Illustration Design', 'UI/UX Design'],
    plotOptions: {
        radialBar: {
            track: {
                margin: 5,
            }
        }
    }
}

var chart = new ApexCharts(
    document.querySelector("#project-overview-chart"),
    options
);

chart.render();
}

})();

    
});