<?
use framework\tools;
use framework\pdo;

$marka = $this->_datas['marka']['name'];
$marka_lower = mb_strtolower($marka);
$_marka_lower = tools::translit($marka, '_');

$accord = array('смартфон' => 'telefonov', 'ноутбук' => 'noutbukov', 'планшет' => 'planshetov');

$this->_datas['brands'] = $brands = ["Acer", "Apple", "Asus", "Dell", "HP", "HTC", "Huawei", "Lenovo", "Meizu", "Samsung", "Sony", "Toshiba", "Xiaomi"];
$brandList = "'".implode('\',\'', $brands)."'";


if (in_array($this->_datas['region']['name'], ['Новосибирск', 'Нижний Новгород', 'Екатеринбург', 'Казань', 'Санкт-Петербург', 'Москва'])) {
  $typesId = implode(',', array_column($this->_datas['all_devices_site'], 'type_id'));
  $stmt = pdo::getPdo()->query("SELECT m_models.model_type_id, GROUP_CONCAT(DISTINCT markas.name ORDER BY markas.name ASC SEPARATOR ',') FROM `m_models` JOIN markas ON m_models.marka_id = markas.id WHERE m_models.model_type_id IN (".$typesId.") AND markas.name IN ($brandList) GROUP BY m_models.model_type_id");
  $this->_datas['typeMarkas'] = [];
  foreach ($stmt->fetchAll() as $item) {
    $this->_datas['typeMarkas'][$item[0]] = explode(',', $item[1]);
  }
  $typeMarkas = $this->_datas['typeMarkas'];
}

$url = ($this->_datas['arg_url'] != '/') ? '/'.$this->_datas['arg_url'].'/' : '/';
$time = ($this->_datas['partner']['time']) ? $this->_datas['partner']['time'] : 'пн-вс: 10:00 - 20:00';
$analytics = $this->_datas['analytics'];

$urlHome = in_array($url, ['/o_nas/', '/kontakty/', '/vakansii/', '/dostavka/']) ? '/' : '/'.$marka_lower.'/';

?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title><?=$this->_ret['title']?></title>
        <meta name="description" content="<?=$this->_ret['description']?>"/>
        <meta name="format-detection" content="telephone=no"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="/templates/moscow/img/<?=$marka_lower?>/favicon.ico" />
        <link href="/min/f=/templates/moscow/css/font-awesome.min.css,/templates/moscow/css/styles.css&123456" rel="stylesheet" type="text/css">

        <? if ($analytics):?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?=$analytics?>"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', '<?=$analytics?>');
        </script>
        <?endif;?>
    </head>
    <body>
        <div class="header-row">
            <div class="toprow">
                <div class="container">
                    <? if ($url != $urlHome) :?>
                        <a class="logo" href="<?=$urlHome?>"><img src="/templates/moscow/img/<?=$marka_lower?>/logo<?=(($this->_datas['region']['code'] ? '-'.$this->_datas['region']['code'] : ''))?>.png"></a>
                    <?else:?>
                        <span class="logo"><img src="/templates/moscow/img/<?=$marka_lower?>/logo<?=(($this->_datas['region']['code'] ? '-'.$this->_datas['region']['code'] : ''))?>.png"></span>
                    <?endif;?>
                    <div class="logoname">Сервисный центр по ремонту<?=(!in_array($url, ['/o_nas/', '/kontakty/', '/vakansii/', '/dostavka/']) ? ' '.$marka : '')?> в <?=$this->_datas['region']['name_pe']?></div>
                    <div class="worktime">
                        <a href="tel:+<?=$this->_datas['phone']?>" class="phone"><i class="fa fa-phone"></i><span class="mango-phone">
                                    <?=tools::format_phone($this->_datas['phone'])?></span></a>
                        <div class="time">график работы: <?=$time?></div>
                    </div>
                    <button class = "btnred callBackBtn">Обратный звонок</button>
                </div>
            </div>
            <?php if (in_array($this->_datas['region']['name'], ['Новосибирск', 'Нижний Новгород', 'Екатеринбург', 'Казань', 'Санкт-Петербург', 'Москва'])) { ?>
              <div class="navrow">
                  <div class="container">
                      <i class="mobile-menu fa fa-bars"></i>
                      <ul class="topmenu">
                          <?  if ($url == $urlHome)
                                  echo '<li class="selected"><span>Главная</span></li>';
                              else
                                  echo '<li><a href="'.$urlHome.'">Главная</a></li>';

                            unset($this->_datas['menu_header']['/ceny/']); ?>
                            <?php foreach ($this->_datas['all_devices_site'] as $type) { ?>
                          <li>
                              <a href="#" class="sb"><?=tools::mb_ucfirst($type['type_m'])?></a>
                              <ul class="submenu submenuBrand">
                              <? foreach ($typeMarkas[$type['type_id']] as $brand):
                                  $s_path = '/remont_'.$accord[$type['type']].'_'.mb_strtolower($brand).'/';
                                  if ($url == $s_path)
                                      echo '<li class="selected"><span>'.$brand.'</span></li>';
                                  else
                                      echo '<li><a href="'.$s_path.'">'.$brand.'</a></li>';
                                  endforeach; ?>
                              </ul>
                          </li>
                        <?php } ?>
                          <li>
                              <a href="#" class="sb">Цены</a>
                              <ul class="submenu submenuBrand">
                              <? foreach ($brands as $brand):
                                  $s_path = '/'.mb_strtolower($brand).'/ceny/';
                                  if ($url == $s_path)
                                      echo '<li class="selected"><span>'.$brand.'</span></li>';
                                  else
                                      echo '<li><a href="'.$s_path.'">'.$brand.'</a></li>';
                                  endforeach; ?>
                              </ul>
                          </li>
                          <? foreach ($this->_datas['menu_header'] as $key => $value):
                                  if ($url == $key)
                                      echo '<li class="selected"><span>'.$value.'</span></li>';
                                  else
                                      echo '<li><a href="'.$key.'">'.$value.'</a></li>';
                          endforeach; ?>
                      </ul>
                  </div>
              </div>
            <?php } else { ?>
            <div class="navrow">
                <div class="container">
                    <i class="mobile-menu fa fa-bars"></i>
                    <ul class="topmenu">
                        <?  if ($url == '/')
                                echo '<li class="selected"><span>Главная</span></li>';
                            else
                                echo '<li><a href="/">Главная</a></li>'; ?>
                        <li>
                            <a href="#" class="sb">услуги</a>
                            <ul class="submenu">
                            <? foreach ($this->_datas['all_devices'] as $device):
                                $s_path = '/remont_'.$accord[$device['type']].'_'.$_marka_lower.'/';
                                if ($url == $s_path)
                                    echo '<li class="selected"><span>Ремонт '.$device['type_rm'].'</span></li>';
                                else
                                    echo '<li><a href="'.$s_path.'">Ремонт '.$device['type_rm'].'</a></li>';
                                endforeach; ?>
                            </ul>
                        </li>
                        <? foreach ($this->_datas['menu_header'] as $key => $value):
                                if ($url == $key)
                                    echo '<li class="selected"><span>'.$value.'</span></li>';
                                else
                                    echo '<li><a href="'.$key.'">'.$value.'</a></li>';
                        endforeach; ?>
                    </ul>
                </div>
            </div>
          <?php } ?>
        </div>
