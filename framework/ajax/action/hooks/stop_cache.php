<?

namespace framework\ajax\action\hooks;

use framework\pdo;

class stop_cache
{
    public function doAction()
    {
        $sql = "UPDATE `customs` SET `value` = '0' WHERE `code` = 'process'";
        pdo::getPdo()->query($sql);
        
        return "Отправлена команда на остановку."; 
    }
}

?>