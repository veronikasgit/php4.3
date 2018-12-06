<?php
include "config.php";

$sql1 = $pdo->prepare("SHOW TABLES;");  
$sql1->execute();
$tables = $sql1->fetchAll(PDO::FETCH_NUM);

foreach ($tables as $num => $table) {
 
    if ($_GET['deleteintable'] == $num + 1) {
        $nameOfTable = $table['0'];
        $sql2 = $pdo->prepare("DESCRIBE {$table['0']} ;");
        $sql2->execute();
        $table = $sql2->fetchAll(PDO::FETCH_ASSOC);
        foreach ($table as $key => $column) {
            if ($_GET['deletecolumn'] == $key + 1) {
               $columnToDel = $column['Field'];
            }
        }

        $sql3 = $pdo->prepare("ALTER TABLE $nameOfTable DROP COLUMN $columnToDel;"); 
        $sql3->execute(); 
        $columns2 = $sql3->fetchAll(PDO::FETCH_ASSOC); 
        header('Location: index.php?showtable='.$_GET['deleteintable']);
    } 
}


