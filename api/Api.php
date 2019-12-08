<?php 

class API {

    protected $servername = "localhost",
                $username = "root",
                $password = "",
                $dbname = "examples";
    private $conn = NULL;

    function __construct() {
        $this->db_connect();
    }

    function db_connect() {
        $this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    function fetch_all() {
        $sql = "SELECT * FROM `cars`";
        $result = mysqli_query($this->conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            echo json_encode($data);
        } else {
            echo json_encode(
                array("msg" => "No data found.")
            );
        }
    }

    function insertData() {
        $sql = "INSERT INTO cars(id,name,year) VALUES('".$_POST["id"]."','".$_POST["name"]."', '".$_POST["year"]."')";
        $result = mysqli_query($this->conn, $sql);
        if ($result) {
            echo json_encode(
                array("msg" => "Insert Data Success")
            );
        } else {
            echo json_encode(
                array("msg" => "Insert Failed")
            );
        }

    }

    function updateData() {
        $sql = "UPDATE cars SET ".$_POST["column_name"]."='".$_POST["text"]."' WHERE id='".$_POST["id"]."'";
        $result = mysqli_query($this->conn, $sql);
        if($result) {  
            echo json_encode(
                array("msg" => "Updated data success")
            );
        } else {
            echo json_encode(
                array("msg" => "Updated Failed")
            );
        }
    }

    function deleteData() {
        $sql = "DELETE FROM cars WHERE id = '".$_POST["id"]."'";
        $result = mysqli_query($this->conn, $sql);
        if($result) {  
            echo json_encode(
                array("msg" => "Deleted data success")
            );
        } else {
            echo json_encode(
                array("msg" => "Deleted Failed")
            );
        }
    }
}

?>