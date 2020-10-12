<?

namespace framework\ajax\edit_table\hooks;

use framework\pdo;

class dell_sites
{
    public function beforeAdd(&$args)
    {
        $tables = array();
        $services = array('defect','service','complect');
        $suffics_array = array('p','n','f', 'k', 'r', 'o', 's', 'e', 'i',
            'h', 'a', 'v', 't', 'm');
        
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
               
        $tables[] = 'm_model_to_sites';
        $tables[] = 'model_to_sites';
        
        $tables[] = 'urls';
        
        //dop
        /*$tables[] = 'marka_to_sites';
        $tables[] = 'imgs';
        $tables[] = 'dop_urls';
        $tables[] = 'level_imgs';*/
        
        $sql = array();
        foreach ($tables as $table)
        {
            if (pdo::getPdo()->query("SHOW TABLES LIKE '{$table}'")->rowCount() > 0)
            {
                $sql[] = "DELETE FROM `{$table}` WHERE `site_id` = {$args['site_id']}";
            }
        }
            
        $sql = implode(';',$sql);
        
        //echo $sql;
        pdo::getPdo()->query($sql);        
        
        return false;
    }
}