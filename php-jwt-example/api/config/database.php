<?php
// used to get mysql database connection
class DatabaseService{

    private $db_host = "www.weightbeginner.ga";
    private $db_name = "db";
    private $db_user = "hyojin";
    private $db_password = "rlagywlsmyDB1030!";
    private $connection;

    public function getConnection(){

        $this->connection = null;

        try{
            $this->connection = new PDO("mysql:host=" . $this->db_host . ";dbname=" . $this->db_name, $this->db_user, $this->db_password);
        }catch(PDOException $exception){
            echo "Connection failed: " . $exception->getMessage();
        }

        return $this->connection;
    }
}
?>