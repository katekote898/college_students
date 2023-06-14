<?php
if(isset($_POST["Id"]))
{   
    $conn = new mysqli("localhost", "root", "root", "ekaterina");

     if($conn->connect_error){
        die("Ошибка: " . $conn->connect_error);
    }
    $userid = $conn->real_escape_string($_POST["Id"]);
     $sql = "UPDATE students SET Photo= 'NULL' WHERE Id='$userid'";
    if($conn->query($sql)){
         
        header("Location: student.php");
    }
    else{
        echo "Ошибка: " . $conn->error;
    }
    $conn->close();  
}
?>