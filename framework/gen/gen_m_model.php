<?

namespace framework\gen;

use framework\pdo;
use framework\tools;
use framework\rand_it;

class gen_m_model
{
    private $_m_model_id = 0;
    private $_sites = array();
    private $_m_model_info = array();
    
    private $_site_id = 0;
    private $_sites_lazy = array();
    private $_do_pass = true;
    
    private $_mode = false;
    
    public function __construct($m_model_id, $site_id = 0)
    {
        $this->_m_model_id = $m_model_id;  
        $this->_site_id = $site_id;    
    }
    
    public function setPass($pass)
    {
       $this->_do_pass = (bool) $pass;     
    }
    
    public function setSynMode($mode)
    {
        $this->_mode = (bool) $mode;
    }
    
    private function _passSites($sites)
    {
        $m_model_id = $this->_m_model_id; 
        $m_model_info = $this->_getInfo();
                    
        foreach ($sites as $key => $site)
        {
            $pass = true;
            
            if ($this->_do_pass)
            {
                if ($site['setka_name'] == 'СЦ-1' || $site['setka_name'] == 'СЦ-3' || $site['setka_name'] == 'СЦ-5' || $site['setka_name'] == 'СЦ-7')
                {
                    $sql = "SELECT * FROM `m_model_to_sites` 
                                INNER JOIN `m_models` ON `m_model_to_sites`.`m_model_id` = `m_models`.`id` 
                                INNER JOIN `model_types` ON `model_types`.`id` = `m_models`.`model_type_id`
                                INNER JOIN `markas` ON `markas`.`id` = `m_models`.`marka_id`
                            WHERE `m_model_to_sites`.`site_id` = {$site['site_id']} AND `markas`.`id` = {$m_model_info['marka_id']} 
                                    AND `model_types`.`id` = {$m_model_info['type_id']} AND `m_model_to_sites`.`m_model_id` != {$m_model_id}";
                             
                    if (pdo::getPdo()->query($sql)->fetchAll()) $pass = false; 
                }
                
                if ($site['setka_name'] == 'СЦ-4')
                {
                    
                }
            }                
            
            $sites[$key]['pass'] = $pass;
       }
       
       return $sites;
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
                $this->_sites_lazy[$site_id] = $this->_passSites($stm->fetchAll(\PDO::FETCH_ASSOC));
            }
            
            return $this->_sites_lazy[$site_id];
        }        
        
        $m_model_id = $this->_m_model_id; 
        
        if (!isset($this->_sites[$m_model_id]))
        {
           //выбираем все видимые сайты        
           $sql = "SELECT `sites`.`id` as `site_id`, `setkas`.`name` as `setka_name`, `setkas`.`id` as `setka_id` FROM `m_model_to_sites` 
                    INNER JOIN `sites` ON `sites`.`id` = `m_model_to_sites`.`site_id`
                    INNER JOIN `setkas` ON `setkas`.`id` = `sites`.`setka_id`
                            WHERE `m_model_to_sites`.`m_model_id`=:id";  
                                                   
           $stm = pdo::getPdo()->prepare($sql);
           $stm->execute(array('id' => $m_model_id));           
           $this->_sites[$m_model_id] = $this->_passSites($stm->fetchAll(\PDO::FETCH_ASSOC));
        }
        
        return $this->_sites[$m_model_id];
    }
    
     private function _getInfo()
     {
        $m_model_id = $this->_m_model_id; 
        
        if (!isset($this->_m_model_info[$m_model_id]))
        {            
            if ($this->_mode)
                $table = 'sublineykas'; 
            else
                $table = 'm_models';
                
            //находим доп. информацию
            $sql = "SELECT `{$table}`.`name` AS `m_model_name`, `model_types`.`name` AS `type_name`, `markas`.`name` AS `marka_name`,
                `model_types`.`id` as `type_id`, `markas`.`id` as `marka_id` FROM `{$table}` 
                INNER JOIN `model_types` ON `model_types`.`id` = `{$table}`.`model_type_id`
                    INNER JOIN `markas` ON `markas`.`id` = `{$table}`.`marka_id` WHERE `{$table}`.`id`=:id";
                    
            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array('id' => $m_model_id));
            $info = current($stm->fetchAll(\PDO::FETCH_ASSOC));
            
            $this->_m_model_info[$m_model_id] = $info;
            $this->_m_model_info[$m_model_id]['suffics'] = tools::get_suffics($info['type_name']);
        }
        
        return $this->_m_model_info[$m_model_id];
    }    
    
    //область видимости
    public function genScope()
    {
        $m_model_id = $this->_m_model_id;  
        
        //марка
        $sql = "SELECT `marka_id` FROM `m_models` WHERE `id`=:id";
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array('id' => $m_model_id)); 
        $marka_id = $stm->fetchColumn();
        
        //находим сайты связанные с маркой	
		$sql = "SELECT `site_id` FROM `marka_to_sites` WHERE `marka_id`=:id";
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array('id' => $marka_id)); 
        $sites = $stm->fetchAll(\PDO::FETCH_COLUMN);
        
        //добавляем модель к сайтам
        $insert = array();
        foreach ($sites as $site)
            $insert[] = '('.$site.','.$m_model_id.')';
            
        if ($insert)
        {
            $sql = "INSERT INTO `m_model_to_sites` (`site_id`,`m_model_id`) VALUES ".implode(',', $insert);
            pdo::getPdo()->query($sql);
        }
    }
    
    //сиинонимы
    public function genSyns()
    {
        $sites = $this->_getSites();
        $mode = $this->_mode;
       
        if (!$sites) return;
       
        $m_model_info = $this->_getInfo();         
        $suffics = $m_model_info['suffics'];
        
        $m_model_id = $this->_m_model_id;
        $marka_id = $m_model_info['marka_id'];
        $type_id = $m_model_info['type_id'];
        
        $rand = new rand_it();
        $rand->setCountVal(count($sites));
        $rand->setNameValue('id');
        $rand->setNameWeight('weight');
        
        $rand->setOnlyWeight(true);
        $rand->setDifference(4);
        
        if ($mode) $sublineyka_id = $this->_m_model_id;
        
        $tables = array('defect', 'service', 'complect');
        
        foreach ($tables as $value)
        {
            $table = $suffics.'_'.$value.'_syns';
            $get_field = $suffics.'_'.$value.'_id';
            $syn_field = $suffics.'_'.$value.'_syn_id';
            $into_table = $suffics.'_'.$value.'_to_m_models';           
            
             
            $test = pdo::getPdo()->query("SHOW TABLES LIKE '{$table}'")->fetchAll();
            // if(empty($test)){
            //     continue;
            // }
            $sql = "SELECT * FROM `{$table}`";
            $result = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
              
            
            
            $ret_keys = array();
              
            foreach ($result as $field)
                $ret_keys[$field[$get_field]][] = $field;
                
            $insert = array();      
        
            foreach ($ret_keys as $value)
            {
                $rand->setArray($value);
                
                $randIt = $rand->randIt();
                                        
                foreach ($randIt as $key => $value)
                {
                    $site = $sites[$key];
                    if ($site['pass'])
                    {
                        if ($site['setka_name'] == 'СЦ-1' || $site['setka_name'] == 'СЦ-3' || $site['setka_name'] == 'СЦ-5' || $site['setka_name'] == 'СЦ-7')
                        {
                             for ($j=0; $j<count($value); $j++)
                             {
                                $word = tools::word();
                                if ($mode && $site['setka_name'] == 'СЦ-3')
                                    $insert[] = "(NULL,NULL,NULL,{$value[$j]},{$sites[$key]['site_id']},{$j},{$word},{$sublineyka_id})";
                                else
                                    $insert[] = "(NULL,{$marka_id},{$type_id},{$value[$j]},{$sites[$key]['site_id']},{$j},{$word},NULL)";
                             }                  
                        }
                        
                        if ($site['setka_name'] == 'СЦ-2' || $site['setka_name'] == 'СЦ-4')
                        {
                            for ($j=0; $j<count($value); $j++)
                            {
                                $word = tools::word();
                                $insert[] = "({$m_model_id},NULL,NULL,{$value[$j]},{$sites[$key]['site_id']},{$j},{$word},NULL)";
                            }
                        } 
                    }                   
                 }                   
             }
             
             if ($insert)
             {
                $sql = "INSERT INTO `{$into_table}` (`m_model_id`, `marka_id`, `model_type_id`, `{$syn_field}`, `site_id`, `type`, `word`, `sublineyka_id`) VALUES ".implode(',', $insert);
                pdo::getPdo()->query($sql);
                // print_r($sql);
             }
        }
    }
    
   private function _getUrls()
   {    
        $sites = $this->_getSites();
        $mode = $this->_mode;
       
        if (!$sites) return;
        
        $m_model_info = $this->_getInfo();        
        $suffics = $m_model_info['suffics'];
        
        $m_model_id = $this->_m_model_id;
        $marka_id = $m_model_info['marka_id'];
        $type_id = $m_model_info['type_id'];
        
        $marka_name = tools::translit($m_model_info['marka_name']);
        $_marka_name = tools::translit($m_model_info['marka_name'],'_');
        
        $type_name = $m_model_info['type_name'];
        
        $m_model_name = tools::translit($m_model_info['m_model_name']);
        $_m_model_name = tools::translit($m_model_info['m_model_name'],'_');
        
        $urls = array();
        $table_mas = tools::get_codes($suffics);
        
        if ($mode)
        {
            $sublineyka_id = $this->_m_model_id;
            $_sublineyka_name = tools::translit($m_model_info['m_model_name'],'_');  
        }
        
        if ($site['setka_name'] == 'СЦ-7') 
        {
            unset($table_mas['complect']);
            unset($table_mas['defect']);    
        }
        
        foreach ($sites as $site)
        {
            if ($site['pass'])
            {
                switch ($site['setka_name'])
                {
                    case 'СЦ-1':
    
                        $accord = array('ноутбук' => 'remont-noutbukov', 'планшет' => 'remont-planshetov', 'смартфон' => 'remont-smartfonov');
                        
                        $params = serialize(array('model_type_id' => $type_id, 'marka_id' => $marka_id));
                        $urls[] = array($site['site_id'], "'".$accord[$type_name]."'",
                            "'".$params."'", tools::get_rand_dop());
                        
                        foreach ($table_mas as $key => $mas)
                        {
                            foreach ($mas as $value)
                            {
                                $params = serialize(array('model_type_id' => $type_id, 'marka_id' => $marka_id, 'key' => $key, 'id' => $value['id']));
                                $urls[] = array($site['site_id'], "'".$accord[$type_name].'/'.($value['name2'] ? $value['name2'] : $value['name']).'-'.$marka_name."'", 
                                        "'".$params."'", tools::get_rand_dop());
                            }
                        }                                        
                        
                    break;
                    case 'СЦ-2':                    
                        
                        $accord = array('ноутбук' => 'laptop', 'планшет' => 'tablets', 'смартфон' => 'phones');
                        
                        $params = serialize(array('model_type_id' => $type_id, 'marka_id' => $marka_id));
                        $urls[] = array($site['site_id'], "'".$accord[$type_name]."'",
                            "'".$params."'", tools::get_rand_dop());
                            
                        $params = serialize(array('m_model_id' => $m_model_id));
                        $urls[] = array($site['site_id'], "'".$accord[$type_name].'/'.$marka_name.'-'.$m_model_name."'",
                            "'".$params."'", tools::get_rand_dop());
                        
                        foreach ($table_mas as $key => $mas)
                        {
                            foreach ($mas as $value)
                            {
                                $params = serialize(array('m_model_id' => $m_model_id, 'key' => $key, 'id' => $value['id']));
                                $urls[] = array($site['site_id'], "'".$accord[$type_name].'/'.$marka_name.'-'.$m_model_name.'-'.$value['name']."'",
                                    "'".$params."'", tools::get_rand_dop());
                            }
                        }                                     
                        
                    break;
                    
                    case 'СЦ-3':                    
                       
                        $accord = array('ноутбук' => 'remont_noutbukov', 'планшет' => 'remont_planshetov', 'смартфон' => 'remont_telefonov');
                        
                        if ($mode)
                        {
                            $params = serialize(array('sublineyka_id' => $sublineyka_id));
                            $urls[] = array($site['site_id'], "'".$accord[$type_name].'_'.$_marka_name.'/'.$_sublineyka_name."'",
                                "'".$params."'", tools::get_rand_dop());
                            
                            foreach ($table_mas as $key => $mas)
                            {
                                foreach ($mas as $value)
                                {
                                    $params = serialize(array('sublineyka_id' => $sublineyka_id, 'key' => $key, 'id' => $value['id']));
                                    $urls[] = array($site['site_id'], "'".$accord[$type_name].'_'.$_marka_name.'/'.$_sublineyka_name.'/'.str_replace('-', '_', $value['name'])."'",
                                        "'".$params."'", tools::get_rand_dop());
                                }
                            }
                        }
                        else
                        {
                            $params = serialize(array('model_type_id' => $type_id, 'marka_id' => $marka_id));
                            $urls[] = array($site['site_id'], "'".$accord[$type_name].'_'.$_marka_name."'",
                                "'".$params."'", tools::get_rand_dop());
                            
                            foreach ($table_mas as $key => $mas)
                            {
                                foreach ($mas as $value)
                                {
                                    $params = serialize(array('model_type_id' => $type_id, 'marka_id' => $marka_id, 'key' => $key, 'id' => $value['id']));
                                    $urls[] = array($site['site_id'], "'".$accord[$type_name].'_'.$_marka_name.'/'.str_replace('-', '_', $value['name'])."'",
                                        "'".$params."'", tools::get_rand_dop());
                                }
                            }
                        }
                         
                    break;
                    
                    case 'СЦ-4':
                        
                        foreach ($table_mas as $key => $mas)
                        {
                            foreach ($mas as $value)
                            {
                                $params = serialize(array('m_model_id' => $m_model_id, 'key' => $key, 'id' => $value['id']));
                                $urls[] = array($site['site_id'], "'".str_replace('-', '_', ($value['name2'] ? $value['name2'] : $value['name']))."'",
                                    "'".$params."'", tools::get_rand_dop());
                            }
                        }                                                               
                        
                    break;
                    
                    case 'СЦ-5':
                        
                        $accord = array('ноутбук' => 'remont-notebooks', 'планшет' => 'remont-planshetov', 'смартфон' => 'remont-telefonov');
                        
                        $params = serialize(array('model_type_id' => $type_id, 'marka_id' => $marka_id));
                        $urls[] = array($site['site_id'], "'".$accord[$type_name].'-'.$marka_name."'",
                            "'".$params."'", tools::get_rand_dop());
                    
                    break;
                    
                    case 'СЦ-7':
                        
                        $accord = array('ноутбук' => 'laptops', 'планшет' => 'tablets', 'смартфон' => 'phones');
                        
                        $params = serialize(array('model_type_id' => $type_id, 'marka_id' => $marka_id));
                        $urls[] = array($site['site_id'], "'repair-".$accord[$type_name]."'",
                            "'".$params."'", tools::get_rand_dop());
                        
                        foreach ($table_mas as $key => $mas)
                        {
                            foreach ($mas as $value)
                            {
                                $params = serialize(array('model_type_id' => $type_id, 'marka_id' => $marka_id, 'key' => $key, 'id' => $value['id']));
                                $urls[] = array($site['site_id'], "'".($value['name_eng'] ? $value['name_eng'] : $value['name']).'-'.$accord[$type_name]."'", 
                                        "'".$params."'", tools::get_rand_dop());
                            }
                        }
                    
                    break;
                }
            }
        }
        
        return $urls;
    }    
    
    //урлы
    public function genUrls()
    {
        if ($urls = $this->_getUrls())
        {
            $insert_urls = array();
            
            foreach ($urls as $url)
                $insert_urls[] = '('.implode(',', $url).','.tools::get_time().')';                
    
            $sql = "INSERT IGNORE INTO `urls` (`site_id`,`name`,`params`,`feed`,`date`) VALUES ".implode(',', $insert_urls);
            pdo::getPdo()->query($sql);
            // print_r($sql);
        }
    }
    
    //контент
    public function genContent() {
        
        $sites = $this->_getSites();
        $mode = $this->_mode;
       
        if (!$sites) return;
        
        $m_model_info = $this->_getInfo();
        $suffics = $m_model_info['suffics'];
        
        $m_model_id = $this->_m_model_id;
        
        $marka_id = $m_model_info['marka_id'];
        $type_id = $m_model_info['type_id'];
        
        if ($mode) $sublineyka_id = $this->_m_model_id;
        
        $table_mas = tools::get_codes($suffics);
        
        if ($site['setka_name'] == 'СЦ-7') 
        {
            unset($table_mas['complect']);
            unset($table_mas['defect']);    
        }
        
        foreach ($table_mas as $key => $mas)
        {
            $into_table = $suffics.'_'.$key.'_model_vals';
            $get_field = $suffics.'_'.$key.'_id';
            
            $insert = array();      
            $rand_it = new rand_it();
            
            switch ($key)
            {   
                case 'service': 
                
                    $rand_it->setNameValue('id');       
                    $rand_it->setFill(false);  
                    
                    //defect_to_services
                    $d_to_s = array();                    
                    $d_to_s_table = tools::get_base($suffics, 'defect_to_services');
                    foreach ($d_to_s_table as $value) 
                        $d_to_s[$value[$suffics.'_service_id']][] = array('id' => (integer) $value[$suffics.'_defect_id']);
                        
                    $min_d_to_s = 'min_defect_to_service';
                    $max_d_to_s = 'max_defect_to_service'; 
                    $codes = array($min_d_to_s, $max_d_to_s);
                    
                    foreach ($mas as $value)
                    {
                        $id = $value['id'];
                        foreach ($sites as $site)
                        {
                            if ($site['pass'])
                            {    
                                $custom_vals = tools::get_custom($site['setka_name'], $codes);     
                                $defect_to_services = array();
                                
                                if (isset($custom_vals[$min_d_to_s]) && isset($custom_vals[$max_d_to_s]))
                                { 
                                    $rand_it->setArray($d_to_s[$id]);
                                    $rand_it->setCountVal(rand((integer) $custom_vals[$min_d_to_s], (integer) $custom_vals[$max_d_to_s]));
                                
                                    $defect_to_services = $rand_it->randIt();  
                                }

                                if ($site['setka_name'] == 'СЦ-1' || $site['setka_name'] == 'СЦ-5' || $site['setka_name'] == 'СЦ-7' || ($site['setka_name'] == 'СЦ-3' && !$mode))
                                {
                                    $insert[] = "(NULL,{$id},{$site['site_id']},{$marka_id},{$type_id},'".
                                            serialize(tools::create_other($suffics, $key, $id, $site['setka_name']))."','".
                                            serialize($defect_to_services)."',".
                                            rand().
                                            ",NULL)"; 
                                }
                                
                                if ($site['setka_name'] == 'СЦ-3' && $mode)
                                {
                                    $insert[] = "(NULL,{$id},{$site['site_id']},NULL,NULL,'".
                                            serialize(tools::create_other($suffics, $key, $id, $site['setka_name']))."','".
                                            serialize($defect_to_services)."',".
                                            rand().
                                            ",{$sublineyka_id})";
                                }
                                
                                if ($site['setka_name'] == 'СЦ-2' || $site['setka_name'] == 'СЦ-4')
                                {
                                   $insert[] = "({$m_model_id},{$id},{$site['site_id']},NULL,NULL,'".
                                            serialize(tools::create_other($suffics, $key, $id, $site['setka_name']))."','".
                                            serialize($defect_to_services)."',".
                                            rand().
                                            ",NULL)";  
                                }
                            }
                        }
                    }
                    
                    if ($insert)
                    {
                        $sql = "INSERT INTO `{$into_table}` (`m_model_id`, `{$get_field}`, `site_id`, `marka_id`, `model_type_id`, 
                                `other_services`, `dop_defects`, `feed`, `sublineyka_id`) VALUES ".implode(',', $insert);
                        pdo::getPdo()->query($sql);
                        //print_r($sql);
                    }
                    
                break; 
                
                case 'complect':
                
                    $rand_it->setNameValue('id');       
                    $rand_it->setFill(false);  
                    
                    //dop_services
                    $dops = array();
                    $dop_table = $suffics.'_services';
                    $sql = "SELECT `id` FROM `{$dop_table}` WHERE `dop` = 1";
                    foreach (pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN) as $value)
                        $dops[] = array('id' => (integer) $value);                    
                    
                    $min_dop_service = 'min_dop_service';
                    $max_dop_service = 'max_dop_service'; 
                    $codes = array($min_dop_service, $max_dop_service);
                    
                    foreach ($mas as $value)
                    {
                        $id = $value['id'];
                        foreach ($sites as $site)
                        {
                            if ($site['pass'])
                            {
                                $custom_vals = tools::get_custom($site['setka_name'], $codes);
                                $dop_services = array();
                                
                                if (isset($custom_vals[$min_dop_service]) && isset($custom_vals[$max_dop_service]))
                                {
                                    $rand_it->setArray($dops);
                                    $rand_it->setCountVal(rand((integer) $custom_vals[$min_dop_service], (integer) $custom_vals[$max_dop_service]));
                                   
                                    $dop_services = $rand_it->randIt();   
                                }
                                
                                if ($site['setka_name'] == 'СЦ-1' || $site['setka_name'] == 'СЦ-5' || $site['setka_name'] == 'СЦ-7' || ($site['setka_name'] == 'СЦ-3' && !$mode))
                                {
                                    $insert[] = "(NULL,{$id},{$site['site_id']},{$marka_id},{$type_id},'".
                                            serialize(tools::create_other($suffics, $key, $id, $site['setka_name']))."','".
                                            serialize($dop_services)."',".
                                            rand().
                                            ",NULL)"; 
                                }
                                
                                if ($site['setka_name'] == 'СЦ-3' && $mode)
                                {
                                     $insert[] = "(NULL,{$id},{$site['site_id']},NULL,NULL,'".
                                            serialize(tools::create_other($suffics, $key, $id, $site['setka_name']))."','".
                                            serialize($dop_services)."',".
                                            rand().
                                            ",{$sublineyka_id})"; 
                                }
                                
                                if ($site['setka_name'] == 'СЦ-2' || $site['setka_name'] == 'СЦ-4')
                                {
                                   $insert[] = "({$m_model_id},{$id},{$site['site_id']},NULL,NULL,'".
                                            serialize(tools::create_other($suffics, $key, $id, $site['setka_name']))."','".
                                            serialize($dop_services)."',".
                                            rand().
                                            ",NULL)";  
                                }  
                            }
                        }
                    }
                    
                    
                    if ($insert)
                    {
                        $sql = "INSERT INTO `{$into_table}` (`m_model_id`, `{$get_field}`, `site_id`, `marka_id`, `model_type_id`, 
                                `other_complects`, `dop_services`, `feed`, `sublineyka_id`) VALUES ".implode(',', $insert);
                        pdo::getPdo()->query($sql);
                         //print_r($sql);
                    }
                    
                break;
                
                case 'defect':
                
                    $rand_it->setNameValue('id');       
                    $rand_it->setFill(false);  
                    
                    //dop_reasons
                    $dop_reasons = array();                    
                    $reasons_table = tools::get_base($suffics, 'defect_reasons');
                    foreach ($reasons_table as $value) 
                        $dop_reasons[$value[$suffics.'_defect_id']][] = array('id' => (integer) $value['id']);
                        
                    $min_dop_reason = 'min_reason';
                    $max_dop_reason = 'max_reason'; 
                    $codes = array($min_dop_reason, $max_dop_reason);
                    
                    //services_to_defects
                    $s_to_d = array();                    
                    $s_to_d_table = tools::get_base($suffics, 'service_to_defects');
                    foreach ($s_to_d_table as $value) 
                        $s_to_d[$value[$suffics.'_defect_id']][] = array('id' => (integer) $value[$suffics.'_service_id']);
                        
                    $min_s_to_d = 'min_service_to_defect';
                    $max_s_to_d = 'max_service_to_defect'; 
                    $codes = array_merge($codes, array($min_s_to_d, $max_s_to_d));
                    
                    foreach ($mas as $value)
                    {
                        $id = $value['id'];
                        foreach ($sites as $site)
                        {
                            if ($site['pass'])
                            {
                                $custom_vals = tools::get_custom($site['setka_name'], $codes); 
                                $rand_dop_reasons = array();
                                $rand_dop_services = array();
                                
                                if (isset($custom_vals[$min_dop_reason]) && isset($custom_vals[$max_dop_reason])) 
                                {
                                    $rand_it->setArray($dop_reasons[$id]);
                                    $rand_it->setCountVal(rand((integer) $custom_vals[$min_dop_reason], (integer) $custom_vals[$max_dop_reason]));
                                    $rand_dop_reasons = $rand_it->randIt();
                                }
                                
                                if (isset($custom_vals[$min_s_to_d]) && isset($custom_vals[$max_s_to_d]))
                                { 
                                    $rand_it->setArray($s_to_d[$id]);
                                    $rand_it->setCountVal(rand((integer) $custom_vals[$min_s_to_d], (integer) $custom_vals[$max_s_to_d]));
                                    $rand_dop_services = $rand_it->randIt();
                                }
                                
                                if ($site['setka_name'] == 'СЦ-1' || $site['setka_name'] == 'СЦ-5' || $site['setka_name'] == 'СЦ-7' || ($site['setka_name'] == 'СЦ-3' && !$mode))
                                {
                                    $insert[] = "(NULL,{$id},{$site['site_id']},{$marka_id},{$type_id},'".
                                    serialize($rand_dop_reasons)."','".
                                    serialize($rand_dop_services)."','".
                                    serialize(tools::create_other($suffics, $key, $id, $site['setka_name']))."',".
                                    rand().
                                    ",NULL)"; 
                                }
                                
                                if ($site['setka_name'] == 'СЦ-3' && $mode)
                                {
                                    $insert[] = "(NULL,{$id},{$site['site_id']},NULL,NULL,'".
                                    serialize($rand_dop_reasons)."','".
                                    serialize($rand_dop_services)."','".
                                    serialize(tools::create_other($suffics, $key, $id, $site['setka_name']))."',".
                                    rand().
                                    ",{$sublineyka_id})";
                                }
                                
                                
                                if ($site['setka_name'] == 'СЦ-2' || $site['setka_name'] == 'СЦ-4')
                                {
                                    $insert[] = "({$m_model_id},{$id},{$site['site_id']},NULL,NULL,'".
                                    serialize($rand_dop_reasons)."','".
                                    serialize($rand_dop_services)."','".
                                    serialize(tools::create_other($suffics, $key, $id, $site['setka_name']))."',".
                                    rand().
                                    ",NULL)"; 
                                } 
                            }
                        }
                    }
                    
                    if ($insert)
                    {
                        $sql = "INSERT INTO `{$into_table}` (`m_model_id`, `{$get_field}`, `site_id`, `marka_id`, `model_type_id`,
                                 `dop_reasons`, `dop_services`, `other_defects`, `feed`, `sublineyka_id`) VALUES ".implode(',', $insert);
                        pdo::getPdo()->query($sql);
                        // print_r($sql);
                    }
                    
                break;
            }    
        }
        
    }    
     
    //область видимости
    public function delScope()
    {
        $m_model_id = $this->_m_model_id; 
        
        $sql = "DELETE FROM `m_model_to_sites` WHERE `m_model_id` = {$m_model_id}";
        pdo::getPdo()->query($sql); 
    }
    
    //сиинонимы
    public function delSyns()
    {
        $sites = $this->_getSites();
       
        if (!$sites) return;
        
        $m_model_info = $this->_getInfo();
        $suffics = $m_model_info['suffics'];
        
        $m_model_id = $this->_m_model_id;
        $marka_id = $m_model_info['marka_id'];
        $type_id = $m_model_info['type_id'];
        
        $tables = array('defect', 'service', 'complect');
        
        foreach ($tables as $value)
        {
            $into_table = $suffics.'_'.$value.'_to_m_models';   
             
            foreach ($sites as $site)
            {
                if ($site['pass'])
                {
                    if ($site['setka_name'] == 'СЦ-1' || $site['setka_name'] == 'СЦ-3' || $site['setka_name'] == 'СЦ-5' || $site['setka_name'] == 'СЦ-7')
                    {
                        $sql = "DELETE FROM `{$into_table}` WHERE `site_id` = {$site['site_id']} AND `marka_id` = {$marka_id} AND `model_type_id` = {$type_id}";
                        pdo::getPdo()->query($sql);
                     }
                    
                    if ($site['setka_name'] == 'СЦ-2' || $site['setka_name'] == 'СЦ-4')
                    {
                       $sql = "DELETE FROM `{$into_table}` WHERE `site_id`= {$site['site_id']} AND `m_model_id`= {$m_model_id}"; 
                       pdo::getPdo()->query($sql);
                    }
                }
            }
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
    
    public function delContent() 
    {
        $sites = $this->_getSites();
       
        if (!$sites) return;
        
        $m_model_info = $this->_getInfo();
        $suffics = $m_model_info['suffics'];
        
        $m_model_id = $this->_m_model_id;
        $marka_id = $m_model_info['marka_id'];
        $type_id = $m_model_info['type_id'];
        
        $tables = array('defect', 'service', 'complect');
        
        foreach ($tables as $value)
        {
            $into_table = $suffics.'_'.$value.'_vals';   
             
            foreach ($sites as $site)
            {
                if ($site['pass'])
                {
                    if ($site['setka_name'] == 'СЦ-1' || $site['setka_name'] == 'СЦ-3' || $site['setka_name'] == 'СЦ-5' || $site['setka_name'] == 'СЦ-7')
                    {
                        $sql = "DELETE FROM `{$into_table}` WHERE `site_id` = {$site['site_id']} AND `marka_id` = {$marka_id} AND `model_type_id` = {$type_id}"; 
                        pdo::getPdo()->query($sql);
                    }
                    
                    if ($site['setka_name'] == 'СЦ-2' || $site['setka_name'] == 'СЦ-4')
                    {
                        $sql = "DELETE FROM `{$into_table}` WHERE `site_id`= {$site['site_id']} AND `m_model_id`= {$m_model_id}"; 
                        pdo::getPdo()->query($sql);
                    }
                }
            }
        } 
    }
}

?>