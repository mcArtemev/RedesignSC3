<?

namespace framework\ajax\parse\hooks;

use framework\tools;
use framework\pdo;
use framework\rand_it;

class sc7 extends sc
{
    public function generate($answer, $params)
    {

         //if (function_exists('xdebug_start_trace')) {
             //xdebug_start_trace('/var/www/www-root/data/www/sc7/xdebug.log', XDEBUG_TRACE_APPEND);
        // }
 
        $this->_datas['hb'] = false;
		if (isset($params['hab'])) {
			$this->_datas['hab'] = $params['hab'];
			if (!empty($params['hb'])) {
                $this->_datas['hb'] = true;
                if(!empty($params['previous_url'])){
                    $this->_datas['previous_url'] =$params['previous_url'];
                }
            } else {
                // $params['marka_id'] = 1;
            }
		} else {
			$this->_datas['hab'] = false;
		}	
	
        //см sc-1..5, запрос исправлен
        /*$sql =  "SELECT `model_types`.`name` as `type`, `model_types`.`id` as `type_id`,
                `model_types`.`name_m` as `type_m`,`model_types`.`name_rm` as `type_rm`,
                `model_types`.`name_re` as `type_re` FROM `marka_to_sites`
            INNER JOIN `m_models` ON `m_models`.`marka_id` = `marka_to_sites`.`marka_id`
            INNER JOIN `model_types` ON `m_models`.`model_type_id` = `model_types`.`id`
            WHERE `marka_to_sites`.`site_id`= ? GROUP BY `model_types`.`name`";*/

		if ($this->_datas['hab'] === false) {
// #rat данный костыль сделан так как сц6 и сц7 работают по одним и темже связкам 
// это приводит к тому что при добавлении записей в таблицу model_type_to_markas для развертывания сц6 сц7 начинает рушаться
		    $sql = "SELECT `markas`.id FROM `markas`
					LEFT JOIN `marka_to_sites` ON `marka_to_sites`.`marka_id` = `markas`.`id`
				    WHERE `marka_to_sites`.`site_id`=?";
			$stm = pdo::getPdo()->prepare($sql);
			$stm->execute(array($params['site_id']));
			$tempBrandId = $stm->fetchColumn();
			
			$condition= '';
            if($tempBrandId ==1){
                $condition =" and `model_types`.id not in(16,4,18,41)";
            }elseif($tempBrandId ==25){
			    $condition =" and `model_types`.id not in(3, 7, 9, 10, 12, 31, 32,39, 40, 41, 43, 44)";
			}elseif($tempBrandId ==2){
			    $condition =" and `model_types`.id not in(13, 5, 8, 10, 18, 9, 44, 32, 40, 41, 38, 35, 27, 36, 42, 16)";
			}elseif($tempBrandId ==12){
			    $condition =" and `model_types`.id not in(1, 2, 5, 8, 9, 10, 13, 18, 27, 32, 35, 36, 38, 39,  40, 41, 43, 44)";
			}elseif($tempBrandId ==26){
			    $condition =" and `model_types`.id not in(1, 2, 3, 7, 8, 9, 10, 43, 16, 44, 35, 41,  45, 13, 32, 31)";
			}elseif($tempBrandId ==38){
			    $condition =" and `model_types`.id not in(2, 7)";
			}elseif($tempBrandId ==7){
			    $condition =" and `model_types`.id not in(8,9)";
			}elseif($tempBrandId ==8){
			    $condition =" and `model_types`.id not in(10)";
			}elseif($tempBrandId ==20){
			    $condition =" and `model_types`.id not in(2)";
			}elseif($tempBrandId ==6){
			    $condition =" and `model_types`.id not in(2, 10,29)";
			}elseif($tempBrandId ==32){
			    $condition =" and `model_types`.id not in(13)";
			}elseif($tempBrandId ==9){
			    $condition =" and `model_types`.id not in(2, 3, 5)";
			}elseif($tempBrandId ==21){
			    $condition =" and `model_types`.id not in(5, 10)";
			}elseif($tempBrandId ==44){
			    $condition =" and `model_types`.id not in(8,9,7,42,44,35,27,38,46,40,39,36)";
			}elseif($tempBrandId ==155){
			    $condition =" and `model_types`.id not in(7, 8, 35, 32)";
			}elseif($tempBrandId ==156){
			    $condition =" and `model_types`.id not in(7, 16, 41)";
			}elseif($tempBrandId ==53){
			    $condition =" and `model_types`.id not in(18)";
			}elseif($tempBrandId ==160){
			    $condition =" and `model_types`.id not in(3, 7, 8, 9, 44)";
			}elseif($tempBrandId ==35){
			    $condition =" and `model_types`.id not in(1, 5, 7)";
			}elseif($tempBrandId ==42){
			    $condition =" and `model_types`.id not in(1, 2, 3, 7, 5, 10, 13, 15, 4, 35)";
			}elseif($tempBrandId ==144){
			    $condition =" and `model_types`.id not in(1, 7, 10)";
			}elseif($tempBrandId ==145){
			    $condition =" and `model_types`.id not in(11)";
			}elseif($tempBrandId ==159){
			    $condition =" and `model_types`.id not in(13)";
			}elseif($tempBrandId ==63){
			    $condition =" and `model_types`.id not in(2,4,5)";
			}elseif($tempBrandId ==32){
			    $condition =" and `model_types`.id not in(29)";
			}elseif($tempBrandId ==169){
			    $condition =" and `model_types`.id not in(11,23)";
		    }elseif($tempBrandId == 164){
			    $condition =" and `model_types`.id not in(22,23)";
			}elseif($tempBrandId == 173){
			    $condition =" and `model_types`.id not in(23,24)";
			}elseif($tempBrandId == 175){
			    $condition =" and `model_types`.id not in(22,23,24,25)";
		    }elseif($tempBrandId == 171){
			    $condition =" and `model_types`.id not in(22,23,25)";
			}elseif($tempBrandId == 166){
			    $condition =" and `model_types`.id not in(23)";
			}elseif($tempBrandId == 167){
			    $condition =" and `model_types`.id not in(23)";
			}elseif($tempBrandId == 169){
			    $condition =" and `model_types`.id not in(11,23)";
			}elseif($tempBrandId == 170){
			    $condition =" and `model_types`.id not in(22,23,24,25)";
			}elseif($tempBrandId == 164){
			    $condition =" and `model_types`.id not in(22,23)";
			}elseif($tempBrandId == 46){
			    $condition =" and `model_types`.id not in(2,3,22,23)";
			}elseif($tempBrandId == 172){
			    $condition =" and `model_types`.id not in(22,23,24,25)";
			}elseif($tempBrandId == 238){
			    $condition =" and `model_types`.id not in(7, 22, 23, 31, 32, 40, 44, 46)";
			}elseif($tempBrandId == 163){
			    $condition =" and `model_types`.id not in(22,23,24,25)";
			}elseif($tempBrandId == 162){
			    $condition =" and `model_types`.id not in(23,22)";
			}elseif($tempBrandId == 173){
			    $condition =" and `model_types`.id not in(23,24)";
			}elseif($tempBrandId == 345){
                $condition =" and `model_types`.id not in(8,9,27,39,10,44,35,38,41,36,42,36)";
            }elseif($tempBrandId == 336){
                $condition =" and `model_types`.id not in(10)";
            }elseif($tempBrandId == 339){
                $condition =" and `model_types`.id not in(10)";
            }elseif($tempBrandId == 52){
                $condition =" and `model_types`.id not in(12)";
             }elseif($tempBrandId == 342){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 343){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 229){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 203){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 226){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 190){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 212){
                $condition =" and `model_types`.id in(29,13)";
             }elseif($tempBrandId == 202){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 300){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 235){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 30){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 29){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";             
            }elseif($tempBrandId == 31){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";             
            }elseif($tempBrandId == 42){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";             
            }elseif($tempBrandId == 43){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";             
            }elseif($tempBrandId == 184){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 186){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 187){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 195){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 209){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 217){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 218){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 220){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 303){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 312){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 189){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 193){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 24){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";             
            }elseif($tempBrandId == 314){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 316){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 318){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 33){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";             
            }elseif($tempBrandId == 192){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 322){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 323){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 224){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 67){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";             
            }elseif($tempBrandId == 327){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 335){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 56){
                $condition =" and `model_types`.id in(1,2,3,13,10,6,11,17,8,15,16,7,4)";             
            }elseif($tempBrandId == 216){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 152){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 188){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 185){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 228){
                $condition =" and `model_types`.id in(1,2,3,5,13,10,6,11,17,8,15,16,7,4)";
             }elseif($tempBrandId == 57){
                $condition =" and `model_types`.id not in(1,2,3,13,10,6,11,17,8,15,16,7,4)";
             }
// #rat			
		    
			$sql = "SELECT `model_types`.`name` as `type`, `model_types`.`id` as `type_id`,
					`model_types`.`name_m` as `type_m`,`model_types`.`name_rm` as `type_rm`,
					`model_types`.`name_re` as `type_re` 
					FROM `model_type_to_markas`
					INNER JOIN `marka_to_sites` ON `marka_to_sites`.`marka_id` = `model_type_to_markas`.`marka_id`
					INNER JOIN `model_types` ON `model_types`.`id` = `model_type_to_markas`.`model_type_id`
				WHERE `marka_to_sites`.`site_id`=? ".$condition;
			$stm = pdo::getPdo()->prepare($sql);
			$stm->execute(array($params['site_id']));
			$this->_datas['all_devices'] = $stm->fetchAll(\PDO::FETCH_ASSOC);
            $this->_datas['HERE0']=$this->_datas['all_devices']; //в таблицу Urls добавить строчку для данного сайта
		} else {
            if ($this->_datas['hb'] === true) {
                //$this->_datas['HERE1'];    
                $this->_datas['params'] = $params;
                $this->_datas['HERE1']='1'; 
                $sql = "SELECT `model_types`.`name` as `type`, `model_types`.`id` as `type_id`,
					`model_types`.`name_m` as `type_m`,`model_types`.`name_rm` as `type_rm`,
					`model_types`.`name_re` as `type_re` FROM `model_types`
					INNER JOIN `type_to_sites` ON `model_types`.`id` = `type_to_sites`.`type_id`
				WHERE `type_to_sites`.`site_id`=?";
                $stm = pdo::getPdo()->prepare($sql);
                $stm->execute(array($params['site_id']));
                $this->_datas['all_devices'] = $stm->fetchAll(\PDO::FETCH_ASSOC);

                $sql = "SELECT DISTINCT `markas`.`name` as `brand_name`, `markas`.`id` as `brand_id` FROM `markas`
                        INNER JOIN `models_list` ON `markas`.`id`=`models_list`.`marka_id`
                        INNER JOIN `type_to_sites` ON `type_to_sites`.`type_id`=`models_list`.`model_type_id`
                        INNER JOIN `sites` ON `sites`.`id`=`type_to_sites`.`site_id`
                        WHERE `sites`.`id`=? ORDER BY `markas`.`id` ASC";
                $stm = pdo::getPdo()->prepare($sql);
                $stm->execute(array($params['site_id']));
                $this->_datas['all_brands'] = $stm->fetchAll(\PDO::FETCH_ASSOC);
            } else {
                $this->_datas['HERE2']='2'; 
                $this->_datas['params'] = $params;
                $sql = "SELECT `model_types`.`name` as `type`, `model_types`.`id` as `type_id`,
					`model_types`.`name_m` as `type_m`,`model_types`.`name_rm` as `type_rm`,
					`model_types`.`name_re` as `type_re` FROM `model_types`
					INNER JOIN `type_to_sites` ON `model_types`.`id` = `type_to_sites`.`type_id`
				WHERE `type_to_sites`.`site_id`=?";
                $stm = pdo::getPdo()->prepare($sql);
                $stm->execute(array($params['site_id']));
                $this->_datas['all_devices'] = $stm->fetchAll(\PDO::FETCH_ASSOC);
                
                if($this->_datas['all_devices'][0]['type_id'] == 9){
                    $condition = " AND `markas`.`name` NOT LIKE 'Liebherr' AND `markas`.`name` NOT LIKE 'Bork' ";
                }elseif($this->_datas['all_devices'][0]['type_id'] == 5){
                    $condition = " AND `markas`.`name` NOT LIKE 'Oysters' ";
                }else{
                    $condition =' ';
                }
                
                $sql = "SELECT DISTINCT `markas`.`name` as `brand_name`, `markas`.`id` as `brand_id` 
                        FROM `markas`
                        INNER JOIN `model_type_to_markas` ON `markas`.`id`=`model_type_to_markas`.`marka_id`
                        INNER JOIN `type_to_sites` ON `type_to_sites`.`type_id`=`model_type_to_markas`.`model_type_id`
                        INNER JOIN `sites` ON `sites`.`id`=`type_to_sites`.`site_id`
                        WHERE `sites`.`id`=? 
                        ".$condition." 
                        ORDER BY `markas`.`id` ASC";
                $stm = pdo::getPdo()->prepare($sql);
                $stm->execute(array($params['site_id']));
                $this->_datas['all_brands'] = $stm->fetchAll(\PDO::FETCH_ASSOC);
            }
		}
        $this->_site_id = $params['site_id'];

        $f = $this->_datas['f'] = tools::gen_feed($params['site_name']);
        $diagnostic_time = $this->_datas['diagnostic_time'] = tools::get_rand(array(10, 15, 20, 30), $f);

        // region
        $this->_datas['region'] = $this->_getRegion($params['region_id']);
		$this->_datas['region_id'] = $params['region_id'];
        $city = $this->_datas['region']['name_pe'];
        $city_d = $this->_datas['region']['name_de'];
        $city_r = $this->_datas['region']['name_re'];
		
        // partner
        $this->_datas['partner'] = $this->_getPartner($params['partner_id']);
        $this->_datas['zoom'] = 16;
	
        // menu
        
		if ($this->_datas['hab'] === false) {
			$this->_datas['menu'] = array(
				'/' => 'Главная', //+
				'/about/price/' => 'Услуги и цены', //+
				'/info/components/' => 'Комплектующие', //+
                '/info/defects/' => 'Неисправности',
                '/help-pc/' => 'Компьютерная помощь', //+
				'/about/action/' => 'Акции', //+
                '/about/contacts/' => 'Контакты',//+
			);
			
			$this->_datas['menuf'] = array(
				'/info/components/' => 'Комплектующие', //+
                '/info/defects/' => 'Неисправности',
                '/help-pc/' => 'Компьютерная помощь', //+
				'/about/price/' => 'Услуги и цены', //+
                '/about/action/' => 'Акции', //+
                //+
			);
		} else {
			$this->_datas['menu'] = array(
				'/' => 'Главная', //+
				 "/about/price/" => 'Услуги и цены', 
				'/info/components/' => 'Комплектующие', //+
				'/about/action/' => 'Акции', //+
				'/about/contacts/' => 'Контакты', //+
                "/info/components/" => 'Комплектующие',
                
				
			);
			if ($this->_datas['hb'] === true) {
                $this->_datas['menu'] = array(
                    "/" => 'Главная', //+
                    "/about/price/" => 'Услуги и цены', //+
                    "/info/components/" => 'Комплектующие', //+
                    '/about/action/' => 'Акции', //+
                    '/info/' => 'Информация',
                    '/help/' => 'Помощь',
                    '/about/contacts/' => 'Контакты', //+
                );
                
                if($this->_datas['region_id']==0){
                    $tempArr=[];
                    foreach($this->_datas['menu'] as $key=>$value){
                        if($key == "/info/components/"){
			               $tempArr['/refilling-cartridges/'] ='Заправка картриджей';
                        }
                            $tempArr[$key] = $value;
                    }
                    $this->_datas['menu']=$tempArr;
                    unset($tempArr);
			    }
                
            }
			$this->_datas['menuf'] = array(
			    '/about/price/'=> 'Услуги и цены',
				'/info/components/' => 'Комплектующие', //+
				'/about/action/' => 'Акции', //+
			);
		}
        $this->_datas['menus'] = array(
            '/info/' => 'Информация', //+
            '/info/time-to-repair/' => 'Время ремонта', //+
            '/info/hurry-up-repairs/' => 'Срочный ремонт', //+
            '/info/diagnostics/' => 'Диагностика', //+
            '/info/delivery/' => 'Выезд и доставка', //+
        );
        if($this->_datas['hb'] === true){
            if($this->_datas['region_id']==0){
                $this->_datas['menuf']['/refilling-cartridges/'] ='Заправка картриджей';
            }
            $this->_datas['menus']['/help/'] =  'Помощь';
        }

        

		if (empty($this->_datas['hab'])) {
		    $this->_datas['menus']['/sitemap/'] = 'Карта сайта';
        }

        $this->_datas['menud'] = array(
            '/about/' => 'О компании', //+
            '/about/vacancy/' => 'Вакансии', //+
            '/about/contacts/' => 'Контакты', //+
        );

        //images
        $this->_datas['accord_image'] = array(
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
            'cмарт-часы' => 'smart-watch',
            'гироскутер' => 'giroscooters',
            'квадрокоптер' => 'quadrocopters',
            'электросамокат' => 'samokats',
            'холодильник' => 'fridges',
            'посудомоечная машина' => 'dishwashers',
            'стиральная машина' => 'washing-machines',
            'кофемашина' => 'coffee-machines',
            'плоттер' => 'plotter',
            'сортировщик купюр' => 'bill-sorters',
            'моноколесо' => 'monowheels',
            'сегвей' => 'segways',
            'водонагреватель' => 'water-heaters',
            'микроволновая печь' => 'microwave-ovens',
            'пылесос' => 'vacuum-cleaners',
            'робот-пылесос' => 'robot-vacuum-cleaners',
            'лазерный принтер'=>'laser-printers',
            'сушильная машина'=> 'dryer-machines',
        );

        //Диаграмма
        srand(tools::gen_feed($params['site_name']));
        $this->_datas['rand_ustroistva'] = rand(9000,35500);
        $this->_datas['HERE0']=$params;
        if (isset($params['static']))
        {
            // $typeInfo = [
            //     "плоттер" =>'plotterov',
            //     'планшет' =>'planshetov',
            // ];
            
            $file_name = ($params['static'] == '/') ? 'index' : $params['static'];
            $check_domen = preg_match('/^[a-z|\.]{0,}pomosch-komputernaya\.ru/',$params['realHost']);
            //if($check_domen && isset($params['admin']) && $params['admin'][0] == 'admin'){
            //if($params['realHost'] == 'tul.pomosch-komputernaya.ru'){
            if($check_domen){
            	include ('pages/sc7/description_pomosch_komputernaya.php');
                    switch ($params['static']) {
                        case 'hab':
                                $file_name = 'pomosch-index';
                            break;
                        case 'time-to-repair':
                                $file_name = 'pomosch-time-to-repair';
                            break;
                        case 'hurry-up-repairs':
                                $file_name = 'pomosch-hurry-up-repairs';
                            break;
                        case 'diagnostics':
                                $file_name = 'pomosch-diagnostics';
                                break;
                        case 'delivery':
                                $file_name = 'pomosch-delivery';
                                break;
                        case 'about':
                                $file_name = 'pomosch-about';
                                break;
                        case 'info':
                                $file_name = 'pomosch-info';
                                break;
                        case 'price':
                                $file_name = 'pomosch-price';
                                break;
                        case 'components':
                                $file_name = 'pomosch-components';
                                break;

                        // case 'antivirus-help':
                        // case 'installing-os':
                        // case 'data-recovery':
                        // case 'installing-software':
                        // case 'configuring-internet':
                        // case 'installing-devices':
                        //         $file_name = 'pomosch-page';
                        // break;

                        default:
                                $file_name = $params['static'];
                            break;
                    }
            }
			if ($file_name == 'index' && $this->_datas['hab'] === true) {
			    if ($this->_datas['hb'] === true) {
                    $file_name = 'hab_2';
                }
			}
            
            if (strstr($file_name, "remont-plotterov-") !== false) {
                $file_name = 'repair-plotters';
                $this->_datas['arg_url'] = 'repair-plotters';
            }
            
            if ($this->_datas['hab'] !== false) {
                if (strstr($file_name, "repair-".$this->_datas['accord_image'][$this->_datas['all_devices'][0]['type']]."-") !== false) {
    			    
                    $file_name = 'repair-'.$this->_datas['accord_image'][$this->_datas['all_devices'][0]['type']];
                    $this->_datas['arg_url'] = 'repair-'.$this->_datas['accord_image'][$this->_datas['all_devices'][0]['type']];
                }
            }
            
			if (strstr($file_name, "remont") !== false) {
				$file_name = 'remont';
			}
			
            if ($file_name)
            {
                $this->_datas = $this->_datas + $params;

                $feed = $this->_datas['feed'] = (isset($this->_datas['vals']['feed']) ? $this->_datas['vals']['feed'] : $this->_datas['feed']);
                
				if ($this->_datas['hab'] === false) {
				
					$sql = "SELECT * FROM `markas` WHERE `id`= ?";
					$stm = pdo::getPdo()->prepare($sql);
					$stm->execute(array($params['marka_id']));
					$this->_datas['marka'] = current($stm->fetchAll(\PDO::FETCH_ASSOC));
					

					$marka = $this->_datas['marka']['name'];  // SONY
					$marka_lower = mb_strtolower($marka);
					$region_name_pe = $this->_datas['region']['name_pe'];//в Москве (в Владивостоке)
					$ru_marka = $this->_datas['marka']['ru_name']; // СОНИ
					$servicename = $this->_datas['servicename']; //SONY Russia
					$region_name_pril = $this->_datas['region']['pril'];//Московском
                    // $this->_datas['OLOLO'] = $this->_datas;
				
				} else {
				    if (!empty($this->_datas['hb'])) {
                        if (!empty($params['marka_id'])) {
                            $sql = "SELECT * FROM `markas` WHERE `id`= ?";
                            $stm = pdo::getPdo()->prepare($sql);
                            $stm->execute(array($params['marka_id']));
                            $this->_datas['marka'] = current($stm->fetchAll( \PDO::FETCH_ASSOC));

                            $marka = $this->_datas['marka']['name'];  // SONY
                            $marka_lower = mb_strtolower($marka);
                            $region_name_pe = $this->_datas['region']['name_pe'];//в Москве (в Владивостоке)
                            $ru_marka = $this->_datas['marka']['ru_name']; // СОНИ
                            $servicename = $this->_datas['servicename']; //SONY Russia
                            $region_name_pril = $this->_datas['region']['pril'];//Московском
                        } else {
                            $this->_datas['marka']['name'] = "";
                            $this->_datas['marka']['ru_name'] = "";
                            $this->_datas['marka']['id'] = 0;
                            $marka = $this->_datas['marka']['name'];
                            $marka_lower = mb_strtolower($marka);
                            $region_name_pe = $this->_datas['region']['name_pe'];
                            $ru_marka = "";
                            $servicename = "PARTNERSER";
                            $region_name_pril = $this->_datas['region']['pril'];
                        }
                    } else {
                        if (!empty($params['marka_id'])) {
                            $sql = "SELECT * FROM `markas` WHERE `id`= ?";
                            $stm = pdo::getPdo()->prepare($sql);
                            $stm->execute(array($params['marka_id']));
                            $this->_datas['marka'] = current($stm->fetchAll( \PDO::FETCH_ASSOC));

                            $marka = $this->_datas['marka']['name'];  // SONY
                            $marka_lower = mb_strtolower($marka);
                            $region_name_pe = $this->_datas['region']['name_pe'];//в Москве (в Владивостоке)
                            $ru_marka = $this->_datas['marka']['ru_name']; // СОНИ
                            $servicename = $this->_datas['servicename']; //SONY Russia
                            $region_name_pril = $this->_datas['region']['pril'];//Московском
                        } else {
                            $this->_datas['marka']['name']    = "RUSSUPPORT";
                            $this->_datas['marka']['ru_name'] = "";
                            $this->_datas['marka']['id'] = 0;
                            $marka = $this->_datas['marka']['name'];
                            $marka_lower = mb_strtolower($marka);
                            $region_name_pe = $this->_datas['region']['name_pe'];
                            $ru_marka = "";
                            $servicename = "RUSSUPPORT";
                            $region_name_pril = $this->_datas['region']['pril'];
                        }
                    }
				}
                
                $this->_make_accord_table($marka_lower);
				
                $this->_gen_blocks();

                $description_help_pc = tools::new_gen_text(" {
                    {Специалисты|Мастера|Сисадмины|Системные администраторы|Специалисты сервиса|Мастера сервиса|Сисадмины сервиса|Системные администраторы сервиса}
                    {Russupport|RUSSUPPORT} {выполнят|осуществят|проведут} {работы|все работы|любые работы} по {подключению|установке|инсталляции}
                    {периферийных устройств|периферии|периферийного оборудования}, {настроят и установят|установят и настроят|установят и наладят|наладят и установят|налядт или установят|установят или наладят|установят или настроят|настроят или установят}
                    {
                        {
                             {нужный|необходимый|требуемый|запрашиваемый} {софт|soft}  
                        }|{
                             {нужное|необходимое|требуемое|запрашиваемое} {ПО|программное обеспечение}       
                        } 
                    }
                    на ^{компьютеры|ПК|персональные компьютеры}^(0) , ^{моноблоки|серверы}^(0) {,|или} ^{ноутбуки|лептопы}^(0) .   
                 }");

                switch ($file_name)
             {
              case 'index':
                        $t = array();
                        $t[] = array("Ремонт $marka в $region_name_pe -");
                        $t[] = array("сервисный центр","сервис центр");
                        $t[] = array("RUSSUPPORT");
                        $d = array();
                        $d[0][] = array("Сервисный центр","Сервис центр","Ремонтный центр","Ремонтный сервис центр","Сервис","Ремонтный сервис");
                        $d[0][] = array("$marka RUSSUPPORT");
                        $d1 = rand(1,2);
                        if($d1 == 1)
                        {
                            $d[0][] = array("устраним","исправим","отремонтируем","починим");
                            $d[0][] = array("любые неисправности:","любые поломки:");
                            $d[0][] = array("от самых ");
                            $d[0][] = array("незначитильных до","мелких до");
                            $d[0][] = array("сложного ремонта.","самого сложного ремонта.");
                        }
                        if($d1 == 2)
                        {
                            $d[0][] = array("справимся");
                            $d[0][] = array("с любыми неисправностями:","с любыми поломками:");
                            $d[0][] = array("от самых");
                            $d[0][] = array("незначитильных до","мелких до");
                            $d[0][] = array("сложного ремонта.","самого сложного ремонта.");
                        }
                        $d[0][] = array("Бесплатная диагностика,");
                        $d[1][] = array("оригинальные запчасти,","оригинальные комплектующие,","все запчасти оригинальные,","все комплектующие оригинальные,","фирменные запчасти,","фирменныекомплектующие,");
                        $d[1][] = array("длительная гарантия,","продолжительная гарантия,","долгосрочная гарантия,");
                        $d[1][] = array("фиксированные цены,","фиксированная стоимость,","регламентированные цены,","регламентированная стоимость,");
                        $d[1][] = array("оптимальные сроки ремонта,","сжатые сроки ремонт,","кратчайшие сроки ремонта,","оптимальное время ремонта,","кратчайшее время ремонта,");

                        $d_1_count = count($d[1]);
                        $d1_out = "";
                        for ($i = 0;$i < $d_1_count;$i++)
                        {
                            $d1_arr = array_rand($d[1]);
                            $d1_out .= $this->checkcolumn($d[1][$d1_arr]);
                            unset($d[1][$d1_arr]);
                        }
                        $d1_out = substr($d1_out,0,-1);
                        $d1_out .= ".";

                        $h = array();
                        $h[] = array("Сервисный центр","Сервис центр","Ремонтный центр","Ремонтный сервис центр","Сервис","Ремонтный сервис");
                        $h[] = array("$marka RUSSUPPORT");
                        
                        $title_arrays = array(
                            'acer' => 'Сервисный центр Acer в '.$region_name_pe.' - ремонт Асер в RUSSUPPORT',
                            'asus' => 'Сервисный центр ASUS в '.$region_name_pe.' - ремонт АСУС в RUSSUPPORT',
                            'apple' => 'Сервисный центр Apple в '.$region_name_pe.' - ремонт Эппл в RUSSUPPORT',
                            'dell' => 'Сервисный центр DELL в '.$region_name_pe.' - ремонт Делл в RUSSUPPORT',
                            'hp' => 'Сервисный центр HP в '.$region_name_pe.' - ремонт HP в RUSSUPPORT',
                            'htc' => 'Сервисный центр HTC в '.$region_name_pe.' - ремонт HTC в RUSSUPPORT',
                            'huawei' => 'Сервисный центр Huawei в '.$region_name_pe.' - ремонт Хуавей в RUSSUPPORT',
                            'lenovo' => 'Сервисный центр Lenovo в '.$region_name_pe.' - ремонт Леново в RUSSUPPORT',
                            'meizu' => 'Сервисный центр  Meizu в '.$region_name_pe.' - ремонт Мейзу в RUSSUPPORT',
                            'msi' => 'Сервисный центр MSI в '.$region_name_pe.' - ремонт MSI в RUSSUPPORT',
                            'nokia' => 'Сервисный центр Nokia в '.$region_name_pe.' - ремонт Нокиа в RUSSUPPORT',
                            'samsung' => 'Сервисный центр Samsung в '.$region_name_pe.' -  емонт Самсунг в RUSSUPPORT',
                            'sony' => 'Сервисный центр Sony в '.$region_name_pe.' - ремонт Сони в RUSSUPPORT',
                            'toshiba' => 'Сервисный центр Тошиба | Toshiba в '.$region_name_pe.' - ремонт Тошиба в RUSSUPPORT',
                            'xiaomi' => 'Сервисный центр Xiaomi в '.$region_name_pe.' - ремонт Ксиоми в RUSSUPPORT',
                            'zte' => 'Сервисный центр ZTE в '.$region_name_pe.' - ремонт ЗТЕ в RUSSUPPORT',
                            'vertu' => 'Сервисный центр Vertu в '.$region_name_pe.' - ремонт Верту в RUSSUPPORT',
                            'oneplus' => 'Сервисный центр OnePlus в '.$region_name_pe.' - ремонт ВанПлюс в RUSSUPPORT'
                        );
                        
                       if (isset($title_arrays[$marka_lower]))
                            $title = $title_arrays[$marka_lower];
                       else
                            $title = $this->checkarray($t);
                       
                       $description = $this->checkarray($d[0]) . " " . $d1_out;
                       $h1 = $this->checkarray($h);
              break;
              case 'antivirus-help':
                        $title = 'Удаление вирусов в '.$this->_datas['region']['name_pe'].' – сервис Russupport';
                        $description = $description_antivirus_helper;
                        $h1 = 'Антивирусная помощь';
                        $this->_datas['text']='Услуги на работы по антивирусной помощи:';
                        $this->_datas['content']=$description_antivirus_text;
                        $file_name = 'pomosch-page';

              break;
      
              case 'help-pc': 
                        $title = 'Срочная компьютерная помощь Russupport '.$this->_datas['marka']['name'].' в '.$this->_datas['region']['name_pe'].' – инсталляция и настройка операционных систем';
                        $h1 = 'Компьютерная помощь для техники '.$this->_datas['marka']['name'];
                        $description = $description_help_pc;
                        $file_name = 'help-pc';
              break;
              case 'wtf': 
                        $title = 'Срочная компьютерная помощь Russupport '.$this->_datas['marka']['name'].' в '.$this->_datas['region']['name_pe'].' – инсталляция и настройка операционных систем';
                        $h1 = 'Компьютерная помощь для техники '.$this->_datas['marka']['name'];
                        $description = '';
                        $file_name = 'wtf';
              break;              
              case 'installing-os':
                        $title = 'Помощь в установке и настройке ОС в '.$this->_datas['region']['name_pe'].' – сервис Russupport';
                        $description = $description_install_OC;
                        $h1 = 'Установка и настройка ОС';
                        $this->_datas['text']='Услуги на работы по установке и настройке ОС';  
                        $this->_datas['content']=$description_install_OC_text;
                        $file_name = 'pomosch-page';       
              break;
              case 'data-recovery':
                        $title = 'Восстановление поврежденных данных с цифровых носителей в '.$this->_datas['region']['name_pe'].' – сервис Russupport';
                        $description = $description_data_recovery;
                        $h1 = 'Восстановление данных';
                        $this->_datas['text']='Услуги на работы по восстановлению данных:';
                        $this->_datas['content']=$description_data_recovery_text;
                        $file_name = 'pomosch-page';                  
              break;
              case 'installing-software':
                        $title = 'Установка программного обеспечения и его настройка в '.$this->_datas['region']['name_pe'].' – сервис Russupport';
                        $description = $description_install_PO;
                        $this->_datas['text']='Услуги на работы по установке и настройке ПО:';
                        $this->_datas['content']=$description_install_PO_text;
                        $h1 = 'Установка и настройка ПО'; 
                        $file_name = 'pomosch-page';                     
              break;
              case 'configuring-internet':
                        $title = 'Настройка Интернет роутера в '.$this->_datas['region']['name_pe'].' – сервис Russupport';
                        $description = $description_setting;
                        $this->_datas['text']='Услуги на работы по настройке роутера и Интернета:';
                        $this->_datas['content']=$description_setting_text;
                        $h1 = 'Настройка роутера и Интернета';
                        $file_name = 'pomosch-page';                    
              break;
              case 'installing-devices':
                        $title = 'Подключение периферийных устройств в '.$this->_datas['region']['name_pe'].' – сервис Russupport';
                        $description = $description_periphery;
                        $this->_datas['text']='Услуги на работы по подключению и настройке периферии:';
                        $this->_datas['content']=$description_periphery_text;
                        $h1 = 'Подключение и настройка периферии';
                        $file_name = 'pomosch-page';                      
              break;
              case 'pomosch-index':
                        $title = 'Компьютерная помощь в '.$this->_datas['region']['name_pe'].' – сервис Russupport';
                        $description = $description_description;
                        $h1 = 'Ремонт компьютеров с выездом на дом';
              break;
              case 'pomosch-price':
						   $title = 'Цены на услуги '.$servicename.' в '.$region_name_pe;
                           $h1='Услуги и цены';
                           $description='Прайс-лист сервисного центра RUSSUPPORT в '.$region_name_pe.' . Цены на компьютерную помощь и восстановление данных.';
              break; 
              case 'pomosch-components':
                           $title = 'Запасные накопители в наличии и под заказ на складе RUSSUPPORT в '.$region_name_pe;
                           $h1='Комплектующие';
                           $description='Запасные накопители в наличии и под заказ на складе RUSSUPPORT в '.$region_name_pe.'. Стоимость предоставляемых работоспособных носителей для перенесения восстановленных данных.';
              break; 
              case 'pomosch-time-to-repair':
                        $title = 'Время ремонта техники RUSSUPPORT в '.$region_name_pe;
                        $h1 = 'Время работ';
                        $description = 'Время выполнения работ для техники RUSSUPPORT в '.$region_name_pe.' . Среднее время проведения восстановительных работ для разных типов устройств и моделей';
              break;
              case 'pomosch-hurry-up-repairs':
                        $title = 'Условия срочного ремонта RUSSUPPORT в '.$region_name_pe;
                        $h1 = 'Срочные работы';
                        $description = 'Условия проведения срочных работ в сервисном центре RUSSUPPORT в '.$region_name_pe;                  
              break;
              case 'pomosch-diagnostics':
                        $title = 'Условия проведения диагностики в RUSSUPPORT в '.$region_name_pe;
                        $h1 = 'Диагностика';
                        $description = 'Бесплатная диагностика в RUSSUPPORT в '.$region_name_pe.'. Условия проведения аппаратного тестирования и программной диагоностики.';
              break;
              case 'pomosch-delivery':
                        $title = 'Условия выезда курьера RUSSUPPORT в '.$region_name_pe;
                        $h1 = 'Выезд и доставка';
                        $description = 'Условия выезда курьера на дом, стоимость доставки аппаратуры в мастерскую и из лаборатории RUSSUPPORT в '.$region_name_pe;
              break;
              case 'pomosch-about':
                        $title = 'О сервисе RUSSUPPORT в '.$region_name_pe;
                        $h1 = 'О компании';
                        $description = 'О сервисе RUSSUPPORT: принципы работы, миссия компании, опыт сотрудников, технические возможности.';
              break;
              case 'pomosch-info':
                        $title = 'Условия работы RUSSUPPORT в '.$region_name_pe;
                        $h1 = 'Условия работы сервиса';
                        $description = 'Условия работы сервисного центра RUSSUPPORT в '.$region_name_pe.' : наличие и доставка накопителей, время работ, срочные работы, диагностика.';
              break;
              case 'courses-repair':
                        include('pages/sc7/description_vacancy.php');
                        $title = 'Обучающие курсы по ремонту стиральных машин для мастеров в '.$region_name_pe;
                        $h1 = 'Курсы по ремонту стиральных машин';
                        $description = $description_vacancy;                                   
              break;                 
                    case 'hab':
                        $t = array();
                        $t[] = array("Ремонт техники в $region_name_pe -");
                        $t[] = array("сервисный центр","сервис центр");
                        $t[] = array("RUSSUPPORT");
                        $d = array();
                        $d[0][] = array("Сервисный центр","Сервис центр","Ремонтный центр","Ремонтный сервис центр","Сервис","Ремонтный сервис");
                        $d[0][] = array("RUSSUPPORT");
                        $d1 = rand(1,2);
                        if($d1 == 1)
                        {
                            $d[0][] = array("устраним","исправим","отремонтируем","починим");
                            $d[0][] = array("любые неисправности:","любые поломки:");
                            $d[0][] = array("от самых ");
                            $d[0][] = array("незначитильных до","мелких до");
                            $d[0][] = array("сложного ремонта.","самого сложного ремонта.");
                        }
                        if($d1 == 2)
                        {
                            $d[0][] = array("справимся");
                            $d[0][] = array("с любыми неисправностями:","с любыми поломками:");
                            $d[0][] = array("от самых");
                            $d[0][] = array("незначитильных до","мелких до");
                            $d[0][] = array("сложного ремонта.","самого сложного ремонта.");
                        }
                        $d[0][] = array("Бесплатная диагностика,");
                        $d[1][] = array("оригинальные запчасти,","оригинальные комплектующие,","все запчасти оригинальные,","все комплектующие оригинальные,","фирменные запчасти,","фирменныекомплектующие,");
                        $d[1][] = array("длительная гарантия,","продолжительная гарантия,","долгосрочная гарантия,");
                        $d[1][] = array("фиксированные цены,","фиксированная стоимость,","регламентированные цены,","регламентированная стоимость,");
                        $d[1][] = array("оптимальные сроки ремонта,","сжатые сроки ремонт,","кратчайшие сроки ремонта,","оптимальное время ремонта,","кратчайшее время ремонта,");

                        $d_1_count = count($d[1]);
                        $d1_out = "";
                        for ($i = 0;$i < $d_1_count;$i++)
                        {
                            $d1_arr = array_rand($d[1]);
                            $d1_out .= $this->checkcolumn($d[1][$d1_arr]);
                            unset($d[1][$d1_arr]);
                        }
                        $d1_out = substr($d1_out,0,-1);
                        $d1_out .= ".";

                        $h = array();
                        $h[] = array("Сервисный центр","Сервис центр","Ремонтный центр","Ремонтный сервис центр","Сервис","Ремонтный сервис");
                        $h[] = array("RUSSUPPORT");


                        $title = $this->checkarray($t);

                        $description = $this->checkarray($d[0]) . " " . $d1_out;
                        $h1 = $this->checkarray($h);
                        break;
                    case 'hab_2':
                        $t = array();
                        $t[] = array("Ремонт плоттеров в $region_name_pe -");
                        $t[] = array("сервисный центр","сервис центр");
                        $t[] = array("PARTNERSER");
                        $d = array();
                        $d[0][] = array("Сервисный центр","Сервис центр","Ремонтный центр","Ремонтный сервис центр","Сервис","Ремонтный сервис");
                        $d[0][] = array("PARTNERSER");
                        $d1 = rand(1,2);
                        if($d1 == 1)
                        {
                            $d[0][] = array("устраним","исправим","отремонтируем","починим");
                            $d[0][] = array("любые неисправности:","любые поломки:");
                            $d[0][] = array("от самых ");
                            $d[0][] = array("незначитильных до","мелких до");
                            $d[0][] = array("сложного ремонта.","самого сложного ремонта.");
                        }
                        if($d1 == 2)
                        {
                            $d[0][] = array("справимся");
                            $d[0][] = array("с любыми неисправностями:","с любыми поломками:");
                            $d[0][] = array("от самых");
                            $d[0][] = array("незначитильных до","мелких до");
                            $d[0][] = array("сложного ремонта.","самого сложного ремонта.");
                        }
                        $d[0][] = array("Бесплатная диагностика,");
                        $d[1][] = array("оригинальные запчасти,","оригинальные комплектующие,","все запчасти оригинальные,","все комплектующие оригинальные,","фирменные запчасти,","фирменныекомплектующие,");
                        $d[1][] = array("длительная гарантия,","продолжительная гарантия,","долгосрочная гарантия,");
                        $d[1][] = array("фиксированные цены,","фиксированная стоимость,","регламентированные цены,","регламентированная стоимость,");
                        $d[1][] = array("оптимальные сроки ремонта,","сжатые сроки ремонт,","кратчайшие сроки ремонта,","оптимальное время ремонта,","кратчайшее время ремонта,");

                        $d_1_count = count($d[1]);
                        $d1_out = "";
                        for ($i = 0;$i < $d_1_count;$i++)
                        {
                            $d1_arr = array_rand($d[1]);
                            $d1_out .= $this->checkcolumn($d[1][$d1_arr]);
                            unset($d[1][$d1_arr]);
                        }
                        $d1_out = substr($d1_out,0,-1);
                        $d1_out .= ".";

                        $h = array();
                        $h[] = array("Сервисный центр","Сервис центр","Ремонтный центр","Ремонтный сервис центр","Сервис","Ремонтный сервис");
                        $h[] = array("PARTNERSER");


                        $title = $this->checkarray($t);

                        $description = $this->checkarray($d[0]) . " " . $d1_out;
                        $h1 = $this->checkarray($h);
                        break;
                        case 'contacts':
                        $description_contacts = array("адрес", "телефон горячей линии", "схема проезда", "форма обратной связи");

                       $title = 'Контактная информация '.$servicename.' в '.$region_name_pe;
                       $description = 'Контактная информация сервисного центра '.$marka.' RUSSUPPORT в '.$region_name_pe.'.'.$this->firstup($this->rand_arr_str($description_contacts)).'.';
                       $h1 = 'Контакты в '.$region_name_pe;

                        break;
                        case 'components':

                            $description_components_mass = array('в офис', 'на дом', 'центральный офис RUSSUPPORT');
                            $count_description_components_mass = count($description_components_mass);
                            $description_components_str = "";
                            for($i=0;$i<$count_description_components_mass; $i++)
                            {
                                $rand_keys = array_rand($description_components_mass, 1);
                                if($i==0) {
                                    $description_components_str .= $this->firstup($description_components_mass[$rand_keys]) . ", ";
                                }
                                if($i==1) {
                                    $description_components_str .= $description_components_mass[$rand_keys] . " или ";
                                }
                                if($i==2) {
                                    $description_components_str .= $description_components_mass[$rand_keys] . ".";
                                }
                                unset($description_components_mass[$rand_keys]);
                            }

               $title = 'Запчасти для техники '.$servicename.' в '.$region_name_pe;
               $description = 'Запасные части в наличии и под заказ на складе '.$marka.' RUSSUPPORT в '.$region_name_pe.'. Сроки доставки комплектующих.' .$description_components_str;
               $h1 = 'Комплектующие';

                        break;

                        case 'defects':



               $title = 'Неисправности '.implode(', ', array_column($this->_datas['all_devices'], 'type_rm')).' '.$marka;
               $description = 'Список распространенных неисправностей '.$marka.' от сервиса RUSSUPPORT.';
               $h1 = 'Неисправности';

                        break;

                        case 'price':
                            $all_deall_devices = $this->_datas['all_devices'];

                            $ustroista_all = "";
                            $all_deall_devices = $this->rand_arr(count($all_deall_devices),count($all_deall_devices),$all_deall_devices);
                            foreach ($all_deall_devices as $item)
                            {
                                $ustroista_all .= $item['type_rm'] . ", ";
                            }

                            $ustroista_all = substr($ustroista_all,0,-2);


						   $title = 'Цены на услуги '.$servicename.' в '.$region_name_pe;
						   $description = 'Прайс-лист сервисного центра '. $marka .' RUSSUPPORT в '.$region_name_pe.'. Цены на ремонт: '.$ustroista_all.'.';
						   $h1 = 'Услуги и цены';

                        break;
							case 'remont':
							$types_array = [
								"remont-monitorov"     => ["display.jpg", "монитор"],
								"remont-monoblokov"    => ["all-in-one.jpg", "моноблок"],
								"remont-noutbukov"     => ["laptop.jpg", "ноутбук"],
								"remont-planshetov"    => ["tablet.jpg", "планшет"],
								"remont-telefonov"     => ["phone.jpg", "смартфон"],
								"remont-proektorov"    => ["projector.jpg", "проектор"],
								"remont-fotoapparatov" => ["photo.jpg", "фотоаппарат"],
								"remont-printerov"     => ["mfu.jpg", "принтер"],
								"remont-kompyuterov"   => ["computer.jpg", "компьютер"],
								"remont-televizorov"   => ["tv.jpg", "телевизор"]
							];

							if (!empty($this->_datas['hb'])) {
							    foreach ($this->_datas['all_brands'] as $data) {
                                    $types_array['remont-plotterov-'.strtolower($data['brand_name'])] = ["display.jpg", "плоттер"];
                                }
                            }
                            
        //                     if (empty($this->_datas['hb']) && !empty($this->_datas['hab'])) {
		//                         foreach ($this->_datas['all_brands'] as $data) {
        //                             $types_array['remont-'.$typeInfo[$this->_datas['all_devices'][0]['type']].'-'.strtolower($data['brand_name'])] = ["display.jpg", $this->_datas['all_devices'][0]['type']];
        //                         }
        //                     }

							foreach($this->_datas['all_devices'] as $key => $val) {
								if ($val['type'] == $types_array[$params['static']][1])
									break;
							}
							$this->_datas['page'] = $params['static'];
						    $title = 'Ремонт '.$this->_datas['all_devices'][$key]['type_rm'].' в '.$region_name_pe.' - сервисный центр '.$this->_datas['all_devices'][$key]['type_rm'];
						    $description = 'Ремонт '.$this->_datas['all_devices'][$key]['type_rm'].' в сервисе RUSSUPORT.';
						    $h1 = 'Ремонт '.$this->_datas['all_devices'][$key]['type_rm'];
							$this->_datas['type_name_rm'] = $this->_datas['all_devices'][$key]['type_rm'];
                        break;
                        case 'action':

                        $description_action = array();
                            $description_action[] = array('Акции и скидки сервисного центра '.$marka.' RUSSUPPORT в '.$region_name_pe.'.');
                        $description_action_rand = rand(1,2);

                        if($description_action_rand == 1)
                        {
                            $description_action[] = array('Выгодные предложения.');
                            $description_action[] = array('Условия участия в акциях.');
                        }

                        if($description_action_rand == 2)
                        {
                            $description_action[] = array('Условия участия в акциях.');
                            $description_action[] = array('Выгодные предложения.');
                        }

               $title = 'Акции '.$servicename.' в '.$region_name_pe;
               $description = $this->checkarray($description_action);
               $h1 = 'Акции';

                        break;
                        case 'about':

               $title = 'О сервисе '.$servicename.' в '.$region_name_pe;
               $description = 'О сервисе '.$marka.' RUSSUPPORT: принципы работы, миссия компании, опыт сотрудников, технические возможности.';
               $h1 = 'О компании';

                        break;
                        case 'vacancy':

               $title = 'Вакансии сервиса '.$servicename.' в '.$region_name_pe;
               $description = 'Открытые вакансии сервисного центра '.$marka.' RUSSUPPORT в '.$region_name_pe.'. Условия работы: оформление по ТК РФ, график работы, зароботная плата.';
               $h1 = 'Вакансии';

                        break;
                    case 'time-to-repair':

                        $title = 'Время ремонта техники '.$servicename.' в '.$region_name_pe;
                        $description = 'Время ремонта техники '.$marka.' в RUSSUPPORT. Среднее время выполнения ремонтных работ на разных типах устройств и моделей.';
                        $h1 = 'Время ремонта';

                    break;
                    case 'help':

                        $title = 'Часто задаваемые вопросы по ремонту плоттеров'; //.$region_name_pe;
                        $description = 'Помощь при ремонте плоттеров. Вопросы и ответы.';
                        $h1 = 'F.A.Q: Помощь при ремонте плоттеров';//.$region_name_pe;

                    break;
                    case 'refilling-cartridges':

                        $title = 'PARTNERSER, заправка картриджей в '.$region_name_pe;
                        $description = 'Мы заправляем картриджи для плоттеров '.$marka.' в '.$region_name_pe;
                        $h1 = 'Заправка картриджей в '.$region_name_pe;

                        break;

                    case 'hurry-up-repairs':

               $title = 'Условия срочного ремонта '.$servicename.' в '.$region_name_pe;
               $description = 'Условия проведения срочного ремонта в сервисном центре '.$servicename.' в '.$region_name_pe;
               $h1 = 'Срочный ремонт';

                        break;
                        case 'diagnostics':

                        $description_diagnostics = rand(1,2);
                         $description_diagnostics_str = "";
                         if($description_diagnostics ==1)
                         {
                             $description_diagnostics_str = "программной диагоностики и аппаратного тестирования.";
                         }
                         if($description_diagnostics ==2)
                         {
                             $description_diagnostics_str = "аппаратного тестирования и программной диагоностики.";
                         }
                        $title = 'Условия проведения диагностики в '.$servicename.' в '.$region_name_pe;
               $description = 'Бесплатная диагностика в '.$marka.' RUSSUPPORT в '.$region_name_pe.'. Условия проведения '.$description_diagnostics_str;
               $h1 = 'Диагностика';

                        break;
                        case 'info':

                        $description_info = array('время ремонта', 'наличие и доставка запчастей', 'диагностика', 'срочный ремонт');

                        $title = 'Условия работы '.$servicename.' в '.$region_name_pe;
               $description = 'Условия работы сервисного центра '.$marka.' RUSSUPPORT в '.$region_name_pe.':'.$this->firstup($this->rand_arr_str($description_info)).'.';
               $h1 = 'Условия работы сервиса';

                        break;
                        
                        case 'sitemap':
                            $title = 'Карта сайта — сервисный центр '.$servicename.' в '.$region_name_pe;
                            $description = 'Карта сайта — сервисный центр '.$servicename.' в '.$region_name_pe;
                            $h1 = 'Карта сайта'; 
                        break;
                        
                        case 'delivery':

                           $title = 'Условия выезда курьера '.$servicename.' в '.$region_name_pe;
                           $description = 'Условия выезда курьера на дом, стоимость доставки аппаратуры в мастерскую и из лаборатории '.$servicename.' в '.$region_name_pe;
                           $h1 = 'Выезд и доставка';

                        break;

                        default:
                            $serviceName =($this->_datas['hb'])? 'PARTNERSER':'RUSSUPORT';
                            $gadget = $this->_datas['add_device_type'][$this->_datas['arg_url']];
                            
                           	$title = implode(' ', [
            							'Ремонт',
            							$gadget['type_rm'],
            							$this->_datas['marka']['name'],
            							'в',
            							$region_name_pe,
            							'—',
            							'сервис',
            							$gadget['type_rm'],
            							$this->_datas['marka']['ru_name'],
            							'ваш '.$serviceName
						                  ]);
                                    
                            $desc = array();
                            $desc[] = array("Сервис","Обслуживание");
                            $desc[] = array("и");
                            $desc[] = array("ремонт","восстановление");
                            $desc[] = array($gadget['type_rm']." ".$this->_datas['marka']['name'].".");
                            $desc[] = array("Список","Перечень");
                            $desc[] = array("услуг,");
                            $desc[] = array("комплектующих","запчастей","запасных частей");
                            $desc[] = array("для");
                            $desc[] = array("устройства.","аппарата.",$gadget['type_re'].".");
                            $desc[] = array("Цены","Прайслист");
                            $desc[] = array("на");
                            $desc[] = array("обслуживание,","ремонт","восстановление");
                            $desc[] = array("стоимость");
                            $desc[] = array("запчастей","комплектующих","запасных частей");
                            $desc[] = array("в");
                            $desc[] = array($params['servicename']);
            
                            $description = sc::_createTree($desc, $this->_datas['feed']);
                                                        
                            $h1 = implode(' ', ['Ремонт',
                                               $gadget['type_rm'],
                                               $this->_datas['marka']['name'],
                                               ]);
                                               
                            $this->_datas['gadget'] = $gadget;
                            
                            $file_name = 'gadget';

                }

				if ($this->_datas['hab'] === false) {
					$this->_datas['addresis'] = $this->_getAddresis($params['setka_id'], $this->_datas['marka']['id']);
				} else {
                    // $this->_datas['addresis'] = $this->_getHabAddresis($params['setka_id'], 'RUSSUPPORT');
                    
                    // $tempArr = explode('.',$params['site_name']);
                    // $domenName = (count($tempArr) >2) ? $tempArr[1] : $tempArr[0];
                    $this->_datas['addresis'] = $this->_getHabAddresisNotPlotter($params['original_setka_id'],$this->_datas['all_devices'][0]['type_id']);// $params['site_name']
                    
                    if ($this->_datas['hb'] === true) {
                        $this->_datas['addresis'] = $this->_getHabAddresis($params['original_setka_id'], 'PARTNERSER');
                    }
                    
				}

				$this->_ret['title'] = $title;
				$this->_ret['h1'] = $h1;
				$this->_ret['description'] = $description;
                
                $this->_sdek();
                $body = $this->_body($file_name, basename(__FILE__, '.php'));
                if (!empty($this->_datas['hb'])) {
                    $body = str_ireplace('RUSSUPPORT', 'PARTNERSER', $body);
                }
                return array('body' => $body);
           }
        }
		
        if (isset($params['7_defect_id'])) {
          $sql = "SELECT * FROM 7_defects WHERE id = ?";
          $stmt = pdo::getPdo()->prepare($sql);
          $stmt->execute([$params['7_defect_id']]);
          $defect = $this->_datas['defect'] = $stmt->fetch(\PDO::FETCH_ASSOC);

          $params['model_type_id'] = $defect['model_type_id'];
        }

        if (isset($params['m_model2_id'])) {
          $stmt = pdo::getPdo()->prepare("SELECT * FROM m_models2 WHERE id = ?");
          $stmt->execute([$params['m_model2_id']]);
          $this->_datas['m_model'] = $stmt->fetch(\PDO::FETCH_ASSOC);

          $params['model_type_id'] = $this->_datas['m_model']['model_type_id'];
          $params['marka_id'] = $this->_datas['m_model']['marka_id'];
        }

        if (isset($params['model2_id'])) {
          $stmt = pdo::getPdo()->prepare("SELECT models2.*, model_type_to_markas.model_type_id, model_type_to_markas.marka_id FROM models2 JOIN model_type_to_markas ON models2.model_type_mark = model_type_to_markas.id WHERE models2.id = ?");
          $stmt->execute([$params['model2_id']]);
          $this->_datas['model'] = $stmt->fetch(\PDO::FETCH_ASSOC);

          $params['model_type_id'] = $this->_datas['model']['model_type_id'];
          $params['marka_id'] = $this->_datas['model']['marka_id'];
        }

        if (!isset($params['marka_id'])) {
          $sql = "SELECT marka_id FROM marka_to_sites WHERE site_id = ?";
          $stm = pdo::getPdo()->prepare($sql);
          $stm->execute(array($this->_site_id));
          $params['marka_id'] = $stm->fetch()[0];
        }

        $this->_sqlData($params);
        
        $this->_make_accord_table(mb_strtolower($this->_datas['marka']['name']));
        $this->_datas['addresis'] = $this->_getAddresis($params['setka_id'], $this->_datas['marka']['id']);
        $feed = $this->_datas['feed'] = (isset($this->_datas['vals']['feed']) ? $this->_datas['vals']['feed'] : $this->_datas['feed']);
        $this->_gen_blocks();

        if (isset($params['7_defect_id'])) {
          $this->replaceMask($defect);
          $ret['title'] = [$defect['title']];
          $ret['h1'] = [$defect['h1']];
          $ret['description'] = [$defect['description']];
          $ret['plain'] = $defect['plain'];

          $file_name = 'defect';
        }
        else if (isset($params['model2_id'])) {
          $ret['title'] = array(
              ['Ремонт'],
			  [$this->_datas['model_type'][0]['name_re']],
              [$this->_datas['marka']['name']],
              [$this->_datas['model']['name']],
              ['в'],
              [$city],
              ['—'],
              ['сервис '.$this->_datas['model_type'][0]['name_re']],
			  [$this->_datas['marka']['name']],
              ['ваш RUSSUPORT']
          );/*
          $ret['title'] = array(
              ['Ремонт'],
              [$this->_datas['marka']['name']],
              [$this->_datas['model']['name']],
              ['в'],
              [$city],
              ['—'],
              ['сервис', 'сервисный центр', 'в сервис-центре'],
              [$this->_datas['servicename'].','],
              ['низкая'],
              ['стоимость', 'цена'],
          );*/
          $ret['title'] = [self::_createTree($ret['title'], $this->_datas['feed'])];

          $ret['h1'] = array(
              'Ремонт',
              $this->_datas['model_type'][1]['name_re'],
              $this->_datas['marka']['name'].' '.$this->_datas['model']['name'],
          );

          $desc = [
            ['Ремонт'],
            [$this->_datas['model_type'][1]['name_re'].' '.$this->_datas['marka']['name'].' '.$this->_datas['model']['name']],
            ['от профессионалов'],
            ['сервисного центра', 'сервис-центра', 'сервиса'],
            [$this->_datas['servicename']],
            ['в'],
            [$city.'.'],

            ['Оригинальные', 'Качественные'],
            ['комплектующие,', 'детали,'],
            ['честные', 'низкие'],
            ['цены, высокое качество.'],

            ['Предоставляем', 'Даем'],
            ['гарантию на все виды'],
            ['работ.', 'оказанных работ.'],
          ];

          $ret['description'] = array(
             sc::_createTree($desc, $this->_datas['feed']),
          );

          $plainRand = [
            [
              ['оригинальные'],
              ['детали', 'комплектующие'],
            ],
            [
              ['качественное', 'новое', 'сертифицированное'],
              ['оборудование'],
            ],
          ];

          srand($this->_datas['feed']);
          shuffle($plainRand);
          srand();

          foreach ($plainRand[0][count($plainRand[0])-1] as $k=>$v) {
            $plainRand[0][count($plainRand[0])-1][$k] .= ',';
          }

          foreach ($plainRand[1][count($plainRand[0])-1] as $k=>$v) {
            $plainRand[1][count($plainRand[0])-1][$k] .= '.';
          }

          $plain = array_merge([
            ['В нашем'],
            ['сервисном центре', 'сервисе', 'сервис-центре'],
            [$this->_datas['servicename']],
            ['мы специализируемся на ремонте'],
            [$this->_datas['model_type'][2]['name_re'].' '.$this->_datas['marka']['name'].' '.$this->_datas['model']['name'].'.'],

            ['Если вы'],
            ['заметили', 'обратили внимание'],
            ['что'],
            ['в', 'при'],
            ['работе'],
            ['гаджета', 'устройства', 'техники'],
            ['возникли', 'появились'],
            ['проблемы, приносите аппарат в наш'],
            ['сервис.', 'сервис-центр.', 'сервисный центр.'],

            ['При'],
            ['ремонте', 'восстановлении'],
            [$this->_datas['marka']['name'].' нашим'],
            ['специалистам', 'мастерам', 'инженерам'],
            ['помогает большой опыт,'],

          ],
          $plainRand[0],
          $plainRand[1],
          [
            ['Мы'],
            ['уверены', 'знаем'],
            ['что'],
            ['сможем', 'сумеем', 'в силах'],
            ['вам'],
            ['помочь', 'оказать помошь'],
            ['в', 'при'],
            ['любой'],
            ['ситуации.', 'возникшей ситуации.'],
          ]);

          $ret['plain'] = sc::_createTree($plain, $this->_datas['feed']);

          $file_name = 'model';
        }
        else if (isset($params['m_model2_id'])) {
          $ret['title'] = array(
              ['Ремонт'],
			  [$this->_datas['model_type'][0]['name_rm']],
              [$this->_datas['marka']['name']],
              [$this->_datas['m_model']['name']],
              ['в'],
              [$city],
              ['—'],
              ['сервис '.$this->_datas['model_type'][0]['name_re']],
			  [$this->_datas['marka']['name']],
              ['ваш RUSSUPORT']
          );
          /*$ret['title'] = array(
              ['Ремонт'],
              [$this->_datas['marka']['name']],
              [$this->_datas['m_model']['name']],
              ['в'],
              [$city],
              ['—'],
              ['сервис', 'сервисный центр', 'в сервис-центре'],
              [$this->_datas['servicename'].','],
              ['низкая'],
              ['стоимость', 'цена'],
          );*/
          $ret['title'] = [self::_createTree($ret['title'], $this->_datas['feed'])];

          $ret['h1'] = array(
              'Ремонт',
              $this->_datas['model_type'][1]['name_rm'],
              $this->_datas['marka']['name'].' '.$this->_datas['m_model']['name'],
          );

          $desc = [
            ['Ремонт'],
            [$this->_datas['model_type'][1]['name_rm'].' '.$this->_datas['marka']['name'].' '.$this->_datas['m_model']['name']],
            ['от профессионалов'],
            ['сервисного центра', 'сервис-центра', 'сервиса'],
            [$this->_datas['servicename']],
            ['в'],
            [$city.'.'],

            ['Оригинальные', 'Качественные'],
            ['комплектующие,', 'детали,'],
            ['честные', 'низкие'],
            ['цены, высокое качество.'],

            ['Предоставляем', 'Даем'],
            ['гарантию на все виды'],
            ['работ.', 'оказанных работ.'],
          ];

          $ret['description'] = array(
             sc::_createTree($desc, $this->_datas['feed']),
          );

          $plainRand = [
            [
              ['оригинальные'],
              ['детали', 'комплектующие'],
            ],
            [
              ['качественное', 'новое', 'сертифицированное'],
              ['оборудование'],
            ],
          ];

          srand($this->_datas['feed']);
          shuffle($plainRand);
          srand();

          foreach ($plainRand[0][count($plainRand[0])-1] as $k=>$v) {
            $plainRand[0][count($plainRand[0])-1][$k] .= ',';
          }

          foreach ($plainRand[1][count($plainRand[0])-1] as $k=>$v) {
            $plainRand[1][count($plainRand[0])-1][$k] .= '.';
          }

          $plain = array_merge([
            ['В нашем'],
            ['сервисном центре', 'сервисе', 'сервис-центре'],
            [$this->_datas['servicename']],
            ['мы специализируемся на ремонте'],
            ['линейки '.$this->_datas['model_type'][2]['name_rm'].' '.$this->_datas['marka']['name'].' '.$this->_datas['m_model']['name'].'.'],

            ['Если вы'],
            ['заметили', 'обратили внимание'],
            ['что'],
            ['в', 'при'],
            ['работе'],
            ['гаджета', 'устройства', 'техники'],
            ['возникли', 'появились'],
            ['проблемы, приносите аппарат в наш'],
            ['сервис.', 'сервис-центр.', 'сервисный центр.'],

            ['При'],
            ['ремонте', 'восстановлении'],
            [$this->_datas['marka']['name'].' нашим'],
            ['специалистам', 'мастерам', 'инженерам'],
            ['помогает большой опыт,'],

          ],
          $plainRand[0],
          $plainRand[1],
          [
            ['Мы'],
            ['уверены', 'знаем'],
            ['что'],
            ['сможем', 'сумеем', 'в силах'],
            ['вам'],
            ['помочь', 'оказать помошь'],
            ['в', 'при'],
            ['любой'],
            ['ситуации.', 'возникшей ситуации.'],
          ]);

          $ret['plain'] = sc::_createTree($plain, $this->_datas['feed']);

          $file_name = 'm_model';
        }
        else if (isset($params['marka_id']) && isset($params['model_type_id']))
        {
            if (!isset($params['key']))
            {
				// Ремонт телефонов Мейзу | Meizu в [city] — сервис смартфонов Meizu ваш RUSSUPPORT
				switch($this->_datas['model_type'][0]['name']) {
					case 'смартфон':
					case 'телефон':
						//Ремонт ноутбуков MSI в [city] — сервис ноутбуков МСИ ваш RUSSUPPORT
						$ret['title'] = array(
							'Ремонт',
							'телефонов',
							$this->_datas['marka']['name'],
							'в',
							$city,
							'—',
							'сервис смартфонов',
							$this->_datas['marka']['ru_name'],
							'ваш RUSSUPORT'
						);
						if ($this->_datas['marka']['name'] == 'Apple') {
							// Ремонт Apple iPhone (Айфон) в [city] — сервис телефонов Apple | Эппл ваш RUSSUPPORT
							$ret['title'] = array(
								'Ремонт Apple iPhone (Айфон) в',
								$city,
								'— сервис',
								$this->_datas['model_type'][0]['name_rm'],
								$this->_datas['marka']['name'],
								'| Эппл ваш RUSSUPORT'
							);
						}
					break;
					case 'планшет':
					case 'сервер':
						//Ремонт планшетов Нокиа в [city] ваш RUSSUPPORT
						$ret['title'] = array(
							'Ремонт',
							$this->_datas['model_type'][0]['name_rm'],
							$this->_datas['marka']['name'],
							'в',
							$city,
							'ваш RUSSUPORT'
						);
						if ($this->_datas['marka']['name'] == 'Apple') {
							// Ремонт Apple iPad в [city] — сервис планшетов Apple | Эппл ваш RUSSUPPORT
							$ret['title'] = array(
								'Ремонт Apple iPad в',
								$city,
								'— сервис',
								$this->_datas['model_type'][0]['name_rm'],
								$this->_datas['marka']['name'],
								'| Эппл ваш RUSSUPORT'
							);
						}
					break;
					case 'ноутбук':
						//Ремонт ноутбуков MSI в [city] — сервис ноутбуков МСИ ваш RUSSUPPORT
						$ret['title'] = array(
							'Ремонт',
							$this->_datas['model_type'][0]['name_rm'],
							$this->_datas['marka']['name'],
							'в',
							$city,
							'—',
							'сервис',
							$this->_datas['model_type'][0]['name_rm'],
							$this->_datas['marka']['ru_name'],
							'ваш RUSSUPORT'
						);
						if ($this->_datas['marka']['name'] == 'Apple') {
							// Ремонт Apple MacBook в [city] — сервис ноутбуков Apple ваш RUSSUPPORT
							$ret['title'] = array(
								'Ремонт Apple MacBook в',
								$city,
								'— сервис',
								$this->_datas['model_type'][0]['name_rm'],
								$this->_datas['marka']['name'],
								'| Эппл ваш RUSSUPORT'
							);
						}
					break;
					case 'моноблок':
					case 'монитор':
					case 'фотоаппарат':
						//Ремонт моноблоков MSI | МСИ в [city] ваш RUSSUPPORT
						$ret['title'] = array(
							'Ремонт',
							$this->_datas['model_type'][0]['name_rm'],
							$this->_datas['marka']['name'],
							'|',
							$this->_datas['marka']['ru_name'],
							'в',
							$city,
							'ваш RUSSUPORT'
						);
						//Ремонт Apple iMac в [city] — сервис моноблока Apple ваш RUSSUPPORT
						if ($this->_datas['marka']['name'] == 'Apple') {
							$ret['title'] = array(
								'Ремонт Apple iMac в',
								$city,
								'— сервис',
								$this->_datas['model_type'][0]['name_rm'],
								$this->_datas['marka']['name'],
								'| Эппл ваш RUSSUPORT'
							);
						}
					break;
					case 'компьютер':
					case 'проектор':
						// Ремонт компьютеров MSI в [city] ваш RUSSUPPORT
						// Ремонт проекторов Sony в [city] ваш RUSSUPPORT
						$ret['title'] = array(
							'Ремонт',
							$this->_datas['model_type'][0]['name_rm'],
							$this->_datas['marka']['name'],
							'в',
							$city,
							'ваш RUSSUPORT'
						);
					break;
					case 'игровая приставка':
						// Ремонт игровой приставки Sony Playstation (3,2,4) в [city] ваш RUSSUPPORT
						$ret['title'] = array(
							'Ремонт игровой приставки Sony Playstation (3,2,4) в',
							$city,
							'ваш RUSSUPPORT'
						);
					break;
					// case 'телевизор' default
					// case 'холодильник' default
					default:
						$ret['title'] = array(
							'Ремонт',
							$this->_datas['model_type'][0]['name_rm'],
							$this->_datas['marka']['name'],
							'|',
							$this->_datas['marka']['ru_name'],
							'в',
							$city,
							'—',
							'сервис',
							$this->_datas['model_type'][0]['name_rm'],
							$this->_datas['marka']['name'],
							'ваш RUSSUPORT'
						);
					break;
				}				
				
                $ret['h1'] = array(
                    'Ремонт',
                    $this->_datas['model_type'][1]['name_rm'],
                    $this->_datas['marka']['name'],
                );

                $desc = array();
                $desc[] = array("Сервис","Обслуживание");
                $desc[] = array("и");
                $desc[] = array("ремонт","восстановление");
                $desc[] = array($this->_datas['model_type'][2]['name_rm']." ".$this->_datas['marka']['name'].".");
                $desc[] = array("Список","Перечень");
                $desc[] = array("услуг,");
                $desc[] = array("комплектующих","запчастей","запасных частей");
                $desc[] = array("для");
                $desc[] = array("устройства.","аппарата.",$this->_datas['model_type'][2]['name_re'].".");
                $desc[] = array("Цены","Прайслист");
                $desc[] = array("на");
                $desc[] = array("обслуживание,","ремонт","восстановление");
                $desc[] = array("стоимость");
                $desc[] = array("запчастей","комплектующих","запасных частей");
                $desc[] = array("в");
                $desc[] = array($params['servicename']);

                $ret['description'] = array(
                   sc::_createTree($desc, $this->_datas['feed']),
                );

                $file_name = 'model-types';
            }
            else
            {
                $ret['title'] = array(
					//Замена северного моста ноутбука Sony | Сони в [city] ваш RUSSUPPORT
                    tools::mb_firstupper($this->_datas['syns'][0]),
                    $this->_datas['model_type'][0]['name_re'],
                    $this->_datas['marka']['name'],
					'|',
					$this->_datas['marka']['ru_name'],
                    'в',
                    $city,
                    'ваш',
                    'RUSSUPORT'
                );

                $ret['h1'] = array(
                    tools::mb_firstupper($this->_datas['syns'][1]),
                    $this->_datas['model_type'][1]['name_re'],
                    $this->_datas['marka']['name'],
                );

                $description = array();

                $t[0][] = array('Время ремонта,', 'Время восстановления,');
                $t[0][] = array('стоимость.', 'цена.');

                $temp = array();
                foreach ($t[0][0] as $t_0_0_val)
                    foreach ($t[0][1] as $t_0_1_val)
                        $temp[] = $t_0_0_val.' '.$t_0_1_val;

                $t[0] = $temp;
                $t[1] = array('Оформление заявки на ремонт.', 'Подача заявки на ремонт.');

                $description = rand_it::randMas($t, 2, '', $feed);

                $ret['description'] = array(
                    tools::mb_firstupper($this->_datas['syns'][2]),
                    $this->_datas['model_type'][2]['name_re'],
                    $this->_datas['marka']['name'],
                    'в',
                    $city.'.',
                    sc::_createTree($description, $this->_datas['feed']),
                );

                $file_name = 'services';
            }
        }

        foreach (array('h1', 'title', 'description') as $key)
             if (isset($ret[$key])) $ret[$key] = implode(' ', $ret[$key]);

        $this->_ret = $this->_answer($answer, $ret);

       	$this->_sdek();
        $body = $this->_body($file_name, basename(__FILE__, '.php'));
	
        return array('body' => $body);
    }

    private function _gen_blocks()
    {
        $blocks = array();
        $blocks[0][] = array('<div class="link-block"><div class="link-block-title-strong">Бесплатная диагностика</div>');
        $blocks[0][] = array('<div class="link-block-text">Тестирование', ' <div class="link-block-text">Проверка', ' <div class="link-block-text">Комплексное тестирование');
        $blocks[0][] = array('на профессиональном оборудовании</div></div>', 'на профессиональных стендах</div></div>');
        if(preg_match('/^[a-z|\.]{0,}pomosch-komputernaya\.ru/',$this->_datas['realHost'])){
        $blocks[1][] = array('<div class="link-block"><div class="link-block-title-strong">Срочные работы <br>от 30 минут</div>');
        } else {
        $blocks[1][] = array('<div class="link-block"><div class="link-block-title-strong">Срочный ремонт <br>от 30 минут</div>');    
        }
        $blocks[1][] = array('<div class="link-block-text">Экспресс восстановление', '<div class="link-block-text">Быстрый ремонт',
                                    '<div class="link-block-text">Экспресс ремонт', '<div class="link-block-text">Быстрое восстановление');
        $blocks[1][] = array('устройства</div></div>', 'гаджета</div></div>', 'техники</div></div>');

        if ($region_name = $this->_datas['region']['name'] == 'Москва')
            $blocks[2][] = array('<div class="link-block"><div class="link-block-title-strong">Выезд в пределах МКАД <br>30 минут</div>');
        else
            $blocks[2][] = array('<div class="link-block"><div class="link-block-title-strong">Выезд в пределах города <br>30 минут</div>');

        $choose = rand(0, 1);
        switch ($choose)
        {
            case 0:
                $blocks[2][] = array('<div class="link-block-text">Выезд курьера за вашим');
                $blocks[2][] = array('устройством</div></div>', 'гаджетом</div></div>');
            break;
            case 1:
                $blocks[2][] = array('<div class="link-block-text">Выезд и доставка вашего устройства');
                $blocks[2][] = array('устройства</div></div>', 'гаджета</div></div>');
            break;
        }

        $blocks[3][] = array('<div class="link-block"><div class="link-block-title-strong">Оригинальные запчасти <br>в наличии</div>');
        $blocks[3][] = array('<div class="link-block-text">Только', '<div class="link-block-text">Исключительно');
        $blocks[3][] = array('оригинальные запчасти</div></div>', 'оригинальные комплектующие</div></div>', 'оригинальные запасные части</div></div>');

        $this->_datas['blocks'] = rand_it::randMas($blocks, 4, '', $this->_datas['feed']);

        $this->_datas['r'] = array(round($this->_datas['rand_ustroistva']*0.40), round($this->_datas['rand_ustroistva'] + $this->_datas['rand_ustroistva']*0.1),
            round($this->_datas['rand_ustroistva']*0.30), round($this->_datas['rand_ustroistva'] + $this->_datas['rand_ustroistva']*0.05),
                round($this->_datas['rand_ustroistva']));
    }

    public function replaceMask(&$arr) {
      foreach (['title', 'description', 'h1', 'plain'] as $field) {
        if (isset($arr[$field])) {
          $arr[$field] = strtr($arr[$field], [
            '[brand]' => $this->_datas['marka']['name'],
            '[name]' => $this->_datas['servicename'],
          ]);

          srand($this->_datas['feed']);

          if (preg_match_all('/\{([А-Яа-яA-Za-z\s\?|-]+)\}/u', $arr[$field], $match)) {
            foreach ($match[1] as $var) {
              $varArr = explode('|', $var);
              $newVar = $varArr[array_rand($varArr)];
              $arr[$field] = str_replace('{'.$var.'}', $newVar, $arr[$field]);
            }
          }

          srand();
        }
      }
    }
    
    private function _make_accord_table($marka_lower)
    {
        $this->_datas['add_device_url'] = $urls = array(
            'apple' => array('repair-monitors','repair-computers'),
            'acer' => array('repair-monitors'),
            'asus' => array('repair-projectors'),
            'canon' => array('repair-projectors','repair-video-cameras'),
            'dexp' => array('repair-tvs','repair-projectors'),
            'digma' => array('repair-projectors'),
            'haier' => array('repair-tvs'),
            'htc' => array('repair-tablets'),
            'msi' => array('repair-tablets','repair-monitors'),
            'prestigio' => array('repair-tvs'),
            'samsung' => array('repair-monoblocks','repair-monitors','repair-projectors'),
            'sony' => array('repair-monoblocks'),
            'toshiba' => array('repair-tvs','repair-projectors','repair-fridges','repair-washing-machines'),
            'xiaomi' => array( 'repair-tvs','repair-projectors', 'repair-cameras', 'repair-giroscooters','repair-quadrocopters','repair-samokats'),
            'zte' => array('repair-routers'),
            'hp' => array('repair-smartphones','repair-tablets','repair-monitors','repair-projectors','repair-plotter'),
            'meizu' => array('repair-tablets','repair-smart-watch'),
            'vertu' => array('repair-smartphones'),
            'oneplus' => array('repair-smartphones'),
            'barco' =>  array('repair-projectors'),
            'benq' =>  array('repair-smartphones', 'repair-monitors','repair-projectors'),
            'christie' =>  array('repair-projectors'),
            'cinemood' =>  array('repair-projectors'),
            'epson' =>  array('repair-projectors','repair-printers'),
            'hitachi' =>  array('repair-tvs','repair-projectors','repair-fridges'),
            'infocus' =>  array('repair-projectors'),
            'jvc' =>  array('repair-tvs','repair-projectors','repair-video-cameras'),
            'lenovo' =>  array('repair-monitors','repair-computers','repair-projectors'),
            'lg' =>  array('repair-smartphones','repair-tablets','repair-laptops','repair-tvs','repair-monitors','repair-projectors','repair-fridges','repair-washing-machines','repair-dishwashers'),
            'nec' =>  array('repair-monitors','repair-projectors'),
            'optoma' =>  array('repair-projectors'),
            'panasonic'=>  array('repair-smartphones','repair-laptops','repair-tablets','repair-tvs','repair-monitors','repair-projectors','repair-cameras','repair-video-cameras','repair-printers','repair-fridges','repair-washing-machines'),
            'philips' =>  array('repair-smartphones','repair-tvs','repair-monitors','repair-projectors','repair-printers','repair-coffee-machines'),
            'ricoh' =>  array('repair-projectors','repair-cameras','repair-printers'),
            'sharp' =>  array('repair-tvs','repair-projectors','repair-fridges','repair-washing-machines'),
            'viewSonic' =>  array('repair-monitors','repair-projectors'),
            'vivitek' =>  array('repair-projectors'),
            'xgimi' =>  array('repair-projectors'),
            'dell' =>  array('repair-smartphones','repair-tablets','repair-computers','repair-projectors', 'repair-laptops', 'repair-monoblocks', 'repair-monitors', 'repair-servers'), //хую
            'sigma' =>  array('repair-cameras'),
            'fujifilm' =>  array('repair-cameras','repair-printers'),
            'polaroid' =>  array('repair-cameras','repair-printers'),
            'olympus' =>  array('repair-cameras'),
            'leica' =>  array('repair-cameras'),
            'kodak' =>  array('repair-cameras'),
            'hasselblad' =>  array('repair-cameras'),
            'airwheel' => array('repair-monowheels','repair-samokats','repair-segways','repair-giroscooters'),
            'zaxboard' => array('repair-samokats','repair-segways'),
            'globber' => array('repair-samokats'),
            'halten' => array('repair-samokats'),
            'razor' => array('repair-giroscooters','repair-samokats'),
            'hiper' => array('repair-samokats', 'repair-projectors'),
            'hoverbot' => array('repair-monowheels','repair-samokats','repair-segways','repair-giroscooters'),
            'iconbit' => array('repair-samokats', 'repair-giroscooters','repair-tablets'),
            'inmotion' => array('repair-monowheels','repair-samokats','repair-segways','repair-giroscooters'),
            'polaris' => array('repair-giroscooters', 'repair-samokats'),
            'ninebot' => array('repair-monowheels','repair-samokats','repair-segways','repair-giroscooters'),
            'kugoo' => array('repair-samokats','repair-giroscooters'),
            'kingsong' => array('repair-monowheels', 'repair-samokats'),
            'omen' => array('repair-laptops', 'repair-computers'),
            'compaq' => array('repair-laptops', 'repair-computers', 'repair-monoblocks'),
            'predator' => array('repair-laptops', 'repair-computers'),
            'rover' => array('repair-laptops', 'repair-tablets'),
            'vestel' => array('repair-laptops', 'repair-tablets', 'repair-smartphones', 'repair-tvs'),
            'emachines' => array('repair-laptops','repair-monoblocks'),
            '4good' => array('repair-laptops','repair-tablets','repair-smartphones'),
            'honor' => array('repair-laptops','repair-tablets','repair-smartphones','repair-tvs'),
            'microsoft' => array('repair-laptops','repair-tablets','repair-smartphones','repair-computers','repair-monoblocks','repair-game-consoles'),
            'micromax' => array('repair-laptops','repair-tablets','repair-smartphones','repair-tvs'),
            
            'shivaki'=> array('repair-tvs','repair-washing-machines','repair-fridges','repair-dishwashers','repair-monitors','repair-vacuum-cleaners','repair-microwave-ovens'),
            'teka'=> array('repair-washing-machines','repair-fridges','repair-dishwashers','repair-coffee-machines','repair-water-heaters','repair-microwave-ovens'),
            'weissgauff'=> array('repair-washing-machines','repair-dishwashers','repair-fridges','repair-microwave-ovens','repair-vacuum-cleaners','repair-robot-vacuum-cleaners'),
            'whirlpool'=> array('repair-washing-machines','repair-fridges','repair-dishwashers','repair-microwave-ovens','repair-vacuum-cleaners','repair-coffee-machines','repair-water-heaters'),
            'midea'=> array('repair-dishwashers','repair-fridges','repair-microwave-ovens','repair-robot-vacuum-cleaners','repair-washing-machines','repair-vacuum-cleaners','repair-water-heaters'),
            'miele'=> array('repair-washing-machines','repair-vacuum-cleaners','repair-coffee-machines','repair-robot-vacuum-cleaners','repair-fridges','repair-dishwashers','repair-microwave-ovens'),
            'aeg' => array('repair-fridges','repair-vacuum-cleaners','repair-coffee-machines','repair-washing-machines','repair-robot-vacuum-cleaners','repair-tvs','repair-dryer-machines','repair-dishwashers','repair-microwave-ovens'),
            'ardo' => array('repair-microwave-ovens','repair-dishwashers','repair-washing-machines','repair-dryer-machines','repair-fridges'),
            'ariston' => array('repair-coffee-machines','repair-vacuum-cleaners','repair-dishwashers','repair-microwave-ovens','repair-washing-machines','repair-dryer-machines','repair-fridges'),
            'hisense' => array('repair-smartphones','repair-fridges','repair-washing-machines','repair-tvs'),
            'hyundai' => array('repair-vacuum-cleaners','repair-tvs'),
            'iiyama' => array('repair-tvs'),
            'indesit' => array('repair-coffee-machines','repair-microwave-ovens','repair-dishwashers','repair-washing-machines','repair-dryer-machines','repair-fridges'),
            'kaiser' => array('repair-coffee-machines','repair-microwave-ovens','repair-dishwashers','repair-washing-machines','repair-fridges'),
            'kitchenaid' => array('repair-coffee-machines','repair-microwave-ovens','repair-dishwashers','repair-fridges'),
            'kitfort' => array('repair-robot-vacuum-cleaners','repair-vacuum-cleaners'),
            'kuppersbusch' => array('repair-coffee-machines','repair-microwave-ovens','repair-dishwashers','repair-washing-machines','repair-dryer-machines','repair-tvs','repair-fridges'),
            'kyocera' => array('repair-laser-printers','repair-smartphones'),
            'leran' => array('repair-coffee-machines','repair-microwave-ovens','repair-dishwashers','repair-vacuum-cleaners','repair-washing-machines','repair-fridges'),
            'oki' => array('repair-laser-printers','repair-plotter'),
            'oysters'=> array('repair-tablets','repair-smartphones','repair-coffee-machines',),
            'packard bell'=> array('repair-laptops','repair-monitors','repair-monoblocks','repair-laptops','repair-tablets',),
            'roland'=> array('repair-plotter','repair-printers',),
            'sanyo'=> array('repair-tvs','repair-projectors',),
            'zanussi'=> array('repair-washing-machines','repair-dishwashers','repair-fridges','repair-vacuum-cleaners','repair-microwave-ovens','repair-dryer-machines'),
            'siemens'=> array('repair-coffee-machines','repair-washing-machines','repair-dishwashers','repair-fridges','repair-microwave-ovens','repair-dryer-machines'),
            'smeg'=> array('repair-fridges','repair-coffee-machines','repair-dishwashers','repair-washing-machines','repair-microwave-ovens','repair-dryer-machines'),
            'mimaki'=> array('repair-plotter','repair-printers'),
            'neff'=> array('repair-dishwashers','repair-fridges','repair-washing-machines','repair-coffee-machines','repair-microwave-ovens'),
            'asko'=> array('repair-washing-machines','repair-fridges','repair-dishwashers','repair-coffee-machines','repair-microwave-ovens'),
            'bauknecht'=> array('repair-washing-machines','repair-fridges','repair-dishwashers','repair-coffee-machines','repair-microwave-ovens'),
            'bbk'=> array('repair-tvs','repair-microwave-ovens','repair-dishwashers','repair-vacuum-cleaners','repair-smartphones','repair-fridges','repair-tablets','repair-monitors'),
            'beko'=> array('repair-washing-machines','repair-fridges','repair-dishwashers','repair-vacuum-cleaners','repair-microwave-ovens','repair-coffee-machines','repair-water-heaters'),
            'bork'=> array('repair-coffee-machines','repair-vacuum-cleaners','repair-microwave-ovens'),
            'bosch'=> array('repair-dishwashers','repair-washing-machines','repair-fridges','repair-vacuum-cleaners','repair-coffee-machines','repair-microwave-ovens','repair-robot-vacuum-cleaners','repair-water-heaters'),
            'brandt'=> array('repair-tvs','repair-washing-machines','repair-fridges','repair-dishwashers','repair-coffee-machines','repair-microwave-ovens'),
            'brother'=> array('repair-printers','repair-plotter'),
            'candy'=> array('repair-washing-machines','repair-dishwashers','repair-fridges','repair-microwave-ovens','repair-vacuum-cleaners','repair-water-heaters'),
            'delonghi'=> array('repair-coffee-machines','repair-microwave-ovens','repair-vacuum-cleaners','repair-dishwashers'),
            'electrolux'=> array('repair-dishwashers','repair-washing-machines','repair-water-heaters','repair-vacuum-cleaners','repair-fridges','repair-microwave-ovens','repair-robot-vacuum-cleaners','repair-coffee-machines'),
            'fujitsu'=> array('repair-laptops','repair-tvs','repair-smartphones','repair-monitors','repair-laptops','repair-monoblocks','repair-tablets','repair-servers'),
            'gaggenau'=> array('repair-fridges','repair-dishwashers','repair-coffee-machines','repair-washing-machines','repair-microwave-ovens'),
            'ginzzu'=> array('repair-vacuum-cleaners','repair-laptops','repair-fridges','repair-dishwashers','repair-smartphones','repair-tablets'),
            'gorenje'=> array('repair-microwave-ovens','repair-washing-machines','repair-fridges','repair-dishwashers','repair-vacuum-cleaners','repair-water-heaters','repair-coffee-machines'),
            'graude'=> array('repair-washing-machines','repair-fridges','repair-dishwashers','repair-coffee-machines','repair-microwave-ovens'),
            'hansa'=> array('repair-dishwashers','repair-washing-machines','repair-fridges','repair-microwave-ovens','repair-vacuum-cleaners','repair-water-heaters'),
        );

        $this->_datas['add_device_type'] = $add_device_type = array(
            'repair-monitors' => array('type' => 'монитор', 'type_rm' => 'мониторов', 'type_m' => 'мониторы', 'type_de' => 'монитором', 'type_re' => 'монитора'),
            'repair-projectors' => array('type' => 'проектор', 'type_rm' => 'проекторов', 'type_m' => 'проекторы', 'type_de' => 'проектором', 'type_re' => 'проекторов'),
            'repair-video-cameras' => array('type' => 'видеокамера', 'type_rm' => 'видеокамер', 'type_m' => 'видеокамеры', 'type_de' => 'видеокамерой', 'type_re' => 'видеокамеры'),
            'repair-cameras' => array('type' => 'фотоаппарат', 'type_rm' => 'фотоаппаратов', 'type_m' => 'фотоаппараты', 'type_de' => 'фотоаппаратом', 'type_re' => 'фотоаппаратов'),
            'repair-tvs' => array('type' => 'телевизор', 'type_rm' => 'телевизоров', 'type_m' => 'телевизоры', 'type_de' => 'телевизором', 'type_re' => 'телевизоров'),
            'repair-tablets' => array('type' => 'планшет', 'type_rm' => 'планшетов', 'type_m' => 'планшеты', 'type_de' => 'планшетом', 'type_re' => 'планшетов'),
            'repair-monoblocks' => array('type' => 'моноблок', 'type_rm' => 'моноблоков', 'type_m' => 'моноблоки', 'type_de' => 'моноблоком', 'type_re' => 'моноблоков'),
            'repair-routers' => array('type' => 'роутер', 'type_rm' => 'роутеров', 'type_m' => 'роутеры', 'type_de' => 'роутером', 'type_re' => 'роутеров'),
            'repair-smartphones' => array('type' => 'смартфон', 'type_rm' => 'смартфонов', 'type_m' => 'смартфоны', 'type_de' => 'смартфоном', 'type_re' => 'смартфонов'),
            'repair-smart-watch' => array('type' => 'cмарт-часы', 'type_rm' => 'cмарт-часов', 'type_m' => 'смарт часы', 'type_de' => 'cмарт-часами', 'type_re' => 'cмарт-часы'),
            'repair-giroscooters' => array('type' => 'гироскутер', 'type_rm' => 'гироскутеров', 'type_m' => 'гироскутеры', 'type_de' => 'гироскутером', 'type_re' => 'гироскутеров'),
            'repair-quadrocopters' => array('type' => 'квадрокоптер', 'type_rm' => 'квадрокоптеров', 'type_m' => 'квадрокоптеры', 'type_de' => 'квадрокоптером', 'type_re' => 'квадрокоптеров'),
            'repair-samokats' => array('type' => 'электросамокат', 'type_rm' => 'электросамокатов', 'type_m' => 'электросамокаты', 'type_de' => 'электросамокатом', 'type_re' => 'электросамокатов'),
            'repair-game-consoles' => array ('type' => 'игровая приставка', 'type_rm' => 'игровых приставок', 'type_m' => 'игровые приставки', 'type_de' => 'игровой приставкой', 'type_re' => 'игровой приставки'),
            
            'repair-servers' => array ('type' => 'сервер', 'type_rm' => 'серверов', 'type_m' => 'сервера', 'type_de' => 'сервером', 'type_re' => 'сервера'),
            //'repair-laptops' => array('type' => 'наушники', 'type_rm' => 'наушников', 'type_m' => 'наушники', 'type_de' => 'наушниками', 'type_re' => 'наушников'),
            'repair-printers' => array('type' => 'принтер', 'type_rm' => 'принтеров', 'type_m' => 'принтеры', 'type_de' => 'принтером', 'type_re' => 'принтера'),
            'repair-laptops' => array('type' => 'ноутбук', 'type_rm' => 'ноутбуков', 'type_m' => 'ноутбуки', 'type_de' => 'ноутбуком', 'type_re' => 'ноутбука'),
            'repair-video-cameras' =>   array('type' => 'видеокамера', 'type_rm' => 'видеокамер', 'type_m' => 'видеокамеры', 'type_de' => 'видеокамерой', 'type_re' => 'видеокамеры'),
            'repair-computers' =>   array('type' => 'компьютер', 'type_rm' => 'компьютеров', 'type_m' => 'компьютеры', 'type_de' => 'компьютером', 'type_re' => 'компьютера'),
            'repair-fridges' => array('type' => 'холодильник', 'type_rm' => 'холодильников', 'type_m' => 'холодильники', 'type_de' => 'холодильником', 'type_re' => 'холодильника'),
            'repair-dishwashers' => array('type' => 'посудомоечная машина', 'type_rm' => 'посудомоечных машин', 'type_m' => 'посудомоечные машины', 'type_de' => 'посудомоечной машиной', 'type_re' => 'посудомоечной машины'),
            'repair-washing-machines' => array('type' => 'стиральная машина', 'type_rm' => 'стиральных машин', 'type_m' => 'стиральные машины', 'type_de' => 'стиральной машиной', 'type_re' => 'стиральной машины'),
            'repair-coffee-machines'  => array('type' => 'кофемашина', 'type_rm' => 'кофемашин', 'type_m' => 'кофемашины', 'type_de' => 'кофемашиной', 'type_re' => 'кофемашина'),
            'repair-plotters'  => array('type' => 'плоттер', 'type_rm' => 'плоттеров', 'type_m' => 'плоттеры', 'type_de' => 'плоттеру', 'type_re' => 'плоттера'),
            'repair-plotter'  => array('type' => 'плоттер', 'type_rm' => 'плоттеров', 'type_m' => 'плоттеры', 'type_de' => 'плоттеру', 'type_re' => 'плоттера'),
            'repair-bill-sorters'  => array('type' => 'сортировщик купюр', 'type_rm' => 'сортировщиков купюр', 'type_m' => 'сортировщики купюр', 'type_de' => 'сортировщику купюр', 'type_re' => 'сортировщика купюр'),
            'repair-monowheels'  => array('type' => 'моноколесо', 'type_rm' => 'моноколёс', 'type_m' => 'моноколеса', 'type_de' => 'моноколёсам', 'type_re' => 'моноколёс'),
            'repair-segways'  => array('type' => 'сегвей', 'type_rm' => 'сегвеев', 'type_m' => 'сегвеи', 'type_de' => 'сегвеям', 'type_re' => 'сегвеев'),
            'repair-water-heaters'  => array('type' => 'водонагреватель', 'type_rm' => 'водонагревателей', 'type_m' => 'водонагреватели', 'type_de' => 'водонагревателю', 'type_re' => 'водонагревателя'),
            'repair-microwave-ovens'  => array('type' => 'микроволновая печь', 'type_rm' => 'микроволновых печей', 'type_m' => 'микроволновые печи', 'type_de' => 'микроволновой печи', 'type_re' => 'микроволновой печи'),
            'repair-vacuum-cleaners'  => array('type' => 'пылесос', 'type_rm' => 'пылесосов', 'type_m' => 'пылесосы', 'type_de' => 'пылесосу', 'type_re' => 'пылесоса'),
            'repair-robot-vacuum-cleaners'  => array('type' => 'робот-пылесос', 'type_rm' => 'робот-пылесосов', 'type_m' => 'робот-пылесосы', 'type_de' => 'робот-пылесосу', 'type_re' => 'робот-пылесоса'),
            'repair-dryer-machines' => array('type' => 'сушильная машина', 'type_rm' => 'сушильных машин', 'type_m' => 'сушильные машины', 'type_de' => 'сушильной машине', 'type_re' => 'сушильной машины'),
            'repair-laser-printers' => array('type' => 'лазерный принтер', 'type_rm' => 'лазерных принтеров', 'type_m' => 'лазерные принтеры', 'type_de' => 'лазерным принтером', 'type_re' => 'лазерного принтера'),

		);

            
        if (isset($urls[$marka_lower]) && $this->_datas['hab'] === false)
        {
            $t = array();
            foreach ($urls[$marka_lower] as $url)
                $t[] = $add_device_type[$url];
                
            $this->_datas['all_devices'] = array_merge($this->_datas['all_devices'], $t);
        }
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
                $this->_datas['zoom'] = 12;
            }
        }
        return;
        
        $this->_datas['sdek'] = false;
        if ($this->_datas['partner']['email'] == 'litovchenko@list.ru')
        {
            $this->_datas['phone'] = '78003013299';
            $this->_datas['partner']['exclude'] = 1;  
            $this->_datas['partner']['time']  = 'с 10:00 до 20:00 (без выходных)';
            $this->_datas['sdek'] = true; 
        } 
    }
}

?>
