<?php

ini_set('display_errors',1);
ini_set('error_reporting',2047);
error_reporting(E_ALL);

$status = '';
$error = false;

//phpinfo();

$way = $_FILES['domens']['tmp_name'];
$file = file_get_contents($way);

if (isset($_POST['submit']) && isset($_FILES['domens'])) {
  $way = $_FILES['domens']['tmp_name'];
  $file = file_get_contents($way);


      file_put_contents(__DIR__ . '/common/status', '1');
      file_put_contents(__DIR__ . '/common/urls', "");
      file_put_contents(__DIR__ . '/common/shorten.txt', "");

      $out = explode("\r\n", $file);

      /*require_once "pclzip.lib.php";
      define('PATH_XLSX', __DIR__.'/resXlsx');

    	// Разарзхивируем xlsx в xml формат
    	$archive = new PclZip(__DIR__.'/domens.xlsx');
    	$result = $archive->extract(PCLZIP_OPT_PATH, PATH_XLSX);
    	if ($result == 0) exit($archive->errorInfo(true));

    	// Вытаскиваем все значения ячеек в массив
    	$xml = simplexml_load_file(PATH_XLSX.'/xl/sharedStrings.xml');
        $sharedStringsArr = array();
        foreach ($xml->children() as $item) {
            $sharedStringsArr[] = trim((string)$item->t);
        }

        $handle = @opendir(PATH_XLSX.'/xl/worksheets');
        $out = [];
        while ($file = @readdir($handle)) {
            //проходим по всем файлам из директории /xl/worksheets/
            if ($file != "." && $file != ".." && $file != '_rels') {
                $xml = simplexml_load_file(PATH_XLSX.'/xl/worksheets/'.$file);
                //по каждой строке
                foreach ($xml->sheetData->row as $item) {
                	$row = [];
                    //по каждой ячейке строки
                    foreach ($item as $child) {
                        $attr = $child->attributes();
                        $value = isset($child->v) ? (string)$child->v : false;
                        $row[] = isset($attr['t']) ? $sharedStringsArr[$value] : $value;
                    }
                    $out[$file][] = $row;
                }
            }
        }*/

        $doms = [];

       	foreach ($out as $d) {
          //if (preg_match("/^.+\.ru\s*$/", $d))
            $doms[] = $d;
        }

        file_put_contents(__DIR__ . '/common/all', count($doms));
    		file_put_contents(__DIR__ . '/common/urls', implode("\r\n", $doms));

        exec("php ".__DIR__."/genOne.php > /dev/null &", $output, $return_var);

        $status = 'Процесс запущен.';

       if ($error === true) $status .= 'Ошибка. <a href="/">Попробовать другой файл</a>';
}


?>

<html>
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">

function recursive()
{
   setTimeout(function(){
        $.post('ajax.php', {op: 'status'}, function(answer){
            switch (answer)
            {
                case 'ready':
                    if ($(".status").text() != "Готово") {
                      alert("Все ссылки сконвертированы!");
                      $(".status").text('Готово');
                      var link = document.createElement('a');
                      link.setAttribute('href', document.location.href.replace("/gen.php", "")+'/common/shorten.txt');
                      link.setAttribute('download','shorten.txt');
                      onload=link.click();
                    }
                break;
                case 'none':
                    $(".status").text('Процессов нет');
                break;
                case 'error':
                  alert('Ошибка при получении короткого адреса');
                break;
                default:
                    $(".status").text(answer);
                    recursive();
            }

        });
    }, 1000);
}

$(function(){
    if ($("[name=error]").length == 0) recursive();
})
</script>
</head>
<body>
<p class="status"><?=$status?></p>
<?php if ($error) echo '<input type="hidden" name="error" value="1"/>'; ?>
</body>
</html>
