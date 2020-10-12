<?

namespace framework\ajax\edit_table\hooks\keys_templates;

use framework\pdo;

class one extends template
{
    private $_link_table = '';
    
    public function setLinkTable($table)
    {
        $this->_link_table = (string) $table;
    }
    
    public function getSelect()
    {
        $table = $this->_table;
        $link_table =  $this->_link_table;
        $link_field = mb_substr($link_table, 0, -1) .'_id';         
           
        $values = array();
        $sql = "SELECT `{$link_table}`.`name` AS `group_name`, 
                `{$table}`.`name` AS `name`, `{$table}`.`id` AS `id` 
                    FROM `$table` INNER JOIN `$link_table` ON `$link_table`.`id` = `{$table}`.`{$link_field}`";
                    
        $data = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        
        foreach ($data as $value)
            $values[$value['group_name']][$value['id']] = $value['name'];  
            
        return $values;
    }
}

?>