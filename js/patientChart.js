let dropdown = document.getElementById("chartType");
let canvas = document.getElementById("canvas1");
let canvas2 = document.getElementById("canvas2");
let barBtn = document.getElementById("bar");
let lineBtn = document.getElementById("line");
let doughnutBtn = document.getElementById("doughnut");
let pieBtn = document.getElementById("pie");
let polarBtn = document.getElementById("polar");

dropdown.addEventListener("change", () => {
  let type = dropdown.value;
  console.log(type);
  graph(type);
});

function setChartBtn(labels, data) {
  barBtn.addEventListener("click", () => {
    bar(canvas, labels, data);
  });
  lineBtn.addEventListener("click", () => {
    line(canvas, labels, data);
  });
  doughnutBtn.addEventListener("click", () => {
    doughnut(canvas2, labels, data);
  });
  pieBtn.addEventListener("click", () => {
    pie(canvas2, labels, data);
  });
  polarBtn.addEventListener("click", () => {
    polar(canvas2, labels, data);
  });
}

async function graph(type) {
  let res = await fetch(`./php/staff_patient_chart.php?${type}`);
  let json = await res.json();
  let labels = [];
  let data = [];

  for (let label in json) {
    labels.push(label);
    data.push(json[label]);
  }

  bar(canvas, labels, data);
  doughnut(canvas2, labels, data);
  setChartBtn(labels, data);
}

graph("day");

//autocomplete name
let patientName = document.getElementById("patient-name");
let patientId = document.getElementById("patient-id");

patientId.addEventListener("input", ()=> {
  let id = patientId.value;
  fetch(`./php/staff_patient_chart.php?id=${id}`)
    .then(res => res.json())
    .then((json) => {
      patientName.value = json;
    })
});