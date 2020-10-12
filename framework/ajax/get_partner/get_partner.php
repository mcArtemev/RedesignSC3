<?

namespace framework\ajax\get_partner;

use framework\pdo;
use framework\ajax as ajax;

class get_partner extends ajax\ajax {
    
    public function __construct($args = array())
    {
        parent::__construct(''); 
        
        $email = isset($args['email']) ? $args['email'] : 'litovchenko@list.ru';
        $sites = isset($args['sites']) ? $args['sites'] : array();
        
        /*if ($sites)
        {        
            if ($source == -1)
            {
                $sql = "SELECT `partner_id` as `id1`, `partner_yd` as `id2`, `partner_ga` as `id3` FROM `sites` WHERE `name` IN ('".implode("','", $sites)."')";                
                $partners_id = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
            }
            else
            {
                $accord_source = ['partner_id', 'partner_yd', 'partner_ga'];
                $field_name = $accord_source[$source];  
                
                $sql = "SELECT `{$field_name}` as `id` FROM `sites` WHERE `name` IN ('".implode("','", $sites)."')";            
                $partners_id = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
            }
            
            if ($source == -1)
            {
                $t = array();
                foreach ($partners_id as $partner_id)
                {
                    $t[] = $partner_id['id1'];
                    $t[] = $partner_id['id2'];
                    $t[] = $partner_id['id3'];
                }
            }
            else
            {
                $t = array();
                foreach ($partners_id as $partner_id)
                    $t[] = $partner_id['id'];
            }
                
            $partners_id = $t;    
            
            $partners_id = array_unique($partners_id);
            
            if ($partners_id)
            {
                $sql = "UPDATE `partners` SET `email`=:email WHERE `id` IN (".implode(',', $partners_id).")"; echo $sql;
                $stm = pdo::getPdo()->prepare($sql); 
                $stm->execute(array('email' => $email)); 
            }
        }*/
        
        /*foreach ($sites as $source => $value)
        {
            $accord_source = ['partner_id', 'partner_yd', 'partner_ga'];
            $field_name = $accord_source[$source];  
            
            $sql = "SELECT DISTINCT `{$field_name}` as `id` FROM `sites` WHERE `name` IN ('".implode("','", $value)."')";            
            $partners_id = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN);
            
            if ($partners_id)
            {
                $sql = "UPDATE `partners` SET `email`=:email WHERE `id` IN (".implode(',', $partners_id).")"; echo $sql;
                $stm = pdo::getPdo()->prepare($sql); 
                $stm->execute(array('email' => $email)); 
            }            
        }*/
    }
}

?>     