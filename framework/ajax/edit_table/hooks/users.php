<?

namespace framework\ajax\edit_table\hooks;

use framework\pdo;

class users {
    
    public function beforeAdd(&$args)
    {
        $args['pass'] = base64_encode('grid' . $args['pass']);
        return true;
    }
    
    public function beforeUpdate(&$args)
    {
        $args['pass'] = base64_encode('grid' . $args['pass']);
        return true;
    }
    
    public function processItems(&$items, $args)
    {
        $items['pass']->setValue('');
        if ($args['id'] == 1)
        {
            unset($items['delete']);
            $items['name']->setReadonly(true);
        }
    }
}

?>