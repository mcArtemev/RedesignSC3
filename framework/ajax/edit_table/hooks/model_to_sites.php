<?

namespace framework\ajax\edit_table\hooks;

use framework\gen\gen_model;
use framework\pdo;

class model_to_sites
{
    private function _before($id)
    {
        $sql = "SELECT `site_id`, `model_id` FROM `model_to_sites` WHERE `id`=:id";
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array('id' => $id));
        return current($stm->fetchAll(\PDO::FETCH_ASSOC));
    }
    
    public function afterAdd($args)
    {
        $gen = new gen_model($args['model_id'], $args['site_id']);
        
        $gen->genSyns();
        $gen->genUrls();
        $gen->genContent();
    }
    
    public function beforeDelete(&$args)
    {
        $before = $this->_before($args['id']);
        $gen = new gen_model($before['m_model_id'], $before['site_id']);
        
        $gen->delContent();
        $gen->delUrls();
        $gen->delSyns(); 
        
        return true;
    }
}

?>