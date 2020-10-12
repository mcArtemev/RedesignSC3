<?

namespace framework\ajax\edit_table\hooks;

use framework\pdo;

class fields
{
    private $_before_val;
    
    private function _before($id)
    {
        $sql = "SELECT `tables`.`name` AS `table`, `fields`.`name` AS `field` 
                FROM `fields` INNER JOIN `tables` ON `tables`.`id` = `fields`.`table_id` WHERE `fields`.`id`=:id";
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array('id' => $id));
        return current($stm->fetchAll(\PDO::FETCH_ASSOC));
    }
    
    public function beforeAdd(&$args)
    {
        if ($args['type_id'] == 6)
        {
            $args['null'] = 1;
        }
        else
        {
            if ($args['type_id'] == 5)
                $args['null'] = 0;
            else
                $args['null'] = isset($args['null']) ? $args['null'] : 0;
        }
        return true;
    }
    
    public function afterAdd($args)
    {
        $type = $args['type_id'];
        $name = $args['name'];
        $null = ($args['null'] == 1) ? 'NOT NULL' : 'NULL';
        
        $sql = "SELECT `name` FROM `tables` WHERE `id`=:id";
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array('id' => $args['table_id']));
        $table = $stm->fetchColumn();
        
        $sql = '';
        switch ($type)
        {
            case 1:
                $sql = "ALTER TABLE `{$table}` ADD `{$name}` varchar(255) ".$null;
            break;
            case 2:
                $sql = "ALTER TABLE `{$table}` ADD `{$name}` int(11) ".$null;
            break;
            case 3:
                $sql = "ALTER TABLE `{$table}` ADD `{$name}` int(11) ".$null.", ADD INDEX (`{$name}`)";
            break;
            case 4:
                
            break;
            case 5:
                $sql = "ALTER TABLE `{$table}` ADD `{$name}` tinyint(1) NULL";
            break;
            case 6:
                $sql = "ALTER TABLE `{$table}` ADD `{$name}` varchar(255) NOT NULL";
            break;
            case 7:
                $sql = "ALTER TABLE `{$table}` ADD `{$name}` text ".$null;
            break;
            case 8:
                $sql = "ALTER TABLE `{$table}` ADD `{$name}` varchar(255) ".$null;
            break;
            case 9:
                $sql = "ALTER TABLE `{$table}` ADD `{$name}` int(11) ".$null;
            break;
        }
        
        if ($sql) pdo::getPdo()->query($sql);   
    }   
    
    public function beforeUpdate(&$args)
    {
        if ($args['type_id'] == 6)
        {
            $args['null'] = 1;
        }
        else
        {
            if ($args['type_id'] == 5)
                $args['null'] = 0;
            else
                $args['null'] = isset($args['null']) ? $args['null'] : 0;
        }
        $this->_before_val = $this->_before($args['id']); 
        return true;   
    }
    
    public function afterUpdate($args)
    {
        $before = $this->_before_val;
        $table = $before['table'];
        $field = $before['field'];
        
        $type = $args['type_id'];
        $name = $args['name'];
        $null = ($args['null'] == 1) ? 'NOT NULL' : 'NULL';
        
        $sql = '';
        switch ($type)
        {
            case 1:
                $sql = "ALTER TABLE `{$table}` CHANGE `{$field}` `{$name}` varchar(255) ".$null;
            break;
            case 2:
                $sql = "ALTER TABLE `{$table}` CHANGE `{$field}` `{$name}` int(11) ".$null;
            break;
            case 3:
                $sql = "ALTER TABLE `{$table}` CHANGE `{$field}` `{$name}` int(11) ".$null.", DROP INDEX `{$field}`, ADD INDEX (`{$name}`)";
            break;
            case 4:
                
            break;
            case 5:
                $sql = "ALTER TABLE `{$table}` CHANGE `{$field}` `{$name}` tinyint(1) NULL";
            break;
            case 6:
                $sql = "ALTER TABLE `{$table}` CHANGE `{$field}` `{$name}` varchar(255) NOT NULL";
            break;
            case 7:
                $sql = "ALTER TABLE `{$table}` CHANGE `{$field}` `{$name}` text ".$null;
            break;
            case 8:
                $sql = "ALTER TABLE `{$table}` CHANGE `{$field}` `{$name}` varchar(255) ".$null;
            break;
            case 9:
                $sql = "ALTER TABLE `{$table}` CHANGE `{$field}` `{$name}` int(11) ".$null;
            break;
        }
        
        if ($sql) pdo::getPdo()->query($sql);
    }    
     
    public function beforeDelete(&$args)
    {
        $this->_before_val = $this->_before($args['id']);  
        return true;
    }
    
    public function afterDelete($args)
    {
        $before = $this->_before_val;   
        $table = $before['table'];
        $field = $before['field'];
         
        $sql = "ALTER TABLE `{$table}` DROP `{$field}`";
        pdo::getPdo()->query($sql);      
    } 
    
    public function processItems(&$items, $args)
    {
        $before = $this->_before($args['id']);
        $field = $before['field'];
        $table = $before['table'];
        
        if ($field == 'id' || $table == 'fields' || $table == 'tables' || $table == 'clasters' || $before == 'users')
        {
            unset($items['delete']);
            foreach ($items as $key => $item)
                if ($key != 'label' && $key != 'id'  && $key != 'sort') $items[$key]->setReadonly(true);
        }
        else
        {
            $items['type_id']->delValues(4);
            $items['table_id']->setReadonly(true);
        }       
    }   
}