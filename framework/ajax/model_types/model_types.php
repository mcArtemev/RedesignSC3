<?

namespace framework\ajax\model_types;

use framework\pdo;
use framework\ajax as ajax;

class model_types extends ajax\ajax {

    public function __construct($args)
    {
        parent::__construct(''); 
        
        $site_name = isset($args['site_name']) ? (string) $args['site_name'] : '';
        $result = array();
         
        $sql = "SELECT `sites`.`id` as `site_id`, `setkas`.`name` as `setka_name` 
                    FROM `sites` LEFT JOIN `setkas` ON `sites`.`setka_id` = `setkas`.`id` WHERE `sites`.`name`=:name";   
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array('name' => $site_name)); 
        $site_array = $stm->fetchAll(\PDO::FETCH_ASSOC);
        
        if ($site_array)
        {
            $site_array = current($site_array);
            
            $setka_name = $site_array['setka_name'];
            $site_id = $site_array['site_id'];
            
            $allow = array('СЦ-1', 'СЦ-5', 'СЦ-6', 'СЦ-7');
            
            if (in_array($setka_name, $allow))
            {
                if ($setka_name != 'СЦ-6')
                {
                     if ($setka_name == 'СЦ-7')
                     {
                        $sql = "SELECT
                                `model_types`.`name` as `type`, 
                                `model_types`.`name_re` as `type_re`,
                                `model_types`.`name_rm` as `type_rm`,
                                `model_types`.`name_m` as `type_m`, 
                                `model_types`.`name_de` as `type_de`, 
                                `model_types`.`name_dm` as `type_dm`
                                
                                        FROM `model_type_to_markas`
                                INNER JOIN `marka_to_sites` ON `marka_to_sites`.`marka_id` = `model_type_to_markas`.`marka_id`
                                INNER JOIN `model_types` ON `model_types`.`id` = `model_type_to_markas`.`model_type_id`
                            WHERE `marka_to_sites`.`site_id`=?";
                     }
                     else
                     {
                         $sql =  "SELECT 
                                `model_types`.`name` as `type`,
                                `model_types`.`name_re` as `type_re`,
                                `model_types`.`name_rm` as `type_rm`,
                                `model_types`.`name_m` as `type_m`, 
                                `model_types`.`name_de` as `type_de`, 
                                `model_types`.`name_dm` as `type_dm` 
                                
                                    FROM `m_model_to_sites`
                                INNER JOIN `m_models` ON `m_models`.`id` = `m_model_to_sites`.`m_model_id`
                                INNER JOIN `model_types` ON `m_models`.`model_type_id` = `model_types`.`id` 
                            WHERE `m_model_to_sites`.`site_id`= ? GROUP BY `model_types`.`name`";
                    }       
                }
                else
                {
                    $sql =  "SELECT 
                                `model_types`.`name` as `type`,
                                `model_types`.`name_re` as `type_re`,
                                `model_types`.`name_rm` as `type_rm`,
                                `model_types`.`name_m` as `type_m`, 
                                `model_types`.`name_de` as `type_de`, 
                                `model_types`.`name_dm` as `type_dm` 
                            
                                FROM `marka_to_sites`
                            LEFT JOIN `model_type_to_markas` ON `marka_to_sites`.`marka_id`= `model_type_to_markas`.`marka_id`
                            INNER JOIN `model_types` ON `model_type_to_markas`.`model_type_id` = `model_types`.`id`
                         WHERE `marka_to_sites`.`site_id`= ? GROUP BY `model_types`.`name`";
                }                
                
                $stm = pdo::getPdo()->prepare($sql);
                $stm->execute(array($site_id));
                $result = $stm->fetchAll(\PDO::FETCH_ASSOC);
            }
        }
        
        $this->getWrapper()->addChildren(json_encode($result));
    }
}

?>