<?php

require_once('config/init.php');

if (!isLogged()) {
    $_SESSION['loginError'] = "Információ megtekintéséhez be kell jelentkezni";
    header('Location: login.php');
    die();
}

//TODO: jogosultságot létrehozni adatbázisban új értékkel!!
if (!isHaveRequiredPermission(9)) {
    $_SESSION['loginError'] = "Információ megtekintéséhez nincs jogosultsága";
    header('Location: logout.php');
    die();
}

$months_hu = array("", "Január", "Február", "Március", "Április", "Május", "Június", "Július", "Augusztus", "Szeptembe", "Október", "November", "December");


//Kezdő dátumok beállítása
//Megnyitáskor mai dátumhoz viszonyított hónap első és utolsó napja
//Ha kap POST -ban dátumot az adott hónap első és utolsó napja
if (!empty($_POST['year']) && (!empty($_POST['month']))) {
    $year = $_POST['year'];
    $month = $_POST['month'];
    $year_month = $year . '-' . $month;
} else {
    $year_month = date('Y-m');
}

$last_day = date('d', strtotime(getLastDay($year_month)));


echo $last_day;


//Legördülő menü adatok
$years = array();
$months = array();
$sql = 'SELECT start_date FROM time_table';
$res = $con->query($sql);

while ($row = $res->fetch_assoc()) {
    $datum = strtotime($row['start_date']);
    if (!in_array(date("Y", $datum), $years)) {
        $years[] = date("Y", $datum);
    }
    if (!in_array(date("m", $datum), $months)) {
        $months[] = date("m", $datum);
    }
}
sort($years);
sort($months);

$selector = '<p><form class="form-inline" action="#" method="post">
    <select class="form-control" name="year">
    <option value="0">Év</option>';
foreach ($years as $value) {
    $selector .= '<option value="' . $value . '">' . $value . '</option>';
};
$selector .= '</select>
    <select class="form-control" name="month">
    <option value="0">Hónap</option>';
foreach ($months as $value) {
    $selector .= '<option value="' . $value . '">' . $value . '</option>';
};
$selector .= '</select> <input class="btn btn-success" type="submit" value="Elküld"></form>';


//Beosztás adatok
$sql = 'SELECT '
        . 'user_data.id '
        . 'personal_data.first_name, '
        . 'personal_data.last_name, '
        . 'position.position_name, '
        . 'position.priority, '
        . 'DATE_FORMAT(time_table.start_date, "%e") as day_index, '
        . 'DATE_FORMAT(time_table.start_date, "%H")as start_hour, '
        . 'DATE_FORMAT(time_table.end_date, "%H")as end_hour, '
        . 'time_table.paid_leave, '
        . 'time_table.sick_leave '
        . 'FROM personal_data, user_data, time_table, position '
        . 'WHERE personal_data.id = user_data.personal_data_id '
        . 'AND position.id = user_data.position_id '
        . 'AND time_table.user_id = user_data.id '
        . 'AND DATE_FORMAT(time_table.start_date, "%Y-%m") = "' . $year_month . '" '
        . 'ORDER BY position.priority, personal_data.first_name, time_table.start_date ASC';

$res = $con->query($sql);
if (!$res) {
    die('Hiba a lekérdezés végrehajtásában!');
}

$table_head = '<th>Név</th>';

for ($i = 1; $i <= $last_day; $i++) {
    $table_head .= '<th>' . $i . '</th>';
}

$content = '<table class="table">'
        . '<thead">'
        . '<tr>';

$content .= $table_head . '</tr></thead>';

$adatok = array();
$new_user = true;
$user = '';

while ($row = $res->fetch_assoc()) {

    if ($new_user) {
        $new_user = false;
        $user = $row['id'];
        $adatok[$row['day_index']] = $row['start_hour'] . '-' . $row['end_hour'];
    } else {
        if ($user == $row['id']) {
            $adatok[$row['day_index']] = $row['start_hour'] . '-' . $row['end_hour'];
        } else {
            $user = $row['id'];
            $content .= '<tr>';
            for ($i = 1; $i <= $last_day; $i++) {
                if (!empty($adatok[i])) {
                    $content .= '<td>'.$adatok[i].'</td>';
                }else{
                    $content .= '<td>-</td>';
                }
            }
            $content .= '</tr>';
        }
    }
}
$content .= '</table>';

var_dump($adatok);

printHTML('html/header.html');
printMenu();
echo '<div class="container">';
echo $selector;
echo '<p><p>' . $start_date . ' - ' . $stop_date;
echo $content;
echo '</div>';
printHTML('html/footer.html');
$con->close();

