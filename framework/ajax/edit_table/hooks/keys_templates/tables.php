<?

namespace framework\ajax\edit_table\hooks\keys_templates;

use framework\pdo;

class tables extends template
{
    public function getSelect()
    {
        $values = array();
        $sql = "SELECT `clasters`.`name` AS `group_name`, 
                `tables`.`name` AS `name`, `tables`.`id` AS `id`,
                    ISNULL(`clasters`.`sort`) AS `clasters_null`, ISNULL(`tables`.`sort`) AS `tables_null` 
                    FROM `tables` INNER JOIN `clasters` ON `clasters`.`id` = `tables`.`claster_id`
                        ORDER BY `clasters_null` ASC, `clasters`.`sort` ASC, `clasters`.`id` ASC,
                           `tables_null` ASC, `tables`.`sort` ASC, `tables`.`id` ASC";
                    
        $data = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        
        foreach ($data as $value)
            $values[$value['group_name']][$value['id']] = $value['name'];  
            
        return $values;
    }
}

?>