<?php
require_once('config/init.php');

if(!isLogged()){
    $_SESSION['loginError'] = "Információ megtekintéséhez be kell jelentkezni";   
    header('Location: login.php');
    die();
}

$userid = $_SESSION['userid'];
$sql = "SELECT * FROM personal_data WHERE id = $userid";
$res = $con -> query($sql);
if (!$res){
    die('Hiba a lekérdezés végrehajtásában!');

}

$content = '<div class="card-deck">';
while ($row = $res -> fetch_assoc()){        
    $content .= '<div class="card">'
            . '<img class="w-25 card-image-top " src="Images/'.$row['picture'].'">'
            . '<div class="card-body">'
            . '<h2 class="card-title">'.$row['first_name'].' '.$row['last_name'].'</h2>'
            . '<table class="table">'
            . '<tr><td>Anyja neve:</td><td>'.$row['mother'].'</td></tr>'
            . '<tr><td>Születési dátum:</td><td>'.$row['birth_date'].'</td></tr>'
            . '<tr><td>Település:</td><td>'.$row['location'].'</td></tr>'
            . '<tr><td>E-mail:</td><td>'.$row['email'].'</td></tr>'
            . '<tr><td>Telefonszám:</td><td>'.$row['phone'].'</td></tr>'
            . '</table>'            
            . '</div>'                           
            . '</div>';
}
$content .='</div>';
    

printHTML('html/header.html');
printMenu();
echo '<div class="container"><p>';
echo $content;
echo '</div">';
printHTML('html/footer.html');

$con -> close();

