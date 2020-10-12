<?

namespace framework\ajax\metrika_count;

use framework\pdo;
use framework\ajax as ajax;

class metrika_count extends ajax\ajax {
    
    public function __construct($args)
    {
        parent::__construct('');
        $site = isset($args['site']) ? $args['site'] : '';
        
        $answer = '';
        
        if ($site)
        {
            if (is_array($site))
            {
                $sql = "SELECT `name`, `metrica` FROM `sites` WHERE `name` IN ('".implode("','", $site)."') AND `metrica` != '' AND `metrica` IS NOT NULL";
                $answer = json_encode(pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_KEY_PAIR));
            }
            else
            {
                $sql = "SELECT `metrica` FROM `sites` WHERE `name`=:name AND `metrica` != '' AND `metrica` IS NOT NULL";
                $stm = pdo::getPdo()->prepare($sql); 
                $stm->execute(array('name' => $site)); 
                $answer = $stm->fetchColumn();
            }
        }
        
        $this->getWrapper()->addChildren($answer);
    }
}

?> 