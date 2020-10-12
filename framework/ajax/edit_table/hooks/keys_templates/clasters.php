<?

namespace framework\ajax\edit_table\hooks\keys_templates;

use framework\pdo;

class clasters extends template
{
    public function getSelect()
    {
        $values = array();

        $sql = "SELECT `id`, `name`, ISNULL(`sort`) FROM `clasters` ORDER BY ISNULL(`sort`) ASC, `sort` ASC, `id` ASC";
        $data = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
                         
        foreach ($data as $value)
            $values[$value['id']] = $value['name'];
            
        return $values;
    }
}

?>