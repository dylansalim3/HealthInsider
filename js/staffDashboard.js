let patients = document.querySelector("#patients");
let staffs = document.querySelector("#staffs");
let users = document.querySelector("#users");
let visitors = document.querySelector("#visitors");
let wardEmpty = document.querySelector("#wardEmpty");
let wardPatient = document.querySelector("#wardPatient");
let appointment = document.querySelector("#appointment");

function view(data) {
  patients.innerHTML = data["patients"];
  staffs.innerHTML = data["staffs"];
  users.innerHTML = data["users"];
  visitors.innerHTML = data["visitors"];
  wardEmpty.innerHTML = data["wardEmpty"];
  wardPatient.innerHTML = data["wardPatient"];
}

function update() {
  fetch("./php/staff_dashboard.php")
    .then(response => response.json())
    .then(json => view(json));
}

function viewAppointment(list) {
  let table = document.querySelector("#appointment");
  table.innerHTML = "";

  if (list.length == 0) {
    document.getElementById("none").style.display = "unset";
    return;
  }

  for (let i = 0; i < list.length; i++) {
    row = document.createElement("tr");

    data = document.createElement("td");
    data.innerHTML = i + 1;
    row.append(data);

    data = document.createElement("td");
    data.innerHTML = list[i].PATIENT;
    row.append(data);

    data = document.createElement("td");
    data.innerHTML = list[i].DOCTOR;
    row.append(data);

    data = document.createElement("td");
    time = list[i].TIME.split(":");
    data.innerHTML = time[0] + ":" + time[1];
    row.append(data);

    table.append(row);
  }
}

function updateAppointment() {
  fetch("./php/staff_dashboard_appointment.php")
    .then(res => res.json())
    .then(json => viewAppointment(json));
}

update();
updateAppointment();

document.querySelectorAll(".card-footer").forEach(cardFooter => {
  cardFooter.addEventListener("mouseover", () => {
    cardFooter.style.cursor = "pointer";
  });
  cardFooter.addEventListener("click", () => {
    update();
    updateAppointment();
  });
});
setInterval(() => {
  update();
  updateAppointment();
  console.log("update");
}, 1000 * 30);
