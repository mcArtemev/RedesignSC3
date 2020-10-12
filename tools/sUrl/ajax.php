<?php

if (isset($_POST['op']))
{
    $status = (integer) file_get_contents(__DIR__ . '/common/status');
    switch ($status)
    {
        case 0:
            echo 'none';
        break;
        case 1:
            $urls = file_get_contents(__DIR__ . '/common/urls');
            $all = (integer) file_get_contents(__DIR__ . '/common/all');
            echo 'Конвертировано '.($all - count(explode("\n", $urls)) + 1).' из '.$all.' урлов.';
        break;
        case 2:
            echo 'ready';
        break;
        case 2:
            echo 'error';
        break;
    }
}

?>
