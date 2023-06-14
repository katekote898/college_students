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
  
  $FIO=$_POST["FIO"];
  $Name=$_POST["Name"];
  $MarksCount=$_POST["MarksCount"];
  $AverageMark=$_POST["AverageMark"];
  
}


/* Все варианты сортировки */
$sort_list = array(
  'Id_asc'             => '`Id`',
  'Id_desc'            => '`Id` DESC',
  'FIO_asc'            => '`FIO`',
  'FIO_desc'           => '`FIO` DESC',  
  'Name_asc'   => '`Name`',
  'Name_desc'  => '`Name` DESC', 
  'MarksCount_asc'     => '`MarksCount`',
  'MarksCount_desc'    => '`MarksCount` DESC',
  'AverageMark_asc'    => '`AverageMark`',
  'AverageMark_desc'   => '`AverageMark` DESC'
);
 
/* Проверка GET-переменной */
$sort = @$_GET['sort'];
if (array_key_exists($sort, $sort_list)) {
  $sort_sql = $sort_list[$sort];
} else {
  $sort_sql = reset($sort_list);
}
 
/* Запрос в БД для вывода записей, так же этот запрос применяется для поиска */

$sql ="Select progress.*, students.FIO AS st_name, subject.Name AS su_name
FROM progress,students,subject WHERE

progress.MarksCount LIKE '%".$MarksCount."%'
AND progress.AverageMark LIKE '%".$AverageMark."%'
AND  students.FIO LIKE '%".$FIO."%'
AND subject.Name LIKE '%".$Name."%'
AND progress.StudentId = students.Id
AND progress.SubjectId = subject.Id
 ORDER BY {$sort_sql}";





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


<center> <b style='font-size: 40px; color: #ecf0f1; text-shadow: 2px 2px 4px #000000;'>Успеваемость</b>
<br>

<table class='table_dark'>
<tr>
  <th ><?php echo sort_link_th('Id', 'Id_asc', 'Id_desc');?></th>
  <th><?php echo sort_link_th('Студент', 'FIO_asc', 'FIO_desc');?></th>
  <th><?php echo sort_link_th('Предмет', 'Name_asc', 'Name_desc');?></th>
  <th><?php echo sort_link_th('Колличество', 'MarksCount_asc', 'MarksCount_desc');?></th>
  <th><?php echo sort_link_th('Средний балл', 'AverageMark_asc', 'AverageMark_desc');?></th>
  <th></th>
</tr>

<?php

if($result = $conn->query($sql)){
foreach($result as $row){

echo"<tr>";


echo"
<td >".$row["Id"]."</td>
<td >".$row["st_name"]."</td>
<td >".$row["su_name"]."</td>
<td >".$row["MarksCount"]."</td>
<td >".$row["AverageMark"]."</td>";



echo "<td>
                  <!-- Форма удаления записи --><form action='del_progress.php' method='post'>
                        <input type='hidden' name='Id' value='" . $row["Id"] . "' />
                        <input type='submit' value='Удалить'>
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
      <td>ФИО студента</td>
      <td><input type='text' name='Student_FIO'></td>
    </tr>
     <tr>
      <td>Название предмета</td>
      <td><input type='text' name='Subject_Name'></td>
    </tr>
     <tr>
      <td>Колличество оценок</td>
      <td><input type='text' name='MarksCount'></td>
    </tr>
     <tr>
      <td>Средний балл</td>
      <td><input type='еуче' name='AverageMark'></td>
    </tr>
    <tr>
      <td colspan='2'><input type='submit' name='find1' value='Найти'></td>
    </tr>
  </table>
</form>




"
?>
</body>
</html>
