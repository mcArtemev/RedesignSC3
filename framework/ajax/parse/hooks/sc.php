<?

namespace framework\ajax\parse\hooks;

use framework\tools;
use framework\pdo;
use framework\gen\leaf;
use framework\gen\tree;
use framework\rand_it;

abstract class sc
{
    protected $_datas = array();
    protected $_ret = array();

    protected $_suffics = '';
    protected $_site_id = 0;

    protected $_mode = 0; //режим синонимов
    protected $_cache_mode = false;

    public function getData()
    {
        return $this->_datas;
    }

    public function getMode()
    {
        return $this->_mode;
    }

    public function getCacheMode()
    {
        return $this->_cache_mode;
    }

    public function getSuffics()
    {
        return $this->_suffics;
    }

    public function getSiteId()
    {
        return $this->_site_id;
    }

    public static function createDop($setka_id, $feed)
    {
        // dop
        $gropus = array();
        $colsDb = array();

        $sql = "SELECT `dops`.`dop_group_id` as `group`, `dops`.`col` as `col` FROM `dop_group_to_setkas`
                INNER JOIN `dops` ON `dop_group_to_setkas`.`dop_group_id` = `dops`.`dop_group_id` WHERE `dop_group_to_setkas`.`setka_id`= ?";
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array($setka_id));

        foreach ($stm->fetchAll(\PDO::FETCH_ASSOC) as $value)
            $colsDb[$value['group']][] = $value['col'];

        $groups = array();

        foreach ($colsDb as $gr)
        {
            $j = 0;
            $cols = array();

            foreach ($gr as $col)
            {
                $dp = explode(';', $col);
                $count_gr = count($gr);

                for($i=0; $i<count($dp); $i++)
                {
                    $str = trim($dp[$i]);
                    if ($j == 0) $str = tools::mb_ucfirst($str, 'utf-8', false);
                    if ($j == $count_gr - 1) $str .= '.';
                    $cols[$j][] = $str;
                }
                $j++;
            }
            $groups[] = $cols;
        }

        $str = '';
        foreach ($groups as $cols)
            $str .= sc::_createTree($cols, $feed).' ';

        return ($str) ? mb_substr($str, 0, -1) : '';
    }

    public function _sqlLevelData($params)
    {
        $this->_site_id = $params['site_id'];
        $this->_cache_mode = $params['cache_mode'];

        $fields = array('syns', 'price', 'marka', 'suffics', 'availables', 'time');

        foreach ($params['model_type_id'] as $key => $model_type_id)
        {
            $obj = new sc1;

            $t_params = $params;
            $t_params['model_type_id'] = $model_type_id;
            $t_params['id'] = $params['id'][$key];

            if ($params['setka_name'] == 'СЦ-2' || $params['setka_name'] == 'СЦ-2з')
            {
                unset($t_params['id']);
                unset($t_params['key']);
            }

            $obj->_sqlData($t_params);
            $this->_datas[] = $obj->getData();
        }

        $prices = array();
        $m_type = array();
        $orig_m_type = array();

        foreach ($this->_datas as $data)
        {
            $prices[] = $data['price'];
            $m_type[] = $data['model_type'];
            $orig_m_type[] = $data['orig_model_type'];

            if (isset($data['vals'])) $this->_datas['vals'][] = $data['vals'];
            $this->_datas['eds'][] = $data['eds'];

            switch ($params['key'])
            {
                case 'complect':

                    if (!isset($this->_datas['services_to_complect']))
                        $this->_datas['services_to_complect'] = array();

                    if (isset($data['services_to_complect']))
                        if ($data['services_to_complect'])
                            $this->_datas['services_to_complect'][] = $data['services_to_complect'];

                    if (isset($data['other_complects']))
                        $this->_datas['other_complects'][] = rand_it::randMas($data['other_complects'], 4, '', $params['feed']);

                break;
                case 'service':

                    if (!isset($this->_datas['complect_to_services']))
                        $this->_datas['complect_to_services'] = array();

                    if (isset($data['complect_to_services']))
                        if ($data['complect_to_services'])
                            $this->_datas['complect_to_services'][] = $data['complect_to_services'];

                    if (isset($data['other_services']))
                        $this->_datas['other_services'][] = rand_it::randMas($data['other_services'], 4, '', $params['feed']);

                break;
                case 'defect':

                    if (!isset($this->_datas['dop_reasons']))
                        $this->_datas['dop_reasons'] = array();

                    if (isset($data['dop_reasons']))
                        if ($data['dop_reasons'])
                            $this->_datas['dop_reasons'] = array_merge($this->_datas['dop_reasons'], $data['dop_reasons']);

                    if (!isset($this->_datas['dop_services'])) $this->_datas['dop_services'] = array();

                    if (isset($data['dop_services']))
                        if ($data['dop_services'])
                            $this->_datas['dop_services'][] = rand_it::randMas($data['dop_services'], 2, '', $params['feed']);

                break;
            }
        }

        if ($params['key'] == 'defect')
        {
            $t = array();
            foreach ($this->_datas['dop_reasons'] as $key => $value)
                $t[$value] = true;

            $this->_datas['dop_reasons'] = array_keys($t);
        }

        $ar_s = array_search(min($prices), $prices);
        foreach ($this->_datas[$ar_s] as $key => $value)
        {
            if (in_array($key, $fields))
                $this->_datas[$key] = $value;
            else
            {
                if ($key == 'id') $this->_datas['min_id'] = $value;
            }
        }

        if ($params['setka_name'] == 'СЦ-2' || $params['setka_name'] == 'СЦ-2з')
            $this->_datas['min_id'] = $params['id'][$ar_s];

        $this->_datas['model_type'] = array();
        $this->_datas['orig_model_type'] = array();

        foreach ($m_type as $key => $value)
        {
            foreach ($value as $k => $v)
            {
                if (is_numeric($k))
                {
                    foreach ($v as $kk => $vv)
                    {
                        $this->_datas['model_type'][$k][$kk][] = $vv;
                    }
                }
                else
                    $this->_datas['model_type'][$k][] = $v;
            }
        }

        foreach ($orig_m_type as $key => $value)
        {
            for ($i = 0; $i < 2; $i++)
            {
                if (!isset($value[1])) $value[1] = $value[0];
                $v = $value[$i];
                foreach ($v as $kk => $vv)
                {
                    $this->_datas['orig_model_type'][$i][$kk][] = $vv;
                }
            }
        }

        // img
        $sql = "SELECT `img` FROM `level_imgs` WHERE `site_id` = ?";
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array($this->_site_id));
        $this->_datas['img']  = $stm->fetchColumn();

        $this->_datas['dop'] = sc::createDop($params['setka_id'], $params['feed']);

        $this->_datas = $this->_datas + $params;

        $this->_suffics = $this->_datas['suffics'];
        $this->_mode = 0;

        //print_r($this->_datas);
    }

    public function _sqlData($params)
    {
        $this->_datas = $this->_datas + $params;
        $this->_site_id = $params['site_id'];
        $this->_cache_mode = $params['cache_mode'];

        // устанавливаем режим
        if (isset($params['sublineyka_id']))
        {
            if (isset($params['key']))
                $this->_mode = 5;
            else
                $this->_mode = -5;
        }

        if (isset($params['m_model_id']) || (isset($params['marka_id']) && isset($params['model_type_id'])))
        {
            if (isset($params['key']))
            {
                if (isset($params['m_model_id']))
                    $this->_mode = 1;
                else
                    $this->_mode = 3;
            }
            else
            {
                if (isset($params['m_model_id']))
                    $this->_mode = -1;
                else
                    $this->_mode = -3;
            }
        }

        if (isset($params['model_id']))
        {
            if (isset($params['key']))
                $this->_mode = 2;
            else
                $this->_mode = -2;
        }

        // dop
        $this->_datas['dop'] = sc::createDop($params['setka_id'], $params['feed']);

        // model
        if (isset($params['model_id']))
        {
            $sql = "SELECT * FROM `models` WHERE `id`= ?";
            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array($params['model_id']));
            $data = current($stm->fetchAll(\PDO::FETCH_ASSOC));

            $params['m_model_id'] = $data['m_model_id'];
            $params['sublineyka_id'] = $data['sublineyka_id'];

            $this->_datas['model'] = $data;
        }

        // m_model
        if (isset($params['m_model_id']))
        {
            $sql = "SELECT * FROM `m_models` WHERE `id`= ?";
            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array($params['m_model_id']));
            $data = current($stm->fetchAll(\PDO::FETCH_ASSOC));

            $params['model_type_id'] = $data['model_type_id'];
            $params['marka_id'] = $data['marka_id'];

            $this->_datas['m_model'] = $data;
        }

        //sublineyka
        if (isset($params['sublineyka_id']))
        {

            $sql = "SELECT * FROM `sublineykas` WHERE `id`= ?";
            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array($params['sublineyka_id']));
            $data = current($stm->fetchAll(\PDO::FETCH_ASSOC));

            $params['model_type_id'] = $data['model_type_id'];
            $params['marka_id'] = $data['marka_id'];

            $this->_datas['sublineyka'] = $data;
        }

        // type
        $sql = "SELECT * FROM `model_types` WHERE `id`= ?";
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array($params['model_type_id']));

        $m_type = current($stm->fetchAll(\PDO::FETCH_ASSOC));

        foreach (array('name', 'name_re', 'name_rm', 'name_de', 'name_dm', 'name_m') as $name)
        {
            if (!$m_type[$name.'_syn'])
               $m_type[$name.'_syn'] = $m_type[$name];
            else
               $this->_datas['orig_model_type'][1][$name] = $m_type[$name.'_syn'];

            $this->_datas['orig_model_type'][0][$name] = $m_type[$name];
        }

        $this->_datas['model_type'] = $m_type;

        // marka
        $sql = "SELECT * FROM `markas` WHERE `id`= ?";
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array($params['marka_id']));
        $this->_datas['marka'] = current($stm->fetchAll(\PDO::FETCH_ASSOC));

        // vsemodeli
        $vsemodeli = array();
        $ru_vsemodeli = array();
        $vsemodeli_id = array();
        
        // $groupByM_Model = '';
        // if($this->_datas['setka_name'] == 'СЦ-1' && tools::get_suffics($this->_datas['model_type']['name'])  == 'p'){
            $groupByM_Model = ' group by `m_model_to_sites`.`m_model_id` ';
        // }

        $sql = "SELECT `m_models`.`name` as `name`,`m_models`.`ru_name` as `ru_name`,
                `m_models`.`id` as `id` FROM `m_model_to_sites`
            INNER JOIN `sites` ON `sites`.`id`=`m_model_to_sites`.`site_id`
            INNER JOIN `m_models` ON `m_models`.`id`=`m_model_to_sites`.`m_model_id`
                WHERE `m_models`.`marka_id`= ? AND `m_models`.`brand` = 1 AND `m_model_to_sites`.`site_id` = ? AND `m_models`.`model_type_id` = ? {$groupByM_Model}";

        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array($params['marka_id'], $params['site_id'], $params['model_type_id']));
        $data = $stm->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($data as $value)
        {
            $vsemodeli[] = $value['name'];
            $ru_vsemodeli[] = $value['ru_name'];
            $vsemodeli_id[] = $value['id'];
        }

        $this->_datas['vsemodeli_array'] = $vsemodeli;
        $this->_datas['vsemodeli'] = implode(', ', $vsemodeli);
        $this->_datas['ru_vsemodeli'] = implode(', ', $ru_vsemodeli);
        $this->_datas['vsemodeli_id'] = $vsemodeli_id;

        // others
        $this->_datas['suffics'] = $suffics = $this->_suffics = tools::get_suffics($this->_datas['model_type']['name']);

        // img
        $sql = "SELECT `url` FROM `imgs` WHERE `site_id` = ? AND `marka_id`= ? AND `model_type_id` = ?";
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array($this->_site_id, $params['marka_id'], $params['model_type_id']));
        $this->_datas['img']  = $stm->fetchColumn();

        // eds
        $table_cost = $suffics.'_service_costs';
        $j_field = $suffics.'_service_id';

        $this->_datas['eds'] = array();

        $sql = "SELECT `{$j_field}`, `ed_time`, `ed_garantee` FROM `{$table_cost}` WHERE `setka_id`=:setka_id";
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array('setka_id' => $this->_datas['setka_id']));
        foreach ($stm->fetchAll(\PDO::FETCH_ASSOC) as $ed)
            $this->_datas['eds'][$ed[$j_field]] = $ed;

        $eds = $this->_datas['eds'];

        // availables
        $this->_datas['availables'] = $availables = tools::get_base('', 'availables');

         //max_amount
        $this->_datas['max_amount'] = 0;
        $table_amount = $suffics.'_complect_amounts';

        if (pdo::getPdo()->query("SHOW TABLES LIKE '$table_amount'")->rowCount())
        {
            $sql = "SELECT `max_amount` FROM `{$table_amount}` WHERE `setka_id`=:setka_id";
            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array('setka_id' => $this->_datas['setka_id']));
            $this->_datas['max_amount'] = $stm->fetchColumn();
        }

        if ($this->_mode > 0)
        {
            $syns = $this->_get_syns($params['key'], array($params['id']));
            $syns_ar = array();

            foreach ($syns as $syn)
            {
                $key = (integer) $syn['type'];
                $this->_datas['syns'][$key] = $syn['name'];
                $syns_ar[$key] = $syn;
            }

            // model_types_syns
            $t = array();
            foreach ($syns_ar as $key => $value)
            {
                if ($value['word'])
                    $ar = array(
                        'name' => $this->_datas['model_type']['name_syn'],
                        'name_re' => $this->_datas['model_type']['name_re_syn'],
                        'name_rm' => $this->_datas['model_type']['name_rm_syn'],
                        'name_m' => $this->_datas['model_type']['name_m_syn'],
                        );
                else
                    $ar = array(
                        'name' => $this->_datas['model_type']['name'],
                        'name_re' => $this->_datas['model_type']['name_re'],
                        'name_rm' => $this->_datas['model_type']['name_rm'],
                        'name_m' => $this->_datas['model_type']['name_m'],
                        );
                $t[$key] = $ar;
            }

            $this->_datas['model_type'] = array('id' => $this->_datas['model_type']['id']) + $t;

            $this->_datas['vals'] = $vals = current($this->_get_vals($params['key'], array($this->_datas['id'])));

            switch ($params['key'])
            {
                case 'complect':
                    $this->_datas['amount'] = $this->_datas['vals']['amount'];
                    $this->_datas['price'] = $this->_datas['vals']['price'];
                    $this->_datas['available'] = isset($availables[$vals['available_id']]['name']) ? $availables[$vals['available_id']]['name'] : array();

                    $this->_datas['services_to_complect'] = $this->_find('service', 'complect', $this->_datas['id']);
                    $this->_datas['dop_services'] = $this->_get_vals('service', unserialize($vals['dop_services']));
                    $this->_datas['other_complects'] = $this->_get_vals('complect', unserialize($vals['other_complects']));

                break;
                case 'service':
                    if (isset($this->_datas['vals']['price']))
                        $this->_datas['price'] = $this->_datas['vals']['price'];

                    if (isset($this->_datas['vals']['time_min']))
                        $this->_datas['time'] = $this->_datas['vals']['time_min'];

                    $this->_datas['complect_to_services'] = $this->_find('complect', 'service', $this->_datas['id']);

                    if (isset($vals['dop_defects']))
                        if ($dop_defects = unserialize($vals['dop_defects']))
                            $this->_datas['dop_defects'] = $this->_get_vals('defect', $dop_defects);

                    if (isset($vals['other_services']))
                        if ($other_services = unserialize($vals['other_services']))
                            $this->_datas['other_services'] = $this->_get_vals('service', $other_services);
                break;
                case 'defect':
                    $reasons_table = $this->_suffics.'_defect_reasons';
                    $sql = "SELECT `name` FROM `{$reasons_table}` WHERE `id` IN (".implode(",", unserialize($vals['dop_reasons'])).")";
                    $this->_datas['dop_reasons'] = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN);

                    $this->_datas['dop_services'] = $this->_get_vals('service', unserialize($vals['dop_services']));
                    $this->_datas['other_defects'] = $this->_get_vals('defect', unserialize($vals['other_defects']));

                    $prices = array();
                    $times = array();

                    foreach ($this->_datas['dop_services'] as $value)
                    {
                        $prices[] = $value['price'];
                        $times[] = $value['time_min'];
                    }

                    $this->_datas['price'] = min($prices);
                    $this->_datas['time'] = min($times);
                break;
            }
        }
        else
        {
            $table_mas = tools::get_codes($suffics);

            foreach ($table_mas as $key => $mas)
            {
                if ($key == 'defect') continue;

                $ids = array();
                foreach ($mas as $value)
                    $ids[] = $value['id'];

                if ($key == 'service')
                {
                    $this->_datas['all_services'] = rand_it::randMas($this->_get_vals($key, $ids), count($ids), '', $params['feed']);

                    $prices = array();
                    $times = array();

                    foreach ($this->_datas['all_services'] as $value)
                    {
                        if ($value['price'] > 100) $prices[] = $value['price'];
                        $times[] = $value['time_min'];
                    }

                    if ($prices) $this->_datas['price'] = min($prices);
                    if ($times) $this->_datas['time'] = min($times);
                }

                if ($key == 'complect')
                {
                    $this->_datas['all_complects'] = rand_it::randMas($this->_get_vals($key, $ids), count($ids), '', $params['feed']);
                }
            }

            srand($params['feed']);

            $t = array();
            for ($i=0; $i<4; $i++)
            {
                if (rand(0, 1))
                {
                    $ar = array(
                        'name' => $this->_datas['model_type']['name_syn'],
                        'name_re' => $this->_datas['model_type']['name_re_syn'],
                        'name_rm' => $this->_datas['model_type']['name_rm_syn'],
                        'name_m' => $this->_datas['model_type']['name_m_syn'],
                    );
                }
                else
                {
                    $ar = array(
                        'name' => $this->_datas['model_type']['name'],
                        'name_re' => $this->_datas['model_type']['name_re'],
                        'name_rm' => $this->_datas['model_type']['name_rm'],
                        'name_m' => $this->_datas['model_type']['name_m']
                    );
                }

                $t[$i] = $ar;
            }
            $this->_datas['model_type'] = array('id' => $this->_datas['model_type']['id']) + $t;

            if ($this->_mode == -1 || $this->_mode == -3)
            {
                if (isset($this->_datas['all_models']))
                {
                    $this->_datas['popular_models'] = rand_it::randMas($this->_datas['all_models'], count($this->_datas['all_models']), '', $params['feed']);

                    $t = array();
                    foreach ($this->_datas['popular_models'] as $key => $model)
                        $t[$model['m_model_name']] = $key;

                    foreach ($t as $value)
                        $this->_datas['popular_m_models'][] = $this->_datas['popular_models'][$value];
                }
            }
        }
        //print_r($this->_datas);
    }

    protected function _answer($answer, $ret)
    {
        foreach ($answer as $key => $value)
        {
            if ($value && isset($ret[$key]))
                $ret[$key] = $value;
        }

        return $ret;
    }

    protected function _body($file_name, $accord)
    {
        $str = '';
        $file = __DIR__.'/pages/'.$accord.'/'.$file_name.'.php';
        if (file_exists($file))
        {
            ob_start();

            $all_page = false;
            //if ($this->_datas['setka_name'] == 'СЦ-5')
            //{
                if (file_exists($header_file = __DIR__.'/pages/'.$accord.'/header.php')
                    &&  file_exists($footer_file = __DIR__.'/pages/'.$accord.'/footer.php'))
                        $all_page = true;
                /*else
                {
                         if (file_exists($header_file = __DIR__.'/pages/'.$accord.'/header2.php')
                            &&  file_exists($footer_file = __DIR__.'/pages/'.$accord.'/footer2.php')
                             && ($this->_datas['setka_name'] == 'СЦ-1' && in_array(mb_strtolower($this->_datas['marka']['name']), array('htc', 'toshiba', 'dell', 'huawei'))))
                        $all_page = true;

                 } */
            //}
            $check_domen = preg_match('/^[a-z|\.]{0,}pomosch-komputernaya\.ru/',$this->_datas['realHost']);
            //if($check_domen && isset($this->_datas['admin']) && ($this->_datas['admin'][0]=='admin')){
            //if($this->_datas['realHost'] == 'tul.pomosch-komputernaya.ru'){
            if($check_domen){          
                $header_file = __DIR__.'/pages/'.$accord.'/pomosch-header.php';
                $footer_file = __DIR__.'/pages/'.$accord.'/pomosch-footer.php';
            }
            
            if (($this->_datas['setka_name'] == 'СЦ-5' || $this->_datas['setka_name'] == 'СЦ-5Б') && $this->_datas['arg_url'] == 'promo') 
            {
                $header_file = __DIR__.'/pages/'.$accord.'/header_new.php';
                $footer_file = __DIR__.'/pages/'.$accord.'/footer_new.php';
            }
            
            if ($all_page) include $header_file;

            include $file;

            if ($all_page) include $footer_file;

            //if ($this->_datas['site_name'] == 'ufa-sony.russupport.com')
               //$str = ob_get_contents();
            //else

            if ((!in_array($this->_datas['setka_name'], ['СЦ-5'])||!in_array($this->_datas['setka_name'], ['СЦ-5Б'])) && $this->_datas['site_name'] != 'centre.moscow')
              $str = preg_replace(array('/ {2,}/','/\t|(?:\r?\n[ \t]*)+/s'),array(' ',''), ob_get_contents());
            else
              $str = ob_get_contents();

            //$cache_file = '/var/www/www-root/data/www/studiof1-test.ru/cache/'.$this->_datas['site_name'].'/'.$this->_datas['arg_url'].'-text.cache';
            //tools::file_force_contents($cache_file, $this->_datas['vars2']);

            //$cache_file = '/var/www/www-root/data/www/studiof1-test.ru/cache/'.$this->_datas['site_name'].'/'.$this->_datas['arg_url'].'-h1.cache';
            //tools::file_force_contents($cache_file, $this->_ret['h1']);

            ob_end_clean();
        }

        //$file2 = '/var/www/www-root/data/www/studiof1-test.ru/lenovo-russia-title.csv';
        //file_put_contents($file2, .';'.$this->_ret['title'].PHP_EOL, FILE_APPEND | LOCK_EX);

        return $str;
    }

    // контекст
    protected function _createContext()
    {
        $context = new context($this);
        $context->createContext();
    }

    // получает синонимы
    protected function _get_syns($key, $ids)
    {
        if ($this->_datas['setka_name'] == 'СЦ-8' || $this->_datas['setka_name'] == 'СЦ-6') return array();

        $suffics = $this->_suffics;
        $site_id = $this->_site_id;
        $mode = $this->_mode;

        $join_table = $suffics.'_'.$key.'_syns';
        $join_field = $suffics.'_'.$key.'_syn_id';
        $id_field = $suffics.'_'.$key.'_id';

        switch ($mode)
        {
            case 1: case -1:

                $table_name = $suffics.'_'.$key.'_to_m_models';
                $ex = array('m_model_id' => $this->_datas['m_model_id'], 'site_id' => $site_id);
                $condition = "`m_model_id`=:m_model_id";

            break;

            case 3: case -3:

                $table_name = $suffics.'_'.$key.'_to_m_models';
                $ex = array('marka_id' => $this->_datas['marka_id'], 'model_type_id' => $this->_datas['model_type_id'], 'site_id' => $site_id);
                $condition = "`marka_id`=:marka_id AND `model_type_id`=:model_type_id";

            break;

            case 5: case -5:

                $table_name = $suffics.'_'.$key.'_to_m_models';
                $ex = array('sublineyka_id' => $this->_datas['sublineyka_id'], 'site_id' => $site_id);
                $condition = "`sublineyka_id`=:sublineyka_id";

            break;

            case 2: case -2:

                $table_name = $suffics.'_'.$key.'_to_models';
                $ex = array('model_id' => $this->_datas['model_id'], 'site_id' => $site_id);
                $condition = "`model_id`=:model_id";

            break;

            case 4:

                $table_name = $suffics.'_'.$key.'_to_models';
                $ex = array('site_id' => $site_id);
                $condition = "`model_id` IN (".implode(",", $this->_datas['all_models_ids']).")";

            break;
        }

        $sql = "SELECT `{$table_name}`.`type` as `type`, `{$join_table}`.`name` as `name`,
                    `{$table_name}`.`word` as `word`, `{$join_table}`.`{$id_field}` as `id` FROM `{$table_name}`
                INNER JOIN `{$join_table}` ON `{$table_name}`.`{$join_field}` = `{$join_table}`.`id`
                WHERE {$condition} AND `{$table_name}`.`site_id`=:site_id AND `{$join_table}`.`{$id_field}` IN (".implode(",", $ids).")";


        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute($ex);

        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    // получает контент
    protected function _get_vals($key, $ids)
    {
        if ($this->_datas['setka_name'] == 'СЦ-8' ||  $this->_datas['setka_name'] == 'СЦ-6') return array();
        if ($this->_datas['setka_name'] == 'СЦ-7' && $this->_mode == 4) return array();
        if ($this->_datas['setka_name'] == 'СЦ-7' && $key == 'complect') return array();

        $suffics = $this->_suffics;
        $site_id = $this->_site_id;
        $mode = $this->_mode;

        $syns = array();
        if (!(($this->_datas['setka_name'] == 'СЦ-2' || $this->_datas['setka_name'] == 'СЦ-2з') && $this->_mode == -3))
        {
            $syns = $this->_get_syns($key, $ids);
            $t = array();

            foreach ($syns as $syn)
                if ((integer) $syn['type'] == 3) $t[$syn['id']] = $syn['name'];
            $syns = $t;
        }

        $join_field = $suffics.'_'.$key.'_id';
        $models = array();

        switch ($mode)
        {
            case 1: case -1:

                $table_vals = $suffics.'_'.$key.'_model_vals';
                $ex = array('m_model_id' => $this->_datas['m_model_id'], 'site_id' => $site_id);
                $condition = "`m_model_id`=:m_model_id";

                $cond_model = "`m_models`.`id`=:m_model_id";

            break;

            case 3: case -3:

                $table_vals = $suffics.'_'.$key.'_model_vals';
                $ex = array('marka_id' => $this->_datas['marka_id'], 'model_type_id' => $this->_datas['model_type_id'], 'site_id' => $site_id);
                $condition = "`marka_id`=:marka_id AND `model_type_id`=:model_type_id";

                $cond_model = "`m_models`.`marka_id`=:marka_id AND `m_models`.`model_type_id`=:model_type_id";

            break;

            case 5: case -5:

                $table_vals = $suffics.'_'.$key.'_model_vals';
                $ex = array('sublineyka_id' => $this->_datas['sublineyka_id'], 'site_id' => $site_id);
                $condition = "`sublineyka_id`=:sublineyka_id";

                $cond_model = "`sublineykas`.`id`=:sublineyka_id";

            break;

            case 2: case -2:

                $table_vals = $suffics.'_'.$key.'_vals';
                $ex = array('model_id' => $this->_datas['model_id'], 'site_id' => $site_id);
                $condition = "`model_id`=:model_id";

            break;

            case 4:

                $table_vals = $suffics.'_'.$key.'_vals';
                $ex = array('site_id' => $site_id);
                $condition = "`model_id` IN (".implode(",", $this->_datas['all_models_ids']).")";

            break;
        }

        if (($mode == 1 || $mode == 3 || $mode == -1 || $mode == -3 || $mode == 5 || $mode == -5) && ($key == 'service' || $key == 'complect'))
        {
            $m_models_table = 'm_models';
            $m_models_link = 'm_model_id';

            if ($mode == 5 || $mode == -5)
            {
                $m_models_table = 'sublineykas';
                $m_models_link = 'sublineyka_id';
            }

            //все устройства
            $sql = "SELECT `models`.`id` as `id`, `models`.`name` as `name`, `{$m_models_table}`.`name` as `m_model_name`,
                    `{$m_models_table}`.`id` as `m_model_id` FROM `model_to_sites`
                    INNER JOIN `sites` ON `sites`.`id`=`model_to_sites`.`site_id`
                    INNER JOIN `models` ON `models`.`id`=`model_to_sites`.`model_id`
                    INNER JOIN `{$m_models_table}` ON `{$m_models_table}`.`id`=`models`.`{$m_models_link}`
                        WHERE {$cond_model} AND `model_to_sites`.`site_id`=:site_id ORDER BY `models`.`id` ASC LIMIT 0,30";

            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute($ex);
            $data = $stm->fetchAll(\PDO::FETCH_ASSOC);

            $this->_datas['all_models'] = $data;
            $this->_datas['all_models_ids'] = array();
            $this->_mode = 4;

            foreach ($data as $id)
                 $this->_datas['all_models_ids'][] = $id['id'];

            $mas = $this->_get_vals($key, $ids);

            foreach ($mas as $m)
                $models[$m[$join_field]][] = $m;

            $this->_mode = $mode;
        }

        $i = 0;
        $ret = array();

        // $groupBy = '';
        
        // if ($this->_datas['setka_name'] == 'СЦ-1' and $suffics == "p"){
            
        //     if($key == 'service'){
                $groupBy = ' GROUP BY '.$join_field;
        //     }elseif($key == 'defect'){
        //         $groupBy = ' GROUP BY p_defect_id ';
        //     }elseif($key == 'complect'){
        //         $groupBy = ' GROUP BY p_complect_id ';
        //     }
        // }


        if (($this->_datas['setka_name'] == 'СЦ-2' || $this->_datas['setka_name'] == 'СЦ-2з') && $this->_mode == -3)
        {
            $vals = tools::get_base($this->_suffics, $key);
            foreach ($vals as $k => $value)
                $vals[$k][$join_field] = $value['id'];
        }
        else
        {
            $sql = "SELECT * FROM `{$table_vals}` WHERE {$condition} AND `site_id`=:site_id AND `{$join_field}` IN (".implode(",", $ids).")".$groupBy.
                        " ORDER BY FIELD(`{$join_field}`, ".implode(",", $ids) .")";

            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute($ex);
            $vals = $stm->fetchAll(\PDO::FETCH_ASSOC);

        }

        // добавляем устройства
        foreach ($vals as $value)
        {
           $ret[$i] = array('name' => ((isset($syns[$value[$join_field]])) ? $syns[$value[$join_field]] : '')) + $value;
           if (isset($models[$value[$join_field]])) $ret[$i]['models'] = $models[$value[$join_field]];
           $i++;
        }

        if ($key == 'service' || $key == 'complect')
        {
            if ($this->_datas['setka_name'] != 'СЦ-7' || $key != 'service')
            {
                // находим минимальное
                foreach ($ret as $key => $value)
                {
                    if (!isset($value['models'])) continue;
                    $prices = array();

                    foreach ($value['models'] as $k => $v)
                        $prices[$k] = $v['price'];


                    $ret[$key]['min_model'] = $value['models'][array_search(min($prices), $prices)];
                    unset($ret[$key]['models']);

                    if (!$ret[$key]['name']) $ret[$key]['name'] = $ret[$key]['min_model']['name'];

                    foreach ($ret[$key]['min_model'] as $k => $v)
                    {
                        if (!isset($ret[$key][$k]) && $k != 'model_id') $ret[$key][$k] = $v;
                    }
                }
            }
            else
            {
                $table = $suffics.'_'.$key.'_costs';

                $sql = "SELECT `setka_id` FROM `sites`
                                WHERE `sites`.`id`=:site_id";
                $stm = pdo::getPdo()->prepare($sql);
                $stm->execute(array('site_id' => $site_id));
                $setka_id = $stm->fetchColumn();

                $sql = "SELECT * FROM `{$table}` WHERE `setka_id`=:setka_id AND `{$join_field}` IN (".implode(",", $ids).")
                        ORDER BY FIELD(`{$join_field}`, ".implode(",", $ids).")";

                $stm = pdo::getPdo()->prepare($sql);
                $stm->execute(array('setka_id' => $setka_id));

                $t = array();
                $mins = $stm->fetchAll(\PDO::FETCH_ASSOC);
                foreach ($mins as $min)
                    $t[$min[$join_field]] = $min;

                foreach ($ret as $key => $value)
                {
                    foreach ($t[$value[$join_field]] as $k => $v)
                       $ret[$key][$k] = $v;
                }
            }
        }

        return $ret;
    }

    protected function _find($key1, $key2, $id)
    {
        $suffics = $this->_suffics;
        $mode = $this->_mode;

        $table = $suffics.'_'.$key1.'_to_'.$key2.'s';
        $field1 = $suffics.'_'.$key1.'_id';
        $field2 = $suffics.'_'.$key2.'_id';

        if (pdo::getPdo()->query("SHOW TABLES LIKE '$table'")->rowCount() <= 0) return array();

        if (!is_array($id))
        {
            $sql = "SELECT `{$field1}` FROM `{$table}` WHERE `{$field2}`=:id";
            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array('id' => $id));
            $ids = $stm->fetchAll(\PDO::FETCH_COLUMN);
        }
        else
        {
            $sql = "SELECT `{$field1}` FROM `{$table}` WHERE `{$field2}` IN (".implode(',', $id).")";
            $ids = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN);
        }

        if ($ids)
            return $this->_get_vals($key1, $ids);
        else
            return array();
    }

    public static function _createTree($vars, $path)
    {
        $tree = new tree($path);
        $leaf = new leaf();

        foreach ($vars as $var)
        {
            $leaf->setVariants($var);
            $tree->addLeaf($leaf);
            $leaf = new leaf();
        }

        unset($leaf);
        return $tree->browse();
    }

     protected function _getRegion($region_id)
     {
        if ($region_id)
        {
            $sql = "SELECT * FROM `regions` WHERE `id`= ?";
            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array($region_id));
            return current($stm->fetchAll(\PDO::FETCH_ASSOC));
         }
        else
        {
             return array('id' => 0, 'name' => 'Москва', 'name_pe' => 'Москве', 'name_de' => 'Москве', 'name_re' => 'Москвы',
                'code' => '', 'geo_region' => 'MOW', 'translit1' => 'Moskva', 'translit2' => 'Moscow', 'translit3' => '', 'pril' => 'московском',
                            'pril_rp' => 'московского');
        }
     }

     protected function _getPartner($partner_id)
     {
        if ($partner_id)
        {
            $sql = "SELECT * FROM `partners` WHERE `id`= ?";
            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array($partner_id));
            return current($stm->fetchAll(\PDO::FETCH_ASSOC));
        }
        else
            return array();
    }

    protected function _getAddresis($setka_id, $marka_id)
    {
        $sql = "SELECT
            `partners`.`address1` as `address1`,
            `partners`.`address2` as `address2`,
            `regions`.`name` as `region_name`,
            `regions`.`name_pe` as `region_name_pe`,
            `sites`.`name` as `site`,
            `sites`.`id` as `site_id`,
            `sites`.`phone` as `phone`,
            `partners`.`time` as `time`,
            `partners`.`x` as `x`,
            `partners`.`y` as `y`,
            `partners`.`email` as `email`
        FROM `marka_to_sites`
        INNER JOIN `sites` ON `marka_to_sites`.`site_id` = `sites`.`id`
        INNER JOIN `partners` ON `partners`.`id` = `sites`.`partner_id`
        INNER JOIN `setkas` ON `setkas`.`id` = `sites`.`setka_id`
        LEFT JOIN `regions` ON `regions`.`id` = `sites`.`region_id`
            WHERE `setkas`.`id`=:setka_id AND `marka_to_sites`.`marka_id`=:marka_id ORDER BY `sites`.`id` ASC";

        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array('setka_id' => $setka_id, 'marka_id' => $marka_id));
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }
	
	protected function _getHabAddresis($setka_id, $name)
    {
        $sql = "SELECT
            `partners`.`address1` as `address1`,
            `partners`.`address2` as `address2`,
            `regions`.`name` as `region_name`,
            `regions`.`name_pe` as `region_name_pe`,
            `sites`.`name` as `site`,
            `sites`.`id` as `site_id`,
            `sites`.`phone` as `phone`,
            `partners`.`time` as `time`,
            `partners`.`x` as `x`,
            `partners`.`y` as `y`
        FROM `sites`
        INNER JOIN `partners` ON `partners`.`id` = `sites`.`partner_id`
        INNER JOIN `setkas` ON `setkas`.`id` = `sites`.`setka_id`
        LEFT JOIN `regions` ON `regions`.`id` = `sites`.`region_id`
            WHERE `setkas`.`id`=? AND `sites`.`servicename` LIKE ? ORDER BY `sites`.`id` ASC";

        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array($setka_id, $name));
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    protected function _getHabAddresisNotPlotter($setka_id, $tipeId) //#rat временное название
    {
        $sql = "SELECT
				`partners`.`name` AS `name`,
                `partners`.`address1` as `address1`,
                `partners`.`address2` as `address2`,
                `regions`.`name` as `region_name`,
                `regions`.`name_pe` as `region_name_pe`,
                `sites`.`name` as `site`,
                `sites`.`id` as `site_id`,
                `sites`.`phone` as `phone`,
                `partners`.`time` as `time`,
                `partners`.`x` as `x`,
                `partners`.`y` as `y`
            FROM `sites`
            INNER JOIN `partners` ON `partners`.`id` = `sites`.`partner_id`
            INNER JOIN `setkas` ON `setkas`.`id` = `sites`.`setka_id`
            LEFT JOIN `regions` ON `regions`.`id` = `sites`.`region_id`
            LEFT JOIN `type_to_sites` ON `sites`.`id` = `type_to_sites`.`site_id`
                WHERE `setkas`.`id`=?  
    				AND `type_to_sites`.type_id =?
    				ORDER BY `sites`.`id` ASC";

        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array($setka_id,$tipeId));
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    protected function _one_point($region_name, $setka_name)
    {
        $region_name = mb_strtolower($region_name);
        $setka_name = mb_substr($setka_name, mb_strpos($setka_name, '-') + 1);
        $str = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/sdek/tochkas_final.csv');
        $rows = explode(PHP_EOL, $str);
        $t = [];
        
        foreach ($rows as $cols)
        {
            $cols = explode(';', $cols);
            foreach ($cols as $key => $col)
                $cols[$key] = trim($col);
                
            $t[$cols[3]][mb_strtolower($cols[0])] = [$cols[1], $cols[2]];
        }
        return isset($t[$setka_name][$region_name]) ? $t[$setka_name][$region_name] : false;
    }
    
    protected function _points($city_original, $t_city)
    {
        foreach ($t_city as $key => $value)
            $t_city[$key] = "'".$city_original.", ".$value."'";

        $pdo = new \PDO('mysql:host='.$_ENV['CFG_DATA']['ip_s1'].';dbname='.$_ENV['CFG_DATA']['db']['service-3_gg']['db_name'].';charset=UTF8', $_ENV['CFG_DATA']['db']['service-3_gg']['slave_user']['user'], $_ENV['CFG_DATA']['db']['service-3_gg']['slave_user']['pass']);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $pdo->query("SET NAMES utf8");
        
        $sql = "SELECT `x`,`y`,`addres` FROM `sdek` WHERE `addres` IN (".implode(',',$t_city ).")";
        $address = $pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        $t = array();
        foreach ($address as $value)
            $t[$value['addres']] = array($value['x'], $value['y']);    
        
        $address = $t;
        
        $mas = array();
        $insert = array();
        
        foreach ($t_city as $value)
        { 
            $value = mb_substr($value, 1, -1);
            
            if (isset($address[$value]))
            {
                $mas[] = $address[$value];
            }
            else
            {
                $responce = file_get_contents('https://geocode-maps.yandex.ru/1.x/?format=json&apikey=e0d7d39d-e16c-4097-bad3-4a66985b01ad&geocode='.urlencode($value));
                $responce = json_decode($responce, true);
                
                if (isset($responce['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos']))
                {
                   $point = $responce['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'];
                   $point = explode(' ', $point);
                   
                   $insert[] = "('".$value."',".$point[0].",".$point[1].")";
                   $mas[] = $point;  
                }
            }
        }
        
        if ($insert)
        {
            $sql = "INSERT IGNORE INTO `sdek` (`addres`,`x`,`y`) VALUES ".implode(',', $insert);
            $pdo->query($sql);    
        }
        
        return $mas;   
    }

    protected function _footer_addresis($fix, $dop = 0)
    {
        $t = $fix;
        $count_fix = count($fix);
        $addresis = $this->_datas['addresis'];

        $diff = count($addresis) - $count_fix;
        if ($dop > $diff) $dop = $diff;

        $t_t = array();
        $t_array = array();

        $current_key = 0;
        $i = 0;

        foreach ($t as $k => $v)
            $t_array[$v] = array();

        foreach ($addresis as $value)
        {
           if (!$value['region_name']) $value['region_name'] = 'Москва';

           if (isset($t_array[$value['region_name']]))
           {
               $t_array[$value['region_name']] = $value;
               if ($value['site'] == $this->_datas['site_name']) $current_key = array_search($value['region_name'], $t);
           }
           else
           {
               $t_t[$i] = $value;
               if ($value['site'] == $this->_datas['site_name']) $current_key = $count_fix + $i;
               $i++;
           }
        }

        $count = count($t_t);
        $array = array();

        if ($current_key >= $count_fix)
            $k = $current_key - $count_fix;
        else
            $k = $current_key * $dop;

        for ($i = 0; $i < $dop; $i++)
        {
            if ($k == $count) $k = 0;
            $array[] = $t_t[$k];
            $k++;
        }

        return array_merge(array_values($t_array), $array);
    }

    // бежит по массиву и возвращает последовательно по столбцам случайные значения, проверяет на пустоту
    protected function checkarray($check)
    {
        $a = "";

        foreach ($check as $item)
        {
            $item_in = array_rand($item,1);
            if ($item[$item_in] != "")
            {
                $a .= $item[$item_in] . " ";
            }
        }

        return trim($a);
    }

    // выдаёт случайную запись
    protected function checkcolumn($check)
    {
        $a = "";

        $check_in = array_rand($check,1);
        if ($check[$check_in] != "")
        {
            $a .= $check[$check_in] . " ";
        }

        return trim($a);
    }

    // существует аналог tools::mb_ucfirst
    protected function firstup($line)
    {
        $first = mb_substr($line,0,1, 'UTF-8');//первая буква
        $last = mb_substr($line,1);//все кроме первой буквы
        $first = mb_strtoupper($first, 'UTF-8');
        //$last = mb_strtolower($last, 'UTF-8');
        return $first . $last;
    }

    // случайные записи массива
    public static function rand_arr($x,$y,$arr)
    {
        $rand = rand($x,$y);
        $arr_rand = array();

        for($i=0; $i<$rand; $i++)
        {
            $arr_rand_in = array_rand($arr,1);
            $arr_rand[] = $arr[$arr_rand_in];
            unset($arr[$arr_rand_in]);
        }
        return $arr_rand;
    }

    // обрабатываем массив типа (,,,) - выдаём в случайном порядке
    public static function rand_arr_str($mass)
    {
        $mass_new = array();
        $count_mass = count($mass);

        for($i=0;$i<$count_mass; $i++)
        {
            $rand_keys = array_rand($mass, 1);
            $mass_new[] = $mass[$rand_keys];
            unset($mass[$rand_keys]);
        }

        $str = "";
        foreach ($mass_new as $item)
        {
            $str .= $item . ", ";
        }
        $str = substr($str,0,-2);

        return $str;
    }

    abstract public function generate($answer, $params);
}
