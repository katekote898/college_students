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
  $Mark=$_POST["Mark"];
  $Student_FIO=$_POST["Student_FIO"];
  $Subject_Name=$_POST["Subject_Name"];
  $Teacher_FIO=$_POST["Teacher_FIO"];
  $Date=$_POST["Date"];
  
}


/* Все варианты сортировки */
$sort_list = array(
  'Id_asc'             => '`Id`',
  'Id_desc'            => '`Id` DESC',
  'Mark_asc'           => '`Mark`',
  'Mark_desc'          => '`Mark` DESC',
  'Student_FIO_asc'    => '`students`.`FIO`',
  'Student_FIO_desc'   => '`students`.`FIO` DESC',  
  'Subject_Name_asc'   => '`subject`.`Name`',
  'Subject_Name_desc'  => '`subject`.`Name` DESC', 
  'Teacher_FIO_asc'    => '`teachers`.`FIO`',
  'Teacher_FIO_desc'   => '`teachers`.`FIO` DESC',
  'Date_asc'           => '`Date`',
  'Date_desc'          => '`Date` DESC'
);
 
/* Проверка GET-переменной */
$sort = @$_GET['sort'];
if (array_key_exists($sort, $sort_list)) {
  $sort_sql = $sort_list[$sort];
} else {
  $sort_sql = reset($sort_list);
}
 
/* Запрос в БД для вывода записей, так же этот запрос применяется для поиска */

$sql = "SELECT marks.*, students.FIO AS st_name, subject.Name AS su_name, teachers.FIO AS tc_name
        FROM marks
        JOIN students ON marks.StudentId = students.Id
        JOIN subject ON marks.SubjectId = subject.Id
        JOIN teachers ON marks.TeacherId = teachers.Id
        WHERE marks.Id LIKE '%{$Id}%'
          AND students.FIO LIKE '%{$Student_FIO}%'
          AND subject.Name LIKE '%{$Subject_Name}%'
          AND teachers.FIO LIKE '%{$Teacher_FIO}%'
          AND marks.Mark LIKE '%{$Mark}%'
          AND marks.Date LIKE '%{$Date}%'
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
<center> <b style='font-size: 40px; color: #ecf0f1; text-shadow: 2px 2px 4px #000000;'>Оценки</b>
<br>
<table class='table_dark'>
<tr>
  <th ><?php echo sort_link_th('Id', 'Id_asc', 'Id_desc');?></th>
  <th ><?php echo sort_link_th('Оценка', 'Mark_asc', 'Mark_desc');?></th>
  <th><?php echo sort_link_th('Студент', 'Student_FIO_asc', 'Student_FIO_desc');?></th>
  <th><?php echo sort_link_th('Предмет', 'Subject_Name_asc', 'Subject_Name_desc');?></th>
  <th><?php echo sort_link_th('Преподаватель', 'Teacher_FIO_asc', 'Teacher_FIO_desc');?></th>
  <th><?php echo sort_link_th('Дата', 'Date_asc', 'Date_desc');?></th>
  <th></th>
</tr>


<?php
/* Вывод данных из БД */
if($result = $conn->query($sql)){
foreach($result as $row){

echo"<tr>";


echo"
<td >".$row["Id"]."</td>
<td >".$row["Mark"]."</td>
<td >".$row["st_name"]."</td>
<td >".$row["su_name"]."</td>
<td >".$row["tc_name"]."</td>
<td >".$row["Date"]."</td>";



echo "<td>
                  <!-- Форма удаления записи -->
                  <form action='del_marks.php' method='post'>
                        <input type='hidden' name='Id' value='" . $row["Id"] . "' />
                        <input type='submit' value='Удалить'>
                   </form>
                   <!-- Ссылка для изменения записи -->
                   <a href='upd_marks.php?Id=" . $row["Id"] . "'>Изменить</a>
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
      <td>Оценка</td>
      <td><input type='text' name='Mark'></td>
    </tr>
     <tr>
      <td>ФИО студента</td>
      <td><input type='text' name='Student_FIO'></td>
    </tr>
     <tr>
      <td>Название предмета</td>
      <td><input type='text' name='Subject_Name'></td>
    </tr>
     <tr>
      <td>ФИО преподавателя</td>
      <td><input type='text' name='Teacher_FIO'></td>
    </tr>
     <tr>
      <td>Дата</td>
      <td><input type='date' name='Date'></td>
    </tr>
    <tr>
      <td colspan='2'><input type='submit' name='find1' value='Найти'></td>
    </tr>
  </table>
</form>


<!-- Форма добавления записи -->

<form class='form_add' action='add_marks.php' method='POST' enctype='multipart/form-data'>
  <table class='form_add'>
    <th>Добавление</th>
    <tr>
      <td>Id</td>
      <td><input type='text' name='Id'></td>
    </tr>
     <tr>
      <td>Оценка</td>
      <td><input type='text' name='Mark'></td>
    </tr>
     <tr>
      <td>Id студента</td>
      <td><input type='text' name='StudentId'></td>
    </tr>
     <tr>
      <td>Id предмета</td>
      <td><input type='text' name='SubjectId'></td>
    </tr>
     <tr>
      <td>Id преподавателя</td>
      <td><input type='text' name='TeacherId'></td>
    </tr>
     <tr>
      <td>Дата</td>
      <td><input type='date' name='Date'></td>
    </tr>
    <tr>
      <td colspan='2'><input type='submit' name='add' value='Добавить'></td>
    </tr>
  </table>
</form>
"
?>
</body>
</html>
