<?

namespace framework\ajax\parse\hooks;

use framework\pdo;
use framework\tools;
use framework\rand_it;

class sc3 extends sc
{
    public function generate($answer, $params)
    {
        $sql =  "SELECT `model_types`.`name` as `type`, `model_types`.`id` as `type_id`,
                `model_types`.`name_re` as `type_re`, `model_types`.`name_rm` as `type_rm`,
                `model_types`.`name_m` as `type_m` FROM `m_model_to_sites`
            INNER JOIN `m_models` ON `m_models`.`id` = `m_model_to_sites`.`m_model_id`
            INNER JOIN `model_types` ON `m_models`.`model_type_id` = `model_types`.`id` WHERE `m_model_to_sites`.`site_id`= ? GROUP BY `model_types`.`name`";
        $stm = pdo::getPdo()->prepare($sql);
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
        
        $marka_lower = mb_strtolower($this->_datas['marka']['name']);

        if (isset($params['static']))
        {
            $file_name = ($params['static'] == '/') ? 'index' : $params['static'];

            if (in_array($this->_datas['region']['name'], ['Новосибирск', 'Нижний Новгород', 'Екатеринбург', 'Казань', 'Санкт-Петербург', 'Москва']) && isset($params['marka_id'])) {
              $stmt = pdo::getPdo()->prepare("SELECT `model_types`.`name` as `type`, `model_types`.`id` as `type_id`,
                      `model_types`.`name_re` as `type_re`, `model_types`.`name_rm` as `type_rm`,
                      `model_types`.`name_m` as `type_m` FROM `m_models` INNER JOIN `model_types` ON `m_models`.`model_type_id` = `model_types`.`id`
                      WHERE m_models.marka_id = ? GROUP BY model_types.id");
              $stmt->execute([$params['marka_id']]);
              $this->_datas['all_devices'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }

            if ($file_name)
            {
                $this->_datas = $this->_datas + $params;

                if (isset($params['marka_id'])) {
                  $sql = "SELECT * FROM `markas` WHERE `id`= ?";
                  $stm = pdo::getPdo()->prepare($sql);
                  $stm->execute(array($params['marka_id']));
                  $this->_datas['marka'] = current($stm->fetchAll(\PDO::FETCH_ASSOC));
                }

                if ($file_name != 'indexSite') {

                  $text = array();
                  $feed = $this->_datas['feed'];

                  //gen
                  $text['komplektuyushie']['name'] = array('Качественные комплектующие');

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
                  $text['neispravnosti']['text'][] = array('аппаратов '.(isset($this->_datas['marka']['name']) ? $this->_datas['marka']['name'] : ''), 'техники '.(isset($this->_datas['marka']['name']) ? $this->_datas['marka']['name'] : ''));
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
                      $newKey = in_array($this->_datas['region']['name'], ['Новосибирск', 'Нижний Новгород', 'Екатеринбург', 'Казань', 'Санкт-Петербург', 'Москва']) && $key != 'dostavka' ? str_replace('komplektuyushie', 'zapchasti', $key).'_'.mb_strtolower($this->_datas['marka']['name']) : $key;
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
                
                $this->_make_accord_table($marka_lower);

                switch ($file_name)
                {
                    //!
                    case 'neispravnosti':
                       $title = 'Типовые неисправности устройств '.$this->_datas['marka']['name']. ' | '.$params['servicename'].' '.$this->_datas['region']['translit1'];
                       $description = 'Популярные виды неисправностей - от разбитых стекол до перепайки сгоревших BGA-чипов.';
                       $h1 = 'Ремонт любых неисправностей';
                    break;
                    //!
                    case 'komplektuyushie':
                       $title = 'Детали, запчасти и комплектующие для устройств '.$this->_datas['marka']['name'].' | '.$params['servicename'].' '.$this->_datas['region']['translit1'];
                       $description = 'Условия установки и продажи комплектующих в лаборатории '.$params['servicename'].', гарантия на устанавливаемые запасные части.';
                       $h1 = 'Качественные комплектующие';
                    break;
                    //!
                    case 'diagnostika':
                       $title = 'Диагностика техники '.$this->_datas['marka']['ru_name'].' в '.$params['servicename'].' '.$this->_datas['region']['translit1'];
                       $description = 'Условия диагностики аппаратов '.$this->_datas['marka']['name'].' в сервисном центре '.$params['servicename'].' и на выезде к заказчику.';
                       $h1 = 'Срочная диагностика, техзаключение';
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
                        $h1 = 'Цены';
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
                            WHERE `setkas`.`id`= ? GROUP BY region_name ORDER BY `sites`.`id` ASC";

                        $stm = pdo::getPdo()->prepare($sql);
                        $stm->execute(array($params['setka_id']));
                        $this->_datas['addresis'] = $stm->fetchAll(\PDO::FETCH_ASSOC);

                        return array('body' => $this->indexSite());
                    break;
                }

                // addresis
                $this->_datas['addresis'] = $this->_getAddresis($params['setka_id'], $this->_datas['marka']['id']);

                $this->_ret['title'] = $title;
                $this->_ret['h1'] = $h1;
                $this->_ret['description'] = $description;

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

        if (!$level) $this->_sqlData($params);
        $this->_make_accord_table(mb_strtolower($this->_datas['marka']['name']));

        if (in_array($this->_datas['region']['name'], ['Новосибирск', 'Нижний Новгород', 'Екатеринбург', 'Казань', 'Санкт-Петербург', 'Москва']) && isset($this->_datas['marka']['id'])) {
          $stmt = pdo::getPdo()->prepare("SELECT `model_types`.`name` as `type`, `model_types`.`id` as `type_id`,
                  `model_types`.`name_re` as `type_re`, `model_types`.`name_rm` as `type_rm`,
                  `model_types`.`name_m` as `type_m` FROM `m_models` INNER JOIN `model_types` ON `m_models`.`model_type_id` = `model_types`.`id`
                  WHERE m_models.marka_id = ? GROUP BY model_types.id");
          $stmt->execute([$this->_datas['marka']['id']]);
          $this->_datas['all_devices'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        // addresis
          $this->_datas['addresis'] = $this->_getAddresis($params['setka_id'], $this->_datas['marka']['id']);

        $ret = array();

        $file_name = '';

        if (isset($params['marka_id']) && isset($params['model_type_id']))
        {
            if (!isset($params['key']))
            {
                $ret['title'] = array(
                    'Ремонт',
                    $this->_datas['model_type'][0]['name_rm'],
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

                $ret['h1'] = array(
                    'Ремонт',
                    $this->_datas['model_type'][1]['name_rm'],
                    $this->_datas['marka']['name']
                  );

                $ret['description'] = array(
                    'Услуги по ремонту',
                    $this->_datas['model_type'][2]['name_rm'],
                    $this->_datas['marka']['ru_name'],
                    $this->_datas['ru_vsemodeli'].'.',
                    $this->_datas['dop']
                );

                $file_name = 'model';
            }
            else
            {
                switch ($params['key'])
                {
                    case 'service':

                        $ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0]),
                            $this->_datas['model_type'][0]['name_re'],
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

                        $ret['h1'] = array(
                            tools::mb_firstupper($this->_datas['syns'][1]),
                            $this->_datas['model_type'][1]['name_rm'],
                            $this->_datas['marka']['name']
                        );

                        $ret['description'] = array(
                            tools::mb_firstupper($this->_datas['syns'][2]),
                            $this->_datas['marka']['ru_name'],
                            $this->_datas['ru_vsemodeli'].'.',
                            $this->_datas['dop']
                        );

                    $file_name = 'model-service';

                    break;
                    case 'defect':

                        $count = count($this->_datas['dop_reasons']);

                        $ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0]),
                            $this->_datas['marka']['ru_name'],
                            '—',
                            $count,
                            tools::declOfNum($count, array('причина', 'причины', 'причин'), false),
                            'поломки',
                            $this->_datas['model_type'][0]['name_re'],
                            '|',
                            $this->_datas['servicename'],
                            $this->_datas['region']['translit1']
                        );

                        $ret['h1'] = array(
                            tools::mb_firstupper($this->_datas['syns'][1]),
                            //$this->_datas['model_type'][1]['name_rm'],
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

                    $file_name = 'model-defect';

                    break;
                    case 'complect':

                        $ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0]),
                            $this->_datas['model_type'][0]['name_rm'],
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
                            $this->_datas['model_type'][1]['name_rm'],
                            $this->_datas['marka']['name']
                        );

                        $ret['description'] = array(
                            tools::mb_firstupper($this->_datas['syns'][2]),
                            $this->_datas['marka']['name'],
                            $this->_datas['vsemodeli'].'.',
                            $this->_datas['dop']
                        );

                    $file_name = 'model-complect';

                    break;
                }
            }
        }

        if (isset($params['sublineyka_id']))
        {
            if (!isset($params['key']))
            {
                $ret['title'] = array(
                    'Ремонт',
                    $this->_datas['model_type'][0]['name_rm'],
                    $this->_datas['marka']['ru_name'],
                    $this->_datas['sublineyka']['ru_name'],
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
                     $this->_datas['sublineyka']['name']
                 );

                 $ret['description'] = array(
                    'Услуги по ремонту',
                    $this->_datas['model_type'][2]['name_rm'],
                    $this->_datas['marka']['ru_name'],
                    $this->_datas['sublineyka']['ru_name'].'.',
                    $this->_datas['dop']
                 );

                $file_name = 'model';
            }
            else
            {
                switch ($params['key'])
                {
                    case 'service':

                        $ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0]),
                            $this->_datas['model_type'][0]['name_re'],
                            $this->_datas['marka']['ru_name'],
                            $this->_datas['sublineyka']['ru_name'],
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
                            tools::mb_firstupper($this->_datas['syns'][1]),
                            $this->_datas['model_type'][1]['name_re'],
                            $this->_datas['marka']['name'],
                            $this->_datas['sublineyka']['name']
                        );

                        $ret['description'] = array(
                            tools::mb_firstupper($this->_datas['syns'][2]),
                            $this->_datas['marka']['ru_name'],
                            $this->_datas['sublineyka']['ru_name'].'.',
                            $this->_datas['dop']
                        );

                    $file_name = 'model-service';

                    break;

                    case 'defect':

                        $count = count($this->_datas['dop_reasons']);

                        $ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0]),
                            $this->_datas['marka']['ru_name'],
                            $this->_datas['sublineyka']['ru_name'],
                            '—',
                            $count,
                            tools::declOfNum($count, array('причина', 'причины', 'причин'), false),
                            'поломки',
                            $this->_datas['model_type'][0]['name_re'],
                            '|',
                            $this->_datas['servicename'],
                            $this->_datas['region']['translit1']
                        );

                        $ret['h1'] = array(
                            tools::mb_firstupper($this->_datas['syns'][1]),
                            $this->_datas['marka']['name'],
                            $this->_datas['sublineyka']['name']
                        );

                        $ret['description'] = array(
                            'Неисправность',
                            '—',
                            $this->_datas['marka']['ru_name'],
                            $this->_datas['sublineyka']['ru_name'],
                            tools::mb_firstlower($this->_datas['syns'][2]).'.',
                            $this->_datas['dop']
                        );

                    $file_name = 'model-defect';

                    break;

                    case 'complect':

                        $ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0]),
                            $this->_datas['model_type'][0]['name_rm'],
                            $this->_datas['marka']['ru_name'],
                             $this->_datas['sublineyka']['ru_name'],
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
                            $this->_datas['model_type'][1]['name_rm'],
                            $this->_datas['marka']['name'],
                            $this->_datas['sublineyka']['name']
                        );

                        $ret['description'] = array(
                            tools::mb_firstupper($this->_datas['syns'][2]),
                            $this->_datas['marka']['name'],
                            $this->_datas['sublineyka']['name'].'.',
                            $this->_datas['dop']
                        );

                    $file_name = 'model-complect';

                    break;
                }
            }
        }

        if (isset($params['model_id']))
        {
            if (!isset($params['key']))
            {
                 $ret['title'] = array(
                    'Ремонт'
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

                 $ret['h1'] = array(
                    'Ремонт',
                     $this->_datas['model']['name']
                 );

                 $ret['description'] = array(
                    'Услуги по ремонту',
                    $this->_datas['model_type'][2]['name_rm'],

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

                 $file_name = 'model';
            }
            else
            {
                switch ($params['key'])
                {
                    case 'service':

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

                        $ret['h1'] = array(
                            tools::mb_firstupper($this->_datas['syns'][1]),
                            $this->_datas['model_type'][1]['name_re'],
                            $this->_datas['model']['name']
                        );

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

                    $file_name = 'model-service';

                    break;

                    case 'defect':

                        $count = count($this->_datas['dop_reasons']);

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
                        $ret['title'][] = $this->_datas['model_type'][0]['name_re'];
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

                    $file_name = 'model-defect';

                    break;

                    case 'complect':

                        $ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0]),
                            $this->_datas['model_type'][0]['name_re']
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
                            $this->_datas['model_type'][1]['name_re'],
                            $this->_datas['model']['name']
                        );

                        $ret['description'] = array(
                            tools::mb_firstupper($this->_datas['syns'][2]),
                            $this->_datas['model']['name'].'.',
                            $this->_datas['dop']
                        );

                    $file_name = 'model-complect';

                    break;
                }
            }
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
        $preim[$i][] = array(
                    '<div class="preimitem"><div class="preimimage"><img src="/templates/moscow/img/shared/preimin2.png"></div><div class="preimname">Консультация по телефону</div>',
                    '<div class="preimitem"><div class="preimimage"><img src="/templates/moscow/img/shared/preimin2.png"></div><div class="preimname">Бесплатные консультации</div>',
                    '<div class="preimitem"><div class="preimimage"><img src="/templates/moscow/img/shared/preimin2.png"></div><div class="preimname">Горячая линия '.$this->_datas['marka']['name'].'</div>');

        $preim[$i][] = array('<div class="preimtext">Помогаем решать проблемы', '<div class="preimtext">Помогаем устранять неисправности', '<div class="preimtext">Помогаем устранять поломки',
                '<div class="preimtext">Оказываем помощь');

        $preim[$i][] = array('владельцам', 'обладателям');
        $preim[$i][] = array('устройств', 'гаджетов', 'техники', 'оборудования');
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
        $preim[$i][] = array($this->_datas['marka']['name'].'</div></div>', $this->_datas['marka']['ru_name'].'</div></div>');

        $preims = rand_it::randMas($preim, 3, '', $feed);

         $text = array();
         $text2 = array();

         if (!isset($params['key']))
         {
            if (!isset($params['marka_id']))
            {
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
            else
            {
                $f = tools::gen_feed($this->_datas['site_name']);

                $text[] = array('<p>Ремонт');

                $t_array = array();
                foreach ($this->_datas['orig_model_type'] as $type)
                    $t_array[] = $type['name_rm'];

                $text[] = $t_array;

                $t_marka = array($this->_datas['marka']['name'], $this->_datas['marka']['ru_name']);
                $choose = rand(0, 1);
                $text[] = array($t_marka[$choose]);

                unset($t_marka[$choose]);

                $t_marka = array_values($t_marka);

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

                        $text[] = array(current($t_marka).'.');
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

                $block_text[$j][] = array($this->_datas['marka']['name'], $this->_datas['marka']['ru_name']);

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
        }
        else
        {
            switch ($params['key'])
            {
                case 'service':

                    $text[] = array('<p>'.tools::mb_firstupper($this->_datas['syns'][0]));

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

                break;
                case 'defect':

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

                    srand($this->_datas['id']);
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
                     foreach ($this->_datas['dop_reasons'] as $value)
                        $str.= '<li>'.$value.'</li>';

                     $t_array = array($str);

                     $text2[] = $t_array;

                     $text2[] = array('</ul></p>');

                break;
                case 'complect':

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

                    if (isset($params['marka_id']) && isset($params['model_type_id']))
                    {
                        $text[] = array($this->_datas['marka']['name'].'.', $this->_datas['marka']['ru_name'].'.');
                    }
                    else
                    {
                        $text[] = array($this->_datas['marka']['name'].',');
                        $text[] = array('в том числе и для');

                        $t_array = array('модели', 'устройства', 'аппарата', '');
                        foreach ($this->_datas['orig_model_type'] as $type)
                            $t_array[] = $type['name_re'];

                        $text[] = $t_array;

                        if (isset($params['sublineyka_id']))
                            $text[] = array($this->_datas['sublineyka']['name'].'.</p>');

                        if (isset($params['model_id']))
                        {
                            if (mb_strtolower($this->_datas['model']['lineyka']) != mb_strtolower($this->_datas['model']['sublineyka']))
                            {
                                 $text[] = $this->_datas['m_model']['name'];
                                 $text[] = tools::mb_ucfirst($this->_datas['model']['submodel'].'.</p>');
                            }
                            else
                            {
                                 $text[] = tools::mb_ucfirst($this->_datas['model']['submodel'].'.</p>');
                            }
                        }
                    }

                    $text[] = array('Сведения', 'Информацию', 'Данные');
                    $text[] = array('о наличии и');
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
                break;
            }
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

        if (isset($params['sublineyka_id']))
            $t2 = array($this->_datas['marka']['name'].' '.$this->_datas['sublineyka']['name']);

        if (isset($params['model_id']))
            $t2 = array($this->_datas['model']['name']);

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

        foreach (array('h1', 'title', 'description') as $key)
                $ret[$key] =  implode(' ', $ret[$key]);

        $ret['img'] = $this->_datas['img'];

        $this->_ret = $this->_answer($answer, $ret);
        $body = $this->_body($file_name, basename(__FILE__, '.php'));

        //return array('title' => $this->_ret['title'], 'description' => $this->_ret['description'], 'body' => $body);
        return array('body' => $body);
    }

    protected function indexSite()
    {
        $str = '';
        $file = __DIR__.'/pages/sc3/indexSite.php';
        if (file_exists($file))
        {
            ob_start();
            include $file;
            $str = preg_replace(array('/ {2,}/','/\t|(?:\r?\n[ \t]*)+/s'),array(' ',''), ob_get_contents());
            ob_end_clean();
        }
        return $str;
    }
    
    private function _make_accord_table($marka_lower)
    {
        $urls = array(
            'acer' => array('remont_computer'),
		);
        
        $this->_datas['add_device_type'] = $add_device_type = array(
            'remonе_computer' => array('type' => 'компьютер', 'type_rm' => 'компьютеров', 'type_m' => 'компьютеры', 'type_de' => 'кмопьютером', 'type_re' => 'компьютера'),
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
         );
    }
}

?>
