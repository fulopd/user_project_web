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
        . 'WHERE user_data.personal_data_id = personal_data.id AND user_data.position_id = position.id '
        . 'ORDER BY position.priority ASC';
$res = $con -> query($sql);
if (!$res){
    die('Hiba a lekérdezés végrehajtásában!');
}

$content = '';
$new_pos = true;
$new_pos_name = '';

while ($row = $res -> fetch_assoc()){  
    if($new_pos){
        $content.= '<h1>'.$row['position_name'].'</h1>';         
        $content.= '<div class="tablocontaier"><div class="d-flex flex-wrap">';              
        $new_pos = false;
        $new_pos_name = $row['position_name'];
    }else{
        if($new_pos_name != $row['position_name']){
            $content .= '</div></div>';
            $content .= '<h1>'.$row['position_name'].'</h1><br>';   
            $content .= '<div class="tablocontaier"><div class="d-flex flex-wrap">';
            $new_pos_name = $row['position_name'];            
        }
    }
    $content .= '<div class="p-2 bd-highlight">';
        $content .= '<img src="./images/'.$row['picture'].'" class="probaimage"><br>';
        $content.= $row['first_name'].' ';
        $content.= $row['last_name'].'<br>';        
    $content .= '</div>';
   
}


























printHTML('html/header.html');
printMenu();
echo '<div class="mycontainer">';
//printHTML('html/own_time_table_form.html');

echo $content;

echo '</div>';
printHTML('html/footer.html');
$con -> close();

