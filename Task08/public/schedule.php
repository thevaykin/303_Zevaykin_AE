<?php
$db = new PDO('sqlite:../data/masters.db');
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Добавить график работы для мастера</title>
    </head>
    <link rel="stylesheet" href="styles.css" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="ajax.js"></script>
    <body>
    <div class = "back_to_main">
        <a href="index.php">Назад</a>
    </div>
    <div class="refs">

        <form  method = "GET" id = "form" onchange="changeMaster(this)">
            <h1 class = "newMtText" > Добавить время работы для мастера </h1>
            <fieldset class="fieldset_class">
                <h4>Мастер:
                    <select name = "master" id = "master" class="master" onchange="changeMaster(this)">
                        <option class = "option_st">Выбрать</option>
                        <?php
                            //$select_master = $_GET['master'];
                            $st = $db->prepare("SELECT s.id as id, s.last_name as fam, s.first_name as im, s.patronymic as otch from masters as s;");
                            $st->execute();
                            $res_st = $st->fetchAll(PDO::FETCH_ASSOC);
                            foreach($res_st as $temp){
                                $value1 = $temp['fam']." ".$temp['im']." ".$temp['otch'];
                                if(isset($_GET['master'])){
                                    if($value1==$_REQUEST['master']){
                                        $stud_id = $temp['id'];
                                        ?>
                                        <option id = "sel_val" selected><?=$value1;?></option>
                                        <?php
                                    }
                                    else{
                                        ?>
                                        <option id = "sel_val"><?=$value1;?></option>
                                        <?php
                                    }
                                }
                                else{
                                    ?>
                                    <option id = "sel_val"><?=$value1;?></option>
                                    <?php
                                }
                            }
                            if(isset($_REQUEST['master'])){

                        ?>
                        <script> alert("23") </script>
                                <?php } else { ?>
                                <script> alert("asf") </script>
                            <?php  }?>
                    </select>
                </h4>
                <hr>
                <h4>День недели:
                    <select name = "day" id ="day" class = "day">
                        <option class = "option_st">Пн</option>
                        <option class = "option_st">Вт</option>
                        <option class = "option_st">Ср</option>
                        <option class = "option_st">Чт</option>
                        <option class = "option_st">Пт</option>
                        <option class = "option_st">Сб</option>
                        <option class = "option_st">Вс</option>
                    </select>
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