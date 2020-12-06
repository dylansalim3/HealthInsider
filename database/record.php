<?php

require_once "database.php";

class record
{
    private $database;
    private $limit = 1;

    public function __construct()
    {
        $this->database = new database();
    }

    public function setLimit(int $limit)
    {
        $this->limit = $limit;
    }

    public function numbers(): ?int
    {
        $statement = $this->database->prepare("
            select count(*) from patient_history
        ");
        $statement->execute();
        return $statement->get_result()->fetch_row()[0];
    }

    public function getRecord(int $patientId): ?array
    {
        $statement = $this->database->prepare("
            select * from patient_history inner join patient
            on patient.PATIENT_ID = patient_history.PATIENT_ID
            where patient.PATIENT_ID = {$patientId}
        ");
        $statement->execute();
        return $statement->get_result()->fetch_assoc();
    }

    public function getAllRecord(int $offset = 0): ?array
    {
        $statement = $this->database->prepare("
            select ph.PATIENT_ID, ph.PATIENT_HISTORY_ID, ph.DATE, ph.TIME, ph.HEIGHT, ph.WEIGHT, ph.BMI, ph.SYSTOLIC, ph.DIASTOLIC, ph.HEART_RATE, ph.LDL, ph.PATIENT_HISTORY, p.PATIENT_NAME
            from patient_history as ph inner join patient as p
            on p.PATIENT_ID = ph.PATIENT_ID
            limit {$offset}, {$this->limit}
        ");
        $statement->execute();
        return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function addRecord(array $data)
    {
        $statement = $this->database->prepare("
            insert into patient_history (PATIENT_ID, DATE, TIME, HEIGHT, WEIGHT, SYSTOLIC, DIASTOLIC, HEART_RATE, LDL, PATIENT_HISTORY) 
            VALUES (?,?,?,?,?,?,?,?,?,?);
        ");
        $statement->bind_param(
            'issddiiiis',
            $data['PATIENT_ID'],
            $data['DATE'],
            $data['TIME'],
            $data['HEIGHT'],
            $data['WEIGHT'],
            $data['SYSTOLIC'],
            $data['DIASTOLIC'],
            $data['HEART_RATE'],
            $data['LDL'],
            $data['PATIENT_HISTORY']
        );
        $statement->execute();
    }

    public function deleteRecord(int $recordId)
    {
        $statement = $this->database->prepare("
            delete from patient_history
            where PATIENT_HISTORY_ID = {$recordId}
        ");
        $statement->execute();
    }

    public function getAllDate(): ?array
    {
        $statement = $this->database->prepare("
            select DATE from patient_history
        ");
        $statement->execute();
        return $statement->get_result()->fetch_all();
    }

    public function getAllBmi(): ?array
    {
        $statement = $this->database->prepare("
            select BMI from patient_history
        ");
        $statement->execute();
        return $statement->get_result()->fetch_all();
    }

    public function getAllBlood(): ?array
    {
        $statement = $this->database->prepare("
            select SYSTOLIC, DIASTOLIC, HEART_RATE
            from patient_history
        ");
        $statement->execute();
        return $statement->get_result()->fetch_all();
    }

    public function getAllLdl(): ?array
    {
        $statement = $this->database->prepare("
            select LDL from patient_history
        ");
        $statement->execute();
        return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}