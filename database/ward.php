<?php

require_once "database.php";

class ward
{
    private $database;

    public function __construct()
    {
        $this->database = new database();
    }

    public function getWards(): ?array
    {
        $statement = $this->database->prepare("
            select * from ward
        ");
        $statement->execute();
        return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getPatient(int $wardId)
    {
        $statement = $this->database->prepare("
            select PATIENT_ID from ward
            where WARD_ID = {$wardId}
        ");
        $statement->execute();
        return $statement->get_result()->fetch_row()[0];
    }

//    patinetId = 0 to checkout a patient
    public function setPatient($patientID, int $wardID)
    {
        if ($patientID == 0) {
            $statement = $this->database->prepare("
            update ward set PATIENT_ID =null where WARD_ID = ?
            ");
            $statement->bind_param('i', $wardID);
            $statement->execute();
            $statement = $this->database->prepare("
            update patient set WARD_ID =null where PATIENT_ID = ?
            ");
            $statement->bind_param('i', $patientID);
            $statement->execute();
            return;
        }
        $statement = $this->database->prepare("
            update ward set PATIENT_ID =? where WARD_ID = ?
        ");
        $statement->bind_param('ii', $patientID, $wardID);
        $statement->execute();
        $statement = $this->database->prepare("
            update patient set WARD_ID =? where PATIENT_ID = ?
        ");
        $statement->bind_param('ii', $wardID, $patientID);
        $statement->execute();
    }

    public function checkoutPatient($patientID, $wardID)
    {
        $statement = $this->database->prepare("
            update ward set PATIENT_ID =null where WARD_ID = ?
            ");
        $statement->bind_param('i', $wardID);
        $statement->execute();
        $statement = $this->database->prepare("
            update patient set WARD_ID =null where PATIENT_ID = ?
            ");
        $statement->bind_param('i', $patientID);
        $statement->execute();
    }

    public function whichWard(int $patientID): ?int
    {
        $statement = $this->database->prepare("
            select WARD_ID from ward where PATIENT_ID = ?
        ");
        $statement->bind_param('i', $patientID);
        $statement->execute();
        return $statement->get_result()->fetch_row()[0];
    }

    public function ocupiedWard(): ?int
    {
        $statement = $this->database->prepare("
            select count(*) from ward
        ");
        $statement->execute();
        return ($statement->get_result()->fetch_row()[0]) - $this->availableWard();
    }

    public function availableWard(): ?int
    {
        $statement = $this->database->prepare("
            select count(*) from ward where PATIENT_ID is null 
        ");
        $statement->execute();
        return $statement->get_result()->fetch_row()[0];
    }

}
