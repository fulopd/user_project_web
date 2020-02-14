<?php
require_once('config/init.php');

if(!isLogged()){
    $_SESSION['loginError'] = "Információ megtekintéséhez be kell jelentkezni";   
    header('Location: login.php');
    die();
}

if (!isHaveRequiredPermission(1)){
    $_SESSION['loginError'] = "Információ megtekintéséhez nincs jogosultsága";     
    header('Location: logout.php');
    die();
}

$userid = $_SESSION['userid'];
$sql = "SELECT * FROM personal_data WHERE id = $userid";
$res = $con -> query($sql);
if (!$res){
    die('Hiba a lekérdezés végrehajtásában!');

}

$content = '';
while ($row = $res -> fetch_assoc()){        
    $content .= '<div class="userinfo-box">'
                . '<img class="avatar" src="Images/'.$row['picture'].'">' 
                
                . '<h2>'.$row['first_name'].' '.$row['last_name'].'</h2>'

                . '<table class="table">'
                . '<tr><td>Anyja neve:</td><td>'.$row['mother'].'</td></tr>'
                . '<tr><td>Születési dátum:</td><td>'.$row['birth_date'].'</td></tr>'
                . '<tr><td>Település:</td><td>'.$row['location'].'</td></tr>'
                . '<tr><td>E-mail:</td><td>'.$row['email'].'</td></tr>'
                . '<tr><td>Telefonszám:</td><td>'.$row['phone'].'</td></tr>'
                . '<tr><td>Felhasználónév:</td><td>'.$_SESSION['username'].'</td></tr>'
                . '<tr><td>Munkakör:</td><td>'.$_SESSION['position_name'].'</td></tr>'
                . '<tr><td>Munkaviszony kezdete:</td><td>'.$_SESSION['first_working_day'].'</td></tr>'
                . '</table>'
            . '</div>';
}

    

printHTML('html/header.html');
printMenu();
echo '<div class="mycontainer">';
echo $content;
isHaveRequiredPermission(2);
echo '</div">';
printHTML('html/footer.html');

$con -> close();

