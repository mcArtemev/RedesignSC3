<?

namespace framework\ajax\action\hooks;

use framework\pdo;
use framework\ajax\action\idoAction;  

class optimize_yd implements idoAction  
{
    public function doAction()
    {
        /*$sql = "SELECT COUNT(*) FROM `ads_yd`";
        $ads = (integer) pdo::getPdo()->query($sql)->fetchColumn();
            
        if (!$ads) return 'Нет объявлений.';
        
        $sql = "SELECT `header`, COUNT(*) as `count` FROM `ads_yd` GROUP BY `header` HAVING `count` > 1";
        $headers = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN);
        
        foreach ($headers as $header)
        {
            $sql = "SELECT * FROM `ads_yd` WHERE `header`=:header";
            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array('header' => $header)); 
            $ad = $stm->fetchAll(\PDO::FETCH_ASSOC);
            
            $max_ad = array(0 => false, 3 => false, -3 => false, 1 => false, -1 => false, 2 => false, -2 => false);            
            $del_id = array();
            $keywords = array();
            $save_id = false;
            
            foreach ($ad as $a)
            {
                $id = $a['id'];
                
                $max_ad[$a['mode']][] = $id;
                $del_id[$id] = $id;
                $keywords[] = $a['keywords'];
            }        
            
            foreach ($max_ad as $value)
            {
                if ($value)
                {
                    if (count($value) > 1)
                        file_put_contents('/var/www/www-root/data/www/studiof1-test.ru/optimize.txt', $value.",", FILE_APPEND | LOCK_EX);
                    //else
                        $save_id = current($value);
                    break;
                }
            }
            
            unset($del_id[$save_id]);
            
            $t_keywords = array();
            foreach ($keywords as $keyword)
            {
                foreach (explode(";", $keyword) as $k)
                {            
                    $t_keywords[] = $k;
                }
            }
            
            $t_keywords = implode(";", array_unique($t_keywords));           
                  
            $sql = "UPDATE `ads_yd` SET `keywords` = '{$t_keywords}' WHERE `id` = {$save_id}";
            pdo::getPdo()->query($sql);
            
            $sql = "DELETE FROM `ads_yd` WHERE `id` IN (".implode(',', $del_id).")";
            pdo::getPdo()->query($sql);
            
        } 
         
        return 'Оптимизация завершена.'; */  
        $keywords_opt_1 = array();
        //$all_markas = array();
                
        $sql = "SELECT `m_model_id`,`url` FROM `keywords` WHERE `mode` = -1 GROUP BY `m_model_id`";
        $opt_1 = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($opt_1 as $value)
        {
            $sql = "SELECT `name` FROM `keywords` WHERE `mode` = -2 AND `m_model_id` = {$value['m_model_id']} AND `use_marka` IS NULL";   
            $keywords_opt_1[$value['url']] = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN);
            
            //$sql = "SELECT `name` FROM `keywords` WHERE `mode` = -2 AND `m_model_id` = {$value['m_model_id']} AND `use_marka` IS NOT NULL";
            //$all_markas = array_merge($all_markas, pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN));  
            
            $sql = "SELECT `name` FROM `keywords` WHERE `mode` = -1 AND `url` = {$value['url']}";
            $keywords_opt_1[$value['url']] = array_merge(pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN) + $keywords_opt_1[$value['url']]); 
        }
        
        print_r($keywords_opt_1);
        
        $keywords_opt_2 = array();
        
        $sql = "SELECT `key`,`k_id`,`m_model_id`,`url` FROM `keywords` WHERE `mode` = 1 GROUP BY `key`,`k_id`,`m_model_id`";
        $opt_2 = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($opt_2 as $value)
        {
            $sql = "SELECT `name` FROM `keywords` WHERE `mode` = 2 AND 
                    `key` = '{$value['key']}' AND `k_id` = {$value['k_id']} AND `m_model_id` = {$value['m_model_id']} AND `use_marka` IS NULL"; 
                      
            $keywords_opt_2[$value['url']] = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN);
            
            $sql = "SELECT `name` FROM `keywords` WHERE `mode` = 1 AND `url` = {$value['url']}";
            $keywords_opt_2[$value['url']] = array_merge(pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN) + $keywords_opt_2[$value['url']]); 
        }
        
        print_r($keywords_opt_2);
        
        $keywords_opt_3 = array();
        
        $sql = "SELECT `key`,`k_id`,`m_model_id`,`url` FROM `keywords` WHERE `mode` = 0 GROUP BY `key`,`k_id`,`m_model_id`";
        $opt_2 = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($opt_2 as $value)
        {
            $sql = "SELECT `name` FROM `keywords` WHERE `mode` = 2 AND 
                    `key` = '{$value['key']}' AND `k_id` = {$value['k_id']} AND `m_model_id` = {$value['m_model_id']} AND `use_marka` IS NULL"; 
                      
            $keywords_opt_2[$value['url']] = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN);
            
            $sql = "SELECT `name` FROM `keywords` WHERE `mode` = 1 AND `url` = {$value['url']}";
            $keywords_opt_2[$value['url']] = array_merge(pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN) + $keywords_opt_2[$value['url']]); 
        }

    }
}