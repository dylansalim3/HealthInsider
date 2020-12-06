<?php

require_once('../database/visitor.php');

$visitor_model = new visitor();

if (isset($_GET['increment'])) {
    $visitor_model->increment();
    die();
}

echo $visitor_model->numbers();
