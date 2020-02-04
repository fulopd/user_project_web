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
        . '<th>Létrehozás dátuma</th>'
        . '<th>Tartalom</th>'
        . '</tr>'
        . '</thead>';

while ($row = $res->fetch_assoc()) {
    $comment = substr($row['content'], 0, 100);
    $comment = str_replace('<', '&lt;', $comment);
    $comment = str_replace('>', '&gt;', $comment);
    
    $content .= '<tr>'
            . '<td>' . $row['creation_date'] . '</td>'
            . '<td>' . $comment . '</td>'
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
