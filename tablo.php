<?php
require_once('config/init.php');

if(!isLogged()){
    $_SESSION['loginError'] = "Információ megtekintéséhez be kell jelentkezni";   
    header('Location: login.php');
    die();
}

if (!isHaveRequiredPermission(9)){
    $_SESSION['loginError'] = "Információ megtekintéséhez nincs jogosultsága";     
    header('Location: index.php');
    die();
}



$sql = 'SELECT personal_data.first_name, personal_data.last_name, personal_data.picture, position.position_name, position.priority '
        . 'FROM personal_data, position, user_data '
        . 'WHERE user_data.personal_data_id = personal_data.id AND user_data.position_id = position.id';
$res = $con -> query($sql);
if (!$res){
    die('Hiba a lekérdezés végrehajtásában!');
}

while ($row = $res -> fetch_assoc()){  
    echo $row['first_name'];
    echo $row['last_name'];
    echo $row['picture'];
    echo $row['position_name'];
    echo $row['priority'];
           
    
}


























printHTML('html/header.html');
printMenu();
echo '<div class="container">';
//printHTML('html/own_time_table_form.html');

echo 'tablo';

echo '</div>';
printHTML('html/footer.html');
$con -> close();

