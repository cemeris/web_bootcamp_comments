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

    public function __deconstruct() {
        $this->connection->close();
    }

    public function &getTable() {
        $sql = "SELECT * FROM comments";
        $result = $this->connection->query($sql);

        if ($result->num_rows > 0) {
            $this->table = $result->fetch_all(MYSQLI_ASSOC);
        }

        return $this->table;
    }

    public function addEntry($entry) {
        $name = $this->connection->real_escape_string(@$entry['name']);
        $message = $this->connection->real_escape_string(@$entry['message']);

        $sql = "INSERT INTO comments (name, message) VALUES ('$name', '$message')";

        if ($this->connection->query($sql) === TRUE) {
            echo "New record created successfully";

            $this->table[$this->connection->insert_id] = [
                'name' => $name,
                'message' => $message
            ];

        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
        }


    }
}