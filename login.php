<?php
   
require_once('config/init.php');

 
if (!empty($_POST['username']) && (!empty($_POST['password']))){
    if (isset($_SESSION['loginError'])){
        unset($_SESSION['loginError']);
    }       
    if(!empty($_SESSION['userid'])){
        $_SESSION['loginError'] = "Már be vagy jelentkezve!";   
        session_destroy();        
        header('Location: login.php');
    }else{
        $username = $_POST['username'];
        $pwd = $_POST['password'];
        $sql = "SELECT id, user_name, first_working_day FROM user_data WHERE user_name = ? AND password = ?";
        $stmt = $con -> prepare($sql);
        $stmt -> bind_param('ss',$username, $pwd );
        $stmt -> execute();
        $stmt -> store_result();

        if ($stmt -> num_rows == 1){
            //belépett
            $stmt -> bind_result($id, $username, $first_working_day);
            $stmt -> fetch();        
            $_SESSION['userid'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['first_working_day'] = $first_working_day;

            //Belépett felhasználó jogosultságainak kiolvasása
            $sql = "SELECT position.permission_ids, position.position_name FROM position, user_data WHERE user_data.id = $id AND user_data.position_id = position.id";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($permission_ids, $position_name);
            $stmt->fetch();

            $_SESSION['permissionids'] = $permission_ids;
            $_SESSION['position_name'] = $position_name;


            header('Location: news.php');
        
        }
        else {
               //sikertelen a belépés
               $_SESSION['loginError'] = "Helytelen belépési adatok!";
           }    
    }
}


printHTML('html/header.html');
if(!empty($_SESSION['loginError'])){
    echo '<h3 class="text-center text-danger">'.$_SESSION['loginError'].'</h3>';
    unset($_SESSION['loginError']);
}

printHTML('html/login_form.html');


printHTML('html/footer.html');
$con -> close();