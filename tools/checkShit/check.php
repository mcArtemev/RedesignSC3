<?php

require __DIR__.'/tools.php';

ini_set('display_errors', '1');
ini_set('error_reporting','2047');
error_reporting(E_ALL);

$status = '';
$error = false;


if (isset($_POST['submit']) && isset($_FILES['urls'])) {
  $way = $_FILES['urls']['tmp_name'];
  $file = file_get_contents($way);

  $urls = explode("\r\n", $file);

  //$urls = array_slice($urls, 0, 50);

  //var_dump(tools::checkCode($urls));

  //exit;

  file_put_contents(__DIR__ . '/common/status', '1');
  file_put_contents(__DIR__ . '/common/url', implode($urls, "\r\n"));
  file_put_contents(__DIR__ . '/common/all', count($urls));
  file_put_contents(__DIR__ . '/common/shitDomains.txt', "");
  file_put_contents(__DIR__ . '/common/goodDomains.txt', "");

  exec("php ".__DIR__."/checkOne.php > /dev/null &", $output, $return_var);

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
                    $(".status").html('<a href="/">Проверить еще</a>');
                    alert("Все домены проверены!");
                    $(".status").text('Готово');
                    var link = document.createElement('a');
                    link.setAttribute('href', document.location.href.replace("/check.php", "")+'/common/shitDomains.txt');
                    link.setAttribute('download','shitDomains.txt');
                    onload=link.click();
                    var link = document.createElement('a');
                    link.setAttribute('href', document.location.href.replace("/check.php", "")+'/common/goodDomains.txt');
                    link.setAttribute('download','goodDomains.txt');
                    onload=link.click();
                break;
                case 'none':
                    $(".status").text('Процессов нет');
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
