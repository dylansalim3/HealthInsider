<?php

require_once "database/inventory.php";

$inventory_db = new inventory();

$recordsPerPage = 7;
$totalPage = ceil($inventory_db->numbers() / $recordsPerPage);
$inventory_db->setLimit($recordsPerPage);

if (isset($_POST['add'])) {
    $inventory_db->addStock($_POST['add'], $_POST['num']);
}
if (isset($_POST['minus'])) {
    $inventory_db->minusStock($_POST['minus'], $_POST['num']);
}
if (isset($_POST['edit'])) {
    $inventory_db->editStock($_POST['edit'], $_POST);
}
if (isset($_POST['delete'])) {
    $inventory_db->deleteStock($_POST['delete']);
}
if (isset($_POST['create'])) {
    $inventory_db->createStock($_POST);
}


if (isset($_GET['page'])) {
    $page = $_GET['page'];
    $inventories = $inventory_db->getAllItem(($page - 1) * $recordsPerPage);
} else {
    $page = 1;
    $inventories = $inventory_db->getAllItem();
}
