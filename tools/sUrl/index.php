<?php


?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Google Short Url Generator</title>
	</head>
	<body>
		<form action = "./gen.php" method = "POST" style = "position: relative; margin: 20px auto; border: 1px solid #ccc; background: #f2f2f2; padding: 15px; text-align: center; width: 400px;" enctype="multipart/form-data">
			<input type = "file" name = "domens">
			<button type = "submit" name = "submit">Сгенерировать</button>
		</form>
	</body>
</html>
