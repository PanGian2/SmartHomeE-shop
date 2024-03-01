function createLoginLogoutChart(login, durations) {
    // Format date
    const formattedDates = login.map(date => luxon.DateTime.fromFormat(date, 'dd-MM-yyyy, HH:mm'));
    console.log(formattedDates)

    const ctx = document.getElementById('loginChart').getContext('2d');
    const loginHistoryChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: formattedDates,
            datasets: [{
                label: 'Login Duration (minutes)',
                data: durations,
                borderColor: 'rgb(75, 192, 192)',
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                x: {
                    type: 'time',
                    display: true,
                    time: {
                        unit: "day",
                        round: "day",
                        displayFormats: {
                            day: 'DD'
                        }
                    },
                    title: {
                        display: true,
                        text: 'Login Time'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Duration (seconds)'
                    }
                }
            }
        }
    });
}
