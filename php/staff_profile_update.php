<?php

require_once('../database/staff.php');
require_once('../database/user.php');

$staff_model = new staff();
$user_model = new user();

function uploadPicture()
{
    global $user_model;
    $tempDir = $_FILES['picture']['tmp_name'];
    $destDir = '../uploads/';
    $fileName = $user_model->getUserID($_POST['oldName']) . "." . pathinfo($_FILES['picture']['name'])['extension'];
    if (move_uploaded_file($tempDir, $destDir . $fileName)) {
        //        echo 'g';
    } else {
        var_dump($_FILES);
    }
}

function insertData()
{
    global $staff_model;
    global $user_model;

    if (checkPassword($_POST['oldName'], $_POST['oldPassword'])) {
        $staffID = $user_model->getStaffID($_POST['oldName']);
        $user_model->update($staffID, $_POST);
        $staff_model->update($staffID, $_POST);
    }
}

function checkPassword(string $oldName, string $password): ?bool
{
    global $user_model;
    return $user_model->checkPassword($oldName, $password);
}

if (count($_POST) < 3) {
    echo json_encode(checkPassword($_POST['oldName'], $_POST['password']));
} else {
    if (checkPassword($_POST['oldName'], $_POST['oldPassword'])) {
        insertData();
        if (strlen($_FILES['picture']['name']) > 0) {
            uploadPicture();
        }
    }
}
