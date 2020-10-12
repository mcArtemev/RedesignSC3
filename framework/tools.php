<?

namespace framework;

class tools
{
    private static $_table_mas = array();

    private static $_custom_vals = array();
    private static $_custom_vals_lazy = array();
    
    private static $_base_vals = array();
    
    private static $_urls = array();
    private static $_skl = array();
    
    public static function mb_ucfirst($str, $enc = 'utf-8', $to_lower = true) 
    { 
        if ($to_lower) $str = mb_strtolower($str, $enc);
        return mb_strtoupper(mb_substr($str, 0, 1, $enc), $enc).mb_substr($str, 1, mb_strlen($str, $enc), $enc); 
    }
    
    public static function mb_firstlower($str, $enc = 'utf-8') 
    { 
        $exclude = array('HDMI', 'Windows', 'Виндовс', 'HDD', 'USB', 'ЮСБ', 'WIFI', 'WiFi', 'Wi-Fi', 'Wifi', 'Wi fi',
                'SDD', 'ПО', 'ОС', 'ОЗУ', 'BIOS', 'БИОС', 'Биос', 'АКБ', 'ЗУ', 'GPS');
                
        $pass = true;
        foreach ($exclude as $value)
        {
            if (mb_strpos($str, $value) === 0)
            { 
                $pass = false;
                break;
            }
        }
        
        if ($pass)
            return mb_strtolower(mb_substr($str, 0, 1, $enc), $enc).mb_substr($str, 1, mb_strlen($str, $enc), $enc);
        else
            return $str; 
    }
	
	public static function gen_text($S1, $S2, $text) {							
		$text = preg_replace_callback('~{([^{}]+)}~', function($g) {
			$f = explode('|', trim($g[1]));
			$f = $f[(rand(0,count($f) - 1))];
			return $f;
		}, $text);

		return str_replace($S1, $S2, $text);
	}
	
	public static function str_replace_once($search, $replace, $text){ 
		   $pos = strpos($text, $search); 
		   return $pos!==false ? substr_replace($text, $replace, $pos, strlen($search)) : $text; 
		}

	public static function trim_mid($temp) {
		return preg_replace("/\s{2,}/"," ",$temp);
	}
	
	public static function new_gen_text($text, $S1 = NULL, $S2 = NULL) { // 2019-04-09	
		if (!empty($S1) && !empty($S2)) {
			$text = str_replace($S1, $S2, $text);
		}

		$m = NULL;
		preg_match_all('#\~\(([^\(\)]+)\)#is', $text, $m);
		if (!empty($m[1])) {
			$scroll = $m[1];
			foreach($scroll as $numname) {
				preg_match_all('#\~([^~~]+)\~\('.$numname.'\)#is', $text, $array);
				if (!empty($array[0])) {
					foreach($array[0] as $key => $val) {
						if (rand(1,2) == 1) {
							$text = str_replace($val, '', $text);
						} else {
							$text = str_replace($val, $array[1][$key], $text);
						}
					}
				}
			}
		}

		while(true) {
			preg_match_all('#~(.+?)~#is', $text, $array);
			if (!empty($array[0])) {
				foreach($array[0] as $key => $val) {
					if (rand(1,2) == 1) {
						$text = str_replace($val, '', $text);
					} else {
						$text = str_replace($val, $array[1][$key], $text);
					}
				}
			} else {
				break;
			}
		}

		$m = NULL;
		preg_match_all('#\^\(([^\(\)]+)\)#is', $text, $m);
		if (!empty($m[1])) {
			$scroll = $m[1];
			foreach($scroll as $numname) {
				preg_match_all('#\^([^\^\^]+)\^\('.$numname.'\)#is', $text, $array);
				if (!empty($array[0])) {
					if (count($array[0]) > 1) {
						shuffle($array[1]);
						foreach($array[0] as $key => $val) {
							$text = tools::str_replace_once($val, $array[1][$key], $text);
						}
					} else {
						$text = tools::str_replace_once($array[0][0], $array[1][0], $text);
					}
				}
			}
		}
		
		$m = NULL;
		preg_match_all('#\*\(([^\(\)]+)\)#is', $text, $m);
		if (!empty($m[1])) {
			$scroll = $m[1];		
			foreach($scroll as $numname) {
				preg_match_all('#\*([^**]+)\*\('.$numname.'\)#is', $text, $array);
				if (!empty($array[0])) {
					if (count($array[0]) > 1) {
						$repnum = rand(0, (count($array[1])-1));
						foreach($array[1] as $key => $val) {
							if ($repnum != $key) {
								$array[1][$key] = "";
							}
						}
						foreach($array[0] as $key => $val) {
							$text = tools::str_replace_once($val, $array[1][$key], $text);
						}
					} else {
						$text = tools::str_replace_once($array[0][0], $array[1][0], $text);
					}
				}
			}
		}

		do {
			$text = preg_replace_callback('~{([^{}]+)}~', function($g) {
				$f = explode('|', trim($g[1]));
				$f = $f[(rand(0,count($f) - 1))];
				return $f;
			}, $text);
		} while (preg_match('~{([^{}]+)}~', $text, $out) > 0);

		$text = trim(tools::trim_mid($text));
		$text = tools::mb_firstupper($text);

		$text = preg_split('//u', $text, -1, PREG_SPLIT_NO_EMPTY);

		$step = false;
		foreach ($text as $key => $val) {
			if (in_array($val, ['!', '.', '?']) === true) {
				$step = true;
				continue;
			}

			if ($step === true) {
				if (preg_match("/^[a-zа-яA-ZА-ЯёЁ]/u", $val) === 1) {
					$text[$key] = tools::mb_firstupper($val);
					$step = false;
				}
			}
		}
		
		$text = implode($text);
		
		
		$arr1 = [
			' .',
			' ,',
			' !',
			' ?',
			' :',
			' ;',
		];
		
		$arr2 = [
			'.',
			',',
			'!',
			'?',
			':',
			';',
		];

		$text = str_replace($arr1, $arr2, $text);

		return $text;
	}
	
	public static function unique_multidim_array($array, $key) { 
		$temp_array = array(); 
		$i = 0; 
		$key_array = array(); 
		
		foreach($array as $val) { 
			if (!in_array($val[$key], $key_array)) { 
				$key_array[$i] = $val[$key]; 
				$temp_array[$i] = $val; 
			} 
			$i++; 
		} 
		return $temp_array; 
	} 
	
    public static function mb_firstupper($str, $enc = 'utf-8') 
    { 
        return mb_strtoupper(mb_substr($str, 0, 1, $enc), $enc).mb_substr($str, 1, mb_strlen($str, $enc), $enc); 
    }
    
    public static function translit($str, $sign = '-')
    {
         $str = str_replace('+', '-plus', $str); //fix+
         return mb_strtolower(str_replace(array(' ', '.'), $sign, $str));
    }
    
    public static function get_suffics($typeName)
    {
        $accord_suffics = array('ноутбук' => 'n', 'планшет' => 'p', 'смартфон' => 'f', 
            'компьютер' => 'k', 'принтер' => 'r', 'монитор' => 'o', 'сервер' => 's', 'проектор' => 'e', 'игровая приставка' => 'i',
            'холодильник' => 'h', 'фотоаппарат' => 'a', 'видеокамера' => 'v', 'телевизор' => 't', 'моноблок' => 'm',
                'стиральная машина' => 'w');
        return (isset($accord_suffics[$typeName]) ? $accord_suffics[$typeName] : false);
    }
    
    public static function get_setka_code($setkaName)
    {
        $accord = array('СЦ-1' => 'sc1', 'СЦ-2' => 'sc2', 'СЦ-3' => 'sc3', 'СЦ-4' => 'sc4', 'СЦ-5' => 'sc5', 'СЦ-6' => 'sc6', 'СЦ-7' => 'sc7',
                'СЦ-8' => 'sc8', 'СЦ-10' => 'sc10');
        return (isset($accord[$setkaName]) ? $accord[$setkaName] : false);
    }
    
    public static function get_codes($suffics)
    {
        if (!isset(self::$_table_mas[$suffics]))
        {
            $table_mas = array();
            $tables = array('defect', 'service', 'complect');
            
            foreach ($tables as $value)
            {
                $select_table = $suffics.'_'.$value.'s';
                $select_key = $value;
                
                if (pdo::getPdo()->query("SHOW TABLES LIKE '{$select_table}'")->rowCount() > 0)
                {
                    $sql = "SELECT `name`, `name2`, `id` FROM `{$select_table}`";
                    $table_mas[$select_key] = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
                }
            }
            
            self::$_table_mas[$suffics] = $table_mas;
        }
        
        return self::$_table_mas[$suffics];
    }    
    
    public static function get_rand_dop()
    {
        srand();
        return rand();        
    }
    
    public static function get_rand($mas, $rand = 0)
    {
         if ($rand !== false)
         {         
            if (!$rand)
                srand();
            else
                srand($rand);
         }
            
         return $mas[rand(0, count($mas)-1)];    
    } 
    
    public static function declOfNum($number, $titles, $number_str = true, $to_lower = true)
    {
        $cases = array (2, 0, 1, 1, 1, 2);
        $str = '';
        if ($number_str) $str .= $number.' ';
        
        $ret = $titles[ ($number%100 > 4 && $number%100 < 20) ? 2 : $cases[min($number%10, 5)] ];
        
        if ($to_lower)
            $str .= mb_strtolower($ret);
        else
            $str .= $ret;
            
        return $str;            
    }
    
    public static function cut_phone($phone)
    {
        return str_replace(array(" ", ")", "(", "-", "+"), "", (string) $phone);
    }
    
    public static function format_phone($phone, $eight = false)
    {
        $phone = (string) $phone;
        if ($phone && mb_strlen($phone) == 11)
            if ($eight)
                return "8"." (".$phone[1].$phone[2].$phone[3].") ".$phone[4].$phone[5].$phone[6]."-".$phone[7].$phone[8]."-".$phone[9].$phone[10];
            else
                return $phone[0]." (".$phone[1].$phone[2].$phone[3].") ".$phone[4].$phone[5].$phone[6]."-".$phone[7].$phone[8]."-".$phone[9].$phone[10];
        else
            return $phone;
    }
    
    public static function word()
    {
        srand();
        return rand(0, 1);
    }
    
    public static function get_time()
    {
        return mktime(date("H"),date("i"),date("s"),date("n"),date("j"),date("Y")); //?
    }
    
    public static function get_custom($setka_name, $codes)
    {
        if (!isset(self::$_custom_vals[$setka_name]))
        {
            $sql = "SELECT `code`,`value` FROM `customs` INNER JOIN `setkas` ON `setkas`.`id` = `customs`.`setka_id` WHERE `setkas`.`name`=:setka_name";
            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array('setka_name' => $setka_name));
            self::$_custom_vals[$setka_name] = $stm->fetchAll(\PDO::FETCH_KEY_PAIR);
        }
        
        $custom_vals = self::$_custom_vals[$setka_name];
        
        if ($codes)
        {
            $codes = (array) $codes; 
            $key = serialize($codes);
            $ret = array();
            
            if (!isset(self::$_custom_vals_lazy[$key])) 
            {
                foreach ($codes as $code)
                {
                    if (isset($custom_vals[$code])) $ret[$code] = $custom_vals[$code];
                }
                
                self::$_custom_vals_lazy[$key] = $ret;
            } 
            
            return self::$_custom_vals_lazy[$key];
        }
    }
    
    public static function get_base($suffics, $name) 
    {
        if ($suffics) 
            $key = $suffics.'_'.$name;
        else
            $key = $name;
            
         if (mb_substr($key, -1) !== 's') $key .= 's';
        
        if (!isset(self::$_base_vals[$key]))
        {
            $table = $key;           
             
            $sql = "SELECT * FROM `{$table}`";
            $db = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC); 
             
            $base_vals = array();
            
            foreach ($db as $field)
                $base_vals[$field['id']] = $field;
                
            self::$_base_vals[$key] = $base_vals;
        }
        
        return self::$_base_vals[$key];         
    }
    
    public static function create_other($suffics, $table, $ret_key, $setka_name)
    {
        //base
        $base_vals = tools::get_base($suffics, $table);
        unset($base_vals[$ret_key]);        
        
        $array = array();
        foreach ($base_vals as $key => $value)
            $array[] = array('id' => $key);
         
        //customs
        $min_name = 'min_'.$table;
        $max_name = 'max_'.$table;       
        $codes = array($min_name, $max_name);       
        $custom_vals = tools::get_custom($setka_name, $codes);
        
        if (isset($custom_vals[$min_name]) && isset($custom_vals[$max_name]))
        {
            srand();
        
            $rand_it = new rand_it();
            $rand_it->setArray($array);
            $rand_it->setCountVal(rand((integer) $custom_vals[$min_name], (integer) $custom_vals[$max_name]));
            $rand_it->setNameValue('id');
        
            return $rand_it->randIt();
        }
        else
            return array();
    }
    
    public static function search_url($site_id, $params)
    {
        $key = $site_id.'_'.$params;
        
        if (!isset(self::$_urls[$key]))
        {
            $sql = "SELECT `name` FROM `urls` WHERE `site_id`=:site_id AND `params`=:params";
            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array('site_id' => $site_id, 'params' => $params));
            self::$_urls[$key] = $stm->fetchColumn();   
        }
        
        return self::$_urls[$key];  
    }
    
    public static function format_time($time_min, $time_max, $format_number, $setka_name = '')
    {
        switch ($format_number)
        {
            case 1:
                $suff = 'часа';
                $time_min_format = (string) round($time_min/60, 2);
                $time_max_format = (string) round($time_max/60, 2);             
            break;
            default:
                if ($setka_name == 'СЦ-1' || $setka_name == 'СЦ-7')
                  $suff = '';
                else
                  $suff = 'мин';
                  
                $time_min_format = (string) $time_min;
                $time_max_format = (string) $time_max;            
        }
        
        if ($time_min != $time_max)
            return $time_min_format. '-' . $time_max_format. ' '. $suff;
        else
        {
            if ($time_min == 60 && $format_number == 1) $suff = 'час';
            return $time_min_format. ' '. $suff;
        }
    }
    
    public static function format_garantee($garantee, $format_number)
    {
        if (!$garantee) return '-';
        switch ($format_number)
        {
            case 1:
                $suff = array('неделя', 'недели', 'недель');
                $garantee_format = round($garantee/28);     
            break;
            case 2:
                $suff = array('месяц', 'месяца', 'месяцев');
                $garantee_format = round($garantee/30); 
            break;
            default:
                $suff = array('день', 'дня', 'дней'); 
                $garantee_format = $garantee;        
               
        }
        
        return tools::declOfNum($garantee_format, $suff);
    }
    
    public static function format_price($price, $setka_name)
    {
        switch ($setka_name)
        {
            case 'СЦ-1':
                return $price;
            break;
            case 'СЦ-2': case 'СЦ-2з':
                if ($price == 0) return 'Бесплатно';
                return number_format($price, 0, '.', ' ');
            break;
            case 'СЦ-3':
                return $price;
            break;
            case 'СЦ-5':
                return $price;
            break;
            case 'СЦ-8':
                return number_format($price, 0, '.', ',');
            break;
            default:
                return $price;
        }
    }
    
    public static function skl($table, $suffics, $name, $skl)
    {
        $key = $table.'_'.$suffics.'_'.$name.'_'.$skl;
        
        if (!isset(self::$_skl[$key]))
        {
            $table_name = $suffics.'_'.$table.'_syns';
       
            $sql = "SELECT `{$skl}` FROM `{$table_name}` WHERE `name`=:name";
            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array('name' => $name));
            $word = tools::mb_firstlower($stm->fetchColumn());
      
            if (!$word) 
            {
                switch ($table)
                {
                    case 'service':
                    
                        if ($skl == 'dat')
                        {
                            $word = str_replace(
                                array('замена','ремонт','настройка','установка','работа','восстановление','калибровка','юстировка','обновление','переустановка',
                                        'устранение', 'маскировка', 'скрытие', 'пайка', 'перепайка', 'чистка', 'очистка', 'прошивка','ребболинг','заправка'), 
                                array('замене','ремонту','настройке','установке','работе','восстановлению','калибровке','юстировке','обновлению','переустановке',
                                        'устранению', 'маскировке', 'скрытию', 'пайке', 'перепайке', 'чистке', 'очистке', 'прошивке','ребболингу','заправке'), 
                                    tools::mb_firstlower($name));
                        }
                        
                        if ($skl == 'tp')
                        {
                            $word = str_replace(
                                array('замена','ремонт','настройка','установка','работа','восстановление','калибровка','юстировка','обновление','переустановка',
                                        'устранение', 'маскировка', 'скрытие', 'пайка', 'перепайка', 'чистка', 'очистка', 'прошивка','ребболинг','заправка'), 
                                array('заменой','ремонтом','настройкой','установкой','работой','восстановлением','калибровкой','юстировкой','обновлением','переустановкой',
                                        'устранением', 'маскировкой', 'скрытием', 'пайкой', 'перепайкой', 'чисткой', 'очисткой', 'прошивкой','ребболингом','заправкой'), 
                                    tools::mb_firstlower($name));
                        }
                        
                        if ($skl == 'rp')
                        {
                            $word = str_replace(
                                array('замена','ремонт','настройка','установка','работа','восстановление','калибровка','юстировка','обновление','переустановка',
                                        'устранение', 'маскировка', 'скрытие', 'пайка', 'перепайка', 'чистка', 'очистка', 'прошивка','ребболинг','заправка'), 
                                array('замены','ремонта','настройки','установки','работы','восстановления','калибровки','юстировки','обновления','переустановки',
                                        'устранения', 'маскировки', 'скрытия', 'пайки', 'перепайки', 'чистки', 'очистки', 'прошивки','ребболинга','заправки'), 
                                    tools::mb_firstlower($name));
                        }
                    
                    break;
                    case 'complect':
                    
                        $word = tools::mb_firstlower($name);
                             
                    break;
                }
                
            }
            
            self::$_skl[$key] = $word;
        }       
        
        return self::$_skl[$key];
    }
    
     public static function cut_empty($str)
     {
        return trim(preg_replace("/(\s){2,}/",' ',$str));
     }
     
     public static function file_force_contents($dir, $contents)
     {
        $parts = explode('/', $dir);
        $file = array_pop($parts);
        $dir = '';
        foreach($parts as $part)
            if(!is_dir($dir .= "/$part")) mkdir($dir);
        file_put_contents("$dir/$file", $contents);
     }
     
     public static function commit($arr, $sign = 'и')
     {
        $last = array_pop($arr);
        return implode(', ', $arr).' '.$sign.' '.$last;
     }     
     
     public static function get_optimal_variant($variants, $min_arg)
     {
        $min = $min_arg - 1;
        $min_index = false;
                     
        for($i=0; $i<count($variants); $i++)
        {
           if (($t = ($min_arg - mb_strlen($variants[$i]))) >= 0 && $t < $min) 
           {
                $min = $t;
                $min_index = $i;
           } 
        }
        
        return $min_index;
    }
    
    public static function chbo($num) 
    {
        $data = dechex($num);
        
        if (strlen($data) <= 2) 
            return $num;
            
        $u = unpack("H*", strrev(pack("H*", $data)));
        $f = hexdec($u[1]);
        
        return $f;
    }
    
    public static function get_station($site_name, $feed = 0)
    {
        switch ($site_name)
        {
            case 'sony-russia.com':
                $ret =  array(
                        'Weller WQB4000 SOPS', 
                        array('XTX-series LBX', 'TORNADO Pro'), 
                        array('Lukey 936A', 'BAKU BK-702B'), 
                        array('RIGOL DS1202CA', 'Fluke 196B'),
                        );
            break;
            case 'asus-russia.ru':
                $ret = array(
                        'HR200-HP', 
                        array('LEVENHUK', 'NJF-120A'), 
                        array('Lukey', 'Accta 301'), 
                        array('Fluke', 'JDS3012A')
                        );
            break;
            case 'lenovo-russia.ru':
                $ret = array(
                        'HAKKO FX-952 ESD',  
                        array('ST60-24B2 с подсветкой', 'Eyepiece KE-208A'), 
                        array('Lukey 868', 'BAKU BK-601D'), 
                        array('Hantek DSO1200', 'RIGOL DS1102D'),
                        );
            break;
            case 'dell-russia.com':
                $ret = array(
                        'HT-R392 BGA', 
                        array('AOYUE 638', 'ZTX-E-W (10x; 1x/4x)'), 
                        array('QUICK 713 ESD', 'BAKU BK-878'), 
                        array('Hantek DSO1060', 'RIGOL DS1302CA'),
                        );
            break;
            case 'samsung.russia-service.com':
                $ret = array(
                        'SEAMARK ZM-R5860', 
                        array('NK-103C', 'Konus Campus 5306'), 
                        array('AOYUE 2703A++', 'ATTEN AT860D'), 
                        array('Tektronix TDS2002B', 'UNI-T UTD2052CL'),
                        );
            break;
            case 'hprussia.ru':
                $ret = array(
                        'ERSA IR550A PLUS', 
                        array('Olympus BX41 Laboratory', 'Nikon Eclipse ME600D'), 
                        array('ATTEN AT8502D', 'AOYUE 2702 с'), 
                        array('Tektronix TDS2004B', 'UNI-T UTD2102CEX'),
                        );
            break;
            case 'htcrussia.com':
                $ret = array(
                        'HAKKO 702B', 
                        array('Leica Microsystems MZ16 FA', 'Olympus IX50'), 
                        array('QUICK 856AX ESD', 'Goot XFC-300'), 
                        array('JDS3012A', 'RIGOL DS1102E'),
                        );
            break;
            case 'msi-russia.ru':
                $ret = array(
                        'QUICK 9234', 
                        array('Leica Microsystems DM5500B', 'Eclipse E600 - Nikon'), 
                        array('AOYUE 768', 'QUICK 856AX ESD'), 
                        array('UNI-T UTD2052CL', 'Tektronix TDS2004B'),
                        );
            break;
            case 'acer-russia.ru':
                $ret = array(
                        'Jovy Systems RE-8500', 
                        array('Karl Kaps KCBE 13', 'LEVENHUK'), 
                        array('BAKU BK-878', 'AOYUE 6031 Sirocco'), 
                        array('Hantek DSO1060', 'RIGOL DS1202CA'),
                        );
            break;
            case 'toshibarussia.ru':
                $ret = array(
                        'ATTEN AT8235', 
                        array('Nikon Eclipse ME600D', 'Konus Campus 5306'), 
                        array('Accta 301', 'ProsKit SS-989B'), 
                        array('Hantek DSO1200', 'Tektronix TDS2004B'),
                        );
            break;
            
            case 'nokia-russia.com':
                $ret = array(
                        'SEAMARK ZM-R5860', 
                        array('Eclipse E600 - Nikon', 'ST60-24B2 с подсветкой'), 
                        array('Goot XFC-300', 'ATTEN AT860D'), 
                        array('RIGOL DS1102D', 'JDS3012A'),
                        );
            break;
            case 'lg-russia.ru':
                $ret = array(
                       'HAKKO FX-952 ESD',
                        array('AOYUE 638', 'Olympus BX41 Laboratory'), 
                        array('BAKU BK-702B', 'AOYUE 2703A++'), 
                        array('Fluke 196B', 'UNI-T UTD2052CL'),
                        );
            break;
            
            case 'russia-apple.pro':
                $ret = array(
                        'QUICK 9234', 
                        array('Olympus IX50', 'NK-103C'), 
                        array('Goot XFC-300', 'AOYUE 2702 с'), 
                        array('Tektronix TDS2004B', 'Hantek DSO1060'),
                        );
            break;            
            case 'russia-meizu.com':
                $ret = array(
                        'HAKKO FX-952 ESD', 
                        array('Eyepiece KE-208A', 'Olympus BX41 Laboratory'), 
                        array('AOYUE 6031 Sirocco', 'AOYUE 2703A++'), 
                        array('RIGOL DS1302CA', 'UNI-T UTD2102CEX'),
                        );
            break;
            case 'russia-xiaomi.pro':
                $ret = array(
                       'ERSA IR550A PLUS',
                        array('Konus Campus 5306', 'Karl Kaps KCBE 13'), 
                        array('ProsKit SS-989B', 'QUICK 856AX ESD'), 
                        array('JDS3012A', 'RIGOL DS1302CA'),
                        );
            break;
            
            case 'russia-huawei.ru':
                $ret = array(
                       'SEAMARK ZM-R5860',
                        array('Eclipse E600 - Nikon', 'ZTX-E-W (10x; 1x/4x)'), 
                        array('Lukey 936A', 'BAKU BK-702B'), 
                        array('Tektronix TDS2002B', 'RIGOL DS1102D'),
                        );
            break;
            
            default:
                
                $v = array();
                $ret = array();
                $amount = array(1, 1, 1, 1);
                
                $v[] = array('Weller WQB4000 SOPS', 'HAKKO FX-952 ESD', 'HT-R392 BGA', 'SEAMARK ZM-R5860', 
                'ERSA IR550A PLUS', 'ERSA HR100AHP', 'ERSA PCBXY', 'HAKKO 702B','QUICK 9234',
                    'Jovy Systems RE-8500', 'Jovy Systems Jetronix-Eco', 'ATTEN AT8235', 'Jovy Systems Turbo IR');
                    
                $v[] = array('NJF-120A', 'XTX-series LBX', 'TORNADO Pro', 'ST60-24B2 с подсветкой', 'Eyepiece KE-208A',
                    'AOYUE 638', 'ZTX-E-W (10x; 1x/4x)', 'NK-103C', 'Konus Campus 5306', 'Olympus BX41 Laboratory',
                    'Nikon Eclipse ME600D', 'Leica Microsystems MZ16 FA', 'Leica Microsystems DM5500B', 'Olympus IX50',
                    'Eclipse E600 - Nikon', 'Karl Kaps KCBE 13');
                    
                $v[] = array(array('Lukey 936A', 'Lukey 868'), array('QUICK 713 ESD', 'QUICK 856AX ESD'), array('ProsKit SS-989B'), array('Goot XFC-300'),
                    array('BAKU BK-702B', 'BAKU BK-601D', 'BAKU BK-878'), array('Accta 301'), array('ATTEN AT860D','ATTEN AT8502D'),
                    array('AOYUE 2703A++', 'AOYUE 6031 Sirocco', 'AOYUE 2702 с', 'AOYUE 768'));
                
                $v[] = array('RIGOL DS1202CA', 'Fluke 196B', 'Hantek DSO1200', 'RIGOL DS1102D', 'Hantek DSO1060', 'RIGOL DS1302CA',
                        'Tektronix TDS2002B', 'Tektronix TDS2004B', 'UNI-T UTD2052CL', 'UNI-T UTD2102CEX', 'JDS3012A', 'RIGOL DS1102E');
                
                foreach ($v as $key => $value)
                {
                    $mas = rand_it::randMas($value, $amount[$key], '', $feed);
                    if ($key == 0 || $key == 2)
                        $ret[] = current($mas);
                    else
                        $ret[] = $mas; 
                }          
        }
        
        return $ret;
    }
    
    public static function get_type_amount($site_name, $suffics)
    {
        switch ($site_name)
        { 
            case 'toshiba-moscow.com':
                $ar = array('p' => 16, 'n' => 20, 'f' => 22);
            break;
            case 'sony-moscow.com':
                $ar = array('p' => 19, 'n' => 26, 'f' => 24);
            break;
            case 'samsung-moscow.com':
                $ar = array('p' => 18, 'n' => 24, 'f' => 26);
            break;
            case 'hp-moscow.com':
                $ar = array('p' => 17, 'n' => 21, 'f' => 23);
            break;
            case 'asus-moscow.com':
                $ar = array('p' => 18, 'n' => 23, 'f' => 24);
            break;
            case 'lenovo-moscow.com':
                $ar = array('p' => 17, 'n' => 24, 'f' => 23);
            break;
            case 'acer-moscow.com':
                $ar = array('p' => 18, 'n' => 25, 'f' => 23);
            break;
            case 'dell.moskva-servis.com':
                $ar = array('p' => 16, 'n' => 22, 'f' => 21);
            break;
            
            default:
                $ar = array('p' => 18, 'n' => 21, 'f' => 25);
        }
            
        return isset($ar[$suffics]) ? $ar[$suffics] : '';
    }
    
    public static function get_complect_amount($site_name)
    {
        switch ($site_name)
        { 
            case 'toshiba-moscow.com':
                $amount = 6;
            break;
            case 'sony-moscow.com':
                $amount = 9;
            break;
            case 'samsung-moscow.com':
                $amount = 8;
            break;
            case 'hp-moscow.com':
                $amount = 6;
            break;
            case 'asus-moscow.com':
                $amount = 7;
            break;
            case 'lenovo-moscow.com':
                $amount = 8;
            break;
            case 'acer-moscow.com':
                $amount = 6;
            break;
            case 'dell.moskva-servis.com':
                $amount = 8;
            break;
            
            default:
                $amount = 6;
        }
        
        return $amount;
    }
    
    public static function get_diagnostic_minuts($site_name)  
    {
        switch ($site_name)
        { 
            case 'toshiba-moscow.com':
                $amount = 15;
            break;
            case 'sony-moscow.com':
                $amount = 10;
            break;
            case 'samsung-moscow.com':
                $amount = 20;
            break;
            case 'hp-moscow.com':
                $amount = 25;
            break;
            case 'asus-moscow.com':
                $amount = 30;
            break;
            case 'lenovo-moscow.com':
                $amount = 10;
            break;
            case 'acer-moscow.com':
                $amount = 15;
            break;
            case 'dell.moskva-servis.com':
                $amount = 20;
            break;
            
            default:
                $amount = 15;
        }
        
        return $amount;
    }
    
    public static function sortByPriority($array)
    {
        $tempArr =[];
        if(!empty($array)){
            $types = ['смартфон', 'лэптоп', 'ноутбук', 'планшет',
                'моноблок', 'телевизор', 'проектор', 'компьютер', 'монитор',
                'сервер','телефон', 'принтер', 'плоттер', 'электронная книга',
                'фотоаппарат', 'видеокамера', 'игровая приставка',
                'смарт-часы', 'роутер', 'VR система', 'наушники',
                'гироскутер', 'электросамокат', 'моноколесо', 'сигвей',
                'квадрокоптер', 'холодильник', 'стиральная машина', 
                'посудомоечная машина', 'кофемашина'
            ];
            foreach ($types as $k => $type) {
                foreach ($array as $key => $arr) {
                    if(!empty($arr['type']) && $type == $arr['type']) {
                        $tempArr[$k] = $arr;
                        unset($array[$key]);
                    }elseif($type === $key){
                        $tempArr[$key] = $arr;
                        unset($array[$key]);
                    }
                }
            }
            $tempArr = array_merge($tempArr,$array);
        }
        return $tempArr;
    }
    
     public static function gen_feed($tmp_str)
     {
        $sum = 0;
        for ($i=0;$i<strlen($tmp_str);$i++)
            $sum += ord($tmp_str[$i]); 
        return $sum;
     } 
     
     public static function implode_or($t, $word = 'и')
     {
        if (!$t) return '';
        if (count($t) > 1)
        {
            $last = array_pop($t);
            return implode(', ', $t).' '.$word.' '.$last;
        }
        else
            return $t[0];
     }
     
     public static function connect_ciba($request)
     {
        $request_json = mb_convert_encoding(json_encode($request), 'UTF-8');
                    
        $ch = curl_init();
        curl_setopt_array($ch,
        	array(CURLOPT_URL => 'https://cibacrm.com/admin/index.php', CURLOPT_POST => 1,
        		CURLOPT_POSTFIELDS => $request_json, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => 0, 
                    CURLOPT_SSL_VERIFYHOST => 0, CURLOPT_RETURNTRANSFER => 1, CURLOPT_CONNECTTIMEOUT => 3,
                      CURLOPT_HTTPHEADER => array(
                                'Accept: application/json',
                                'Connection: close',
                                'Content-Type: application/json; charset=UTF-8',
                                'Content-Length: '.mb_strlen($request_json))));
                                            
        return curl_exec($ch);
    }
    
    public static function connect_gc($method, $container = true)
    {
        $url = 'https://gc.cibacrm.com/api?' . $method;        
        if ($container) $url .= '&container=MULTILAND_TC2BRABDS&api_key=xvQkhVZakx8FX4qTzVjugeWXjHOeuewUxwHcPHSFog1ZYOH4PKPwSn1sTz5LWaVh';
                
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Connection: close'
        ));
        
        $answer = curl_exec($ch); //var_dump($answer);
        curl_close($ch);
        $answer = json_decode($answer, true);
                
        return $answer;
    }
    
    public static function cmp_obj($a, $b)
    {
        if ($a['freq'] == $b['freq']) {
            return 0;
        }
        return ($a['freq'] > $b['freq']) ? -1 : 1;
    }    

    public static function price_ot($cena)
    {
        if($cena == "ноутбук")
        {
            return round(rand(250,350),-1);
        }
        else if($cena == "планшет")
        {

            return round(rand(450,550),-1);
        }
        else if($cena == "моноблок")
        {

            return round(rand(150,200),-1);
        }
        else if($cena == "компьютер")
        {

            return round(rand(250,350),-1);
        }
        else if($cena == "смартфон")
        {

            return round(rand(450,550),-1);
        }
        else if($cena == "фотоаппарат")
        {

            return round(rand(300,400),-1);
        }
        else if($cena == "видеокамера")
        {

            return round(rand(300,400),-1);
        }
        else if($cena == "телевизор")
        {

            return round(rand(300,400),-1);
        }
        else if($cena == "проектор")
        {

            return round(rand(600,700),-1);
        }
        else if($cena == "монитор")
        {

            return round(rand(500,600),-1);
        }
        else if($cena == "сервер")
        {

            return round(rand(700,800),-1);
        }
        else if($cena == "принтер")
        {

            return round(rand(500,600),-1);
        }
        else if($cena == "электронная книга")
        {

            return round(rand(500,600),-1);
        }
    }

}
    
?>