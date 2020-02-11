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

$content = '';


if (!empty($_POST['news_id'])) {
    $news_id = $_POST['news_id'];
    $_SESSION['news_id'] = $news_id;
    $sql = "SELECT * FROM news WHERE news.id = ?";

    $stmt = $con->prepare($sql);
    $stmt->bind_param('i', $news_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {

        $stmt->bind_result($id, $author, $title, $content, $public, $creation_date);
        $stmt->fetch();
        $public = empty($public) ? "" : "checked";

        $content = '<div class="container">
                        
                        <form action="#" method="post">
                        <div class="form-group">
                           <label for="comment"></label>
                           <input type="text" class="form-control" name="title" placeholder="Cím" value="' . $title . '">                          
                           <textarea class="form-control" rows="5" name="comment" placeholder="Főoldalon megjelenő hír hozzáadása!">' . $content . '</textarea>
                         </div>
                           <input type="checkbox" name="public" value="1" ' . $public . '> Megjelenítés a főoldalon
                           <input type="datetime-local" name="creatian_date" value="' . str_replace(' ', 'T', $creation_date) . '">
                           <input class="btn btn-success" type="submit" value="Elküld">
                       </form>
                   </div>';
    } else {
        //sikertelen a belépés
        $_SESSION['loginError'] = "Adatbázis hiba!";
        //header('Location: news_controller.php');
    }
} else {   
    $public = empty($_POST['public']) ? 0 : 1;
    $creation_date = str_replace('T', ' ', $_POST['creatian_date']);
    //$content = htmlentities($_POST['comment']);
    $title = $_POST['title'];
    $content = $_POST['comment'];
    $id = $_SESSION['news_id'];
    
    //$sql = 'UPDATE news SET title="' . $_POST['title'] . '", content="' . $content . '", public=' . $public . ', creation_date="'.$creation_date.'" WHERE id=' . $_SESSION['news_id'];
    $sql = "UPDATE news SET title='$title', content='$content', public='$public', creation_date='$creation_date' WHERE id='$id'";

    if ($con->query($sql) === TRUE) {
        $_SESSION['ok'] = "Módosítás megtörtént!";
        echo "Record updated successfully";
    } else {
        $_SESSION['newsError'] = "Hír módosítása sikertelen: ". $con->error;
        echo "Error updating record: " . $con->error;
    }
    echo $_SESSION['news_id'];
    header('Location: news_controller.php');
}



printHTML('html/header.html');
printMenu();
echo '<div class="mycontainer">';
echo '<h1 class="mt-2 mb-3">Hír módosítása</h1>';
echo $content;
echo '</div>';
printHTML('html/footer.html');
$con->close();
