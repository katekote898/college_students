<?php
/* Получаем значения переданные в форму */
if (isset($_POST["Id"]) &&isset($_POST["FIO"]) && isset($_POST["Spec"])  && isset($_POST['CourseName']) && isset($_POST['GroupName']) && isset($_POST['PhoneNumber'])&& isset($_POST['Email']) && isset($_POST['add'])) {
     $conn = new mysqli("localhost", "root", "root", "ekaterina");
    if($conn->connect_error){
        die("Ошибка: " . $conn->connect_error);
    }
/* Присваиваем переменным полученные зачения */
    $Id = $conn->real_escape_string($_POST["Id"]);
    $FIO = $conn->real_escape_string($_POST["FIO"]);
    $Spec = $conn->real_escape_string($_POST["Spec"]);
    $CourseName = $conn->real_escape_string($_POST["CourseName"]);
    $GroupName = $conn->real_escape_string($_POST["GroupName"]);
    $PhoneNumber = $conn->real_escape_string($_POST["PhoneNumber"]);
    $Email = $conn->real_escape_string($_POST["Email"]);
    $Photo = addslashes(file_get_contents($_FILES['Photo']['tmp_name']));
    
    $sql = "INSERT INTO students (Id,FIO, Spec, CourseName, GroupName, PhoneNumber,Email,Photo) VALUES ('$Id','$FIO', '$Spec',  '$CourseName',  '$GroupName',  '$PhoneNumber', '$Email', '$Photo')";

    if($conn->query($sql)){
        
        header("Location: student.php");
    } else{
        echo "Ошибка: " . $conn->error;
    }
    $conn->close();
}
?>
