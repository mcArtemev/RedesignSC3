<?

namespace framework\ajax\color_table;

use framework\pdo;
use framework\record;
use framework\tools;
use framework\shape\form as form;
use framework\shape as shape;
use framework\ajax as ajax;

class color_table extends ajax\ajax
{
    public function __construct($args)
    {
        parent::__construct('color_table');
        
        $table = $args['table'];
        $page = $args['page'] = isset($args['page']) ? $args['page'] : 1;
        
        $this->getWrapper()->getAttributes()->addAttr('id', 'color-table-'.$table);
        $this->getWrapper()->getAttributes()->getClass()->addItems('wide');
        
        $sql = "SELECT `id`,`label` FROM `tables` WHERE `name`=:table";
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array('table' => $table));
        $table_mas = current($stm->fetchAll(\PDO::FETCH_ASSOC));                
       
        $main_table = new shape\main_table();
        $twocolors_table = new shape\twocolors_table();
        
        $main_table->setTitle(tools::mb_ucfirst($table_mas['label']));
        
        $sql = "SELECT `name`,`label` FROM `fields` WHERE `table_id`=:table_id";
        $stm = pdo::getPdo()->prepare($sql);       
        $stm->execute(array('table_id' => $table_mas['id']));       
        $labels = $stm->fetchAll(\PDO::FETCH_KEY_PAIR);
      
        $record = new record($table);
        $record->setPage($page);
        $data = $record->getRecord();
        
        $tbody = array();
        $thead = array();
        $i = 0;
        
        foreach ($data as $value)
        {
            foreach ($value as $key => $value1)
            {
                if (!is_array($value1) && $key !== 'id')
                {
                    if (mb_strpos($key, '_id') !== false)
                    {
                        $link = mb_substr($key, 0, -3);
                        if (isset($value[$link]['name'])) 
                            $value1 = $value[$link]['name'];
                    }
                    $tbody[$i][] = $value1;
                }
            }
            $i++;
        }
        
        $record->setDescribe(true);
        $data = $record->getRecord();
      //  print_r($data);
        
        foreach ($data as $key => $value)
        {
            if (!is_array($value) && $key !== 'id')
                $thead[] = isset($labels[$key]) ? mb_strtolower($labels[$key]) : 'поле'; 
        }
        
        $pagination = null;
        $sql = "SELECT COUNT(*) FROM {$table}";
        $all = pdo::getPdo()->query($sql)->fetchColumn();
            
        $pages = ceil($all/10);
        
        if ($pages > 1)
        {
            $pagination = new shape\pagination();
            $pagination->setPage($page);
            $pagination->setPages($pages);
        }
        
        $twocolors_table->setThead($thead);
        $twocolors_table->setTbody($tbody);
        $twocolors_table->setTfoot('Всего: '.$all);
        
        $hidden = new form\hidden();
        $hidden->setName('table');
        $hidden->setValue($table);
        
        $main_table->setInto((string) $twocolors_table . (string) $pagination . (string) $hidden);
        $this->getWrapper()->addChildren($main_table);   
    }
}