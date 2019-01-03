<?php
class Database{
    public $host = "localhost";

    public $user = "root";

    public $password = "";

    public $database = "simple_shop";

    public $connection;


    public function __construct()
    {
        $this->connection = $this->connectDatabase();
    }

    public function connectDatabase(){
        $connection = mysqli_connect($this->host,$this->user,$this->password,$this->database);
        return $connection;
    }

    public function runQuery($sql){
        $result = mysqli_query($this->connection,$sql);
        $data = array();

        while ($row =mysqli_fetch_assoc($result)){
            $data[]=$row;
        }
        return $data;
    }

    public function numRows($sql){
        $result = mysqli_query($this->connection,$sql);
        $count = mysqli_num_rows();
        return $count;
    }
}