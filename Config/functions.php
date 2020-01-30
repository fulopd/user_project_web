<?php

function printHTML($html) {
    echo file_get_contents($html);
}

function isLogged() {
    if (!empty($_SESSION['userid'])) {
        return true;
    } else {
        return false;
    }
}

function isHaveRequiredPermission($con, $requiredPermission) {

    $userid = $_SESSION['userid'];

    $sql = "SELECT position.permission_ids FROM position, user_data WHERE user_data.id = $userid AND user_data.position_id = position.id";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($permission_ids);
    $stmt->fetch();

    $permissions = explode(',', $permission_ids);

    if (in_array($requiredPermission, $permissions)) {        
        return true;
    }
    return false;
}

function printMenu($con) {

    $menu = file_get_contents('Html/menu.html');
    if (isLogged()) {
        $menuitems = '';
        //Beosztás menüpont megjelenítéséhez 2 -es jogosultság szükséges
        if (isHaveRequiredPermission($con, 2)) {
            $menuitems .= '<li class="nav-item"> <a class="nav-link text-light" href="beosztas.php">Beosztás </a></li>';
        }
        //Saját adatok menüpont megjelenítéséhez 1 -es jogosultság szükséges
        if (isHaveRequiredPermission($con, 1)) {
            $menuitems .= '<li class="nav-item"> <a class="nav-link text-light" href="userinfo.php">Saját adatok</a></li>';
        }
        $menuitems .= '</ul></div>'
                . '<div class="navbar-collapse">'
                . '<ul class="navbar-nav ml-auto">'
                . '<span class="nav-link text-warning">' . $_SESSION['username'] . '</span>'
                . '<li class="nav-item"> <a class="nav-link text-light" href="logout.php"> Kilép</a> </li>'
                . '</ul>'
                . '</div>';

        $menu = str_replace('::ki_belepes', $menuitems, $menu);
    } else {
        $menu = str_replace('::ki_belepes', '<li class="nav-item">  <a class="nav-link text-light" href="login.php">Belép</a> </li>', $menu);
    }

    echo $menu;
}

function getFirsDay($date) {
    $modDate = (new DateTime($date))
            ->modify('first day of this month')
            ->format('Y-m-d');

    return $modDate;
}

function getLastDay($date) {
    $modDate = (new DateTime($date))
            ->modify('last day of this month')
            ->format('Y-m-d');

    return $modDate;
}

function increaseDateDay($date, $day) {
    return date('Y-m-d', strtotime($date . ' +' . $day . ' day'));
}
