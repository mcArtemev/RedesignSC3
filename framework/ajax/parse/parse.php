<?

namespace framework\ajax\parse;

use framework\pdo;
use framework\tools;
use framework\ajax as ajax;
use framework\dom\node;
use framework\rand_it;

// Тест 2
define('CACHE_PATH', '/var/www/www-root/data/www/studiof1-test.ru/cache');
define('SITEMAP_PART', 50000);

class parse extends ajax\ajax {

    public function __construct($args)
    {
        parent::__construct('');

        $pass = '';
        $args['mode'] = isset($args['mode']) ? (integer) $args['mode'] : 0; //режим кеширования
        $args['batch_id'] = isset($args['batch_id']) ? (integer) $args['batch_id'] : 0; //доп аргумент пакетной обработки
        $remote = $args['remote'] = isset($args['remote']) ? (string) $args['remote'] : '';
        
        $query = $args['query'] = isset($args['query']) ? (string) $args['query'] : '';
        $referal = $args['referal'] = isset($args['referal']) ? (string) $args['referal'] : '';
        
        if (function_exists('idn_to_utf8')) {
            if (preg_match("/[А-Яа-яЁё]/u", idn_to_utf8($args['site']))) {
                $args['site'] = idn_to_utf8($args['site']);
            }
        }

        if ($args['site'] && $args['url'])
        {
            $args['site'] = trim($args['site']);
            $args['url'] = trim($args['url']);
            $p_mode = isset($args['p_mode']) ? trim($args['p_mode']) : false;
             
            $sitemap_g = false;

            $sql = "SELECT `sites`.`id` as `site_id`,
                `sites`.`servicename` as `servicename`,
                `sites`.`ru_servicename` as `ru_servicename`,
                `setkas`.`name` as `setka_name`,
                `setkas`.`id` as `setka_id`,
                `sites`.`phone` as `phone`,
                `sites`.`name` as `site_name`,
                `sites`.`allow` as `allow`,
				`sites`.`piwik` as `piwik`,
                `sites`.`phone_yd` as `phone_yd`,
                `sites`.`phone_ga` as `phone_ga`,
                `sites`.`phone_yd_rs` as `phone_yd_rs`,
				`sites`.`phone_yd_mb` as `phone_yd_mb`,
                `sites`.`region_id` as `region_id`,
                `sites`.`partner_id` as `partner_id`,
                `sites`.`partner_yd` as `partner_yd`,
                `sites`.`partner_ga` as `partner_ga`,
                `sites`.`metrica` as `metrica`,
                `sites`.`analytics` as `analytics`,
                `sites`.`mail_counter` as `mail_counter`,
                `setkas`.`https` as `https`
                FROM `sites`
                INNER JOIN `setkas` ON `sites`.`setka_id` = `setkas`.`id` WHERE `sites`.`name`=:name";

            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array('name' => $args['site']));
            $result = current($stm->fetchAll(\PDO::FETCH_ASSOC));

//            if( preg_match("/[А-Яа-я]/", $result['site_name']) ) {
//                preg_match("/[А-Яа-я]/",$result['site_name'], $firstRu);
//                $result['site_name'] = idn_to_ascii($result['site_name']);
//            }

            if ($result['site_name'] == 'mskcentre.ru') $result['https'] = 1;
 
            if ($p_mode)
            {
                if ($p_mode == "YD")
                {
                    $result['phone'] = ($result['phone_yd']) ? $result['phone_yd'] : $result['phone'];
                    $result['partner_id'] = ($result['partner_yd']) ? $result['partner_yd'] : $result['partner_id'];
                }

                if ($p_mode == "GA")
                {
                    $result['phone'] = ($result['phone_ga']) ? $result['phone_ga'] : $result['phone'];
                    $result['partner_id'] = ($result['partner_ga']) ? $result['partner_ga'] : $result['partner_id'];
                }

                if ($p_mode == "YD-RS")
                    $result['phone'] = ($result['phone_yd_rs']) ? $result['phone_yd_rs'] : (($result['phone_yd']) ? $result['phone_yd'] : $result['phone']);

                if ($p_mode == "YD-MB")
                    $result['phone'] = ($result['phone_yd_mb']) ? $result['phone_yd_mb'] : (($result['phone_yd']) ? $result['phone_yd'] : $result['phone']);

                if ($p_mode == "YS")
                    $sitemap_g = false;

                if ($p_mode == "GS")
                    $sitemap_g = true;
            }

            if ($result)
            {
                $use_dynamic = true;
                
                if (empty($args['realHost'])) $args['realHost'] = "";
                if (mb_strpos($args['realHost'], 'rsupport.ru.com') !== false)
                {
                    $use_dynamic = false;
                    $result['phone'] = '78003015964';
                    
                    if ($result['region_id'] == 6) $result['phone'] = '78126039538';  
                    if (!$result['region_id']) $result['phone'] = '74950324977';
                }
                
                /*if ($p_mode == "YD" && $result['setka_name'] == "СЦ-5" && $result['region_id'] == 6) 
                {
                    $use_dynamic = false;
                    //$result['partner_id'] = 383;                 
                }*/
                
                if (in_array($p_mode, array("YD", "GA", "VK", "YD-RS", "FB", "MT")) && isset($args['sid']) && isset($args['realHost']) && $use_dynamic)
                {
                    $request = [];
                    $request['op'] = 'dt';
                    $request['responce'] = 1;
                    $request['args']['mode'] = 'in';
                    $request['args']['session'] = $args['sid'];
                    $request['args']['site'] = $args['site']; 
                    $request['args']['client_id'] = isset($args['client_id']) ? $args['client_id'] : '';
                    $request['args']['p_mode'] = $p_mode;
                    
                    $mango = tools::connect_ciba($request);
                    $mango = mb_substr($mango, 1, -1);
                    
                    if ($mango) $result['phone'] = $mango;
                }

                if ($result['setka_name'] == 'СЦ-1Б')
                {
                    $result['original_setka_id'] = $result['setka_id'];
                    $result['setka_name'] = 'СЦ-1';
                    $result['setka_id'] = 1;
                }

                if ($result['setka_name'] == 'СЦ-5Б')
                {
                    $result['original_setka_id'] = $result['setka_id'];
                    $result['setka_name'] = 'СЦ-5';
                    $result['setka_id'] = 5;
                }

                if ($result['setka_name'] == 'СЦ-7Х')
                {
                    $result['original_setka_id'] = $result['setka_id'];
                    $result['setka_name'] = 'СЦ-7';
                    $result['setka_id'] = 7;
                }
                
                $cache_file = CACHE_PATH.'/'.$args['site'].'/'.$args['url'].'.cache';
                if (($args['mode'] === 1) && file_exists($cache_file))
                {
                   $pass = file_get_contents($cache_file);
                }
                else
                {
                    if ($result['setka_name'] == 'СЦ-6') {
                      $sitemap_part = preg_match('/^map_(google_)?([0-9]+).xml$/is', $args['url'], $part_number);
                      $siteMapName = ['map.xml' => 'all'];
                    }
                    else if ($result['setka_name'] == 'СЦ-3') {
                      $sitemap_part = preg_match('/^sitemap_(google_)?([0-9]+).xml$/is', $args['url'], $part_number);
                      $siteMapName = ['sitemap.xml' => 'all', 'sitemap_google.xml' => 'google'];
                    }
                    else {
                      $sitemap_part = preg_match('/^sitemap_(google_)?([0-9]+).xml$/is', $args['url'], $part_number);
                      $siteMapName = ['sitemap.xml' => 'all'];
                    }

                    if (isset($siteMapName[$args['url']]) || $sitemap_part)
                    {
                        $allow_arr = array();
                        $allow_str = '';
                        $siteMapType = isset($siteMapName[$args['url']]) ? $siteMapName[$args['url']] : ($part_number[1] !== null ? trim($part_number[1], '_') : 'all');

                        foreach (explode("\n", $result['allow']) as $allow)
                        {
                            $allow = trim($allow);
                            if ($allow) $allow_arr[] = "(`name` LIKE '{$allow}')";
                        }

                        $allow_str = implode(' OR ', $allow_arr);

                        if ($result['setka_name'] == 'СЦ-1')
                        {
                            $sql = "SELECT * FROM `urls` WHERE
                                (`site_id`= {$result['site_id']}) AND
                                    ((`params` LIKE '%marka_id%') OR (`params` LIKE '%model_id%' AND `params` NOT LIKE '%key%')";
                        }

                        if ($result['setka_name'] == 'СЦ-3') {
                          $sql = "SELECT * FROM `urls` WHERE (`site_id` = 0";
                        }

                        if ($result['setka_name'] == 'СЦ-2')
                        {
                           $sql = "SELECT * FROM `urls` WHERE
                                (`site_id`= {$result['site_id']}) AND
                                    ((`params` LIKE '%marka_id%') OR (`params` LIKE '%model_id%' AND `params` NOT LIKE '%key%') OR (`params` LIKE '%m_model_id%')";
                        }

                        if ($result['setka_name'] == 'СЦ-5' || $result['setka_name'] == 'СЦ-7'  || $result['setka_name'] == 'СЦ-7Х' || $result['setka_name'] == 'СЦ-8')
                        {
                           $sql = "SELECT * FROM `urls` WHERE
                                (`site_id`= {$result['site_id']}";
                        }

                        if ($result['setka_name'] == 'СЦ-6') {
                          $startCount = [
                            68 => [
                              2 => 1,
                              1 => 6,
                            ],
                            69 => [
                              1 => 5,
                              2 => 6,
                              3 => 12,
                            ],
                            34 => [
                              2 => 44,
                              3 => 29,
                            ],
                            35 => [
                              3 => 3,
                            ],
                            36 => [
                              3 => 30,
                            ],
                            37 => [
                              2 => 33,
                            ],
                            38 => [
                              2 => 15,
                              3 => 38,
                              1 => 7,
                            ],
                            39 => [
                              2 => 54,
                              3 => 29,
                              1 => 1,
                            ],
                            40 => [
                              1 => 1,
                            ],
                            41 => [
                              3 => 86,
                              2 => 33,
                            ],
                            42 => [
                              2 => 6,
                              1 => 24,
                            ],
                            43 => [
                              2 => 19,
                              3 => 44,
                            ],
                            44 => [
                              2 => 3,
                              3 => 15,
                              1 => 1,
                            ],
                            45 => [
                              3 => 37,
                            ],
                            46 => [
                              2 => 9,
                              3 => 2,
                            ],
                            47 => [
                              2 => 110,
                              3 => 29,
                              1 => 2,
                            ],
                            48 => [
                              3 => 48,
                            ],
                            49 => [
                              3 => 11,
                            ],
                            50 => [
                              3 => 12,
                            ],
                            52 => [
                              3 => 89,
                            ],
                            53 => [
                              3 => 41,
                            ],
                            54 => [
                              2 => 1,
                            ],
                            56 => [
                              2 => 9,
                              3 => 19,
                            ],
                            57 => [
                              1 => 19,
                            ],
                            58 => [
                              2 => 25,
                              3 => 37,
                              1 => 8,
                            ],
                            59 => [
                              2 => 16,
                              3 => 14,
                            ],
                            60 => [
                              2 => 31,
                              3 => 1,
                            ],
                            61 => [
                              2 => 53,
                              3 => 41,
                            ],
                            62 => [
                              3 => 25,
                            ],
                            65 => [
                              3 => 9,
                            ],
                            64 => [
                              2 => 23,
                              3 => 1,
                            ],
                            4 => [
                              1 => 114,
                              2 => 41,
                              3 => 19,
                            ],
                            21 => [
                              1 => 10,
                              2 => 10,
                              3 => 15,
                            ],
                            3 => [
                              1 => 222,
                              2 => 46,
                              3 => 27,
                            ],
                            16 => [
                              2 => 4,
                              3 => 45,
                            ],
                            6 => [
                              1 => 51,
                            ],
                            10 => [
                              3 => 38,
                            ],
                            17 => [
                              3 => 53,
                              2 => 23,
                            ],
                            5 => [
                              1 => 55,
                              3 => 101,
                              2 => 34,
                            ],
                            20 => [
                              3 => 31,
                            ],
                            8 => [
                              1 => 40,
                            ],
                            11 => [
                              3 => 42,
                              2 => 3,
                            ],
                            1 => [
                              1 => 15,
                              3 => 33,
                              2 => 7,
                            ],
                            7 => [
                              1 => 4,
                              2 => 4,
                            ],
                            18 => [
                              1 => 2,
                              3 => 47,
                            ],
                            9 => [
                              1 => 71,
                            ],
                            66 => [
                              3 => 39,
                            ],
                            12 => [
                              3 => 19,
                            ],
                          ];

                          $stmt = pdo::getPdo()->query("SELECT models2.id as 'id', marka_to_sites.marka_id as 'marka', model_types.id as 'type' FROM models2_to_setka
                          JOIN models2 ON models2_to_setka.id_model = models2.id
                          JOIN model_type_to_markas ON models2.model_type_mark = model_type_to_markas.id
                          JOIN model_types ON model_type_to_markas.model_type_id = model_types.id
                          JOIN marka_to_sites ON model_type_to_markas.marka_id = marka_to_sites.marka_id
                          JOIN sites ON marka_to_sites.site_id = sites.id
                          WHERE models2_to_setka.id_setka = 6 AND sites.setka_id = 6 AND marka_to_sites.site_id = {$result['site_id']}
                          ORDER BY models2.id");

                          $models = [];

                          foreach ($stmt->fetchAll() as $model) {
                            $models[$model['marka']][$model['type']][] = $model['id'];
                          }

                          $startDate = 2018+2;
                          $startPercent = 0.7;
                          $stepPercent = 0.1;
                          $percent = $startPercent + (date('Y')+date('n')-$startDate)*$stepPercent;

                          $id = [];

                          foreach ($models as $mId => $types) {
                            foreach ($types as $typeId => $ids) {
                              $count = isset($startCount[$mId][$typeId]) ? ceil($startCount[$mId][$typeId]*$percent) : count($ids);
                              $id = array_merge($id, array_slice($ids, 0, $count));
                            }
                          }

                          $id = implode('|',$id);

                          $sql = "SELECT * FROM `urls` WHERE
                               (`site_id`= {$result['site_id']} AND (`params` NOT LIKE '%model_id%' OR `params` REGEXP 'model_id.+({$id}).;')";
                        }

                        if ($allow_str) $sql .= " OR " . $allow_str;

                        $sql .= ")";

                        if (!$sitemap_part)
                            $part_number = 0;
                        else
                            $part_number = $part_number[2];

                        if ($args['site'] == 'mskcentre.ru') {
                          $dbh = pdo::getPdo(2);
                        }
                        else if ($args['site'] == 'gpsolid.ru' || $result['setka_name'] == 'СЦ-3') {
                          $dbh = pdo::getPdo(3);
                        }
                        else {
                          $dbh = pdo::getPdo();
                        }

                          $pass = $this->_createSitemap($args['site'], $dbh->query($sql)->fetchAll(\PDO::FETCH_ASSOC), $result['setka_name'],
                                          $result['allow'], $result['https'], $siteMapType, $sitemap_g, $part_number);

                        if ($args['mode'] === 1 && $pass) tools::file_force_contents($cache_file, $pass);
                    }
                    else
                    {
                        if ($args['url'] == 'robots.txt')
                        {
                            if ($args['site'] == 'gpsolid.ru' ) { // || $args['realHost'] != $args['site']xn----ctbinllnmhed.xn--p1ai
                              $pass = 'User-agent: *'.PHP_EOL.'Disallow: / ';
                            } else {
                              $pass = $this->_createRobots($args['site'], $result['setka_name'], $result['allow'], $result['https']);
                            }
							
							if (isset($args['realHost'])) {
								if (
								    ($args['realHost'] != $args['site'] && !empty($args['realHost']) && strpos($args['realHost'],'nikon-russia.net') ===false
								) || $args['realHost'] =='customers.ru.com'
								) {
									$pass = 'User-agent: *'.PHP_EOL.'Disallow: / ';
								} else {
									$pass = $this->_createRobots($args['site'], $result['setka_name'], $result['allow'], $result['https']);
								}								
							} else {
								$pass = $this->_createRobots($args['site'], $result['setka_name'], $result['allow'], $result['https']);
							}
							if( strpos($args['realHost'],'xn----ctbinllnmhed.xn--p1ai') !==false){
							    $pass = $this->_createRobots($args['site'], $result['setka_name'], $result['allow'], $result['https']);
							}
                        }
                        else
                        {

                          $sql = "SELECT * FROM `urls` WHERE `site_id`=:site_id AND `name`=:url";

                          if ($args['site'] == 'mskcentre.ru') {
                            $dbh = pdo::getPdo(2);
                          }
                          else if ($args['site'] == 'gpsolid.ru' || $result['setka_name'] == 'СЦ-3') {
                            $sql = "SELECT * FROM `urls` WHERE (`site_id` = 0 OR `site_id`=:site_id) AND `name`=:url";
                            $dbh = pdo::getPdo(3);
                          }
                          else {
                            $dbh = pdo::getPdo();
                          }
                          
                          if ($result['setka_name'] == 'СЦ-1')
                          {
                            if (isset($args['realHost'])) 
                            {
                                if ($args['realHost'] == $args['site'])
                                {
                                    if ($args['url'] == 'b2b')
                                    {
                                        $args['url'] = '-1';
                                    }                                                                                        
                                }
                             }
                           }

                            $file = tools::get_setka_code($result['setka_name']);
                            if ($args['site'] == 'mskcentre.ru') {
                              $file = 'sc2_1'; // НОВАЯ SC2
                            }
                            if ($args['site'] == 'gpsolid.ru' || $result['setka_name'] == 'СЦ-3') {
                              $file = 'sc3_1'; // НОВАЯ SC3
                            }
                            if ($result['setka_name'] == 'СЦ-2з') {
                              $file = 'sc2'; // НОВАЯ SC3
                            }
                            

                            
                            if ($result['setka_name'] == 'СЦ-2') {
                              $file = 'sc2n'; 
                            }
                           
                            if ($result['setka_name'] == 'СЦ-2з') 
                            {
                              $result['setka_name'] = 'СЦ-2';
                              $result['setka_id'] = 2; 
                            }

                            $stm = $dbh->prepare($sql);
                            $stm->execute(array('site_id' => $result['site_id'], 'url' => $args['url']));
                            $content = current($stm->fetchAll(\PDO::FETCH_ASSOC));

                            if ($content)
                            {
                                $sql = "SELECT * FROM `dop_urls` WHERE `site_id`=:site_id AND `name`=:url";
                                $stm = $dbh->prepare($sql);
                                $stm->execute(array('site_id' => $result['site_id'], 'url' => $args['url']));
                                $dops = current($stm->fetchAll(\PDO::FETCH_ASSOC));

                                $answer = array('h1' => '', 'title' => '', 'description' => '', 'img' => '', 'text' => '');

                                foreach ($answer as $key => $value)
                                {
                                    if (isset($dops[$key]))
                                        if ($dops[$key])
                                            $answer[$key] = trim($dops[$key]);
                                }

                                if ($remote == '83.69.214.226') $result['metrica'] = '';

                                $dopParams = $args['site'] == 'mskcentre.ru' ? array('p_mode' => $p_mode, 'pb_mode' => isset($args['pb_mode']) ? trim($args['pb_mode']) : false) : array();

                                if ( $args['site'] == 'mskcentre.ru' && isset($args['isAMP']))
                                    $dopParams['isAMP'] = $args['isAMP'];

                                if ( $args['site'] == 'mskcentre.ru' && isset($args['mskcentre']))
                                    $dopParams['mskcentre'] = $args['mskcentre'];

                                if ( isset($args['realHost']))
                                    $dopParams['realHost'] = $args['realHost'];

                                if ( isset($args['sid']))
                                    $dopParams['sid'] = $args['sid'];
                                    
                                $dopParams['p_mode'] = $p_mode;
                                $dopParams['remote'] = $remote;
                                $dopParams['query'] = $query;
                                $dopParams['referal'] = $referal;
                                
                                $content_params = $content['params'] ? unserialize($content['params']) : [];
                                                                   
                                $params = array_merge($content_params, array('params' => $content['params'], 'feed' => $content['feed'],
                                    'arg_url' => $content['name'], 'cache_mode' => $args['mode'],
                                        'batch_id' => $args['batch_id']), $dopParams, $result);

								if (isset($args['site_in_url'])) {
									$params['site'] = $args['site'];
									$params['site_in_url'] = $args['site_in_url'];
								}
								
								/*для работы сц7 partnerser.ru/help/ Tony Rat*/
								if(!empty($args['previous_url'])){
								    $params['previous_url'] = $args['previous_url'];
								}
								
								/*для работы сц2 мультизеркала  Tony Rat*/
								if(!empty($args['region_name'])){
								    $params['region_name'] = $args['region_name'];
								}
								
								if(!empty($args['realHost']) && $args['realHost'] =='customers.ru.com' && !empty($args['brand'])){
								    $params['multiBrand'] = $args['brand'];
								}
								if($args['site']=='customers.ru.com'){
								     $params['indexSite'] ='indexSite';
								}
								if(!empty($args['validatedCity'])){
								     $params['validatedCity'] =$args['validatedCity'];
								}
								
								/*для работы сц2 мультизеркала  Tony Rat*/
								
										
                                $hook_obj = null;
                                
                                //if (mb_strpos($args['site'], '.ruservicecenters.com') !== false)
                                    //$file = 'sc10'; // НОВАЯ SC10

                                if (file_exists(__DIR__.'/hooks/'.$file.'.php'))
                                {
                                   $hook = 'framework\\ajax\\parse\\hooks\\'.$file;
                                   $hook_obj = new $hook;
                                }

                                if (method_exists($hook_obj, 'generate'))
                                  if (isset($args['admin'])){
                                    $params['admin']=[$args['admin'][0]];
                                  }
                                    $answer = $hook_obj->generate($answer, $params);

                                $pass = serialize($answer);
                                if ($args['mode'] === 1 && $answer) tools::file_force_contents($cache_file, $pass);
                            }
                        }
                    }
                }
            }
        }

        if (!$pass) header("HTTP/1.0 404 Not Found");

        $this->getWrapper()->addChildren($pass);
    }

    private function _splitSitemap($site, $urls, $dates, $https, $part = 1)
    {
        $str = '';

        $parts = ceil(count($urls) / SITEMAP_PART);

        if ($part >= 1 && $part <= $parts)
        {
            $str .= '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL.
                '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.PHP_EOL;

            $split = array_slice($urls, ($part - 1) * SITEMAP_PART, SITEMAP_PART);

            foreach ($split as $value)
            {
                $str .= '<url>'.PHP_EOL.
                            '<loc>'.(($https) ? 'https' : 'http') .'://'.$site.'/'.(($value !== '/') ? ($value.'/') : '').'</loc>'.PHP_EOL.
                            '<lastmod>'.date('c', ( (isset($dates[$value])) ? $dates[$value] :  (time() - 24*7*60*60) )).'</lastmod>'.PHP_EOL.
                            '<priority>0.7</priority>'.PHP_EOL.
                        '</url>'.PHP_EOL;
                
            }

             $str .= '</urlset>';
        }

        return $str;
    }

    private function _createSitemap($site, $urls, $setka, $allow, $https, $type, $sitemap_g, $part_number = 0)
    {
       $str = '';

       $t = array();
       $merge = array();

       if ($site == 'mskcentre.ru' || $setka == 'СЦ-3') {
         $cur_urls = $ya_urls = [];

       }
       else {
         $sql = "SELECT `cur_urls`, `ya_urls` FROM `sites` WHERE `name`=:site";
         $stm = pdo::getPdo()->prepare($sql);
         $stm->execute(array('site' => $site));
         $sql_urls = current($stm->fetchAll(\PDO::FETCH_ASSOC));

         $cur_urls = array();
         $ya_urls = array();

         if ($sql_urls['cur_urls'])
         {
              $cur_urls = explode("\n", $sql_urls['cur_urls']);
              foreach ($cur_urls as $key => $value)
                  $cur_urls[$key] = trim($value);
         }

         if ($sql_urls['ya_urls'] && !$sitemap_g)
         {
             $ya_urls = explode("\n", $sql_urls['ya_urls']);

             $t_ya_urls = array();

             foreach ($ya_urls as $key => $value)
                  $t_ya_urls[trim($value)] = true;

             $ya_urls = $t_ya_urls;
         }
       }

       $dates = array();

       foreach ($urls as $url)
       {
            $t[] = $url['name'];
            $dates[$url['name']] = $url['date'];
       }

       foreach ((array_merge($cur_urls, $t)) as $value)
       {
            if (!isset($ya_urls[$value]))
                $merge[$value] = true;
       }

       $count_urls = 0;

       $merge = array_keys($merge);

       if ($merge)
       {
          if ($type == 'google' && $setka == 'СЦ-3') {
            $dateStart = date_create('2018-03-30');
            $now = date_create();

            $diff = date_diff($dateStart, $now);
            $count = 500 + $diff->d*150;
            $merge = array_slice($merge, 0, $count);
          }

          $count_urls = count($merge);
           if ($count_urls > SITEMAP_PART)
           {
                if (!$part_number)
                {
                    $parts = ceil($count_urls / SITEMAP_PART);

                    $str .= '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL.
                        '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.PHP_EOL;

                    for($j = 1; $j <= $parts; $j++)
                    {
                        $min = ($j - 1) * SITEMAP_PART;
                        $max = ($j) * SITEMAP_PART;
                        $last_mod = 0;

                        for ($i = $min; $i < $max; $i++)
                        {
                            if (!isset($merge[$i])) break;

                            $value = $merge[$i];
                            $mod = isset($dates[$value]) ? $dates[$value] :  (time() - 24*7*60*60);
                            if ($mod > $last_mod) $last_mod = $mod;
                        }

                        $str .= '<sitemap>'.PHP_EOL.
                                '<loc>'.(($https) ? 'https' : 'http') .'://'.$site.'/sitemap_'.$j.'.xml</loc>'.PHP_EOL.
                                '<lastmod>'.date('c', $last_mod).'</lastmod>'.PHP_EOL.
                            '</sitemap>'.PHP_EOL;
                    }

                    $str .= '</sitemapindex>';
                }
                else
                {
                    $str = $this->_splitSitemap($site, $merge, $dates, $https, $part_number);
                }
           }
           else
           {
               $str .= '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL.
                    '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.PHP_EOL;

               foreach ($merge as $value)
               {
                  $str .=  '<url>'.PHP_EOL.
                            '<loc>'.(($https) ? 'https' : 'http') .'://'.$site.'/'.(($value !== '/') ? ($value.'/') : '').'</loc>'.PHP_EOL.
                            '<lastmod>'.date('c', ( (isset($dates[$value])) ? $dates[$value] :  (time() - 24*7*60*60) )).'</lastmod>'.PHP_EOL.
                            '<priority>0.7</priority>'.PHP_EOL.
                          '</url>'.PHP_EOL;
               }

                $str .= '</urlset>';
           }

           $file = $this->_get_robots($setka, $allow, 0, $site);

           if ($count_urls < 1000 && $file)
           {
                $allow = array();
                $close_key = array_search('#close', $file);
                if ($close_key !== false)
                {
                     for ($i = $close_key + 1; $i < count($file); $i++)
                        $allow[] = str_replace(array('Disallow: ', '*'), array('', '%'), $file[$i]);
                }

                if ($allow)
                {
                    $sql = "SELECT `allow` FROM `sites` WHERE `name`=:name";
                    $stm = pdo::getPdo()->prepare($sql);
                    $stm->execute(array('name' => $site));
                    $cur_allow = $stm->fetchColumn();

                    if ($cur_allow)
                        $cur_allow = explode("\n", $cur_allow);
                    else
                        $cur_allow = array();

                    $allow = implode("\n", array_merge($cur_allow, rand_it::randMas($allow, 3)));

                    $update_args = array('name' => $site, 'allow' => $allow);

                    $sql = "UPDATE `sites` SET ".pdo::prepare($update_args)." WHERE `name`=:name";
                    $stm = pdo::getPdo()->prepare($sql);
                    $stm->execute($update_args);
                }
           }
       }

       return $str;
    }

    private function _createRobots($site, $setka, $allow, $https)
    {
        $str = '';

        $file = $this->_get_robots($setka, $allow, 1, $site);

        if ($file)
        {
            if ($site != 'mskcentre.ru') {
              $file = implode("\n", $file);

              srand(tools::gen_feed($setka));
              $choose = rand(0, 1);

              $files = array();

              ob_start();

              $files[0] = function() use ($file, $setka, $site, $https)
              {
                  echo 'User-agent: Yandex'.PHP_EOL;
                  echo $file.PHP_EOL;
                  $cleanParam = 'utm_source&utm_medium&utm_campaign&utm_content&utm_term&yclid&gclid&openstat';
                  if (in_array($setka, ['СЦ-5', 'СЦ-1', 'СЦ-6', 'СЦ-3'])) {
                    $cleanParam = explode('&', $cleanParam);
                    srand((int)substr($setka, 3));
                    shuffle($cleanParam);
                    $cleanParam = implode('&', $cleanParam);
                  }
                  echo 'Clean-param: '.$cleanParam.'&from /'.PHP_EOL;
                  if ($site != 'mskcentre.ru') echo 'Host: '.(($https) ? 'https' : 'http').'://'.$site.PHP_EOL.PHP_EOL;
                  else echo PHP_EOL.PHP_EOL;
              };

              $files[1] = function() use ($file, $site)
              {
                  echo 'User-agent: Googlebot'.PHP_EOL;
                  echo $file.PHP_EOL.PHP_EOL;
              };

              $files[2] = function() use ($file, $site, $setka, $https)
              {
                  echo 'User-agent: *'.PHP_EOL;
                  echo $file.PHP_EOL.PHP_EOL;
                  if ($setka != 'СЦ-6') {
                    echo 'Sitemap: '.(($https) ? 'https' : 'http').'://'.$site.'/sitemap.xml'.PHP_EOL.PHP_EOL;
                  }
                  else {
                    echo 'Sitemap: '.(($https) ? 'https' : 'http').'://'.$site.'/map.xml'.PHP_EOL.PHP_EOL;
                  }
              };

              $files[3] = function() use ($file)
              {
                  echo 'User-agent: ia_archiver'.PHP_EOL;
                  echo 'Disallow: /'.PHP_EOL.PHP_EOL;

                  echo 'User-agent: MJ12bot'.PHP_EOL;
                  echo 'Disallow: /'.PHP_EOL.PHP_EOL;

                  echo 'User-agent: AhrefsBot'.PHP_EOL;
                  echo 'Disallow: /'.PHP_EOL.PHP_EOL;

                  echo 'User-agent: SemrushBot'.PHP_EOL;
                  echo 'Disallow: /'.PHP_EOL.PHP_EOL;
              };

              $files[$choose]();
              $files[!$choose]();
              $files[2]();
              if ($setka == 'СЦ-1')
              {
                  $files[3]();
              }
            }
            else {
              include __DIR__.'/hooks/pages/sc2_1/robots.php';
            }

            $str = ob_get_contents();

            ob_end_clean();
        }

       return $str;
    }

    private function _get_robots($setka, $allows, $mode = 1, $site)
    {
        $setka_code = tools::get_setka_code($setka);
        if ($site == 'mskcentre.ru') $setka_code = 'sc2_1';
        $file = __DIR__.'/hooks/pages/'.$setka_code.'/robots.php';

        $t = array();

        if (file_exists($file))
        {
			/*if ($setka_code == 'sc1') {
				include $file;
			} else {*/
				$file = file_get_contents($file);
			//}
			
            $sql = "SELECT `markas`.`name` FROM `marka_to_sites`
                        INNER JOIN `markas` ON `markas`.`id` = `marka_to_sites`.`marka_id`
                        INNER JOIN `sites` ON `sites`.`id` = `marka_to_sites`.`site_id`
                    WHERE `sites`.`name`= ?";

            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array($site));

            if ($setka == 'СЦ-3')
                $marka = tools::translit($stm->fetchColumn(), '_');
            else
                $marka = tools::translit($stm->fetchColumn());

            $file = str_replace('#marka', $marka, $file);

            foreach (explode("\n", $file) as $row)
            {
                $row = trim($row);
                if ($row)
                {
                    $t[$row] = $row;
                }
            }

            if ($mode) unset($t['#close']);
            
            if ($setka_code == 'sc1') $allows = '';
            
            foreach (explode("\n", $allows) as $allow)
            {
                $allow = trim($allow);
                if ($allow)
                {
                    unset($t['Disallow: '.str_replace('%', '*', $allow)]);
                }
            }

            $t = array_keys($t);
        }

        return $t;
    }
}
