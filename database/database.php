<?php


class database extends mysqli
{
    const servername = 'localhost';
    const username = 'root';
    const password = 'password';
    const dbname = 'health_insider';
    const port = 3300;

    public function __construct()
    {
        parent::__construct(self::servername, self::username, self::password, self::dbname,self::port);
        if ($this->connect_error) {
            die('sql_connection_error');
        }
        echo "Connected successfully";
    }
}
