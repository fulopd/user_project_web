<?php

//$con = new mysqli('node01.facesharedeu1.com','yztvriym_root','1ZT6A!CqQyCj','yztvriym_user_project_db','3306');
$con = new mysqli('localhost','root','','user_project_db','3306');
if ($con -> errno){
    die('Nem sikerült csatlakozi az adatbázishoz!');
}
if (!$con ->set_charset('utf8')){
    echo 'A karakterkódolás beállísa sikertelen!';
}

