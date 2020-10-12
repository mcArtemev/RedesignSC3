<?

namespace framework\ajax\update_partner;

use framework\pdo;
use framework\ajax as ajax;

class update_partner extends ajax\ajax {
    
    public function __construct($args = array())
    {
        parent::__construct(''); 
        
        $site_name1 = isset($args['site_name_1']) ? $args['site_name_1'] : '';
        $site_name2 = isset($args['site_name_2']) ? $args['site_name_2'] : '';
        
        if (!$site_name1 || !$site_name2) return;
        
        $partner1 = $this->_get_partner($site_name1);        
        $partner2 = $this->_get_partner($site_name2);
        
        $exclude = isset($args['exclude']) ? $args['exclude'] : false;
        
        if ($partner1 && $partner2)
        {
            $sql = "SELECT * FROM `partners` WHERE `id`=:id";   
            $stm = pdo::getPdo()->prepare($sql);   
            $stm->execute(array('id' => $partner1));  
            $data_select = current($stm->fetchAll(\PDO::FETCH_ASSOC));
            
            unset($data_select['name']);
            $data_select['id'] = $partner2;  
            
            if ($exclude)
            {
                $t['exclude'] = $exclude;
                
                $sign1 = rand(0, 1);
                $sign2 = rand(0, 1);
                
                $diff1 = rand(1000, 9999) * 0.000001;
                $diff2 = rand(1000, 9999) * 0.000001;
                
                $diff1 = ($sign1) ? $diff1 : (-1) * $diff1;
                $diff2 = ($sign2) ? $diff2 : (-1) * $diff2;
                
                $t['x'] = $data_select['x'] + $diff1;
                $t['y'] = $data_select['y'] + $diff2;
               
                $t['email'] = $data_select['email'];
                $t['time'] = $data_select['time'];
                $t['id'] = $data_select['id'];
                
                $data_select = $t;
            }
            
            $sql = "UPDATE `partners` SET ".pdo::prepare($data_select)." WHERE `id`=:id";
            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute($data_select);
        }
    }
    
    private function _get_partner($name)
    {
        $sql = "SELECT `partner_id` FROM `sites` WHERE `name`=:name LIMIT 0,1";   
        $stm = pdo::getPdo()->prepare($sql);   
        $stm->execute(array('name' => $name));          
        $partner_id = $stm->fetchColumn();
        
        return $partner_id;
    }
}

?>    