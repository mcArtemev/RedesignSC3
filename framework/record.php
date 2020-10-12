<?

namespace framework;

class record
{
    private $_alias = array();
    private $_t = 1;    
    
    private $_table = '';
    private $_describe = false;
    private $_page = 1;
    
    public function __construct($table, $describe = false)
    {
        $this->setTable($table);
        $this->setDescribe($describe);
    }
    
    public function setTable($table)
    {
        if ($table) $this->_table = (string) $table;
    }
    
    public function setDescribe($describe)
    {
         $this->_describe = (bool) $describe;
    }
    
    public function getAlias($key)
    {
        if (isset($this->_alias[$key])) return $this->_alias[$key];
        return false;
    }
    
    public function setPage($page)
    {
        if ($page) $this->_page = (int) $page;
    }
    
    public function getRecord()
    {
        $ret = array();
        
        if ($table = $this->_table)
        {
            $responce = $this->_recursion($table);
            if (!$this->_describe)
            {
                $value = implode(',',$responce[0]);
                $page = ($this->_page - 1) * 10;
                $query = "SELECT {$value} FROM `{$table}`".$responce[1]." LIMIT {$page},10";
                //$query = "SELECT {$value} FROM `{$table}`".$responce[1];
                $data = pdo::getPdo()->query($query)->fetchAll(\PDO::FETCH_ASSOC);
        
                $i = 0;
                foreach ($data as $value)
                {
                    foreach ($value as $key => $value1)
                    {
                        if (mb_strpos($key, mb_substr($table, 0, -1)) === 0)
                            $ret[$i][mb_substr($key, mb_strlen($table))] = $value1;
                        else
                            $ret[$i][mb_substr($key, 0, mb_strrpos($key, '_'))][mb_substr($key, mb_strrpos($key, '_')+1)] = $value1;
                    }
                    $i++;
                }
            }
            else
            {
               // print_r($responce);
                foreach ($responce as $key => $value1)
                {
                    if (mb_strpos($key, mb_substr($table, 0, -1)) === 0)
                        $ret[mb_substr($key, mb_strlen($table))] = $value1;
                    else
                        $ret[mb_substr($key, 0, mb_strrpos($key, '_'))][mb_substr($key, mb_strrpos($key, '_')+1)] = $value1;
                }                 
            }
        }
        
        return $ret; 
    }
    
    private function _recursion($name, $alias = 0)
    {
      $value = array();
      $inner = "";
      $describe = $this->_describe;
                  
      $fields = pdo::getPdo()->query("DESCRIBE {$name}")->fetchAll(\PDO::FETCH_ASSOC);
                
      foreach ($fields as $field)
      {
         $field = $field["Field"];
        
         $short = mb_strtolower(mb_substr($name, 0, -1).'_'.$field);
         if (!$describe)
         {
            $t_name = isset($this->_alias[$name]) ? $this->_alias[$name] : $t_name = $name;
            $value[] = "`{$t_name}`.`{$field}` as `".$short."`";
         }
         else
         {
            $value[$short] = ''; 
         }
         
         if (mb_strpos($field, '_id') !== false)
         {
             $name2 = mb_strtolower(mb_substr($field, 0, -3)).'s';
             if (!$describe)
             {
                 $t =  't'. (string) $this->_t;
                 $inner .= " LEFT JOIN `{$name2}` `{$t}` ON `{$t_name}`.`{$field}` = `{$t}`.`ID`";  
                 $this->_alias[$name2] = $t;
                 $this->_t++;
                 $responce = $this->_recursion($name2, $t);
                 $value = array_merge($value, $responce[0]);
                 $inner .= $responce[1];
            }
            else
            {
                $responce = $this->_recursion($name2);
                $value = array_merge($value, $responce);
            }
         }
       }
       
       if (!$describe)
            return array($value, $inner);
       else       
            return $value;
    }
}