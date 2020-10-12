<?

namespace framework\ajax\edit_table\hooks;

use framework\pdo;
use framework\ajax\edit_table\hooks\m_model_to_sites;
use framework\ajax\edit_table\hooks\model_to_sites;
use framework\shape\form as form;
use framework\gen\gen_m_model;
use framework\gen\sc7;
use framework\gen\sc8;
use framework\gen\sc6;

class fill_new
{
    public function beforeAdd(&$args)
    {
        $site_id = $args['site_id'];

        $sql = "SELECT `setkas`.`name` FROM `sites`
                INNER JOIN `setkas` ON `setkas`.`id` = `sites`.`setka_id`
                    WHERE `sites`.`id`=:site_id";
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array('site_id' => $site_id));
        $setka = $stm->fetchColumn();

        if ($setka == 'СЦ-7')
        {
            $obj = new sc7($site_id);
            $obj->genSyns();
            $obj->genUrls();
            $obj->genContent();

            return false;
        }

        if ($setka == 'СЦ-8')
        {
            $obj = new sc8($site_id);
            $obj->genUrls();

            return false;
        }

        if ($setka == 'СЦ-6')
        {
            $obj = new sc6($site_id);
            $obj->genUrls();
            // $obj->updateUrls();

            return false;
        }

        $add_condition = '';
        if ($setka == 'СЦ-5')
            $add_condition = " AND `m_models`.`brand` = 1";
            
        if ($setka == 'СЦ-2')
            $add_condition = ' AND (`model_type_id` = 1 OR `model_type_id`= 2 OR `model_type_id` = 3)';    
        
        $sql = "SELECT `m_models`.`id` FROM `m_models`
                INNER JOIN `markas` ON `markas`.`id` = `m_models`.`marka_id`
                INNER JOIN `marka_to_sites` ON `markas`.`id` = `marka_to_sites`.`marka_id`
                    WHERE `site_id`=:site_id".$add_condition;

        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array('site_id' => $site_id));
        $m_models = $stm->fetchAll(\PDO::FETCH_COLUMN);

        //print_r($m_models);

        foreach ($m_models as $m_model)
        {
            $args = array('m_model_id' => $m_model, 'site_id' => $site_id);

            $sql = "INSERT INTO `m_model_to_sites` SET ".pdo::prepare($args);
            $stm = pdo::getPdo()->prepare($sql);

            $stm->execute($args);

            $m_model_to_sites = new m_model_to_sites();
            $m_model_to_sites->afterAdd($args);
        }

        if ($setka == 'СЦ-3')
        {
            $sql = "SELECT `sublineykas`.`id`
                        FROM `sublineykas`
                    INNER JOIN `marka_to_sites` ON `marka_to_sites`.`marka_id` = `sublineykas`.`marka_id` WHERE `marka_to_sites`.`site_id`=:site_id";

            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array('site_id' => $site_id));
            $sublineykas = $stm->fetchAll(\PDO::FETCH_COLUMN);

            foreach ($sublineykas as $id)
            {
                $gen = new gen_m_model($id, $site_id);
                $gen->setPass(false);
                $gen->setSynMode(true);
                $gen->genSyns();
                $gen->genUrls();
                $gen->genContent();
            }
        }

        if ($m_models)
        {
            $sql = "SELECT `models`.`id` FROM `models` WHERE `m_model_id` IN (".implode(',', $m_models).")";
            $models = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN);
            
            foreach ($models as $model)
            {
                $args = array('model_id' => $model, 'site_id' => $site_id);

                $sql = "INSERT INTO `model_to_sites` SET ".pdo::prepare($args);
                $stm = pdo::getPdo()->prepare($sql);

                $stm->execute($args);

                $model_to_sites = new model_to_sites();
                $model_to_sites->afterAdd($args);
            }
        }

        return false;
    }

    public function processItems(&$items, $args)
    {
        /*$values = array();

        $sql = "SELECT `site_id` FROM `urls` GROUP BY `site_id`";
        $sites = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN);

        $sql = "SELECT `setkas`.`name` as `setka_name`, `sites`.`name` as `site_name`, `sites`.`id` as `site_id`
                    FROM `sites` LEFT JOIN `setkas` ON `sites`.`setka_id` = `setkas`.`id` WHERE `sites`.`id` NOT IN (".implode(',', $sites).")
                            ORDER BY `setkas`.`id` ASC, `sites`.`name` ASC";

        $data = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($data as $value)
            $values[$value['setka_name']][$value['site_id']] = $value['site_name'];

        $items['site_id']->setValues(array(0 => '-- нет данных --') + $values);*/
    }
}
