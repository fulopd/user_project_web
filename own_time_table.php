<?php
require_once('config/init.php');

if(!isLogged()){
    $_SESSION['loginError'] = "Információ megtekintéséhez be kell jelentkezni";   
    header('Location: login.php');
    die();
}

if (!isHaveRequiredPermission(2)){
    $_SESSION['loginError'] = "Információ megtekintéséhez nincs jogosultsága";     
    header('Location: logout.php');
    die();
}

$userid = $_SESSION['userid'];

if (!empty($_POST['year']) && (!empty($_POST['month']))){     
     $year = $_POST['year'];
     $month = $_POST['month'];
     $start_date = $year.'-'.$month.'-01';
     $stop_date = getLastDay($start_date);           
}else{
    
    if (!empty($_POST['start']) && (!empty($_POST['end']))){     
        $start_date = $_POST['start'];
        $stop_date = $_POST['end'];
    }else{
        $date_now = date('Y-m-d');              //Aktuális dátum
        $start_date = getFirsDay($date_now);    //hónap első napja
        $stop_date = getLastDay($date_now);     //hónap utolsó napja    
    }

}


//Legördülő menü adatok
$years = array();
$months = array();
$sql = 'SELECT start_date FROM time_table WHERE user_id = '.$userid;
$res = $con -> query($sql);

while ($row = $res -> fetch_assoc()){  
    $datum = strtotime($row['start_date']);    
    if (!array_key_exists(date("Y", $datum), $years)){
        $years[date("Y", $datum)] = true;
    }
    if (!array_key_exists(date("m", $datum), $months)){
        $months[date("m", $datum)] = true;
    }
}
ksort($years);
ksort($months);

$selector = '<p><form class="form-inline" action="#" method="post">
    <select class="form-control" name="year">
    <option value="0">Év</option>';
    foreach ($years as $key => $value) {
        $selector .=  '<option value="'.$key.'">'.$key.'</option>';
    };
$selector .= '</select>
    <select class="form-control" name="month">
    <option value="0">Hónap</option>';
    foreach ($months as $key => $value) {
        $selector .=  '<option value="'.$key.'">'.$key.'</option>';
    };
$selector .='</select> <input class="btn btn-success" type="submit" value="Elküld"></form>';
        
        
//Beosztás adatok
$sql = 'SELECT * FROM time_table WHERE user_id = '.$userid.' AND start_date > "'.$start_date.'" AND start_date < "'.increaseDateDay($stop_date, 1).'" ORDER BY start_date ASC';
$res = $con -> query($sql);
if (!$res){
    die('Hiba a lekérdezés végrehajtásában!');
}


$content = '<table class="table table-bordered table-hover">'
        . '<thead class="thead-light">'
        . '<tr>'
        . '<th>Dátum</th>'
        . '<th>Kezdés</th>'
        . '<th>Vége</th>'
        . '<th>Munkaidő</th>'
        . '</tr>'
        . '</thead>';

while ($row = $res -> fetch_assoc()){  
    $workshift_start = strtotime($row['start_date']);
    $workshift_end = strtotime($row['end_date']);        
    $working_time = $workshift_end - $workshift_start;  
    $paid_leave = $row['paid_leave'];
    $sick_leave = $row['sick_leave'];
    
    if ($paid_leave){
        $content .='<tr>'
                . '<td>'.date("Y.m.d", $workshift_start).'</td>'
                . '<td>-</td>'
                . '<td>-</td>'
                . '<td>Fizetett szabadság</td>'
            . '</tr>';
    }else{        
        if($sick_leave){
            $content .='<tr>'
                . '<td>'.date("Y.m.d", $workshift_start).'</td>'
                . '<td>-</td>'
                . '<td>-</td>'
                . '<td>Beteg szabadság</td>'
            . '</tr>';
        }else{
             $content .='<tr>'
                . '<td>'.date("Y.m.d", $workshift_start).'</td>'
                . '<td>'.date("H:i", $workshift_start).'</td>'
                . '<td title="'.date("Y.m.d", $workshift_end).'">'.date("H:i", $workshift_end).'</td>'
                . '<td>'.(($working_time/60)/60).'</td>'
            . '</tr>';
        }
    }
    
    
}
$content .='</table>';


printHTML('html/header.html');
printMenu();
echo '<div class="container">';
printHTML('html/own_time_table_form.html');
echo $selector;
echo '<p><p>'.$start_date .' - '. $stop_date;
echo $content;
echo '</div>';
printHTML('html/footer.html');
$con -> close();

