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
<body>
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
<br><br><br><br>

  
  




<!-- Присваиваем переменным значения из полей ввода для поиска. -->
<?php
if(isset($_POST["find1"])){
  $Id=$_POST["Id"];
  $FIO=$_POST["FIO"];
  $Spec=$_POST["Spec"];
  $CourseName=$_POST["CourseName"];
  $GroupName=$_POST["GroupName"];
  $PhoneNumber=$_POST["PhoneNumber"];
  $Email=$_POST["Email"];
}


/* Все варианты сортировки */
$sort_list = array(


  'Id_asc'   => '`Id`',
  'Id_desc'  => '`Id` DESC',
  'FIO_asc'   => '`FIO`',
  'FIO_desc'  => '`FIO` DESC',
  'Spec_asc'  => '`Spec`',
  'Spec_desc' => '`Spec` DESC',  
  'CourseName_asc'  => '`CourseName`',
  'CourseName_desc' => '`CourseName` DESC', 
  'GroupName_asc'   => '`GroupName`',
  'GroupName_desc'  => '`GroupName` DESC',
  'PhoneNumber_asc'   => '`PhoneNumber`',
  'PhoneNumber_desc'  => '`PhoneNumber` DESC',
  'Email_asc'   => '`Email`',
  'Email_desc'  => '`Email` DESC',
    
);
 
/* Проверка GET-переменной */
$sort = @$_GET['sort'];
if (array_key_exists($sort, $sort_list)) {
  $sort_sql = $sort_list[$sort];
} else {
  $sort_sql = reset($sort_list);
}
 
/* Запрос в БД для вывода записей, так же этот запрос применяется для поиска */

$sql ="Select * FROM students WHERE 
students.Id LIKE '%".$Id."%'
AND students.FIO LIKE '%".$FIO."%'
AND students.Spec LIKE '%".$Spec."%'
AND students.CourseName LIKE '%".$CourseName."%'
AND students.GroupName LIKE '%".$GroupName."%'
AND students.PhoneNumber LIKE '%".$PhoneNumber."%'
AND students.Email LIKE '%".$Email."%' ORDER BY {$sort_sql}";




/* Функция вывода ссылок, как заголовков таблицы для сортировки */
function sort_link_th($title, $a, $b) {
  $sort = @$_GET['sort'];
 
  if ($sort == $a) {
    return '<a class="active" href="?sort=' . $b . '">' . $title . ' <i>▲</i></a>';
  } elseif ($sort == $b) {
    return '<a class="active" href="?sort=' . $a . '">' . $title . ' <i>▼</i></a>';  
  } else {
    return '<a href="?sort=' . $a . '">' . $title . '</a>';  
  }
}

?>


<br><br>
<br><br>


<center> <b style='font-size: 40px; color: #ecf0f1; text-shadow: 2px 2px 4px #000000;'>Students</b>
<br>
<!-- Сортировка -->
<table class='table_dark'>
<tr>
  <th ><?php echo sort_link_th('Id', 'Id_asc', 'Id_desc');?></th>
  <th ><?php echo sort_link_th('ФИО', 'FIO_asc', 'FIO_desc');?></th>
  <th><?php echo sort_link_th('Специальность', 'Spec_name_asc', 'Spec_name_desc');?></th>
  <th><?php echo sort_link_th('Курс', 'CourseName_asc', 'CourseName_desc');?></th>
  <th><?php echo sort_link_th('Группа', 'GroupName_asc', 'GroupName_desc');?></th>
  <th><?php echo sort_link_th('Телефон', 'PhoneNumber_asc', 'PhoneNumber_desc');?></th>
  <th><?php echo sort_link_th('Почта', 'Email_asc', 'Email_desc');?></th>
  <th>Фото</th> 
  <th></th>
</tr>

<?php
/* Вывод данных из БД */
if($result = $conn->query($sql)){
foreach($result as $row){

echo"<tr>";

$photo = $row['Photo'];
$photo_base64 = base64_encode($photo);
echo"
<td >".$row["Id"]."</td>
<td >".$row["FIO"]."</td>
<td >".$row["Spec"]."</td>
<td >".$row["CourseName"]."</td>
<td >".$row["GroupName"]."</td>
<td >".$row["PhoneNumber"]."</td>
<td >".$row["Email"]."</td>
<td><img src='data:image/png;base64,$photo_base64' style='width: 100px; height: 80px;' /></td>";


echo "<td>
    <!-- Форма удаления записи студента -->

    <form action='del_student.php' method='post'>
        <input type='hidden' name='Id' value='" . $row["Id"] . "' />
        <input type='submit' value='Удалить'>
    </form>
    <br>

    <!-- Ссылка для изменения записи студента -->

    <a href='upd_student.php?Id=" . $row["Id"] . "'>Изменить запись</a>
    <br>

    <!-- Форма обновления фотографии студента -->

    <form action='upd_studentPhoto.php' method='post' enctype='multipart/form-data'>
        <input type='hidden' name='Id' value='" . $row["Id"] . "' />
        <br>
        <input type='file' name='photo'>
        <br>
        <input type='submit' name='submit' value='Обновить фото'>
    </form>

    <br>

    <!-- Форма удаления фотографии студента -->

    <form action='del_studentPhoto.php' method='post'>
        <input type='hidden' name='Id' value='" . $row["Id"] . "' />
        <input type='submit' value='Удалить фото'>
    </form>
</td>";
echo "</tr>";

}
echo "</table>";

$result->free();
} else{
echo "Ошибка: " . $conn->error;
}
echo "<br><br>";

echo "
<!-- Форма поиска по таблице -->
<form class='form_add' action='' method='POST' >
  <table class='form_add'>
    <th>Поиск</th>
    <tr>
      <td>Id</td>
      <td><input type='text' name='Id'></td>
    </tr>
     <tr>
      <td>ФИО</td>
      <td><input type='text' name='FIO'></td>
    </tr>
     <tr>
      <td>Специальность</td>
      <td><input type='text' name='Spec'></td>
    </tr>
     <tr>
      <td>Курс</td>
      <td><input type='text' name='CourseName'></td>
    </tr>
     <tr>
      <td>Группа</td>
      <td><input type='text' name='GroupName'></td>
    </tr>
     <tr>
      <td>Телефон</td>
      <td><input type='text' name='PhoneNumber'></td>
    </tr>
    <tr>
      <td>Почта</td>
      <td><input type='text' name='Email'></td>
    </tr>
    <tr>
      <td colspan='2'><input type='submit' name='find1' value='Найти'></td>
    </tr>
  </table>
</form>


<!-- Форма добавления студента студента -->

<form class='form_add' action='add_student.php' method='POST' enctype='multipart/form-data'>
  <table class='form_add'>
    <th>Добавление</th>
     <tr>
      <td>Id</td>
      <td><input type='text' name='Id'></td>
    </tr>
    <tr>
      <td>ФИО</td>
      <td><input type='text' name='FIO'></td>
    </tr>
     <tr>
      <td>Специальность</td>
      <td><input type='text' name='Spec'></td>
    </tr>
     <tr>
      <td>Курс</td>
      <td><input type='text' name='CourseName'></td>
    </tr>
     <tr>
      <td>Группа</td>
      <td><input type='text' name='GroupName'></td>
    </tr>
     <tr>
      <td>Телефон</td>
      <td><input type='text' name='PhoneNumber'></td>
    </tr>
     <tr>
      <td>Почта</td>
      <td><input type='text' name='Email'></td>
    </tr>
    <tr>
      <td>Фото</td>
      <td><input type='file' name='Photo'></td>
    </tr>
    <tr>
      <td colspan='2'><input type='submit' name='add' value='OK'></td>
    </tr>
  </table>
</form>
"
?>
</body>
</html>
