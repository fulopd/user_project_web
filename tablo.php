<?php

require_once('config/init.php');

if (!isLogged()) {
    $_SESSION['loginError'] = "Információ megtekintéséhez be kell jelentkezni";
    header('Location: login.php');
    die();
}

if (!isHaveRequiredPermission(5)) {
    $_SESSION['loginError'] = "Információ megtekintéséhez nincs jogosultsága";
    header('Location: logout.php');
    die();
}

//Legördülő menü adatok
$sql = 'SELECT position_name, id FROM position';
$res = $con->query($sql);

$selector = '<div class="input-group mb-3">
                <div class="input-group-prepend">                
                    <label class="input-group-text">Szűrés pozíció alapján:</label>
                </div>
                <select class="form-control" name="position">
                <option value="">Minden</option>';

while ($row = $res->fetch_assoc()) {
    $position_name = $row['position_name'];
    $selector .= '<option value="' . $row['id'] . '">' . $row['position_name'] . '</option>';
}
$selector .= '</select></div><input class="btn btn-success" type="submit" value="Elküld"></form></div>';


//szűrők beállítása
$query_position = '';
$query_date_time = '';
$query_name = '';
$query_FROM = 'FROM personal_data, position, user_data ';

if (!empty($_POST['position'])) {
    $position_id = $_POST['position'];
    $query_position = 'AND position.id = "' . $position_id . '" ';
}

if (!empty($_POST['date']) && !empty($_POST['time'])) {
    $date_time_value = $_POST['date'] . ' ' . $_POST['time'];
    $query_FROM = 'FROM personal_data, position, user_data, time_table ';
    $query_date_time = 'AND time_table.user_id = user_data.id AND "' . $date_time_value . '" BETWEEN time_table.start_date AND time_table.end_date ';
}

if(!empty($_POST['searchFirstName']) || !empty($_POST['searchLastName'])){
    $search_first_name = $_POST['searchFirstName'];
    $search_last_name = $_POST['searchLastName'];
    $query_name = 'AND personal_data.last_name LIKE "%' . $search_last_name . '%" AND personal_data.first_name LIKE "%' . $search_first_name . '%" ';
}



//szűrőfeltételek alapján tablóképek és poziciók kirajzolása
$sql = 'SELECT user_data.id, user_data.user_name, personal_data.first_name, personal_data.last_name, personal_data.picture, position.position_name, position.priority '
        . $query_FROM
        . 'WHERE user_data.personal_data_id = personal_data.id AND user_data.position_id = position.id AND position.position_name NOT LIKE "@%" AND (user_data.last_working_day IS NULL OR user_data.last_working_day >= CURDATE())'
        . $query_position
        . $query_date_time
        . $query_name
        . 'ORDER BY position.priority ASC';

//jelen pillanatban munkában van e?...
$sql2 = 'SELECT time_table.start_date, time_table.end_date, TIMEDIFF(time_table.start_date, now()) as "elteres" FROM time_table '
            . 'WHERE time_table.user_id = ? '
            . 'AND ((time_table.start_date <= now() AND time_table.end_date >= now()) '
            . 'OR time_table.start_date >= now()) '
            . 'AND (time_table.paid_leave = 0 AND time_table.sick_leave = 0) '
            . 'ORDER BY elteres ASC '
            . 'LIMIT 1';

$res = $con->query($sql);

if (!$res) {
    die('Hiba a lekérdezés végrehajtásában!');
}

$content = '';
$new_pos = true;
$new_pos_name = '';

while ($row = $res->fetch_assoc()) {

    $stmt = $con->prepare($sql2);
    $stmt->bind_param('i', $row['id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($start, $stop, $temp);
    $stmt->fetch();
    
    if ($new_pos) {
        //Első pozíció kiíratása
        $content .= '<div class="tablopositiontext"><h2>' . $row['position_name'] . '</h2></div>';
        $content .= '<div class="tabloRowContaier bgColor"><div class="d-flex flex-wrap">';
        $new_pos = false;
        $new_pos_name = $row['position_name'];
    } else {
        //Elsőtől eltérő pozíció kiíratása
        if ($new_pos_name != $row['position_name']) {
            $content .= '</div></div>';
            $content .= '<div class="tablopositiontext"><h2>' . $row['position_name'] . '</h2></div>';
            $content .= '<div class="tabloRowContaier bgColor"><div class="d-flex flex-wrap">';
            $new_pos_name = $row['position_name'];
        }
    }
    //Kép és adatok kiíratása
    //New line char: &#xa;
    if(currentlyAtWork($start, $stop)){
        $info_text = 'Igen';               
        $tabloImageBoxWork = ' tabloImageBoxWork';
    }else{
        $info_text = 'Nem&#xa;Következő munkanap:&#xa;'.$start;        
        $tabloImageBoxWork = '';
    }    
    $content .= '<div class="tabloImageBox'.$tabloImageBoxWork.'" style="background-image: url(images/' . $row['picture'] . ')" '
            . 'data-text="'.$row['first_name'].'&nbsp;'.$row['last_name'].'&#xa;'
            . 'Jelenleg munkában van: '
            . $info_text.''
            . '&#xa;Felhasználónév: '.$row['user_name'].''
            . '">';    
    $content .= '</div>';
}





printHTML('html/header.html');
printMenu();
echo '<div class="container">';

printHTML('html/tablo.html');
echo $selector;
echo $content;
echo '</div>';
printHTML('html/footer.html');
$con->close();

