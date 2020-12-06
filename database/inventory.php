<?php

require_once "database.php";

class inventory
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

    public function numbers()
    {
        $statement = $this->database->prepare("
            select count(*) from inventory
        ");
        $statement->execute();
        return $statement->get_result()->fetch_row()[0];
    }

    public function getItem(int $id): ?array
    {
        $statement = $this->database->prepare("
            select * from inventory
            where NO = {$id}
        ");
        $statement->execute();
        return $statement->get_result()->fetch_assoc();
    }

    public function getAllItem(int $offset = 0)
    {
        $statement = $this->database->prepare("
            select * from inventory
            limit {$offset}, {$this->limit}
        ");
        $statement->execute();
        return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function addStock(int $id, int $num)
    {
        $statement = $this->database->prepare("
            update inventory set STOCK = STOCK + {$num}
            where NO = {$id}
        ");
        $statement->execute();
    }

    public function minusStock(int $id, int $num)
    {
        $statement = $this->database->prepare("
            update inventory set STOCK = STOCK - {$num}
            where NO = {$id}
        ");
        $statement->execute();
    }

    public function editStock(int $id, array $detail)
    {
        $statement = $this->database->prepare("
            UPDATE `healthinsider`.`inventory` t 
            SET t.`DRUG` = '{$detail['drug']}', t.`DESC` = '{$detail['desc']}', t.`COST` = {$detail['cost']} 
            WHERE t.`NO` = {$id}
        ");
        $statement->execute();
    }

    public function createStock(array $detail)
    {
        $statement = $this->database->prepare("
            insert into inventory
            (DRUG, `DESC`, COST, STOCK) 
            VALUES (?,?,?,?)
        ");
        $statement->bind_param(
            'ssii',
            $detail['drug'],
            $detail['desc'],
            $detail['cost'],
            $detail['stock']
        );
        $statement->execute();
    }

    public function deleteStock(int $id)
    {
        $statement = $this->database->prepare("
            delete from inventory where NO = {$id}
        ");
        $statement->execute();
    }
}
