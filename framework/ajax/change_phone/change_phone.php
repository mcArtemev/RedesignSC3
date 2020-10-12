<?

namespace framework\ajax\change_phone;

use framework\pdo;
use framework\ajax as ajax;

class change_phone extends ajax\ajax {
    
    public function __construct($args = array())
    {
        parent::__construct(''); 
        
        $mas = isset($args['mas']) ? $args['mas'] : array();
        $sites = isset($args['sites']) ? $args['sites'] : array();
        
        if ($sites)
        {        
            $sets = array();
            
            foreach ($mas as $key => $value)
            {        
                if ($key == 'mango_id') $key = 'phone';                
                $sets[] = "`{$key}`='".$value."'";
            }
            
            $sql = "UPDATE `sites` SET ".implode(',', $sets)." WHERE `name` IN ('".implode("','", $sites)."')"; echo $sql;
            pdo::getPdo()->query($sql);
        }
    }
}

?>     