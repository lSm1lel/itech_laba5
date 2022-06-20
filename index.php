<!DOCKTYPE HTML>
<html>
<head>
    <title>Laba 5</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Автор: ст.гр. КИУКИ-19-3 Александ Суровыкин </h1>
    <?php
    include('connection.php');

        try{
            $dbh = new PDO($dsn, $user, $psw, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

            $expr = $dbh->prepare("SELECT chief FROM department");
            $expr->execute();
            $chief_options = $expr->fetchAll();

            $expr = $dbh->prepare("SELECT projects.name FROM projects");
            $expr->execute();
            $project_options = $expr->fetchAll();            
        }
        catch(PDOException $ex){
            echo $ex->GetMessage();
        }
    ?>
    <form action="result.php" method="get">
        <p>Количество подчиненных каждого начальника:</p>
        <select name="chief">
            <?php foreach ($chief_options as $name): ?>
                <option value="<?=$name["chief"]?>"><?=$name["chief"]?></option>
            <?php endforeach ?>
        </select>

        <p>Общее время, потраченное на выбранный проект:</p>
        <select name="project_1">
            <?php foreach ($project_options as $project): ?>
                <option value="<?=$project["name"]?>"><?=$project["name"]?></option>
            <?php endforeach ?>
        </select>

        <p>Информация о выполненных задачах по указанным проектам на выбранную дату:</p>
        <select name="project_2">
            <?php foreach ($project_options as $project): ?>
                <option value="<?=$project["name"]?>"><?=$project["name"]?></option>
            <?php endforeach ?>
        </select>
        <p><input type="date" name="date"></p>

        <button type="submit">Поиск</button><br>
    </form>
</body> 