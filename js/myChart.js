Chart.defaults.global.defaultFontSize = 20;
const backgroundColor = [
  "rgba(255, 99, 132, 0.4)",
  "rgba(54, 162, 235, 0.4)",
  "rgba(255, 206, 86, 0.4)",
  "rgba(75, 192, 192, 0.4)",
  "rgba(153, 102, 255, 0.4)",
  "rgba(255, 159, 64, 0.4)"
];
const borderColor = [
  "rgba(255, 99, 132, 1)",
  "rgba(54, 162, 235, 1)",
  "rgba(255, 206, 86, 1)",
  "rgba(75, 192, 192, 1)",
  "rgba(153, 102, 255, 1)",
  "rgba(255, 159, 64, 1)"
];
const options = {
  legend: {
    display: false
  },
  responsive: true,
  maintainAspectRatio: false,
  scales: {
    yAxes: [
      {
        ticks: {
          beginAtZero: true
        },
        scaleLabel: {
          display: true,
          labelString: 'Number of patients'
        }
      }
    ]
  }
};
const options2 = {
  responsive: true,
  maintainAspectRatio: false
};
const borderWidth = 1;
const hoverBorderColor = "#777";
const hoverBorderWidth = 3;
let currentChart1 = [];
let currentChart2 = [];

function clearCanvas1() {
  while (currentChart1.length > 0) {
    currentChart1.pop().destroy();
  }
}

function clearCanvas2() {
  while (currentChart2.length > 0) {
    currentChart2.pop().destroy();
  }
}

function bar(canvas, labels, data) {
  clearCanvas1();
  let chart = new Chart(canvas, {
    type: "bar",
    data: {
      labels: labels,
      datasets: [
        {
          data: data,
          backgroundColor: backgroundColor,
          borderColor: borderColor,
          borderWidth: borderWidth,
          hoverBorderColor: hoverBorderColor,
          hoverBorderWidth: hoverBorderWidth
        }
      ]
    },
    options: options
  });
  currentChart1.push(chart);
}

function line(canvas, labels, data) {
  clearCanvas1();
  let chart = new Chart(canvas, {
    type: "line",
    data: {
      labels: labels,
      datasets: [
        {
          data: data,
          backgroundColor: backgroundColor,
          pointBackgroundColor: "#777",
          borderColor: "#777",
          borderWidth: borderWidth,
          hoverBorderColor: hoverBorderColor,
          hoverBorderWidth: hoverBorderWidth
        }
      ]
    },
    options: options
  });
  currentChart1.push(chart);
}

function doughnut(canvas, labels, data) {
  clearCanvas2();
  let chart = new Chart(canvas, {
    type: "doughnut",
    data: {
      labels: labels,
      datasets: [
        {
          data: data,
          backgroundColor: borderColor,
          borderColor: "#777",
          borderWidth: borderWidth,
          hoverBorderColor: hoverBorderColor,
          hoverBorderWidth: hoverBorderWidth
        }
      ]
    },
    options: options2
  });
  currentChart2.push(chart);
}

function pie(canvas, labels, data) {
  clearCanvas2();
  let chart = new Chart(canvas, {
    type: "pie",
    data: {
      labels: labels,
      datasets: [
        {
          data: data,
          backgroundColor: borderColor,
          borderColor: "#777",
          borderWidth: borderWidth,
          hoverBorderColor: hoverBorderColor,
          hoverBorderWidth: hoverBorderWidth
        }
      ]
    },
    options: options2
  });
  currentChart2.push(chart);
}

function polar(canvas, labels, data) {
  clearCanvas2();
  let chart = new Chart(canvas, {
    type: "polarArea",
    data: {
      labels: labels,
      datasets: [
        {
          data: data,
          backgroundColor: borderColor,
          borderColor: "#777",
          borderWidth: borderWidth,
          hoverBorderColor: hoverBorderColor,
          hoverBorderWidth: hoverBorderWidth
        }
      ]
    },
    options: options2
  });
  currentChart2.push(chart);
}
