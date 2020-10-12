<?

namespace framework\ajax\action\hooks;

use framework\pdo;
use framework\tools;
use framework\ajax\edit_table\hooks\m_models;
use framework\ajax\edit_table\hooks\models;

class fill
{
    public function doAction()
    {
        $file = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/models.csv');
        
        $sql = "SELECT `name`,`id` FROM `markas`";
        $markas_db = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_KEY_PAIR);
        
        $sql = "SELECT `name`,`id` FROM `model_types`";
        $model_types_db = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_KEY_PAIR); 
        
        $sql = "SELECT `name`,`id` FROM `models`";
        $models_db = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_KEY_PAIR);
        
        $rows = explode("\n",$file);
        
        $row_count = 0;
        $success_count = 0;
        
        foreach ($rows as $row)
        {
            $row = trim($row);

            if ($row)
            {
                $cols = explode(';',$row);
                
                if (isset($markas_db[$cols[0]]) && isset($model_types_db[$cols[1]]) 
                            && !isset($models_db[$cols[5]]) && count($cols) >= 14)
                {
                    
                    $marka_id = $markas_db[tools::cut_empty($cols[0])];
                    $model_type_id = $model_types_db[tools::cut_empty($cols[1])];
                    $m_model_name = tools::cut_empty($cols[2]);                    
                   
                    $sql = "SELECT `id` FROM `m_models`                            
                                WHERE `marka_id` = ? AND `model_type_id` = ? AND `name` = ?";
                            
                    $stm = pdo::getPdo()->prepare($sql);
                    $stm->execute(array($marka_id, $model_type_id, $m_model_name)); 
                    $m_model_id = $stm->fetchColumn();                  
                    
                    if (!$m_model_id)
                    {
                        $args = array('marka_id' => $marka_id, 'model_type_id' => $model_type_id, 'name' => $m_model_name, 'ru_name' => tools::cut_empty($cols[3]),
                                'brand' => (integer) tools::cut_empty($cols[4]));                       
                       try
                        {
                            $sql = "INSERT INTO `m_models` SET ".pdo::prepare($args);
                            $stm = pdo::getPdo()->prepare($sql);  
                           
                            $stm->execute($args);                      
                            
                            $m_model_id = $args['last_id'] = pdo::getPdo()->lastInsertId();
                            $obj = new m_models();                        
                            $obj->afterAdd($args);
                       }
                       catch (\PDOException $e) 
                       {
                           continue;
                       }
                    }                    
                    
                    $args = array('name' => tools::cut_empty($cols[5]), 'ru_name' => tools::cut_empty($cols[6]), 'm_model_id' => $m_model_id, 'submodel' => tools::cut_empty($cols[7]), 
                        'lineyka' => tools::cut_empty($cols[8]), 'sublineyka' => tools::cut_empty($cols[9]), 'ru_submodel' => tools::cut_empty($cols[10]), 'ru_lineyka' => tools::cut_empty($cols[11]), 
                            'ru_sublineyka' => tools::cut_empty($cols[12]), 'ru_submodel_syn' => tools::cut_empty($cols[13]));
                    
                    try
                    {
                        $sql = "INSERT INTO `models` SET ".pdo::prepare($args);                    
                        $stm = pdo::getPdo()->prepare($sql);  
                        
                        $stm->execute($args);
                        
                        $model_id = $args['last_id'] = pdo::getPdo()->lastInsertId();
                        $obj = new models();                        
                        $obj->afterAdd($args);
                        $success_count++;
                    }
                    catch (\PDOException $e) 
                    {
                        continue;
                    }
                }
                else
                {
                     continue;   
                } 
                
                $row_count++;
                
            }
        }
        
        return "Завершено. {$success_count} из {$row_count}";         
    }
}

?>