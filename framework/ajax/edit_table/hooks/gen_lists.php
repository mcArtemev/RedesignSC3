<?

namespace framework\ajax\edit_table\hooks;

use framework\pdo;
use framework\tools;

class gen_lists
{
    public function beforeAdd(&$args)
    {
        //setka
        $sql = "SELECT `setkas`.`name` AS `setka_name`, `sites`.`name` AS `site_name` 
                FROM `sites` INNER JOIN `setkas` ON `sites`.`setka_id` = `setkas`.`id` WHERE `sites`.`id`=:site_id";                            
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array('site_id' => $args['site_id']));
        $datas = current($stm->fetchAll(\PDO::FETCH_ASSOC));
        
        $setka_name = $datas['setka_name'];
        $site_name = $datas['site_name'];
        
        $path = $_SERVER['DOCUMENT_ROOT'].'/lists/'.$site_name.'/';
        
        switch ($setka_name)
        {
            case 'СЦ-1':

                $sql = "SELECT  `models`.`name` AS `name`,
                        `model_types`.`name` AS `type`
                    FROM  `model_to_sites` 
                INNER JOIN  `models` ON  `models`.`id` =  `model_to_sites`.`model_id` 
                INNER JOIN  `m_models` ON  `m_models`.`id` =  `models`.`m_model_id` 
                INNER JOIN  `model_types` ON  `model_types`.`id` =  `m_models`.`model_type_id` 
                INNER JOIN  `markas` ON  `markas`.`id` =  `m_models`.`marka_id` 
                    WHERE  `model_to_sites`.`site_id`=:site_id";
        
                $stm = pdo::getPdo()->prepare($sql);
                $stm->execute(array('site_id' => $args['site_id']));
                $datas = $stm->fetchAll(\PDO::FETCH_ASSOC);

                if ($datas)
                {
                    $accord = array('ноутбук' => 'remont-noutbukov', 'планшет' => 'remont-planshetov', 'смартфон' => 'remont-smartfonov');
                    $strings = array('ноутбук' => array(), 'планшет' => array(), 'смартфон' => array());
                    
                    foreach ($datas as $data)
                        $strings[$data['type']][]  = $data['name'];
                        
                    foreach ($strings as $key => $string)
                         tools::file_force_contents($path.$accord[$key].'.list', implode(PHP_EOL, $string));
                }
                             
            break;
            
            case 'СЦ-2':
            
                $sql = "SELECT  `models`.`name` AS `name`,
                        `model_types`.`name` AS `type`,
                        `m_models`.`name` AS `m_model`,
                        `markas`.`name` AS `marka`,
                        `models`.`submodel` AS `submodel`    
                    FROM  `model_to_sites` 
                INNER JOIN  `models` ON  `models`.`id` =  `model_to_sites`.`model_id` 
                INNER JOIN  `m_models` ON  `m_models`.`id` =  `models`.`m_model_id` 
                INNER JOIN  `model_types` ON  `model_types`.`id` =  `m_models`.`model_type_id` 
                INNER JOIN  `markas` ON  `markas`.`id` =  `m_models`.`marka_id` 
                    WHERE  `model_to_sites`.`site_id`=:site_id";
        
                $stm = pdo::getPdo()->prepare($sql);
                $stm->execute(array('site_id' => $args['site_id']));
                $datas = $stm->fetchAll(\PDO::FETCH_ASSOC);
                
                if ($datas)
                {
                    $m_models = array();
                    $models = array();
                    
                    $accord = array('ноутбук' => 'laptop', 'планшет' => 'tablets', 'смартфон' => 'phones');
                    
                    foreach ($datas as $data)
                    {
                        $m_models[$data['type']][$data['m_model']] = true;
                        $key = $accord[$data['type']].'/'.tools::translit($data['marka']).'-'.tools::translit($data['m_model']);
                        $models[$key.'.list'][] = $data['name'].';/'.$key.'/'.tools::translit($data['submodel']).'/';
                    }
                        
                    $t = array();
                    foreach ($m_models as $key => $value)
                        foreach ($value as $k => $v)
                            $t[$key][] = $k;
                    
                    $m_models = $t;                   
                    
                    foreach ($m_models as $key => $string)
                        tools::file_force_contents($path.$accord[$key].'.list', implode(PHP_EOL, $string));
                    
                    foreach ($models as $key => $string)  
                        tools::file_force_contents($path.$key, implode(PHP_EOL, $string));
                    
                }
            
            break;
            
            case 'СЦ-3':
            
                $sql = "SELECT  `models`.`name` AS `name`,
                        `model_types`.`name` AS `type`,
                        `sublineykas`.`name` AS `sublineyka`,
                        `markas`.`name` AS `marka`,
                        `models`.`submodel` AS `submodel`    
                    FROM  `model_to_sites` 
                INNER JOIN  `models` ON  `models`.`id` =  `model_to_sites`.`model_id` 
                INNER JOIN  `sublineykas` ON  `sublineykas`.`id` =  `models`.`sublineyka_id` 
                INNER JOIN  `model_types` ON  `model_types`.`id` =  `sublineykas`.`model_type_id` 
                INNER JOIN  `markas` ON  `markas`.`id` =  `sublineykas`.`marka_id` 
                    WHERE  `model_to_sites`.`site_id`=:site_id";
        
                $stm = pdo::getPdo()->prepare($sql);
                $stm->execute(array('site_id' => $args['site_id']));
                $datas = $stm->fetchAll(\PDO::FETCH_ASSOC);
                
                if ($datas)
                {
                    $sublineykas = array();
                    $models = array();
                    
                    $accord = array('ноутбук' => 'remont_noutbukov', 'планшет' => 'remont_planshetov', 'смартфон' => 'remont_telefonov');
                    
                    foreach ($datas as $data)
                    {
                        $_marka = tools::translit($data['marka'],'_');
                        
                        $sublineykas[$accord[$data['type']].'_'.$_marka.'.list'][$data['sublineyka']] = true;
                        
                        $key = $accord[$data['type']].'_'.$_marka.'/'.tools::translit($data['sublineyka'],'_');
                        $models[$key.'.list'][] = $data['name'].';/'.$key.'/'.tools::translit($data['submodel'],'_').'/';
                    }
                        
                    $t = array();
                    foreach ($sublineykas as $key => $value)
                        foreach ($value as $k => $v)
                            $t[$key][] = $k;
                    
                    $sublineykas = $t;                   
                    
                    foreach ($sublineykas as $key => $string)
                        tools::file_force_contents($path.$key, implode(PHP_EOL, $string));
                    
                    foreach ($models as $key => $string)  
                        tools::file_force_contents($path.$key, implode(PHP_EOL, $string));
                    
                }
            
            break;
            
            
        }        
       
        return false;
    }
}