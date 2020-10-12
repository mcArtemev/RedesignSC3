<?

namespace framework\ajax\edit_table\hooks;

use framework\pdo;

class partners {
    
    public function beforeUpdate(&$args)
    {
        $args['exclude'] = isset($args['exclude']) ? $args['exclude'] : 0;
        return true;
    }
}

?>