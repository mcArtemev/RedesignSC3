<?

namespace framework\ajax\edit_table\hooks\keys_templates;

use framework\pdo;

abstract class template 
{
    protected $_table = '';
    
    private static function _hasField($field, $table)
    {
        $has = false;
        
        $sql = "DESCRIBE `{$table}`";
        $data = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($data as $value)
        {
            if ($value['Field'] == $field)
            {
                $has = true;
                break;
            }
        }
        
        return $has;
    }
    
    private static function _hasName($table)
    {
        return self::_hasField('name', $table);
    }
    
    public function __construct($table)
    {
        $this->_table = $table;
    }
    
    public static function initial($table)
    {
        $class = '';
        
        if (file_exists(__DIR__.'/'.$table.'.php'))
           $class = $table;
           
        if (!$class)
        {
            switch ($table)
            {
                case 'sites':
                    $link_table = 'setkas';
                    $class = 'one';
                break;
                case 'm_models':
                    $link_table = 'markas';
                    $class = 'one';
                break;
                case 'urls':
                    $link_table = 'sites';
                    $class = 'one';
                break;
                case 'customs':
                    $link_table = 'setkas';
                    $class = 'one';
                break;
                case 'dop_urls':
                    $link_table = 'sites';
                    $class = 'one';
                break;
                case 'marka_to_sites':
                    $table1 = 'sites';
                    $table2 = 'markas';
                    $class = 'two';
                break;
                case 'm_model_to_sites':
                    $table1 = 'sites';
                    $table2 = 'm_models';
                    $class = 'two';
                break;
                case 'model_to_sites':
                    $table1 = 'sites';
                    $table2 = 'models';
                    $class = 'two';
                break;
                case 'dop_group_to_setkas':
                    $table1 = 'setkas';
                    $table2 = 'dop_groups';
                    $class = 'two';
                break;
                case 'imgs':
                    $table1 = 'sites';
                    $table2 = 'model_types';
                    $class = 'two';
                break;
                case 'model_type_to_markas':  case 'model_type_to_markas_8':
                    $table1 = 'markas';
                    $table2 = 'model_types';
                    $class = 'two';
                break;
                case '6_defects': case '6_services':
                    $link_table = 'model_types';
                    $class = 'one';
                break;
                //case 'level_imgs':
                    //$link_table = 'sites';
                    //$class = 'one';
                //break;
            }
        }
        
        if (!$class && mb_strpos($table, '_to_') !== false && (mb_strpos($table, 'p_') === 0 || mb_strpos($table, 'n_') === 0 || mb_strpos($table, 'f_') === 0) 
                && mb_strpos($table, 'models') === false)
        {
            $prefics = $table[0];
            
            if (mb_strpos($table, 'setkas') !== false)
            {
                $table1 = mb_substr($table, mb_strrpos($table, '_')+1);
                $table2 = mb_substr($table, 2, mb_strpos($table, '_to')-2).'s';
            }
            else
            {
                $table1 = $prefics.'_'.mb_substr($table, mb_strrpos($table, '_')+1);
                $table2 = mb_substr($table, 0, mb_strpos($table, '_to')).'s';
            }
            
            $link_field1 = mb_substr($table1, 0, -1) .'_id';         
            $link_field2 = mb_substr($table2, 0, -1) .'_id';
            
            if (self::_hasName($table1) && self::_hasName($table2) && self::_hasField($link_field1, $table) && self::_hasField($link_field2, $table))
                $class = 'two';
        }
        
        if (!$class && mb_strpos($table, '_service_cost') !== false)
        {
            $prefics = $table[0];
            
            $table1 = 'setkas';
            $table2 = $prefics.'_services';
            
            $class = 'two';
        }            
        
        if (!$class && (mb_strpos($table, '_syns') !== false || mb_strpos($table, '_reasons') !== false) && mb_strpos($table, '_context_') === false)
        {
            $link_table = mb_substr($table, 0, mb_strrpos($table, '_')).'s';
            $link_field = mb_substr($link_table, 0, -1) .'_id';   
            
            if (self::_hasName($table) && self::_hasName($link_table) && self::_hasField($link_field, $table))
                $class = 'one';
        }
        
        if (!$class && mb_strpos($table, '_context_') !== false)
        {
            $link_table = mb_substr($table, 0, mb_strrpos($table, '_context_')).'s';
            $link_field = mb_substr($link_table, 0, -1) .'_id';   
            
            if (self::_hasName($table) && self::_hasName($link_table) && self::_hasField($link_field, $table))
                $class = 'one';
        }
        
        if (!$class && self::_hasName($table)) $class = 'name';        
         
        if (!$class) $class = 'id';
        
        $class_str = 'framework\\ajax\\edit_table\\hooks\\keys_templates\\'.$class;
           
        $obj = new $class_str($table);
        
        if ($class == 'two')
        {
            $obj->setTable1($table1);
            $obj->setTable2($table2);
        }
        
        if ($class == 'one')
        {
            $obj->setLinkTable($link_table);
        }
            
        return $obj;
    }
    
    abstract public function getSelect();        
}

?>