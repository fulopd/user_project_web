<?php

require_once('config/init.php');

if (!isLogged()) {
    $_SESSION['loginError'] = "Információ megtekintéséhez be kell jelentkezni";
    header('Location: login.php');
    die();
}

if (!isHaveRequiredPermission(9)) {
    $_SESSION['loginError'] = "Információ megtekintéséhez nincs jogosultsága";
    header('Location: index.php');
    die();
}

//Legördülő menü adatok
$sql = 'SELECT position_name, id FROM position';
$res = $con->query($sql);

$selector = '<div class="container"><form action="#" method="post"><div class="input-group mb-3">
                <div class="input-group-prepend">                
                    <span class="input-group-text">Szűrés pozíció alapján:</span>
                </div>
                <select class="form-control" name="position">
                <option value="">Minden</option>';

while ($row = $res->fetch_assoc()) {
    $position_name = $row['position_name'];
    $selector .= '<option value="' . $row['id'] . '">' . $row['position_name'] . '</option>';
}
$selector .= '</select></div><input class="btn btn-success" type="submit" value="Elküld"></form></div>';

//Szűrő feltételek
if (!empty($_POST['position'])) {
    //Legördülő menü alapján pozició szerinti listázás
    $position_id = $_POST['position'];
   
    $sql = 'SELECT personal_data.first_name, personal_data.last_name, personal_data.picture, position.position_name, position.priority '
            . 'FROM personal_data, position, user_data '
            . 'WHERE user_data.personal_data_id = personal_data.id AND user_data.position_id = position.id AND position.id LIKE ' . $position_id . ' '
            . 'ORDER BY position.priority ASC';
} else {

    if (!empty($_POST['date']) && !empty($_POST['time'])) {
        //Adott időpillanatban dolgozók listája
        $date_time_value = $_POST['date'] . ' ' . $_POST['time'];
        
        $sql = 'SELECT personal_data.first_name, personal_data.last_name, personal_data.picture, position.position_name, position.priority '
                . 'FROM personal_data, position, user_data, time_table '
                . 'WHERE user_data.personal_data_id = personal_data.id '
                . 'AND user_data.position_id = position.id '
                . 'AND time_table.user_id = user_data.id '
                . 'AND "' . $date_time_value . '" BETWEEN time_table.start_date AND time_table.end_date '
                . 'ORDER BY position.priority ASC';
    } else {
        
        
        if(!empty($_POST['searchFirstName']) || !empty($_POST['searchLastName'])){
            $search_first_name = $_POST['searchFirstName'];
            $search_last_name = $_POST['searchLastName'];
            //Keressé név alapján
            $sql = 'SELECT personal_data.first_name, personal_data.last_name, personal_data.picture, position.position_name, position.priority '
                . 'FROM personal_data, position, user_data '
                . 'WHERE user_data.personal_data_id = personal_data.id AND user_data.position_id = position.id '
                . 'AND personal_data.last_name LIKE "%'.$search_last_name.'%" '
                . 'AND personal_data.first_name LIKE "%'.$search_first_name.'%" '
                . 'ORDER BY position.priority ASC';
            
        }else{
            //Minden dolgozó
            $sql = 'SELECT personal_data.first_name, personal_data.last_name, personal_data.picture, position.position_name, position.priority '
                . 'FROM personal_data, position, user_data '
                . 'WHERE user_data.personal_data_id = personal_data.id AND user_data.position_id = position.id '
                . 'ORDER BY position.priority ASC';
        }
        
    }
}





$res = $con->query($sql);
if (!$res) {
    die('Hiba a lekérdezés végrehajtásában!');
}

$content = '';
$new_pos = true;
$new_pos_name = '';

while ($row = $res->fetch_assoc()) {
    if ($new_pos) {
        //Első pozíció kiíratása
        $content .= '<h1>' . $row['position_name'] . '</h1>';
        $content .= '<div class="tablocontaier"><div class="d-flex flex-wrap">';
        $new_pos = false;
        $new_pos_name = $row['position_name'];
    } else {
        //Elsőtől eltérő pozíció kiíratása
        if ($new_pos_name != $row['position_name']) {
            $content .= '</div></div>';
            $content .= '<h1>' . $row['position_name'] . '</h1><br>';
            $content .= '<div class="tablocontaier"><div class="d-flex flex-wrap">';
            $new_pos_name = $row['position_name'];
        }
    }
    //Kép és adatok kiíratása
    $content .= '<div class="p-2 bd-highlight">';
    $content .= '<img src="./images/' . $row['picture'] . '" class="probaimage"><br>';
    $content .= $row['first_name'] . ' ';
    $content .= $row['last_name'] . '<br>';
    $content .= '</div>';
}





printHTML('html/header.html');
printMenu();
echo '<div class="mycontainer">';
printHTML('html/tablo.html');
echo $selector;
echo $content;
echo '</div>';
printHTML('html/footer.html');
$con->close();

