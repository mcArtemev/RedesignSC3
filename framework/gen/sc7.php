<?

namespace framework\gen;

use framework\pdo;
use framework\tools;
use framework\rand_it;

class sc7
{
    private $_site_id = 0;
    private $_sites_lazy = array();
    private $_info = array();

    public function __construct($site_id = 0)
   {
        $this->_site_id = $site_id;
    }

    private function _getSites()
    {
        //если сайт задан
        if ($this->_site_id)
        {
            $site_id = $this->_site_id;

            if (!isset($this->_sites_lazy[$site_id]))
            {
                $sql = "SELECT `sites`.`id` as `site_id`, `setkas`.`name` as `setka_name`, `setkas`.`id` as `setka_id` FROM `sites`
                                INNER JOIN `setkas` ON `setkas`.`id` = `sites`.`setka_id`
                                    WHERE `sites`.`id`=:id";

                $stm = pdo::getPdo()->prepare($sql);
                $stm->execute(array('id' => $site_id));
                $this->_sites_lazy[$site_id] = $stm->fetchAll(\PDO::FETCH_ASSOC);
            }

            return $this->_sites_lazy[$site_id];
        }

        return false;
    }

    private function _getInfo($type)
    {
        $site_id = $this->_site_id;

        if (!isset($this->_info[$site_id][$type]))
        {
            if ($type == 1) {
              $sql = "SELECT `model_types`.`name` as `model_type_name`, `model_types`.`id` as `type_id`, `model_type_to_markas`.`marka_id` as `marka_id` FROM `model_type_to_markas`
                  INNER JOIN `marka_to_sites` ON `marka_to_sites`.`marka_id` = `model_type_to_markas`.`marka_id`
                  INNER JOIN `model_types` ON `model_types`.`id` = `model_type_to_markas`.`model_type_id`
              WHERE `marka_to_sites`.`site_id`=:site_id";
            }
            else if ($type == 2) {
              $sql = "SELECT 7_defects.id, 7_defects.url, mt.name as 'type_name' FROM `marka_to_sites` AS `mts`
                JOIN `model_type_to_markas` AS `mttm` ON `mttm`.`marka_id` = `mts`.`marka_id`
                JOIN `model_types` AS `mt` ON `mt`.`id` = `mttm`.`model_type_id`
                JOIN 7_defects ON mt.id = 7_defects.model_type_id
               WHERE `mts`.`site_id` = :site_id";
            }
            else if ($type == 3) {
              $sql = "SELECT m_models2.id as 'id', m_models2.name as 'name', model_types.name as 'type', markas.name as 'marka'
                FROM `m_models2`
                JOIN marka_to_sites ON m_models2.marka_id = marka_to_sites.marka_id
                JOIN `m_models2_to_setka` ON `m_models2`.`id` = `m_models2_to_setka`.`m_model_id`
                JOIN model_types ON m_models2.model_type_id = model_types.id
                JOIN markas ON marka_to_sites.marka_id = markas.id
                WHERE site_id = :site_id AND m_models2_to_setka.setka_id = 7";
            }
            else if ($type == 4) {
              $sql = "SELECT `m2`.`id` AS `id`, `m2`.`name` AS `name`, `mt`.`name` AS `type`, markas.name as 'marka' FROM `marka_to_sites` AS `mts`
                            JOIN `model_type_to_markas` AS `mttm` ON `mttm`.`marka_id` = `mts`.`marka_id`
                            JOIN `model_types` AS `mt` ON `mt`.`id` = `mttm`.`model_type_id`
                            JOIN `models2` AS `m2` ON `mttm`.`id` = `m2`.`model_type_mark`
                            JOIN markas ON mttm.marka_id = markas.id
                            JOIN models2_to_setka ON m2.id = models2_to_setka.id_model
                          WHERE `mts`.`site_id` = :site_id AND models2_to_setka.id_setka = 7";
            }

            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array('site_id' => $site_id));
            $this->_info[$site_id][$type] = $stm->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $this->_info[$site_id][$type];
    }

   //сиинонимы
    public function genSyns()
    {
        $sites = $this->_getSites();

        if (!$sites) return;

        $model_types = $this->_getInfo(1);

        $rand = new rand_it();
        $rand->setCountVal(count($sites));
        $rand->setNameValue('id');
        $rand->setNameWeight('weight');

        $rand->setOnlyWeight(true);
        $rand->setDifference(4);

        foreach ($model_types as $value_1)
        {
            $type_name = $value_1['model_type_name'];
            $suffics = tools::get_suffics($type_name);
            if(!$suffics) continue;
            $type_id = $value_1['type_id'];
            $marka_id = $value_1['marka_id'];

            $table = $suffics.'_'.'service'.'_syns';
            $get_field = $suffics.'_'.'service'.'_id';
            $syn_field = $suffics.'_'.'service'.'_syn_id';
            $into_table = $suffics.'_'.'service'.'_to_m_models';

            $sql = "SELECT * FROM `{$table}`";
            $result = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

            $ret_keys = array();

            foreach ($result as $field)
                $ret_keys[$field[$get_field]][] = $field;

            $insert = array();

            foreach ($ret_keys as $value)
            {
                $rand->setArray($value);

                $randIt = $rand->randIt();

                foreach ($randIt as $key => $value)
                {
                    $site = $sites[$key];

                    for ($j=0; $j<count($value); $j++)
                    {
                        $word = tools::word();
                        $insert[] = "(NULL,{$marka_id},{$type_id},{$value[$j]},{$site['site_id']},{$j},{$word},NULL)";
                    }
                }
             }

             if ($insert)
             {
                $sql = "INSERT INTO `{$into_table}` (`m_model_id`, `marka_id`, `model_type_id`, `{$syn_field}`, `site_id`, `type`, `word`, `sublineyka_id`) VALUES ".implode(',', $insert);
                pdo::getPdo()->query($sql);
                //print_r($sql).PHP_EOL;
             }
        }

    }

   private function _getUrls()
   {
        $sites = $this->_getSites();

        if (!$sites) return;

        $model_types = $this->_getInfo(1);
        $defects = $this->_getInfo(2);
        $m_models = $this->_getInfo(3);
        $models = $this->_getInfo(4);
        $urls = array();

        foreach ($sites as $site)
        {
            foreach ($model_types as $value)
            {
                $type_name = $value['model_type_name'];
                $suffics = tools::get_suffics($type_name);
                if(!$suffics) continue;
                $type_id = $value['type_id'];
                $marka_id = $value['marka_id'];

                $accord = array(
                        'ноутбук' => 'laptops', 
                        'планшет' => 'tablets', 
                        'смартфон' => 'smartphones',
                        'компьютер' => 'computers', 
                        'принтер' => 'printers', 
                        'сервер' => 'servers',
                        'проектор' => 'projectors',
                        'игровая приставка' => 'game-consoles',
                        'холодильник' => 'refrigerators', 
                        'фотоаппарат' => 'cameras',
                        'видеокамера' => 'video-cameras', 
                        'телевизор' => 'tvs', 
                        'моноблок' => 'monoblocks',
                        'монитор' => 'monitors',
                        'роутер' => 'routers',
                        /* add rat*/
                        'cмарт-часы' => 'smart-watch',
                        'гироскутер' => 'giroscooters',
                        'квадрокоптер' => 'quadrocopters',
                        'электросамокат' => 'samokats',
                        'холодильник' => 'fridges',
                        'посудомоечная машина' => 'dishwashers',
                        'стиральная машина' => 'washing-machines',
                        'кофемашина' => 'coffee-machines',
                        'плоттер' => 'plotter',
                        'моноколесо' => 'monowheels',
                        'сегвей' => 'segways',
                        'лазерный принтер' => 'laser-printers',
                        'сушильная машина' => 'dryer-machines',
                    );

                $params = serialize(array('model_type_id' => $type_id, 'marka_id' => $marka_id));
                $urls[] = array($site['site_id'], "'repair-".$accord[$type_name]."'",
                        "'".$params."'", tools::get_rand_dop());

                $select_table = $suffics.'_services';
                $sql = "SELECT `name_eng`, `id`, `name` FROM `{$select_table}`";
                $services = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

                foreach ($services as $service)
                {
                    $params = serialize(array('model_type_id' => $type_id, 'marka_id' => $marka_id, 'key' => 'service', 'id' => $service['id']));
                    $urls[] = array($site['site_id'], "'".($service['name_eng'] ? $service['name_eng'] : $service['name']).'-'.$accord[$type_name]."'",
                            "'".$params."'", tools::get_rand_dop());
                }
            }

            foreach ($defects as $def) {
              $url = "repair-".$accord[$def['type_name']]."/".$def['url'];
              $params = serialize(array('7_defect_id' => $def['id']));
              $urls[] = array($site['site_id'], "'$url'",
                      "'".$params."'", tools::get_rand_dop());
            }

            foreach ($m_models as $mm) {
              $url = "repair-".$accord[$mm['type']]."/".strtolower(preg_replace('/(\s+)/', '-', $mm['marka'].' '.$mm['name']));
              $params = serialize(array('m_model2_id' => $mm['id']));
              $urls[] = array($site['site_id'], "'$url'",
                      "'".$params."'", tools::get_rand_dop());
            }

            foreach ($models as $mm) {
              $url = "repair-".$accord[$mm['type']]."/".strtolower(preg_replace('/(\s+)/', '-', $mm['marka'].' '.$mm['name']));
              $params = serialize(array('model2_id' => $mm['id']));
              $urls[] = array($site['site_id'], "'$url'",
                      "'".$params."'", tools::get_rand_dop());
            }
        }

        return $urls;
    }

    public function genUrls()
    {
        if ($urls = $this->_getUrls())
        {
            $insert_urls = array();

            foreach ($urls as $url)
                $insert_urls[] = '('.implode(',', $url).','.tools::get_time().')';

            $sql = "INSERT IGNORE INTO `urls` (`site_id`,`name`,`params`,`feed`,`date`) VALUES ".implode(',', $insert_urls);
            pdo::getPdo()->query($sql);
            //print_r($sql).PHP_EOL;
        }
    }

     //контент
    public function genContent()
    {
        $sites = $this->_getSites();

        if (!$sites) return;

        $model_types = $this->_getInfo(1);

        foreach ($model_types as $value_1)
        {
            $type_name = $value_1['model_type_name'];
            $suffics = tools::get_suffics($type_name);
            if(!$suffics) continue;
            $type_id = $value_1['type_id'];
            $marka_id = $value_1['marka_id'];

            $into_table = $suffics.'_'.'service'.'_model_vals';
            $get_field = $suffics.'_'.'service'.'_id';

            $select_table = $suffics.'_services';
            $sql = "SELECT `id`, `name` FROM `{$select_table}`";
            $mas = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

            $insert = array();

            foreach ($mas as $value)
            {
                $id = $value['id'];

                foreach ($sites as $site)
                {
                    $insert[] = "(NULL,{$id},{$site['site_id']},{$marka_id},{$type_id},'".
                            serialize(tools::create_other($suffics, 'service', $id, $site['setka_name']))."','".
                            serialize(array())."',".
                            rand().
                            ",NULL)";
                }
            }

            if ($insert)
            {
                $sql = "INSERT INTO `{$into_table}` (`m_model_id`, `{$get_field}`, `site_id`, `marka_id`, `model_type_id`,
                    `other_services`, `dop_defects`, `feed`, `sublineyka_id`) VALUES ".implode(',', $insert);
                pdo::getPdo()->query($sql);
                //print_r($sql);
            }
        }
    }

    //сиинонимы
    public function delSyns()
    {
        $sites = $this->_getSites();

        if (!$sites) return;

        $model_types = $this->_getInfo(1);

        foreach ($model_types as $value)
        {
            $type_name = $value['model_type_name'];
            $suffics = tools::get_suffics($type_name);
            if(!$suffics) continue;
            $type_id = $value['type_id'];
            $marka_id = $value['marka_id'];

            $into_table = $suffics.'_'.'service'.'_to_m_models';

            foreach ($sites as $site)
            {
                $sql = "DELETE FROM `{$into_table}` WHERE `site_id` = {$site['site_id']} AND `marka_id` = {$marka_id} AND `model_type_id` = {$type_id}";
                //echo $sql;
                pdo::getPdo()->query($sql);
            }
        }
    }

    public function delUrls()
    {
        if ($urls = $this->_getUrls())
        {
            foreach ($urls as $url)
            {
                $sql = "DELETE FROM `urls` WHERE `site_id`= {$url[0]} AND `name`= {$url[1]}";
                pdo::getPdo()->query($sql);
            }
        }
    }

    public function delContent()
    {
        $sites = $this->_getSites();

        if (!$sites) return;

        $model_types = $this->_getInfo(1);

        foreach ($model_types as $value)
        {
            $type_name = $value['model_type_name'];
            $suffics = tools::get_suffics($type_name);
            if(!$suffics) continue;
            $type_id = $value['type_id'];
            $marka_id = $value['marka_id'];

            $into_table = $suffics.'_'.'service'.'_model_vals';

            foreach ($sites as $site)
            {
                $sql = "DELETE FROM `{$into_table}` WHERE `site_id` = {$site['site_id']} AND `marka_id` = {$marka_id} AND `model_type_id` = {$type_id}";
                pdo::getPdo()->query($sql);
            }
        }
    }
}

?>
