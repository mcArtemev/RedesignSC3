<?

namespace framework\ajax\action\hooks;

use framework\pdo;

class clear
{
    public function doAction()
    {
        /*$pass = true;
        $tables = array();
        $services = array('defect','service','complect');
        $suffics_array = array('p','n','f');
        
        foreach ($suffics_array as $suffics)
        {
            foreach ($services as $service)
            {
                $tables[] = $suffics.'_'.$service.'_to_models';
                $tables[] = $suffics.'_'.$service.'_to_m_models';
                $tables[] = $suffics.'_'.$service.'_vals';
                $tables[] = $suffics.'_'.$service.'_model_vals';
            }
        }

        $tables[] = 'm_models';
        $tables[] = 'models';
               
        $tables[] = 'm_model_to_sites';
        $tables[] = 'model_to_sites';
        
        $tables[] = 'urls';
        
        $sql = array();
        foreach ($tables as $table)
            $sql[] = "TRUNCATE `{$table}`";

        try 
        {
            pdo::getPdo()->query(implode(';',$sql));
        }
        catch (\PDOException $e)
        {
            $pass = false; 
        }
        
        return (($pass) ? 'Завершено.' : 'Ошибка.'); */ 
    }
}

?>