<?

use framework\tools;
use framework\pdo;

$marka = $this->_datas['marka']['name'];
$marka_lower = mb_strtolower($this->_datas['marka']['name']); // SONY
$ru_marka = $this->_datas['marka']['ru_name']; // СОНИ
$site_id = $this->_site_id;
$model_type = $this->_datas['model_type'][3];
$model_type_rm = $model_type['name_rm'];
$model_type_m = $model_type['name_m'];
$model_type_id = $this->_datas['model_type']['id'];
$marka_id = $this->_datas['marka']['id'];
$region_code = ($this->_datas['region']['code']) ? '-'.$this->_datas['region']['code'] : '';

if ($this->_mode == -2)
{
    $model_id = $this->_datas['model']['id'];
    $full_type_name = $model_type['name_re'].' '.$this->_datas['model']['name'];
    $full_name = $this->_datas['model']['name'];
}

if ($this->_mode == -3)
{
    $full_name = $full_type_name = $model_type['name_re'].' '.$this->_datas['marka']['name'];
}

$setka_name = $this->_datas['setka_name'];

$eds = $this->_datas['eds'];
$availables = $this->_datas['availables'];

$all_services =  $this->_datas['all_services'];
$all_complects = $this->_datas['all_complects'];
$metrica = $this->_datas['metrica'];

/* удаление из $all_services случайных строк от 0 до 3, удаление из $all_complects случайных строк от 0 до 2.
if ($this->_mode == -2) {
    $all_services_temporary = rand(0, 3);
    if ($all_services_temporary != 0) {
        for ($i = 0; $i < $all_services_temporary; $i++) {
            $all_services_in = array_rand($all_services, 1);
            unset($all_services[$all_services_in]);

        }
    }

    $all_complects_temporary = rand(0, 2);
    if ($all_complects_temporary != 0) {
        for ($i = 0; $i < $all_complects_temporary; $i++) {
            $all_complects_in = array_rand($all_complects, 1);
            unset($all_complects[$all_complects_in]);
        }
    }
}
*/


$price = tools::format_price($this->_datas['price'], $setka_name);
$accord_image = $this->_datas['accord_image'];
$this->_ret['img'] = 'wp-content/uploads/2015/03/'.$marka_lower.'/'.$accord_image[$this->_datas['orig_model_type']['0']['name']].$region_code.'.png';

// srand($this->_datas['feed']);

//  блок с генерёжем
$generation_identical = array("Цены на работы по ремонту", "Стоимость работ по ремонту", "Цены на услуги по ремонту", "Стоимость услуг по ремонту",
    "Прейскурант цен на работы по ремонту", "Прайс-лист на работы по ремонту", "Прейскурант цен на услуги по ремонту", "Прайс-лист на услуги по ремонту",
    "Цены на ремонт", "Стоимость ремонта");
$generation_identical2 = array("Стоимость комплектующих для", "Цены на комплектующие для", "Стоимость запчастей для", "Цены на запчасти для", "Стоимость запасных частей для",
    "Цены на запасные части для", "Прайс-лист на комплектующие для", "Прайс-лист на запчасти для", "Прайс-лист на запасные части для", "Прейскурант на комплектующие для",
    "Прейскурант на запчасти для", "Прейскурант на запасные части для", "Прайс-лист комплектующих для", "Прайс-лист запчастей для", "Прайс-лист запасных частей для",
    "Прейскурант комплектующих для", "Прейскурант запчастей для", "Прейскурант запасных частей для");


// Тип модель
if ($this->_mode == -3 || $this->_mode == -2) {
    // на уровне -3

    $generation = array();
    $generation[0][] = $generation_identical;
    $generation[0][] = array($model_type_rm);
    $generation[0][] = array($marka, $ru_marka, "");
    $generation[1][] = $generation_identical2;
    $generation[1][] = array($model_type_rm);
    $generation[1][] = array($marka, $ru_marka, "");
    $generation[2][] = array("Популярные", "Распространенные", "Часто встречающиеся");
    $generation[2][] = array("модели", $model_type_m, "модели $model_type_rm");
    $generation[2][] = array($marka, $ru_marka, "");

    //$generation_h2_a = $this->checkarray($generation[0]);
    //флаг для первого h2
    $generation_h2_a_temporary = $this->checkcolumn($generation[0][2]);

    if ($generation_h2_a_temporary == $generation[0][2][0]) {
        unset($generation[1][2][0]);
        unset($generation[2][2][0]);
    }
    if ($generation_h2_a_temporary == $generation[0][2][1]) {
        unset($generation[1][2][1]);
        unset($generation[2][2][1]);
    }

    if ($generation_h2_a_temporary == $generation[0][2][2]) {
        unset($generation[1][2][2]);
        unset($generation[2][2][2]);
    }

    $generation_h2_a = $this->checkcolumn($generation[0][0]) . " " . $this->checkcolumn($generation[0][1]) . " " . $generation_h2_a_temporary;
    $generation_h2_2_a_temporary = $this->checkcolumn($generation[1][2]);
    $generation_h2_2_a = $this->checkcolumn($generation[1][0]) . " " . $this->checkcolumn($generation[1][1]) . " " . $generation_h2_2_a_temporary;
    if(isset($generation[1][2][0]))
    {
        if ($generation_h2_2_a_temporary == $generation[1][2][0]) {
            unset($generation[2][2][0]);
        }
    }
    if(isset($generation[1][2][1]))
    {
        if ($generation_h2_2_a_temporary == $generation[1][2][1]) {
        unset($generation[2][2][1]);
    }
    }
    if(isset($generation[1][2][2]))
    {
        if ($generation_h2_2_a_temporary == $generation[1][2][2]) {
            unset($generation[2][2][2]);
        }
    }
    $generation_h2_3_a = $this->checkarray($generation[2]);
}

// на уровне -2
if ($this->_mode == -2) {
    $generation_2 = array();
    $generation_2 [0][] = $generation_identical;
    $generation_2 [0][] = array($model_type_rm);
    $generation_2 [0][] = array("{$this->_datas['model']['name']}", "");
    $generation_2 [1][] = $generation_identical2;
    $generation_2 [1][] = array($model_type_rm);
    $generation_2 [1][] = array("{$this->_datas['model']['name']}", "");

    $generation_h2_model_a_temporary = $this->checkcolumn($generation_2[0][2]);

    if ($generation_h2_model_a_temporary == $generation_2[0][2][0]) {
        unset($generation_2[1][2][0]);
    }
    if ($generation_h2_model_a_temporary == $generation_2[0][2][1]) {
        unset($generation_2[1][2][1]);
    }

    $generation_h2_model_a = $this->checkcolumn($generation_2[0][0]) . " " . $this->checkcolumn($generation_2[0][1]) . " " . $generation_h2_model_a_temporary;

    $generation_h2_model_2_a = $this->checkarray($generation_2[1]);
}

$use_choose_city = $this->_datas['use_choose_city'];
$add_class = ($use_choose_city) ? " js-choose-city" : "";
    if (isset($this->_datas['admin'])){
        echo "<pre>";
        if (!empty($this->_datas['admin'][0])){
        print_r($this->_datas[$this->_datas['admin'][0]]);
        }else print_r($this->_datas);
        echo "</pre>";
    }
?>

    <div class="sr-main target">
        <div class="uk-width-medium-1-1 bgcolorwhite uk-hidden-small breadcrumbs">
            <div class="uk-container-center uk-container">
                <? if ($this->_mode == -2): ?>
                     <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/" class="uk-icon-home uk-text-muted"><meta itemprop="title" content="Главная"/></a></span>
                     &nbsp;/&nbsp;
                     <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/"><span itemprop="title">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?></span></a></span>
                     &nbsp;/&nbsp;
                     <span class="uk-text-muted">Ремонт <?=$this->_datas['model']['name']?></span>
                <? endif; ?>
                <? if ($this->_mode == -3): ?>
                    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/" class="uk-icon-home uk-text-muted"><meta itemprop="title" content="Главная"/></a></span>
                    &nbsp;/&nbsp;
                    <span class="uk-text-muted">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?></span>
                <? endif; ?>
            </div>
        </div>


        <div class="uk-width-medium-1-1 bgcolorwhite uk-visible-small<?=$add_class?>">
            <div class="uk-container-center uk-container">
               <a href="tel:+<?=$phone?>" class="uk-text-muted"><?=$phone_format?></a>
            </div>
        </div>

        <div class="uk-container-center uk-container" itemscope itemtype="http://schema.org/Product">
            <div class="uk-grid uk-margin-remove" data-uk-grid-margin>
                <div class="uk-width-medium-4-10 ">
                    <img itemprop="image" src="/<?=$this->_ret['img']?>" class="uk-margin-top uk-align-center">
                </div>
                <div class="uk-width-medium-6-10 whiteblock ">
                    <h1 itemprop="name"><?=$this->_ret['h1']?></h1>
                    <span itemprop="description">
                    <?
                    if ($this->_mode == -3
                        && $this->_datas['region']['name'] == 'Москва'
                        && $this->_datas['marka']['name'] == 'Huawei'
                        && $this->_datas['model_type'][0]['name'] == 'телефон' && 0) { ?>
                      <p>Сломался телефон? Мы починим! Сервисный центр Huawei предлагает профессиональное обслуживание и ремонт смартфонов. Мы знаем, как исправить самую сложную поломку и наладить работу софта. Ремонтируем технику в кратчайшие сроки, гарантируя отличное качество.</p>
                    <?}
                    else {
                      echo $this->_ret['text'];
                    }
                    ?>
                    </span>
                    <p class="textPrice" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                        <span class="uk-align-left uk-text-large target-price" itemprop="price">от <?=$price?> руб.</span>
                        <meta itemprop="priceCurrency" content="RUB"/>
                        <span class="uk-align-right"><input type="button" data-uk-modal="{target:'#popup'}" class=" uk-button  uk-button-large uk-button-success uk-margin-right" onclick="if (typeof window['yaCounter<?=$metrica?>'] !== 'undefined') yaCounter<?=$metrica?>.reachGoal('ORDER'); return false;" value="Записаться на ремонт"/></span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="sr-content">
        <div class="uk-container-center uk-container uk-margin-bottom">
            <div class="uk-flex sr-contetnt-block uk-margin-top sr-content-main">
                <div class="uk-width-large-7-10 sr-content-white ">
                          <?
                          if ($this->_mode == -3
                              && $this->_datas['region']['name'] == 'Москва'
                              && $this->_datas['marka']['name'] == 'Huawei'
                              && $this->_datas['model_type'][0]['name'] == 'телефон' && 0) { ?>
                            <p style = "display: none;">
                              Мы знаем, как быстро восстановить работу Вашего телефона. У нас работают опытные специалисты и есть высокотехнологичное оборудование, которое позволит починить даже серьезную поломку. Диагностика проводится в сжатые сроки. А это значит, что приступить к ремонту мастер сможет уже через час. Мы предлагаем своим клиентам экспресс-ремонт смартфонов Huawei: забрать технику Вы можете через 24 часа.</p>
                          <? } ?>
                    <p class="uk-h2 uk-margin-top">
                        <? if ($this->_mode == -3)
                        {
                            echo $generation_h2_a;
                        }
                        if ($this->_mode == -2)
                        {
                            echo $generation_h2_model_a;
                        }
                        ?>
                    </p>
                    <table class="priceTable uk-table uk-table-hover uk-table-striped services">
                        <tbody>
                            <tr class="uk-text-small">
                                <th>Наименование услуги</th>
                                <th class="uk-text-center">Время ремонта, мин</th>
                                <th class="uk-text-center">Цена, руб</th>
                            </tr>
                            <? foreach ($all_services as $value): ?>
                            <?
							if ($value['name'] != "Диагностика" && $value['name'] != "Программная диагностика") {
                             if ($this->_mode == -2)
                                $href = tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));

                             if ($this->_mode == -3)
                                $href = tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));
                            ?>

                            <tr>
                                <td><a href="/<?=$href?>/"><?=tools::mb_firstupper($value['name'])?></a></td>
                                <td class="uk-text-center"><?=tools::format_time($value['time_min'], $value['time_max'], $eds[$value[$this->_suffics.'_service_id']]['ed_time'], $setka_name);?></td>
                                <td class="uk-text-center"><?=tools::format_price($value['price'], $setka_name)?></td>
                            </tr>
                            <? } endforeach; ?>
                        </tbody>
                    </table>
                    <? if ($this->_mode == -3
                        && $this->_datas['region']['name'] == 'Москва'
                        && $this->_datas['marka']['name'] == 'Huawei'
                        && $this->_datas['model_type'][0]['name'] == 'телефон' && 0) { ?>
                      <p style = "display: none;">
                        В компании работают курьеры, которые всегда могут забрать сломанный телефон и вернуть клиенту отремонтированный. Наши мастера самостоятельно выезжают на дом или в офис, чтобы на месте провести диагностику и мелкий ремонт телефона Huawei. Диагностика бесплатна, а после оказания услуг клиент получает гарантийный талон. Если в течение гарантийного срока у смартфона возникнет аналогичная поломка, мы починим его бесплатно!
                      </p>
                    <? } ?>
                    <? include __DIR__.'/form_new.php'; ?>
                    <p class="uk-h2 uk-margin-medium-top">
                        <? if ($this->_mode == -3)
                        {
                            echo $generation_h2_2_a;
                        }
                        if ($this->_mode == -2)
                        {
                            echo $generation_h2_model_2_a;
                        }
                        ?>
                    </p>
                    <? if ($this->_mode == -3
                        && $this->_datas['region']['name'] == 'Москва'
                        && $this->_datas['marka']['name'] == 'Huawei'
                        && $this->_datas['model_type'][0]['name'] == 'телефон' && 0) { ?>
                      <p style = "display: none;">
                        Обратившись за помощью к нашим специалистам, клиент получает самое внимательное и чуткое обслуживание. Мы ищем индивидуальный подход к каждой проблеме и помогаем Вам сэкономить на ремонте. Для починки телефонов Huawei мы используем только оригинальные комплектующие от производителя и лицензионный софт. Все детали проходят тестирование, что минимизирует возможность аналогичной поломки. Все цены на услуги и детали указаны в нашем прайс-листе.
                      </p>
                    <? } ?>
                    <table class="priceTable uk-table uk-table-hover uk-table-striped collapsed">
                        <tbody>
                            <tr class="uk-text-small">
                                <th>Наименование оборудования</th>
                                <th class="uk-text-center">Статус</th>
                                <th class="uk-text-center">Цена, руб</th>
                            </tr>

                            <?  $i = 0;
                            foreach ($all_complects as $value): ?>
                            <?
							if ($value['name'] != "Диагностика" && $value['name'] != "Программная диагностика") {
                             if ($this->_mode == -2)
                                $href = tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'complect', 'id' => $value[$this->_suffics.'_complect_id'])));

                            if ($this->_mode == -3)
                                $href = tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'complect', 'id' => $value[$this->_suffics.'_complect_id'])));

                            ?>

                            <tr<?=(($i>9) ? ' class="invs"' : '')?>>
                                <td><a href="/<?=$href?>/"><?=tools::mb_firstupper($value['name'])?></a></td>
                                <td><?=$availables[$value['available_id']]['name']?></td>
                                <td>от <?=tools::format_price($value['price'], $setka_name)?></td>
                            </tr>
                        <?  $i++;
							}
                            endforeach; ?>
                        </tbody>
                    </table>
                    <div class="uk-panel uk-panel-box uk-text-center">
                        <span class="uk-link link-to-all">Показать все комплектующие <i class="uk-icon-caret-down"></i></span>
                    </div>
                    <? if ($this->_mode == -3
                        && $this->_datas['region']['name'] == 'Москва'
                        && $this->_datas['marka']['name'] == 'Huawei'
                        && $this->_datas['model_type'][0]['name'] == 'телефон' && 0) { ?>
                      <p style = "display: none;">
                        Все необходимые детали для смартфонов марки есть на складе. При выявлении типовой неисправности она будет устранена в режиме экспресс-ремонта. Получить консультацию по обслуживанию телефона Huawei Вы всегда можете у наших менеджеров. Мы работаем без выходных и праздников и готовы отвечать на все вопросы по поводу технических особенностей и программного обеспечения смартфонов.
                      </p>
                    <? } ?>
                    <p class="uk-h2 uk-margin-medium-top"><? if ($this->_mode == -3 || $this->_mode == -2) {echo $generation_h2_3_a;}?></p>
                     <? if ($this->_mode == -3 || $this->_mode == -2):?>
                    <div class="uk-grid uk-grid-small uk-grid-match popular collapsed" data-uk-grid-margin="" data-uk-grid-match="{target:'.uk-panel'}" >
                    <?
                    $sql = "SELECT `models`.`name` as `name` FROM `model_to_sites`
                    INNER JOIN `models` ON `models`.`id`=`model_to_sites`.`model_id`
                    INNER JOIN `m_models` ON `m_models`.`id` = `models`.`m_model_id`
                        WHERE `model_to_sites`.`site_id`=:site_id
                        AND `m_models`.`marka_id`=:marka_id AND `m_models`.`model_type_id`=:model_type_id
                                GROUP BY  `models`.`id`
                            ORDER BY RAND('".$this->_datas['feed']."') LIMIT 20";

                    $stm = pdo::getPdo()->prepare($sql);
                    $stm->execute(array('site_id' => $site_id, 'marka_id' => $marka_id, 'model_type_id' => $model_type_id));
                    $data = $stm->fetchAll(\PDO::FETCH_COLUMN);
					
                    foreach ($data as $num => $name)
                    {
						
						$href = '/'.tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id))).'/'.tools::translit($name).'/';
							
						if ($num > 9) {
							echo '<div style="margin-top: 10px;" class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-2 invs"><div class="uk-panel uk-panel-box uk-text-center uk-grid-match uk-vertical-align"><a class="uk-vertical-align-middle" href="'.$href.'">'.$name.'</a></div></div>';
						} else {
							echo '<div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-2"><div class="uk-panel uk-panel-box uk-text-center uk-grid-match uk-vertical-align"><a class="uk-vertical-align-middle" href="'.$href.'">'.$name.'</a></div></div>';	
						}
					}
					
                    ?>
                    </div>
                    <? 
					
					if (count($data) > 10) {
						echo '<div style="margin-top: 10px;" class="uk-width-large-1-1 uk-width-medium-1-1 uk-width-small-1-1 uk-panel uk-panel-box uk-text-center">
								     <span class="uk-link link-to-all">Показать другие модели <i class="uk-icon-caret-down"></i></span>
							     </div>';
					}
					
					endif; ?>
                    <? if ($this->_mode == -3
                        && $this->_datas['region']['name'] == 'Москва'
                        && $this->_datas['marka']['name'] == 'Huawei'
                        && $this->_datas['model_type'][0]['name'] == 'телефон' && 0) { ?>
                      <p style = "display: none;">
                        Китайские смартфоны марки Huawei отличаются высокой производительностью, стильным дизайном, отличным качеством сборки и приятной ценой. Именно поэтому они пользуются таким высоким спросом на мировом рынке. Владельцы таких телефонов знают, что это — высокотехнологичный гаджет, удовлетворяющий все потребности современного человека. У бренда 5 линеек смартфонов и более 70 различных моделей. На нашем складе есть комплектующие и для популярных, и для редких гаджетов Хуавей.
                      </p>
                      <p style = "display: none;">
                        Специалисты нашего сервисного центра знают особенности всех линеек марки и могут починить любую поломку гаджета. Мы меняем треснутые корпуса, заменяем камеры и динамики, восстанавливаем работу тачскрина и прошиваем ПО. Регулярное наличие оригинальных запчастей  для Huawei позволяет нам делать ремонт не только быстрым, но и качественным.
                      </p>
                    <? } ?>
                </div>
                <? include __DIR__.'/right_part_new.php'; ?>
           </div>
       </div>
    </div>
