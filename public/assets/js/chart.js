document.addEventListener("DOMContentLoaded", function() {
    const myChart = document.querySelector(".myChart");

    new Chart(myChart, {
        type: "doughnut",
        data: {
            labels: chartData.labels,
            datasets: [{
                data: chartData.data,
                backgroundColor: chartData.backgroundColor,
                hoverBackgroundColor: chartData.backgroundColor.map(color => color.replace("rgb", "rgba").replace(")", ", 0.8)")), // Lighten on hover
                hoverBorderColor: "rgba(234, 236, 244, 1)"
            }]
        },
        options: {
            responsive: true, // Make it responsive
            maintainAspectRatio: false, // Allow flexible sizing
            cutoutPercentage: 30, // Adjust the inner hole size (Lower value = Smaller hole)
            legend: {
                display: true,
                position: 'bottom', // Show legend at the bottom
                labels: {
                    fontColor: "#333", // Text color
                    fontSize: 14
                }
            },
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 10,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10
            },
            animation: {
                animateScale: true, // Scale animation on load
                animateRotate: true // Rotate animation on load
            },
            hover: {
                mode: 'nearest',
                intersect: true
            }
        }
    });
});
