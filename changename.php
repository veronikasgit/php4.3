<?php
include "config.php";

$tableName = $_POST['tableName'];
$tableNumber = $_POST['tableNumber'];
$column = $_POST['column'];
$newName = $_POST['newName'];
$type = $_POST['type'];

$sql = $pdo->prepare("ALTER TABLE $tableName CHANGE $column $newName $type");  
$sql->execute();
$tables = $sql->fetchAll(PDO::FETCH_NUM);

header('Location: index.php?showtable='.$tableNumber);
