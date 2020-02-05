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
                        <h2 class="mt-3">Hír módosítása:</h2>
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
    $sql = 'UPDATE news SET title="' . $_POST['title'] . '", content="' . $_POST['comment'] . '", public=' . $public . ', creation_date="'.$creation_date.'" WHERE id=' . $_SESSION['news_id'];

    if ($con->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $con->error;
    }
    header('Location: news_controller.php');
}



/*
  if (!empty($_POST['comment'])) {
  $userid = $_SESSION['userid'];
  $title = $_POST['title'];
  $comment = $_POST['comment'];
  $public = empty($_POST['public'])?0:1;
  $sql = "INSERT INTO news (author, title, content, public) VALUES ('$userid', '$title', '$comment', '$public')";

  if ($con->query($sql) === TRUE) {
  header('Location: news.php');
  } else {
  $_SESSION['loginError'] = "Az új hír hozzáadása sikertelen!";
  header('Location: news.php');
  }
  }
 */







printHTML('html/header.html');
printMenu();
echo '<div class="mycontainer">';
echo $content;
echo '</div>';
printHTML('html/footer.html');
$con->close();
