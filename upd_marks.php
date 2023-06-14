<?php

$conn = new mysqli("localhost", "root", "root", "ekaterina");

if ($conn->connect_error) {
    die("Ошибка: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["Id"])) {

    $userid = $conn->real_escape_string($_GET["Id"]);
    $sql = "SELECT * FROM marks WHERE Id = '$userid'";

    if ($result = $conn->query($sql)) {

        if ($result->num_rows > 0) {

            foreach ($result as $row) {

                $Mark = $row["Mark"];
                $StudentId = $row["StudentId"];
                $SubjectId = $row["SubjectId"];
                $TeacherId = $row["TeacherId"];
                $Date = $row["Date"];
                
            }

            $result->free();

            echo "<h3>Обновление пользователя</h3>
                <form method='post' enctype='multipart/form-data'>
                    <input type='hidden' name='Id' value='$userid' />
                    <p>Оценка:
                    <input type='text' name='Mark' value='$Mark' /></p>
                    <p>Id студента:
                    <input type='text' name='StudentId' value='$StudentId' /></p>
                    <p>Id предметв:
                    <input type='text' name='SubjectId' value='$SubjectId' /></p>
                    <p>Id преподавателя:
                    <input type='text' name='TeacherId' value='$TeacherId' /></p>
                    <p>Дата:
                    <input type='date' name='Date' value='$Date' /></p>
                    
                    <input type='submit' value='Сохранить'>
                </form>";

        } else {

            echo "<div>Пользователь не найден</div>";
        }

    } else {

        echo "Ошибка: " . $conn->error;
    }

} elseif (isset($_POST["Id"]) && isset($_POST["Mark"]) && isset($_POST["StudentId"]) && isset($_POST["SubjectId"]) && isset($_POST["TeacherId"]) && isset($_POST["Date"])) {

    $userid = $conn->real_escape_string($_POST["Id"]);
    $Mark = $conn->real_escape_string($_POST["Mark"]);
    $StudentId = $conn->real_escape_string($_POST["StudentId"]);
    $SubjectId = $conn->real_escape_string($_POST["SubjectId"]);
    $TeacherId = $conn->real_escape_string($_POST["TeacherId"]);
    $Date = $conn->real_escape_string($_POST["Date"]);
   
   
    $sql = "UPDATE marks SET Mark = '$Mark', StudentId = '$StudentId', SubjectId = '$SubjectId', TeacherId = '$TeacherId', Date = '$Date'";

   

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