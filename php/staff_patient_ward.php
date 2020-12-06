<?php

require_once "../database/record.php";
require_once "../database/patient.php";
require_once "../database/ward.php";

$record_db = new record();
$patient_db = new patient();
$ward_db = new ward();

// return list of patient id to choose
if (isset($_GET['availablePatient'])) {
    $wardId = $_GET['availablePatient'];
    $patientIdArray = [];

    $patientIdArray[] = $ward_db->getPatient($wardId);
    $tempArray = $patient_db->getAllAvailablePatient();
    foreach ($tempArray as $val) {
        $patientIdArray[] = $val['PATIENT_ID'];
    }

    sort($patientIdArray);

    echo json_encode($patientIdArray);
}

// return patient id in ward
if (isset($_GET['patientInWard'])) {
    $wardId = $_GET['patientInWard'];
    $patientId = $ward_db->getPatient($wardId);

    echo json_encode($patientId);
}

//return patient name with id
if (isset($_GET['patientName'])) {
    $patientId = $_GET['patientName'];
    $patientName = $patient_db->getName($patientId);

    echo json_encode($patientName);
}