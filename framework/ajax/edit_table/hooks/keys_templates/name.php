<?

namespace framework\ajax\edit_table\hooks\keys_templates;

use framework\pdo;

class name extends template
{
    public function getSelect()
    {
        $table = $this->_table;
        
        $values = array();

        $sql = "SELECT `id`, `name` FROM `{$table}` ORDER BY `name` ASC";
        $data = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
                         
        foreach ($data as $value)
            $values[$value['id']] = $value['name'];
            
        return $values;
    }
}

?>