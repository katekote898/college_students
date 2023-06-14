<?php
if (isset($_POST["Id"]) &&isset($_POST["Mark"]) && isset($_POST["StudentId"])  && isset($_POST['SubjectId']) && isset($_POST['TeacherId']) && isset($_POST['Date']) && isset($_POST['add'])) {
     $conn = new mysqli("localhost", "root", "root", "ekaterina");
    if($conn->connect_error){
        die("Ошибка: " . $conn->connect_error);
    }
    $Id = $conn->real_escape_string($_POST["Id"]);
    $Mark = $conn->real_escape_string($_POST["Mark"]);
    $StudentId = $conn->real_escape_string($_POST["StudentId"]);
    $SubjectId = $conn->real_escape_string($_POST["SubjectId"]);
    $TeacherId = $conn->real_escape_string($_POST["TeacherId"]);
    $Date = $conn->real_escape_string($_POST["Date"]);
    
    
    $sql = "INSERT INTO marks (Id,Mark, StudentId, SubjectId, TeacherId, Date) VALUES ('$Id','$Mark', '$StudentId',  '$SubjectId',  '$TeacherId',  '$Date')";

    if($conn->query($sql)){
        
        header("Location: marks.php");
    } else{
        echo "Ошибка: " . $conn->error;
    }
    $conn->close();
}
?>
