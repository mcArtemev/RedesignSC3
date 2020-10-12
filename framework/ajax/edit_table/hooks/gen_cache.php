<?

namespace framework\ajax\edit_table\hooks;

use framework\pdo;

define('TEST_MODE', false);

class gen_cache
{
    public function beforeAdd(&$args)
    {
        /*if (!TEST_MODE)
            $sql = "SELECT COUNT(*) FROM `urls` WHERE `site_id`=:site_id";
        else
            $sql = "SELECT COUNT(*) FROM `urls` WHERE `site_id`=:site_id LIMIT 0,10000";

        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array('site_id' => $args['site_id']));
        $count = $stm->fetchColumn();

        for ($c = 0; $c < ceil($count/100000); $c++)
        {
            $page = $c * 100000;

            if (!TEST_MODE)
                $sql = "SELECT `name` FROM `urls` WHERE `site_id`=:site_id LIMIT {$page},100000";
            else
                $sql = "SELECT `name` FROM `urls` WHERE `site_id`=:site_id LIMIT {$page},10000";

            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array('site_id' => $args['site_id']));
            $urls = $stm->fetchAll(\PDO::FETCH_COLUMN);

            $sql = "SELECT `name` FROM `sites` WHERE `id`=:site_id";
            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array('site_id' => $args['site_id']));
            $site_name = $stm->fetchColumn();

            $mode = (integer) $args['mode'];

            $insert = array();
            $i = 0;

            foreach ($urls as $url)
            {
                $pid = $i % 20;
                $insert[] = "('{$site_name}','{$url}',{$pid},{$mode})";
                $i++;
            }

            if ($insert)
            {
                $sql = "INSERT IGNORE INTO `batchs` (`site_name`,`name`,`pid`,`mode`) VALUES ".implode(',', $insert);
                pdo::getPdo()->query($sql);
            }
        }*/
        /*$ar = array('sony-centre.com','sam-centre.com','asus-centre.com',
                            'acer-centre.com','lenovo-centre.com','hp-centre.com',
                    'msi.centre.services','htc-centre.com','nokia-centre.com',
                    'lg-centre.com','xiaomi-centre.com','huawei-centre.com',
                    'meizu-centre.com','apple.centre.services');

        //sql = "SELECT `id` FROM `sites` WHERE `setka_id` = 3740";
        $sql = "SELECT `id` FROM `sites` WHERE `name` IN (\"".implode('","',$ar)."\")";*/
//        $sql = "SELECT `id` FROM `sites` WHERE `setka_id` = 7";
       $sql = "SELECT `id` FROM `sites` WHERE `setka_id` = 1";
       
       // $sql = "SELECT `id` FROM `sites` WHERE `site_id` IN (13296)";
        // $sql = "SELECT `id` FROM `sites` WHERE `id` = 13861";
        $sites = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN);

        $i = 0;

        $insert = array();

        foreach ($sites as $site)
        {
            $pid = $i % 20;
            $insert[] = "({$site},{$pid})";
            $i++;
        }

         if ($insert)
         {
            $sql = "INSERT IGNORE INTO `batch_site_id` (`site_id`,`pid`) VALUES ".implode(',', $insert);
            pdo::getPdo()->query($sql);
         }

        return false;
    }
}
