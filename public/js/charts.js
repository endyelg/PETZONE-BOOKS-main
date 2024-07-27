
$(document).ready(function () {
    $.ajax({
        type: "GET",
        url: "/api/dashboard/bar-chart",
        dataType: "json",
        success: function (data) {
            console.log(data.labels, data.data);
            var ctx = $("#barChart");
            var myBarChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Sales per Category',
                        data: data.data,
                        backgroundColor: [
                            'rgba(255, 0, 0, 0.2)',   // Red
                            'rgba(255, 165, 0, 0.2)', // Orange
                            'rgba(255, 255, 0, 0.2)', // Yellow
                            'rgba(0, 128, 0, 0.2)',   // Green
                            'rgba(0, 0, 255, 0.2)',   // Blue
                            'rgba(238, 130, 238, 0.2)', // Violet
                            'rgba(255, 192, 203, 0.2)', // Pink
                            'rgba(128, 0, 128, 0.2)', // Purple
                            'rgba(0, 255, 255, 0.2)', // Cyan
                            'rgba(255, 165, 255, 0.2)' // Light Pink
                        ],
                        borderColor: [
                            'rgba(255, 0, 0, 1)',     // Red
                            'rgba(255, 165, 0, 1)',   // Orange
                            'rgba(255, 255, 0, 1)',   // Yellow
                            'rgba(0, 128, 0, 1)',     // Green
                            'rgba(0, 0, 255, 1)',     // Blue
                            'rgba(238, 130, 238, 1)', // Violet
                            'rgba(255, 192, 203, 1)', // Pink
                            'rgba(128, 0, 128, 1)',   // Purple
                            'rgba(0, 255, 255, 1)',   // Cyan
                            'rgba(255, 165, 255, 1)'  // Light Pink
                        ],
                        borderWidth: 1,

                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    indexAxis: 'y',
                },
            });

        },
        error: function (error) {
            console.log(error);
        }
    });

    $.ajax({
        type: "GET",
        url: "/api/dashboard/line-chart",
        dataType: "json",
        success: function (data) {
            console.log(data);
            var ctx = $("#lineChart");
            var myBarChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Monthly sales over time',
                        data: data.data,
                        backgroundColor: [
                            'rgba(255, 0, 0, 0.2)',   // Red
                            'rgba(255, 165, 0, 0.2)', // Orange
                            'rgba(255, 255, 0, 0.2)', // Yellow
                            'rgba(0, 128, 0, 0.2)',   // Green
                            'rgba(0, 0, 255, 0.2)',   // Blue
                        ],
                        borderColor: [
                            'rgba(255, 0, 0, 1)',     // Red
                            'rgba(255, 165, 0, 1)',   // Orange
                            'rgba(255, 255, 0, 1)',   // Yellow
                            'rgba(0, 128, 0, 1)',     // Green
                            'rgba(0, 0, 255, 1)',     // Blue
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                },
            });

        },
        error: function (error) {
            console.log(error);
        }
    });

    $.ajax({
        type: "GET",
        url: "/api/dashboard/pie-chart",
        dataType: "json",
        success: function (data) {
            console.log(data);
            var ctx = $("#pieChart");
            var myBarChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Products per Category',
                        data: data.data,
                        backgroundColor: [
                            'rgba(255, 0, 0, 0.2)',   // Red
                            'rgba(255, 165, 0, 0.2)', // Orange
                            'rgba(255, 255, 0, 0.2)', // Yellow
                            'rgba(0, 128, 0, 0.2)',   // Green
                            'rgba(0, 0, 255, 0.2)',   // Blue
                            'rgba(238, 130, 238, 0.2)', // Violet
                            'rgba(255, 192, 203, 0.2)', // Pink
                            'rgba(128, 0, 128, 0.2)', // Purple
                            'rgba(0, 255, 255, 0.2)', // Cyan
                            'rgba(255, 165, 255, 0.2)' // Light Pink
                        ],
                        borderColor: [
                            'rgba(255, 0, 0, 1)',     // Red
                            'rgba(255, 165, 0, 1)',   // Orange
                            'rgba(255, 255, 0, 1)',   // Yellow
                            'rgba(0, 128, 0, 1)',     // Green
                            'rgba(0, 0, 255, 1)',     // Blue
                            'rgba(238, 130, 238, 1)', // Violet
                            'rgba(255, 192, 203, 1)', // Pink
                            'rgba(128, 0, 128, 1)',   // Purple
                            'rgba(0, 255, 255, 1)',   // Cyan
                            'rgba(255, 165, 255, 1)'  // Light Pink
                        ],
                        borderWidth: 1,
                        responsive: true,
                        // hoverBackgroundColor: colors,
                    }]
                },

            });

        },
        error: function (error) {
            console.log(error);
        }
    });
});