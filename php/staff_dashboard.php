<?php

require_once('../database/staff.php');
require_once('../database/user.php');
require_once('../database/patient.php');
require_once('../database/visitor.php');
require_once('../database/ward.php');

$staff_model = new staff();
$user_model = new user();
$patient_model = new patient();
$visitor_model = new visitor();
$ward_model = new ward();
$array = array();

$array['patients'] = $patient_model->numbers();
$array['staffs'] = $staff_model->numbers();
$array['users'] = $user_model->numbers();
$array['visitors'] = $visitor_model->numbers();
$array['wardEmpty'] = $ward_model->availableWard();
$array['wardPatient'] = $ward_model->ocupiedWard();

echo(json_encode($array));
