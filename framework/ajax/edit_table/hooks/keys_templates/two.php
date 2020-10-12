<?

namespace framework\ajax\edit_table\hooks\keys_templates;

use framework\pdo;

class two extends template
{
    private $_table1 = '';
    private $_table2 = '';
    
    public function setTable1($table)
    {
        $this->_table1 = (string) $table;
    }
    
    public function setTable2($table)
    {
        $this->_table2 = (string) $table;
    }
    
    public function getSelect()
    {
        $table = $this->_table;
        $link_table1 = $this->_table1;
        $link_table2 = $this->_table2;
        
        $link_field1 = mb_substr($link_table1, 0, -1) .'_id';         
        $link_field2 = mb_substr($link_table2, 0, -1) .'_id';
          
        $values = array();
        $sql = "SELECT `{$link_table1}`.`name` AS `group_name`, 
                `{$link_table2}`.`name` AS `name`, `{$table}`.`id` AS `id` 
                    FROM `$table` INNER JOIN `$link_table1` ON `$link_table1`.`id` = `{$table}`.`{$link_field1}`
                        INNER JOIN `$link_table2` ON `$link_table2`.`id` = `{$table}`.`{$link_field2}`";
                    
        $data = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        
        foreach ($data as $value)
            $values[$value['group_name']][$value['id']] = $value['name'];  
            
        return $values;
    }
}

?>