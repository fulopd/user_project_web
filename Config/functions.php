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

function isHaveRequiredPermission($requiredPermission) {

    $permission_ids = $_SESSION['permissionids'];
    $permissions = explode(',', $permission_ids);

    if (in_array($requiredPermission, $permissions)) {        
        return true;
    }
    return false;
}

function printMenu() {

    $menu = file_get_contents('Html/menu.html');
    if (isLogged()) {
        $menuitems = '';
        //Beosztás menüpont megjelenítéséhez 2 -es jogosultság szükséges
        if (isHaveRequiredPermission(2)) {
            $menuitems .= '<li class="nav-item"> <a class="nav-link text-light" href="own_time_table.php">Beosztás</a></li>';
        }
        //Saját adatok menüpont megjelenítéséhez 1 -es jogosultság szükséges
        if (isHaveRequiredPermission(1)) {
            $menuitems .= '<li class="nav-item"> <a class="nav-link text-light" href="userinfo.php">Saját adatok</a></li>';
        }
        //Tabló menüpont megjelenítéséhez 9 -es jogosultság szükséges
        if (isHaveRequiredPermission(5)) {
            $menuitems .= '<li class="nav-item"> <a class="nav-link text-light" href="tablo.php">Tabló</a></li>';
        }
        //Hírek kezelése menüpont megjelenítéséhez 3 -es jogosultság szükséges
        if (isHaveRequiredPermission(3)) {
            $menuitems .= '<li class="nav-item"> <a class="nav-link text-light" href="news_controller.php">Hírek kezelése</a></li>';
        }
        //Teljes beosztás menüpont megjelenítéséhez 4 -es jogosultság szükséges
        if (isHaveRequiredPermission(4)) {
            $menuitems .= '<li class="nav-item"> <a class="nav-link text-light" href="time_table.php">Teljes beosztás</a></li>';
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


function currentlyAtWork($startDate, $endDate){
    $testedDate = date('Y-m-d H:i:s');        
    if($startDate < $testedDate && $endDate > $testedDate){
        return true;
    }else{
        return false;
    }
}
