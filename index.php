<!DOCTYPE html>
<html lang="ru">

<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "ekaterina";



// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="style.css">

</head>
<body >
  <center>
<ul class="navigation"> 
   <!-- Описание ссылок в меню и сами ссылки. -->
   <li><a href="index.php" >Главная</a></li>
   <li><a href="student.php" >Студенты</a></li>
   <li><a href="teachers.php" >Преподаватели</a></li>
   <li><a href="subject.php" >Предметы</a></li>
   <li><a href="marks.php" >Оценки</a></li>
   <li><a href="progress.php" >Успеваемость</a></li>
</ul>
<br>

  
  








<?php
$db = mysqli_connect("localhost","root","root","ekaterina"); 
 $sql = "SELECT Photo FROM students WHERE id=1";
 
$sth = $db->query($sql);
$result=mysqli_fetch_array($sth);



// вывод и удаление
echo "<br><br>";
echo "<br><br>";
echo "<br><br>";
echo "<br><br>";

$sql ="Select * from students";

if($result = $conn->query($sql)){

echo "<center> <b style='font-size: 40px; color: #ecf0f1; text-shadow: 2px 2px 4px #000000;'>students</b>";

echo "<table> 
<tr>
<th>Id</th>
<th>ФИО</th>
<th>Специальность</th>
<th>Курс</th>
<th>Группа</th>
<th>Телефон</th>
<th>Почта</th> 
<th>Фото</th> ";


foreach($result as $row){

echo"<tr>";

$show_img =base64_encode( $row['Photo'] );
echo"
<td>".$row["Id"]."</td>
<td>".$row["FIO"]."</td>
<td>".$row["Spec"]."</td>
<td>".$row["CourseName"]."</td>
<td>".$row["GroupName"]."</td>
<td>".$row["PhoneNumber"]."</td>
<td>".$row["Email"]."</td>
<td><img src = 'data:image/jpeg;base64, $show_img'></td>";

}

echo "</table>";

$result->free();

} else{

echo "Ошибка: " . $conn->error;

}

echo "<br><br>";


?>
</body>
</html>