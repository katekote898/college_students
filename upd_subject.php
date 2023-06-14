<?php

$conn = new mysqli("localhost", "root", "root", "ekaterina");

if ($conn->connect_error) {
    die("Ошибка: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["Id"])) {

    $userid = $conn->real_escape_string($_GET["Id"]);
    $sql = "SELECT * FROM subject WHERE Id = '$userid'";

    if ($result = $conn->query($sql)) {

        if ($result->num_rows > 0) {

            foreach ($result as $row) {

                $TeacherId = $row["TeacherId"];
                $Name = $row["Name"];
               
            }

            $result->free();

            echo "<h3>Обновление предмета</h3>
                <form method='post' enctype='multipart/form-data'>
                    <input type='hidden' name='Id' value='$userid' />
                    <p>Id преподвателя:
                    <input type='text' name='TeacherId' value='$TeacherId' /></p>
                    <p>Предмет:
                    <input type='text' name='Name' value='$Name' /></p>
                    
                
                    <input type='submit' value='Сохранить'>
                </form>";

        } else {

            echo "<div>Пользователь не найден</div>";
        }

    } else {

        echo "Ошибка: " . $conn->error;
    }

} elseif (isset($_POST["Id"]) && isset($_POST["TeacherId"]) && isset($_POST["Name"])) {

    $userid = $conn->real_escape_string($_POST["Id"]);
    $TeacherId = $conn->real_escape_string($_POST["TeacherId"]);
    $Name = $conn->real_escape_string($_POST["Name"]);
   
   
    $sql = "UPDATE subject SET TeacherId = '$TeacherId', Name = '$Name'";

    
    $sql .= " WHERE Id = '$userid'";

    if ($conn->query($sql) === true) {

        echo "<div>Данные пользователя успешно обновлены</div>";

    } else {

        echo "Ошибка: " . $conn->error;
    }

} else {

    echo "<div>Неверный запрос</div>";
}

$conn->close();

?>