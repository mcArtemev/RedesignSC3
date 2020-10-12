<?

namespace framework\gen;

use framework\pdo;
use framework\tools;
use framework\rand_it;

class gen_model
{
    private $_model_id = 0;
    private $_sites = array();
    private $_model_info = array();
    
    private $_site_id = 0;
    private $_sites_lazy = array();
    
    public function __construct($model_id, $site_id = 0)
    {
        $this->_model_id = $model_id;
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
        
        $model_id = $this->_model_id; 
        
        if (!isset($this->_sites[$model_id]))
        {
           //выбираем все видимые сайты        
           $sql = "SELECT `sites`.`id` as `site_id`, `setkas`.`name` as `setka_name`, `setkas`.`id` as `setka_id` FROM `model_to_sites` 
                    INNER JOIN `sites` ON `sites`.`id` = `model_to_sites`.`site_id`
                    INNER JOIN `setkas` ON `setkas`.`id` = `sites`.`setka_id`
                            WHERE `model_to_sites`.`model_id`=:id";  
           
	       $stm = pdo::getPdo()->prepare($sql);
           $stm->execute(array('id' => $model_id));
           $this->_sites[$model_id] = $stm->fetchAll(\PDO::FETCH_ASSOC);
        }
        
        return $this->_sites[$model_id];
    }
    
     private function _getInfo()
     {
        $model_id = $this->_model_id; 
        
        if (!isset($this->_model_info[$model_id]))
        {            
            //находим доп. информацию
            $sql = "SELECT `m_models`.`name` AS `m_model_name`, `model_types`.`name` AS `type_name`, `markas`.`name` AS `marka_name`,
                `model_types`.`id` as `type_id`, `m_models`.`id` as `m_model_id`, `models`.`submodel` AS `submodel`,
                    `models`.`name` AS `model_name`, `models`.`sublineyka` AS `sublineyka`, `models`.`lineyka` AS `lineyka`
                    FROM `models` 
                INNER JOIN `m_models` ON `m_models`.`id` = `models`.`m_model_id`
                INNER JOIN `model_types` ON `model_types`.`id` = `m_models`.`model_type_id`
                INNER JOIN `markas` ON `markas`.`id` = `m_models`.`marka_id` WHERE `models`.`id`=:id";
                    
            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array('id' => $model_id));
            $info = current($stm->fetchAll(\PDO::FETCH_ASSOC));
            
            $this->_model_info[$model_id] = $info;
            $this->_model_info[$model_id]['suffics'] = tools::get_suffics($info['type_name']);
        }
        
        return $this->_model_info[$model_id];
    }    
    
    //область видимости
    public function genScope()
    {
        $model_id = $this->_model_id;  
        
        //модель
        $sql = "SELECT `m_model_id` FROM `models` WHERE `id`=:id";
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array('id' => $model_id)); 
        $m_model_id = $stm->fetchColumn();
        
        //находим сайты связанные с моделью
        $sql = "SELECT `site_id` FROM `m_model_to_sites` WHERE `m_model_id`=:id";
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array('id' => $m_model_id)); 
        $sites = $stm->fetchAll(\PDO::FETCH_COLUMN);
        
        //добавляем устройство к сайтам
        $insert = array();
        foreach ($sites as $site)
            $insert[] = '('.$site.','.$model_id.')';
            
        if ($insert)
        {
            $sql = "INSERT INTO `model_to_sites` (`site_id`,`model_id`) VALUES ".implode(',', $insert);
            pdo::getPdo()->query($sql);
        }
    }
    
    //сиинонимы
    public function genSyns()
    {
        $sites = $this->_getSites();
       
        if (!$sites) return;
       
        $model_info = $this->_getInfo();
        $suffics = $model_info['suffics'];
        
        $model_id = $this->_model_id;
        
        $rand = new rand_it();
        $rand->setCountVal(count($sites));
        $rand->setNameValue('id');
        $rand->setNameWeight('weight');
        
        $rand->setOnlyWeight(true);
        $rand->setDifference(4);
        
        $tables = array('defect', 'service', 'complect');
        
        foreach ($tables as $value)
        {
            $table = $suffics.'_'.$value.'_syns';
            $get_field = $suffics.'_'.$value.'_id';
            $syn_field = $suffics.'_'.$value.'_syn_id';
            $into_table = $suffics.'_'.$value.'_to_models';           
            
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
                    $sql = "SELECT `id` FROM `{$into_table}` WHERE `model_id`=:model_id AND `site_id`=:site_id";
                    $stm = pdo::getPdo()->prepare($sql);
                    $stm->execute(array('model_id' => $model_id, 'site_id' => $sites[$key]['site_id'])); 
                    $is_has = $stm->fetchColumn();
                    
                    if (!$is_has)
                    {
                        for ($j=0; $j<count($value); $j++)
                        {
                            $word = tools::word();
                            $insert[] = "({$model_id},{$value[$j]},{$sites[$key]['site_id']},{$j},{$word})";
                        }                                        
                    }
                }
             }
             
             if ($insert)
             {
                $sql = "INSERT INTO `{$into_table}` (`model_id`, `{$syn_field}`, `site_id`, `type`, `word`) VALUES ".implode(',', $insert);
                pdo::getPdo()->query($sql);
             }
        }
    }
    
    private function _getUrls()
    {
        $sites = $this->_getSites();
       
        if (!$sites) return;
        
        $model_info = $this->_getInfo();
        $suffics = $model_info['suffics'];
        
        $model_id = $this->_model_id;
        
        $marka_name = tools::translit($model_info['marka_name']);
        $_marka_name = tools::translit($model_info['marka_name'],'_');
        
        $type_name = $model_info['type_name'];
        
        $m_model_name = tools::translit($model_info['m_model_name']);
        $_m_model_name = tools::translit($model_info['m_model_name'],'_');        
        
        $submodel_name = tools::translit($model_info['submodel']);
        $full_name =  tools::translit($model_info['model_name']);     
        $sublineyka_name = tools::translit($model_info['sublineyka']); 
        
        $_submodel_name = tools::translit($model_info['submodel'],'_');
        $_full_name =  tools::translit($model_info['model_name'],'_');     
        $_sublineyka_name = tools::translit($model_info['sublineyka'],'_'); 
        
        if (mb_strtolower($model_info['lineyka']) == mb_strtolower($model_info['sublineyka']))
            $model_sc5 = $submodel_name;   
        else
            $model_sc5 = $m_model_name.' '.$submodel_name; 
                                        
        $model_sc5 = str_replace(array('-',' '), '', $model_sc5);
        
        $urls = array();
        $table_mas = tools::get_codes($suffics);
        
        $t_mas5 = array();
        foreach ($table_mas['service'] as $value)
            $t_mas5[$value['id']] = $value;
        
        foreach ($sites as $site)
        {
            switch ($site['setka_name'])
            {
                case 'СЦ-1':
                
                    $accord = array('ноутбук' => 'remont-noutbukov', 'планшет' => 'remont-planshetov', 'смартфон' => 'remont-smartfonov');

                    $params = serialize(array('model_id' => $model_id));
                    $urls[] = array($site['site_id'], "'".$accord[$type_name].'/'.$full_name."'", 
                                "'".$params."'", tools::get_rand_dop());
                    
                    foreach ($table_mas as $key => $mas)
                    {
                        foreach ($mas as $value)
                        {
                            $params = serialize(array('model_id' => $model_id, 'key' => $key, 'id' => $value['id']));
                            $urls[] = array($site['site_id'], "'".$accord[$type_name].'/'.$full_name.'/'.($value['name2'] ? $value['name2'] : $value['name'])."'", 
                                        "'".$params."'", tools::get_rand_dop());
                        }
                    }
                    
                break;
                case 'СЦ-2':
                    
                    $accord = array('ноутбук' => 'laptop', 'планшет' => 'tablets', 'смартфон' => 'phones');

                    $params = serialize(array('model_id' => $model_id));
                    $urls[] = array($site['site_id'], "'".$accord[$type_name].'/'.$marka_name.'-'.$m_model_name.'/'.$submodel_name."'",
                            "'".$params."'", tools::get_rand_dop());
                    
                    foreach ($table_mas as $key => $mas)
                    {
                        foreach ($mas as $value)
                        {
                            $params = serialize(array('model_id' => $model_id, 'key' => $key, 'id' => $value['id']));
                            $urls[] = array($site['site_id'], "'".$accord[$type_name].'/'.$marka_name.'-'.$m_model_name.'/'.$submodel_name.'/'.$value['name']."'",
                                    "'".$params."'", tools::get_rand_dop());
                        }
                    }                  
                    
                break;
                
                case 'СЦ-3':
                    
                    $accord = array('ноутбук' => 'remont_noutbukov', 'планшет' => 'remont_planshetov', 'смартфон' => 'remont_telefonov');
                    
                    $params = serialize(array('model_id' => $model_id));
                    $urls[] = array($site['site_id'], "'".$accord[$type_name].'_'.$_marka_name.'/'.$_sublineyka_name.'/'.$_submodel_name."'",
                            "'".$params."'", tools::get_rand_dop());                                              
                    
                    foreach ($table_mas as $key => $mas)
                    {
                        foreach ($mas as $value)
                        {
                            $params = serialize(array('model_id' => $model_id, 'key' => $key, 'id' => $value['id']));
                            $urls[] = array($site['site_id'], "'".$accord[$type_name].'_'.$_marka_name.'/'.$_sublineyka_name.'/'.$_submodel_name.'/'.str_replace('-', '_', $value['name'])."'",
                                    "'".$params."'", tools::get_rand_dop());
                        }
                    }
                    
                break;
                
                case 'СЦ-4':
                    
                    $params = serialize(array('model_id' => $model_id));
                    $urls[] = array($site['site_id'], "'remont_".$_full_name."'",
                            "'".$params."'", tools::get_rand_dop());                        
                    
                    foreach ($table_mas as $key => $mas)
                    {
                        foreach ($mas as $value)
                        {
                            $params = serialize(array('model_id' => $model_id, 'key' => $key, 'id' => $value['id']));
                            $urls[] = array($site['site_id'], "'remont_".$_full_name.'/'.str_replace('-', '_', ($value['name2'] ? $value['name2'] : $value['name']))."'",
                                    "'".$params."'", tools::get_rand_dop());
                        }
                    }
                    
                break;
                
                case 'СЦ-5':
                
                    $accord = array('ноутбук' => 'remont-notebooks', 'планшет' => 'remont-planshetov', 'смартфон' => 'remont-telefonov');
                    
                    $table_mas_5 = array();
                    $tables_5 = array('service');
                    
                    foreach ($tables_5 as $value)
                    {
                        $select_table = $suffics.'_'.$value.'s';
                        $select_key = $value;
                        
                        if (pdo::getPdo()->query("SHOW TABLES LIKE '{$select_table}'")->rowCount() > 0)
                        {
                            $sql = "SELECT `name3`, `id` FROM `{$select_table}`";
                            $table_mas_5[$select_key] = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
                        }
                    }                    
                    
                    $params = serialize(array('model_id' => $model_id));
                    $urls[] = array($site['site_id'], "'".$accord[$type_name].'-'.$marka_name.'/'.$model_sc5."'",
                            "'".$params."'", tools::get_rand_dop());  
                            
                    //$accord = array('p' => 3, 'n' => 3, 'f' => 3);
                    
                    //$value = $t_mas5[$accord[$suffics]];
      
                    /*$params = serialize(array('model_id' => $model_id, 'key' => 'service', 'id' => $value['id']));
                    $urls[] = array($site['site_id'], "'zamena-ekrana-".$marka_name."/".$model_sc5."'",
                                    "'".$params."'", tools::get_rand_dop());*/
                                    
                    foreach ($table_mas_5 as $key => $mas)
                    {
                        foreach ($mas as $value)
                        {
                            $params = serialize(array('model_id' => $model_id, 'key' => $key, 'id' => $value['id']));
                            $urls[] = array($site['site_id'], "'".$value['name3']."-".$marka_name."/".$model_sc5."'",
                                    "'".$params."'", tools::get_rand_dop());
                        }
                    }                   
                
                break;
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
                
            //print_r($insert_urls);         
    
            $sql = "INSERT IGNORE INTO `urls` (`site_id`,`name`,`params`,`feed`,`date`) VALUES ".implode(',', $insert_urls);
            pdo::getPdo()->query($sql);
        }
    }
    
    //контент
    public function genContent()
    {
        $sites = $this->_getSites();
       
        if (!$sites) return;
        
        $model_info = $this->_getInfo();        
        $suffics = $model_info['suffics'];
        
        $model_id = $this->_model_id;
        
        $table_mas = tools::get_codes($suffics);
        
        foreach ($table_mas as $key => $mas)
        {
            $into_table = $suffics.'_'.$key.'_vals';                    
            $get_field = $suffics.'_'.$key.'_id';
            
            $insert = array();
            $rand_it = new rand_it();
              
            switch ($key)
            {   
                case 'service':
                                            
                    $rand_it->setNameValue('id');       
                    $rand_it->setFill(false);  
                    
                    //cost table
                    $service_vals = tools::get_base($suffics, 'service_cost');
                    $vals = array();
                                            
                    foreach ($service_vals as $value)
                        $vals[$value['setka_id']][$value[$get_field]] = array((integer) $value['price'], (integer) $value['time_min'], (integer) $value['time_max'], (integer) $value['garantee']);
                        
                    $service_vals = $vals;
                    
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
                            $custom_vals = tools::get_custom($site['setka_name'], $codes);     
                            $defect_to_services = array();
                            
                            if (isset($custom_vals[$min_d_to_s]) && isset($custom_vals[$max_d_to_s]))
                            {
                                $rand_it->setArray($d_to_s[$id]);
                                $rand_it->setCountVal(rand((integer) $custom_vals[$min_d_to_s], (integer) $custom_vals[$max_d_to_s]));

                                $defect_to_services = $rand_it->randIt();
                            }  
                                    
                            $ar = $service_vals[$site['setka_id']][$id];
                            
                            $sql = "SELECT `id` FROM `{$into_table}` WHERE `model_id`=:model_id AND `site_id`=:site_id";
                            $stm = pdo::getPdo()->prepare($sql);
                            $stm->execute(array('model_id' => $model_id, 'site_id' => $site['site_id'])); 
                            $is_has = $stm->fetchColumn();
                            
                            if (!$is_has) 
                            {
                                $insert[] = "({$model_id},{$id},{$site['site_id']},{$ar[0]},{$ar[1]},{$ar[2]},{$ar[3]},'".
                                        serialize(tools::create_other($suffics, $key, $id, $site['setka_name']))."','".
                                        serialize($defect_to_services)."',".
                                        rand().
                                        ")";
                            } 
                        }
                    }
                    
                    if ($insert)
                    {
                        $sql = "INSERT INTO `{$into_table}` (`model_id`, `{$get_field}`, `site_id`, `price`, `time_min`, 
                                `time_max`, `garantee`, `other_services`, `dop_defects`, `feed`) VALUES ".implode(',', $insert);
                        pdo::getPdo()->query($sql);
                    }
                    
                break; 
                
                case 'complect':
                
                    $rand_it->setCountVal(count($sites));
                    $rand_it->setNameValue('val');
                    
                    $rand_it_dops = new rand_it();
                    $rand_it_dops->setNameValue('id');       
                    $rand_it_dops->setFill(false);  
                    
                    //price
                    $prices = array();                    
                    $prices_table = tools::get_base($suffics, 'complect_costs');
                    foreach ($prices_table as $value)
                    {
                        foreach (explode(';',$value['prices']) as $val2)
                            $prices[$value[$get_field]][] = array('val' => (integer) $val2);
                    }
                    
                    //amounts
                    $amounts = array();                    
                    $amounts_table = tools::get_base($suffics, 'complect_amounts');
                    foreach ($amounts_table as $value)
                        $amounts[$value['setka_id']] = explode(';',$value['amounts']);
                    
                    //available
                    $availables = array();
                    $availables_table = tools::get_base($suffics, 'available_to_setkas');
                    foreach ($availables_table as $value)
                        $availables[$value['setka_id']][] = $value['available_id'];                    
                    
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
                        
                        $rand_it->setArray($prices[$id]);                        
                        $price_rand = $rand_it->randIt();
                        
                        foreach ($sites as $key_site => $site)
                        {
                            $price = $price_rand[$key_site];
                            
                            $amount = tools::get_rand($amounts[$site['setka_id']]);
                            
                            if (isset($availables[$site['setka_id']]))
                                $available = tools::get_rand($availables[$site['setka_id']]);
                            else
                                $available = 'NULL';
                                
                            $custom_vals = tools::get_custom($site['setka_name'], $codes);
                            $dop_services = array();
                            
                            if (isset($custom_vals[$min_dop_service]) && isset($custom_vals[$max_dop_service]))
                            {
                                $rand_it_dops->setArray($dops);
                                $rand_it_dops->setCountVal(rand((integer) $custom_vals[$min_dop_service], (integer) $custom_vals[$max_dop_service]));
                           
                                $dop_services = $rand_it_dops->randIt();
                            }
                            
                            $sql = "SELECT `id` FROM `{$into_table}` WHERE `model_id`=:model_id AND `site_id`=:site_id";
                            $stm = pdo::getPdo()->prepare($sql);
                            $stm->execute(array('model_id' => $model_id, 'site_id' => $site['site_id'])); 
                            $is_has = $stm->fetchColumn();   
                            
                            if (!$is_has)
                            {
                                $insert[] = "({$model_id},{$id},{$site['site_id']},{$price},'".
                                    serialize(tools::create_other($suffics, $key, $id, $site['setka_name']))."',
                                    {$available},{$amount},'".
                                    serialize($dop_services)."',".
                                    rand().
                                ")";
                            }    
                        }
                    }
                    
                    if ($insert)
                    {
                        $sql = "INSERT INTO `{$into_table}` (`model_id`, `{$get_field}`, `site_id`, `price`, 
                                `other_complects`, `available_id`, `amount`, `dop_services`, `feed`) VALUES ".implode(',', $insert);
                        pdo::getPdo()->query($sql);
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
                            
                            $sql = "SELECT `id` FROM `{$into_table}` WHERE `model_id`=:model_id AND `site_id`=:site_id";
                            $stm = pdo::getPdo()->prepare($sql);
                            $stm->execute(array('model_id' => $model_id, 'site_id' => $site['site_id'])); 
                            $is_has = $stm->fetchColumn(); 
                            
                            if (!$is_has)
                            {
                                $insert[] = "({$model_id},{$id},{$site['site_id']},'".
                                    serialize($rand_dop_reasons)."','".
                                    serialize($rand_dop_services)."','".
                                    serialize(tools::create_other($suffics, $key, $id, $site['setka_name']))."',".
                                    rand().")";   
                            }                                    
                        }
                    }
                    
                    if ($insert)
                    {
                        $sql = "INSERT INTO `{$into_table}` (`model_id`, `{$get_field}`, `site_id`, `dop_reasons`, 
                                `dop_services`, `other_defects`, `feed`) VALUES ".implode(',', $insert);
                        pdo::getPdo()->query($sql);
                    }
                    
                break;                   
            }
        }
    }    
     
    //область видимости
    public function delScope()
    {
        $model_id = $this->_model_id; 
        
        $sql = "DELETE FROM `model_to_sites` WHERE `model_id`= {$model_id}";
        pdo::getPdo()->query($sql);
    }
    
    //сиинонимы
    public function delSyns()
    {
        $sites = $this->_getSites();
       
        if (!$sites) return;
        
        $model_info = $this->_getInfo();
        $suffics = $model_info['suffics'];
        
        $model_id = $this->_model_id;
        
        $tables = array('defect', 'service', 'complect');
        
        foreach ($tables as $value)
        {
            $into_table = $suffics.'_'.$value.'_to_models';   
             
            foreach ($sites as $site)
            {
                $sql = "DELETE FROM `{$into_table}` WHERE `site_id`= {$site['site_id']} AND `model_id`= {$model_id}"; 
                pdo::getPdo()->query($sql);
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
        
        $model_info = $this->_getInfo();
        $suffics = $model_info['suffics'];
        
        $model_id = $this->_model_id;
        
        $tables = array('defect', 'service', 'complect');
        
        foreach ($tables as $value)
        {
            $into_table = $suffics.'_'.$value.'_vals';   
             
            foreach ($sites as $site)
            {
                $sql = "DELETE FROM `{$into_table}` WHERE `site_id`= {$site['site_id']} AND `model_id`= {$model_id}"; 
                pdo::getPdo()->query($sql);
            }
        } 
    }
}

?>