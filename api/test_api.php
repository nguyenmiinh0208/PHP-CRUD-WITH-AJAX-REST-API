<?php 

require_once "API.php";
$obj = new API();

if (isset($_POST["action"])) {
    if ($_POST["action"] == "insert") {
        $obj->insertData();
    } else if ($_POST["action"] == "update") {
        $obj->updateData();
    } else if ($_POST["action"] == "delete") {
        $obj->deleteData();
    } 
} else {
    $obj->fetch_all();
}

?>