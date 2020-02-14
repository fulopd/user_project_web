<?php

require_once('config/init.php');

if (!isLogged()) {
    $_SESSION['loginError'] = "Információ megtekintéséhez be kell jelentkezni";
    header('Location: login.php');
    die();
}

//Adatok lekérése
$sql = 'SELECT personal_data.first_name, personal_data.last_name, news.title, news.content, news.creation_date '
        . 'FROM personal_data, user_data, news '
        . 'WHERE user_data.personal_data_id = personal_data.id '
        . 'AND news.author = user_data.id '
        . 'AND news.public = 1 '
        . 'ORDER BY news.creation_date DESC '
        . 'LIMIT 5';



$res = $con->query($sql);
if (!$res) {
    die('Hiba a lekérdezés végrehajtásában!');
}

$content = '';

while ($row = $res->fetch_assoc()) {
    //$comment = nl2br($row['content']);
    $comment = $row['content'];
    $content .= '<div class="card-deck">'
            . '<div class="card m-2 p-2">'
            . '<span class="newsTitle">' . $row['title'] .'</span>'
            . '<span class="newsDate">'. $row['creation_date'] . '</span>'
            . '<p>' . $comment . '</p>'            
            . '<h5 class="text-right">' . $row['first_name'] . ' ' . $row['last_name'] . '</h5>'
            . '</div>'
            . '</div>';
}



printHTML('html/header.html');
printMenu();

if (!empty($_SESSION['ok'])) {
    echo '<h3 class="text-center text-success">' . $_SESSION['ok'] . '</h3>';
    unset($_SESSION['ok']);
}


echo '<div class="container">';
echo '<h1>Hírek</h1>';

echo $content;
echo '</div>';
printHTML('html/footer.html');
$con->close();

