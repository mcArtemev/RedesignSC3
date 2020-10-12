<?

namespace framework\ajax\edit_table\hooks;

use framework\pdo;
use framework\shape\form as form;

class sites
{
    public function processItems(&$items, $args)
    {
        $sql = "SELECT `id`, `name` FROM `partners`";
        $data = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        $t = array();
        foreach ($data as $key => $value)
            $t[$value['id']] = $value['name'];  
             
        $key = array(0 => '-- нет данных --') + $t;
                 
        $select1 = new form\select();            
        $select1->setName('partner_yd');
        $select1->setValues($key);
        $items['partner_yd'] = $select1;        
        
        $select2 = new form\select();            
        $select2->setName('partner_ga');
        $select2->setValues($key);
        $items['partner_ga'] = $select2;   
    }
}
