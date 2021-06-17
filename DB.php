<?php
class DB
{
    private $connection;
    private $table = [];

    public function __construct() {
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "web_bootcamp_comments";

        // Create connection
        $this->connection = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function &getTable() {
        $sql = "SELECT * FROM comments";
        $result = $this->connection->query($sql);

        if ($result->num_rows > 0) {
            $this->table = $result->fetch_all(MYSQLI_ASSOC);
        }

        return $this->table;
    }
}