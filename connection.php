<?php
    $dsn = "mysql:host=localhost;dbname=lab5_itech";
    $user = 'root';
    $psw = "";
    try{
        $dbh = new PDO($dsn,$user,$psw);
        print('База данных успешно подключена');
    }
    catch(PDOException $ex){
        echo $ex->GetMessage();
        print('База данных не подключена');
    }

?>