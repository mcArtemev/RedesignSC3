<?php
use framework\tools;
use framework\pdo;

use framework\ajax\parse\hooks\pages\sc6\data\src\service_service;
use framework\ajax\parse\hooks\pages\sc6\data\src\helpers6;

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




$all_deall_devices = $this->_datas['all_devices'];

srand($this->_datas['feed']);

$types = [];

foreach ($this->_datas['all_devices'] as $type) {
  $types[$type['type']] = [
    'code' => service_service::TYPES_TR_NAME[$type['type']],
    'names' => $type,
    'services' => service_service::getForType($type['type'], $this->_datas['site_id']),
  ];
}

?>


<?php helpers6::breadcrumbs([
	['/', 'Главная'],
  [0, 'Цены'],
]); 
?>

<main>

    <section class="price-block">
        <div class="part_header">
            <h1 class="part-title part-title__center part-title__bold" style="font-size: 30px">Цены на ремонт в сервисном центре <?=$marka?></h1>
        </div>
        
        <div class="container">
            <div class="popular-services__inner">
                <ul class="nav nav-tabs nav-tabs-custom owl-carousel " role="tablist" style="overflow: hidden; font-size: 40px;">
                <?
                  $firstType = true;
                  foreach ($types as $typeName => $type) {
                  if (count($type['services'])) {
                ?>
                <div>
                    <li class="nav-item <?php if ($firstType) {?>active<?php } ?>">
                    <a class="nav-link" href="#<?=$type['code']?>" role="tab" data-toggle="tab" <?php if ($firstType) { $firstType = false;?>aria-expanded="true"<?php } ?>>
                        <?=tools::mb_ucfirst($type['names']['type_m'])?>
                    </a>
                    </li>
                </div>
                <?
                  }
                  }
                  unset($firstType);
                ?>
              </ul>
              <div class="tab-content tab-content-custom">
                  <?
                  $firstType = true;
                  foreach ($types as $typeName => $type) {
                  if (count($type['services'])) { ?>
                  <div role="tabpanel" class="tab-pane fade<?php if ($firstType) { $firstType = false; ?>in active<?php } ?>" id="<?=$type['code']?>">
                      <?php
                        $services = $type['services'];
                        include 'data/inc/tablePrice.php';
                      ?>
                  </div>
                  <?
                }}
                  unset($firstType);?>
              </div>
                <noindex><p style="font-weight: 300;">Цены указаны за работу специалиста без учета стоимости запчастей.<br/>Стоимость диагностики составляет 500 рублей. В случае проведения ремонтных работ диагностика в подарок.<br> В таблице указано среднее время оказания услуги при условии наличия необходимой для ремонта комплектующей.</p></noindex>
            </div>
        </div>
    </section>

    <?php srand($this->_datas['feed']); include 'preference.php'; ?>
</main>
<script>

  $(document).ready(function() {
    if (location.hash.indexOf('#to-') === 0) {
      var hash = '#'+location.hash.split('-')[1];
      var tab = $(".nav-item a[href='"+hash+"']");

      if (tab.length > 0) {
        tab.click();
      }

      $(window).on("load", function() {
        if (tab.length > 0) {
          var top = $("main").offset().top;
          $("html, body").animate({scrollTop: top}, 500);
        }
      });
    }
  });

</script>
