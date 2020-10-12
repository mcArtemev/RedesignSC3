<?

namespace framework\ajax\edit_table\hooks\keys_templates;

use framework\pdo;

class sites extends template
{
    public function getSelect()
    {
        $values = array();
        $sql = "SELECT `name`, `id` FROM `sites` WHERE `setka_id` = 7 AND `region_id` = 6 ORDER BY `name` ASC";
                    
        $data = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        
        foreach ($data as $value)
            $values[$value['id']] = $value['name'];  
            
        return $values;
    }
}

?>