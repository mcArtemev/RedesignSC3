<?

namespace framework\ajax\action\hooks;

use framework\pdo;
use framework\tools;
use framework\ajax\action\idoAction;  

class output_yd implements idoAction  
{
    public function doAction()
    {
        $sql = "SELECT COUNT(*) FROM `ads_yd`";
        $ads = (integer) pdo::getPdo()->query($sql)->fetchColumn();
        
        if (!$ads) return 'Нет объявлений.';   
        
        $contexts = 1;
        $step = 100; 
        $campaign_count = 1000;
        $file_campaign = 1;
        
        // имя сайта единое
        $sql = "SELECT `site_name` FROM `ads_yd` ORDER BY `id` ASC LIMIT 0,1";
        $site_name = pdo::getPdo()->query($sql)->fetchColumn();
        
        // сетка
        $sql = "SELECT `setkas`.`name` as `setka_name`, `sites`.`servicename` as `servicename` FROM `sites` 
            INNER JOIN `setkas` ON `sites`.`setka_id` = `setkas`.`id` WHERE `sites`.`name`=:name";                
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array('name' => $site_name));         
        $data = current($stm->fetchAll(\PDO::FETCH_ASSOC));
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
        
        // по шагам
        for ($page = 0; $page < ceil($ads / $step); $page++)
        {
            $limit_start = $page * $step;
            $sql = "SELECT * FROM `ads_yd` ORDER BY `id` ASC LIMIT {$limit_start},{$step}";
            $ad = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
            
            $campaign_number = ceil($contexts / $campaign_count);
            $file_number =  ceil($contexts / ($campaign_count * $file_campaign)); 
            $new_file = (($contexts % ($campaign_count * $file_campaign)) == 1);
            
            $file = '/var/www/www-root/data/www/studiof1-test.ru/contexts/'.$site_name.'-'.$file_number.'.csv';      
            $str = array();
            
            $campaign = $campaign_str.' 16 '.$campaign_number;
            
            // новый файл, новая шапка
            if ($new_file)
            { 
                $str[] = array("Предложение текстовых блоков для рекламной кампании");
                $str[] = array();   
                $str[] = array("Доп. объявление группы", "Мобильное объявление",
                            "ID группы", "Название группы", "Номер группы", "Тип кампании", "ID кампании (локальный)",
                            "ID кампании (серверный)", "Название кампании", "ID фразы", "Фраза (с минус-словами)",
                            "ID объявления", "Заголовок", "Текст", "Ссылка", "Отображаемая ссылка", "Регион",
                            "Ставка", "Ставка в сетях", "Контакты", "Статус объявления", "Статус фразы",
                            "Заголовки быстрых ссылок", "Адреса быстрых ссылок", "Описания быстрых ссылок", 
                            "Параметр 1", "Параметр 2", "Метки", "Изображение", "Уточнения", "Минус-слова на группу", 
                            "Минус-слова на кампанию", "Возрастные ограничения", 
                            "Ссылка на приложение в магазине", "Тип устройства", "Тип связи",
                            "Версия ОС", "Трекинговая ссылка", "Иконка", "Рейтинг", "Количество оценок", "Цена");
            }
                        
            foreach ($ad as $a)
            {
                // 1 объявление - 1 группа
                $n = $contexts % $campaign_count;
                if ($n == 0) $n = $campaign_count; 
                $group = 'Группа '.$n; 
                
                $header = $a['header'];
                $text = $a['text'];
                $keywords = explode(";", $a['keywords']);
                               
                //$url = $a['url'];
                $url = 'http://'.$site_name.'/';
                $vis_link = $a['vis_link']; 
                $link_h = $a['link_h'];
                $link_u = $a['link_u'];       
                
                foreach ($keywords as $keyword)
                {  
                    $t_str = array('-', '-', '', $group, '', 'Текстово-графическая кампания', '', '',
                            $campaign, '', $keyword, '', $header, $text,
                                $url, $vis_link, 
                            'Москва, Балашиха, Видное, Долгопрудный, Домодедово, Жуковский, Истра, Королёв, Красногорск, Лобня, Лосино-Петровский, Люберцы, Мытищи, Одинцово, Пушкино, Реутов, Солнечногорск, Фрязино, Химки, Щелково',
                            '1,1', '', '', '', '', $link_h, $link_u, '', '', '', '', '', $desc); 
                                
                    foreach ($t_str as $key => $s)
                        if ($s && !is_numeric($s) && $key != 17) $t_str[$key] = "\"".$s."\"";
                        
                    $str[] = $t_str;
                }
                
                unset($keywords);
                    
                $contexts++;
            }            
                       
            unset($ad);
            
            $temp_str = '';
            foreach ($str as $row)
                $temp_str .= implode("\t", $row).PHP_EOL;
                
            unset($str);
                
            $temp_str =  tools::chbo(iconv("UTF-8", "UTF-16LE", $temp_str));  
            
            if ($new_file) $temp_str = pack("S",0xfeff) . $temp_str;
            
            file_put_contents($file, $temp_str, FILE_APPEND | LOCK_EX);                        
        }        
        
        return 'Вывод заверешен.';            
    }
}

?>