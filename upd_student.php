<?php

$conn = new mysqli("localhost", "root", "root", "ekaterina");

if ($conn->connect_error) {
    die("Ошибка: " . $conn->connect_error);
}
/* Получаем Id записи которую нужно обновить и выводим поля этой записи в поля для редактирования */
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["Id"])) {

    $userid = $conn->real_escape_string($_GET["Id"]);
    $sql = "SELECT * FROM students WHERE Id = '$userid'";

    if ($result = $conn->query($sql)) {

        if ($result->num_rows > 0) {

            foreach ($result as $row) {

                
                $FIO = $row["FIO"];
                $Spec = $row["Spec"];
                $CourseName = $row["CourseName"];
                $GroupName = $row["GroupName"];
                $PhoneNumber = $row["PhoneNumber"];
                $Email = $row["Email"];
                
            }

            $result->free();

            echo "<h3>Обновление пользователя</h3>
                <form method='post' enctype='multipart/form-data'>
                    <input type='hidden' name='Id' value='$userid' />
                    <p>Имя:
                    <input type='text' name='FIO' value='$FIO' /></p>
                    <p>Специальность:
                    <input type='text' name='Spec' value='$Spec' /></p>
                    <p>Курс:
                    <input type='text' name='CourseName' value='$CourseName' /></p>
                    <p>Группа:
                    <input type='text' name='GroupName' value='$GroupName' /></p>
                    <p>Телефон:
                    <input type='tel' name='PhoneNumber' value='$PhoneNumber' /></p>
                    <p>Почта:
                    <input type='email' name='Email' value='$Email' /></p>
                    <input type='submit' value='Сохранить'>
                </form>";

        } else {

            echo "<div>Пользователь не найден</div>";
        }

    } else {

        echo "Ошибка: " . $conn->error;
    }

} if (isset($_POST["Id"]) && isset($_POST["FIO"]) && isset($_POST["Spec"]) && isset($_POST["CourseName"]) && isset($_POST["GroupName"]) && isset($_POST["PhoneNumber"]) && isset($_POST["Email"])) {

    $userid = $conn->real_escape_string($_POST["Id"]);
    $FIO = $conn->real_escape_string($_POST["FIO"]);
    $Spec = $conn->real_escape_string($_POST["Spec"]);
    $CourseName = $conn->real_escape_string($_POST["CourseName"]);
    $GroupName = $conn->real_escape_string($_POST["GroupName"]);
    $PhoneNumber = $conn->real_escape_string($_POST["PhoneNumber"]);
    $Email = $conn->real_escape_string($_POST["Email"]);
    


    $sql = "UPDATE students SET FIO = '$FIO', Spec = '$Spec', CourseName = '$CourseName', GroupName = '$GroupName', PhoneNumber = '$PhoneNumber', Email = '$Email' WHERE Id = '$userid'";

    if ($conn->query($sql) === true) {

        echo "<div>Данные пользователя успешно обновлены</div>";

    } else {

        echo "Ошибка: " . $conn->error;
    }

} 

$conn->close();

?>