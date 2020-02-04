<?php

require_once('config/init.php');

if (!isLogged()) {
    $_SESSION['loginError'] = "Információ megtekintéséhez be kell jelentkezni";
    header('Location: login.php');
    die();
}

if (!isHaveRequiredPermission(3)) {
    $_SESSION['loginError'] = "Információ megtekintéséhez nincs jogosultsága";
    header('Location: logout.php');
    die();
}




if (!empty($_POST['comment'])) {
    $userid = $_SESSION['userid'];
    $comment = $_POST['comment'];
    $sql = "INSERT INTO news (author, content) VALUES ('$userid', '$comment')";

    if ($con->query($sql) === TRUE) {
        header('Location: news.php');
    } else {
        $_SESSION['loginError'] = "Az új hír hozzáadása sikertelen!";
        header('Location: news.php');
    }
}








printHTML('html/header.html');
printMenu();
echo '<div class="mycontainer">';
printHTML('html/news_create.html');
echo '</div>';
printHTML('html/footer.html');
$con->close();
