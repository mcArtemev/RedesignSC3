<?

namespace framework\ajax\action\hooks;

use framework\pdo;
use framework\tools;
use framework\ajax\edit_table\hooks\gen_level;
use framework\ajax\edit_table\hooks\fill_new;

class fill_sites
{
    public function doAction()
    {
        $file = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/sites.csv');
        $rows = explode("\n",$file);
        
        //$rows = array($rows[1]);
        
        if (!$rows) return "Нет файла.";
        
        $sql = "SELECT `id` FROM `setkas`";
        $setka_db = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN);
        
        $sql = "SELECT `id` FROM `regions`";
        $region_db = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN);
        
        $sql = "SELECT `id` FROM `partners`";
        $partner_db = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN);  
        
        $sql = "SELECT `id` FROM `markas`";
        $marka_db = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN);  
        
        //$sql = "SELECT `id`,`name` FROM `markas`";
        //$markas = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_KEY_PAIR);   
        
        $insert = array();   
        $i = 0; 
        
        foreach ($rows as $row)
        {
            if ($row)
            {
              
               $row = explode(';', $row);
               
               if (!$this->_to_integer($row, 2, $setka_db) || !$this->_to_integer($row, 4, $partner_db)) // || !$this->_to_integer($row, 8, $marka_db))
                {                                                    
                    echo 'error1'.PHP_EOL;
                    continue;
                }
				
			  if (empty($row[6]))
					$row[6] = 0;
              
              if ($row[3] != '' && !$this->_to_integer($row, 3, $region_db))
              {
                    echo 'error2'.PHP_EOL;
                    continue;
              } 
               
              try
              {   
                    $args = array(
                                'name' => tools::cut_empty($row[0]), 
                                'servicename' =>  tools::cut_empty($row[1]), 
                                'setka_id' => $row[2],  
                                'region_id' => ($row[3]) ? $row[3] : null,
                                
                                /*'phone' => tools::cut_phone($row[4]),
                                'phone_yd' => tools::cut_phone($row[5]),  
                                'phone_ga' => tools::cut_phone($row[6]),*/
                                'phone' => '78002005089',
                                'partner_id' => $row[4],
                                   
                                'metrica' => tools::cut_empty($row[5]),                                 
                                'ru_servicename' => tools::cut_empty($row[7]),
                         ); 
                    
                    
                    $sql = "INSERT INTO `sites` SET ".pdo::prepare($args);
                    $stm = pdo::getPdo()->prepare($sql);                    
                    $stm->execute($args);
                    
                    $site_id = pdo::getPdo()->lastInsertId();  
                   
                    $args2 = array('marka_id' => $row[6], 'site_id' => $site_id);      
                    
                    $sql = "INSERT INTO `marka_to_sites` SET ".pdo::prepare($args2);
                    $stm = pdo::getPdo()->prepare($sql);                            
                    $stm->execute($args2); 
                    
                    $pid = $i % 20;
                    $insert[] = "({$site_id},{$pid})";
                    
                    $i++;                          
                 
               }
               catch (\PDOException $e) 
               {
                 continue;
               }
            }
              
        }
        
        if ($insert)
        {
            $sql = "INSERT IGNORE INTO `batch_site_id` (`site_id`,`pid`) VALUES ".implode(',', $insert);
            pdo::getPdo()->query($sql);
        }
        
        return "Завершено.";         
    }
    
    private function _to_integer(&$row, $index, $mas)
    {
         $row[$index] = (integer) $row[$index];
         return in_array($row[$index], $mas);
    }
}

?>