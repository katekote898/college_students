<?php
if(isset($_POST["Id"]))
{   
    $conn = new mysqli("localhost", "root", "root", "ekaterina");

     if($conn->connect_error){
        die("Ошибка: " . $conn->connect_error);
    }
    $userid = $conn->real_escape_string($_POST["Id"]);
    $sql = "DELETE FROM marks WHERE Id = '$userid'";
    if($conn->query($sql)){
         
        header("Location: marks.php");
    }
    else{
        echo "Ошибка: " . $conn->error;
    }
    $conn->close();  
}
?>
