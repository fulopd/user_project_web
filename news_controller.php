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

$userid = $_SESSION['userid'];

//Beosztás adatok
$sql = 'SELECT * FROM news WHERE author = ' . $userid . ' ORDER BY creation_date ASC';

$res = $con->query($sql);
if (!$res) {
    die('Hiba a lekérdezés végrehajtásában!');
}


$content = '<table class="table table-bordered table-hover">'
        . '<thead class="thead-light">'
        . '<tr>'
        . '<th>Megjelenítés</th>'
        . '<th>Létrehozás dátuma</th>'
        . '<th>Cím</th>'
        . '<th>Tartalom</th>'
        . '<th>Szerkesztés</th>'
        . '</tr>'
        . '</thead>';

while ($row = $res->fetch_assoc()) {
    $comment = substr($row['content'], 0, 100);
    $comment = str_replace('<', '&lt;', $comment);
    $comment = str_replace('>', '&gt;', $comment);
    $public = $row['public']?'checked':'';
    $content .= '<tr>'
            . '<td><input type="checkbox" name="" value="" '.$public.' disabled></td>'
            . '<td>' . $row['creation_date'] . '</td>'
            . '<td>' . $row['title'] . '</td>'
            . '<td>' . $comment . '</td>'
            . '<td>'
                . '<form action="news_update.php" method="post">'
                . '<input type="hidden" name="news_id" value="'.$row['id'].'">'
                . '<input class="btn btn-outline-secondary" type="submit" value="Szerkesztés">'
                . '</form>'                 
            . '</td>'
            . '</tr>';
}
$content .= '</table>';






printHTML('html/header.html');
printMenu();
echo '<div class="mycontainer">';
echo '<h1 class="mt-2 mb-3">Hírek kezelése</h1>';
echo $content;

echo '</div>';
printHTML('html/footer.html');
$con->close();
