<?php

require_once "../database/appointment.php";
require_once "../database/doctor.php";
require_once "../database/patient.php";

$appointment_model = new appointment();
$doctor_model = new doctor();
$patient_model = new patient();

$appointmentList = $appointment_model->todayList();
foreach ($appointmentList as $index => $appointment) {
    $appointmentList[$index]['PATIENT'] = $patient_model->getName($appointment['PATIENT_ID']);
    $appointmentList[$index]['DOCTOR'] = $doctor_model->getName($appointment['DOCTOR_ID']);
}

echo json_encode($appointmentList);
