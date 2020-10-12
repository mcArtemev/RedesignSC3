<?

namespace framework\ajax\edit_table\hooks\keys_templates;

use framework\pdo;

class id extends template
{
    public function getSelect()
    {
        $table = $this->_table;
        
        $values = array();
        
        $sql = "SELECT `id` FROM `{$table}`";
        $data = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
                         
        foreach ($data as $value)
            $values[$value['id']] = $value['id'];
            
        return $values;
    }
}

?>