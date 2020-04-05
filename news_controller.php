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
        . '<tr class="text-center">'
        . '<th>Megjelenítés</th>'
        . '<th>Dátuma</th>'
        . '<th>Cím</th>'
        . '<th>Tartalom</th>'
        . '<th>Szerkesztés</th>'
        . '</tr>'
        . '</thead>';

while ($row = $res->fetch_assoc()) {
    $comment = substr($row['content'], 0, 100);
    //$comment = str_replace('<', '&lt;', $comment);
    //$comment = str_replace('>', '&gt;', $comment);
    $comment = strip_tags($comment);
    
    $public = $row['public']?'checked':'';
    $content .= '<tr>'
            . '<td class="text-center"><input type="checkbox" name="" value="" '.$public.' disabled></td>'
            . '<td>' . $row['creation_date'] . '</td>'
            . '<td>' . $row['title'] . '</td>'
            . '<td>' . $comment . '</td>'
            . '<td class="text-center">'
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

if (!empty($_SESSION['newsError'])) {
    echo '<h3 class="text-center text-danger">' . $_SESSION['newsError'] . '</h3>';
    unset($_SESSION['newsError']);
}
if (!empty($_SESSION['ok'])) {
    echo '<h3 class="text-center text-success">' . $_SESSION['ok'] . '</h3>';
    unset($_SESSION['ok']);
}

echo '<div class="mycontainer">';
echo '<h1 class="mt-2 mb-3">Hírek kezelése</h1><a href="news_create.php"><p class="btn btn-success">Új hír</p></a>';
echo $content;

echo '</div>';
printHTML('html/footer.html');
$con->close();
