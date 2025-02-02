$.ajax({
  url: `stats`,
  method: "GET",
  dataType: 'json',
  success: function (data) {
    const statistics_chart = document.getElementById("myChart").getContext('2d');

    chartStats(statistics_chart, data);
  }
});

function chartStats(chart, data) {
  new Chart(chart, {
    type: 'line',
    data: {
      labels: data.tahun.slice(-10),
      datasets: [{
        label: 'Statistics',
        data: data.total.slice(-10),
        borderWidth: 5,
        borderColor: '#6777ef',
        backgroundColor: 'transparent',
        pointBackgroundColor: '#fff',
        pointBorderColor: '#6777ef',
        pointRadius: 4
      }]
    },
    options: {
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          gridLines: {
            display: false,
            drawBorder: false,
          },
          ticks: {
            stepSize: 150
          }
        }],
        xAxes: [{
          gridLines: {
            color: '#fbfbfb',
            lineWidth: 2
          }
        }]
      },
    }
  });
}