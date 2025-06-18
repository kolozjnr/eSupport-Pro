document.addEventListener('DOMContentLoaded', function () {

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
});