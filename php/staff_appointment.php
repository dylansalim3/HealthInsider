<?php

require_once "./database/appointment.php";
require_once "./database/doctor.php";

$appointment_db = new appointment();
$doctor_db = new doctor();

if (isset($_POST['process'])) {
    if ($_POST['process'] == "accept") {
        $appointment_db->accept($_POST['appointmentId'], $_POST['slotId']);
    } elseif ($_POST['process'] == "reject") {
        $appointment_db->reject($_POST['appointmentId']);
        if (strlen($_POST['reason']) > 0) {
            $appointment_db->rejectReason($_POST['appointmentId'], $_POST['reason']);
        }
    }
}

if (isset($_POST['slot'])) {
    if (!$_POST['date'] == null) {
        $appointment_db->addDoctorSlot($_POST['id'], $_POST['date'], $_POST['time']);
    }
}

$doctorArray = $doctor_db->getAll();
