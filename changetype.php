<?php
include "config.php";

$tableName = $_POST['tableName'];
$tableNumber = $_POST['tableNumber'];
$column = $_POST['column'];
$type = $_POST['type'];

if ($type === 'varchar'){
	$type = 'varchar(100)';
}

$sql = $pdo->prepare("ALTER TABLE $tableName MODIFY $column $type NOT NULL;");  
$sql->execute();
$tables = $sql->fetchAll(PDO::FETCH_NUM);

header('Location: index.php?showtable='.$tableNumber);




