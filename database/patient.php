<?php

require_once('database.php');

class patient
{
    private $database;

    public function __construct()
    {
        $this->database = new database();
    }

    public function numbers(): ?int
    {
        $statement = $this->database->prepare("
            select count(*) from patient
        ");
        $statement->execute();
        return $statement->get_result()->fetch_row()[0];
    }

    public function getName(int $patientID): ?string
    {
        $statement = $this->database->prepare("
            select PATIENT_NAME from patient where PATIENT_ID = {$patientID}
        ");
        $statement->execute();
        return $statement->get_result()->fetch_row()[0];
    }

    public function getPatient(int $patientID): ?array
    {
        $statement = $this->database->prepare("
            select * from patient
            where PATIENT_ID = {$patientID}
        ");
        $statement->execute();
        return $statement->get_result()->fetch_assoc();
    }

    public function getAllPatient(): ?array
    {
        $statement = $this->database->prepare("
           select * from patient 
        ");
        $statement->execute();
        return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllGender(): ?array
    {
        $statement = $this->database->prepare("
           select GENDER from patient 
        ");
        $statement->execute();
        return $statement->get_result()->fetch_all();
    }

    public function updateRecord($data)
    {
        $statement = $this->database->prepare("
           update patient
           set `HEIGHT`={$data['HEIGHT']} , `WEIGHT`={$data['WEIGHT']} , `LDC`={$data['LDL']} , 
           `SYSTOLIC`={$data['SYSTOLIC']}, `DIASTOLIC`={$data['DIASTOLIC']}, `HEART_RATE`={$data['HEART_RATE']}
            where PATIENT_ID={$data['PATIENT_ID']}
        ");
        $statement->execute();
    }

//    patient with no ward
    public function getAllAvailablePatient(): ?array
    {
        $statement = $this->database->prepare("
            select PATIENT_ID from patient   
            where WARD_ID is null
        ");
        $statement->execute();
        return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
