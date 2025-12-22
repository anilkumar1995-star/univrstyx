var cardColor, headingColor, labelColor, shadeColor, grayColor;

function renderSparklinesInActiveTab() {
    const activeTab = $('.tab-pane.active');

    function renderChart(selector, color) {
        activeTab.find(selector).each(function () {
            const values = $(this).data('values');
            if (values) {
                const parsed = values.toString().split(',').map(Number);
                $(this).sparkline(parsed, {
                    type: 'bar',
                    height: '60px',
                    barWidth: 6,
                    barSpacing: 1,
                    disableInteraction: true,
                    barColor: color
                });
            }
        });
    }

    renderChart('.ticket-chart-1', config.colors.danger);
    renderChart('.ticket-chart-2', config.colors.warning);
    renderChart('.ticket-chart-3', config.colors.info);
    renderChart('.ticket-chart-4', config.colors.success);
}



$(document).ready(function () {
    renderSparklinesInActiveTab();
    $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        renderSparklinesInActiveTab();
    });
});



function yearlyChart(finalCount) {

    const currentMonthIndex = new Date().getMonth();
    const colors = Array.from({ length: 12 }, (_, i) =>
        i === currentMonthIndex ? config.colors.success : config.colors.primary
    );

    const yearlyEarningReportsEl = document.querySelector('#yearlyEarningReports'),
        yearlyEarningReportsConfig = {
            chart: {
                height: 202,
                parentHeightOffset: 0,
                type: 'bar',
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    barHeight: '60%',
                    columnWidth: '38%',
                    startingShape: 'rounded',
                    endingShape: 'rounded',
                    borderRadius: 4,
                    distributed: true
                }
            },
            grid: {
                show: false,
                padding: {
                    top: -30,
                    bottom: 0,
                    left: -10,
                    right: -10
                }
            },
            colors: colors,
            dataLabels: {
                enabled: true
            },
            series: [
                {
                    data: finalCount
                }
            ],
            legend: {
                show: false
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                axisBorder: {
                    show: true
                },
                axisTicks: {
                    show: true
                },
                labels: {
                    style: {
                        colors: labelColor,
                        fontSize: '13px',
                        fontFamily: 'Public Sans'
                    }
                }
            },
            yaxis: {
                labels: {
                    show: false
                }
            },
            tooltip: {
                enabled: true,
                shared: false,
                custom: function ({ seriesIndex, dataPointIndex, w }) {
                    const count = w.config.series[seriesIndex].data[dataPointIndex];
                    return `<div class="tooltip-custom p-2"><span>Count : ${count}</span></div>`;
                }
            },
            responsive: [
                {
                    breakpoint: 1025,
                    options: {
                        chart: {
                            height: 199
                        }
                    }
                }
            ]
        };

    if (typeof yearlyEarningReportsEl !== undefined && yearlyEarningReportsEl !== null) {
        const yearlyEarningReports = new ApexCharts(yearlyEarningReportsEl, yearlyEarningReportsConfig);
        yearlyEarningReports.render();
    }
}
function yearlyChartIt(finalCount) {

    const currentMonthIndex = new Date().getMonth();
    const colors = Array.from({ length: 12 }, (_, i) =>
        i === currentMonthIndex ? config.colors.success : config.colors.primary
    );

    const yearlyEarningReportsItEl = document.querySelector('#yearlyEarningReportsIt'),
        yearlyEarningReportsItConfig = {
            chart: {
                height: 202,
                parentHeightOffset: 0,
                type: 'bar',
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    barHeight: '60%',
                    columnWidth: '38%',
                    startingShape: 'rounded',
                    endingShape: 'rounded',
                    borderRadius: 4,
                    distributed: true
                }
            },
            grid: {
                show: false,
                padding: {
                    top: -30,
                    bottom: 0,
                    left: -10,
                    right: -10
                }
            },
            colors: colors,
            dataLabels: {
                enabled: true
            },
            series: [
                {
                    data: finalCount
                }
            ],
            legend: {
                show: false
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                axisBorder: {
                    show: true
                },
                axisTicks: {
                    show: true
                },
                labels: {
                    style: {
                        colors: labelColor,
                        fontSize: '13px',
                        fontFamily: 'Public Sans'
                    }
                }
            },
            yaxis: {
                labels: {
                    show: false
                }
            },
            tooltip: {
                enabled: true,
                shared: false,
                custom: function ({ seriesIndex, dataPointIndex, w }) {
                    const count = w.config.series[seriesIndex].data[dataPointIndex];
                    return `<div class="tooltip-custom p-2"><span>Count : ${count}</span></div>`;
                }
            },
            responsive: [
                {
                    breakpoint: 1025,
                    options: {
                        chart: {
                            height: 199
                        }
                    }
                }
            ]
        };

    if (typeof yearlyEarningReportsItEl !== undefined && yearlyEarningReportsItEl !== null) {
        const yearlyEarningReportsIt = new ApexCharts(yearlyEarningReportsItEl, yearlyEarningReportsItConfig);
        yearlyEarningReportsIt.render();
    }
}
function yearlyChartSales(finalCount) {

    const currentMonthIndex = new Date().getMonth();
    const colors = Array.from({ length: 12 }, (_, i) =>
        i === currentMonthIndex ? config.colors.success : config.colors.primary
    );

    const yearlyEarningReportsSalesEl = document.querySelector('#yearlyEarningReportsSales'),
        yearlyEarningReportsSalesConfig = {
            chart: {
                height: 202,
                parentHeightOffset: 0,
                type: 'bar',
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    barHeight: '60%',
                    columnWidth: '38%',
                    startingShape: 'rounded',
                    endingShape: 'rounded',
                    borderRadius: 4,
                    distributed: true
                }
            },
            grid: {
                show: false,
                padding: {
                    top: -30,
                    bottom: 0,
                    left: -10,
                    right: -10
                }
            },
            colors: colors,
            dataLabels: {
                enabled: true
            },
            series: [
                {
                    data: finalCount
                }
            ],
            legend: {
                show: false
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                axisBorder: {
                    show: true
                },
                axisTicks: {
                    show: true
                },
                labels: {
                    style: {
                        colors: labelColor,
                        fontSize: '13px',
                        fontFamily: 'Public Sans'
                    }
                }
            },
            yaxis: {
                labels: {
                    show: false
                }
            },
            tooltip: {
                enabled: true,
                shared: false,
                custom: function ({ seriesIndex, dataPointIndex, w }) {
                    const count = w.config.series[seriesIndex].data[dataPointIndex];
                    return `<div class="tooltip-custom p-2"><span>Count : ${count}</span></div>`;
                }
            },
            responsive: [
                {
                    breakpoint: 1025,
                    options: {
                        chart: {
                            height: 199
                        }
                    }
                }
            ]
        };

    if (typeof yearlyEarningReportsSalesEl !== undefined && yearlyEarningReportsSalesEl !== null) {
        const yearlyEarningReportsSales = new ApexCharts(yearlyEarningReportsSalesEl, yearlyEarningReportsSalesConfig);
        yearlyEarningReportsSales.render();
    }
}
function yearlyChartSocial(finalCount) {

    const currentMonthIndex = new Date().getMonth();
    const colors = Array.from({ length: 12 }, (_, i) =>
        i === currentMonthIndex ? config.colors.success : config.colors.primary
    );

    const yearlyEarningReportsSocialEl = document.querySelector('#yearlyEarningReportsSocial'),
        yearlyEarningReportsSocialConfig = {
            chart: {
                height: 202,
                parentHeightOffset: 0,
                type: 'bar',
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    barHeight: '60%',
                    columnWidth: '38%',
                    startingShape: 'rounded',
                    endingShape: 'rounded',
                    borderRadius: 4,
                    distributed: true
                }
            },
            grid: {
                show: false,
                padding: {
                    top: -30,
                    bottom: 0,
                    left: -10,
                    right: -10
                }
            },
            colors: colors,
            dataLabels: {
                enabled: true
            },
            series: [
                {
                    data: finalCount
                }
            ],
            legend: {
                show: false
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                axisBorder: {
                    show: true
                },
                axisTicks: {
                    show: true
                },
                labels: {
                    style: {
                        colors: labelColor,
                        fontSize: '13px',
                        fontFamily: 'Public Sans'
                    }
                }
            },
            yaxis: {
                labels: {
                    show: false
                }
            },
            tooltip: {
                enabled: true,
                shared: false,
                custom: function ({ seriesIndex, dataPointIndex, w }) {
                    const count = w.config.series[seriesIndex].data[dataPointIndex];
                    return `<div class="tooltip-custom p-2"><span>Count : ${count}</span></div>`;
                }
            },
            responsive: [
                {
                    breakpoint: 1025,
                    options: {
                        chart: {
                            height: 199
                        }
                    }
                }
            ]
        };

    if (typeof yearlyEarningReportsSocialEl !== undefined && yearlyEarningReportsSocialEl !== null) {
        const yearlyEarningReportsSocial = new ApexCharts(yearlyEarningReportsSocialEl, yearlyEarningReportsSocialConfig);
        yearlyEarningReportsSocial.render();
    }
}
function yearlyChartHR(finalCount) {

    const currentMonthIndex = new Date().getMonth();
    const colors = Array.from({ length: 12 }, (_, i) =>
        i === currentMonthIndex ? config.colors.success : config.colors.primary
    );

    const yearlyEarningReportsHREl = document.querySelector('#yearlyEarningReportsHR'),
        yearlyEarningReportsHRConfig = {
            chart: {
                height: 202,
                parentHeightOffset: 0,
                type: 'bar',
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    barHeight: '60%',
                    columnWidth: '38%',
                    startingShape: 'rounded',
                    endingShape: 'rounded',
                    borderRadius: 4,
                    distributed: true
                }
            },
            grid: {
                show: false,
                padding: {
                    top: -30,
                    bottom: 0,
                    left: -10,
                    right: -10
                }
            },
            colors: colors,
            dataLabels: {
                enabled: true
            },
            series: [
                {
                    data: finalCount
                }
            ],
            legend: {
                show: false
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                axisBorder: {
                    show: true
                },
                axisTicks: {
                    show: true
                },
                labels: {
                    style: {
                        colors: labelColor,
                        fontSize: '13px',
                        fontFamily: 'Public Sans'
                    }
                }
            },
            yaxis: {
                labels: {
                    show: false
                }
            },
            tooltip: {
                enabled: true,
                shared: false,
                custom: function ({ seriesIndex, dataPointIndex, w }) {
                    const count = w.config.series[seriesIndex].data[dataPointIndex];
                    return `<div class="tooltip-custom p-2"><span>Count : ${count}</span></div>`;
                }
            },
            responsive: [
                {
                    breakpoint: 1025,
                    options: {
                        chart: {
                            height: 199
                        }
                    }
                }
            ]
        };

    if (typeof yearlyEarningReportsHREl !== undefined && yearlyEarningReportsHREl !== null) {
        const yearlyEarningReportsHR = new ApexCharts(yearlyEarningReportsHREl, yearlyEarningReportsHRConfig);
        yearlyEarningReportsHR.render();
    }
}

function yearlyChartSupport(finalCount) {

    const currentMonthIndex = new Date().getMonth();
    const colors = Array.from({ length: 12 }, (_, i) =>
        i === currentMonthIndex ? config.colors.success : config.colors.primary
    );

    const yearlyEarningReportsSupportEl = document.querySelector('#yearlyEarningReportsSupport'),
        yearlyEarningReportsSupportConfig = {
            chart: {
                height: 202,
                parentHeightOffset: 0,
                type: 'bar',
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    barHeight: '60%',
                    columnWidth: '38%',
                    startingShape: 'rounded',
                    endingShape: 'rounded',
                    borderRadius: 4,
                    distributed: true
                }
            },
            grid: {
                show: false,
                padding: {
                    top: -30,
                    bottom: 0,
                    left: -10,
                    right: -10
                }
            },
            colors: colors,
            dataLabels: {
                enabled: true
            },
            series: [
                {
                    data: finalCount
                }
            ],
            legend: {
                show: false
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                axisBorder: {
                    show: true
                },
                axisTicks: {
                    show: true
                },
                labels: {
                    style: {
                        colors: labelColor,
                        fontSize: '13px',
                        fontFamily: 'Public Sans'
                    }
                }
            },
            yaxis: {
                labels: {
                    show: false
                }
            },
            tooltip: {
                enabled: true,
                shared: false,
                custom: function ({ seriesIndex, dataPointIndex, w }) {
                    const count = w.config.series[seriesIndex].data[dataPointIndex];
                    return `<div class="tooltip-custom p-2"><span>Count : ${count}</span></div>`;
                }
            },
            responsive: [
                {
                    breakpoint: 1025,
                    options: {
                        chart: {
                            height: 199
                        }
                    }
                }
            ]
        };

    if (typeof yearlyEarningReportsSupportEl !== undefined && yearlyEarningReportsSupportEl !== null) {
        const yearlyEarningReportsSupport = new ApexCharts(yearlyEarningReportsSupportEl, yearlyEarningReportsSupportConfig);
        yearlyEarningReportsSupport.render();
    }
}

// Main Dahboard Chart
function emplyeeCountChart(data) {
    var sBar = {
        chart: {
            height: 300,
            type: 'bar',
            toolbar: {
                show: false,
            }
        },
        colors: ['#4361ee'],
        plotOptions: {
            bar: {
                horizontal: true,
                barHeight: '40%',
                borderRadius: 6,
                borderRadiusApplication: 'end'
            }
        },
        dataLabels: {
            enabled: false
        },
        series: [{
            name: 'Employees',
            data: data.counts
        }],
        xaxis: {
            categories: data.labels
        }
    }

    var chart = new ApexCharts(
        document.querySelector("#emplyee-count-chart"),
        sBar
    );

    chart.render();
}
function attendanceChart(data) {
    var donutChart = {
        chart: {
            height: 240,
            type: 'donut',
            toolbar: {
                show: false,
            }
        },
        colors: ['#FFC107', '#1B84FF', '#F26522', '#F26511'],
        series: [60, 10, 40, 20],
        labels: ['Present', 'Late', 'Permission', 'Absent'],
        plotOptions: {
            pie: {
                donut: {
                    size: '50%',
                    labels: {
                        show: false
                    },
                    borderRadius: 30
                }
            }
        },
        stroke: {
            lineCap: 'round',
            show: true,
            width: 2,
            colors: '#fff'
        },
        dataLabels: {
            enabled: false
        },
        legend: { show: false },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    height: 180,
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    }

    var donut = new ApexCharts(
        document.querySelector("#attendance-overview"),
        donutChart
    );

    donut.render();
}
function ticketDepartmentWise(series, label) {
    var sColStacked = {
        chart: {
            height: 240,
            type: 'bar',
            toolbar: {
                show: false,
            }
        },
        colors: ['#212529'],
        responsive: [{
            breakpoint: 480,
            options: {
                legend: {
                    position: 'bottom',
                    offsetX: -10,
                    offsetY: 0
                }
            }
        }],
        plotOptions: {
            bar: {
                borderRadius: 10,
                borderRadiusWhenStacked: 'all',
                horizontal: false,
                endingShape: 'rounded',
                colors: {
                    backgroundBarColors: ['#f3f4f5'], // Background color for bars
                    backgroundBarOpacity: 0.5,
                    hover: {
                        enabled: true,
                        borderColor: '#F26522', // Color when hovering over the bar
                    }
                }
            },
        },
        series: [{
            name: 'Company',
            data: series
        }],
        xaxis: {
            categories: label,
            labels: {
                show: false
            }
            // labels: {
            //   style: {
            //     colors: '#6B7280',
            //     fontSize: '13px',
            //   }
            // }
        },
        yaxis: {
            labels: {
                offsetX: -15,
                show: false
            }
        },
        grid: {
            borderColor: '#E5E7EB',
            strokeDashArray: 5,
            padding: {
                left: -8,
            },
        },
        legend: {
            show: false
        },
        dataLabels: {
            enabled: false // Disable data labels
        },
        fill: {
            opacity: 1
        },
    }

    var chart = new ApexCharts(
        document.querySelector("#departmentwise-overview"),
        sColStacked
    );

    chart.render();
}




