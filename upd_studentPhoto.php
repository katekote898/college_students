<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "ekaterina";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// проверяем соединение с базой данных
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// проверяем, была ли отправлена форма
if (isset($_POST['submit'])) {
    // получаем идентификатор записи и новое фото
    $Id = $_POST['Id'];
    $new_photo = addslashes(file_get_contents($_FILES['photo']['tmp_name']));

    // обновляем фото в базе данных
    $sql = "UPDATE students SET Photo='$new_photo' WHERE Id=$Id";
    if (mysqli_query($conn, $sql)) {
        echo "Фото успешно обновлено";
    } else {
        echo "Ошибка при обновлении фото: " . mysqli_error($conn);
    }
}

// закрываем соединение с базой данных
mysqli_close($conn);
?>