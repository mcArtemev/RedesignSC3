<?php

use framework\tools;
use framework\pdo;

use framework\ajax\parse\hooks\pages\sc6\data\src\type_service;
use framework\ajax\parse\hooks\pages\sc6\data\src\helpers6;

$metrica = $this->_datas['metrica'];
$analytics = $this->_datas['analytics'];

$marka = $this->_datas['marka']['name'];  // SONY
$marka_lower = mb_strtolower($marka);
$servicename = $this->_datas['servicename']; //SONY Russia
$ru_servicename = $this->_datas['ru_servicename']; //
$ru_marka = $this->_datas['marka']['ru_name']; // СОНИ

$region_name = $this->_datas['region']['name'];//Москва
$region_name_eng = $this->_datas['region']['translit2'];//Moscow
$region_name_pril = $this->_datas['region']['pril'];//Московского
$region_name_pe = $this->_datas['region']['name_pe'];//в Москве (в Владивостоке)
$region_name_de = $this->_datas['region']['name_de'];//по Москве (Владивостоку)
$region_name_re = $this->_datas['region']['name_re'];//служба Москвы (Владивостока)
$phone = $this->_datas['phone'];
$phone_format = tools::format_phone($phone);
$address = $this->_datas['partner']['address1'];
$address2 = $this->_datas['partner']['address2'];
$geo_google = $this->_datas['partner']['sid'];

$addresis = $this->_footer_addresis(['Москва'], 7);

$url = $this->_datas['arg_url'];

$mail = $this->_datas['partner']['email'];
if ($mail == 'litovchenko@list.ru') {
	$mail = '';
}


srand($this->_datas['feed']);
    $h2 = array();
    //$h2[] = array("Запись на ремонт $marka в","Заявка на ремонт $marka в","Онлайн запись на ремонт $marka в","Онлайн заявка на ремонт $marka в","Online запись на ремонт $marka в",
    //    "Online заявка на ремонт $marka в");
    #$h2[] = array("Запись на ремонт в","Заявка на ремонт в","Онлайн запись на ремонт в","Онлайн заявка на ремонт в","Online запись на ремонт в",
    #"Online заявка на ремонт в");
    $h2[] = array("$servicename");
    $h2[] = array("вы знаете, куда обращаться","вы всегда знаете, куда обращаться","здесь точно помогут","здесь 100% помогут","есть куда обратится","вы знаете, куда обратиться",
        "вы всегда знаете, куда обратиться");
    $h2[] = array("");
    $h2[] = array("");

    //первое предложение
    $predlogenie[0][] = array("Ремонтируют технику","Технику ремонтируют");
    $predlogenie[0][] = array("опытные","квалифицированные");
    $predlogenie[0][] = array("мастера","специалисты","сотрудники","сервисные сотрудники","сервис инженеры","сервисные мастера");
    $predlogenie[0][] = array("со стажем","с опытом");
    $predlogenie[0][] = array("работы");
    $predlogenie[0][] = array("от 2 лет.","от 3 лет.","от 4 лет.","от 5 лет.");

    // второе предложение
    $predlogenie[1][] = array("Работаем только на","Для ремонта используем","Ремонт производим на","Ремонтируем на","В ремонте используем","Ремонтные работы проводим на","Работаем на",
        "Ремонтируем только на");

    $predlogenie[1][] = array("современном,","профессиональном,","высокопрофессиональном,","специализированном,","новейшем,","оригинальном,","фирменном,","брендовом,");
    $predlogenie[1][] = array("современном","профессиональном","высокопрофессиональном","специализированном","новейшем","оригинальном","фирменном","брендовом");

    $predlogenie[2][] = array("оборудовании:","спецоборудовании:");
    $predlogenie[2][] = array("современных","профессиональных","специализированных","новейших","оригинальных","фирменных","брендовых");
    $predlogenie[2][] = array("паяльных станциях","ремонтных системах","ремонтных станциях","паяльных системах","паяльных комплексах","ремонтных комплексах","паяльно-ремонтных комплексах",
        "паяльно-ремонтных системах","паяльно-ремонтных центрах","паяльно-ремонтных станциях");
    $predlogenie[2][] = array("с ИК нагревом,","с ИК подогревом,","с верхним/нижним ИК подогревом,","с верхним/нижним ИК нагревом,","с нижним/верхним ИК подогревом,","с нижним/верхним ИК нагревом,",
        "для монтажа BGA элементов,","для монтажа BGA компонент,","для монтажа/демонтажа BGA компонент,","для монтажа BGA элементов,");
    $predlogenie[3][] = array("осциллографы","цифровые осциллографы","цифровые анализаторы");
    $predlogenie[3][] = array("микроскопы");
    $predlogenie[3][] = array("мультиметры","электроизмерительные мультиметры");
    $predlogenie[3][] = array("программаторы");
    $predlogenie[3][] = array("ультразвуковые ванны");


    //первый флаг
    $predlogenie1_1 = $this->checkcolumn($predlogenie[1][1]);
    $key = array_search(mb_substr($predlogenie1_1,0,-1),$predlogenie[1][2]);
    unset($predlogenie[1][2][$key]);
    $key2 = preg_grep("#".mb_substr($predlogenie1_1,0,-3)."#",$predlogenie[2][1]);
    if(count($key2)>0)
    {
        foreach ($key2 as $key => $value)
            unset($predlogenie[2][1][$key]);
    }
    //второй флаг
    $predlogenie1_2 = $this->checkcolumn($predlogenie[1][2]);
    $key3 = preg_grep("#".mb_substr($predlogenie1_2,0,-3)."#",$predlogenie[2][1]);
    if(count($key3)>0)
    {
        foreach ($key3 as $key => $value)
            unset($predlogenie[2][1][$key]);
    }


    $predlogenie_2 =  $this->checkcolumn($predlogenie[1][0]) . " " . $predlogenie1_1 . " " . $predlogenie1_2 . " " . $this->checkarray($predlogenie[2]) . " ";

    for ($i = 0;$i <3; $i++)
    {
        if($i == 0)
        {
            $predlogenie_2_rand = array_rand($predlogenie[3]);
            $predlogenie_2 .= $this->checkcolumn($predlogenie[3][$predlogenie_2_rand]) . ", ";
            unset($predlogenie[3][$predlogenie_2_rand]);
        }
        if($i == 1)
        {
            $predlogenie_2_rand = array_rand($predlogenie[3]);
            $predlogenie_2 .= $this->checkcolumn($predlogenie[3][$predlogenie_2_rand]) . " и ";
            unset($predlogenie[3][$predlogenie_2_rand]);
        }
        if($i == 2)
        {
            $predlogenie_2_rand = array_rand($predlogenie[3]);
            $predlogenie_2 .= $this->checkcolumn($predlogenie[3][$predlogenie_2_rand]);
        }


    }


    // третье предложение
    $predlogenie[4][] = array("В $servicename не бывает");
    $predlogenie[4][] = array("проблем","трудностей","сложностей");
    $predlogenie[5][] = array("с запчастями:","с запасными частями:","");
    $predlogenie[6][] = array("налаженные","отлаженные");
    $predlogenie[6][] = array("поставки,","процессы поставок,","процессы регулярных поставок,");

    $predlogenie[6][] = array("большинство деталей","большинство запчастей","большинство запасных частей","большинство комплектующих");
    $predlogenie[6][] = array("в наличии","есть","в достаточном количестве","в необходимом количестве");
    $predlogenie[6][] = array("на лабораторных складах");
    $predlogenie[6][] = array("по адресу");
    $predlogenie[6][] = array("$address.");
    $predlogenie5_0 = $this->checkcolumn($predlogenie[5][0]);
    if($predlogenie5_0 == "с запчастями:")
    {
        unset($predlogenie[6][2][1]);
    }
    if($predlogenie5_0 == "с запасными частями:")
    {
        unset($predlogenie[6][2][2]);
    }
    if($predlogenie5_0 == "с комплектующими:")
    {
        unset($predlogenie[6][2][4]);
    }
    $predlogenie_3 = $this->checkarray($predlogenie[4]) . " " . $predlogenie5_0 . " " . $this->checkarray($predlogenie[6]);
// 4-е предложение

    $predlogenie[7][] = array("Можем");
    $predlogenie[7][] = array("починить","отремонтировать");
    $predlogenie[7][] = array("абсолютно любую","любую");
    $predlogenie[7][] = array("модель");
    $predlogenie[7][] = array("любого");
    $predlogenie[7][] = array("аппарата","устройства");
    $predlogenie[7][] = array("бренда","");
    $predlogenie[7][] = array("$marka");

    $predlogenie_rand12 = rand(1,2);
    $predlogenie_rand = rand(1,3);
    if($predlogenie_rand12 == 1)
    {
        $predlogenie_out = $this->checkarray($predlogenie[7]);
        if($predlogenie_rand == 1)
        {
            $predlogenie_out .= " " . $this->checkarray($predlogenie[0]);
        }
        if($predlogenie_rand == 2)
        {
            $predlogenie_out .= " " .$predlogenie_2;
        }
        if($predlogenie_rand == 3)
        {
            $predlogenie_out .= " " . $predlogenie_3;
        }

    }
    if($predlogenie_rand12 == 2)
    {
        $predlogenie_out = "";
        if($predlogenie_rand == 1)
        {
            $predlogenie_out .= $this->checkarray($predlogenie[0]);
        }
        if($predlogenie_rand == 2)
        {
            $predlogenie_out .= $predlogenie_2;
        }
        if($predlogenie_rand == 3)
        {
            $predlogenie_out .= $predlogenie_3;
        }
        $predlogenie_out .= " ".$this->checkarray($predlogenie[7]);
    }

    // второй абзац
    $abzac2 = array();
    $abzac2_rand = rand(1,2);
    if($abzac2_rand == 1)
    {
        $abzac2[] = array("Заполняйте телефон","Заполняйте номер телефона","Заполняйте свой телефон","Заполняйте свой номер телефона","Заполняйте номер своего телефона");
        $abzac2[] = array("и отправляйте","и посылайте","и оставляйте");
        $abzac2[] = array("онлайн заявку -","on-line заявку -","онлайн заказ -","on-line заказ -","онлайн запрос -","on-line запрос -");
    }
    if($abzac2_rand == 2)
    {
        $abzac2[] = array("Заполняйте телефон через онлайн форму","Заполняйте номер телефона через онлайн форму","Заполняйте свой телефон через онлайн форму","Заполняйте свой номер телефона через онлайн форму",
            "Заполняйте номер своего телефона через онлайн форму","Заполняйте телефон через on-line форму","Заполняйте номер телефона через on-line форму",
            "Заполняйте свой телефон через on-line форму","Заполняйте свой номер телефона через on-line форму","Заполняйте номер своего телефона через on-line форму");
        $abzac2[] = array("и отправляйте","и посылайте","и оставляйте");
        $abzac2[] = array("заявку -","заказ -","запрос -");
    }

    $abzac2[] = array("наши специалисты","наши операторы","наши сотрудники","сотрудники call-центра","операторы call-центра","специалисты call-центра",
        "сотрудники нашего call-центра","операторы нашего call-центра","специалисты нашего call-центра");
    $abzac2[] = array("перезвонят вам и","свяжутся с вами и");
    $abzac2[] = array("проконсультируют по любым вопросам ремонта,","проконсультируют по любым вопросам ремонта и обслуживания,","проконсультируют по всем вопросам ремонта,",
        "проконсультируют по всем вопросам ремонта и обслуживания,","проведут консультацию по любым вопросам ремонта,","проведут консультацию по любым вопросам ремонта и обслуживания,",
        "проведут консультацию по всем вопросам ремонта,","проведут консультацию по всем вопросам ремонта и обслуживания,","ответят на любые вопросы по любым видам ремонта,",
        "ответят на любые вопросы по любым видам ремонта и обслуживания,","ответят на все вопросы по любым видам ремонта,","ответят на все вопросы по любым видам ремонта и обслуживания,",
        "проконсультируют по любым видам ремонта,","проконсультируют по любым видам ремонта и обслуживания,","проконсультируют по всем видам ремонта,",
        "проконсультируют по всем видам ремонта и обслуживания,","проведут консультацию по любым видам ремонта,","проведут консультацию по любым видам ремонта и обслуживания,",
        "проведут консультацию по всем видам ремонта,","проведут консультацию по всем видам ремонта и обслуживания,","ответят на вопросы по любым видам ремонта,",
        "ответят на вопросы по любым видам ремонта и обслуживания,","ответят на вопросы по всем видам ремонта,","ответят на вопросы по всем видам ремонта и обслуживания,");
    $abzac2[] = array("при необходимости");
    $abzac2[] = array("запишут на","согласуют");
    $abzac2[] = array("удобное время","подходящее время","удобное вам время","подходящее вам время","удобное для вас время","подходящее для вас время");
    $abzac2[] = array("приезда в");
    $abzac2[] = array("наш сервис.","наш сервисный центр.","нашу мастерскую.","наш сервис центр.");

$all_deall_devices = $this->_datas['all_devices'];

$oz = [
  ['Вам'],
  ['необходимо','нужно'],
  ['отремонтировать', 'починить'],
  ['неисправную', 'вышедшую из строя'],
  ['технику?'],

  ['Запишитесь	в'],
  ['наш сервисный центр','сервисный центр','сервис-центр'],
  ['онлайн,	находясь дома или на работе.'],

  ['Позвоните', 'Наберите наш номер'],
  ['по телефону или'],
  ['отправьте','оставьте'],
  ['заявку через	форму	обратной связи и'],
  ['приезжайте','приходите'],
  ['в'],
  ['удобное','указанное'],
  ['время.'],

  ['Вам','У Вас'],
  ['не хватает	времени	на'],
  ['поездку','визит'],
  ['в'],
  ['сервисный центр?','мастерскую?','ремонтную мастерскую?'],

  ['Воспользуйтесь услугами','Используйте услугу'],
  ['курьера: наш'],
  ['сотрудник','работник'],
  ['заберет'],
  ['неисправное','сломаное'],
  ['устройство и'],
  ['доставит','отвезет'],
  ['в	сервисный	центр, когда'],
  ['инженеры','мастера'],
  ['устранят'],
  ['поломку','неисправность'],
  ['технику','устройство'],
  ['привезут','доставят'],
  ['Вам	обратно.'],

  ['Мы ремонтируем'],
  ['технику','гаджеты'],
  ['и'],
  ['экономим','сохраняем'],
  ['время	наших'],
  ['клиентов.','заказчиков.'],
];

$menuFooter = [
  1 => [
    #'uslugi' => 'Услуги',
    'komplektuyshie' => 'Комплектующие',
    'neispravnosti' => 'Неисправности',
    'o_kompanii/price_list' => 'Цены',
  ],
  2 => [
    'o_kompanii/vremya_remonta' => 'Время ремонта',
    'o_kompanii/diagnostika' => 'Диагностика',
    'o_kompanii/dostavka' => 'Выезд и доставка',
  ],
  3 => [
    'o_kompanii' => 'О компании',
    'o_kompanii/akciya' => 'Акции',
    'o_kompanii/vakansii' => 'Вакансии',
    'o_kompanii/otzivy' => 'Отзывы',
    'o_kompanii/informaciya' => 'Информация',
  ]
];

$onlineP1 = [
  ['Запишитесь в'],
  ['наш сервисный центр','сервисный центр','сервис-центр'],
  ['онлайн, находясь в любом месте.'],

  ['Позвоните','Наберите наш номер'],
  ['по телефону или'],
  ['отправьте','оставьте'],
  ['заявку через форму обратной связи и'],
  ['приезжайте','приходите'],
  ['в удобное время.'],
];
$onlineP1 = self::_createTree($onlineP1, $this->_datas['site_id']);

$onlineP2 = [
  ['Вам','У Вас'],
  ['не хватает времени на'],
  ['поездку','визит'],
  ['в'],
  ['сервисный центр?','мастерскую?','ремонтную мастерскую?'],

  ['Воспользуйтесь услугами','Используйте услугу'],
  ['курьера: наш'],
  ['сотрудник','работник'],
  ['заберет'],
  ['неисправное','сломаное'],
  ['устройство и'],
  ['доставит','отвезет'],
  ['в сервисный центр. Когда'],
  ['инженеры','мастера'],
  ['устранят'],
  ['поломку,','неисправность,'],
  ['технику','устройство'],
  ['привезут','доставят'],
  ['Вам обратно.'],

  ['Мы ремонтируем'],
  ['технику','гаджеты'],
  ['и'],
  ['экономим','сохраняем'],
  ['время наших'],
  ['клиентов.','заказчиков.'],
];
$onlineP2 = self::_createTree($onlineP2, $this->_datas['site_id']);


?>

<section class="call-master">
    <div class="container">
        <div class="call-master__inner">
            <div class="call-master__top">
                <h2><?=$this->checkarray($h2)?></h2>

                <p><?=$onlineP1?></p>
                <p><?=$onlineP2?></p>
            </div>

            <div class="call-master-form-wrap">
                <div>
                  <p>Оформите заявку на вызов мастера</p>
                  <span>и получите скидку 25% на ремонт</span>

                  <form class="call-master-form" action="">
                      <div class="row">
                          <div class="col-md-4 col-sm-6 col-xs-12 call-master-form__item">
                              <input name = "name" type="text" placeholder="Ваш имя *" class="call-master-form__input" required>
                          </div>
                          <div class="col-md-4 col-sm-6 col-xs-12 call-master-form__item">
                              <input name = "phone" type="text" placeholder="Ваш номер телефона *" class="call-master-form__input" required>
                          </div>
                          <div class="col-md-3 col-sm-12 col-xs-12 call-master-form__last">
                              <button type="submit" class="call-master-form__btn">Вызвать мастера</button>
                          </div>
                      </div>
                  </form>
                </div>
            </div>

        </div>
    </div>
</section>
<footer class="page-footer">
    <div class="container">
        <div class="row page-footer__main">
            <div class="page-footer__main-col">
                
            <?php 

                $croppedTypes = cropArrTypes($all_deall_devices);

                $twoColumn = (count($croppedTypes)>9)? 'class="twoColumn"' :''; 
                $hidden = (count($croppedTypes)>9)? 'hidden' :'';
                $NotHidden = (count($croppedTypes)<10)? 'hidden' :'';

                
                
            ?>
                <h3>Устройства</h3>
                <ul <?=$twoColumn?>>
                  <?php foreach ($croppedTypes as $type) { ?>
                    <li>
                      <?php if (type_service::TYPES_URL[$type['type']] != $url) { ?>
                      <a href = "/<?=type_service::TYPES_URL[$type['type']]?>/"><?=tools::mb_ucfirst($type['type_m'])?></a>
                      <?php } else { ?>
                      <span><?=tools::mb_ucfirst($type['type_m'])?></span>
                      <?php } ?>
                    </li>
                  <?php } ?>
                </ul>
            </div>
            <div class="page-footer__main-col">
                <h3>Обслуживание и ремонт</h3>
                <ul>
                    <?php foreach ($menuFooter[1] as $urlItem => $itemMenu) { ?>
                    <li>
                      <?php if ($urlItem != $url) { ?>
                      <a href = "/<?=preg_replace('/(^\/|\/$)/', '', $urlItem)?>/"><?=$itemMenu?></a>
                      <?php } else { ?>
                      <span><?=$itemMenu?></span>
                      <?php } ?>
                    </li>
                    <?php } ?>
                    
                <?php if(count($croppedTypes)>9){
                    foreach ($menuFooter[2] as $urlItem => $itemMenu) { ?>
                      <li>
                        <?php if ($urlItem != $url) { ?>
                        <a href = "/<?=preg_replace('/(^\/|\/$)/', '', $urlItem)?>/"><?=$itemMenu?></a>
                        <?php } else { ?>
                        <span><?=$itemMenu?></span>
                        <?php } ?>
                      </li>
                <?php       }
                        } 
                ?>
                </ul>
            </div>
            <div class="page-footer__main-col" <?=$hidden?>>
                <h3>Информация</h3>
                <ul>
                  <?php foreach ($menuFooter[2] as $urlItem => $itemMenu) { ?>
                  <li>
                    <?php if ($urlItem != $url) { ?>
                    <a href = "/<?=preg_replace('/(^\/|\/$)/', '', $urlItem)?>/"><?=$itemMenu?></a>
                    <?php } else { ?>
                    <span><?=$itemMenu?></span>
                    <?php } ?>
                  </li>
                  <?php } ?>
                </ul>
            </div>
            <div class="page-footer__main-col">
                <h3>Сервисный центр</h3>
                <ul>
                  <?php foreach ($menuFooter[3] as $urlItem => $itemMenu) { ?>
                  <li>
                    <?php if ($urlItem != $url) { ?>
                    <a href = "/<?=preg_replace('/(^\/|\/$)/', '', $urlItem)?>/"><?=$itemMenu?></a>
                    <?php } else { ?>
                    <span><?=$itemMenu?></span>
                    <?php } ?>
                  </li>
                  <?php } ?>
                </ul>
            </div>
        </div>
        <div class="footer-maps">
            <? if ($this->_datas['marka']['id'] != 352):?>
              <?php foreach ($addresis as $address) {
                $cityName = $address['region_name'] == '' ? 'Москва' : $address['region_name'];?>
                <div class="footer-maps__item">
                    <div class="footer__map-left">
                        <?php if ($this->_datas['site_id'] == $address['site_id']) { ?>
                          <h3><?=$cityName?></h3>
                        <?php } else { ?>
                        <a href="https://<?=$address['site']?>/<?=($url == '/' ? '' : preg_replace('/(^\/|\/$)/', '', $url).'/')?>"><h3><?=$cityName?></h3></a>
                        <?php } ?>
                        <span><?//($address['address2'] ? $address['address2'] : $address['address1'])?></span>
                        <a href="tel:<?=$address['phone']?>"><?=tools::format_phone($address['phone'])?></a>
                        <span><?=($address['time'] === null ? "Пн-Вс, с 9:00 до 18:00" : $address['time'])?></span>
                    </div>
                    <div class="footer__map-right">
                        <img src="https://static-maps.yandex.ru/1.x/?ll=<?=$address['y']?>,<?=$address['x']?>&size=250,140&z=13&l=map&pt=<?=$address['y']?>,<?=$address['x']?>,org" style="width: 250px; height: 140px;" />
    					<!--<div data-map = "<?=$address['x'].';'.$address['y']?>" style="width: 250px; height: 140px;"></div>-->
                    </div>
                </div>
                <?php } ?>
            <?endif;?>
            <div class="tab-btn" style="margin: 0 auto;"><a href="#" class="btn btn-blue" onclick="var body = $('html, body'); body.stop().animate({scrollTop:0}, 1000, 'swing'); $(this).blur(); return false;">Наверх</a></div>
        </div>

        <div class="page-footer__copy">
            <p class="text-center">Сервисный центр <?= $marka ?></p>
            <p class="font-norm">Горячая линии технической поддержки клиентов в <?=$region_name_pe?>: 
              <a href="tel:<?=$phone?>">
                  <i class="fa fa-phone" aria-hidden="true"></i>&nbsp;<?=$phone_format?>
                </a>
            </p>
            <span class="text-center">
              <a href = "#" class = "ps">Пользовательское соглашение</a><br>
							<i class="fa fa-copyright" aria-hidden="true"></i>
							&nbsp;<?=date('Y')?>. Все права защищены
						</span>
        </div>
    </div>
    <div id = "mailFormSend" style = "display: none;"><?=$mail?></div>
</footer>

</div>

<!-- Modal-callback -->
<div class="modal fade" id="requestModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Обратный звонок</h4>
                <p>отправьте заявку и наши менеджеры свяжутся с Вами в удобное для Вас время</p>
            </div>
            <div class="modal-body">
                <form class="form-callback">
                    <div class="form-callback__item">
                        <input type="text" name = "name" placeholder="Ваше имя" class="form-callback__input">
                    </div>
                    <div class="form-callback__item">
                        <input type="text" name = "phone" placeholder="Ваш номер телефона" class="form-callback__input">
                    </div>
                    <div class="form-callback__item">
                        <input type="text" name="times" placeholder="Удобное время звонка" class="form-callback__input">
                    </div>
                    <div class="form-callback__submit">
                        <button class="form-callback__btn">Заказать звонок</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal-thankyou -->
<div class="modal fade" id="tyRequest" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title">Спасибо, Ваша заявка принята!</h3>
            </div>
            <div class="modal-body">
              <p class="modal-txt">Наши менеджеры свяжутся с Вами в удобное для Вас время.</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal-thankyou -->
<div class="modal fade" id="tyQuest" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title">Спасибо, за Ваш вопрос!</h3>
            </div>
            <div class="modal-body">
              <p class="modal-txt">Наши специалисты в ближайшее время дадут ответ на Ваш вопрос.</p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="statusModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title">Статус заказа</h3>
                <p></p>
              </div>
              <div class="modal-body">
                  <form>
                      <div class="form-callback__item">
                          <input type="text" name = "num" placeholder="Номер заказа" class="form-callback__input">
                      </div>
                      <div class="form-callback__submit">
                          <button class="form-callback__btn">Проверить</button>
                      </div>
                  </form>

                  <div class = "result">
                    
                  </div>
              </div>
        </div>
    </div>
</div>

<div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title">Оставить отзыв</h3>
                <p></p>
              </div>
              <div class="modal-body">
                  <form>
                      <div class="form-callback__item">
                          <input type="text" name = "name" placeholder="Ваше имя" class="form-callback__input">
                      </div>
                      <div class="form-callback__item">
                          <textarea type="text" rows = "4" name = "text" placeholder="Ваш отзыв" class="form-control form-question__textarea"></textarea>
                      </div>
                      <div class="form-callback__item">
                          <input type="text" name = "cause" placeholder="Причина обращения" class="form-callback__input">
                      </div>
                      <div class="form-callback__submit">
                          <button class="form-callback__btn">Оставить отзыв</button>
                      </div>
                  </form>

                  <div class = "result">
                    <p>Спасибо! Ваш отзыв отправлен на модерацию.</p>
                  </div>
              </div>
        </div>
    </div>
</div>




<script src="/_mod_files/_js/bootstrap.min.js"></script>

<script type="text/javascript" src="/_mod_files/_js/plugins/slick.js"></script>

<script src="/_mod_files/_js/chosen.jquery.js"></script>

<script type="text/javascript" src="/_mod_files/_js/plugins/custom-select-menu.jquery.js"></script>

<script type="text/javascript" src="/_mod_files/_js/plugins/stacktable.js"></script>

<script type="text/javascript" src="/_mod_files/_js/owl/owl.carousel.min.js"></script>

<script type="text/javascript" src="/_mod_files/_js/jquery.maskedinput.min.js"></script>

<script src="/_mod_files/_js/main.js" type="text/javascript"></script>
<script src="/_mod_files/_js/action.js" type="text/javascript"></script>
<script src="/_mod_files/_js/tracking.js" type="text/javascript"></script>
<? if ($metrica):?>
<script type="text/javascript" data-counter_id="<?=$metrica?>"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter<?=$metrica?> = new Ya.Metrika({ id:<?=$metrica?>, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, triggerEvent:1 }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/<?=$metrica?>" style="position:absolute; display: none; left:-9999px;" alt="" /></div></noscript>
<?php endif;?>
<? if ($analytics):?>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', '<?=$analytics?>', 'auto');
        ga('send', 'pageview');

    </script>
<?endif;?>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4VJXHdz_zdv_KYgYw1RscLcN6pW8T9LQ&callback=initMap">
</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-114242006-1"></script>
<script>
 window.dataLayer = window.dataLayer || [];
 function gtag(){dataLayer.push(arguments);}
 gtag('js', new Date());

 gtag('config', 'UA-114242006-1');
</script>
<?php if (!empty($this->_datas['piwik'])) { ?>
	<!-- Matomo -->
	<script type="text/javascript">
	var _paq = _paq || [];
	/* tracker methods like "setCustomDimension" should be called before "trackPageView" */
	_paq.push(['trackPageView']);
	_paq.push(['enableLinkTracking']);
	(function() {
		var u="/statistics/";
		_paq.push(['setTrackerUrl', u+'piwik.php']);
		_paq.push(['setSiteId', '<?=$this->_datas['piwik']?>']);
		var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
		g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
	})();
	</script>
	<noscript><p><img src="/statistics/piwik.php?idsite=<?=$this->_datas['piwik']?>&amp;rec=1" style="border:0;" alt="" /></p></noscript>
	<!-- End Matomo Code -->
<?php } ?>
</body>
</html>
