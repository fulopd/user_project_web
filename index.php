<?php

require_once('Config/init.php');

printHTML('html/header.html');


if (isLogged()) {
    printMenu($con);
    echo '<div class="container"><p>';
    printHTML('html/user_welcome.html');
} else {
    echo '<div class="container"><p>';
    printHTML('html/welcome.html');
}

if (!empty($_SESSION['loginError'])) {
    echo '<h3 class="text-center text-danger">' . $_SESSION['loginError'] . '</h3>';
    unset($_SESSION['loginError']);
}




echo '</div>';


printHTML('html/footer.html');
$con->close();
