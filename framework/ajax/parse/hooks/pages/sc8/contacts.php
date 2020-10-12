<?

use framework\tools;
$time = ($this->_datas['partner']['time']) ? tools::mb_ucfirst($this->_datas['partner']['time'], 'utf-8', false) : 'Пн-Вс: 10:00-20:00';
$city = $this->_datas['region']['name'];
$addr_index = $this->_datas['partner']['index'];
$address = $this->_datas['partner']['address1'];
$x = $this->_datas['partner']['x'];
$y = $this->_datas['partner']['y'];
$phone = tools::format_phone($this->_datas['phone']);
$email = "info@" . $this->_datas['site_name'];
$servisename = $this->_datas['servicename'];
$zoom = $this->_datas['zoom'];

?>
<header class="secondary main_block">
    <div class="container">
        <ul class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <a itemprop="name" href="/">Главная</a>
                <meta itemprop="position" content="1" />
            </li>
            <li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <span itemprop="name">Контакты</span>
                <meta itemprop="position" content="2" />
            </li>
        </ul>
        <div class="row">
            <div class="col-sm-12">
                <h1><?= $this->_ret['h1'] ?></h1>
                <!--<a href="/"><p class="back-home">Вернуться на главную страницу</p></a>-->
            </div>
        </div>
    </div>
</header>

    <div class="main-content contacts-page vcard" itemscope itemtype="http://schema.org/Organization">
        <div class="hidden">
            <span class="category">Сервисный центр</span>
            <span class="fn org" itemprop="name"><?= $servisename; ?></span>
            <div class="adr" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                <span itemprop="postalCode">141070</span>
                <span class="locality" itemprop="addressLocality">г. Москва, </span>,
                <span class="street-address" itemprop="streetAddress">ул Мясницкая д 20</span>
            </div>
        </div>

      <div class="container">
        <div class="row">
          <div class="col-sm-3">
            <p>Время работы:</p>
            <p><span class="workhours"><?= $time; ?></span></p>
          </div>
          <div class="col-sm-3">
            <p>Телефон горячей линии:</p>
            <p><span class="tel" itemprop="telephone"><a href="tel:+<?=$phone; ?>">+<?= $phone; ?></a></span></p>
          </div>
          <div class="col-sm-3">
            <p>По вопросам обслуживания:</p>
            <p><span class="email" itemprop="email"><a href="mailto:<?=$email; ?>"><?= $email; ?></a></span></p>
          </div>
          <div class="col-sm-3 text-right">
            <a href="#" class="btn btn-gr btn-contact scroll-btn">Записаться на ремонт</a>
          </div>
        </div>
      </div>
    </div>

    <div id="map" data-zoom=<?= $zoom; ?> data-phone="<?= $phone; ?>"   data-servise="<?= $servisename; ?>"  data-email="<?= $email; ?>" data-city="<?= $city; ?>" data-index="<?= $addr_index; ?>" data-address="<?=(!$this->_datas['partner']['exclude']) ? $address : 'no_info' ?>" data-format="<?=(!$this->_datas['partner']['exclude']) ? 'show' : 'hide' ?>" data-x="<?= $x; ?>" data-y="<?= $y; ?>"></div>
    
    <?//if ($city == 'Москва'):?>
        <!--<div class="container">
            <p style="margin-top: 20px;">От м.Фрунзенская или м.Парк Культуры по дублеру Комсомольского проспекта. Вход в сервис со стороны двора. Пешком - 5 минут от метро.</p>
        </div>-->
    <?//endif;?>