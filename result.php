<html>
<head>
    <title>Results</title>
    <meta charset="utf-8">
</head>
<body>
<?php 
   
    include('connection.php');
    
    try{
        $dbh = new PDO($dsn, $user, $psw, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        $sql = $dbh->prepare("SELECT COUNT(a.ID_Worker) FROM worker a JOIN department b 
        ON a.FID_Department=b.ID_Department WHERE b.chief=:chief_name");
        $sql->execute(['chief_name'=>$_GET["chief"]]);
        $workers_number = $sql->fetch();

        $sql = $dbh->prepare("SELECT ROUND(TIME_TO_SEC(timediff(a.time_end, a.time_start))/3600) AS diff 
        FROM work a JOIN projects b ON a.FID_Projects=b.ID_Projects WHERE b.name=:project_1");
        $sql->execute(['project_1'=>$_GET["project_1"]]);
        $sqlresult = $sql->fetchAll();

        $total_time = 0;
        foreach ($sqlresult as $result)
            $total_time += $result[0];

        $sql = $dbh->prepare("SELECT a.* FROM work a JOIN projects b ON a.FID_Projects=b.ID_Projects 
        WHERE b.name=:project_1 AND a.date<=:work_date");
        $sql->execute(['project_1'=>$_GET["project_2"], 'work_date'=>$_GET["date"]]);
        $sqlresult = $sql->fetchAll();

        echo  "<br>  Информация о выполненных заданиях ".$_GET["project_2"]. " на дату ".$_GET["date"].":";
        echo "<p><table border='1'>
            <tr>
                <th>FID_Worker</th>
                <th>FID_Projects</th>
                <th>date</th>
                <th>time_start</th>
                <th>time_end</th>
                <th>Project status</th>
            </tr>";
        foreach ($sqlresult as $row){
            echo "<tr>";
            echo "<td>".$row[0]."</td>";
            echo "<td>".$row[1]."</td>";
            echo "<td>".$row[2]."</td>";
            echo "<td>".$row[3]."</td>";
            echo "<td>".$row[4]."</td>";
            echo "<td>".$row[5]."</td>";
            echo "</tr>";
        }
        echo "</table></p>";
    }
    catch(PDOException $ex){
        echo $ex->GetMessage();
    }
?>
    <p><div>Количество сотрудников отдела управления  <?=$_GET['chief']?>: <?=$workers_number['COUNT(a.ID_Worker)']?></div></p>
    <p><div> Total time spent working on the project <?=$_GET['project_1']?>: <?=$total_time?> часа</div></p>
</body> 