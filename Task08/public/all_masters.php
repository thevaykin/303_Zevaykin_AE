<?php
$db = new PDO('sqlite:../data/masters.db');
/*
$all_groups_q = "SELECT group_name from all_groups;";
$all_groups_arr = $db->prepare($all_groups_q);
$all_groups_arr->execute();
$all_groups = $all_groups_arr->fetchAll(PDO::FETCH_ASSOC);
*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Добавить мастера</title>
</head>
<link rel="stylesheet" href="styles.css" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<body>
<div class = "back_to_main">
    <a href="index.php">Назад</a>
</div>
<div class="refs">

    <form  method = "GET" >
        <h1 class = "newMtText" >Новый мастер</h1>
        <fieldset class="fieldset_class">
            <legend> Информация о мастере </legend>
            <h4>Фамилия:
                <input required class = "text_input" type="text" name="surname" value=""><br>
            </h4>
            <hr>
            <h4>Имя:
                <input required class = "text_input" type="text" name="name" value=""><br>
            </h4>
            <hr>
            <h4>Отчество:
                <input required class = "text_input" type="text" name="lastname" value=""><br>
            </h4>
            <hr>
            <h4>Пол:
                <li><input required class="radio_b" type="radio" name="sex" value="m"> Мужской</li>
                <li><input required class="radio_b" type="radio" name="sex" value="f"> Женский</li>
            </h4>
            <hr>
            <h4>Дата рождения:
                <input required class = "date_birth" type="date" name="birthday" value=""><br>
            </h4>
            <hr>
            <h4>Коэффициент зарплаты:
                <input required class = "text_input" type="text" name="salary" value=""><br>
            </h4>
            <h4>Дата наёма:
                <input required class = "date_birth" type="date" name="hiring_date" value=""><br>
            </h4>
            <h4>Дата увольнения:
                <input class = "date_birth" type="date" name="dismissal_date" value=""><br>
            </h4>
        </fieldset>

        <input class = "sendInfoNewMaster" type = "submit" value="Добавить"/>
    </form>
</div>
<?php
var_dump($_REQUEST);
if(isset($_REQUEST["surname"]) && isset($_REQUEST["name"]) && isset($_REQUEST["lastname"]) && isset($_REQUEST["sex"]) && isset($_REQUEST["birthday"]) && isset($_REQUEST["salary"]) && isset($_REQUEST["hiring_date"]) && isset($_REQUEST["dismissal_date"])){
    $sex_="";
    if($_REQUEST["sex"]=="m"){
        $sex_ = 'муж';
    }
    else{
        $sex_ = 'жен';
    }
    if($_REQUEST['dismissal_date']!=""){
        $new_master_q = 'INSERT INTO masters (first_name, patronymic, last_name, gender, birthdate, salary_coefficient, hiring_date, dismissal_date) VALUES'
            .'(:first_name, :patronymic, :last_name, :gender, :birthdate, :salary_coefficient, :hiring_date, :dismissal_date);';
        $ins=$db->prepare($new_master_q);
        $ins->execute([
            ':first_name' => $_GET["name"],
            ':patronymic' => $_GET["lastname"],
            ':last_name' => $_GET["surname"],
            ':gender' => $sex_,
            ':birthdate' => $_GET["birthday"],
            ':salary_coefficient' => $_GET["salary"],
            ':hiring_date' => $_GET["hiring_date"],
            ':dismissal_date' => $_GET["dismissal_date"],
        ]);
    }
    else{
        $new_master_q = 'INSERT INTO masters (first_name, patronymic, last_name, gender, birthdate, salary_coefficient, hiring_date) VALUES'
            .'(:first_name, :patronymic, :last_name, :gender, :birthdate, :salary_coefficient, :hiring_date);';
        $ins=$db->prepare($new_master_q);
        $ins->execute([
            ':first_name' => $_GET["name"],
            ':patronymic' => $_GET["lastname"],
            ':last_name' => $_GET["surname"],
            ':gender' => $sex_,
            ':birthdate' => $_GET["birthday"],
            ':salary_coefficient' => $_GET["salary"],
            ':hiring_date' => $_GET["hiring_date"],
            ]);
    }
}
?>

</body>
</html>
