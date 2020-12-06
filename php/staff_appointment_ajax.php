<?php

require_once "../database/appointment.php";
require_once "../database/doctor.php";
require_once "../database/patient.php";
require_once "../database/visitor.php";

$appointment_db = new appointment();
$doctor_db = new doctor();
$patient_db = new patient();
$visitor_db = new visitor();

if (isset($_GET['page'])) {
    echo json_encode($appointment_db->numbers());
}

if (isset($_GET['availability'])) {
    $array = $appointment_db->getDoctorSlot($_GET['availability']);
    foreach ($array as $key => $val) {
        $array[$key]['NAME'] = $doctor_db->getName($val['DOCTOR_ID']);
        $array[$key]['SPECIAL'] = $doctor_db->getSpecial($val['DOCTOR_ID']);
    }
    echo json_encode($array);
}

if (isset($_GET['pending'])) {
    $array = $appointment_db->pending($_GET['pending']);
    foreach ($array as $key => $val) {
        $array[$key]['NAME'] = $patient_db->getName($val['PATIENT_ID']);
        $array[$key]['DOCTOR_NAME'] = $doctor_db->getName($val['DOCTOR_ID']);
        $array[$key]['SPECIALIZATION'] = $doctor_db->getSpecial($val['DOCTOR_ID']);
    }
    echo json_encode($array);
}

if (isset($_GET['upcoming'])) {
    $array = $appointment_db->upcoming($_GET['upcoming']);
    foreach ($array as $key => $val) {
        $array[$key]['NAME'] = $patient_db->getName($val['PATIENT_ID']);
        $array[$key]['DOCTOR'] = $doctor_db->getName($val['DOCTOR_ID']);
    }
    echo json_encode($array);
}

if (isset($_GET['history'])) {
    $array = $appointment_db->history($_GET['history']);
    foreach ($array as $key => $val) {
        $array[$key]['NAME'] = $patient_db->getName($val['PATIENT_ID']);
        $array[$key]['DOCTOR'] = $doctor_db->getName($val['DOCTOR_ID']);
    }
    echo json_encode($array);
}

if (isset($_GET['special'])) {
    $special = $_GET['special'];
    $date = $_GET['date'];
    $time = $_GET['time'];
    $array = $appointment_db->getDoctor($special, $date, $time);
    echo json_encode($array);
}

if (isset($_GET['event'])) {
    $events = $appointment_db->getEvents();
    $counter = 0;
    foreach ($events as $key => $event) {
        $counter++;
        $events[$key]['id'] = $counter;
        $events[$key]['title'] = $event['PATIENT_NAME'].'('.$event['DOCTOR_ID'].')';
        $events[$key]['start'] = $event['DATE'].'T'.$event['TIME'];
        $events[$key]['end'] = $event['DATE'].'T'.$event['TIME'];
    }
    echo json_encode($events);
}
