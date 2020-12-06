<?php

require_once('database.php');

class visitor
{
    private $database;

    public function __construct()
    {
        $this->database = new database();
    }

    public function increment()
    {
        $statement = $this->database->prepare("
            update visitor set count = count + 1
        ");
        $statement->execute();
    }

    public function numbers(): ?int
    {
        $statement = $this->database->prepare("
            select count from visitor
        ");
        $statement->execute();
        return $statement->get_result()->fetch_row()[0];
    }
}
