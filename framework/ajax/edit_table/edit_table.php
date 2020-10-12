<?

namespace framework\ajax\edit_table;

use framework\pdo;
use framework\tools;
use framework\shape as shape;
use framework\shape\form as form;
use framework\ajax as ajax;

class edit_table extends ajax\ajax
{
    public function __construct($args)
    {
        parent::__construct('edit_table');
                
        $table = $args['table'];
        $this->getWrapper()->getAttributes()->addAttr('id', 'edit-table-'.$table);
        
        $hook_obj = null;
           
        if (file_exists(__DIR__.'/hooks/'.$table.'.php'))
        {
           $hook = 'framework\\ajax\\edit_table\\hooks\\'.$table;
           $hook_obj = new $hook;  
        }
        
        /*$rel = array();
        if (method_exists($hook_obj, 'getRel'))
            $rel = (array) $hook_obj->getRel();            
        $this->getWrapper()->getRel()->setItems(array_merge(array('color-table-'.$table), $rel));*/         

        $args['id'] = isset($args['id']) ? (integer) $args['id'] : 0;
        $args['delete'] = isset($args['delete']) ? $args['delete'] : false;
        $args['on_submit'] = isset($args['on_submit']) ? (bool) $args['on_submit'] : false;
        
        $op_add = ($args['id'] == 0 || $args['delete'] !== false);
        
        $error_str = '';
        
        $sql = "SELECT `id`,`label` FROM `tables` WHERE `name`=:table";
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array('table' => $table));
        $table_mas = current($stm->fetchAll(\PDO::FETCH_ASSOC));                
       
        $main_table = new shape\main_table();
        $form = new form\form();
        
        $main_table->setTitle(tools::mb_ucfirst($table_mas['label']));

        $sql = "SELECT `name`, `label`, `type_id`, `null`, ISNULL(`sort`) FROM `fields` WHERE `table_id`=:table_id ORDER BY ISNULL(`sort`) ASC, `sort` ASC, `id` ASC";
        $stm = pdo::getPdo()->prepare($sql);       
        $stm->execute(array('table_id' => $table_mas['id']));       
        $data = $stm->fetchAll(\PDO::FETCH_ASSOC);
        
        $nulls = array();
        $types = array();
        foreach ($data as $value)
        {
            $nulls[$value['name']] = ((integer) $value['null'] == 1);
            $types[$value['name']] = $value['type_id'];
        }
        
        if ($args['on_submit'])
        {
            $sql_args = $args;
            unset($sql_args['delete'], $sql_args['on_submit'], $sql_args['table']);

            foreach ($sql_args as $key => $arg)
            {
                if ($types[$key] == 8) $sql_args[$key] = tools::cut_phone($arg);
                if ($types[$key] == 9 && $sql_args[$key] === '') $sql_args[$key] = tools::get_time();
                
                if (!$nulls[$key] && $sql_args[$key] === '') $sql_args[$key] = null;
            }
                
            $pass = true;
            
            if ($args['delete'] === false)
            {
                 if ($args['id'] === 0)
                 {
                      if (method_exists($hook_obj, 'beforeAdd'))
                        $pass = $hook_obj->beforeAdd($sql_args);
                                              
                      if ($pass)
                      {
                          try 
                          {
                            $sql = "INSERT INTO `{$table}` SET ".pdo::prepare($sql_args);
                            $stm = pdo::getPdo()->prepare($sql);  
                            $stm->execute($sql_args);
                          }
                          catch (\PDOException $e) 
                          {
                             $error_str = 'Ошибка при добавлении.';
                             $pass = false;
                          }
                      }
                      else
                        $error_str = 'Отмена добавления.';
                      
                      if ($pass)
                      {
                          $sql_args['last_id'] = pdo::getPdo()->lastInsertId();
                                              
                          $error_str = 'Добавлено.';
    
                          if (method_exists($hook_obj, 'afterAdd'))
                              if ($str = $hook_obj->afterAdd($sql_args))
                                $error_str = $str;
                       }
                 }
                 else
                 {
                     if (method_exists($hook_obj, 'beforeUpdate'))
                        $pass = $hook_obj->beforeUpdate($sql_args);
                                          
                     if ($pass)
                     {
                         try 
                         {
                            $sql = "UPDATE `{$table}` SET ".pdo::prepare($sql_args)." WHERE `id`=:id";
                            $stm = pdo::getPdo()->prepare($sql);
                            $stm->execute($sql_args);
                         }
                         catch (\PDOException $e) 
                         {
                             $error_str = 'Ошибка при обновлении.';
                             $pass = false;
                         }
                     }
                     else
                        $error_str = 'Отмена обновления.';
                         
                     if ($pass)
                     {
                         $error_str = 'Изменено.';
                         
                         if (method_exists($hook_obj, 'afterUpdate'))
                            if ($str = $hook_obj->afterUpdate($sql_args))
                                $error_str = $str;
                     }
                     
                 }                     
            }
            else
            {
               if ($args['id'])
               {
                    if (method_exists($hook_obj, 'beforeDelete'))
                        $pass = $hook_obj->beforeDelete($sql_args);
                        
                    if ($pass)
                    {
                        try 
                        {
                            $sql = "DELETE FROM `{$table}` WHERE `id`=:id";
                            $stm = pdo::getPdo()->prepare($sql);
                            $stm->execute(array('id' => $args['id']));
                        }
                        catch (\PDOException $e) 
                        {
                             $error_str = 'Ошибка при удалении.';
                             $pass = false;
                        }                        
                    }
                    else
                        $error_str = 'Отмена удаления.';
                    
                    if ($pass)
                    {   
                        $error_str = 'Удалено.';
                        
                        if (method_exists($hook_obj, 'afterDelete'))
                            if ($str = $hook_obj->afterDelete($sql_args))
                                $error_str = $str;
                    }
               }       
            }
        }
              
        $items = array();   
                   
        foreach ($data as $value)
        {
           $field = $value['name'];
           $type = (integer) $value['type_id'];
           $item = null;
           
           if ($field === 'id' && $type == 4)
           {
                $item = new form\select();
                $arr = hooks\keys_templates\template::initial($table)->getSelect();
                $item->setValues(array(0 => '-- добавить --') + $arr);    
           }
           else
           {
               if (mb_strpos($field, '_id') !== false && $type == 3)
               {
                    $link_table = mb_strtolower(mb_substr($field, 0, -3)) . 's';
                    $item = new form\select();  
                    $arr = hooks\keys_templates\template::initial($link_table)->getSelect();
                    $item->setValues(array(0 => '-- нет данных --') + $arr);
               }
               else
               {
                    switch ($type)
                    {
                        case 1:
                            $item = new form\input_box();
                        break;
                        case 2:
                            $item = new form\input_box('decimal');
                        break;
                        case 5:
                            $item = new form\checkbox();
                        break;
                        case 6:
                            $item = new form\pass_box();
                        break;
                        case 7:
                            $item = new form\textarea();
                        break;
                        case 8:
                            $item = new form\input_box('phone');
                        break;
                        case 9:
                            $item = new form\input_box('date');
                        break;
                    } 
               }
           }
           
           if ($item !== null)
           {
                $item->setName($field);
                if ((integer) $value['null'] == 1 && $field !== 'id') $item->setError('required');
                $items[$field] = $item;
                $label_nodes[$field] = $value['label'];
           }
       }   
        
       if (!$op_add) 
       {
            $delete = new form\checkbox();
            $delete->setName('delete');
            $items['delete'] = $delete;
       }
       
       if (method_exists($hook_obj, 'processItems'))
            $hook_obj->processItems($items, $args);
       
       $item_wrap = array();
       foreach ($items as $key => $item)
       {
           if ($key == 'delete')
             $label = 'Удалить';
           else
             $label = isset($label_nodes[$key]) ? $label_nodes[$key] : 'Поле';
             
           if ($item->getError() == 'required') $item->setError(mb_strtolower($label)); 
           $item_wrap[] = $this->_wrapItem($item, tools::mb_ucfirst($label));
       }    
       
       $hidden = new form\hidden();
       $hidden->setName('table');
       $hidden->setValue($table);
       $item_wrap[] = $hidden;   
      
       $form->setChildren($item_wrap);
       
       if (!$op_add) $form->fillValuesBase($args, $types); 
        
       $form->setSubmit('Сохранить');       
       $form->setMessage($error_str);
       
       $main_table->setInto($form);
       $this->getWrapper()->addChildren($main_table);   
    }
    
    private function _wrapItem($item, $label = '')
    {
        $form_block = new form\form_item('form-block');
        $form_block->setLabel($label);                              
        $form_block->addChildren($item);
        return $form_block;
    }
}

?>