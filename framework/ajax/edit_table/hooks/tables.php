<?

namespace framework\ajax\edit_table\hooks;

use framework\pdo;

class tables
{
    private $_before_val;
    
    private function _before($id)
    {
        $sql = "SELECT `name` FROM `tables` WHERE `id`=:id";
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array('id' => $id));
        return $stm->fetchColumn();
    }
    
    public function afterAdd($args)
    {
        $table = $args['name'];
        $sql = "CREATE TABLE IF NOT EXISTS `{$table}` 
                (`id` int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (`id`)) 
                        ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
        pdo::getPdo()->query($sql);      

        $sql_args = array('label' => $args['label'], 'table_id' => $args['last_id'], 'name' => 'id', 'type_id' => 4, 'null' => true);
        $sql = "INSERT INTO `fields` SET ".pdo::prepare($sql_args);
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute($sql_args);             
    }
    
    public function beforeUpdate(&$args)
    {
        $this->_before_val = $this->_before($args['id']);  
        return true;
    } 
    
    public function afterUpdate($args)
    {
        $name = $args['name'];
        $before = $this->_before_val;         
        if ($before !== $name)
        {
            $sql = "RENAME TABLE `{$before}` TO `{$name}`";
            pdo::getPdo()->query($sql);
        }  
    }
    
    public function beforeDelete(&$args)
    {
        $this->_before_val = $this->_before($args['id']);  
        return true;
    }
    
    public function afterDelete($args)
    {
        $before = $this->_before_val;   
        $sql = "DROP TABLE IF EXISTS `{$before}`";
        pdo::getPdo()->query($sql);
        
        $sql = "DELETE FROM `fields` WHERE `table_id`=:id" ;
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array('id' => $args['id']));               
    }
    
    public function processItems(&$items, $args)
    {
        $before = $this->_before($args['id']);     
     
        if ($before == 'fields' || $before == 'tables' || $before == 'clasters' || $before == 'users')
        {
            unset($items['delete']);
            $items['name']->setReadonly(true);    
        }               
    }   
}

?>