<?

namespace framework\ajax\edit_table\hooks\keys_templates;

use framework\pdo;

class actions extends template
{
    public function getSelect()
    {
        $values = array();
        $sql = "SELECT `name`, `id`, ISNULL(`sort`) FROM `actions` ORDER BY ISNULL(`sort`) ASC, `sort` ASC, `id` ASC";
                    
        $data = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        
        foreach ($data as $value)
            $values[$value['id']] = $value['name'];  
            
        return $values;
    }
}

?>