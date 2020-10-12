<?php


?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Check Shit sites</title>
	</head>
	<body>
		<form action = "./check.php" method = "POST" style = "position: relative; margin: 20px auto; border: 1px solid #ccc; background: #f2f2f2; padding: 15px; text-align: center; width: 400px;" enctype="multipart/form-data">
			<input type = "file" name = "urls">
			<button type = "submit" name = "submit">Проверить</button>
		</form>
	</body>
</html>
