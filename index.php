<?php
include "config.php";

$sql1 = $pdo->prepare("SHOW TABLES;");	
$sql1->execute();
$tables = $sql1->fetchAll(PDO::FETCH_NUM);

$arrayTables = array();

foreach ($tables as $key => $value) {
	foreach ($value as $k => $v) {
		$arrayTables[] = $v;
	}
}

if (!in_array('students', $arrayTables)) {
	$sql = $pdo->prepare("CREATE TABLE `students` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(50) NULL,
	`estimation`float NOT NULL,
	`budget` tinyint(4) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

	$sql->execute();
} 

if (isset($_GET['showtable']) and !empty($_GET['showtable'])) {
	foreach ($tables as $num => $table) {
		if ($num + 1 == $_GET['showtable']) {
			$nameTable = $table['0'];
		}
	}

}

?>

<!DOCTYPE html>
<html>
<head>
	<title>База данных</title>
</head>
<body>

</body>
</html>

<ol>
	<?php foreach ($tables as $key => $value) : ?>
		
		<li>
			<a href = "index.php?showtable=<?php echo $key+1; ?>">
				<?php echo $value['0']; ?>
			</a>	

			<?php if (isset($nameTable) && !empty($nameTable) && ($value['0'] == $nameTable)) : ?>
				<?php foreach ($tables as $num => $table) :  ?>
					<?php if ($num + 1 == $_GET['showtable']) :  ?>
						<?php $nameTable = $table['0'];?>
						<?php $numberTable = $num + 1 ?>
						<?php $sql2 = $pdo->prepare("DESCRIBE $nameTable ;"); ?>	
						<?php $sql2->execute(); ?>
						<?php $table = $sql2->fetchAll(PDO::FETCH_ASSOC); ?>
						<ul>
							<?php foreach ($table as $keyOfTable => $v) : ?> 
								<li>									
									<?php echo $v['Field']; ?>

									<form action="changename.php" method="POST">
										<input name="tableName" type="hidden" value="<?php echo $nameTable; ?>">
										<input name="tableNumber" type="hidden" value="<?php echo $numberTable; ?>"> 
										<input name="column" type="hidden" value="<?php echo $v['Field']; ?>">
										<input name="type" type="hidden" value="<?php echo $v['Type'] ; ?> ">
										<input type="text" name="newName">
										<input type="submit" name="name" value="Изменить название">
									</form>

									<?php echo $v['Type'] ; ?> 

									<form action="changetype.php" method="POST">
										<input name="tableName" type="hidden" value="<?php echo $nameTable; ?>"> 
										<input name="tableNumber" type="hidden" value="<?php echo $numberTable; ?>">
										<input name="column" type="hidden" value="<?php echo $v['Field']; ?>">
										<label><input type="radio" name="type" value="int">INT</label>
										<label><input type="radio" name="type" value="tinyint">TINYINT</label>
										<label><input type="radio" name="type" value="float">FLOAT</label>
										<label><input type="radio" name="type" value="timestamp">TIMESTAMP</label>
										<label><input type="radio" name="type" value="varchar">VARCHAR</label>
										<input type="submit" name="submittype" value="Изменить тип">
									</form>

									<a href = "delete.php?deleteintable=<?php echo $num + 1; ?>&deletecolumn=<?php echo $keyOfTable + 1; ?>">Удалить поле</a>										
								</li>
								<hr>
							<?php endforeach ?>	 
						</ul>
						
					<?php endif ?>	
				<?php endforeach ?>	

			<?php endif ?>		
		</li>		
	<?php endforeach ?>
</ol>
