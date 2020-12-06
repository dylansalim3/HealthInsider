<?php

require_once "database/record.php";
require_once "database/patient.php";
require_once "database/ward.php";

$record_db = new record();
$patient_db = new patient();
$ward_db = new ward();

$getAvailablePatient = $patient_db->getAllAvailablePatient();
$recordsPerPage = 7;
$totalPage = ceil($record_db->numbers() / $recordsPerPage);
$record_db->setLimit($recordsPerPage);

if (isset($_POST['delete'])) {
    $record_db->deleteRecord($_POST['delete']);
}

if (isset($_POST['add'])) {
    $_POST['TIME'] = date("H:i:s", strtotime($_POST['TIME']));
    $record_db->addRecord($_POST);
    $patient_db->updateRecord($_POST);
}

if (isset($_GET['page'])) {
    $page = $_GET['page'];
    $records = $record_db->getAllRecord(($page - 1) * $recordsPerPage);
} else {
    $page = 1;
    $records = $record_db->getAllRecord();
}

if (isset($_POST['ward'])) {
    $type = $_POST['ward'];
    $wardId = $_POST['wardId'];
    $patientId = $_POST['patientId'];
    if ($type == 1) {
        $ward_db->checkoutPatient($patientId, $wardId);
    } elseif ($type == 2) {
        $patientId = $_POST['patientId'];
        $ward_db->setPatient($patientId, $wardId);
    }
}

//$wards = $ward_db->getWards();
//foreach ($wards as $key => $ward) {
//    if ($ward['PATIENT_ID'] === null) {
//        $wards[$key]['PATIENT_NAME'] = "";
//    }
//    else {
//        $wards[$key]['PATIENT_NAME'] = $patient_db->getName($ward['PATIENT_ID']);
//    }
//}
