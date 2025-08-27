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
            series: [],
            labels: [],
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
                        return value + ' minutes';
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

        // Function to load chart data
        function loadChartData() {
            // Show loading state
            // document.getElementById('no_data_message').style.display = 'none';
            // chart.updateOptions({
            //     series: [],
            //     labels: []
            // });
            
            // In a real implementation, you would fetch from your API
            // fetch('/dashboard/users/support-metrics-pie')
            // For demonstration, we'll use a timeout to simulate API call
            setTimeout(() => {
                // Simulated response data - replace with your actual API response
                const mockResponse = {
                    success: true,
                    chartData: [
                        {
                            average_resolution_time: 44,
                            total_tickets_resolved: 10,
                            support: {
                                user: {
                                    fname: "John",
                                    lname: "Doe"
                                }
                            }
                        },
                        {
                            average_resolution_time: 55,
                            total_tickets_resolved: 8,
                            support: {
                                user: {
                                    fname: "Jane",
                                    lname: "Smith"
                                }
                            }
                        },
                        {
                            average_resolution_time: 41,
                            total_tickets_resolved: 12,
                            support: {
                                user: {
                                    fname: "Robert",
                                    lname: "Johnson"
                                }
                            }
                        }
                    ],
                    totalTicketCount: 44,
                    totalCustomerCount: 17,
                    totalSupportCount: 3,
                    totalActiveCustomerCount: 3,
                    reviewedTicketCount: 2,
                    totalPendingTickets: 27,
                    openTicketCount: 15,
                    resolvedTicketCount: 29,
                    totalTicketThisMonth: 21
                };

                // For testing empty data scenario, uncomment the next line:
                // mockResponse.chartData = [];
                
                if (mockResponse.success && mockResponse.chartData && mockResponse.chartData.length > 0) {
                    const series = [];
                    const labels = [];
                    
                    mockResponse.chartData.forEach(support => {
                        series.push(support.average_resolution_time);
                        const supportName = support.support.user.fname + ' ' + support.support.user.lname;
                        labels.push(`${supportName} (${support.total_tickets_resolved} resolved)`);
                    });
                    
                    // Update the chart
                    chart.updateOptions({
                        series: series,
                        labels: labels
                    });
                    
                    // Update stats display 
                    document.getElementById('total_tickets').textContent = mockResponse.totalTicketCount || 0;
                    document.getElementById('active_customers').textContent = mockResponse.totalActiveCustomerCount || 0;
                    document.getElementById('total_customers').textContent = mockResponse.totalCustomerCount || 0;
                    document.getElementById('total_supports').textContent = mockResponse.totalSupportCount || 0;
                    document.getElementById('ticket_reviews').textContent = mockResponse.reviewedTicketCount || 0;
                    document.getElementById('pending_tickets_mid').textContent = mockResponse.totalPendingTickets || 0;
                    document.getElementById("open_tickets_this_month").textContent = mockResponse.openTicketCount || 0;
                    document.getElementById("resolved_tickets_this_month").textContent = mockResponse.resolvedTicketCount || 0;
                    document.getElementById("total_tickets_this_month").textContent = mockResponse.totalTicketThisMonth || 0;
                    
                    // Hide no data message
                    //document.getElementById('no_data_message').style.display = 'none';
                } else {
                    // Show no data message
                    //document.getElementById('no_data_message').style.display = 'block';
                    
                    // Reset stats to 0
                    document.getElementById('total_tickets').textContent = 0;
                    document.getElementById('active_customers').textContent = 0;
                    document.getElementById('total_customers').textContent = 0;
                    document.getElementById('total_supports').textContent = 0;
                    document.getElementById('ticket_reviews').textContent = 0;
                    document.getElementById('pending_tickets_mid').textContent = 0;
                    document.getElementById("open_tickets_this_month").textContent = 0;
                    document.getElementById("resolved_tickets_this_month").textContent = 0;
                    document.getElementById("total_tickets_this_month").textContent = 0;
                }
            }, 1000); // Simulate network delay
        }

        // Initial load
        loadChartData();

    }
    else if (role === 'supervisor') {
        
    }
    else if (role === 'administrator') {
                var options = {
            chart: {
                height: 350,
                type: 'area',
                toolbar: { show: false }
            },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            series: [
                { name: 'Total Revenue', data: [] },
                { name: 'Total Subscribers', data: [] }
            ],
            colors: ['#556ee6', '#34c38f'],
            xaxis: {
                type: 'datetime',
                categories: []
            },
            grid: { borderColor: '#9ca3af20' },
            tooltip: {
                x: { format: 'MMM yyyy' } // Changed to show month/year only
            }
        };

        // Create chart instance
        var chart = new ApexCharts(
            document.querySelector("#admin_data"),
            options
        );
        chart.render();

        // Function to fetch and update chart data
        function updateChartData() {
            fetch('dashboard/administrator/admin-stats')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        
                console.log('Administrator response', data)
                        // Process the metrics data
                        const metrics = data.metrics;
                        
                        // Prepare data arrays
                        const revenueData = [];
                        const subscriberData = [];
                        const categories = [];
                        
                        // Get current date and calculate start date (12 months ago)
                        const currentDate = new Date();
                        const startDate = new Date();
                        startDate.setMonth(currentDate.getMonth() - 12);
                        
                        // Generate all months in the range
                        const monthYearMap = {};
                        let date = new Date(startDate);
                        while (date <= currentDate) {
                            const year = date.getFullYear();
                            const month = String(date.getMonth() + 1).padStart(2, '0');
                            const monthYear = `${year}-${month}`;
                            monthYearMap[monthYear] = true;
                            date.setMonth(date.getMonth() + 1);
                        }
                        
                        // Fill data for all months (including zeros for missing months)
                        Object.keys(monthYearMap).sort().forEach(monthYear => {
                            const metric = metrics.find(m => m.month === monthYear);
                            
                            categories.push(`${monthYear}-01`); // Add first day for proper date format
                            revenueData.push(metric ? metric.total_amount : 0);
                            subscriberData.push(metric ? metric.total_subscribers : 0);
                        });
                        
                        // Update the chart
                        chart.updateOptions({
                            xaxis: { categories: categories }
                        });
                        
                        chart.updateSeries([
                            { name: 'Total Revenue', data: revenueData },
                            { name: 'Total Subscribers', data: subscriberData }
                        ]);

                        document.getElementById('total_income_admin').textContent = data.totalIncome || 0;
                        document.getElementById('total_ticket_admin').textContent = data.tickets || 0;
                        document.getElementById('total_customers_admin').textContent = data.customers || 0;
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }

        // Load data when page is ready
        updateChartData();
    }
    else if (role === 'account') {
        // Initialize the chart with empty data first
        var options = {
            chart: {
                height: 350,
                type: 'area',
                toolbar: { show: false }
            },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            series: [
                { name: 'Total Revenue', data: [] },
                { name: 'Total Subscribers', data: [] }
            ],
            colors: ['#556ee6', '#34c38f'],
            xaxis: {
                type: 'datetime',
                categories: []
            },
            grid: { borderColor: '#9ca3af20' },
            tooltip: {
                x: { format: 'MMM yyyy' } // Changed to show month/year only
            }
        };

        // Create chart instance
        var chart = new ApexCharts(
            document.querySelector("#invoiceFinancialReport"),
            options
        );
        chart.render();

        // Function to fetch and update chart data
        function updateChartData() {
            fetch('dashboard/users/subscription-metrics')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Process the metrics data
                        const metrics = data.metrics;
                        
                        // Prepare data arrays
                        const revenueData = [];
                        const subscriberData = [];
                        const categories = [];
                        
                        // Get current date and calculate start date (12 months ago)
                        const currentDate = new Date();
                        const startDate = new Date();
                        startDate.setMonth(currentDate.getMonth() - 12);
                        
                        // Generate all months in the range
                        const monthYearMap = {};
                        let date = new Date(startDate);
                        while (date <= currentDate) {
                            const year = date.getFullYear();
                            const month = String(date.getMonth() + 1).padStart(2, '0');
                            const monthYear = `${year}-${month}`;
                            monthYearMap[monthYear] = true;
                            date.setMonth(date.getMonth() + 1);
                        }
                        
                        // Fill data for all months (including zeros for missing months)
                        Object.keys(monthYearMap).sort().forEach(monthYear => {
                            const metric = metrics.find(m => m.month === monthYear);
                            
                            categories.push(`${monthYear}-01`); // Add first day for proper date format
                            revenueData.push(metric ? metric.total_amount : 0);
                            subscriberData.push(metric ? metric.total_subscribers : 0);
                        });
                        
                        // Update the chart
                        chart.updateOptions({
                            xaxis: { categories: categories }
                        });
                        
                        chart.updateSeries([
                            { name: 'Total Revenue', data: revenueData },
                            { name: 'Total Subscribers', data: subscriberData }
                        ]);

                        document.getElementById('pending_invoices').textContent = data.total_pending || 0;
                        document.getElementById('successful_transactions').textContent = data.total_success || 0;
                        document.getElementById('failed_transactions').textContent = data.total_failed || 0;
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }

        // Load data when page is ready
        updateChartData();
    
    }
    else if (role === 'businessdeveloper') {
        
        // business_developer chart
        // Initialize the chart with empty data first
        var options = {
            chart: {
                height: 350,
                type: 'area',
                toolbar: { show: false }
            },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            series: [
                { name: 'Subscribed Customers', data: [] }
            ],
            colors: ['#556ee6'],
            xaxis: {
                type: 'datetime',
                categories: [],
                labels: {
                    show: true,
                    rotate: -45,
                    rotateAlways: false,
                    hideOverlappingLabels: false,
                    showDuplicates: false,
                    trim: false,
                    minHeight: undefined,
                    maxHeight: 120,
                    style: {
                        colors: [],
                        fontSize: '12px',
                        fontFamily: 'Helvetica, Arial, sans-serif',
                        fontWeight: 400,
                        cssClass: 'apexcharts-xaxis-label',
                    },
                    offsetX: 0,
                    offsetY: 0,
                    format: undefined,
                    formatter: undefined,
                    datetimeUTC: true,
                    datetimeFormatter: {
                        year: 'yyyy',
                        month: "MMM 'yy",
                        day: 'dd MMM',
                        hour: 'HH:mm',
                    },
                },
                axisBorder: {
                    show: true,
                    color: '#78909C',
                    height: 1,
                    width: '100%',
                    offsetX: 0,
                    offsetY: 0
                },
                axisTicks: {
                    show: true,
                    borderType: 'solid',
                    color: '#78909C',
                    height: 6,
                    offsetX: 0,
                    offsetY: 0
                },
                tickAmount: 12,
                min: undefined,
                max: undefined
            },
            grid: { borderColor: '#9ca3af20' },
            tooltip: {
                x: { format: 'MMM yyyy' }
            }
        };

        // Create chart instance
        var chart = new ApexCharts(
            document.querySelector("#business_developer"),
            options
        );

        chart.render();

        // Function to fetch and update chart data
        function updateBusinessChartData() {
            fetch('dashboard/busines-developer')
                .then(response => response.json())
                .then(data => {
                    console.log('Backend response:', data); // Debug log
                    
                    // Use the complete chart data that includes all 12 months
                    const chartData = data.chartDataComplete || [];
                    
                    // Prepare data arrays
                    const subscriberData = [];
                    const categories = [];
                    
                    // Process each month's data
                    chartData.forEach(monthData => {
                        // Create date string for ApexCharts (YYYY-MM-01 format)
                        const dateStr = `${monthData.year}-${String(monthData.month).padStart(2, '0')}-01`;
                        categories.push(dateStr);
                        subscriberData.push(monthData.count);
                    });
                    
                    console.log('Chart categories:', categories); // Debug log
                    console.log('Subscriber data:', subscriberData); // Debug log
                    
                    // Update the chart with explicit tick configuration
                    chart.updateOptions({
                        xaxis: { 
                            categories: categories,
                            tickAmount: 11, // 12 months = 11 intervals
                            labels: {
                                format: 'MMM yyyy',
                                rotate: -45,
                                hideOverlappingLabels: false,
                                showDuplicates: false,
                                datetimeFormatter: {
                                    year: 'yyyy',
                                    month: "MMM 'yy",
                                    day: 'dd MMM',
                                    hour: 'HH:mm',
                                }
                            }
                        }
                    });
                    
                    chart.updateSeries([
                        { name: 'Subscribed Customers', data: subscriberData }
                    ]);

                    // Update dashboard metrics
                    document.getElementById('onboarded_customers').textContent = data.totalCustomers || 0;
                    document.getElementById('active_customers').textContent = data.activeCustomers || 0;
                    document.getElementById('inactive_customers').textContent = data.inactiveCustomers || 0;
                })
                .catch(error => {
                    console.error('Error fetching business developer data:', error);
                });
        }

        updateBusinessChartData();

        //setInterval(updateBusinessChartData, 300000);

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
        // Fetch the data
async function loadCustomerDashboard() {
    try {
        const response = await fetch('/dashboard/customers/customer-dashboard'); // Adjust your endpoint
        const data = await response.json();
        
        if (data.success) {
            renderChart(data.monthlyTickets);

               function shortNumber(num) {
                    num = Number(num);
                    if (num >= 1_000_000_000) {
                        return (num / 1_000_000_000).toFixed(1).replace(/\.0$/, '') + 'B';
                    } else if (num >= 1_000_000) {
                        return (num / 1_000_000).toFixed(1).replace(/\.0$/, '') + 'M';
                    } else if (num >= 1_000) {
                        return (num / 1_000).toFixed(1).replace(/\.0$/, '') + 'K';
                    } else {
                        return num;
                    }
                }

                // Example usage after fetching data

            document.getElementById('total_pending').textContent = shortNumber(data.total_pending_tickets)
            document.getElementById('total_resolved').textContent = shortNumber(data.total_resolved_tickets)
            document.getElementById('total_tickets').textContent = shortNumber(data.total_tickets)

            document.getElementById('total_tickets_this_month').textContent = shortNumber(data.total_tickets_this_month) || 0;
            document.getElementById('total_resolved_this_month').textContent = shortNumber(data.total_resolved_this_month) || 0;
            document.getElementById('total_pending_this_month').textContent = shortNumber(data.total_pending_this_month) || 0;
        }
    } catch (error) {
        console.error('Error loading dashboard data:', error);
    }
}

// Render the chart
function renderChart(monthlyTickets) {
    // Prepare data for chart
    const categories = monthlyTickets.map(item => item.name);
    const seriesData = monthlyTickets.map(item => item.count);
    
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
            name: 'Tickets',
            data: seriesData
        }],
        colors: ['#556ee6'],
        xaxis: {
            categories: categories,
            labels: {
                formatter: function(value) {
                    return value || '';
                }
            }
        },
        grid: {
            borderColor: '#9ca3af20',
        },
        tooltip: {
            y: {
                formatter: function(value) {
                    return value + ' tickets';
                }
            }
        }
    }

    var chart = new ApexCharts(
        document.querySelector("#customer_activities"),
        options
    );


    chart.render();
}


// Load the data when page loads
loadCustomerDashboard();
//document.addEventListener('DOMContentLoaded', loadCustomerDashboard);
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