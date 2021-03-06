<?php

require_once('config/init.php');

if (!isLogged()) {
    $_SESSION['loginError'] = "Információ megtekintéséhez be kell jelentkezni";
    header('Location: login.php');
    die();
}


if (!isHaveRequiredPermission(4)) {
    $_SESSION['loginError'] = "Információ megtekintéséhez nincs jogosultsága";
    header('Location: logout.php');
    die();
}

$months_hu = array("", "Január", "Február", "Március", "Április", "Május", "Június", "Július", "Augusztus", "Szeptembe", "Október", "November", "December");
$user_name = '';

//Kezdő dátumok beállítása
//Megnyitáskor mai dátumhoz viszonyított hónap első és utolsó napja
//Ha kap POST -ban dátumot az adott hónap első és utolsó napja
if (!empty($_POST['year']) && (!empty($_POST['month']))) {
    $year = $_POST['year'];
    $month = $_POST['month'];
    $year_month = $year . '-' . $month;
} else {
    $year_month = date('Y-m');
    $month = date('m');
}

$last_day = date('d', strtotime(getLastDay($year_month)));

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
$selector .= '</select> <input class="btn btn-success" type="submit" value="Elküld"></form></p>';


//Beosztás adatok
$sql = 'SELECT '
        . 'user_data.id, '
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

$colgroup = '<colgroup><col/>';
$table_head = '<thead class="thead-light"><tr><th>Név</th>';


for ($i = 1; $i <= $last_day; $i++) {    
    //Szombat - Vasárnap más színnel
    $col_date = date("N", strtotime($year_month . '-' . $i));    
    if ($col_date == "6" || $col_date == "7") {
        $colgroup .= '<col class="table-info"/>';
    } else {
        $colgroup .= '<col/>';
    }
    //Fejléc számozás
    $table_head .= '<th class="text-center">' . $i . '</th>';
}
$colgroup .= '</colgroup>';
$table_head .= '</tr></thead>';

$content = '<table id="myTable" class="table table-sm table-bordered table-hover">'
        . $colgroup
        . $table_head;



$adatok = array();
$new_user = true;
$user = '';

while ($row = $res->fetch_assoc()) {

    if ($new_user) {
        //Első futás
        //user id kimentése
        $new_user = false;
        $user = $row['id'];
        $user_name = $row['first_name'] . ' ' . $row['last_name'];
        $position = $row['position_name'];
        $content .= '<tr class="table-warning"><td colspan="' . ((int) $last_day + 1) . '">' . $position . '</td></tr>';
    } else {
        if ($user != $row['id']) {
            //user váltás volt
            //eddigi user adatok kiíratása
            $content .= '<tr>';
            $content .= '<td nowrap>' . $user_name . '</td>';
            
            for ($i = 1; $i <= $last_day; $i++) {
                if (!empty($adatok[$i])) {
                    $td_color = '';
                    if ($adatok[$i] == "FSZ") {
                        $td_color = 'table-danger';
                    } else {
                        if ($adatok[$i] == "B") {
                            $td_color = 'table-success';
                        }
                    }
                    $content .= '<td nowrap class="text-center ' . $td_color . '">' . $adatok[$i] . '</td>';
                } else {
                    $content .= '<td nowrap class="text-center">-</td>';
                }
            }
            $content .= '</tr>';

            if ($position != $row['position_name']) {
                $position = $row['position_name'];
                $content .= '<tr class="table-warning"><td colspan="' . ((int) $last_day + 1) . '">' . $position . '</td></tr>';
            }

            //uj user adatok mentése
            $user = $row['id'];
            $position = $row['position_name'];
            $user_name = $row['first_name'] . ' ' . $row['last_name'];
            $adatok = array();
        }
    }
    //Cella információ kinyerése
    if ($row['paid_leave'] || $row['sick_leave']) {
        if ($row['paid_leave']) {
            $adatok[$row['day_index']] = 'FSZ';
        } else {
            $adatok[$row['day_index']] = 'B';
        }
    } else {
        $adatok[$row['day_index']] = $row['start_hour'] . '-' . $row['end_hour'];
    }
}

//utoljára kiolvasott adatok kiíratása
$content .= '<tr>';
$content .= '<td nowrap>' . $user_name . '</td>';
for ($i = 1; $i <= $last_day; $i++) {
    if (!empty($adatok[$i])) {
        $content .= '<td nowrap class="text-center">' . $adatok[$i] . '</td>';
    } else {
        $content .= '<td nowrap class="text-center">-</td>';
    }
}
$content .= '</tr></table>';


printHTML('html/header.html');
printMenu();
echo '<div class="mycontainer">';
echo '<h1>' . $months_hu[(int) $month] . '</h1>';
echo $selector;
echo $content;
echo '<p> B - Beteg szabadság / FSZ - Fizetett szabadság</p>';
echo '</div>';
printHTML('html/footer.html');
$con->close();

