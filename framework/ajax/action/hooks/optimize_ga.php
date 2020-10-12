<?

namespace framework\ajax\action\hooks;

use framework\pdo;
use framework\ajax\action\idoAction;  

class optimize_yd implements idoAction  
{
    public function doAction()
    {
        $sql = "SELECT COUNT(*) FROM `ads_ga`";
        $ads = (integer) pdo::getPdo()->query($sql)->fetchColumn();
            
        if (!$ads) return 'Нет объявлений.';
        
        return 'Оптимизация завершена.';
    }
}