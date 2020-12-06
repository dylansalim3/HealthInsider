<?php

require_once "../database/record.php";
require_once "../database/patient.php";
require_once "../database/ward.php";

$record_db = new record();
$patient_db = new patient();
$ward_db = new ward();

if (isset($_GET['id'])) {
    $name = $patient_db->getName($_GET['id']);
    echo json_encode($name);
}


if (isset($_GET['day'])) {
    $data = $record_db->getAllDate();
    $dayArray = [
        'Mon' => 0,
        'Tue' => 0,
        'Wed' => 0,
        'Thu' => 0,
        'Fri' => 0,
        'Sat' => 0,
        'Sun' => 0
    ];
    foreach ($data as $date) {
        $day = date('D', strtotime(date('Y-m-d', strtotime($date[0]))));
        $dayArray[$day]++;
    }
    echo json_encode($dayArray);
}

if (isset($_GET['gender'])) {
    $data = $patient_db->getAllGender();
    $genderArray = [
        'Male' => 0,
        'Female' => 0
    ];
    foreach ($data as $gender) {
        switch ($gender[0]) {
            case 0:
                $genderArray['Male']++;
                break;
            case 1:
                $genderArray['Female']++;
                break;
        }
    }
    echo json_encode($genderArray);
}

if (isset($_GET['bmi'])) {
    $data = $record_db->getAllBmi();
    $bmiArray = [
        'Underweight' => 0,
        'Normal' => 0,
        'Overweight' => 0,
        'Obese' => 0
    ];
    foreach ($data as $bmi) {
        $bmi = $bmi[0];
        if ($bmi < 18.5) {
            $bmiArray['Underweight']++;
        } elseif ($bmi < 25) {
            $bmiArray['Normal']++;
        } elseif ($bmi < 30) {
            $bmiArray['Overweight']++;
        } else {
            $bmiArray['Obese']++;
        }
    }
    echo json_encode($bmiArray);
}

if (isset($_GET['blood'])) {
    $data = $record_db->getAllBlood();
    $bloodArray = [
        'Low' => 0,
        'Ideal' => 0,
        'Pre-high' => 0,
        'High' => 0
    ];
    foreach ($data as $blood) {
        $blood = $blood[0];
        if (($blood['SYSTOLIC'] < 90) and ($blood['DIASTOLIC'] < 60)) {
            $bloodArray['Low']++;
        } elseif (($blood['SYSTOLIC'] < 120) and ($blood['DIASTOLIC'] < 80)) {
            $bloodArray['Ideal']++;
        } elseif (($blood['SYSTOLIC'] < 140) and ($blood['DIASTOLIC'] < 90)) {
            $bloodArray['Pre-high']++;
        } else {
            $bloodArray['High']++;
        }
    }
    echo json_encode($bloodArray);
}

if (isset($_GET['ldl'])) {
    $data = $record_db->getAllLdl();
    $ldlArray = [
        'Optimal' => 0,
        'Near Optimal' => 0,
        'Borderline' => 0,
        'High' => 0,
        'Very High' => 0
    ];
    foreach ($data as $ldl) {
        if ($ldl < 100) {
            $ldlArray['Optimal']++;
        } elseif ($ldl < 140) {
            $ldlArray['Near Optimal']++;
        } elseif ($ldl < 160) {
            $ldlArray['Borderline']++;
        } elseif ($ldlArray < 190) {
            $ldlArray['High']++;
        } else {
            $ldlArray['Very High']++;
        }
    }
    echo json_encode($ldlArray);
}