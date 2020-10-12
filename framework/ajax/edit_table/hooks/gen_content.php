<?

namespace framework\ajax\edit_table\hooks;

use framework\pdo;
use framework\gen\gen_m_model;
use framework\gen\gen_model;

class gen_content
{
    public function beforeAdd(&$args)
    {
        $sites = array();
        
        if ($args['setka_id'])
        {
            $sql = "SELECT `id` FROM `sites` WHERE `setka_id`=:setka_id";   
            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array('setka_id' => $args['setka_id'])); 
            $sites = $stm->fetchAll(\PDO::FETCH_COLUMN);
        }
        
        if ($args['site_id'])
            $sites = array($args['site_id']);
            
        if (!$sites) return false;
        
        $sites_id_str = implode(',', $sites);
              
        $tables = array();
        $services = array('defect','service','complect');
        $suffics_array = array('p','n','f');
        
        foreach ($suffics_array as $suffics)
        {
            foreach ($services as $service)
            {
                $tables[] = $suffics.'_'.$service.'_vals';
                $tables[] = $suffics.'_'.$service.'_model_vals';
            }
        }
        
        foreach ($tables as $table)
        {
            $sql = "DELETE FROM `{$table}` WHERE `site_id` IN(".$sites_id_str.")";          
                
            pdo::getPdo()->query($sql);
        }        
        
        $sql = "SELECT `m_model_to_sites`.`id` as `id`, 
                       `m_model_to_sites`.`m_model_id` as `m_model_id`, 
                       `m_model_to_sites`.`site_id` as `site_id`,
                       `model_types`.`id` as `type_id`, 
                       `markas`.`id` as `marka_id` 
                FROM `m_model_to_sites`
                INNER JOIN `m_models` ON `m_model_to_sites`.`m_model_id` = `m_models`.`id` 
                INNER JOIN `model_types` ON `model_types`.`id` = `m_models`.`model_type_id`
                INNER JOIN `markas` ON `markas`.`id` = `m_models`.`marka_id`
                WHERE `site_id` IN(".$sites_id_str.")";
                            
        $data = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        
        $no_pass = array();
        $datas = array();
        
        foreach ($data as $value)
        {
            $no_pass[$value['site_id']][$value['marka_id']][$value['type_id']] = $value;
            $datas[$value['id']] = $value;
        }
        
        foreach ($no_pass as $v1)
        {
            foreach ($v1 as $v2)
            {
                foreach ($v2 as $value)
                {
                    $m_model_to_sites = new gen_m_model($value['m_model_id'], $value['site_id']);
                    $m_model_to_sites->setPass(false);
                    $m_model_to_sites->genContent();
                    unset($datas[$value['id']]);
                }
            }   
        }
        
        foreach ($datas as $args)
        {
            $m_model_to_sites = new gen_m_model($args['m_model_id'], $args['site_id']);
            $m_model_to_sites->genContent();                                
        }
        
        $sql = "SELECT * FROM `model_to_sites` WHERE `site_id` IN(".$sites_id_str.")";
        $datas = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        
        foreach ($datas as $args)
        {
            $model_to_sites = new gen_model($args['model_id'], $args['site_id']);
            $model_to_sites->genContent();
        }
        
        return false;
    }
}

?>