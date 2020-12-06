<?php

require_once('database.php');

class user
{
    private $database;

    public function __construct()
    {
        $this->database = new database();
    }

    public function contains(string $email, string $username)
    {
        $statement = $this->database->prepare("
            select * from users where EMAIL = ? or username = ?
        ");
        $statement->bind_param('ss', $email, $username);
        $statement->execute();
        $result = $statement->get_result()->fetch_assoc();
        if ($result) {
            return true;
        }
        return false;
    }

    public function profile(string $username)
    {
        $statement = $this->database->prepare("
            select * from users where username = ?
        ");
        $statement->bind_param('s', $username);
        $statement->execute();
        return $statement->get_result()->fetch_assoc();
    }

    public function insert(array $userArray)
    {
        $userArray['password'] = $this->hashPassword($userArray['password']);
        $statement = $this->database->prepare("
            insert into users (EMAIL, PW, STAFF_ID, username) VALUES (?,?,?,?)
        ");
        $statement->bind_param(
            'ssis',
            $userArray['email'],
            $userArray['password'],
            $userArray['staffID'],
            $userArray['username']
        );
        $statement->execute();
    }

    private function hashPassword(string $password): ?string
    {
        return password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
    }

    public function update($staffID, $userArray)
    {
        if ($userArray['password'] == '') {
            $statement = $this->database->prepare("
                update users
                set EMAIL=?
                where STAFF_ID = {$staffID}
            ");
            $statement->bind_param(
                's',
                $userArray['email'],
                );
        } else {
            $userArray['password'] = $this->hashPassword($userArray['password']);
            $statement = $this->database->prepare("
                update users
                set EMAIL=?, PW=?
                where STAFF_ID = {$staffID}
            ");
            $statement->bind_param(
                'ss',
                $userArray['email'],
                $userArray['password']
            );
        }
        $statement->execute();
    }

    public function numbers(): ?int
    {
        $statement = $this->database->prepare("
            select count(*) from users;
        ");
        $statement->execute();
        return $statement->get_result()->fetch_row()[0];
    }

    public function getStaffID(string $username): ?int
    {
        $statement = $this->database->prepare("
            select STAFF_ID from users where username =?
        ");
        $statement->bind_param('s', $username);
        $statement->execute();
        return $statement->get_result()->fetch_row()[0];
    }

    public function getUserID(string $username): ?int
    {
        $statement = $this->database->prepare("
            select USER_ID from users where username =?
        ");
        $statement->bind_param('s', $username);
        $statement->execute();
        return $statement->get_result()->fetch_row()[0];
    }

    public function checkPassword(string $username, string $password): ?bool
    {
        $statement = $this->database->prepare("
            select PW from users where username =?
        ");
        $statement->bind_param('s', $username);
        $statement->execute();
        $hashPassword = $statement->get_result()->fetch_row()[0];
        return password_verify($password, $hashPassword);
    }
}
