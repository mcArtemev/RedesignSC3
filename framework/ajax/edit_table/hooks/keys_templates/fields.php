<?

namespace framework\ajax\edit_table\hooks\keys_templates;

use framework\pdo;

class fields extends template
{
    public function getSelect()
    {
        $values = array();
        $sql = "SELECT `tables`.`name` AS `group_name`, 
                `fields`.`name` AS `name`, `fields`.`id` AS `id`,
                    ISNULL(`clasters`.`sort`) AS `clasters_null`, ISNULL(`tables`.`sort`) AS `tables_null`, 
                        ISNULL(`fields`.`sort`) AS `fields_null`
                    FROM `fields` INNER JOIN `tables` ON `tables`.`id` = `fields`.`table_id`
                        INNER JOIN `clasters` ON `clasters`.`id` = `tables`.`claster_id`
                        ORDER BY `clasters_null` ASC, `clasters`.`sort` ASC, `clasters`.`id` ASC,
                           `tables_null` ASC, `tables`.`sort` ASC, `tables`.`id` ASC,
                                `fields_null` ASC, `fields`.`sort` ASC, `fields`.`id` ASC";
                    
        $data = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        
        foreach ($data as $value)
            $values[$value['group_name']][$value['id']] = $value['name'];  
            
        return $values;
    }
}

?>