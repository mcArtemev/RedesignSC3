<?

namespace framework\ajax\action\hooks;

use framework\pdo;

define('BATCH_MODE', 1);

class start_cache
{
    public function doAction()
    {
        $sql = "SELECT `value` FROM `customs` WHERE `code` = 'process'";
        $process = (integer) pdo::getPdo()->query($sql)->fetchColumn();
        
        if ($process == 0)
        {
            if (!BATCH_MODE)
                $sql = "SELECT `pid` FROM `batchs` GROUP BY `pid`";
            else
                $sql = "SELECT `pid` FROM `batch_site_id` GROUP BY `pid`";
                
            $pids = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN);
            
            if (!$pids)
                return "Нет заданий для выполнения.";
            
            $sql = "UPDATE `customs` SET `value` = '1' WHERE `code` = 'process'; TRUNCATE TABLE `pids`";
            pdo::getPdo()->query($sql);

            $insert = array();
            
            foreach ($pids as $pid)
            {
                @exec("php /var/www/www-root/data/www/studiof1-test.ru/cache_bg.php pid={$pid} > /dev/null &", $output, $return_var);
                 
                if ($return_var != -1)
                {
                    $insert[] = "({$pid})";                       
                }    
            }
            
            if ($insert)
            {
                $sql = "INSERT INTO `pids` (`pid`) VALUES ".implode(',', $insert);
                pdo::getPdo()->query($sql);
            }            
            
            return "Отправлена команда на старт.";
        }
        else
            return "Процесс запущен. Повторный запуск невозможен.";
    }
}

?>