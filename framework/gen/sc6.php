<?

namespace framework\gen;

use framework\pdo;
use framework\tools;

class sc6
{
    private $_site_id = 0;
    private $_sites_lazy = array();

    public function __construct($site_id = 0)
    {
        $this->_site_id = $site_id;
    }

    private function _getSites()
    {
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

    private function _getInfo()
    {
        $site_id = $this->_site_id;

        if (!isset($this->_info[$site_id]))
        {
            $sql = "SELECT `model_types`.`name` as `model_type_name`, `model_types`.`id` as `type_id`, `mttm`.`marka_id` as `marka_id`
                    FROM `model_type_to_markas` AS mttm
                       INNER JOIN `marka_to_sites` AS mts ON `mts`.`marka_id` = `mttm`.`marka_id`
                       INNER JOIN `model_types` ON `model_types`.`id` = `mttm`.`model_type_id`
                     WHERE `mts`.`site_id`=:site_id";

            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array(':site_id' => $site_id));
            $this->_info[$site_id]['hub'] = $stm->fetchAll(\PDO::FETCH_ASSOC);

            $sql = "SELECT `m2`.`id` AS `model_id`, `m2`.`name` AS `model_name`, `mt`.`name` AS `type_name` FROM `marka_to_sites` AS `mts`
                          JOIN `model_type_to_markas` AS `mttm` ON `mttm`.`marka_id` = `mts`.`marka_id`
                          JOIN `model_types` AS `mt` ON `mt`.`id` = `mttm`.`model_type_id`
                          JOIN `models2` AS `m2` ON `mttm`.`id` = `m2`.`model_type_mark`
                          JOIN models2_to_setka ON m2.id = models2_to_setka.id_model
                        WHERE `mts`.`site_id` = :site_id AND models2_to_setka.id_setka = 6";

            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array(':site_id' => $site_id));
            $this->_info[$site_id]['models'] = $stm->fetchAll(\PDO::FETCH_ASSOC);

            $sql = "SELECT 6_services.id, 6_services.url, mt.name as 'type_name' FROM `marka_to_sites` AS `mts`
              JOIN `model_type_to_markas` AS `mttm` ON `mttm`.`marka_id` = `mts`.`marka_id`
              JOIN `model_types` AS `mt` ON `mt`.`id` = `mttm`.`model_type_id`
              JOIN 6_services ON mt.id = 6_services.model_type_id
             WHERE `mts`.`site_id` = :site_id AND urlWork = 1";

            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array(':site_id' => $site_id));
            $this->_info[$site_id]['services'] = $stm->fetchAll(\PDO::FETCH_ASSOC);

             $sql = "SELECT 6_defects.id, 6_defects.url, mt.name as 'type_name' FROM `marka_to_sites` AS `mts`
               JOIN `model_type_to_markas` AS `mttm` ON `mttm`.`marka_id` = `mts`.`marka_id`
               JOIN `model_types` AS `mt` ON `mt`.`id` = `mttm`.`model_type_id`
               JOIN 6_defects ON mt.id = 6_defects.model_type_id
              WHERE `mts`.`site_id` = :site_id AND urlWork = 1";

            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array(':site_id' => $site_id));
            $this->_info[$site_id]['defects'] = $stm->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $this->_info[$site_id];
    }


    private function _getUrls()
    {
        $sites = $this->_getSites();

        if (!$sites) return;

//        $model_types = $this->_getInfo();
//        $urls = array();

        $models = $this->_getInfo();
        $urls = array();

        foreach ($sites as $site)
        {
//            $urls = array();
//            $urls[] = array($site['site_id'], 'remont_elektronnykh-knig', 'remont_elektronnykh_knig');
//            $urls[] = array($site['site_id'], 'remont_igrovykh-pristavok', 'remont_igrovykh_pristavok');

//            foreach ($model_types as $value)
//            {
//                $type_name = $value['model_type_name'];
//                $type_id = $value['type_id'];
//                $marka_id = $value['marka_id'];
//
//                $accord = array( 'ноутбук' => 'remont_noutbukov', 'планшет' => 'remont_planshetov', 'смартфон' => 'remont_smartfonov', 'моноблок' => 'remont_monoblokov', 'компьютер' => 'remont_kompyuterov', 'сервер' => 'remont_serverov', 'телевизор' => 'remont_televizorov', 'холодильник' => 'remont_kholodilnikov', 'монитор' => 'remont_monitorov', 'проектор' => 'remont_proyektorov', 'телефон' => 'remont_telefonov', 'принтер' => 'remont_printerov', 'электронная книга' => 'remont_elektronnykh-knig', 'фотоаппарат' => 'remont_fotoapparatov', 'игровая приставка' => 'remont_igrovykh-pristavok');
//
//                $params = serialize(array('model_type_id' => $type_id, 'marka_id' => $marka_id));
//                $urls[] = array($site['site_id'], "'" . $accord[$type_name] . "'", "'".$params."'", tools::get_rand_dop());
//            }

            $accord = array(
                'ноутбук' => 'remont_noutbukov', 
                'планшет' => 'remont_planshetov', 
                'смартфон' => 'remont_smartfonov', 
                'моноблок' => 'remont_monoblokov', 
                'компьютер' => 'remont_kompyuterov', 
                'сервер' => 'remont_serverov', 
                'телевизор' => 'remont_televizorov', 
                'холодильник' => 'remont_kholodilnikov', 
                'монитор' => 'remont_monitorov', 
                'проектор' => 'remont_proyektorov', 
                'телефон' => 'remont_telefonov', 
                'принтер' => 'remont_printerov', 
                'электронная книга' => 
                'remont_elektronnykh_knig', 
                'фотоаппарат' => 
                'remont_fotoapparatov', 
                'игровая приставка' => 
                'remont_igrovykh_pristavok',
                'кофемашина' =>'remont_kofemashin',
                
                
                'пылесос'=> 'remont_pylesosov',
                'варочная панель'=> 'remont_varochnyh_panelej',
                'микроволновая печь'=> 'remont_mikrovolnovyh_pechej',
                'кондиционер'=> 'remont_kondicionerov',
                'робот-пылесос'=> 'remont_robotov-pylesosov',
                'домашний кинотеатр'=> 'remont_domashnih_kinoteatrov',
                'хлебопечка'=> 'remont_hlebopechek',
                'морозильник'=> 'remont_morozilnikov',
                'посудомоечная машина'=> 'remont_posudomoechnyh_mashin',
                'духовой шкаф'=> 'remont_duhovyh_shkafov',
                'смарт-часы'=> 'remont_smart-chasov',
                'вытяжка'=> 'remont_vytyazhek',
                'видеокамера'=> 'remont_videokamer',
                'массажное кресло'=> 'remont_massazhnyh_kresel',
                'стиральная машина'=>'remont_stiralnayh_mashin',
                'водонагреватель'=>'remont_vodonagrevatelej',
                'квадрокоптер'=>'remont_kvadrokopterov',
                'плоттер'=>'remont_plotterov',
                'гироскутер'=>'remont_giroskuterov',
                'электросамокат'=> 'remont_elektrosamokatov',   
                'моноколесо' => 'remont_monokoles',
                'сегвей' => 'remont_segveev',
                'сушильная машина'=> 'remont_sushilnyh_mashin',
                'лазерный принтер'=>'remont_lazernyh_printerov',
                'наушники'=>'remont_naushnikov',
                );

            foreach ($models['hub'] as $model) {
                $url = $accord[$model['model_type_name']];

                $params = serialize(array('model_type_id' => $model['type_id'], 'marka_id' => $model['marka_id']));
                $urls[] = array($site['site_id'], "'" . $url . "'", "'".$params."'", tools::get_rand_dop());
            }

            foreach ($models['models'] as $model) {

                $url = $accord[$model['type_name']] . '/' . mb_strtolower(preg_replace("/\s+/", "_", $model['model_name']));

                $params = serialize(array('model_id' => $model['model_id']));
                $urls[] = array($site['site_id'], "'" . $url . "'", "'".$params."'", tools::get_rand_dop());
            }

            foreach ($models['services'] as $model) {

                /*$url = $accord[$model['type_name']] . '/' . mb_strtolower(preg_replace("/\s+/", "_", $model['model_name']));

                $params = serialize(array('model_id' => $model['model_id']));
                $urls[] = array($site['site_id'], "'" . $url . "'", "'".$params."'", tools::get_rand_dop());*/

                $url = $accord[$model['type_name']] . '/' . $model['url'];

                $params = serialize(array('6_service_id' => $model['id']));
                $urls[] = array($site['site_id'], "'" . $url . "'", "'".$params."'", tools::get_rand_dop());
            }

            foreach ($models['defects'] as $model) {

                /*$url = $accord[$model['type_name']] . '/' . mb_strtolower(preg_replace("/\s+/", "_", $model['model_name']));

                $params = serialize(array('model_id' => $model['model_id']));
                $urls[] = array($site['site_id'], "'" . $url . "'", "'".$params."'", tools::get_rand_dop());*/

                $url = $accord[$model['type_name']] . '/' . $model['url'];

                $params = serialize(array('6_defect_id' => $model['id']));
                $urls[] = array($site['site_id'], "'" . $url . "'", "'".$params."'", tools::get_rand_dop());
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

    public function updateUrls()
    {
        if ($urls = $this->_getUrls())
        {
            foreach ($urls as $url)
            {
                $sql = "UPDATE `urls` SET name = '{$url[2]}' WHERE `site_id`= {$url[0]} AND name = '{$url[1]}'";
                pdo::getPdo()->query($sql);
            }
        }
    }

}

?>
