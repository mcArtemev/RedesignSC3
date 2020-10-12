<?
use framework\tools;
use framework\ajax\parse\parse;
use framework\pdo;
use framework\rand_it;

$marka = $this->_datas['marka']['name'];  // SONY
$servicename = $this->_datas['servicename']; //SONY Russia
$ru_servicename = $this->_datas['ru_servicename']; //
$ru_marka = $this->_datas['marka']['ru_name']; // СОНИ
$region_name = $this->_datas['region']['name'];//Москва
$region_name_pril = $this->_datas['region']['pril'];//Московского
$region_name_pe = $this->_datas['region']['name_pe'];//в Москве (в Владивостоке)
$region_name_de = $this->_datas['region']['name_de'];//по Москве (Владивостоку)
$region_name_re = $this->_datas['region']['name_re'];//служба Москвы (Владивостока)
$phone = $this->_datas['phone'];
$phone_format = tools::format_phone($phone);
$metrica = $this->_datas['metrica'];
$all_deall_devices = $this->_datas['all_devices'];

if ($marka == 'Acer' && $region_name == 'Челябинск'){
    //var_dump($all_deall_devices);
}
srand($this->_datas['feed']);

$feed = $this->_datas['feed'];

$all_deall_devices = $this->_datas['all_devices'];

/*$sql = "SELECT `model_types`.`name` as model_types_name, `model_types`.`name_rm` as model_types_name_rm, `model_types`.`name_re` as model_types_name_re, `m_models`.`name` as m_models_name, `m_models`.`ru_name` as m_models_ru_name,`markas`.`name` as markas_name, `markas`.`ru_name` as markas_ru_name FROM `m_models` INNER JOIN `model_types` ON `model_types`.`id` = `m_models`.`model_type_id` INNER JOIN `markas` ON `markas`.`id` = `m_models`.`marka_id` where `markas`.`name`  = \"".$marka."\"";
$modeli = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

$modeli_plansh = array();
$modeli_phone = array();
$modeli_nout = array();
foreach ($modeli as $item)
{
    if($item["model_types_name"] == "планшет")
    {
        $modeli_plansh[] = $item;
    }
    if($item["model_types_name"] == "смартфон")
    {
        $modeli_phone[] = $item;
    }
    if($item["model_types_name"] == "ноутбук")
    {
        $modeli_nout[] = $item;
    }
}


$modeli_plansh_rand = rand(2,4);;
$modeli_phone_rand = rand(2,4);;
$modeli_nout_rand = rand(2,4);;




$modeli_plansh_str = "";
$modeli_phone_str = "";
$modeli_nout_str = "";

if(count($modeli_phone)>0)
{
    if(count($modeli_phone)>3)
    {
        $key_phone = array_rand($modeli_phone,$modeli_phone_rand);
        foreach ($key_phone as $item)
        {
            $modeli_phone_str .= $modeli_phone[$item]["m_models_name"] . ", ";
        }
        $modeli_phone_str = substr("$modeli_phone_str",0, -2);
    }

    if(count($modeli_phone)>1  && count($modeli_phone)<4)
    {
        $modeli_phone_rand = count($modeli_phone);
        $key_phone = array_rand($modeli_phone,$modeli_phone_rand);
        foreach ($key_phone as $item)
        {
            $modeli_phone_str .= $modeli_phone[$item]["m_models_name"] . ", ";
        }
        $modeli_phone_str = substr("$modeli_phone_str",0, -2);
    }

    if(count($modeli_phone) == 1)
    {
        $modeli_phone_str .= $modeli_phone[0]["m_models_name"];
    }
}

if(count($modeli_nout)>0) {
    if(count($modeli_nout)>3)
    {
        $key_nout = array_rand($modeli_nout, $modeli_nout_rand);
        foreach ($key_nout as $item) {
            $modeli_nout_str .= $modeli_nout[$item]["m_models_name"] . ", ";
        }
        $modeli_nout_str = substr("$modeli_nout_str", 0, -2);
    }
    if(count($modeli_nout)>1 && count($modeli_nout)<4)
    {
        $modeli_nout_rand = count($modeli_nout);
        $key_nout = array_rand($modeli_nout, $modeli_nout_rand);
        foreach ($key_nout as $item) {
            $modeli_nout_str .= $modeli_nout[$item]["m_models_name"] . ", ";
        }
        $modeli_nout_str = substr("$modeli_nout_str", 0, -2);
    }
    if(count($modeli_nout)==1)
    {
        $modeli_nout_str .= $modeli_nout[0]["m_models_name"];
    }

}

if(count($modeli_plansh)>0) {
    if(count($modeli_plansh)>3)
    {
        $key_plansh = array_rand($modeli_plansh, $modeli_plansh_rand);
        foreach ($key_plansh as $item) {
            $modeli_plansh_str .= $modeli_plansh[$item]["m_models_name"] . ", ";
        }
        $modeli_plansh_str = substr("$modeli_plansh_str", 0, -2);
    }

    if(count($modeli_plansh)>1 &&count($modeli_plansh)<4)
    {
        $modeli_plansh_rand = count($modeli_plansh);
        $key_plansh = array_rand($modeli_plansh, $modeli_plansh_rand);
        foreach ($key_plansh as $item) {
            $modeli_plansh_str .= $modeli_plansh[$item]["m_models_name"] . ", ";
        }
        $modeli_plansh_str = substr("$modeli_plansh_str", 0, -2);
    }
    if(count($modeli_plansh)==1)
    {
        $modeli_plansh_str .= $modeli_plansh[0]["m_models_name"];
    }
}*/


$predlojenievnizu = array();
$predlojenievnizu[] = array($servicename);
$predlojenievnizu[] = array("использует ");
$predlojenievnizu[] = array("только","исключительно","лишь");
$predlojenievnizu[] = array("оригинальные комплектующие.","качественные запчасти.","оригинальные запасные части.");
$predlojenievnizu[] = array("Комплектующие к");
$predlojenievnizu[] = array("распространенным","частым","наиболее частым","наиболее распространенным");
$predlojenievnizu[] = array("неисправностям","поломкам","неполадкам","повреждениям");
$predlojenievnizu[] = array("всегда");
$predlojenievnizu[] = array("в наличии.","есть в наличии.","на складе RUSSUPPORT.","на нашем складе.");
$predlojenievnizu_rand = rand(1,2);
if($predlojenievnizu_rand == 1)
{
    $predlojenievnizu[] = array("Поэтому");
    $predlojenievnizu[] = array("ремонт","восстановление");
    $predlojenievnizu[] = array("любой сложности происходит в максимально короткие сроки.");
}
if($predlojenievnizu_rand == 2)
{
    $predlojenievnizu[] = array("Это позволяет качественно и быстро выполнить любой заказ.");
}

$tekst_v_bloke = array();
$tekst_v_bloke[] = array("Запасные части","Комлектующие","Запчасти");
$tekst_v_bloke[] = array("для");


$viezd_dostavkd = array();
$viezd_dostavkd_rand = rand(1,2);
if($viezd_dostavkd_rand == 1)
{
    $viezd_dostavkd = array("условия","сроки","стоимость");
}
if($viezd_dostavkd_rand == 2)
{
    $viezd_dostavkd = array("условия","сроки","цена");
}

$srochnii_remont = array();
$srochnii_remont_rand = rand(1,2);
if($srochnii_remont_rand == 1)
{
    $srochnii_remont = array("время","условия");
}
if($srochnii_remont_rand == 2)
{
    $srochnii_remont = array("сроки","условия");
}
$diagnostika = array();
$diagnostika = array("аппаратная","программная","внешняя");

$all_deall_devices_str = "";
foreach ($all_deall_devices as $items)
{
    $all_deall_devices_str .= $items["type_rm"] . ", ";
}
$all_deall_devices_str = substr("$all_deall_devices_str",0, -2);

$vremya_raboti = "время восстановления: ". $all_deall_devices_str;


$mass_ustr = array();
$mass_ustr["k"][] = array("Матрица экрана","Матрица","Матрица дисплея");
$mass_ustr["k"][] = array("Материнская плата","Системная плата","Основная плата");
$mass_ustr["k"][] = array("Мультиконтроллер","Контроллер управления","Плата контроллера","Плата мультиконтроллера");
$mass_ustr["k"][] = array("Жесткий диск","Накопитель HDD","HDD или SSD","HDD");
$mass_ustr["k"][] = array("Система охлаждения","Кулер","Кулер охлаждения","Вентилятор");
$mass_ustr["k"][] = array("Оперативная память","Оперативная память ОЗУ","Память ОЗУ","ОЗУ");
$mass_ustr["k"][] = array("Разъем HDMI","Порт HDMI","HDMI модуль","HDMI разъем","Модуль HDMI");
$mass_ustr["k"][] = array("Разъем USB","Порт USB","Модуль USB","USB разъем","Разъем ЮСБ","USB модуль");
$mass_ustr["k"][] = array("Wifi модуль","Модуль Wifi","Плата Wi-Fi","Wi fi модуль","Модуль Wi fi","Плата wi fi");
$mass_ustr["k"][] = array("Видеочип","Видеокарта","Видеокарта или видеочип","Встроенная видеокарта");
$mass_ustr["k"][] = array("Блок питания","Устройство питания");
$mass_ustr["k"][] = array("Звуковая карта","Звуковая плата","Плата звукового устройства");
$mass_ustr["k"][] = array("Камера","Встроенная камера","Вебкамера","Встроенная вебкамера");
$mass_ustr["k"][] = array("Микрофон","Встроенный микрофон","Внутренний микрофон");
$mass_ustr["k"][] = array("Разъем питания","Гнездо питания","Разъем для зарядки","Разъем питания для ЗУ");
$mass_ustr["k"][] = array("Северный мост","Чип северного моста","Северный мост материнской платы");
$mass_ustr["k"][] = array("Южный мост","Чип южного моста","Южный мост материнской платы");

$mass_ustr["m"][] = array("Матрица экрана","Матрица","Матрица дисплея");
$mass_ustr["m"][] = array("Материнская плата","Системная плата","Основная плата");
$mass_ustr["m"][] = array("Мультиконтроллер","Контроллер управления","Плата контроллера","Плата мультиконтроллера");
$mass_ustr["m"][] = array("Жесткий диск","Накопитель HDD","HDD или SSD","HDD");
$mass_ustr["m"][] = array("Система охлаждения","Кулер","Кулер охлаждения","Вентилятор");
$mass_ustr["m"][] = array("Оперативная память","Оперативная память ОЗУ","Память ОЗУ","ОЗУ");
$mass_ustr["m"][] = array("Разъем HDMI","Порт HDMI","HDMI модуль","HDMI разъем","Модуль HDMI");
$mass_ustr["m"][] = array("Разъем USB","Порт USB","Модуль USB","USB разъем","Разъем ЮСБ","USB модуль");
$mass_ustr["m"][] = array("Wifi модуль","Модуль Wifi","Плата Wi-Fi","Wi fi модуль","Модуль Wi fi","Плата wi fi");
$mass_ustr["m"][] = array("Видеочип","Видеокарта","Видеокарта или видеочип","Встроенная видеокарта");
$mass_ustr["m"][] = array("Блок питания","Устройство питания");
$mass_ustr["m"][] = array("Звуковая карта","Звуковая плата","Плата звукового устройства");
$mass_ustr["m"][] = array("Камера","Встроенная камера","Вебкамера","Встроенная вебкамера");
$mass_ustr["m"][] = array("Микрофон","Встроенный микрофон","Внутренний микрофон");
$mass_ustr["m"][] = array("Разъем питания","Гнездо питания","Разъем для зарядки","Разъем питания для ЗУ");
$mass_ustr["m"][] = array("Северный мост","Чип северного моста","Северный мост материнской платы");
$mass_ustr["m"][] = array("Южный мост","Чип южного моста","Южный мост материнской платы");

$mass_ustr["s"][] = array("Материнская плата","Системная плата","Основная плата");
$mass_ustr["s"][] = array("Мультиконтроллер","Контроллер управления","Плата контроллера","Плата мультиконтроллера","Плата мультиконтроллера");
$mass_ustr["s"][] = array("Жесткий диск","Накопитель HDD","HDD или SSD","SDD","HDD");
$mass_ustr["s"][] = array("Система охлаждения","Кулер","Кулер охлаждения","Вентилятор","Вентилятор");
$mass_ustr["s"][] = array("Оперативная память","Оперативная память ОЗУ","Память ОЗУ","ОЗУ");
$mass_ustr["s"][] = array("Звуковая карта","Звуковая плата","Плата звукового устройства");
$mass_ustr["s"][] = array("Северный мост","Чип северного моста","Северный мост материнской платы");
$mass_ustr["s"][] = array("Южный мост","Чип южного моста","Южный мост материнской платы");

$mass_ustr["o"][] = array("Дисплей","матрица","экран");
$mass_ustr["o"][] = array("разъем","разъем HDMI","разъем DVI","разъем VGA");
$mass_ustr["o"][] = array("Блок питания");
$mass_ustr["o"][] = array("ЭБУ","Блок управления");
$mass_ustr["o"][] = array("Подсветка","Led подсветка");
$mass_ustr["o"][] = array("Материская плата","Основная плата","Базовая плата");

$mass_ustr["r"][] = array("Абсорбер");
$mass_ustr["r"][] = array("Лазер","Лазерный блок");
$mass_ustr["r"][] = array("Узер закрепления");
$mass_ustr["r"][] = array("Головка");
$mass_ustr["r"][] = array("Резиновый вал");
$mass_ustr["r"][] = array("Узел подачи бумаги");
$mass_ustr["r"][] = array("Узел сканирования изображения");


$mass_ustr["t"][] = array("Тюнер","ТВ тюнер","TV тюнер");
$mass_ustr["t"][] = array("Дисплей","матрица","экран");
$mass_ustr["t"][] = array("разъем","разъем HDMI","разъем USB","разъем VGA");
$mass_ustr["t"][] = array("Блок питания");
$mass_ustr["t"][] = array("Материнская плата","Основная плата","Базовая плата");
$mass_ustr["t"][] = array("Модуль Wi-fi","Адаптер Вай-фай");

$mass_ustr["i"][] = array("Разъем","Разъем usb","Разъем hdmi","Разъем питания");
$mass_ustr["i"][] = array("BGA чип","Видео чип");
$mass_ustr["i"][] = array("Blu-Ray привод");
$mass_ustr["i"][] = array("Blu-Ray лазер");

$mass_ustr["a"][] = array("Дисплей","Матрица");
$mass_ustr["a"][] = array("Байонет объектива");
$mass_ustr["a"][] = array("Вспышка");
$mass_ustr["a"][] = array("Микросхема основной платы");
$mass_ustr["a"][] = array("Объектив");
$mass_ustr["a"][] = array("Разъем");
$mass_ustr["a"][] = array("Шлейф");
$mass_ustr["a"][] = array("Защитное стекло");
$mass_ustr["a"][] = array("Кнопка спуска");
$mass_ustr["a"][] = array("Плата управления затвором");
$mass_ustr["a"][] = array("Крышка аккумулятор");
$mass_ustr["a"][] = array("Затвор");
$mass_ustr["a"][] = array("Плата слота карты памяти");
$mass_ustr["a"][] = array("Зеркало");
$mass_ustr["a"][] = array("Мотор затвора");
$mass_ustr["a"][] = array("крышки объективов");
$mass_ustr["a"][] = array("Плата кнопок");

$mass_ustr["h"][] = array("Вентилятор охлаждения двигателя","Вентилятор обдува");
$mass_ustr["h"][] = array("Реле","Реле управления","Реле запуска");
$mass_ustr["h"][] = array("Нагреватель","Нагреватель оттайки");
$mass_ustr["h"][] = array("Фильтр-осушитель");
$mass_ustr["h"][] = array("Датчик","Датчик температуры");

$mass_ustr["e"][] = array("Блок питания");
$mass_ustr["e"][] = array("Материнская плата","Основная плата");
$mass_ustr["e"][] = array("Лампа","Проекционная лампа");
$mass_ustr["e"][] = array("Кулер охлаждения","Кулер");
$mass_ustr["e"][] = array("Разъем","Разъем HDMI","Разъем VGA","Разъем DVI");
$mass_ustr["e"][] = array("Блок кнопок","Кнопочный блок");

$complect = array();

foreach ($all_deall_devices as $device)
{
    if (!isset($device['type_id'])) continue;
    
    $t = array();

    $suffics = tools::get_suffics($device['type']);
    $select_table = $suffics.'_complect_syns';
    $join_field = $suffics.'_complect_id';

    if (pdo::getPdo()->query("SHOW TABLES LIKE '{$select_table}'")->rowCount() > 0)
    {
        if  (pdo::getPdo()->query("SELECT count(*) FROM `{$select_table}`")->fetchColumn() > 0)
        {
            $t = pdo::getPdo()->query("SELECT `name` FROM (SELECT `name`, `{$join_field}` FROM `{$select_table}` ORDER BY RAND(".$this->_datas['feed'].")) as `subquery` GROUP BY `{$join_field}`")->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

    if (!$t)
    {
        if (isset($mass_ustr[$suffics]))
        {
            foreach ($mass_ustr[$suffics] as $val)
            {
                $t[] = array('name' => tools::get_rand($val, $feed));
            }
        }
    }

   $count = 5;
   if (($c = count($t)) < 5) $count = $c;
   $complect[$device['type_id']] = rand_it::randMas($t, $count, '', $this->_datas['feed']);
}

if (!empty($this->_datas['hb'])) {
    $services = [
            ['name' => 'Нож для режущих плоттеров Silhouette', 'price' => 1590],
            ['name' => 'Керриер для режущего плоттера CAMEO', 'price' => 1650],
            ['name' => 'Прижимной ролик', 'price' => 1300],
            ['name' => 'Держатель ножа PHP34-CB30-HS', 'price' => 21349],
            ['name' => 'Держатель ножа PHP35-CB09-HS', 'price' => 17150],
            ['name' => 'Держатель ножа PHP33-CB09N-HS', 'price' => 7935],
            ['name' => 'Держатель второго инструмента для Graphtec FC8000/FCX8600', 'price' => 31520],
            ['name' => 'Нож CB15U-K30-SP 1,5 мм для плоттеров Graphtec (оригинальный)', 'price' => 5400],
            ['name' => 'Нож CB 30UC 3,0мм для плоттеров Graphtec (оригинальный)', 'price' => 7120],
            ['name' => 'Комплект фланцев для Graphtec FC8000/8600', 'price' => 17920],
            ['name' => 'Биговщик СР-003', 'price' => 23200],
            ['name' => 'Стержень шариковый KB, черный KB700-BK', 'price' => 600],
            ['name' => 'Держатель капиллярных фломастеров PHP31-Fiber', 'price' => 7400],
            ['name' => 'Лупа для проверки длины лезвия PM-CT-001', 'price' => 7100],
            ['name' => 'Сетевая плата для Graphtec FC8000', 'price' => 15000],
            ['name' => 'Держатель ножа PHP35-CB15HS', 'price' => 17500],
            ['name' => 'Роликовый нож для плоттеров Graphtec серии FC8000 (для твердых материалов)', 'price' => 10000],
            ['name' => 'Прижимной ролик для режущих плоттеров FC8000/FCX8600', 'price' => 6200],
            ['name' => 'Биговщик PM-CT-002', 'price' => 12500],
            ['name' => 'Кэрриер Craft Robo A4', 'price' => 1500],
            ['name' => 'Кэрриер CraftRobo A3 (2шт)', 'price' => 4000],
    ];

    foreach ($services as $key => $val) {
        $services[$key]['price'] = $val['price']+(rand(-2,7)*50+rand(0,1)*49);
    }
}
if (!empty($this->_datas['hab']) && empty($this->_datas['hb'])) {
    $services = [
        'планшет'=>[
            ['name' => 'Экран для планшетов', 'price' => 1050],
            ['name' => 'Аккумулятор', 'price' => 500],
        ],
        'компьютер'=>[
            ['name' => 'Система охлаждения', 'price' => 1000],
            ['name' => 'Блок питания', 'price' => 2100],
            ['name' => 'Модули памяти', 'price' => 1500],
        ],
        'сервер'=>[
            ['name' => 'Система охлаждения', 'price' => 2000],
            ['name' => 'Блок питания', 'price' => 5000],
            ['name' => 'Модули памяти', 'price' => 2500],
        ],
        'стиральная машина'=>[
            ['name' => 'Плата управления', 'price' => 2500],
            ['name' => 'Мотор', 'price' => 5300],
            ['name' => 'Манжета люка', 'price' => 1300],
        ],
        'принтер'=>[
            ['name' => 'Печка', 'price' => 3200],
            ['name' => 'Ролики захвата бумаги', 'price' => 300],
            ['name' => 'Сетивая плата', 'price' => 1500],
        ],
        'сортировщик купюр'=>[
            ['name' => 'Накладка подающего ролика', 'price' => 900],
            ['name' => 'Накладка подающего ролика', 'price' => 600],
        ],
        'моноколесо'=>[
            ['name' => 'Декоративная накладка фары моноколеса GotWay MSuper Pro (передняя, двойная)', 'price' => 900],
            ['name' => 'Динамики моноколеса GotWay MSuper-PRO', 'price' => 600],
        ],
        'электросамокат'=>[
            ['name' => 'Гнездо зарядки для электросамоката', 'price' => 800],
            ['name' => 'Болт крепления складного механизма руля', 'price' => 1000],
        ],
        'гироскутер'=>[
            ['name' => 'Центральная плата для гироскутера', 'price' => 1650],
            ['name' => 'Bluetootch модуль - плата гироскутера', 'price' => 350],
            ['name' => 'Стабилизатор напряжения гироскутера', 'price' => 2500],
            ['name' => 'Батарея гироскутера', 'price' => 2500],
            ['name' => 'Кнопки включения для гироскутера', 'price' => 500],
        ],
    ];

    // foreach ($services as $key => $val) {
    //     $services[$key]['price'] = $val['price']+(rand(-2,7)*50+rand(0,1)*49);
    // }
}

?>

<main>
<section class="breadcrumbs">
    <div class="container">
        <div class="grid-12" itemscope="" itemtype="http://schema.org/BreadcrumbList">
            <ul class="breadcrumbs-inside">
               <li itemprop="name"><a href="/" itemprop="url">Главная</a></li>
                    <li class="breadcrumbs-inside-drop">
                        <a href="/info/"><span itemprop="name">Информация</span></a>
                        <span class="breadcrumbs-inside-drop-btn"></span>
                        <ul class="drop">
                            <li itemprop="name"><a itemprop="url" href="/info/time-to-repair/">Время ремонта</a></li>
                            <li itemprop="name"><a itemprop="url" href="/info/delivery/">Выезд и доставка</a></li>
                            <li itemprop="name"><a itemprop="url" href="/info/diagnostics/">Диагностика</a></li>
                            <li itemprop="name"><a itemprop="url" href="/info/hurry-up-repairs/">Срочный ремонт</a></li>
                        </ul>
                    </li>
                <li itemprop="name"><span>Комплектующие</span></li>
            </ul>
        </div>
    </div>
</section>
<section class="title-block">
    <div class="container">
        <div class="grid-12">
            <h1><?=$this->_ret['h1']?></h1>
                <p class="non-block-text"><?=$this->checkarray($predlojenievnizu)?></p>
        </div>
    </div>
</section>
<section class="block-section">
    <div class="container">
        <div class="grid-12">
            <div class="block-list block-list">
                <?foreach ($all_deall_devices as $item) :
                    if (!isset($item['type_id'])) continue;?>
                <div class="block block-auto block-table">
                    <div class="block-inside">
						<?
						if (empty($this->_datas['hab'])) {
						$url = tools::search_url($this->_datas['site_id'], serialize(array('model_type_id' => $item['type_id'], 'marka_id' => $this->_datas['marka_id'])));
						
						?>
                        <a href="/<?=$url?>/"><h3><?=tools::mb_firstupper($item['type_m'])?></h3></a>
                        <div class="services-item-table">
                              <? foreach ($complect[$item['type_id']] as $value):
								//$url = tools::search_url($this->_datas['site_id'], serialize(array('model_type_id' => $value['type_id'], 'marka_id' => $this->_datas['marka_id'])));
							  ?>

                                    <span class="services-item-row">
                                        <span class="services-item-name"><?=tools::mb_firstupper($value['name'])?></span>
                                        <span class="services-item-value"></span>
                                    </span>

                              <? endforeach; ?>
                        </div>
                        <? }  elseif(!empty($this->_datas['hb'])) { ?>
                        <h3><?=tools::mb_firstupper($item['type_m'])?>!</h3>
                        <div class="services-item-table">
                            <? foreach ($services as $value):?>
                                <span class="services-item-row">
                                    <span class="services-item-name"><?=tools::mb_firstupper($value['name'])?></span>
                                    <span class="services-item-value"><?=number_format($value['price'], 0, ',', ' ')?></span>
                                </span>

                            <? endforeach; ?>
                        </div>
                        <? }else{ ?>
                        <?
                        ?>
                                <h3><?=tools::mb_firstupper($item['type_m'])?></h3>
                                <div class="services-item-table">
                                    <? foreach ($services[$item['type']] as $value):?>
                                        <span class="services-item-row">
                                            <span class="services-item-name"><?=tools::mb_firstupper($value['name'])?></span>
                                            <span class="services-item-value"><?=number_format($value['price'], 0, ',', ' ')?></span>
                                        </span>
        
                                    <? endforeach; ?>
                                </div>
                        <? } ?>
                    </div>
                </div>
                <?endforeach;?>
            </div>
        </div>
    </div>
</section>
 <section class="link-block-section">
        <div class="container">
            <div class="link-block-list perelink">
                <a href="/info/hurry-up-repairs/" class="link-block">
                    <div class="link-block-title-strong">Срочный ремонт</div><?=$this->firstup($this->rand_arr_str($srochnii_remont))?>
                </a>
                <a href="/info/delivery/" class="link-block">
                    <div class="link-block-title-strong">Выезд и доставка</div><?=$this->firstup($this->rand_arr_str($viezd_dostavkd))?>
                </a>
                <a href="/info/diagnostics/" class="link-block">
                    <div class="link-block-title-strong">Диагностика</div><?=$this->firstup($this->rand_arr_str($diagnostika))?>
                </a>
                <a href="/info/time-to-repair/" class="link-block">
                    <div class="link-block-title-strong">Время ремонта</div><?=$this->firstup($vremya_raboti)?>
                </a>
            </div>
        </div>
 </section>
</main>
