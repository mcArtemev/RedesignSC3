<?

namespace framework\ajax\parse\hooks;

use framework\pdo;
use framework\tools;
use framework\rand_it;

class sc3_1 extends sc
{

    public $dbh = null;

    public function _sqlData($params) {

      $this->_datas = $this->_datas + $params;
      $this->_site_id = $params['site_id'];
      $this->_cache_mode = $params['cache_mode'];

      // dop
      $this->_datas['dop'] = sc::createDop($params['setka_id'], $params['feed']);

      // model
      if (isset($params['model_id']))
      {
          $stmt = $this->dbh->prepare("SELECT * FROM models WHERE models.id = ?");
          $stmt->execute([$params['model_id']]);
          $model = $stmt->fetch(\PDO::FETCH_ASSOC);

          $stmt = $this->dbh->prepare("SELECT * FROM m_models WHERE m_models.id = ?");
          $stmt->execute([$model['m_model_id']]);
          $m_model = $stmt->fetch(\PDO::FETCH_ASSOC);

          $params['model_type_id'] = $m_model['model_type_id'];
          $params['marka_id'] = $m_model['marka_id'];

          $this->_datas['model'] = $model;
          $this->_datas['m_model'] = $m_model;
      }

      // m_model
      if (isset($params['m_model_id']))
      {

          $stmt = $this->dbh->prepare("SELECT * FROM m_models WHERE m_models.id = ?");
          $stmt->execute([$params['m_model_id']]);
          $m_model = $stmt->fetch(\PDO::FETCH_ASSOC);

          $params['model_type_id'] = $m_model['model_type_id'];
          $params['marka_id'] = $m_model['marka_id'];

          $this->_datas['m_model'] = $m_model;
      }

      //service

      if (isset($params['service_id'])) {
        $stmt = $this->dbh->prepare("SELECT * FROM services WHERE id = ?");
        $stmt->execute([$params['service_id']]);
        $service = $stmt->fetch(\PDO::FETCH_ASSOC);

        $stmt = $this->dbh->prepare("SELECT * FROM services WHERE id != ? AND model_type_id = ?");
        $stmt->execute([$service['id'], $service['model_type_id']]);
        $otherServices = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $one = $two = [];
        foreach ($otherServices as $s) {
          if ($s['id'] > $service['id'])
            $one[] = $s;
          else
            $two[] = $s;
        }
        $this->_datas['other_services'] = array_merge($one, $two);

        $stmt = $this->dbh->prepare("SELECT complects.* FROM services_complects JOIN complects ON services_complects.complect_id = complects.id WHERE service_id = ?");
        $stmt->execute([$service['id']]);
        $complectsService = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $params['model_type_id'] = $service['model_type_id'];

        $this->_datas['service'] = $service;
        $this->_datas['complectsService'] = $complectsService;
        $this->_datas['price'] = $service['cost'];
        $this->_datas['syns'] = explode('@', $service['syns']);
        $syns = [$service['name']]+$this->_datas['syns'];

        if (count($this->_datas['syns']) < 4) {
          $synsCount = count($syns);
          $j = 0;
          for ($i = count($this->_datas['syns']); $i <= 4; $i++) {
            $this->_datas['syns'][$i] = $syns[$j++];
            if ($j >= $synsCount)
              $j = 0;
          }
        }
      }

      // complect

      if (isset($params['complect_id'])) {
        $stmt = $this->dbh->prepare("SELECT * FROM complects WHERE id = ?");
        $stmt->execute([$params['complect_id']]);
        $complect = $stmt->fetch(\PDO::FETCH_ASSOC);

        $stmt = $this->dbh->prepare("SELECT * FROM complects WHERE id != ? AND model_type_id = ?");
        $stmt->execute([$complect['id'], $complect['model_type_id']]);
        $otherComplects = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $one = $two = [];
        foreach ($otherComplects as $s) {
          if ($s['id'] > $complect['id'])
            $one[] = $s;
          else
            $two[] = $s;
        }
        $this->_datas['other_complects'] = array_merge($one, $two);

        $stmt = $this->dbh->prepare("SELECT services.* FROM services_complects JOIN services ON services_complects.service_id = services.id WHERE complect_id = ?");
        $stmt->execute([$complect['id']]);
        $servicesComplect = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $params['model_type_id'] = $complect['model_type_id'];

        $this->_datas['complect'] = $complect;
        $this->_datas['servicesComplect'] = $servicesComplect;
        $this->_datas['syns'] = explode('@', $complect['syns']);
        $syns = [$complect['name']]+$this->_datas['syns'];

        if (count($this->_datas['syns']) < 4) {
          $synsCount = count($syns);
          $j = 0;
          for ($i = count($this->_datas['syns']); $i <= 4; $i++) {
            $this->_datas['syns'][$i] = $syns[$j++];
            if ($j >= $synsCount)
              $j = 0;
          }
        }
      }

      if (isset($params['defect_id'])) {
        $stmt = $this->dbh->prepare("SELECT * FROM defects WHERE id = ?");
        $stmt->execute([$params['defect_id']]);
        $defect = $stmt->fetch(\PDO::FETCH_ASSOC);

        $stmt = $this->dbh->prepare("SELECT * FROM defects WHERE id != ? AND model_type_id = ?");
        $stmt->execute([$defect['id'], $defect['model_type_id']]);
        $otherDefects = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $one = $two = [];
        foreach ($otherDefects as $s) {
          if ($s['id'] > $defect['id'])
            $one[] = $s;
          else
            $two[] = $s;
        }
        $this->_datas['other_defects'] = array_merge($one, $two);

        $params['model_type_id'] = $defect['model_type_id'];

        $this->_datas['defect'] = $defect;
        $this->_datas['syns'] = explode('@', $defect['syns']);
        $this->_datas['reasons'] = explode('@', $defect['reasons']);
        srand($this->_datas['defect']['id']);
        shuffle($this->_datas['reasons']);
        $this->_datas['reasons'] = array_slice($this->_datas['reasons'], 0, rand(4,6));
        srand();
        $syns = [$defect['name']]+$this->_datas['syns'];

        if (count($this->_datas['syns']) < 4) {
          $synsCount = count($syns);
          $j = 0;
          for ($i = count($this->_datas['syns']); $i <= 4; $i++) {
            $this->_datas['syns'][$i] = $syns[$j++];
            if ($j >= $synsCount)
              $j = 0;
          }
        }
      }

      if (isset($params['marka_id'])) {
        $sql = "SELECT * FROM `markas` WHERE `id`= ?";
        $stm = $this->dbh->prepare($sql);
        $stm->execute(array($params['marka_id']));
        $this->_datas['marka'] = current($stm->fetchAll(\PDO::FETCH_ASSOC));

        $stmt = $this->dbh->prepare("SELECT `model_types`.`name` as `type`, `model_types`.`id` as `type_id`,
                `model_types`.`name_re` as `type_re`, `model_types`.`name_rm` as `type_rm`,
                `model_types`.`name_m` as `type_m` FROM `m_models` INNER JOIN `model_types` ON `m_models`.`model_type_id` = `model_types`.`id`
                WHERE m_models.marka_id = ? GROUP BY model_types.id");
        $stmt->execute([$this->_datas['marka']['id']]);
        $this->_datas['all_devices'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
      }

      if (isset($params['model_type_id'])) {
        $sql = "SELECT * FROM `model_types` WHERE `id`= ?";
        $stm = $this->dbh->prepare($sql);
        $stm->execute(array($params['model_type_id']));
        $this->_datas['model_type'] = current($stm->fetchAll(\PDO::FETCH_ASSOC));
        $suffics = [
          'ноутбук' => 'n',
          'планшет' => 'p',
          'смартфон' => 'f',
        ];
        $this->_suffics = $suffics[$this->_datas['model_type']['name']];
      }

      foreach (array('name', 'name_re', 'name_rm', 'name_de', 'name_dm', 'name_m') as $name)
      {
          if (!$this->_datas['model_type'][$name.'_syn'])
             $this->_datas['model_type'][$name.'_syn'] = $this->_datas['model_type'][$name];
          else
             $this->_datas['orig_model_type'][1][$name] = $this->_datas['model_type'][$name.'_syn'];

          $this->_datas['orig_model_type'][0][$name] = $this->_datas['model_type'][$name];
      }

      // vsemodeli
      $vsemodeli = array();
      $ru_vsemodeli = array();
      $vsemodeli_id = array();

      // $sql = "SELECT `m_models`.`name` as `name`,`m_models`.`ru_name` as `ru_name`,
      //         `m_models`.`id` as `id` FROM `m_model_to_sites`
      //     INNER JOIN `sites` ON `sites`.`id`=`m_model_to_sites`.`site_id`
      //     INNER JOIN `m_models` ON `m_models`.`id`=`m_model_to_sites`.`m_model_id`
      //         WHERE `m_models`.`marka_id`= ? AND `m_models`.`brand` = 1 AND `m_model_to_sites`.`site_id` = ? AND `m_models`.`model_type_id` = ?";
      //
      // $stm = $this->dbh->prepare($sql);
      // $stm->execute(array($params['marka_id'], $params['site_id'], $params['model_type_id']));
      // $data = $stm->fetchAll(\PDO::FETCH_ASSOC);
      //
      // foreach ($data as $value)
      // {
      //     $vsemodeli[] = $value['name'];
      //     $ru_vsemodeli[] = $value['ru_name'];
      //     $vsemodeli_id[] = $value['id'];
      // }

      $this->_datas['vsemodeli_array'] = $vsemodeli;
      $this->_datas['vsemodeli'] = implode(', ', $vsemodeli);
      $this->_datas['ru_vsemodeli'] = implode(', ', $ru_vsemodeli);
      $this->_datas['vsemodeli_id'] = $vsemodeli_id;


      if (isset($params['marka_id']) && isset($params['model_type_id'])) {
        // img
        $sql = "SELECT `url` FROM `imgs` WHERE `site_id` = ? AND `marka_id`= ? AND `model_type_id` = ?";
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array($this->_site_id, $params['marka_id'], $params['model_type_id']));
        $this->_datas['img']  = $stm->fetchColumn();
      }

      if (isset($params['geo_id']))
      {

          $stmt = $this->dbh->prepare("SELECT * FROM geo WHERE id = ?");
          $stmt->execute([$params['geo_id']]);
          $geo = $stmt->fetch(\PDO::FETCH_ASSOC);

          $this->_datas['geo'] = $geo;
      }

    }

    public function generate($answer, $params)
    {

        $this->dbh = pdo::getPdo(3);
        
        $sql =  "SELECT `model_types`.`name` as `type`, `model_types`.`id` as `type_id`,
                `model_types`.`name_re` as `type_re`, `model_types`.`name_rm` as `type_rm`,
                `model_types`.`name_m` as `type_m` FROM `m_models`
            INNER JOIN `model_types` ON `m_models`.`model_type_id` = `model_types`.`id` GROUP BY `model_types`.`name`";
        $stm = $this->dbh->prepare($sql);
        $stm->execute(array($params['site_id']));
        $this->_datas['all_devices'] = $this->_datas['all_devices_site'] = $stm->fetchAll(\PDO::FETCH_ASSOC);
   
        $images = array(
                "ceny" => array("ceny.jpg"),
                "o_nas" => array("o nas.jpg", "o kompanii msk.jpg", "o servise.jpg", "o servise msk.jpg", "o kompanii.jpg"),
                "diagnostika" => array("diagnostika msk.jpg", "testirovanie.jpg", "diagnostika.jpg"),
                "dostavka" => array("dostavka.jpg", "dostavka msk.jpg"),
                "komplektuyushie" => array("komplektuyushchie msk.jpg", "komplektuyushchie.jpg"),
                "kontakty" => array("kontakty.jpg", "kontakty msk.jpg"),
                "vakansii" => array("vakansii msk.jpg", "vakansii.jpg", "vakansii mastera.jpg"),
                "neispravnosti" => array("neispravnosti.jpg", "neispravnosti msk.jpg"),
        );

        srand(tools::gen_feed($params['site_name']));
        foreach ($images as $key => $value)
            $this->_datas['images'][$key] = $value[rand(0, count($value)-1)];

        //region
        $this->_datas['region'] = $this->_getRegion($params['region_id']);
        if ($this->_datas['region']['translit3']) $this->_datas['region']['translit1'] = $this->_datas['region']['translit3'];

        // partner
        $this->_datas['partner'] = $this->_getPartner($params['partner_id']);
        
        $this->_datas['wide'] = 0;

        //menu
        $this->_datas['menu_header'] = array(
                '/ceny/' => 'Цены',
                '/o_nas/' => 'О сервисе',
                '/kontakty/' => 'Контакты',
        );

        $this->_datas['menu_footer'] = array(
            '/diagnostika/' => 'Диагностика',
            '/komplektuyushie/' => 'Комплектующие',
            '/neispravnosti/' => 'Неисправности',
            '/dostavka/' => 'Доставка',
            '/vakansii/' => 'Вакансии',
            '/kontakty/' => 'Контакты',
        );

        if (isset($params['static']) || isset($params['sitemap']))
        {
            if (isset($params['static'])) {
              $file_name = ($params['static'] == '/') ? 'index' : $params['static'];
            }
            else {
              $file_name = 'sitemap';
            }

            if (in_array($this->_datas['region']['name'], ['Новосибирск', 'Нижний Новгород', 'Екатеринбург', 'Казань', 'Санкт-Петербург', 'Москва']) && isset($params['marka_id'])) {
            
              $stmt = $this->dbh->prepare("SELECT `model_types`.`name` as `type`, `model_types`.`id` as `type_id`,
                      `model_types`.`name_re` as `type_re`, `model_types`.`name_rm` as `type_rm`,
                      `model_types`.`name_m` as `type_m` FROM `m_models` INNER JOIN `model_types` ON `m_models`.`model_type_id` = `model_types`.`id`
                      WHERE m_models.marka_id = ? GROUP BY model_types.id");
              $stmt->execute([$params['marka_id']]);
              $this->_datas['all_devices'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }

            if ($file_name)
            {
                $this->_datas = $this->_datas + $params;                
        
                if (!isset($params['marka_id'])) $params['marka_id'] = 0;//редактировал Антон, заменил 1 на 0 чтобы не получать sony если мы не находимся на странице брэенда
                if (isset($params['marka_id'])){
                  $sql = "SELECT * FROM `markas` WHERE `id`= ?";
                  $stm = $this->dbh->prepare($sql);
                  $stm->execute(array($params['marka_id']));
                  $this->_datas['marka'] = current($stm->fetchAll(\PDO::FETCH_ASSOC));
                }                
                             
                $marka_lower = mb_strtolower($this->_datas['marka']['name']);
                
                
                $this->_make_accord_table($marka_lower);

                if ($file_name == 'sitemap') {
                  $this->_datas['addresis'] = $this->_getAddresis($params['setka_id'], 1);

                  $this->sitemap($params['sitemap']);
                  
                  $this->_sdek();

                  $body = $this->_body('sitemap', basename(__FILE__, '.php'));
                  return array('body' => $body);
                }
                else if ($file_name != 'indexSite') {

                  $text = array();
                  $feed = $this->_datas['feed'];

                  //gen
                  $text['komplektuyushie']['name'] = array('Качественные комплектующие для техники '.$this->_datas['marka']['name']);

                  $text['komplektuyushie']['text'][] = array('Оригинальные', 'Фирменные');

                  srand($feed);
                  $choose = rand(0, 1);

                  switch ($choose)
                  {
                      case 0:
                           $text['komplektuyushie']['text'][] = array('комплектующие','детали');
                      break;
                      case 1:
                           $text['komplektuyushie']['text'][] = array('запчасти', 'запасные части');
                      break;
                  }

                  $text['komplektuyushie']['text'][] = array('всегда в наличии,', 'в наличии,');
                  $text['komplektuyushie']['text'][] = array('возможность персонального дозаказа', 'возможнен индивидуальный заказ');

                  $t_array = array();

                  $t_array[] = array('комплектующих', 'деталей');
                  $t_array[] = array('запчастей', 'запасных частей');

                  $text['komplektuyushie']['text'][] = $t_array[!$choose];

                  $text['neispravnosti']['name'] = array('Ремонт любых неисправностей', 'Ремонт любой сложности');
                  $text['neispravnosti']['text'][] = array('В наших мастерских', 'В наших лабораториях');
                  $text['neispravnosti']['text'][] = array('производится', 'проводится');
                  $text['neispravnosti']['text'][] = array('ремонт');
                  $text['neispravnosti']['text'][] = array('аппаратов '.(isset($this->_datas['marka']['name']) ? $this->_datas['marka']['name'] : ''), 'техники'); // (isset($this->_datas['marka']['name']) ? $this->_datas['marka']['name'] : '')
                  $text['neispravnosti']['text'][] = array('любого уровня сложности', 'любой сложности', 'любой степени сложности');

                  $text['dostavka']['name'] = array('Доставка вашей техники', 'Доставка техники');
                  $text['dostavka']['text'][] = array('Чтобы вернуть в строй', 'Чтобы отремонтировать', 'Чтобы починить');
                  $text['dostavka']['text'][] = array('вашу технику', 'ваш аппарат', 'ваш гаджет', 'ваш девайс');
                  $text['dostavka']['text'][] = array('не обязательно', 'совсем не обязательно');
                  $text['dostavka']['text'][] = array('выходить из дома', 'приезжать в сервис');

                  $choose = rand(0, 1);

                  switch ($choose)
                  {
                      case 0:
                          $text['diagnostika']['name'] = array('Диагностика, техзаключение');
                      break;
                      case 1:
                          $text['diagnostika']['name'] = array('Срочная диагностика');
                      break;
                      case 2:
                          $text['diagnostika']['name'] = array('Экспресс диагностика');
                      break;
                  }

                  $t_array = array('Программная диагностика', 'Срочная диагностика', 'Экспресс диагностика');
                  if ($choose == 1 || $choose == 2)
                  {
                      unset($t_array[$choose]);
                      $t_array = array_values($t_array);
                  }

                  $text['diagnostika']['text'][] = $t_array;
                  $text['diagnostika']['text'][] = array('в лаборатории', 'в техлаборатории', 'в мастерской');
                  $text['diagnostika']['text'][] = array('от 15 минут,');
                  $text['diagnostika']['text'][] = array('аппаратное');
                  $text['diagnostika']['text'][] = array('тестирование');
                  $text['diagnostika']['text'][] = array('техники', 'устройств');
                  $text['diagnostika']['text'][] = array('от 30 минут');

                  $h2_preim = 'Преимущества нашего специализированного сервиса';

                  if (isset($text[$file_name]))
                      unset($text[$file_name]);

                  if ($file_name == 'o_nas')
                  {
                      $h2_preim = tools::get_rand(array('Нам можно доверять', $this->_datas['servicename'].'  - нам можно доверять'), $feed);
                      unset($text['neispravnosti']);
                  }

                  $preim = array();
                  $preims = array();

                  //print_r($text);

                  foreach ($text as $key => $value)
                  {
                      $count = count($value['text']);

                      $oldKey = $key;
                      if (isset($this->_datas['marka']))
                        $newKey = $key != 'dostavka' ? str_replace('komplektuyushie', 'zapchasti', $key).'_'.mb_strtolower($this->_datas['marka']['name']) : $key;
                      else
                        $newKey = $key;
                      $text[$newKey] = $text[$key];
                      if ($newKey != $oldKey) unset($text[$key]);
                      $key = $newKey;

                      $url = ($this->_datas['arg_url'] != '/') ? '/'.$this->_datas['arg_url'].'/' : '/';
                      $urls = !in_array($url, ['/o_nas/', '/dostavka/']);

                      foreach ($text[$key]['text'][0] as $k => $v)
                      {
                          $text[$key]['text'][0][$k] = '<div class="preimitem"><a class="preimimage" '.($urls ? 'href="/'.$key.'/"' : '').'><img src="/templates/moscow/img/shared/'.$oldKey.'.png">
                              </a><div class="preimtext"><div class="preimname">'.tools::get_rand($value['name'], $feed).'</div><div class="preiman">'.$v;

                      }

                      foreach ($text[$key]['text'][$count-1] as $k => $v)
                      {
                          $text[$key]['text'][$count-1][$k] .= '</div>'.($urls ? '<a href="/'.$key.'/" class="preimbtn">Подробнее</a>' : '').'</div></div>';
                      }

                      $preim[] = $text[$key]['text'];
                  }

                  $preims = rand_it::randMas($preim, 3, '', $feed);

                  $this->_datas['preims'] = '<div class="preimrow"><div class="container"><h2>'.$h2_preim.'</h2><div class="preimlist col3">';

                  foreach ($preims as $var)
                      $this->_datas['preims'] .= sc::_createTree($var, $feed);

                  $this->_datas['preims'] .= '</div></div></div>';
                }

                $url = ($this->_datas['arg_url'] != '/') ? '/'.$this->_datas['arg_url'].'/' : '/';
                                
                switch ($file_name)
                {

                    //!
                    case 'neispravnosti':
                       $title = 'Типовые неисправности устройств '.$this->_datas['marka']['name']. ' | '.$params['servicename'].' '.$this->_datas['region']['translit1'];
                       $description = 'Популярные виды неисправностей - от разбитых стекол до перепайки сгоревших BGA-чипов.';
                       $h1 = 'Ремонт любых неисправностей '.$this->_datas['marka']['name'];

                       $column = array_column($this->_datas['all_devices'], 'type_id');
                       
                       if ($column)
                       {
                            $stmt = $this->dbh->query("SELECT * FROM defects WHERE model_type_id IN (".implode(',', $column).")");
                            $this->_datas['all_defects'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                       }
                    break;
                    //!
                    case 'komplektuyushie':
                       $title = 'Детали, запчасти и комплектующие для устройств '.$this->_datas['marka']['name'].' | '.$params['servicename'].' '.$this->_datas['region']['translit1'];
                       $description = 'Условия установки и продажи комплектующих в лаборатории '.$params['servicename'].', гарантия на устанавливаемые запасные части.';
                       $h1 = 'Качественные комплектующие для '.$this->_datas['marka']['name'];
                        
                       $column = array_column($this->_datas['all_devices'], 'type_id');
                       
                       if ($column)
                       { 
                           $stmt = $this->dbh->query("SELECT * FROM complects WHERE model_type_id IN (".implode(',', $column).")");
                           $this->_datas['all_complects'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                       }
                    break;
                    //!
                    case 'diagnostika':
                       $title = 'Диагностика техники '.$this->_datas['marka']['ru_name'].' в '.$params['servicename'].' '.$this->_datas['region']['translit1'];
                       $description = 'Условия диагностики аппаратов '.$this->_datas['marka']['name'].' в сервисном центре '.$params['servicename'].' и на выезде к заказчику.';
                       $h1 = 'Срочная диагностика '.$this->_datas['marka']['name'];;
                       
                       $column = array_column($this->_datas['all_devices'], 'type_id');
                        
                       if ($column)
                       {
                           $stmt = $this->dbh->query("SELECT * FROM services WHERE model_type_id IN (".implode(',', $column).")");
                           $this->_datas['all_services'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                       } 
                    break;
                    //!
                    case 'kontakty':
                        $title = 'Контакты сервисного центра '.$params['servicename'].' '.$this->_datas['region']['translit1'];
                        $description = 'Телефон, адрес и схема проезда к сервисному центру '.$params['servicename'].'. Обращайтесь по вопросам сотрудничества или запишитесь на ремонт!';
                        $h1 = 'Контакты';
                    break;
                    //!
                    case 'o_nas':
                         $title = 'История компании '.mb_strtoupper($params['servicename'].' '.$this->_datas['region']['translit1']).': мы гордимся нашими мастерами и качеством работы';
                         $description = 'Награды и сертификаты, заслуженные высококвалифицированными специалистами сервисного центра '.$params['servicename'];
                         $h1 = 'О сервисе';
                    break;
                    //!
                    case 'dostavka':
                        $title = 'Доставка сервисного центра '.$params['servicename'].' '.$this->_datas['region']['translit1'];
                        if (!$params['region_id'])
                            $description = 'Условия выезда курьерской службы '.$params['servicename'].' по Москве и за пределы МКАД в ближайшее Подмосковье.';
                        else
                            $description = 'Условия выезда курьерской службы '.$params['servicename'].' по '.$this->_datas['region']['name_de'].' и в ближайшие города.';
                        $h1 = 'Доставка вашей техники';
                    break;
                    //!
                    case 'vakansii':
                        $title = 'Вакансии '.$params['servicename'].' '.$this->_datas['region']['translit1'];
                        $description = 'Открытые вакансии сервисного центра '.$params['servicename'].', требования к кандидатам. Условия работы в сервисном центре '.$params['servicename'].'.';
                        $h1 = 'Вакансии';
                    break;
                    //!
                    case 'index': //devices
                        $title = $params['servicename'].' - сервисный центр по ремонту '.$this->_datas['marka']['name'].' в '.$this->_datas['region']['name_pe'];
                        $description = 'Официальный сервис по ремонту мобильной техники '.$this->_datas['marka']['name'].'. Ноутбуки, планшеты и другие устройства. Гарантия до 1 года. Оригинальные комплектующие. Доставка по '.$this->_datas['region']['name_de'].'.';
                        $h1 = 'Сервисный центр '.mb_strtoupper($this->_datas['marka']['name']);
                    break;
                    //!
                    case 'ceny': //devices
                        $title = 'Цены на ремонт техники '.mb_strtoupper($this->_datas['marka']['ru_name']).' в сервисе '.$params['servicename'].' '.$this->_datas['region']['translit1'];
                        $description = 'Прейскурант и время на ремонт смартфонов, ноутбуков, планшетов и моноблоков '.$this->_datas['marka']['name'].' в сервисном центре '.$params['servicename'].'.';
                        $h1 = 'Цены на ремонт '.$this->_datas['marka']['name'];
                        
                        $column = array_column($this->_datas['all_devices'], 'type_id');
                        
                        if ($column)
                        {
                            $stmt = $this->dbh->query("SELECT * FROM services WHERE model_type_id IN (".implode(',',$column).")");
                            $this->_datas['all_services'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                        }
                    break;

                    case 'indexSite':
                        $title = '1';
                        $description = '1';
                        $h1 = '1';

                        $this->_ret['title'] = $title;
                        $this->_ret['h1'] = $h1;
                        $this->_ret['description'] = $description;

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
                        FROM `partners`
                        JOIN sites ON `partners`.`id` = `sites`.`partner_id`
                        INNER JOIN `setkas` ON `setkas`.`id` = `sites`.`setka_id`
                        LEFT JOIN `regions` ON `regions`.`id` = `sites`.`region_id`
                            WHERE sites.id IN (29, 413, 426, 439, 452, 864) GROUP BY region_name ORDER BY `sites`.`id` ASC";

                        $stm = pdo::getPdo()->prepare($sql);
                        $stm->execute(array($params['setka_id']));
                        $this->_datas['addresis'] = $stm->fetchAll(\PDO::FETCH_ASSOC);
                        
                        $this->_sdek();
                        
                        return array('body' => $this->indexSite());
                    break;
                    
                    default:
                        
                        foreach ($this->_datas['add_device_type'] as $key => $value)
                        {
                            if (mb_strpos($this->_datas['arg_url'], $key) !== false)
                            {
                                $gadget = $value;
                                break;        
                            }    
                        }
                        
                        $this->_datas['gadget'] = $gadget; 
                                                
                        $title = 'Ремонт '.$gadget['type_rm'] .' ' . $this->_datas['marka']['name']. ' в '.$params['servicename'].' в '. $this->_datas['region']['name_pe'];                        
                        $description = 'Официальный сервис по ремонту  '.$this->_datas['marka']['name'].' '.$gadget['type_rm'] .'. Гарантия до 1 года. Оригинальные комплектующие. Доставка по '.$this->_datas['region']['name_de'].'.';
                        $h1 = 'Ремонт '. $gadget['type_rm']  .' ' . $this->_datas['marka']['name'];

                        $file_name = 'gadget';
                }

                // addresis
                $this->_datas['addresis'] = $this->_getAddresis($params['setka_id'], 1);

                $this->_ret['title'] = $title;
                $this->_ret['h1'] = $h1;
                $this->_ret['description'] = $description;
                
                $this->_sdek();

                $body = $this->_body($file_name, basename(__FILE__, '.php'));
                return array('body' => $body);
            }
        }

        $level = false;

        if (isset($params['model_type_id']))
        {
            if (is_array($params['model_type_id']))
            {
                //$this->_sqlLevelData($params);
                $level = true;
                return false;
            }
        }

        //if (!(isset($params['marka_id']) && isset($params['model_type_id'])))
            //return false;

        //$this->datas['marka_id'] = $params['marka_id'];

        $this->_sqlData($params);
        
        $this->_make_accord_table(mb_strtolower($this->_datas['marka']['name']));

        // addresis
        $this->_datas['addresis'] = $this->_getAddresis($params['setka_id'], 1);

        $ret = array();

        $file_name = '';

        if (isset($params['model_type_id']) && isset($params['marka_id']) && isset($params['geo_id'])) {
          $ret['title'] = array(
              'Ремонт '.$this->_datas['model_type']['name_rm'].' '.$this->_datas['marka']['name'].': '.$this->_datas['geo']['name'].', '.$this->_datas['region']['name'].' - цена снижена, быстрое устранение любых поломок, замена неисправных комплектующих – используем оригинальные запчасти, срочный ремонт, выезд специалиста',
          );

          $ret['h1'] = array(
             'Ремонт '.$this->_datas['model_type']['name_rm'].' '.$this->_datas['marka']['name'].' - '.$this->_datas['geo']['name'].', '.$this->_datas['region']['name'],
          );

          $ret['description'] = array(
              'Ремонт '.$this->_datas['model_type']['name_rm'].' '.$this->_datas['marka']['name'].' в '.$this->_datas['region']['name_pe'].', '.$this->_datas['geo']['name'].' - гарантия: квалифицированные специалисты, оригинальные запчасти, срочный ремонт, выезд мастера на дом. Бесплатное выявление неисправности, быстрый ремонт. Прайс лист на все услуги на сайте.',
          );

          $ret['plain'] = array(
            'Нужен ремонт '.$this->_datas['model_type']['name_rm'].' '.$this->_datas['marka']['name'].' по адресу '.$this->_datas['region']['name'].', '.$this->_datas['geo']['name'].'? Ремонт в сервисном центре '.$this->_datas['servicename'].' это не только: замена системных плат и модулей GPS, ремонт WI-FI модулей и микрофонов, перепайка контроллеров и цепей питания, но и индивидуальный подход к проблемам и неисправностям каждого владельца '.$this->_datas['model_type']['name_re'].' '.$this->_datas['marka']['ru_name'].'. Отлаженная работа курьерской службы дает нам возможность принимать на ремонт аппараты со всех районов '.$this->_datas['region']['name_re'].', включая '.$this->_datas['geo']['name'].', за специалистами курьерской службы закреплены популярные метро - это позволяет добираться за 25-40 минут в любую точку города. В пределах МКАД выезжаем бесплатно.',
          );

          $stmt = $this->dbh->prepare("SELECT * FROM services WHERE model_type_id = ?");
          $stmt->execute([$this->_datas['model_type']['id']]);

          $this->_datas['all_services'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

          $minCost = null;
          foreach (array_column($this->_datas['all_services'], 'cost') as $cost) {
            if ($cost > 0 && ($cost < $minCost || is_null($minCost)))
              $minCost = $cost;
          }
          $this->_datas['price'] = $minCost;

          $stmt = $this->dbh->prepare("SELECT * FROM complects WHERE model_type_id = ?");
          $stmt->execute([$this->_datas['model_type']['id']]);

          $this->_datas['all_complects'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

          foreach ($this->_datas['all_complects'] as $i=>$complect) {
            $this->_datas['all_complects'][$i]['price'] = $this->costComplect($complect['costs'], $complect['id']);
          }

          $this->_mode = 112;
          $file_name = 'geo-type';
        }
        else if (isset($params['model_type_id']) && isset($params['geo_id'])) {
          $ret['title'] = array(
              'Ремонт '.$this->_datas['model_type']['name_rm'].': '.$this->_datas['geo']['name'].', '.$this->_datas['region']['name'].' - цена снижена, быстрое устранение любых поломок, замена неисправных комплектующих – используем оригинальные запчасти, срочный ремонт, выезд специалиста',
          );

          $ret['h1'] = array(
             'Ремонт '.$this->_datas['model_type']['name_rm'].' - '.$this->_datas['geo']['name'].', '.$this->_datas['region']['name'],
          );

          $ret['description'] = array(
              'Ремонт '.$this->_datas['model_type']['name_rm'].' в '.$this->_datas['region']['name_pe'].', '.$this->_datas['geo']['name'].' - гарантия: квалифицированные специалисты, оригинальные запчасти, срочный ремонт, выезд мастера на дом.',
          );

          $ret['plain'] = array(
            'Нужен ремонт '.$this->_datas['model_type']['name_rm'].' по адресу '.$this->_datas['region']['name'].', '.$this->_datas['geo']['name'].'? Ремонт в сервисном центре '.$this->_datas['servicename'].' это не только: замена системных плат и модулей GPS, ремонт WI-FI модулей и микрофонов, перепайка контроллеров и цепей питания, но и индивидуальный подход к проблемам и неисправностям каждого владельца '.$this->_datas['model_type']['name_re'].'. Отлаженная работа курьерской службы дает нам возможность принимать на ремонт аппараты со всех районов '.$this->_datas['region']['name_re'].', включая '.$this->_datas['geo']['name'].', за специалистами курьерской службы закреплены популярные метро - это позволяет добираться за 25-40 минут в любую точку города. В пределах МКАД выезжаем бесплатно.',
          );

          $stmt = $this->dbh->prepare("SELECT * FROM services WHERE model_type_id = ?");
          $stmt->execute([$this->_datas['model_type']['id']]);

          $this->_datas['all_services'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

          $minCost = null;
          foreach (array_column($this->_datas['all_services'], 'cost') as $cost) {
            if ($cost > 0 && ($cost < $minCost || is_null($minCost)))
              $minCost = $cost;
          }
          $this->_datas['price'] = $minCost;

          $stmt = $this->dbh->prepare("SELECT * FROM complects WHERE model_type_id = ?");
          $stmt->execute([$this->_datas['model_type']['id']]);

          $this->_datas['all_complects'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

          foreach ($this->_datas['all_complects'] as $i=>$complect) {
            $this->_datas['all_complects'][$i]['price'] = $this->costComplect($complect['costs'], $complect['id']);
          }

          $this->_mode = 111;
          $file_name = 'geo-type';
        }
        else if (isset($params['marka_id']) && isset($params['service_id'])) {

                      if (isset($this->_datas['service']['title']) && trim($this->_datas['service']['title']) != '') {
                        $ret['title'] = [$this->_datas['service']['title']];
                      }
                      else {
                        $ret['title'] = array(
                              tools::mb_firstupper($this->_datas['syns'][0]),
                              $this->_datas['model_type']['name_re'],
                              $this->_datas['marka']['ru_name'],
                              'в',
                              $this->_datas['servicename'],
                              'в',
                              $this->_datas['region']['name_pe']
                          );

                          if (isset($this->_datas['price']))
                          {
                              $ret['title'][] = 'от';
                              $ret['title'][] = $this->_datas['price'];
                              $ret['title'][] = 'руб';
                          }
                        }

                        if (isset($this->_datas['service']['h1']) && trim($this->_datas['service']['h1']) != '') {
                          $ret['h1'] = [$this->_datas['service']['h1']];
                        }
                        else {
                          $ret['h1'] = array(
                              tools::mb_firstupper($this->_datas['syns'][1]),
                              $this->_datas['model_type']['name_rm'],
                              $this->_datas['marka']['name']
                          );
                        }

                        $ret['description'] = array(
                            tools::mb_firstupper($this->_datas['syns'][2]),
                            $this->_datas['marka']['ru_name'],
                            $this->_datas['ru_vsemodeli'].'.',
                            $this->_datas['dop']
                        );

                    $this->prepareSeo($ret);

                    $this->_mode = 3;
                    $file_name = 'model-service';

      }
      else if (isset($params['marka_id']) && isset($params['complect_id'])) {

                        $ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0]),
                            $this->_datas['model_type']['name_rm'],
                            $this->_datas['marka']['ru_name'],
                            'в',
                            $this->_datas['servicename'],
                            $this->_datas['region']['translit1']

                        );

                        if (isset($this->_datas['price']))
                        {
                            $ret['title'][] = 'от';
                            $ret['title'][] = $this->_datas['price'];
                            $ret['title'][] = 'руб';
                        }

                        $ret['h1'] = array(
                            tools::mb_firstupper($this->_datas['syns'][1]),
                            $this->_datas['model_type']['name_rm'],
                            $this->_datas['marka']['name']
                        );

                        $ret['description'] = array(
                            tools::mb_firstupper($this->_datas['syns'][2]),
                            $this->_datas['marka']['name'],
                            $this->_datas['vsemodeli'].'.',
                            $this->_datas['dop']
                        );

                    $this->_mode = 3;
                    $file_name = 'model-complect';

        }
        else if (isset($params['marka_id']) && isset($params['defect_id'])) {

          $count = count($this->_datas['reasons']);

          $ret['title'] = array(
              tools::mb_firstupper($this->_datas['syns'][0]),
              $this->_datas['marka']['ru_name'],
              '—',
              $count,
              tools::declOfNum($count, array('причина', 'причины', 'причин'), false),
              'поломки',
              $this->_datas['model_type']['name_re'],
              '|',
              $this->_datas['servicename'],
              $this->_datas['region']['translit1']
          );

          $ret['h1'] = array(
              tools::mb_firstupper($this->_datas['syns'][1]),
              $this->_datas['model_type']['name'],
              $this->_datas['marka']['name']
          );

          $ret['description'] = array(
              'Неисправность',
              '—',
              $this->_datas['marka']['ru_name'],
              $this->_datas['ru_vsemodeli'],
              tools::mb_firstlower($this->_datas['syns'][2]).'.',
              $this->_datas['dop']
          );

          $stmt = $this->dbh->prepare("SELECT * FROM services WHERE model_type_id = ?");
          $stmt->execute([$this->_datas['model_type']['id']]);

          $this->_datas['all_services'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

          $minCost = null;
          foreach (array_column($this->_datas['all_services'], 'cost') as $cost) {
            if ($cost > 0 && ($cost < $minCost || is_null($minCost)))
              $minCost = $cost;
          }
          $this->_datas['price'] = $minCost;

        $this->_mode = 3;
      $file_name = 'model-defect';

        }
        else if (isset($params['model_id']) && isset($params['service_id']))  {


                        if (isset($this->_datas['service']['title']) && trim($this->_datas['service']['title']) != '') {
                          $ret['title'] = [$this->_datas['service']['title']];
                        }
                        else {
                          $ret['title'] = array(
                              tools::mb_firstupper($this->_datas['syns'][0])
                          );

                          if (mb_strtolower($this->_datas['model']['lineyka']) != mb_strtolower($this->_datas['model']['sublineyka']))
                          {
                               $ret['title'][] = $this->_datas['marka']['ru_name'];
                               $ret['title'][] = $this->_datas['m_model']['ru_name'];
                               $ret['title'][] = tools::mb_ucfirst($this->_datas['model']['submodel']);
                          }
                          else
                          {
                              $ret['title'][] = $this->_datas['marka']['ru_name'];
                              $ret['title'][] = tools::mb_ucfirst($this->_datas['model']['submodel']);
                          }

                          $ret['title'][] = 'в';
                          $ret['title'][] = $this->_datas['servicename'];
                          $ret['title'][] = 'в';
                          $ret['title'][] = $this->_datas['region']['name_pe'];

                          if (isset($this->_datas['price']))
                          {
                              $ret['title'][] = 'от';
                              $ret['title'][] = $this->_datas['price'];
                              $ret['title'][] = 'руб';
                          }
                        }

                        if (isset($this->_datas['service']['h1']) && trim($this->_datas['service']['h1']) != '') {
                          $ret['h1'] = [$this->_datas['service']['h1']];
                        }
                        else {
                          $ret['h1'] = array(
                              tools::mb_firstupper($this->_datas['syns'][1]),
                              $this->_datas['model_type']['name_re'],
                              $this->_datas['model']['name']
                          );
                        }

                        $ret['description'] = array(
                            tools::mb_firstupper($this->_datas['syns'][2]),
                        );

                        if (mb_strtolower($this->_datas['model']['lineyka']) != mb_strtolower($this->_datas['model']['sublineyka']))
                        {
                             $ret['description'][] = $this->_datas['marka']['ru_name'];
                             $ret['description'][] = $this->_datas['m_model']['ru_name'];
                             $ret['description'][] = tools::mb_ucfirst($this->_datas['model']['ru_submodel_syn']).'.';
                        }
                        else
                        {
                            $ret['description'][] = $this->_datas['marka']['ru_name'];
                            $ret['description'][] = tools::mb_ucfirst($this->_datas['model']['ru_submodel_syn']).'.';
                        }

                        $ret['description'][] = $this->_datas['dop'];

                    $this->prepareSeo($ret);
                    $this->_mode = 2;
                    $file_name = 'model-service';

      }
      else if (isset($params['model_id']) && isset($params['complect_id'])) {

                        $ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0]),
                            $this->_datas['model_type']['name_re']
                        );

                        if (mb_strtolower($this->_datas['model']['lineyka']) != mb_strtolower($this->_datas['model']['sublineyka']))
                        {
                             $ret['title'][] = $this->_datas['marka']['ru_name'];
                             $ret['title'][] = $this->_datas['m_model']['ru_name'];
                             $ret['title'][] = tools::mb_ucfirst($this->_datas['model']['submodel']);
                        }
                        else
                        {
                             $ret['title'][] = $this->_datas['marka']['ru_name'];
                             $ret['title'][] = tools::mb_ucfirst($this->_datas['model']['submodel']);
                        }

                        $ret['title'][] = 'в';
                        $ret['title'][] = $this->_datas['servicename'];
                        $ret['title'][] = $this->_datas['region']['translit1'];

                        if (isset($this->_datas['price']))
                        {
                            $ret['title'][] = 'от';
                            $ret['title'][] = $this->_datas['price'];
                            $ret['title'][] = 'руб';
                        }

                        $ret['h1'] = array(
                            tools::mb_firstupper($this->_datas['syns'][1]),
                            $this->_datas['model_type']['name_re'],
                            $this->_datas['model']['name']
                        );

                        $ret['description'] = array(
                            tools::mb_firstupper($this->_datas['syns'][2]),
                            $this->_datas['model']['name'].'.',
                            $this->_datas['dop']
                        );

                    $this->_mode = 2;
                    $file_name = 'model-complect';
            }
            else if (isset($params['model_id']) && isset($params['defect_id'])) {
              $count = count($this->_datas['reasons']);

              $ret['title'] = array(
                  tools::mb_firstupper($this->_datas['syns'][0]),
              );

              if (mb_strtolower($this->_datas['model']['lineyka']) != mb_strtolower($this->_datas['model']['sublineyka']))
              {
                   $ret['title'][] = $this->_datas['marka']['ru_name'];
                   $ret['title'][] = $this->_datas['m_model']['ru_name'];
                   $ret['title'][] = tools::mb_ucfirst($this->_datas['model']['submodel']);
              }
              else
              {
                   $ret['title'][] = $this->_datas['marka']['ru_name'];
                   $ret['title'][] = tools::mb_ucfirst($this->_datas['model']['submodel']);
              }

              $ret['title'][] = '—';
              $ret['title'][] = $count;
              $ret['title'][] = tools::declOfNum($count, array('причина', 'причины', 'причин'), false);
              $ret['title'][] = 'поломки';
              $ret['title'][] = $this->_datas['model_type']['name_re'];
              $ret['title'][] = '|';
              $ret['title'][] = $this->_datas['servicename'];
              $ret['title'][] = $this->_datas['region']['translit1'];

              $ret['h1'] = array(
                  tools::mb_firstupper($this->_datas['syns'][1]),
                  $this->_datas['model']['name']
              );

              $ret['description'] = array(
                  'Неисправность',
                  '—',
              );

              if (mb_strtolower($this->_datas['model']['lineyka']) != mb_strtolower($this->_datas['model']['sublineyka']))
              {
                   $ret['description'][] = $this->_datas['marka']['ru_name'];
                   $ret['description'][] = $this->_datas['m_model']['ru_name'];
                   $ret['description'][] = tools::mb_ucfirst($this->_datas['model']['ru_submodel_syn']).'.';
              }
              else
              {
                   $ret['description'][] = $this->_datas['marka']['ru_name'];
                   $ret['description'][] = tools::mb_ucfirst($this->_datas['model']['ru_submodel_syn']).'.';
              }

              $ret['description'][] = tools::mb_firstlower($this->_datas['syns'][2]).'.';
              $ret['description'][] = $this->_datas['dop'];

              $stmt = $this->dbh->prepare("SELECT * FROM services WHERE model_type_id = ?");
              $stmt->execute([$this->_datas['model_type']['id']]);

              $this->_datas['all_services'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

              $minCost = null;
              foreach (array_column($this->_datas['all_services'], 'cost') as $cost) {
                if ($cost > 0 && ($cost < $minCost || is_null($minCost)))
                  $minCost = $cost;
              }
              $this->_datas['price'] = $minCost;

              $this->_mode = 2;
              $file_name = 'model-defect';
            }
            else if (isset($params['model_id'])) {
                     $ret['title'] = array(
                        'Ремонт'
                     );

                     /*if (mb_strtolower($this->_datas['model']['lineyka']) != mb_strtolower($this->_datas['model']['sublineyka']))
                     {
                         $ret['title'][] = $this->_datas['marka']['ru_name'];
                         $ret['title'][] = $this->_datas['m_model']['ru_name'];
                         $ret['title'][] = tools::mb_ucfirst($this->_datas['model']['submodel']);
                     }
                     else
                     {
                        $ret['title'][] = $this->_datas['marka']['ru_name'];
                        $ret['title'][] = tools::mb_ucfirst($this->_datas['model']['submodel']);
                     }*/
					 
					 $ret['title'][] = $this->_datas['model']['name'];

                     $ret['title'][] = 'в';
                     $ret['title'][] = $this->_datas['servicename'];
                     $ret['title'][] = 'в';
                     $ret['title'][] = $this->_datas['region']['name_pe'];

                    if (isset($this->_datas['price']))
                    {
                        $ret['title'][] = 'от';
                        $ret['title'][] = $this->_datas['price'];
                        $ret['title'][] = 'руб';
                     }

                     $ret['h1'] = array(
                        'Ремонт',
                         $this->_datas['model']['name']
                     );

                     $ret['description'] = array(
                        'Услуги по ремонту',
                        $this->_datas['model_type']['name_rm'],

                     );

                     if (mb_strtolower($this->_datas['model']['lineyka']) != mb_strtolower($this->_datas['model']['sublineyka']))
                     {
						 $ret['description'][] = $this->_datas['marka']['name'];
						 $ret['description'][] = $this->_datas['model']['name'];
                         //$ret['description'][] = $this->_datas['marka']['ru_name'];
                         //$ret['description'][] = $this->_datas['m_model']['ru_name'];
                         $ret['description'][] = tools::mb_ucfirst($this->_datas['model']['ru_submodel_syn']).'.';
                     }
                     else
                     {
						$ret['description'][] = $this->_datas['marka']['name'];
						$ret['description'][] = $this->_datas['model']['name'];
                        //$ret['description'][] = $this->_datas['marka']['ru_name'];
                        $ret['description'][] = tools::mb_ucfirst($this->_datas['model']['ru_submodel_syn']).'.';
                     }

                     $ret['description'][] = $this->_datas['dop'];

                     $stmt = $this->dbh->prepare("SELECT * FROM services WHERE model_type_id = ?");
                     $stmt->execute([$this->_datas['model_type']['id']]);

                     $this->_datas['all_services'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                     $minCost = null;
                     foreach (array_column($this->_datas['all_services'], 'cost') as $cost) {
                       if ($cost > 0 && ($cost < $minCost || is_null($minCost)))
                         $minCost = $cost;
                     }
                     $this->_datas['price'] = $minCost;

                     $stmt = $this->dbh->prepare("SELECT * FROM complects WHERE model_type_id = ?");
                     $stmt->execute([$this->_datas['model_type']['id']]);

                     $this->_datas['all_complects'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                     foreach ($this->_datas['all_complects'] as $i=>$complect) {
                       $this->_datas['all_complects'][$i]['price'] = $this->costComplect($complect['costs'], $complect['id']+$params['model_id']);
                     }

                     $stmt = $this->dbh->prepare("SELECT * FROM models WHERE m_model_id = ? AND id != ?");
                     $stmt->execute([$this->_datas['m_model']['id'], $this->_datas['model']['id']]);
                     $otherModels = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                     $one = $two = [];
                     foreach ($otherModels as $s) {
                       if ($s['id'] > $this->_datas['model']['id'])
                       $one[] = $s;
                       else
                       $two[] = $s;
                     }
                     $this->_datas['other_models'] = array_merge($one, $two);

                     $this->_mode = -2;
                     $file_name = 'model';
                }
                else if (isset($params['m_model_id']) && isset($params['service_id']))  {


                        if (isset($this->_datas['service']['title']) && trim($this->_datas['service']['title']) != '') {
                          $ret['title'] = [$this->_datas['service']['title']];
                        }
                        else {
                          $ret['title'] = array(
                              tools::mb_firstupper($this->_datas['syns'][0]),
                              $this->_datas['model_type']['name_re'],
                              $this->_datas['marka']['ru_name'],
                              $this->_datas['m_model']['ru_name'],
                              'в',
                              $this->_datas['servicename'],
                              'в',
                              $this->_datas['region']['name_pe']
                          );

                          if (isset($this->_datas['price']))
                          {
                              $ret['title'][] = 'от';
                              $ret['title'][] = $this->_datas['price'];
                              $ret['title'][] = 'руб';
                          }
                        }

                        if (isset($this->_datas['service']['h1']) && trim($this->_datas['service']['h1']) != '') {
                          $ret['h1'] = [$this->_datas['service']['h1']];
                        }
                        else {
                          $ret['h1'] = array(
                              tools::mb_firstupper($this->_datas['syns'][1]),
                              $this->_datas['model_type']['name_re'],
                              $this->_datas['marka']['name'],
                              $this->_datas['m_model']['name']
                          );
                        }

                        $ret['description'] = array(
                            tools::mb_firstupper($this->_datas['syns'][2]),
                            $this->_datas['marka']['ru_name'],
                            $this->_datas['m_model']['ru_name'].'.',
                            $this->_datas['dop']
                        );


                            $this->prepareSeo($ret);
                            $this->_mode = 5;
                            $file_name = 'model-service';

              }
              else if (isset($params['m_model_id']) && isset($params['complect_id'])) {

                $ret['title'] = array(
                    tools::mb_firstupper($this->_datas['syns'][0]),
                    $this->_datas['model_type']['name_rm'],
                    $this->_datas['marka']['ru_name'],
                     $this->_datas['m_model']['ru_name'],
                    'в',
                    $this->_datas['servicename'],
                    $this->_datas['region']['translit1']
                );

                if (isset($this->_datas['price']))
                {
                    $ret['title'][] = 'от';
                    $ret['title'][] = $this->_datas['price'];
                    $ret['title'][] = 'руб';
                }

                $ret['h1'] = array(
                    tools::mb_firstupper($this->_datas['syns'][1]),
                    $this->_datas['model_type']['name_rm'],
                    $this->_datas['marka']['name'],
                    $this->_datas['m_model']['name']
                );

                $ret['description'] = array(
                    tools::mb_firstupper($this->_datas['syns'][2]),
                    $this->_datas['marka']['name'],
                    $this->_datas['m_model']['name'].'.',
                    $this->_datas['dop']
                );

                            $this->_mode = 5;
                            $file_name = 'model-complect';
                    }
                    else if (isset($params['m_model_id'])) {
                      $ret['title'] = array(
                          'Ремонт',
                          $this->_datas['model_type']['name_rm'],
                          $this->_datas['marka']['name'],
                          $this->_datas['m_model']['name'],
                          'в',
                          $this->_datas['servicename'],
                          'в',
                          $this->_datas['region']['name_pe']
                      );

                      if (isset($this->_datas['price']))
                      {
                          $ret['title'][] = 'от';
                          $ret['title'][] = $this->_datas['price'];
                          $ret['title'][] = 'руб';
                       }

                       $ret['h1'] = array(
                          'Ремонт',
                           $this->_datas['marka']['name'],
                           $this->_datas['m_model']['name']
                       );

                       $ret['description'] = array(
                          'Услуги по ремонту',
                          $this->_datas['model_type']['name_rm'],
                          $this->_datas['marka']['name'],
                          $this->_datas['m_model']['name'].'.',
                          $this->_datas['dop']
                       );

                       $stmt = $this->dbh->prepare("SELECT * FROM services WHERE model_type_id = ?");
                       $stmt->execute([$this->_datas['model_type']['id']]);

                       $this->_datas['all_services'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                       $minCost = null;
                       foreach (array_column($this->_datas['all_services'], 'cost') as $cost) {
                         if ($cost > 0 && ($cost < $minCost || is_null($minCost)))
                           $minCost = $cost;
                       }
                       $this->_datas['price'] = $minCost;

                       $stmt = $this->dbh->prepare("SELECT * FROM complects WHERE model_type_id = ?");
                       $stmt->execute([$this->_datas['model_type']['id']]);

                       $this->_datas['all_complects'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                       foreach ($this->_datas['all_complects'] as $i=>$complect) {
                         $this->_datas['all_complects'][$i]['price'] = $this->costComplect($complect['costs'], $complect['id']);
                       }

                       $this->_mode = -5;

                       $file_name = 'model';
                    }
        else if (isset($params['marka_id']) && isset($params['model_type_id'])) {
				$loc_data['model_type']['name'] = $this->_datas['model_type']['name_rm'];
				if ($this->_datas['marka']['name'] == "Apple") {
					if ($this->_datas['model_type']['name_rm'] == "планшетов" )
						$loc_data['model_type']['name'] = "iPad";
					elseif($this->_datas['model_type']['name_rm'] == "смартфонов") 
						$loc_data['model_type']['name'] = "iPhone";
				}
                $ret['title'] = array(
                    'Ремонт',
                    //$this->_datas['model_type']['name_rm'],
					$loc_data['model_type']['name'],
					$this->_datas['marka']['name'],
					//$loc_data['model_type']['name'],
                    'в',
                    $this->_datas['servicename'],
                    'в',
                    $this->_datas['region']['name_pe']
                );

                if (isset($this->_datas['price']))
                {
                    $ret['title'][] = 'от';
                    $ret['title'][] = $this->_datas['price'];
                    $ret['title'][] = 'руб';
                }

                $ret['h1'] = array(
                    'Ремонт',
                    //$this->_datas['model_type']['name_rm'],
					$loc_data['model_type']['name'],
                    $this->_datas['marka']['name']
                  );

                $ret['description'] = array(
                    'Услуги по ремонту',
                    //$this->_datas['model_type']['name_rm'],
                    $this->_datas['marka']['name'],
					$loc_data['model_type']['name'],
                    $this->_datas['ru_vsemodeli'].'.',
                    $this->_datas['dop']
                );

                $stmt = $this->dbh->prepare("SELECT * FROM services WHERE model_type_id = ?");
                $stmt->execute([$params['model_type_id']]);

                $this->_datas['all_services'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                $minCost = null;
                foreach (array_column($this->_datas['all_services'], 'cost') as $cost) {
                  if ($cost > 0 && ($cost < $minCost || is_null($minCost)))
                    $minCost = $cost;
                }
                $this->_datas['price'] = $minCost;

                $stmt = $this->dbh->prepare("SELECT * FROM complects WHERE model_type_id = ?");
                $stmt->execute([$params['model_type_id']]);

                $this->_datas['all_complects'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                foreach ($this->_datas['all_complects'] as $i=>$complect) {
                  $this->_datas['all_complects'][$i]['price'] = $this->costComplect($complect['costs'], $complect['id']);
                }

                $this->_mode = -3;

                $file_name = 'model';
        }

        $feed = (isset($this->_datas['vals']['feed']) ? $this->_datas['vals']['feed'] : $this->_datas['feed']);

        // preim
        $preim = array();
        $preims = array();

        srand($feed);

        //$use_4 = false;
        $i = 0;

        /*if (isset($params['model_id'])
            if (isset($params['key']))
                if ($params['key'] == 'service')
                    $use_4 = true;*/
        // 0
        //if (!$use_4)
        //{
        $preim[$i][] = array(
            '<div class="preimitem"><div class="preimimage"><img src="/templates/moscow/img/shared/preimin3.png"></div><div class="preimname">Срочный ремонт</div>',
            '<div class="preimitem"><div class="preimimage"><img src="/templates/moscow/img/shared/preimin3.png"></div><div class="preimname">Экспресс ремонт</div>',
            '<div class="preimitem"><div class="preimimage"><img src="/templates/moscow/img/shared/preimin3.png"></div><div class="preimname">Оперативный ремонт</div>');

        $choose = rand(0, 1);

        switch ($choose)
        {
            case 0:
                $preim[$i][] = array('<div class="preimtext">Ремонт', '<div class="preimtext">Ремонт и обслуживание', '<div class="preimtext">Обслуживание');

                $t_array = array('устройств', 'техники', 'гаджетов');
                foreach ($this->_datas['orig_model_type'] as $type)
                    $t_array[] = $type['name_rm'];

                $preim[$i][] = $t_array;

            break;
            case 1:
                $preim[$i][] = array('<div class="preimtext">Отремонтируем', '<div class="preimtext">Починим');

                $t_array = array('ваше устройство', 'вашу технику', 'ваш гаджет');
                foreach ($this->_datas['orig_model_type'] as $type)
                    $t_array[] = 'ваш '.$type['name'];

                $preim[$i][] = $t_array;

            break;
        }

        if (isset($params['marka_id']) && isset($params['model_type_id']))
            $preim[$i][] = array($this->_datas['marka']['name'], $this->_datas['marka']['ru_name']);

        if (isset($params['sublineyka_id']))
            $preim[$i][] = array($this->_datas['marka']['name'].' '.$this->_datas['sublineyka']['name']);

        if (isset($params['model_id']))
            $preim[$i][] = array($this->_datas['model']['name']);

        $preim[$i][] = array('с типовыми проблемами', 'с типовыми неисправностями', 'с типовыми поломками', 'со стандартными проблемами',
                    'со стандартными неисправностями', 'со стандартными поломками', 'со всеми типовыми проблемами',
                    'со всеми типовыми неисправностями', 'со всеми типовыми поломками', 'со всеми стандартными проблемами',
                    'со всеми стандартными неисправностями', 'со всеми стандартными поломками');

        $preim[$i][] = array('в пределах 1-2 часов</div></div>', 'в пределах 2 часов</div></div>', 'в пределах 2-3 часов</div></div>', 'в пределах одного - двух часов</div></div>',
                    'в пределах двух часов</div></div>', 'в пределах двух - трех часов</div></div>', 'в течении 1-2 часов</div></div>', 'в течении 2 часов</div></div>',
                    'в течении 2-3 часов</div></div>', 'в течении одного - двух часов</div></div>', 'в течении двух часов</div></div>', 'в течении двух - трех часов</div></div>');

        $i++;
        //}

        // 1
        $choose = rand(0, 2);

        switch ($choose)
        {
            case 0:
                $preim[$i][] = array('<div class="preimitem"><div class="preimimage"><img src="/templates/moscow/img/shared/preimin1.png"></div><div class="preimname">Гарантии на работы</div>');
            break;
            case 1:
                $preim[$i][] = array('<div class="preimitem"><div class="preimimage"><img src="/templates/moscow/img/shared/preimin1.png"></div><div class="preimname">Гарантии на ремонт</div>');
            break;
            case 2:
                $preim[$i][] = array('<div class="preimitem"><div class="preimimage"><img src="/templates/moscow/img/shared/preimin1.png"></div><div class="preimname">Гарантии на услуги</div>');
            break;
        }

        $t_array = array('<div class="preimtext">После ремонта', '<div class="preimtext">После ремонтных работ', '<div class="preimtext">После выполнения ремонтных работ',
                        '<div class="preimtext">После предоставления услуг', '<div class="preimtext">По факту выполненых работ',
                        '<div class="preimtext">После работ по ремонту техники', '<div class="preimtext">После работ по ремонту оборудования');

        foreach ($this->_datas['orig_model_type'] as $type)
            $t_array[] = '<div class="preimtext">После работ по ремонту '.$type['name_re'];

        $preim[$i][] = $t_array;

        $preim[$i][] = array('сервисный инженер', 'специалист', 'менеджер', 'мастер приемки', 'специалист приемки', 'старший менеджер');
        $preim[$i][] = array('выписывает', 'выдает', 'предоставляет');

        $t_array = array('чек и гарантийный талон', 'кассовый чек и гарантийный талон', 'полный пакет документов');

        if ($choose != 2)
        {
            $t_array[] = 'гарантийный талон';
            $t_array[] = 'товарно-гарантийный чек';
        }

        $preim[$i][] = $t_array;

        $preim[$i][] = array('на фирменном бланке</div></div>', 'с печатью организации</div></div>', 'на фирменном бланке с печатью</div></div>', 'с печатью компании</div></div>');

        $i++;

        // 2
        $preim[$i][] = array(
            '<div class="preimitem"><div class="preimimage"><img src="/templates/moscow/img/shared/preimin6.png"></div><div class="preimname">Лучшее оборудование</div>',
            '<div class="preimitem"><div class="preimimage"><img src="/templates/moscow/img/shared/preimin6.png"></div><div class="preimname">Современное оборудование</div>' ,
            '<div class="preimitem"><div class="preimimage"><img src="/templates/moscow/img/shared/preimin6.png"></div><div class="preimname">Фирменное оборудование</div>');

        $preim[$i][] = array('<div class="preimtext">Работаем на', '<div class="preimtext">Работа проводится на', '<div class="preimtext">Ремонт проводится на',
                '<div class="preimtext">Работа провоизводится на', '<div class="preimtext">Ремонт производится на', '<div class="preimtext">Ремонтируем на');

        $preim[$i][] = array('профессиональных', 'высокопрофессиональных', 'специализированных', 'новейших', 'оригинальных');
        $preim[$i][] = array('инфракрасных', 'ИК', 'термовоздушных и инфракрасных', 'инфракрасных и термовоздушных');
        $preim[$i][] = array('станциях', 'паяльных станциях', 'ремонтных системах', 'ремонтных станциях', 'паяльных системах',
                        'паяльных комплексах', 'ремонтных комплексах', 'паяльно-ремонтных комплексах', 'паяльно-ремонтных системах',
                        'паяльно-ремонтных центрах', 'паяльно-ремонтных станциях', 'станциях с разноуровневым нагревом',
                        'станциях для монтажа BGA элементов', 'станциях для монтажа BGA компонент', 'станциях для монтажа BGA чипов',
                        'станциях для установки BGA компонент', 'станциях для установки BGA элементов', 'станциях для установки BGA чипов',
                        'станциях для ребола BGA элементов', 'станциях для ребола BGA компонент', 'станциях для ребола BGA чипов');

        $t1 = array('ERSA IR550A PLUS', 'ERSA HR100AHP', 'ERSA PCBXY');
        $t2 = array('микроскопах', 'цифровых микроскопах', 'сверхточных микроскопах', 'проффесиональных микроскопах');
        $t_array = array();

        foreach ($t1 as $value1)
        {
            foreach ($t2 as $value2)
            {
                $t_array[] = $value1.', '.$value2;
                $t_array[] = $value1.' и '.$value2;
            }
        }

        $preim[$i][] = $t_array;
        $preim[$i][] = array('Levenhuk 5ST</div></div>', 'Levenhuk 700M</div></div>', 'Levenhuk D70L Digital</div></div>', 'Levenhuk D70L</div></div>', 'Levenhuk 670T</div></div>',
                'Levenhuk D740T</div></div>', 'Levenhuk 720B</div></div>', 'Levenhuk 850B</div></div>', 'Levenhuk D320L Digital</div></div>', 'Levenhuk D320L</div></div>', 'Levenhuk 625</div></div>',
                    'Levenhuk D70L</div></div>');

        $i++;

        // 3
        $preim[$i][0] = array(
                    '<div class="preimitem"><div class="preimimage"><img src="/templates/moscow/img/shared/preimin2.png"></div><div class="preimname">Консультация по телефону</div>',
                    '<div class="preimitem"><div class="preimimage"><img src="/templates/moscow/img/shared/preimin2.png"></div><div class="preimname">Бесплатные консультации</div>',);

        if (isset($this->_datas['marka'])) {
          $preim[$i][0][] = '<div class="preimitem"><div class="preimimage"><img src="/templates/moscow/img/shared/preimin2.png"></div><div class="preimname">Горячая линия '.$this->_datas['marka']['name'].'</div>';
        }
        else {
          $preim[$i][0][] = '<div class="preimitem"><div class="preimimage"><img src="/templates/moscow/img/shared/preimin2.png"></div><div class="preimname">Горячая линия '.$this->_datas['servicename'].'</div>';
        }

        $preim[$i][] = array('<div class="preimtext">Помогаем решать проблемы', '<div class="preimtext">Помогаем устранять неисправности', '<div class="preimtext">Помогаем устранять поломки',
                '<div class="preimtext">Оказываем помощь');

        $preim[$i][] = array('владельцам', 'обладателям');
        $preim[$i][] = array('устройств', 'гаджетов', 'техники', 'оборудования');
        if (isset($this->_datas['marka']))
          $preim[$i][] = array($this->_datas['marka']['name'], $this->_datas['marka']['ru_name'], 'бренда '.$this->_datas['marka']['name'], 'бренда '.$this->_datas['marka']['ru_name']);

        $preim[$i][] = array('по телефону и онлайн -', 'по телефону и online -', 'онлайн и по телефону -', 'online и по телефону -');
        $preim[$i][] = array('звоните '.tools::format_phone($this->_datas['phone']).'.</div></div>', 'пишите, звоните!</div></div>', 'звоните, пишите!</div></div>',
                        'звоните, проконсультируем!</div></div>', 'звоните, мы на связи!</div></div>');

        $i++;

        // 4
        /*if ($use_4)
        {
            $preim[$i][] = array('<h3>Лучшие сроки ремонта</h3>', '<h3>Сроки ремонта</h3>', '<h3>Сжатые сроки ремонт</h3>', '<h3>Кратчайшие сроки ремонта</h3>');
            $preim[$i][] = array('<p>Среднее время');
            $preim[$i][] = array(tools::skl('service', $this->_suffics, $this->_datas['syns'][0], 'rp'));
            $preim[$i][] = array('на');
            $preim[$i][] = array($this->_datas['model']['name']);
            $preim[$i][] = array('по нашей статистике', 'по нашим данным', 'в нашем сервисе', 'в нашем сервисном центре', 'в нашем сервис-центре', 'в нашем центре');

            $choose = rand(0, 1);

            switch ($choose)
            {
                case 0:
                    $preim[$i][] = array('не превышает');
                    $time = $this->_datas['vals']['time_max'];
                break;
                case 1:
                    $preim[$i][] = array('около');
                    $time = $this->_datas['vals']['time_min'];
                break;
            }

            if ($time >= 60)
            {
                $t_a = round($time/60, 2);
                $t_b = round($time/60, 0);
                $preim[$i][] = array(($t_a == $t_b) ? (tools::declOfNum($t_a, array('часа</p>', 'часов</p>', 'часов</p>'))) : 'часа</p>');
            }
            else
            {
                $preim[$i][] = array(tools::declOfNum($time, array('минуты</p>', 'минут</p>', 'минут</p>')));
            }
        }*/

        $choose = rand(0, 4);

        switch ($choose)
        {
            case 0:
                $preim[$i][] = array('<div class="preimitem"><div class="preimimage"><img src="/templates/moscow/img/shared/preimin4.png"></div><div class="preimname">Запчасти Original</div>');
            break;
            case 1:
                $preim[$i][] = array('<div class="preimitem"><div class="preimimage"><img src="/templates/moscow/img/shared/preimin4.png"></div><div class="preimname">Оригинальные запчасти</div>');
            break;
            case 2:
                $preim[$i][] = array('<div class="preimitem"><div class="preimimage"><img src="/templates/moscow/img/shared/preimin4.png"></div><div class="preimname">Original запчасти</div>');
            break;
            case 3:
                $preim[$i][] = array('<div class="preimitem"><div class="preimimage"><img src="/templates/moscow/img/shared/preimin4.png"></div><div class="preimname">Оригинальные комплектующие</div>');
            break;
            case 4:
                $preim[$i][] = array('<div class="preimitem"><div class="preimimage"><img src="/templates/moscow/img/shared/preimin4.png"></div><div class="preimname">Original комплектующие</div>');
            break;
        }

        $preim[$i][] = array('<div class="preimtext">В работе используем', '<div class="preimtext">При ремонте используем', '<div class="preimtext">Мы используем');
        $preim[$i][] = array('только', 'исключительно', 'все', '');
        $preim[$i][] = array('фирменные', 'брендовые');
        $preim[$i][] = array('комплектующие', 'запасные части', 'запчасти');

        $t_array = array('комплектующие', 'запасные части', 'запчасти');

        if ($choose == 3 || $choose == 4) unset($t_array[0]);
        if ($choose == 0 || $choose == 1 || $choose == 2) unset($t_array[2]);

        $preim[$i][] = array_values($t_array);

        $preim[$i][] = array('от');
        if (isset($this->_datas['marka']))
          $preim[$i][] = array($this->_datas['marka']['name'].'</div></div>', $this->_datas['marka']['ru_name'].'</div></div>');
        else
          $preim[$i][] = array($this->_datas['servicename'].'</div></div>', $this->_datas['ru_servicename'].'</div></div>');

        $preims = rand_it::randMas($preim, 3, '', $feed);

         $text = array();
         $text2 = array();

         if (isset($params['service_id'])) {
           $text[] = array('<p>'.tools::mb_firstupper($this->_datas['service']['name']));

           if (isset($params['marka_id']) && isset($params['model_type_id']))
               $text[] = array($this->_datas['marka']['name'], $this->_datas['marka']['ru_name']);

           if (isset($params['sublineyka_id']))
               $text[] = array($this->_datas['marka']['name'].' '.$this->_datas['sublineyka']['name']);

           if (isset($params['model_id']))
               $text[] = array($this->_datas['model']['name']);

           $text[] = array('- это', '-');
           $text[] = array('задача, которую мы знаем как решать!', 'задача, которую мы решаем каждый день.', 'задача, которую мы умеем решать!',
               'наша работа!', 'работа, которую мы отлично умеем делать.', 'работа, которую мы умеем выполнять.',
               'работа, которую мы делаем отлично!', 'работа, которую мы делаем безукоризненно.', 'работа, которую мы делаем безупречно.',
               'работа, которую мы умеем делать хорошо.', 'работа, которую мы умеем выполнять хорошо!', 'работа, которую мы делаем хорошо!',
               'работа, которую мы делаем не первый год.', 'задача для проффесионалов.', 'задача для таких проффесионалов, как мы.',
               'задача для таких проффесионалов, как наши мастера.', 'работа для экспертов.', 'работа для таких экспертов, как мы.');

           $text[] = array('Сделайте заказ', 'Звоните');
           $text[] = array('по телефону', 'по телефону:', 'по телефону -', 'по номеру телефона', 'по номеру телефона:',
                   'по номеру телефона -', 'по единому номеру телефона', 'по единому номеру телефона:', 'по единому номеру телефона -');
           $text[] = array(tools::format_phone($this->_datas['phone']));
           $text[] = array('или отправляйте заявку', 'или оставляйте заявку', 'или отправляйте online заявку', 'или оставляйте online заявку',
               'или отправляйте онлайн заявку', 'или оставляйте онлайн заявку', 'или отправляйте заявку через онлайн форму',
               'или оставляйте заявку через онлайн форму', 'или отправляйте заявку через online форму', 'или оставляйте заявку через online форму', '');
           $text[] = array('сейчас', 'сегодня');
           $text[] = array('и наши специалисты', 'и наши мастера', 'и наши сервисные инженеры', 'и наши сервисные мастера',
                   'и специалисты '.$this->_datas['servicename'], 'и мастера '.$this->_datas['servicename'], 'и сервисные инженеры '.$this->_datas['servicename'],
                   'и сервисные мастера '.$this->_datas['servicename'], 'и специалисты сервиса '.$this->_datas['servicename'], 'и мастера сервиса '.$this->_datas['servicename'],
                   'и сервисные инженеры сервиса '.$this->_datas['servicename'], 'и сервисные мастера сервиса '.$this->_datas['servicename'],
                   'и специалисты сервисного центра '.$this->_datas['servicename'], 'и мастера сервисного центра '.$this->_datas['servicename'],
                   'и сервисные инженеры сервисного центра '.$this->_datas['servicename'], 'и сервисные мастера сервисного центра '.$this->_datas['servicename']);

           $t1 = array('отремонтируют ваш', 'починят ваш', 'восстановят ваш');
           $t2 = array('устранят неисправности вашего', 'восстановят работоспособность вашего');
           $t_array = array();
           foreach ($this->_datas['orig_model_type'] as $type)
           {
               foreach ($t1 as $value1)
                   $t_array[] = $value1.' '.$type['name'];

               foreach ($t2 as $value2)
                   $t_array[] = $value2.' '.$type['name_re'];
           }

           $text[] = $t_array;

           if (isset($params['marka_id']) && isset($params['model_type_id']))
               $text[] = array($this->_datas['marka']['name'], $this->_datas['marka']['ru_name']);

           if (isset($params['sublineyka_id']))
               $text[] = array($this->_datas['marka']['name'].' '.$this->_datas['sublineyka']['name']);

           if (isset($params['model_id']))
               $text[] = array($this->_datas['model']['name']);

           $text[] = array('в самое ближайшее время.', 'в самые сжатые сроки.', 'в самые короткие сроки.', 'в кратчайшие сроки.');
           $text[] = array('90%', '85%', '80%', '75%', '70%');
           $text[] = array('устройств', 'аппаратов', 'девайсов', 'гаджетов');
           $text[] = array('удается отремонтировать', 'удается починить', 'ремонтируются', 'удается восстановить');
           $text[] = array('в день обращения.</p>', 'в тот же день.</p>', 'в этот же день.</p>', 'в течении 2-3 часов с момента обращения.</p>');
         }
         else if (isset($params['defect_id'])) {
           $text[] = array('<p>По оценке', '<p>По системе оценок', '<p>По корпоративной оценке', '<p>По корпоративной системе оценок',  '<p>По статитстике', '<p>По ежегодной оценке');
           $text[] = array('наших специалисов', 'наших мастеров', 'наших штатных мастеров', 'наших сервисных инженеров', 'наших сервисных мастеров',
                           'наших сотрудников', 'наших аналитиков', 'нашего аналитического отдела', 'нашего отдела аналитики', 'специалистов '.$this->_datas['servicename'],
                           'мастеров '.$this->_datas['servicename'], 'сервисных инженеров '.$this->_datas['servicename'], 'сервисных мастеров '.$this->_datas['servicename'],
                           'ремонтных мастеров '.$this->_datas['servicename'], 'сотрудников '.$this->_datas['servicename'], 'аналитиков '.$this->_datas['servicename'],
                           'аналитического отдела '.$this->_datas['servicename'], 'отдела аналитики '.$this->_datas['servicename']);

           $text[] = array('проблема -', 'неисправность -', 'поломка -');
           $text[] = array(tools::mb_firstlower($this->_datas['syns'][0]));
           $text[] = array('случается', 'происходит', 'возникает');
           $text[] = array('у большого числа',	'у большого количества', 'у большого процента', 'у многих');
           $text[] = array('пользователей', 'обладателей', 'владельцев');

           $t_array = array();
           foreach ($this->_datas['orig_model_type'] as $type)
               $t_array[] = $type['name_re'];

           $t_array[] = '';

           $text[] = $t_array;

           if (isset($params['marka_id']) && isset($params['model_type_id']))
               $text[] = array($this->_datas['marka']['name'].'.', $this->_datas['marka']['ru_name'].'.');

           if (isset($params['sublineyka_id']))
               $text[] = array($this->_datas['marka']['name'].' '.$this->_datas['sublineyka']['name'].'.');

           if (isset($params['model_id']))
               $text[] = array($this->_datas['model']['name'].'.');

           $text[] = array('За последний год', 'За последний год работы', 'За последнее время', 'За прошлый год');

           $choose = rand(0, 1);

           srand($this->_datas['defect']['id']);
           $counts = array('1 000', '1 500', '2 000', '2 500', '3 000', '3 500', '4 000', '4 500', '5 000', '5 500', '6 000', '6 500');
           $number = $counts[rand(0, count($counts)-1)];
           srand($feed);

           switch ($choose)
           {
               case 0:
                   $text[] = array('мы отремонтировали', 'мы починили', 'мы восстановили работоспособность', 'было отремонтировано', 'было восстановлено',
                                       'мы помогли восстановить');

                   $text[] = array($number, 'более '.$number, 'больше '.$number, 'около '.$number, '~'.$number, '>'.$number);

               break;
               case 1:

                   $text[] = array('к нам обращались', 'в сервис '.$this->_datas['servicename'].' обращались', 'в наш сервис обращались', 'к нам в сервис обращались',
                       'в сервисный центр '.$this->_datas['servicename'].' обращались', 'в наш сервисный центр обращались', 'к нам в сервисный центр обращались',
                       'в сервис центр '.$this->_datas['servicename'].' обращались', 'в наш сервис центр обращались', 'к нам в сервис центр обращались');

                   $text[] = array($number, 'более '.$number, 'больше '.$number, 'около '.$number, '~'.$number, '>'.$number);

                   $text[] = array('владельцев', 'обладателей', 'пользователей');

               break;
            }

            $text[]  = array('устройств', 'девайсов', 'аппаратов', 'разных устройств', 'разных девайсов', 'разных аппаратов',
                       'различных устройств', 'различных девайсов', 'различных аппаратов');

            $text[]  = array($this->_datas['marka']['name'], $this->_datas['marka']['ru_name']);
            $text[]  = array('с этой', 'с такой');
            $text[]  = array('проблемой.</p>', 'неисправностью.</p>', 'поломкой.</p>');

            $text2[] = array('<p>Неисправность -');
            $text2[] = array(tools::mb_firstlower($this->_datas['syns'][3]));

            if (isset($params['marka_id']) && isset($params['model_type_id']))
               $text2[] = array($this->_datas['marka']['name'], $this->_datas['marka']['ru_name']);

            if (isset($params['sublineyka_id']))
               $text2[] = array($this->_datas['marka']['name'].' '.$this->_datas['sublineyka']['name']);

            if (isset($params['model_id']))
               $text2[] = array($this->_datas['model']['name']);

            $text2[] = array('чаще всего', 'обычно', 'часто');

            $t_array = array();
            $t1 = array('связана с', 'вызвана');
            $t2 = array('одной из следующих причин', 'одной из этих причин', 'одной из описанных здесь причин', 'этими причинами',
                           'следующими причинами', 'описанными здесь причинами', 'какой-то из следующих причин', 'какой-то из этих причин',
                               'какой-то из описанных здесь причин');

            foreach ($t1 as $value1)
            {
               foreach ($t2 as $value2)
               {
                   $t_array[] = $value1.' '.$value2.':';
               }
               $t_array[] = $value1.':';
            }

            $text2[] = $t_array;
            $text2[] = array('<ul class="dop-reasons">');

            $str = '';
            foreach ($this->_datas['reasons'] as $value)
               $str.= '<li>'.$value.'</li>';

            $t_array = array($str);

            $text2[] = $t_array;

            $text2[] = array('</ul></p>');
         }
         else if (isset($params['complect_id'])) {
           $text[] = array('<p>На складе', '<p>На московском складе', '<p>В фирменном складе', '<p>На складах', '<p>На московских складах',
                   '<p>В фирменных складах');

           $text[] = array('сервиса', 'сервисного центра', 'сервис центра');
           $text[] = array($this->_datas['servicename']);
           $text[] = array('имеется', 'находится', '');
           $text[] = array('больше', 'более', 'свыше');
           $amount = (string) tools::get_complect_amount($this->_datas['site_name']);

           $text[] = array($amount.' 000', $amount.' тысяч');
           $text[] = array('наименований', 'единиц');
           $text[] = array('оригинальных', 'фирменных');
           $text[] = array('комплектующих', 'запчастей', 'деталей и запчастей', 'запасных частей', 'различных комплектующих',
                               'различных запчастей');

           $text[] = array($this->_datas['marka']['name'].'.', $this->_datas['marka']['ru_name'].'.');

           $text[] = ['Среди них всегда в наличии '.$this->_datas['complect']['name'].' для '.$this->_datas['model_type']['name_rm']];
           $text[] = array($this->_datas['marka']['name'].'.', $this->_datas['marka']['ru_name'].'.');

           $text[] = array('Сведения', 'Информацию', 'Данные');
           $text[] = array('о наличии в '.$this->_datas['region']['name_pe'].' и');
           $text[] = array('времени', 'сроках', 'сроках и часах');
           $text[] = array('доставки');
           $text[] = array('уточняйте', 'узнавайте');
           $text[] = array('у наших менеджеров', 'у наших специалистов', 'у наших операторов', 'у сотрудников call-центра', 'у менеджеров колл-центра',
                               'у специалистов колл-центра');
           $text[] = array('по телефону', 'по телефону:', 'по телефону -', 'по номеру телефона', 'по номеру телефона:', 'по номеру телефона -');
           $text[] = array(tools::format_phone($this->_datas['phone']).'.</p>');

           $text2[] = array('<p>Приобрести', '<p>Купить', '<p>Заказать', '<p>Сделать заказ на');
           $text2[] = array(tools::skl('complect', $this->_suffics, $this->_datas['syns'][0], 'vin'));
           $text2[] = array('вы можете', 'вы вправе', 'возможно', 'можно');
           $text2[] = array('с установкой и без.</p>', 'с установкой и без установки.</p>', 'с установкой/без установки.</p>',
                               'с монтажем и без.</p>', 'с монтажем и без монтажа.</p>',  'с монтажем/без монтажа.</p>');
         }
         else if (isset($params['m_model_id'])) {
           $text[] = array('<p>За время существования', '<p>За время работы', '<p>За время работы в '.$this->_datas['region']['name_pe']);
           $text[] = array('мы', 'наши специалисты', 'наши мастера', 'наши штатные мастера', 'наши сервисные инженеры',
                   'наши сервисные мастера', 'специалисты '.$this->_datas['servicename'], 'мастера '.$this->_datas['servicename'],
                   'сервисные инжененры '.$this->_datas['servicename'], 'сервисные мастера '.$this->_datas['servicename'],
                       'ремонтники '. $this->_datas['servicename']);

           $text[] = array('отремонтировали', 'починили', 'восстановили', 'вернули к жизни', 'восстановили работоспособность');
           $text[] = array('более', 'больше', 'больше, чем', 'более, чем', 'уже более', 'уже больше', 'уже более, чем',
                   'уже больше, чем', 'свыше');
           $text[] = array(tools::get_type_amount($this->_datas['site_name'], $this->_suffics).' 000');

           $t_array = array();
           foreach ($this->_datas['orig_model_type'] as $type)
               $t_array[] = $type['name_rm'];

           $text[] = $t_array;

           if (isset($params['marka_id']) && isset($params['model_type_id']))
           {
               $text[] = array($this->_datas['marka']['name'].'.', $this->_datas['marka']['ru_name'].'.');
           }
           else
           {
               $text[] = array($this->_datas['marka']['name'].',');
               $text[] = array('ремонт');

               if (isset($params['sublineyka_id']))
                   $text[] = array($this->_datas['sublineyka']['name']);

               if (isset($params['model_id']))
               {
                   if (mb_strtolower($this->_datas['model']['lineyka']) != mb_strtolower($this->_datas['model']['sublineyka']))
                   {
                        $text[] = $this->_datas['m_model']['name'];
                        $text[] = tools::mb_ucfirst($this->_datas['model']['submodel']);
                   }
                   else
                   {
                        $text[] = tools::mb_ucfirst($this->_datas['model']['submodel']);
                   }
               }

               $text[] = array(' - это', '-');
               $text[] = array('задача, которую мы знаем как решать!', 'задача, которую мы решаем каждый день.', 'задача, которую мы умеем решать!',
                   'наша работа!', 'работа, которую мы отлично умеем делать.', 'работа, которую мы умеем выполнять.', 'работа, которую мы делаем отлично!',
                   'работа, которую мы делаем безукоризненно.', 'работа, которую мы делаем безупречно.', 'работа, которую мы умеем делать хорошо.',
                   'работа, которую мы умеем выполнять хорошо!', 'работа, которую мы делаем хорошо!', 'работа, которую мы делаем не первый год.',
                   'задача для проффесионалов.', 'задача для таких проффесионалов, как мы.', 'задача для таких проффесионалов, как наши мастера.',
                   'работа для экспертов.', 'работа для таких экспертов, как наши.', 'работа для таких экспертов, как мы.');
           }

           $text[] = array('Опыт', 'Квалификация', 'Навыки', 'Знания', 'Образование', 'Практика', 'Образование и большой опыт', 'Знания и большой опыт',
                           'Знания и регулярная практика', 'Образование и навыки', 'Образование и опыт', 'Опыт и образование', 'Регулярная практика',
                           'Постоянная практика', 'Ежедневная практика', 'Большой опыт', 'Высокая квалификация', 'Многолетний опыт', 'Опыт и практика',
                           'Опыт и навыки', 'Опыт и знания', 'Опыт и квалификация', 'Практика и опыт', 'Навыки и опыт', 'Знания и опыт', 'Квалификация и опыт',
                           'Квалификация и навыки', 'Квалификация и знания', 'Квалификация и практика', 'Опыт и квалификация', 'Навыки и квалификация',
                           'Знания и квалификация', 'Регулярная практика и квалификация', 'Ежедневная практика и квалификация', 'Постоянная практика и квалификация',
                           'Регулярная практика и квалификация', 'Многолетняя практика и квалификация', 'Образование и многолетняя практика', 'Навыки и квалификация',
                               'Знания и многолетний опыт');

           $text[] = array('сотрудников, ', 'штатных сотрудников, ', 'сервисных сотрудников, ', 'ремонтных мастеров, ');

           $t_array = array();
           $t1 = array('оборудование', 'профессиональное оборудование', 'высокопрофессиональное оборудование', 'специализированное оборудование',
                               'новейшее оборудование', 'оригинальное оборудование', 'фирменное оборудование');
           $t2 = array('наличие');
           foreach ($t1 as $value1)
           {
               foreach ($t2 as $value2)
               {
                   $t_array[] = $value1.' и '.$value2;
                   $t_array[] = $value1.', '.$value2;
               }
           }

           $text[] = $t_array;

           $text[] = array('всех', '');
           $text[] = array('необходимых', '');
           $text[] = array('оригинальных', 'фирменных', '');
           $text[] = array('запасных частей', 'запчастей', 'комплектующих', 'деталей');
           $text[] = array('и расходных материалов', 'и расходников', '');
           $text[] = array('позволяет', 'дает возможность');
           $text[] = array('нам', '');

           $text[] = array('производить', 'проводить', 'выполнять', 'осуществлять');
           $text[] = array('ремонт', 'ремонтные работы', 'сложный ремонт', 'сложные ремонтные работы', 'даже самый сложный ремонт', 'даже самые сложные работы',
                       'даже сложный ремонт', 'даже сложные работы', 'ремонт любой сложности', 'ремонтные работы любой сложности');
           $text[] = array('максимально быстро.</p>', 'максимально оперативно.</p>', 'быстро.</p>', 'оперативно.</p>', 'в кратчайшие сроки.</p>', 'быстро и качественно.</p>', 'качественно и быстро.</p>',
                       'максимально быстро и качественно.</p>', 'быстрее, чем в других сервисных центрах.</p>');
         }
         else {
           $f = tools::gen_feed($this->_datas['site_name']);

           $text[] = array('<p>Ремонт');

           $t_array = array();
           foreach ($this->_datas['orig_model_type'] as $type)
               $t_array[] = $type['name_rm'];

           $text[] = $t_array;

           if (isset($this->_datas['marka'])) {
             $t_marka = array($this->_datas['marka']['name'], $this->_datas['marka']['ru_name']);
            $choose = rand(0, 1);
            $text[] = array($t_marka[$choose]);

            unset($t_marka[$choose]);

            $t_marka = array_values($t_marka);
           }

           $text[] = array('в сервисном центре', 'в сервисе', 'в сервис центре');
           $text[] = array($this->_datas['servicename']);
           $text[] = array('это не только:');

           $vars = array();
           $vars[] = array('камер', 'корпусов', 'динамиков', 'разъемов', 'портов', 'шлейфов',
                       'кнопок', 'микрофонов', 'слотов', 'крышек');
           $vars[] = array('симхолдеров', 'сим-лотков', 'держателей сим', 'simholder');
           $vars[] = array('GPS', 'GPS-модулей', 'модулей GPS', 'плат GPS', 'GPS-плат');
           $vars[] = array('вибромоторов', 'вибро', 'вибромодулей');
           $vars[] = array('гнезд питания', 'разъемов питания', 'разъемов зарядки', 'гнезд зарядки');
           $vars[] = array('WI-FI', 'WI-FI модулей', 'модулей WI-FI', 'плат WI-FI', 'WI-FI плат');
           $vars[] = array('материнских плат', 'плат', 'элементов плат', 'системных плат');

           $vars = rand_it::randMas($vars, 4, '', $feed);

           $text[] = array('замена');
           $text[] = $vars[0];
           $text[] = array('и');

           foreach ($vars[1] as $key => $value)
               $vars[1][$key] = $value.',';

           $text[] = $vars[1];
           $text[] = array('ремонт');

           $text[] = $vars[2];
           $text[] = array('и');

           foreach ($vars[3] as $key => $value)
               $vars[3][$key] = $value.',';

           $text[] = $vars[3];

           $text[] = array('перепайка');

           $t_array = array();
           $t1_array = array('контроллеров', 'контроллеров плат', 'ШИМ-контроллеров', 'PWM-контроллеров', 'мультиконтроллеров');
           $t2_array = array('цепей питания', 'цепей питания плат', 'чипов', 'BGA-чипов', 'кондесаторов плат', 'кондесаторов плат');

           foreach ($t1_array as $t1)
           {
               foreach ($t2_array as $t2)
               {
                   $t_array[] = $t1.' и '.$t2.',';
                   $t_array[] = $t2.' и '.$t1.',';
               }
           }

           $text[] = $t_array;

           $text[] = array('но и');
           $text[] = array('индивидуальный', 'персональный');
           $text[] = array('подход');
           $text[] = array('к проблемам каждого', 'к проблемам и неисправностям каждого');

           $choose = rand(0, 1);

           switch ($choose)
           {
               case 0:
                   $text[] = array('клиента', 'посетителя');
                   $text[] = array('нашего');
                   $text[] = array('сервиса.', 'центра.');
               break;
               case 1:
                   $text[] = array('владельца');
                   $t_array = array();
                   foreach ($this->_datas['orig_model_type'] as $type)
                       $t_array[] = $type['name_re'];

                   $text[] = $t_array;

                   if (isset($this->_datas['marka'])) $text[] = array(current($t_marka).'.');
               break;
           }

           $text[] = array('Отлаженая работа', 'Отработаная схема работы');
           $text[] = array('курьерской службы', 'службы доставки', 'службы курьерской доставки');
           $text[] = array('позволяет нам', 'дает нам возможность');
           $text[] = array('принимать');
           $text[] = array('на ремонт');
           $text[] = array('технику', 'аппараты');
           $text[] = array('со всех ');
           $text[] = array('районов '.$this->_datas['region']['name_re'].',');
           $text[] = array('за мастерами', 'за специалистами', 'за курьерами', 'за специалистами курьерской службы', 'за специалистами службы доставки');
           $text[] = array('закреплены');
           $text[] = array('основные', 'популярные');
           $text[] = array('станции метро -', 'метро -');
           $text[] = array('это позволяет ');
           $text[] = array('выезжать ', 'приезжать', 'добираться');

           $t_array = array('за 20-30 минут', 'за 25-30 минут', 'за 20-40 минут', 'за 25-40 минут', 'за 25-35 минут', 'за 20-45 минут', 'за 25-45 минут');
           $text[] = array(tools::get_rand($t_array, $f));
           $text[] = array('в');
           $text[] = array('любую точку');

           if ($params['region_id'])
           {
               $text[] = array('города.</p>');
           }
           else
           {
               $text[] = array('города.');
               $text[] = array('Выезд в пределах МКАД бесплатный.</p>', 'В пределах МКАД выезжаем бесплатно.</p>');
           }

           $block_text = array();

           $j = 0;
           $block_text[$j][] = array('<div class="tables"><div class="title">Цены</div><div class="preiman">Стоимость работ',
               '<div class="tables"><div class="title">Цены</div><div class="preiman">Стоимость услуг');
           $block_text[$j][] = array('зависит');

           $t_array = array();
           $t1_array = array('от типа устройства,', 'от типа техники,', 'от модели устройства,', 'от модели аппарата,');
           $t2_array = array('от характера повреждения,', 'от характера поломки,', 'от степени повреждения,');

           foreach ($t1_array as $t1)
           {
               foreach ($t2_array as $t2)
               {
                   $t_array[] = $t1.' '.$t2;
                   $t_array[] = $t2.' '.$t1;
               }
           }

           $block_text[$j][] = $t_array;
           $block_text[$j][] = array('никаких сюрпризов -');
           $block_text[$j][] = array('все цены');
           $block_text[$j][] = array('регламентированы', 'зафиксированы');
           $block_text[$j][] = array('прайс-листом</div></div>', 'прайсом</div></div>');

           $j++;

           $block_text[$j][] = array('<div class="tables"><div class="title">Оборудование</div><div class="preiman">Работаем');
           $block_text[$j][] = array('на проффессиональных');
           $block_text[$j][] = array('паяльных станциях', 'ремонтных системах', 'ремонтных станциях', 'паяльных системах', 'паяльных комплексах',
                   'ремонтных комплексах', 'паяльно-ремонтных комплексах', 'паяльно-ремонтных системах', 'паяльно-ремонтных центрах', 'паяльно-ремонтных станциях');

           $block_text[$j][] = array('с ИК нагревом</div></div>', 'с ИК подогревом</div></div>', 'с верхним/нижним ИК подогревом</div></div>', 'с верхним/нижним ИК нагревом</div></div>',
                   'с нижним/верхним ИК подогревом</div></div>', 'с нижним/верхним ИК нагревом</div></div>', 'для монтажа BGA элементов</div></div>',
                   'для монтажа BGA компонент</div></div>', 'для монтажа/демонтажа BGA компонент</div></div>', 'для монтажа BGA элементов</div></div>');

           $j++;

           $block_text[$j][] = array(
               '<div class="tables"><div class="title">Сотрудники</div><div class="preiman">Наши мастера -',
               '<div class="tables"><div class="title">Сотрудники</div><div class="preiman">Наши ремонтные мастера -');
           $block_text[$j][] = array('сертифицированные', 'дипломированные');
           $block_text[$j][] = array('специалисты', 'спецы');
           $block_text[$j][] = array('с опытом ремонта', 'с практическим опытом ремонта', 'с ежедневным опытом ремонта', 'с непрерывным опытом ремонта');

           foreach ($this->_datas['orig_model_type'] as $type)
                       $t_array[] = $type['name_re'];

           $block_text[$j][] = $t_array;

           if (isset($this->_datas['marka'])) $block_text[$j][] = array($this->_datas['marka']['name'], $this->_datas['marka']['ru_name']);

           $t_array = array();
           $t_array[] = array('больше 3 лет', 'более 3 лет', 'больше трех лет', 'более трех лет');
           $t_array[] = array('больше 7 лет', 'более 7 лет', 'больше семи лет', 'более семи лет');
           $t_array[] = array('больше 4 лет', 'более 4 лет', 'больше четырех лет', 'более четырех лет');
           $t_array[] = array('больше 8 лет', 'более 8 лет', 'больше восьми лет', 'более восьми лет');
           $t_array[] = array('больше 5 лет', 'более 5 лет', 'больше пяти лет', 'более пяти лет');
           $t_array[] = array('больше 9 лет', 'более 9 лет', 'больше девяти лет', 'более девяти лет');
           $t_array[] = array('больше 6 лет', 'более 6 лет', 'больше шести лет', 'более шести лет');
           $t_array[] = array('больше 10 лет', 'более 10 лет', 'больше десяти лет', 'более десяти лет');

           $t_array = tools::get_rand($t_array, $f);

           foreach ($t_array as $key => $value)
               $t_array[$key] = $value.'</div></div>';

           $block_text[$j][] = $t_array;

           $block_text = rand_it::randMas($block_text, count($block_text), '', $feed);

           $this->_datas['block_text'] = '';

           foreach ($block_text as $var)
               $this->_datas['block_text'] .= sc::_createTree($var, $feed);
         }

        $total = array();
        $choose = rand(0, 1);
        $v = array('и выявление', 'и нахождение', 'и обнаружение', 'и определение', 'и поиск');

        switch ($choose)
        {
            case 0:
                $total[] = array('<p>Диагностика', '<p>Экспресс диагностика');
                $total[] = $v;
                $total[] = array('аппаратных', 'программных', 'аппаратных и программных', 'программных и аппаратных');
            break;
            case 1:
                $total[] = array('<p>Программная диагностика', '<p>Аппаратная диагностика', '<p>Программная/аппаратная диагностика', '<p>Аппаратная/программная диагностика');
                $total[] = $v;
                $total[] = array('любых', '');
            break;
        }

        $total[] = array('неисправностей', 'ошибок', 'проблем', 'неполадок');

        $t_array = array('в работе устройств', 'в работе техники');

        foreach ($this->_datas['orig_model_type'] as $type)
            $t_array[] = 'в работе '.$type['name_re'];

        if (isset($params['marka_id']) && isset($params['model_type_id']))
            $t2 = array($this->_datas['marka']['name'], $this->_datas['marka']['ru_name']);

        if (isset($params['marka_id']))
            $t2 = array($this->_datas['marka']['name']);

        if (isset($params['m_model_id']))
            $t2 = array($this->_datas['marka']['name'].' '.$this->_datas['m_model']['name']);

        if (isset($params['model_id']))
            $t2 = array($this->_datas['model']['name']);

        if (isset($params['geo_id']))
            $t2 = array($this->_datas['geo']['name']);

        $t1 = $t_array;
        $t1[] = 'устройств';

        foreach ($t1 as $value1)
            foreach ($t2 as $value2)
                $t_array[] = $value1.' '.$value2;

        $total[] = $t_array;
        $total[] = array('проводится', 'производится', 'выполняется');
        $total[] = array('бесплатно,', 'БЕСПЛАТНО,');
        $minuts = tools::get_diagnostic_minuts($this->_datas['site_name']);

        $minuts1 = tools::declOfNum($minuts, array('минуты', 'минут', 'минут'));
        $minuts2 =  tools::declOfNum($minuts, array('минуту', 'минуты', 'минут'));

        $total[] = array('в течении '.$minuts1.'.</p>', 'за '.$minuts2.'.</p>', 'в среднем за '.$minuts2.'.</p>', '~'.$minuts2.'.</p>', 'в пределах '.$minuts1.'.</p>');

        $this->_datas['preims'] = '';
        $ret['text'] = sc::_createTree($text, $feed);
        $this->_datas['text2'] = '';
        $this->_datas['total'] = '';

        foreach ($preims as $var)
            $this->_datas['preims'] .= sc::_createTree($var, $feed);

        if ($text2) $this->_datas['text2'] = sc::_createTree($text2, $feed);

        $this->_datas['total'] = sc::_createTree($total, $feed);

        foreach (array('h1', 'title', 'description', 'plain') as $key)
                if (isset($ret[$key])) $ret[$key] =  implode(' ', $ret[$key]);

        if (isset($this->_datas['img'])) $ret['img'] = $this->_datas['img'];

        $this->_ret = $this->_answer($answer, $ret);
        
        $this->_sdek();
        
        $body = $this->_body($file_name, basename(__FILE__, '.php'));

        //return array('title' => $this->_ret['title'], 'description' => $this->_ret['description'], 'body' => $body);
        return array('body' => $body);
    }

    protected function indexSite()
    {
        $str = '';
        $file = __DIR__.'/pages/sc3_1/indexSite.php';

        $this->_datas['m_models'] = $this->dbh->query("SELECT model_types.name as 'type', LOWER(markas.name) as 'marka', m_models.name as 'name' FROM  m_models JOIN model_types ON m_models.model_type_id = model_types.id JOIN markas ON m_models.marka_id = markas.id ORDER BY m_models.frequency DESC LIMIT 12")->fetchAll(\PDO::FETCH_ASSOC);

        $this->_datas['models'] = $this->dbh->query("SELECT model_types.name as 'type', LOWER(markas.name) as 'marka', models.name as 'name' FROM `models` JOIN m_models ON models.m_model_id = m_models.id JOIN model_types ON m_models.model_type_id = model_types.id JOIN markas ON m_models.marka_id = markas.id ORDER BY models.frequency DESC LIMIT 12")->fetchAll(\PDO::FETCH_ASSOC);

        if (file_exists($file))
        {
            ob_start();
            include $file;
            $str = preg_replace(array('/ {2,}/','/\t|(?:\r?\n[ \t]*)+/s'),array(' ',''), ob_get_contents());
            ob_end_clean();
        }
        return $str;
    }

    public function urlType($type, $comp = false, $marka = false) {
      $typesUrl = [
        'ноутбук' => 'noutbukov',
        'планшет' => 'planshetov',
        'телефон' => 'telefonov',
        'смартфон' => 'telefonov',
      ];
      $marka = $marka === false ? $this->_datas['marka']['name'] : $marka;
      if (isset($typesUrl[$type]))
        return ($comp ? 'zapchasti_dlya_' : 'remont_').$typesUrl[$type].($marka != 'none' ? '_'.strtolower($marka) : '');
      else
        return '';
    }

    public function clearBrandLin($model, $brand, $lin = false) {
      $lin = $lin !== false ? "|".$lin."[\s-]" : '';
      return preg_replace("/(".$brand."[\s-]".$lin.")/i", '', $model);
    }

    public function translit($string) {
        $converter = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '',  'ы' => 'y',   'ъ' => '',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
            'Ь' => '',  'Ы' => 'Y',   'Ъ' => '',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
        );
        return mb_strtolower(preg_replace('/(\s+|\.)/', '_', strtr($string, $converter)));
    }

    public function costComplect($costs, $id) {
      $costs = explode(';', $costs);
      if (isset($this->_datas['marka']['id'])) {
        $srand = isset($this->_datas['m_model']) ? $this->_datas['m_model']['id'] : (isset($this->_datas['model']) ? $this->_datas['model']['id'] : $this->_datas['marka']['id']);
        srand($id*$srand);
        $cost = $costs[array_rand($costs)];
        srand();
      }
      else {
        $cost = $costs[0];
      }
      return $cost;
    }

    public function randomSyns($name, $syns, $synsArr = false, $srand = false) {
      if (!$synsArr && $syns == '') {
        $syns = [];
      }
      else if (!$synsArr) {
        $syns = explode('@', $syns);
      }
      $names = array_merge([$name], $syns);
      srand($srand === false ? $this->_datas['feed'] : $srand);
      $res = $names[array_rand($names)];
      srand();
      return $res;
    }

    public function randAmount($id) {
      $srand = isset($this->_datas['m_model']) ? $this->_datas['m_model']['id'] : (isset($this->_datas['model']) ? $this->_datas['model']['id'] : (isset($this->_datas['marka']['id']) ? $this->_datas['marka']['id'] : 1));
      srand($srand*$id);
      $amount = rand(1, 4);
      srand();
      return $amount;
    }

    private function prepareSeo(&$arr) {
      foreach (['title', 'h1', 'description', 'plain'] as $item) {
        if (isset($arr[$item])) {
          if (!is_array($arr[$item]))
            $arr[$item] = [$arr[$item]];

          foreach ($arr[$item] as $k=>$v) {
            $model = (isset($this->_datas['model']) ? $this->_datas['model']['name'] : (isset($this->_datas['m_model']) ? $this->_datas['m_model']['name'] : $this->brandName(1)));
            $arr[$item][$k] = strtr($arr[$item][$k], [
              '[brand]' => $this->brandName(1),
              '[city]' => $this->_datas['region']['name_pe'],
              '[cost]' => isset($this->_datas['price']) ? $this->_datas['price'] : '',
              '[brand2]' => $this->brandName(2),
              '[model]' => $model,
            ]);
          }
        }
      }
    }

    public function brandName($num) {
      $brands = [
        1 => [
          'ноутбук' => [
            'apple' => 'Макбук',
            'asus' => 'Asus',
            'hp' => 'HP',
            'acer' => 'Acer',
            'lenovo' => 'Леново',
            'samsung' => 'Самсунг',
            'sony' => 'Sony',
            'dell' => 'Dell',
            'toshiba' => 'Тошиба',
            'xiaomi' => 'Xiaomi',
          ],
        ],
        2 => [
          'ноутбук' => [
            'apple' => 'Macbook',
            'asus' => 'Асус',
            'hp' => 'Эйч пи',
            'acer' => 'Асер',
            'lenovo' => 'Lenovo',
            'samsung' => 'Samsung',
            'sony' => 'Сони',
            'dell' => 'Делл',
            'toshiba' => 'Toshiba',
            'xiaomi' => 'Сяоми',
          ],
          'планшет' => [
            'apple' => 'Айпад',
            'asus' => 'Асус',
            'hp' => 'HP',
            'acer' => 'Асер',
            'lenovo' => 'Lenovo',
            'samsung' => 'Samsung',
            'sony' => 'Сони',
            'dell' => 'Делл',
            'toshiba' => 'Toshiba',
            'xiaomi' => 'Сяоми',
            'htc' => 'HTC',
            'huawei' => 'Хуавей',
            'meizu' => 'Мейзу',
          ],
        ],
      ];

      if (isset($brands[$num][$this->_datas['model_type']['name']][strtolower($this->_datas['marka']['name'])])) {
        return $brands[$num][$this->_datas['model_type']['name']][strtolower($this->_datas['marka']['name'])];
      }
      else if ($num == 2) {
        return $this->_datas['marka']['ru_name'];
      }
      else {
        return $this->_datas['marka']['name'];
      }
    }

    private function sitemap($sm) {
      if ($sm == 'general') {
        $this->_ret = [
          'title' => 'Карта сайта',
          'desc' => 'Карта сайта',
          'h1' => 'Карта сайта: популярные виды ремонтов',
        ];

        $sitemap = [];

        $stmt = $this->dbh->query("SELECT model_types.id as 'id', model_types.name as 'name', model_types.name_rm as 'name_rm', GROUP_CONCAT(DISTINCT CONCAT(markas.id, '~', markas.name) SEPARATOR ';') as 'markas' FROM m_models JOIN markas ON m_models.marka_id = markas.id JOIN model_types ON m_models.model_type_id = model_types.id GROUP BY m_models.model_type_id");

        $ttmArr = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $ttm = [];

        foreach ($ttmArr as $item) {
          $markasArr = explode(';', $item['markas']);
          $markas = [];
          foreach ($markasArr as $marka) {
            $m = explode('~', $marka);
            $markas[$m[0]] = $m[1];
          }
          $ttm[$item['id']] = [
            'name' => $item['name'],
            'name_rm' => $item['name_rm'],
            'markas' => $markas,
          ];
        }

        $stmt = $this->dbh->query("SELECT m_models.name as 'name', m_models.model_type_id as 'type', m_models.marka_id as 'marka' FROM m_models WHERE frequency > 0
        UNION
        SELECT models.name as 'name', m_models.model_type_id as 'type', m_models.marka_id as 'marka' FROM models JOIN m_models ON models.m_model_id = m_models.id");

        $ms = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $models = [];
        foreach ($ms as $m) {
          $models[$m['type']][$m['marka']][] = $m['name'];
        }

        $stmt = $this->dbh->prepare("SELECT name FROM geo WHERE city_id = ?");
        $stmt->execute([$this->_datas['region']['id']]);
        $geo = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($ttm as $tid=>$type) {
          $sm = [
            'title' => 'Ремонт '.self::firstup($type['name_rm']),
            'list' => [],
          ];

          foreach ($type['markas'] as $mid=>$marka) {
            $smBrand = [[strtolower($marka) => $marka], []];
            $prefixUrl = $this->urlType($type['name'], false, $marka);
            if (isset($models[$tid][$mid])) {
              foreach ($models[$tid][$mid] as $m) {
                $url = $prefixUrl.'/'.$this->translit($this->clearBrandLin($m, $marka));
                $smBrand[1][$url] = $m;
              }
            }
            $sm['list'][] = $smBrand;
          }

          $smGeo = [];
          $prefixUrl = $this->urlType($type['name'], false, 'none');
          foreach ($geo as $g) {
             $url = $prefixUrl.'/'.$this->translit($g['name']);
             $smGeo[$url] = $g['name'];
          }
          $sm['list'][] = [$smGeo];

          $sitemap[] = $sm;
        }

        $this->_datas['sitemap'] = $sitemap;
      }
      else if (is_array($sm)) {
        if ($sm['type'] == 'type') {
          $type = $sm['type_id'];

          $sitemap = [];

          $stmt = $this->dbh->query("SELECT * FROM model_types WHERE id = $type");
          $mtype = $stmt->fetch(\PDO::FETCH_ASSOC);

          $this->_ret = [
            'title' => 'Карта сайта '.$this->_datas['servicename'].' - '.$mtype['name_m'],
            'desc' => 'Карта сайта',
            'h1' => 'Карта сайта: популярные виды ремонта '.$mtype['name_rm'],
          ];

          $stmt = $this->dbh->query("SELECT DISTINCT markas.id, markas.name FROM m_models JOIN markas ON m_models.marka_id = markas.id WHERE m_models.model_type_id = $type");

          $markasArr = $stmt->fetchAll(\PDO::FETCH_ASSOC);
          $markas = [];
          foreach ($markasArr as $m) {
            $markas[$m['id']] = $m['name'];
          }

          $stmt = $this->dbh->query("SELECT m_models.name as 'name', m_models.marka_id as 'marka' FROM m_models WHERE m_models.model_type_id = $type AND frequency > 0
          UNION
          SELECT models.name as 'name', m_models.marka_id as 'marka' FROM models JOIN m_models ON models.m_model_id = m_models.id WHERE m_models.model_type_id = $type");

          $ms = $stmt->fetchAll(\PDO::FETCH_ASSOC);

          $models = [];
          foreach ($ms as $m) {
            $models[$m['marka']][] = $m['name'];
          }

          $stmt = $this->dbh->query("SELECT name, url FROM services WHERE model_type_id = $type");
          $services = $stmt->fetchAll(\PDO::FETCH_ASSOC);

          $stmt = $this->dbh->prepare("SELECT name FROM geo WHERE city_id = ?");
          $stmt->execute([$this->_datas['region']['id']]);
          $geo = $stmt->fetchAll(\PDO::FETCH_ASSOC);

          foreach ($markas as $mid=>$marka) {
            $sm = [
              'title' => 'Ремонт '.$mtype['name_rm'].' '.$marka,
              'list' => [],
            ];

            $smBrand = [];

            $prefixUrl = $this->urlType($mtype['name'], false, $marka);

            foreach ($services as $s) {
              $url = $prefixUrl.'/'.$s['url'];
              $smBrand[0][0][$url] = $s['name'];
            }

            if (isset($models[$mid])) {
              foreach ($models[$mid] as $m) {
                $url = $prefixUrl.'/'.$this->translit($this->clearBrandLin($m, $marka));
                $smBrand[$m][0][$url] = $m;
                foreach ($services as $s) {
                  $urlS = $url.'/'.$s['url'];
                  $smBrand[$m][1][$urlS] = $s['name'];
                }
              }
            }

            foreach ($geo as $g) {
              $url = $prefixUrl.'/'.$this->translit($g['name']);
              $smBrand[2][0][$url] = $g['name'];
            }

            $sm['list'] = $smBrand;

            $sitemap[] = $sm;
          }

          $this->_datas['sitemap'] = $sitemap;

        }
      }
    }
    
    private function _make_accord_table($marka_lower)
    {
        $this->_datas['add_url'] = array(            
                    'Acer' => array ('remont_computerov', 'remont_monitorov', 'remont_monoblockov', 'remont_projectorov', 'remont_televizorov','remont_smart_chasov'),
                    'Apple' => array ('remont_computerov', 'remont_monitorov', 'remont_monoblockov', 'remont_printerov', 'remont_televizorov','remont_smart_chasov'),
                    'Asus' => array ('remont_monitorov', 'remont_monoblockov','remont_projectorov','remont_smart_chasov'),
                    'Dell' => array ('remont_computerov', 'remont_monitorov', 'remont_monoblockov', 'remont_printerov', 'remont_projectorov'),
                    'HP' => array ('remont_computerov', 'remont_monitorov', 'remont_monoblockov', 'remont_printerov', 'remont_televizorov', 'remont_plotterov', 'remont_smart_chasov'),
                    'HTC' => array ('remont_televizorov','remont_smart_chasov'),
                    'Huawei' => array ('remont_televizorov','remont_smart_chasov'),
                    'Lenovo' => array ('remont_computerov', 'remont_monitorov', 'remont_monoblockov', 'remont_printerov', 'remont_televizorov','remont_smart_chasov', 'remont_projectorov'),
                    'Samsung' => array ('remont_computerov', 'remont_monitorov', 'remont_monoblockov', 'remont_printerov', 'remont_televizorov', 'remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin', 'remont_projectorov','remont_smart_chasov','remont_photoapparatov','remont_videocamer'),
                    'Sony' => array ('remont_computerov', 'remont_monitorov', 'remont_monoblockov', 'remont_printerov', 'remont_televizorov', 'remont_projectorov', 'remont_photoapparatov','remont_smart_chasov','remont_videocamer', 'remont_igrovyh_pristavok'),
                    'Toshiba' => array ('remont_computerov', 'remont_monitorov', 'remont_televizorov', 'remont_printerov', 'remont_holodilnikov', 'remont_stiralnyh_mashin', 'remont_projectorov'),
                    'Xiaomi' => array ('remont_photoapparatov', 'remont_printerov', 'remont_televizorov', 'remont_naushnikov', 'remont_projectorov', 'remont_smart_chasov', 'remont_kvadrokopterov', 'remont_sigveev', 'remont_elektrosamokatov','remont_monokolyos'),
                    'Alcatel' => array ('remont_telefonov', 'remont_planshetov','remont_smart_chasov'),
                    'Electrolux' => array('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'OnePlus' => array('remont_telefonov'),
                    'Ariston' => array('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'BBK' => array ('remont_televizorov'),
                    'Canon' => array ('remont_printerov', 'remont_photoapparatov', 'remont_monitorov', 'remont_projectorov',  'remont_plotterov', 'remont_videocamer'),
                    'Compaq' => array ('remont_computerov', 'remont_monitorov', 'remont_monoblockov', 'remont_noutbukov'),
                    'Dexp' => array ('remont_computerov', 'remont_monitorov', 'remont_naushnikov', 'remont_monoblockov', 'remont_noutbukov', 'remont_telefonov', 'remont_planshetov', 'remont_televizorov'),
                    'Epson' => array ('remont_printerov', 'remont_projectorov', 'remont_smart_chasov', 'remont_plotterov'),
                    'Fly' => array ('remont_telefonov'),
                    'Fujifilm' => array ('remont_photoapparatov','remont_projectorov'),
                    'Hasselblad' => array ('remont_photoapparatov'),
                    'Leica' => array ('remont_photoapparatov'),
                    'LG' => array ('remont_projectorov', 'remont_televizorov', 'remont_smart_chasov', 'remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'MSI' => array ('remont_computerov', 'remont_monitorov', 'remont_monoblockov'),
                    'Nikon' => array ('remont_photoapparatov'),
                    'Nokia' => array ('remont_planshetov', 'remont_smart_chasov'),
                    'Olympus' => array ('remont_photoapparatov'),
                    'Panasonic' => array ('remont_photoapparatov', 'remont_projectorov', 'remont_holodilnikov','remont_stiralnyh_mashin', 'remont_videocamer','remont_massazhnyh_kresel'),
                    'Polaroid' => array ('remont_photoapparatov'),
                    'Prestigio' => array ('remont_noutbukov', 'remont_telefonov', 'remont_televizorov'),
                    'Sigma' => array ('remont_photoapparatov'),
                    'ZTE' => array ('remont_planshetov','remont_smart_chasov'),
                    'Meizu' => array ('remont_smart_chasov'),
                    'Indesit' => array ( 'remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'BenQ'=> array ( 'remont_projectorov'),
                    'Philips'=> array('remont_smart_chasov', 'remont_projectorov'),
                    'iconBIT'=> array( 'remont_sigveev', 'remont_elektrosamokatov','remont_giroskuterov'),
                    'Digma'=> array('remont_giroskuterov'),
                    'AEG'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Ardo'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Atlant'=> array ('remont_holodilnikov', 'remont_stiralnyh_mashin'),
                    'Bauknecht'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Beko'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Bosch'=> array ('remont_smart_chasov','remont_holodilnikov', 'remont_stiralnyh_mashin'),
                    'Candy'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Gorenje'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Hansa'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Kaiser'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Kuppersberg'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Miele'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Neff'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Sharp'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Siemens'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Smeg'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Vestfrost'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Zanussi'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Blackmagic'=> array ('remont_videocamer'),
                    'JVC'=> array ('remont_videocamer','remont_projectorov'),
                    'Ricoh'=> array ('remont_videocamer','remont_projectorov', 'remont_photoapparatov'),
                    'Brother'=> array ('remont_plotterov'),
                    'GCC'=> array ('remont_plotterov'),
                    'Graphtec'=> array ('remont_plotterov'),
                    'Mimaki'=> array ('remont_plotterov'),
                    'Roland'=> array ('remont_plotterov'),
                    'Silhouette'=> array ('remont_plotterov'),
                    'Vicsign'=> array ('remont_plotterov'),
                    'Barco'=> array ('remont_projectorov'),
                    'Christie'=> array ('remont_projectorov'),
                    'Cinemood'=> array ('remont_projectorov'),
                    'Hitachi'=> array ('remont_projectorov'),
                    'Infocus'=> array ('remont_projectorov'),
                    'Kodak'=> array ('remont_projectorov', 'remont_photoapparatov'),
                    'NEC'=> array ('remont_projectorov'),
                    'Optoma'=> array ('remont_projectorov'),
                    'ViewSonic'=> array ('remont_projectorov'),
                    'Vivitek'=> array ('remont_projectorov'),
                    'Xgimi'=> array ('remont_projectorov'),
                    'Hiper'=> array ('remont_giroskuterov','remont_elektrosamokatov'),
                    'Hoverbot'=> array ('remont_giroskuterov','remont_monokolyos','remont_sigveev'),
                    'Razor'=> array ('remont_giroskuterov','remont_elektrosamokatov'),
                    'Zaxboard'=> array ('remont_giroskuterov','remont_elektrosamokatov'),
                    'DJI'=> array ('remont_kvadrokopterov'),
                    'Hubsan'=> array ('remont_kvadrokopterov'),
                    'Walkera'=> array ('remont_kvadrokopterov'),
                    'Xiro'=> array ('remont_kvadrokopterov'),
                    'Airwheel'=> array ( 'remont_monokolyos','remont_sigveev','remont_elektrosamokatov'),
                    'Gotway'=> array ( 'remont_monokolyos'),
                    'Inmotion'=> array ( 'remont_monokolyos','remont_sigveev','remont_elektrosamokatov'),
                    'KingSong'=> array ( 'remont_monokolyos'),
                    'Eltreco'=> array ('remont_elektrosamokatov'),
                    'e-TWOW'=> array ('remont_elektrosamokatov'),
                    'Globber'=> array ('remont_elektrosamokatov'),
                    'Halten'=> array ('remont_elektrosamokatov'),
                    'Kugoo'=> array ('remont_elektrosamokatov'),
                    'Takasima'=> array ('remont_massazhnyh_kresel'),
                    'Yamaguchi'=> array ('remont_massazhnyh_kresel'),
                    'Ergonova'=> array ('remont_massazhnyh_kresel'),
                    'Inada'=> array ('remont_massazhnyh_kresel'),
                    'Casada'=> array ('remont_massazhnyh_kresel'),
                    'Sensa'=> array ('remont_massazhnyh_kresel'),
                    'Irest'=> array ('remont_massazhnyh_kresel'),
                    'Us medica'=> array ('remont_massazhnyh_kresel'),
                    'UNO'=> array ('remont_massazhnyh_kresel'),
                    'EGO'=> array ('remont_massazhnyh_kresel'),
                    'Gess'=> array ('remont_massazhnyh_kresel'),
                    'Victoryfit'=> array ('remont_massazhnyh_kresel'),
                    'Richter'=> array ('remont_massazhnyh_kresel'),
                    'Restart'=> array ('remont_massazhnyh_kresel'),
                    'Bork'=> array ('remont_massazhnyh_kresel'),
                    'Sanyo'=> array ('remont_massazhnyh_kresel'),
                    'Beurer'=> array ('remont_massazhnyh_kresel'),
                    'Fujiiryoki'=> array ('remont_massazhnyh_kresel'),
                    'Nvidia'=> array ( 'remont_igrovyh_pristavok'),
                    'Microsoft'=> array ( 'remont_igrovyh_pristavok'),
                    'Nintendo'=> array ( 'remont_igrovyh_pristavok')
		);
        
        $urls = [];
        foreach ($this->_datas['add_url'] as $key => $value)
            $urls[mb_strtolower($key)] = $value;
        
        $this->_datas['add_device_type'] = $add_device_type = array(
            'remont_computerov' => array('type' => 'компьютер', 'type_rm' => 'компьютеров', 'type_m' => 'компьютеры', 'type_de' => 'компьютером', 'type_re' => 'компьютера'),
            'remont_naushnikov' => array('type' => 'наушники', 'type_rm' => 'наушников', 'type_m' => 'наушники', 'type_de' => 'наушниками', 'type_re' => 'наушников'),
            'remont_printerov' => array('type' => 'принтер', 'type_rm' => 'принтеров', 'type_m' => 'принтеры', 'type_de' => 'принтером', 'type_re' => 'принтера'),
            'remont_photoapparatov' => array('type' => 'фотоаппарат', 'type_rm' => 'фотоаппаратов', 'type_m' => 'фотоаппараты', 'type_de' => 'фотоаппаратом', 'type_re' => 'фотоаппарата'),
            'remont_monoblockov' => array('type' => 'моноблок', 'type_rm' => 'моноблоков', 'type_m' => 'моноблоки', 'type_de' => 'моноблоком', 'type_re' => 'моноблока'),
            'remont_projectorov' => array('type' => 'проектор', 'type_rm' => 'проекторов', 'type_m' => 'проекторы', 'type_de' => 'проектором', 'type_re' => 'проектора'),
            'remont_televizorov' => array('type' => 'телевизор', 'type_rm' => 'телевизоров', 'type_m' => 'телевизоры', 'type_de' => 'телевизором', 'type_re' => 'телевизора'),
            'remont_monitorov' => array('type' => 'монитор', 'type_rm' => 'мониторов', 'type_m' => 'мониторы', 'type_de' => 'монитором', 'type_re' => 'монитора'),
            'remont_telefonov' => array('type' => 'смартфон', 'type_rm' => 'смартфонов', 'type_m' => 'смартфоны', 'type_de' => 'смартфоном', 'type_re' => 'смартфона'),
            'remont_noutbukov' => array('type' => 'ноутбук', 'type_rm' => 'ноутбуков', 'type_m' => 'ноутбуки', 'type_de' => 'ноутбуком', 'type_re' => 'ноутбука'),
            'remont_planshetov' => array('type' => 'планшет', 'type_rm' => 'планшетов', 'type_m' => 'планшеты', 'type_de' => 'планшетом', 'type_re' => 'планшета'),
            //новые устройства:
            'remont_kvadrokopterov' => array('type' => 'квадрокоптер', 'type_rm' => 'квадрокоптеров', 'type_m' => 'квадрокоптеры', 'type_de' => 'квадрокоптером', 'type_re' => 'квадрокоптера'),
            'remont_sigveev' => array('type' => 'сегвей', 'type_rm' => 'сегвеев', 'type_m' => 'сегвеи', 'type_de' => 'сегвеем', 'type_re' => 'сегвея'),
            'remont_elektrosamokatov' => array('type' => 'электросамокат', 'type_rm' => 'электросамокатов', 'type_m' => 'электросамокаты', 'type_de' => 'электросамокатом', 'type_re' => 'электросамоката'),
            'remont_giroskuterov' => array('type' => 'гироскутер', 'type_rm' => 'гироскутеров', 'type_m' => 'гироскутеры', 'type_de' => 'гироскутером', 'type_re' => 'гироскутера'),
            'remont_monokolyos' => array('type' => 'моноколесо', 'type_rm' => 'моноколес', 'type_m' => 'моноколеса', 'type_de' => 'моноколесом', 'type_re' => 'моноколеса'),
            'remont_videocamer' => array('type' => 'видеокамера', 'type_rm' => 'видеокамер', 'type_m' => 'видеокамеры', 'type_de' => 'видеокамерой', 'type_re' => 'видеокамеры'),
            'remont_plotterov' => array('type' => 'плоттер', 'type_rm' => 'плоттеров', 'type_m' => 'плоттеры', 'type_de' => 'плоттером', 'type_re' => 'плоттера'),
            'remont_smart_chasov' => array('type' => 'смарт-часы', 'type_rm' => 'смарт-часов', 'type_m' => 'смарт-часы', 'type_de' => 'смарт-часами', 'type_re' => 'смарт-часов'),
            'remont_holodilnikov' => array('type' => 'холодильник', 'type_rm' => 'холодильников', 'type_m' => 'холодильники', 'type_de' => 'холодильником', 'type_re' => 'холодильника'),
            'remont_posudomoechnyh_mashin' => array('type' => 'посудомоечная машина', 'type_rm' => 'посудомоечных машин', 'type_m' => 'посудомоечные машины', 'type_de' => 'посудомоечной машиной', 'type_re' => 'посудомоечной машины'),
            'remont_stiralnyh_mashin' => array('type' => 'стиральная машина', 'type_rm' => 'стиральных машин', 'type_m' => 'стиральные машины', 'type_de' => 'стиральной машиной', 'type_re' => 'стиральной машины'),
            'remont_massazhnyh_kresel' => array('type' => 'массажное кресло', 'type_rm' => 'массажных кресел', 'type_m' => 'массажные кресла', 'type_de' => 'массажным креслом', 'type_re' => 'массажного кресла'),
            'remont_igrovyh_pristavok' => array('type' => 'игровая приставка', 'type_rm' => 'игровых приставок', 'type_m' => 'игровые приставки', 'type_de' => 'игровой приставкой', 'type_re' => 'игровой приставки')
            //ноутбуков remont_noutbukov, планшетов remont_planshetov
        );
        
        if (isset($urls[$marka_lower]))
        {
            $t = array();
            foreach ($urls[$marka_lower] as $url)
                $t[] = $add_device_type[$url];
            $this->_datas['all_devices'] = array_merge($this->_datas['all_devices'], $t);
        }
        
        
        $this->_datas['accord_image'] = array(
            'компьютер' => 'computer',
            'ноутбук' => 'noutbuk', 
            'планшет' => 'planshet', 
            'смартфон' => 'telefon',
            'наушники' => 'naushnik',
            'принтер' => 'printer',
            'фотоаппарат' => 'photoapparat',
            'моноблок' => 'monoblock',
            'проектор' => 'projector',
            'телевизор' => 'televizor',
            'монитор' => 'monitor',
            'квадрокоптер' => 'kvadrokopter',
            'сегвей' => 'sigvej',
            'электросамокат' => 'elektrosamokat',
            'гироскутер' => 'giroskuter',
            'моноколесо' => 'monokoleso',
            'видеокамера' => 'videocamera',
            'плоттер' => 'plotter',
            'смарт-часы' => 'smart_chasy',
            'холодильник' => 'holodilnik',
            'посудомоечная машина' => 'posudomoechnaya_mashina',
            'стиральная машина' => 'stiralnaya_mashina',
            'массажное кресло' =>'massazhnoe_kreslo',
            'игровая приставка'=>'igrovaya_pristavka'
         );
         
         $this->_datas['accord'] = array(
            'компьютер' => 'remont_computerov',
            'ноутбук' => 'remont_noutbukov', 
            'планшет' => 'remont_planshetov', 
            'смартфон' => 'remont_telefonov',
            'наушники' => 'remont_naushnikov',
            'принтер' => 'remont_printerov',
            'фотоаппарат' => 'remont_photoapparatov',
            'моноблок' => 'remont_monoblockov',
            'проектор' => 'remont_projectorov',
            'телевизор' => 'remont_televizorov',
            'монитор' => 'remont_monitorov',
            'квадрокоптер' => 'remont_kvadrokopterov',
            'сегвей' => 'remont_sigveev',
            'электросамокат' => 'remont_elektrosamokatov',
            'гироскутер' => 'remont_giroskuterov',
            'моноколесо' => 'remont_monokolyos',
            'видеокамера' => 'remont_videocamer',
            'плоттер' => 'remont_plotterov',
            'смарт-часы' => 'remont_smart_chasov',
            'холодильник' => 'remont_holodilnikov',
            'посудомоечная машина' => 'remont_posudomoechnyh_mashin',
            'стиральная машина' => 'remont_stiralnyh_mashin',
            'массажное кресло' => 'remont_massazhnyh_kresel',
            'игровая приставка'=> 'remont_igrovyh_pristavok'
         );   
    }
    
    private function _sdek()
    {
        $this->_datas['sdek'] = false;
        if ($this->_datas['partner']['email'] == 'litovchenko@list.ru')
        {
            $point = $this->_one_point($this->_datas['region']['name'], $this->_datas['setka_name']);
            if ($point)
            {
                $this->_datas['partner']['x'] = $point[0];
                $this->_datas['partner']['y'] = $point[1];
                $this->_datas['partner']['exclude'] = 1;
                $this->_datas['wide'] = 1;
            }
        }
        return;
    }
}

?>
