<?

namespace framework\ajax\edit_table\hooks;

use framework\gen\gen_model;

class models
{
    public function afterAdd($args)
    {
        $gen = new gen_model($args['last_id']);
        
        $gen->genScope();
        $gen->genSyns();
        $gen->genUrls();
        $gen->genContent();
    }
    
    public function beforeDelete(&$args)
    {
        $gen = new gen_model($args['id']);
        
        $gen->delContent();
        $gen->delUrls();
        $gen->delSyns();   
        $gen->delScope();
        
        return true;
    }
}

?>