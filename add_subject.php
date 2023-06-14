<?php
if (isset($_POST["Id"]) &&isset($_POST["TeacherId"]) && isset($_POST["Name"])  && isset($_POST['add'])) {
     $conn = new mysqli("localhost", "root", "root", "ekaterina");
    if($conn->connect_error){
        die("Ошибка: " . $conn->connect_error);
    }
    $Id = $conn->real_escape_string($_POST["Id"]);
    $TeacherId = $conn->real_escape_string($_POST["TeacherId"]);
    $Name = $conn->real_escape_string($_POST["Name"]);
   
    
    $sql = "INSERT INTO subject (Id,TeacherId, Name) VALUES ('$Id','$TeacherId', '$Name')";

    if($conn->query($sql)){
        
        header("Location: subject.php");
    } else{
        echo "Ошибка: " . $conn->error;
    }
    $conn->close();
}
?>