<?php

$conn = new mysqli("localhost", "root", "root", "ekaterina");

if ($conn->connect_error) {
    die("Ошибка: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["Id"])) {

    $userid = $conn->real_escape_string($_GET["Id"]);
    $sql = "SELECT * FROM teachers WHERE Id = '$userid'";

    if ($result = $conn->query($sql)) {

        if ($result->num_rows > 0) {

            foreach ($result as $row) {

                $FIO = $row["FIO"];
                $Description = $row["Description"];
            }
            $result->free();

            echo "<h3>Обновление пользователя</h3>
                <form method='post' enctype='multipart/form-data'>
                    <input type='hidden' name='Id' value='$userid' />
                    <p>Имя:
                    <input type='text' name='FIO' value='$FIO' /></p>
                    <p>описание:
                    <input type='text' name='Description' value='$Description' /></p>
                
                    <input type='submit' value='Сохранить'>
                </form>";

        } else {

            echo "<div>Пользователь не найден</div>";
        }

    } else {

        echo "Ошибка: " . $conn->error;
    }

} elseif (isset($_POST["Id"]) && isset($_POST["FIO"]) && isset($_POST["Description"])) {

    $userid = $conn->real_escape_string($_POST["Id"]);
    $FIO = $conn->real_escape_string($_POST["FIO"]);
    $Description = $conn->real_escape_string($_POST["Description"]);
   
    $sql = "UPDATE teachers SET FIO = '$FIO', Description = '$Description'";

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