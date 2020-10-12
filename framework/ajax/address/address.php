<?

namespace framework\ajax\address;

use framework\pdo;
use framework\ajax as ajax;

class address extends ajax\ajax {

    public function __construct($args)
    {
        parent::__construct('');
        
        $setka_name = isset($args['setka_name']) ? (string) $args['setka_name'] : '';
        $region_name = isset($args['region_name']) ? (string) $args['region_name'] : '';
        
        $result = '';
        
        if ($setka_name && $region_name)
        {
            if ($region_name != 'Москва')
            {
                $sql = "SELECT `partners`.`address1` FROM `sites` 
                                LEFT JOIN `partners` ON `sites`.`partner_id` = `partners`.`id`
                                LEFT JOIN `setkas` ON `sites`.`setka_id` = `setkas`.`id`
                                LEFT JOIN `regions` ON `sites`.`region_id` = `regions`.`id`
                            WHERE `setkas`.`name`=:setka_name AND `regions`.`name`=:region_name";
             
                $stm = pdo::getPdo()->prepare($sql);
                $stm->execute(array('setka_name' => $setka_name, 'region_name' => $region_name));
                $result = $stm->fetchColumn();
            }
            else
            {
                $sql = "SELECT `partners`.`address1` FROM `sites` 
                                LEFT JOIN `partners` ON `sites`.`partner_id` = `partners`.`id`
                                LEFT JOIN `setkas` ON `sites`.`setka_id` = `setkas`.`id`
                            WHERE `setkas`.`name`=:setka_name AND (`sites`.`region_id` IS NULL OR `sites`.`region_id` = 0)";
             
                $stm = pdo::getPdo()->prepare($sql);
                $stm->execute(array('setka_name' => $setka_name));
                $result = $stm->fetchColumn();
            }
        }
        
        $this->getWrapper()->addChildren($result);
    }
}

?>