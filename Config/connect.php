<?php

$con = new mysqli('db4free.net','userprojectadmin','mandarin','user_project_db','3306');
if ($con -> errno){
    die('Nem sikerült csatlakozi az adatbázishoz!');
}
if (!$con ->set_charset('utf8')){
    echo 'A karakterkódolás beállísa sikertelen!';
}


//https://db4free.net/
//Database = user_project_db
//user = userprojectadmin
//pass = mandarin