const ROWSPERPAGE = 5;

// dom get element
let availablityTable = document.getElementById("availability");
let availabilityPage = document.getElementById("availabilityPage");
let pendingTable = document.getElementById("pending");
let pendingPage = document.getElementById("pendingPage");
let processId = document.getElementById("process_id");
let processName = document.getElementById("process_name");
let processDate = document.getElementById("process_date");
let processTime = document.getElementById("process_time");
let processSpecial = document.getElementById("process_special");
let processDoctor = document.getElementById("process_doctor");
let processSlot = document.getElementById("process_slot");
let processReason = document.getElementById("process_reason");
let rejectId = document.getElementById("rejectId");
let upcomingTable = document.getElementById("upcoming");
let upcomingPage = document.getElementById("upcomingPage");
let historyTable = document.getElementById("history");
let historyPage = document.getElementById("historyPage");

async function getPageNumber() {
  let res = await fetch("./php/staff_appointment_ajax.php?page");
  return res.json();
}

function showPageNumber(json) {
  // availability pagination
  let totalAvailability = Math.ceil(json.availability / ROWSPERPAGE);
  console.log(json.availability);

  for (let x = 1; x <= totalAvailability; x++) {
    let myLi = document.createElement("li");
    let link = document.createElement("a");

    if (x == 1) {
      myLi.classList.add('active');
    }

    myLi.classList.add("page-item");
    link.classList.add("page-link");
    myLi.classList.add("page-avail");
    link.addEventListener("click", () => {
      getAvailability(x).then(json => showAvailability(json));
      // remove class
      let allLink = document.querySelectorAll(".page-avail");
      for (let link1 of allLink) {
        link1.classList.remove('active');
      }
      myLi.classList.add('active');
    });
    link.innerHTML = x;
    myLi.append(link);
    availabilityPage.append(myLi);
  }
  // pending pagination
  // let totalPending = Math.ceil(json.pending / ROWSPERPAGE);
  // for (let x = 1; x <= totalPending; x++) {
  //   let link = document.createElement("li");
  //   link.classList.add("page-link");
  //   link.classList.add("page-pending");
  //   link.addEventListener("click", () => {
  //     getPending(x).then(json => showPending(json));
  //     // remove class
  //     let allLink = document.querySelectorAll(".page-pending");
  //     allLink.classList.remove('active');
  //
  //     link.classList.add('active');
  //   });
  //   link.innerHTML = x;
  //   pendingPage.append(link);
  // }
  let totalPending = Math.ceil(json.pending / ROWSPERPAGE);
  console.log(json.pending);

  for (let x = 1; x <= totalPending; x++) {
    let myLi = document.createElement("li");
    let link = document.createElement("a");

    if (x == 1) {
      myLi.classList.add('active');
    }

    myLi.classList.add("page-item");
    link.classList.add("page-link");
    myLi.classList.add("page-pending");
    link.addEventListener("click", () => {
      getPending(x).then(json => showPending(json));
      // remove class
      let allLink = document.querySelectorAll(".page-pending");
      for (let link1 of allLink) {
        link1.classList.remove('active');
      }
      myLi.classList.add('active');
    });
    link.innerHTML = x;
    myLi.append(link);
    pendingPage.append(myLi);
  }
  // upcoming pagination
  // let totalUpcoming = Math.ceil(json.upcoming / ROWSPERPAGE);
  // for (let x = 1; x <= totalUpcoming; x++) {
  //   let link = document.createElement("li");
  //   link.classList.add("page-link");
  //   link.addEventListener("click", () => {
  //     getUpcoming(x).then(json => showUpcoming(json));
  //   });
  //   link.innerHTML = x;
  //   upcomingPage.append(link);
  // }

  let totalUpcoming = Math.ceil(json.upcoming / ROWSPERPAGE);
  console.log(json.upcoming);

  for (let x = 1; x <= totalUpcoming; x++) {
    let myLi = document.createElement("li");
    let link = document.createElement("a");

    if (x == 1) {
      myLi.classList.add('active');
    }

    myLi.classList.add("page-item");
    link.classList.add("page-link");
    myLi.classList.add("page-up");
    link.addEventListener("click", () => {
      getUpcoming(x).then(json => showUpcoming(json));
      // remove class
      let allLink = document.querySelectorAll(".page-up");
      for (let link1 of allLink) {
        link1.classList.remove('active');
      }
      myLi.classList.add('active');
    });
    link.innerHTML = x;
    myLi.append(link);
    upcomingPage.append(myLi);
  }

// // history pagination
  // let totalHistory = Math.ceil(json.history / ROWSPERPAGE);
  // for (let x = 1; x <= totalHistory; x++) {
  //   let link = document.createElement("li");
  //   link.classList.add("page-link");
  //   link.addEventListener("click", () => {
  //     getHistory(x).then(json => showHistory(json));
  //   });
  //   link.innerHTML = x;
  //   historyPage.append(link);
  // }
  let totalHistory = Math.ceil(json.history / ROWSPERPAGE);
  console.log(json.history);

  for (let x = 1; x <= totalHistory; x++) {
    let myLi = document.createElement("li");
    let link = document.createElement("a");

    if (x == 1) {
      myLi.classList.add('active');
    }

    myLi.classList.add("page-item");
    link.classList.add("page-link");
    myLi.classList.add("page-history");
    link.addEventListener("click", () => {
      getHistory(x).then(json => showHistory(json));
      // remove class
      let allLink = document.querySelectorAll(".page-history");
      for (let link1 of allLink) {
        link1.classList.remove('active');
      }
      myLi.classList.add('active');
    });
    link.innerHTML = x;
    myLi.append(link);
    historyPage.append(myLi);
  }
}

var availablepage=0;

async function getAvailability(page) {
  let offset = (page - 1) * ROWSPERPAGE;
  let res = await fetch(
    `./php/staff_appointment_ajax.php?availability=${offset}`
  );
  availablepage=offset;
  return res.json();
}

function showAvailability(json) {
  availablityTable.innerHTML = "";
  let counter = 0;
  let i=1;
  for (let availability of json) {
    let row = availablityTable.insertRow(counter);
    let no = row.insertCell(0);
    no.innerHTML = i+availablepage;
    i++;
    let id = row.insertCell(1);
    id.innerHTML = availability.DOCTOR_ID;
    let name = row.insertCell(2);
    name.innerHTML = availability.NAME;
    let special = row.insertCell(3);
    special.innerHTML = availability.SPECIAL;
    let date = row.insertCell(4);
    date.innerHTML = availability.DOCTOR_DAY;
    let time = row.insertCell(5);
    time.innerHTML = formatTime(availability.DOCTOR_TIME);
    counter++;
  }
}

var pendingpage=0;
async function getPending(page) {
  let offset = (page - 1) * ROWSPERPAGE;
  let res = await fetch(`./php/staff_appointment_ajax.php?pending=${offset}`);
  pendingpage=offset;
  return res.json();
}

function showPending(json) {
  // clear table
  pendingTable.innerHTML = "";
  let counter = 0;
  let i=1;
  for (let pending of json) {
    // insert row
    let row = pendingTable.insertRow(counter);
    // insert cell
    let no = row.insertCell(0);
    no.innerHTML = i+pendingpage;
    i++;
    let id = row.insertCell(1);
    id.innerHTML = pending.NAME;
    let name = row.insertCell(2);
    name.innerHTML = pending.DESCRIPTION;
    let date = row.insertCell(3);
    date.innerHTML = pending.DATE;
    let time = row.insertCell(4);
    time.innerHTML = formatTime(pending.TIME);
    // process button
    let button = row.insertCell(5);
    button.innerHTML = `<td>
				<button type="button" class="btn btn-info btn-sm active-2"
					data-toggle="modal" data-target="#process">
					process
				</button>
			</td>`;
    button.addEventListener("click", () => {
      changeProcess(pending);
    });
    // counter
    counter++;
  }
}



async function changeProcess(pending) {
  processId.value = pending.APPOINTMENT_ID;
  rejectId.value = pending.APPOINTMENT_ID;
  processName.value = pending.NAME;
  processDate.value = pending.DATE;
  processTime.value = pending.TIME;
  processSpecial.value = pending.SPECIALIZATION;
  processDoctor.value = pending.DOCTOR_NAME;
  processSlot.value = pending.DOCTOR_SLOT_ID;
  processReason.value = pending.DESCRIPTION;

}


var upcomingpage=0;
async function getUpcoming(page) {
  let offset = (page - 1) * ROWSPERPAGE;
  let res = await fetch(`./php/staff_appointment_ajax.php?upcoming=${offset}`);
  upcomingpage=offset;
  return res.json();
}

function showUpcoming(json) {
  upcomingTable.innerHTML = "";
  let counter = 0;
  let i=1;
  for (let upcoming of json) {
    let row = upcomingTable.insertRow(counter);
    let no = row.insertCell(0);
    no.innerHTML = i+upcomingpage;
    i++;
    let id = row.insertCell(1);
    id.innerHTML = upcoming.NAME;
    let name = row.insertCell(2);
    name.innerHTML = upcoming.DESCRIPTION;
    let date = row.insertCell(3);
    date.innerHTML = upcoming.DATE;
    let time = row.insertCell(4);
    time.innerHTML = formatTime(upcoming.TIME);
    let doctor = row.insertCell(5);
    doctor.innerHTML = upcoming.DOCTOR;
    counter++;
  }
}

var historypage=0;
async function getHistory(page) {
  let offset = (page - 1) * ROWSPERPAGE;
  let res = await fetch(`./php/staff_appointment_ajax.php?history=${offset}`);
  // let res2 = res.json();
  // res2['offset'] = offset;
  // console.log(res2['offset']);
  historypage=offset;
  return res.json();
}

function showHistory(json) {
  historyTable.innerHTML = "";
  let counter = 0;
  let i=5;
  for (let history of json) {
    let row = historyTable.insertRow(counter);
    let no = row.insertCell(0);
    console.log(json['offset']);
    no.innerHTML = i+historypage;
    i--;
    

    let id = row.insertCell(1);
    id.innerHTML = history.NAME;
    let name = row.insertCell(2);
    name.innerHTML = history.DESCRIPTION;
    let date = row.insertCell(3);
    date.innerHTML = history.DATE;
    let time = row.insertCell(4);
    time.innerHTML = formatTime(history.TIME);
    let doctor = row.insertCell(5);
    doctor.innerHTML = history.DOCTOR;
    let status = row.insertCell(6);
    status.innerHTML = showStatus(history.STATUS);
  }
}

function showStatus(num) {
  switch (num) {
    case 0: {
      return '<h6><span class="badge badge-danger">Rejected</span></h6>';
    }
    case 1: {
      return '<h6><span class="badge badge-success">Successful</span></h6>';
    }
    case 2: {
      return '<h6><span class="badge badge-info">Pending</span></h6>';
    }
  }
}

function formatTime(time) {
  let tempTime = time.split(":");
  return tempTime[0] + ":" + tempTime[1];
}

getAvailability(1).then(json => showAvailability(json));
getPending(1).then(json => showPending(json));
getUpcoming(1).then(json => showUpcoming(json));
getHistory(1).then(json => showHistory(json));
getPageNumber().then(json => showPageNumber(json));

