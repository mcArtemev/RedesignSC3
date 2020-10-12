<?

/*spl_autoload_extensions('.php');
spl_autoload_register();

use framework\ajax\edit_table\hooks\fields;
use framework\ajax\edit_table\hooks\tables;
use framework\pdo;

$file = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/tables.csv');

$rows = explode("\n",$file);  

$fields_mas = array('name' => array(5, 14), 'label' => array(15, 24), 'type_id' => array(26, 35), 'null' => array(36, 45));
$tables_mas = array('name' => 1, 'label' => 2, 'claster_id' => 3, 'big_data' => 4);
$id_table = 25;    
$row_number = 1;

foreach ($rows as $row)
{
    $row = trim($row);

    if ($row)
    {
        $cols = explode(';', $row);
        $pass = true;
        
        //print_r($cols);
        
        $args_table = array();
        
        foreach ($tables_mas as $key => $value)
            $args_table[$key] = $cols[$value]; 
            
        //print_r($args_table);       

        $sql = "INSERT INTO `tables` SET ".pdo::prepare($args_table);
        $stm = pdo::getPdo()->prepare($sql);  
        $stm->execute($args_table);   
        $last_table_id = pdo::getPdo()->lastInsertId(); 
        
        $args_table["last_id"] = $last_table_id;     
            
        $table_obj = new tables();
        $table_obj->afterAdd($args_table);       
        
        $fields = array();
        $j = 0;
        
        foreach ($fields_mas as $key => $value)
        {
            $fields_count[$j] = 0;        
            for ($i = $value[0]; $i <= $value[1]; $i++)
            {
                if ($cols[$i] !== '')
                {
                    $fields[$fields_count[$j]][$key] = $cols[$i];
                    $fields_count[$j]++; 
                }
            }
            $j++;
        }
        
        for ($i = 0; $i < count($fields_count)-1; $i++)
        {
            if ($fields_count[$i] !== $fields_count[$i+1])
            {
                echo 'Не соответствие. В строке '.$row_number.PHP_EOL;
                $pass = false;
                break;
            }
        }
        
        if ($pass)
        {        
            foreach ($fields as $args_field)
            {
                $args_field['table_id'] = $last_table_id;
                
                //print_r($args_field);
                
                $sql = "INSERT INTO `fields` SET ".pdo::prepare($args_field);
                $stm = pdo::getPdo()->prepare($sql);  
                $stm->execute($args_field);            
                
                $field_obj = new fields(); 
                $field_obj->afterAdd($args_field);
            }
        }

    }
    
    $row_number++;
}

exit();*/

?>