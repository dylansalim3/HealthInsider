<?php

require_once('./database/staff.php');
require_once('./database/user.php');

$staff_model = new staff();
$user_model = new user();

if (isset($_GET)) {
    $staffID = $user_model->getStaffID($login_session);
    $staffArray = $staff_model->profile($staffID);
    $userArray = $user_model->profile($login_session);
}
