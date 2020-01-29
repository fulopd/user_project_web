<?php
require_once('config/init.php');

if(!isLogged()){
    $_SESSION['loginError'] = "Információ megtekintéséhez be kell jelentkezni";   
    header('Location: login.php');
    die();
}

if (!isHaveRequiredPermission($con, 2)){
    $_SESSION['loginError'] = "Információ megtekintéséhez nincs jogosultsága";     
    header('Location: index.php');
    die();
}


printHTML('html/header.html');
printMenu($con);
echo '<div class="container"><p>';

echo "beosztas";

echo '</div">';
printHTML('html/footer.html');

$con -> close();