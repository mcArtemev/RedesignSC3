<?

namespace framework\ajax\action\hooks;

use framework\pdo;
use framework\tools;
use framework\ajax\action\idoAction;  

class output_ga implements idoAction 
{
    public function doAction()
    {
        $sql = "SELECT COUNT(*) FROM `ads_ga`";
        $ads = (integer) pdo::getPdo()->query($sql)->fetchColumn();
        
        if (!$ads) return 'Нет объявлений.';   
        
        $contexts = 1;
        $step = 20000;  
        
        // имя сайта единое
        $sql = "SELECT `site_name` FROM `ads_yd` ORDER BY `id` ASC LIMIT 0,1";
        $site_name = pdo::getPdo()->query($sql)->fetchColumn();
        
        // сетка
        $sql = "SELECT `setkas`.`name` as `setka_name`, `sites`.`servicename` as `servicename`, 
            `sites`.``phone` as `phone`, `sites`.`phone_ga` as `phone_ga` FROM `sites` 
            INNER JOIN `setkas` ON `sites`.`setka_id` = `setkas`.`id` WHERE `sites`.`name`=:name";                
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array('name' => $site_name));         
        $data = current($stm->fetchAll(\PDO::FETCH_ASSOC));
        $phone = ($data['phone_ga']) ? $data['phone_ga'] : $data['phone'];
        $setka_name = $data['setka_name'];
        $service_name = $data['servicename'];
        
        // уточнение единое для сетки            
        $desc = array();
    
        if ($setka_name == 'СЦ-1')
        {
            $desc[] = 'Скидка 10%';
            $desc[] = 'Доставка по Москве';
            $desc[] = 'Диагностика 15 мин';
            $desc[] = 'Срочный ремонт';
        }
        
        if ($setka_name == 'СЦ-2')
        {
            $desc[] = 'Диагностика 0р.';
            $desc[] = 'Экспресс ремонт';
            $desc[] = 'Гарантия';
            $desc[] = 'Выезд курьера';
        }
        
        $desc = implode('||', $desc);
        
        $ar = explode(" ", $service_name);
        $campaign_str = mb_strtolower($ar[1].' '.$ar[0]); 
        $marka_name = $ar[0]; 
        
        // быстрые ссылки единые для сетки        
        if ($setka_name == 'СЦ-1') 
        {
            $links[] = array('Выезд курьера по Москве', 'dostavka');
            $links[] = array('Сервисный центр '.$marka_name, '');
            $links[] = array('Ремонт от 30 минут', 'sroki');
            $links[] = array('Фирменные комплектующие', 'zapchasti');
            
            $desc_link_1 = array();
            
            $desc_link_1[] = 'Доставка техники в сервисный центр';
            $desc_link_1[] = 'Сервис по ремонту техники '.$marka_name;
            $desc_link_1[] = 'Срочный ремонт техники без наценки';
            $desc_link_1[] = 'Оригинальные запчасти '.$marka_name;
            
            $desc_link_2 = array();
            
            $desc_link_2[] = 'Вызов курьера на дом или в офис';
            $desc_link_2[] = 'Обслуживание всей линейки устройств';
            $desc_link_2[] = 'Оперативное обслуживание клиентов';
            $desc_link_2[] = 'Более 10000 наименований в наличии';
        }
        
        if ($setka_name == 'СЦ-2') 
        {
            $links[] = array($service_name.' в Москве', '');
            $links[] = array('Срочный ремонт '.$marka_name, 'services');
            $links[] = array('Задайте вопрос эксперту', 'ask');
            $links[] = array('Ремонт с 10% скидкой', 'order');
            
            $desc_link_1 = array();
            
            $desc_link_1[] = 'Ремонт устройств '.$marka_name.' в Москве';
            $desc_link_1[] = 'Оперативный ремонт в 90% случаев';
            $desc_link_1[] = 'Консультации специалистов';
            $desc_link_1[] = 'Скидка при онлайн обращении';
            
            $desc_link_2 = array();
            
            $desc_link_2[] = 'Услуги сервисного центра';
            $desc_link_2[] = 'Устранение неисправности от 30 мин';
            $desc_link_2[] = 'Онлайн форма по вопросам ремонта';
            $desc_link_2[] = 'Запись на ремонт';
        }
        
        $check_google = false;        
        $ru_markas = array('Sony', 'Dell', 'Lenovo');
                 
        if ((in_array($marka_name, $ru_markas) && $setka_name == 'СЦ-1') || ($setka_name == 'СЦ-2'))
        {
            $check_google = true;   
        }
        
        // по файлам
        for ($page = 1; $page <= ceil($ads / 2000); $page++)
        {
            $limit_start = ( $page-1 ) * 2000;
            $sql = "SELECT * FROM `ads_ga` ORDER BY `id` ASC LIMIT {$limit_start},2000";
            $ad = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
              
            $file = '/var/www/www-root/data/www/studiof1-test.ru/contexts/'.$site_name.'-'.$page.'.csv';      
            $str = array();
            
            // кампании не начинаются с середины файла
            $campaign = $campaign_str.' 16 '.ceil($contexts / $step); 
            
            // новый файл, новая шапка 
            $str[] = array('Campaign', 'Labels', 'Campaign Daily Budget',
                    	'Campaign Type', 'Networks', 'Languages', 'Bid Strategy Type', 'Bid Strategy Name',
                    	'Enhanced CPC',	'CPA Bid',	'Desktop Bid Modifier',	'Mobile Bid Modifier',	'Tablet Bid Modifier',	
                        'Start Date', 'End Date',	
                            'Ad Schedule', 
                                'Ad rotation', 'Delivery method', 'Targeting method', 'Exclusion method', 
                                'Ad Group', 'Max CPC', 'Max CPM', 'Max CPV', 'Max CPC Multiplier', 'Max CPM Multiplier', 'Top Content Bid Modifier',
                                    'Display Network Custom Bid Type', 'Targeting optimization', 'Ad Group Type', 'Flexible Reach', 
                                    'Tracking template', 'Custom parameters', 'ID', 'Location',
                                            	'Reach', 'Bid Modifier', 'Keyword', 
                                                 'Criterion Type', 'First page bid', 'Top of page bid',
                                                    'Quality score', 'Destination URL', 'Final URL',
                                                    'Final mobile URL', 'Device Preference', 'Link Text', 
                                                        'Description Line 1', 'Description Line 2', 'Feed Name',  'Platform Targeting', 'Phone Number',
                                                        'Country of Phone',
                                                    	'Call Reporting', 'Conversion Action', 'Callout text',
                                                         'Headline 1', 'Headline 2',
                                                         'Description', 'Path 1', 'Path 2', 
                                                         'Header', 'Snippet Values',
                                                         'Campaign Status', 'Ad Group Status', 'Status', 'Approval Status', 'Comment'); 
                                                         
            // по кампаниям
            if (($contexts % $step) == 1)
            {
                $str[] = array($campaign, '', '3000.00', 
                        'Search Network only', 'Google search', 'ru', 'Manual CPC', '',
                        'Disabled',  '0.00', '', '12', '', 
                            date('d.m.Y'), '[]', 
                            '(Monday@100%[10:00-19:00]);(Tuesday@100%[10:00-19:00]);(Wednesday@100%[10:00-19:00]);(Thursday@100%[10:00-19:00]);(Friday[10:00-19:00]);(Saturday@100%[10:00-19:00]);(Sunday@100%[10:00-19:00])',
                                'Optimize for clicks', 'Standard', 'Location of presence or Area of interest', 'Location of presence or Area of interest');
            }           
            
          
            foreach ($ad as $a)
            {
               // 1 объявление - 1 группа
               $n = $contexts % $step;
               if ($n == 0) $n = $step; 
               $group = 'Группа '.$n;
                
               $header = $a['header']; 
               $header2 = $a['header2'];
               $text = = $a['text'];
               $keywords = explode(";", $a['$keywords']);
               $url = $a['url'];
               $cpc = $a['cpc'];           
               //$path1, 
               //$path2
               
               if ($check_google)
               {
                    $header = str_replace($marka_name, $header); 
                    $header2 = $a['header2'];
                    $text = = $a['text'];
               }

               // группа объявлений
               $str[] = array($campaign, '', '',
                        '', '', '', '', '',
                            '',  '0.00', '', '', '', 
                                '', '', 
                                '',
                                    '', '', '', '',
                                        $group, $cpc, '0.01', '', '', '', '',
                                            'None', 'Disabled', 'Default', '[]'); 
                                            
                // ключевые слова
                foreach ($keywords as $keyword)        
                {
                    $str[] = array($campaign, '', '',
                        '', '', '', '', '',
                            '',  '', '', '', '', 
                                '', '', 
                                '',
                                    '', '', '', '',
                                        $group, '', '', '', '', '', '',
                                            '', '', '', '',
                                            '', '', '', '',
                                            '', '', $keyword, 
                                            'Broad');
                }
                
                // заголовок объявления
                $str[] = array($campaign, '', '',
                    '', '', '', '', '',
                        '',  '', '', '', '', 
                            '', '', 
                            '',
                                '', '', '', '',
                                    $group, '', '', '', '', '', '',
                                        '', '', '', '',
                                        '', '', '', '',
                                        '', '', '', 
                                        '', '', '',
                                        '', '', $url,
                                        '', '', '',
                                        '', '', '', '', '',
                                        '', 
                                        '', '', '',
                                        $header, $header2,
                                        $text, $path1, $path2); 
                
                $contexts++;                
            }
            
            // конец компании
            if (($contexts % $step) == 0 || $contexts == $ads)
            {
                $str[] = array($campaign, '', '',
                        '', '', '', '', '',
                            '',  '', '', '', '', 
                                '', '', 
                                '',
                                    '', '', '', '',
                                        '', '', '', '', '', '', '',
                                            '', '', '', '',
                                            '', '', '', '(25km:55.755826:37.617300)',
                                            '', '15');
                                            
                $str[] = array($campaign, '', '',
                '', '', '', '', '',
                    '',  '', '', '', '', 
                        '', '', 
                        '',
                            '', '', '', '',
                                '', '', '', '', '', '', '',
                                    '', '', '', '',
                                    '', '', '', '"Москва, город Москва, Россия"',
                                    '7740000', '');
                                    
                $str[] = array($campaign, '', '',
                '', '', '', '', '',
                    '',  '', '', '', '', 
                        '', '', 
                        '',
                            '', '', '', '',
                                '', '', '', '', '', '', '',
                                    '', '', '', '',
                                    '', '', '', '(3km:55.793328:37.591223)',
                                    '', '15');
                
                
                $exclude_keywords = array(
                    'tv','reader','corby','Омск','видео','кассета',
                    'видеокамера', 'мониторов', 'машины', 'свой', 'Таганрог', 'Волгоград',
                    'Сыктывкар', 'Норильск', 'Пермь', 'Рубцовск', 'Новороссийск','Ковров',
                    'Майкоп', 'Балашиха','Тагил', 'Киров', 'Магнитогорск', 'Арзамас',
                    'Уфа', 'Химки', 'двд','духовка', 'гродно', 'Вологда', 'Петропавловск',
                    'отзыв', 'шкафов','форд','код','мфу', 'Артём','Великий','мануал',
                    'Подольск','предохранитель','рей','Уральский','Ногинск','Первоуральск',
                    'кинокамера','Посад','Златоуст','геймпад','слободка','саундбаров',
                    'ford','shot','syncmaster','Воронеж','что','Петербург','Киев',
                    'Самара','Томск','Екатеринбург','Иркутск','Минск','проектор',
                    'музыкальный','Рязань','Абакан','Брянск','Салават','Сочи',
                    'Новгород','Ижевск','Тюмень','Чита','Тверь','Смоленск',
                    'Балаково','Домодедово','Нефтеюганск','Иваново','Кострома',
                    'гарнитура','Нижнекамск','официальный','газовый','пульт',
                    'чем','Димитровград','радиоприемник','магнитола','печка',
                    'делать','Мытищи','Сызрань','печей','видеодвойка','объективов',
                    'стиральных','Камышин', 'Невинномысск','Альметьевск','Каменск',
                    'Батайск','калуге','фототехник','белгороде','led','монитор',
                    'slt','Ангарск','Волгодонск','Чебоксары','Ульяновск','Саратов',
                    'Хабаровск','Нижневартовск','Находка','Ставрополь','Муром',
                    'Питер','чайник','фотокамера','кондиционер','сканер',
                    'автомагнитола','беларусь','проигрыватель','плеер','варочная',
                    'холодильников','Ачинск','Владикавказ','Ярославль','бритва',
                    'микроволновка','фотоаппаратов','книжка','рекордер','подольске',
                    'ксерокс','бытовой','гарантии','пылесосов','телевизора','Челны',
                    'Миасс','Новокуйбышевск','Обнинск','Орёл','варочный','зеленограде','Сергиев',
                    'подскажите','тамбове','Мурманск','Санкт','пылесос','книга','купить',
                    'кинотеатр','Якутск','Архангельск','Северск','Сургут','Пятигорск',
                    'Благовещенск','Нефтекамск','Пенза','Липецк','Владивосток','Нальчик',
                    'Люберцы','Севастополь','фотоаппарат','наушники','видеомагнитофон',
                    'камера','объектив','стиральная','печь','Керчь','Ростов','Саранск',
                    'плееров','прошивка','ридер','руками','Пушкино','фотоаппарата','свч',
                    'Железнодорожный','Йошкар','пылесоса','дивиди','пульта','Комсомольск',
                    'объектива','стиральной','скай','Одинцово','Ессентуки','Ноябрьск',
                    'Раменское','Новомосковск','Оскол','Ола','Прокопьевск','Улан',
                    'Армавир','ингушетия','отпариватель','кнопочный','видеоплеера',
                    'Каспийск','Елец','Зуево','форум','Оренбург','Челябинск',
                    'Кемерово','Барнаул','документы','Белгород','Владимир',
                    'Волжский','Элиста','Уссурийск','Братск','Астрахань',
                    'Череповец','Курск','Краснодар','Тула','Шахты','холодильник',
                    'шкаф','телевизор','спб','Грозный','Махачкала','Орск',
                    'Рыбинск','список','гарантия','атс','копир','Кисловодск',
                    'плеера','почему','гарантийные','гарантийный','Коломна','Королёв',
                    'орг','Жуковский','рука','стеклокерамический','Березники','Назрань',
                    'Красногорск','керамический','Хасавюрт','волгограде','Камчатский',
                    'Сахалинск','духовых','Копейск','воронеже','гарантировать','пультов',
                    'ремонтфото','dsc','hdr','ccd','фото','как','Новокузнецк','Новосибирск',
                    'smartwatch','Тольятти','Красноярск','Бийск','Бердск','Псков','Новочеркасск',
                    'Курган','Северодвинск','Калининград','Дзержинск','Стерлитамак','Казань',
                    'Черкесск','Петрозаводск','принтер','авторизованный','инструмент','стиралка',
                    'плита','Калуга','Симферополь','Тамбов','тв','шкафа','Евпатория','королев',
                    'принтеров','микроволновых','своими','Уренгой','Электросталь','телевизоров',
                    'твери','Кызыл','Энгельс','Серпухов','Новошахтинск','Удэ','зеленоград',
                    'Дербент','Новочебоксарск','Щёлково','пылесов',
             );
         
             foreach ($exclude_keywords as $exclude_keyword)
             {
                 $str[] = array($campaign, '', '',
                    '', '', '', '', '',
                        '',  '', '', '', '', 
                            '', '', 
                            '',
                                '', '', '', '',
                                    '', '', '', '', '', '', '',
                                        '', '', '', '',
                                        '', '', '', '',
                                        '', '', $exclude_keyword, 
                                        'Campaign Negative Broad');
              }
                
                
              foreach ($link_h as $link_h_key => $link_h_value)
              {
                    $str[] = array($campaign, '', '',
                    '', '', '', '', '',
                        '',  '', '', '', '', 
                            '[]', '[]', 
                            '[]',
                                '', '', '', '',
                                    '', '', '', '', '', '', '',
                                        '', '', '', '',
                                        '', '', '', '',
                                        '', '', '', 
                                        '', '', '',
                                        '', '', $link_u[$link_h_key], 
                                        '', 'All', $link_h_value,
                                        $desc_link_1[$link_h_key], $desc_link_2[$link_h_key], 'AdWords Express Sitelinks feed', 'All');
               }
                                        
               $str[] = array($campaign, '', '',
                    '', '', '', '', '',
                        '',  '', '', '', '', 
                            '[]', '[]', 
                            '[]',
                                '', '', '', '',
                                    '', '', '', '', '', '', '',
                                        '', '', '', '',
                                        '', '', '', '',
                                        '', '', '', 
                                        '', '', '',
                                        '', '', '', 
                                        '', 'All', '',
                                        '', '', 'Главный фид номеров телефонов', 'All', tools::format_phone($phone),
                                        'RU',
                                        'Disabled', 'Не учитывать звонки');    
                                        
                 foreach ($desc as $desc_value)
                 {
                     $str[] = array($campaign, '', '',
                        '', '', '', '', '',
                            '',  '', '', '', '', 
                                '[]', '[]', 
                                '[]',
                                    '', '', '', '',
                                        '', '', '', '', '', '', '',
                                            '', '', '', '',
                                            '', '', '', '',
                                            '', '', '', 
                                            '', '', '',
                                            '', '', '', 
                                            '', 'All', '',
                                            '', '', 'Главный фид уточнений', 'All', '',
                                            '',
                                            '', '', $desc_value);
                  }       
                        
            }
            
            $temp_str = '';
            foreach ($str as $row)
                $temp_str .= implode("\t", $row).PHP_EOL;
                
            $temp_str = pack("S",0xfeff) . tools::chbo(iconv("UTF-8", "UTF-16LE", $temp_str));    
            
            file_put_contents($file, $temp_str);  
        }
        
        return 'Вывод заверешен.';
    }
}

?>