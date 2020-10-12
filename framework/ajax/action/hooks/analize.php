<?

namespace framework\ajax\action\hooks;

use framework\pdo;

class analize
{
    public function doAction()
    {
        $file = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/models.csv');
                
        $rows = explode("\n",$file);
        
        $row_count = 0;
        $success_count = 0;
        $ret_str = array();
        
        $sql = "SELECT `name` FROM `markas`";
        $markas = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN); 
        
        $sql = "SELECT `name` FROM `model_types`";
        $model_types = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN);
        
        foreach ($rows as $row)
        {
            $row = trim($row);
            $pass = true;
            $row_count++;
               
            if ($row)
            {
                $cols = explode(';',$row);
                                
                if (count($cols) >= 14)
                {                    
                    if (!in_array($cols[0], $markas))
                    { 
                        $pass = false;
                        $ret_str[] = 'Строка '.($row_count).', колонка 1, неверное значение';
                    }
                    
                    if (!in_array($cols[1], $model_types))
                    { 
                        $pass = false;
                        $ret_str[] = 'Строка '.($row_count).', колонка 2, неверное значение';
                    }
                    
                    $cols[4] =(integer) $cols[4];
                    
                    if ($cols[4] != 0 && $cols[4] != 1)
                    { 
                        $pass = false;
                        $ret_str[] = 'Строка '.($row_count).', колонка 5, неверное значение';
                    }
                    
                    foreach (array(2, 5, 7, 8, 9) as $value)
                    {
                        $str = mb_strtolower($cols[$value]);
                         
                        if (preg_match('/[а-я]+/', $str))
                        {   
                           $pass = false;
                           $ret_str[] = 'Строка '.($row_count).', колонка '.($value + 1).', недопустимый символ';
                        }
                    }
                    
                    //if ($cols[1] == 'ноутбук' || $cols[1] == 'планшет')
                        //$t_ar = array(3, 11, 12); 
                        $t_ar = array(11);
                    //else
                        //$t_ar = array(3, 6, 10, 11, 12, 13);
                
                    foreach ($t_ar as $value)
                    {
                        $str = mb_strtolower($cols[$value]);
                         
                        if (preg_match('/[a-z]+/', $str))
                        {   
                           $pass = false;
                           $ret_str[] = 'Строка '.($row_count).', колонка '.($value + 1).', недопустимый символ';
                        }
                    }                    
   
                }
                else
                {
                    $pass = false;
                    $ret_str[] = 'Строка '.($row_count).', неверное количество колонок';
                }
            }
            else
            {   
                $pass = false;
                $ret_str[] = 'Строка '.($row_count).', пустая строка';                
            }            
            
            if ($pass) $success_count++;    
               
        }
        
        if ($ret_str) 
        {
            file_put_contents($_SERVER['DOCUMENT_ROOT'].'/analize.txt', implode(PHP_EOL, $ret_str));
        }  
        
        return "Завершено. Правильных строчек {$success_count} из {$row_count}.".(($ret_str) ? " Анализ сохранен в analize.txt" : "");        
    }   
    
}

?>