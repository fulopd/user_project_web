<?php

require_once('config/init.php');

if (!isLogged()) {
    $_SESSION['loginError'] = "Információ megtekintéséhez be kell jelentkezni";
    header('Location: login.php');
    die();
}



printHTML('html/header.html');
printMenu();
echo '<div class="mycontainer">';
echo 'news';
//echo $content;
echo '</div>';
printHTML('html/footer.html');
$con->close();

