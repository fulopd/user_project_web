<?php

require_once('Config/init.php');
printHTML('html/header.html');


if (isLogged()) {
    //bejelentkezve
   header('Location: news.php');
} else {
    //kijelentkezve    
    header('Location: login.php');
}

printHTML('html/footer.html');
$con->close();
