<?php

require_once('database.php');

class doctor
{
    private $database;

    public function __construct()
    {
        $this->database = new database();
    }

    public function getAll(): ?array
    {
        $statement = $this->database->prepare("
            select DOCTOR_ID, DOCTOR_NAME from doctor
        ");
        $statement->execute();
        return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getName($doctorID): ?string
    {
        $statement = $this->database->prepare("
            select DOCTOR_NAME from doctor where DOCTOR_ID = {$doctorID}
        ");
        $statement->execute();
        return $statement->get_result()->fetch_row()[0];
    }

    public function getSpecial($doctorID): ?string
    {
        $statement = $this->database->prepare("
            select SPECIALIZATION from doctor where DOCTOR_ID = {$doctorID}
        ");
        $statement->execute();
        return $statement->get_result()->fetch_row()[0];
    }
}
