<?php

require_once('database/staff.php');
require_once('database/user.php');

if ($_POST) {
    $staff_model = new staff();
    $user_model = new user();

    foreach ($_POST as $value) {
        if (!$value) {
            header("Location:sign_up_staff.php?error=emptyfields");
        }
    }
    if ($user_model->contains($_POST['email'], $_POST['username'])) {
        header("Location:sign_up_staff.php?error=userexists");
    }
    if ($staff_model->contains('name', $_POST['name'])) {
        header("Location:sign_up_staff.php?error=userexists");
    };
    if ($staff_model->contains('nric', $_POST['nric'])) {
        header("Location:sign_up_staff.php?error=userexists");
    };

    $_POST['contact'] = $_POST['prefix'] . '-' . $_POST['phone'];
    $staff_model->insert($_POST);
    $staffID = $staff_model->lastID();
    $_POST['staffID'] = $staffID;
    $user_model->insert($_POST);
}
