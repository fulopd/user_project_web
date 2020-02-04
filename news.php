<?php

require_once('config/init.php');

if (!isLogged()) {
    $_SESSION['loginError'] = "Információ megtekintéséhez be kell jelentkezni";
    header('Location: login.php');
    die();
}

$sql = 'SELECT personal_data.first_name, personal_data.last_name, news.content, news.creation_date '
        . 'FROM personal_data, user_data, news '
        . 'WHERE user_data.personal_data_id = personal_data.id '
        . 'AND news.author = user_data.id '
        . 'ORDER BY news.creation_date DESC';



$res = $con->query($sql);
if (!$res) {
    die('Hiba a lekérdezés végrehajtásában!');
}

$content = '';
while ($row = $res->fetch_assoc()) {
    
    $content .= '<div class="card-deck">'
            . '<div class="card m-2 p-2">'
            . '<h5 class="card-title">' . $row['creation_date'] . '</h5>'
            . '<p>' . $row['content'] . '</p>'            
            . '<h5 class="text-right">' . $row['first_name'] . ' ' . $row['last_name'] . '</h5>'
            . '</div>'
            . '</div>';
}



printHTML('html/header.html');
printMenu();

if (!empty($_SESSION['loginError'])) {
    echo '<h3 class="text-center text-danger">' . $_SESSION['loginError'] . '</h3>';
    unset($_SESSION['loginError']);
}


echo '<div class="mycontainer">';
echo '<h1 class="mt-2 mb-3">Hírek</h1>';
echo $content;
echo '</div>';
printHTML('html/footer.html');
$con->close();

