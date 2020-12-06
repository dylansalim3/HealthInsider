<?php

require_once('database.php');

class staff
{
    private $database;

    public function __construct()
    {
        $this->database = new database();
    }

    public function profile(int $id)
    {
        $statement = $this->database->prepare("
            select * from staff where STAFF_ID = ?
        ");
        $statement->bind_param('i', $id);
        $statement->execute();
        return $statement->get_result()->fetch_assoc();
    }

    public function contains(string $column, $value)
    {
        $statement = $this->database->prepare("
            select * from staff where {$column} = ?
        ");
        $statement->bind_param('s', $value);
        $statement->execute();
        $result = $statement->get_result()->fetch_assoc();
        if ($result) {
            return true;
        }
        return false;
    }

    public function insert(array $staffArray)
    {
        $statement = $this->database->prepare(
            'insert into staff (NAME, DOB, NRIC, ADDRESS, CONTACT, GENDER) ' .
            'values (?,?,?,?,?,?)'
        );
        $statement->bind_param(
            'ssssss',
            $staffArray['name'],
            $staffArray['dob'],
            $staffArray['nric'],
            $staffArray['address'],
            $staffArray['contact'],
            $staffArray['gender']
        );
        $statement->execute();
    }

    public function update($staffID, $staffArray)
    {
        //        staff table
        $statement = $this->database->prepare("
            update staff 
            set NAME=?,DOB=?,NRIC=?,ADDRESS=?,CONTACT=?,GENDER=?
            where STAFF_ID = {$staffID}
        ");
        $statement->bind_param(
            'ssssss',
            $staffArray['name'],
            $staffArray['dob'],
            $staffArray['nric'],
            $staffArray['address'],
            $staffArray['contact'],
            $staffArray['gender'],
            );
        $statement->execute();
    }

    public function lastID(): ?int
    {
        return $this->database->insert_id;
    }

    public function numbers(): ?int
    {
        $statement = $this->database->prepare("
            select count(*) from staff;
        ");
        $statement->execute();
        return $statement->get_result()->fetch_row()[0];
    }
}
