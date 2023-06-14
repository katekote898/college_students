<?php
if (isset($_POST["Id"]) &&isset($_POST["FIO"]) && isset($_POST["Description"]) && isset($_POST['add'])) {
     $conn = new mysqli("localhost", "root", "root", "ekaterina");
    if($conn->connect_error){
        die("Ошибка: " . $conn->connect_error);
    }
    $Id = $conn->real_escape_string($_POST["Id"]);
    $FIO = $conn->real_escape_string($_POST["FIO"]);
    $Description = $conn->real_escape_string($_POST["Description"]);
    
    $sql = "INSERT INTO teachers (Id,FIO, Description) VALUES ('$Id','$FIO', '$Description')";

    if($conn->query($sql)){
        
        header("Location: teachers.php");
    } else{
        echo "Ошибка: " . $conn->error;
    }
    $conn->close();
}
?>
