<?

namespace framework\gen;

use framework\pdo;
use framework\tools;

class sc8
{
    private $_site_id = 0;  
    private $_sites_lazy = array();
   
    public function __construct($site_id = 0)
    {
        $this->_site_id = $site_id;    
    }
    
    private function _getSites()
    {
        //если сайт задан
        if ($this->_site_id) 
        {
            $site_id = $this->_site_id;
            
            if (!isset($this->_sites_lazy[$site_id]))
            {
                $sql = "SELECT `sites`.`id` as `site_id`, `setkas`.`name` as `setka_name`, `setkas`.`id` as `setka_id` FROM `sites` 
                                INNER JOIN `setkas` ON `setkas`.`id` = `sites`.`setka_id`
                                    WHERE `sites`.`id`=:id";
                                    
                $stm = pdo::getPdo()->prepare($sql);
                $stm->execute(array('id' => $site_id));
                $this->_sites_lazy[$site_id] = $stm->fetchAll(\PDO::FETCH_ASSOC);
            }
            
            return $this->_sites_lazy[$site_id];
        }
        
        return false; 
    }
    
    private function _getInfo()
    {
        $site_id = $this->_site_id;
        
        if (!isset($this->_info[$site_id]))
        {            
            $sql = "SELECT `model_types`.`name` as `model_type_name`, `model_types`.`id` as `type_id`, 
                        `markas`.`name` as `marka_name`, `markas`.`id` as `marka_id` FROM `model_type_to_markas_8` 
                INNER JOIN `markas` ON `model_type_to_markas_8`.`marka_id` = `markas`.`id` 
                INNER JOIN `model_types` ON `model_type_to_markas_8`.`model_type_id` = `model_types`.`id`";   
                                                         
            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array('site_id' => $site_id));
            $this->_info[$site_id] = $stm->fetchAll(\PDO::FETCH_ASSOC);
        }
        
        return $this->_info[$site_id];
    } 
        
    
    private function _getUrls()
    {    
        $sites = $this->_getSites();
        
        if (!$sites) return;
        
        $model_types = $this->_getInfo();
        $urls = array();
                
        $accord = array(
            'смартфон' => 'phone-service',
            'ноутбук' => 'laptop-service',
            'телевизор' => 'tv-service',
            'холодильник' => 'fridge-service',
            'стиральная машина' => 'washing-machine-service',
            'планшет' => 'tablet-service',
            'моноблок' => 'monobloc-service',
            'компьютер' => 'computer-service',
            'игровая приставка' => 'game-console-service',
        );                
        
        foreach ($sites as $site)
        {
            foreach ($model_types as $value)
            {
                $type_name = $value['model_type_name'];
                $marka_name = $value['marka_name'];
                
                $type_id = $value['type_id'];
                $marka_id = $value['marka_id'];
                                    
                $params = serialize(array('model_type_id' => $type_id, 'marka_id' => $marka_id));
                $urls[] = array($site['site_id'], "'".mb_strtolower($marka_name)."/".$accord[$type_name]."'",
                        "'".$params."'", tools::get_rand_dop());
                
                /*$select_table = $suffics.'_services';
                $sql = "SELECT `name_eng`, `id`, `name` FROM `{$select_table}`";
                $services = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
                
                foreach ($services as $service)
                {
                    $params = serialize(array('model_type_id' => $type_id, 'marka_id' => $marka_id, 'key' => 'service', 'id' => $service['id']));
                    $urls[] = array($site['site_id'], "'".($service['name_eng'] ? $service['name_eng'] : $service['name']).'-'.$accord[$type_name]."'", 
                            "'".$params."'", tools::get_rand_dop()); 
                }*/
            }
        }
        
        return $urls;
    } 
    
    
    public function genUrls()
    {
        if ($urls = $this->_getUrls())
        {
            $insert_urls = array();
            
            foreach ($urls as $url)
                $insert_urls[] = '('.implode(',', $url).','.tools::get_time().')';                
    
            $sql = "INSERT IGNORE INTO `urls` (`site_id`,`name`,`params`,`feed`,`date`) VALUES ".implode(',', $insert_urls);
            pdo::getPdo()->query($sql);
            //print_r($sql).PHP_EOL;
        }
    }
    
    public function delUrls()
    {
        if ($urls = $this->_getUrls())
        {
            foreach ($urls as $url)
            {
                $sql = "DELETE FROM `urls` WHERE `site_id`= {$url[0]} AND `name`= {$url[1]}";
                pdo::getPdo()->query($sql);
            }
        } 
    }
    
}

?>