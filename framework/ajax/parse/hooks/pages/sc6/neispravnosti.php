<?php
use framework\tools;

use framework\ajax\parse\hooks\pages\sc6\data\src\defect_service;
use framework\ajax\parse\hooks\pages\sc6\data\src\helpers6;


$marka = $this->_datas['marka']['name'];  // SONY

$feed = $this->_datas['feed'];

$types = [];

foreach ($this->_datas['all_devices'] as $type) {
  $types[$type['type']] = defect_service::getForType($type['type'], $this->_datas['site_id']);
}

helpers6::skShuffle($types, 0, $this->_datas['site_id']);

$bt = ['бытовой техники', 'электроники'];
helpers6::shuffle($bt, 0, $feed);

$p1 = [
  ['Ни один'],
  ['производитель','разработчик'],
  ['не может'],
  ['гарантировать','обещать'],
  ['безотказную','беcперебойную'],
  ['работу'],
  [$bt[0].' и '.$bt[1].'.'],

  ['Обычно','Как правило'],
  ['неисправности','поломки'],
  ['возникают','появляются'],
  ['по причине:']
];

$ps = [
  [
    ['нарушения правил'],
    ['эксплуатации','использования'],
  ],
  [
    ['использования'],
    ['неоригинальных','некачественных'],
    ['комплектующих','деталей'],
  ],
  [
    ['неквалифицированного','непрофессионального'],
    ['вмешательства']
  ],
  [
    ['неправильного'],
    ['подключения','включения'],
  ],
  [
    ['заражения вирусами операционной системы'],
    ['устройства','гаджета'],
  ],
];
helpers6::shuffle($ps, 0, $feed);

$last = count($ps)-1;
foreach ($ps as $k=>$v) {
  $lastK = count($v)-1;
  foreach ($ps[$k][$lastK] as $j => $e) {
    $ps[$k][$lastK][$j] = $e.($last == $k ? '.' : ';');
  }
  $p1 = array_merge($p1, $ps[$k]);
}
$p1 = self::_createTree($p1, $feed);

$ap = ['аппаратные', 'программные'];
helpers6::shuffle($ap, 0, $feed);

$p2 = [
  ['Вышеперечисленные','Перечисленные'],
  ['причины'],
  ['приводят к полной','служат источником полной'],
  ['или частичной'],
  ['потери','утраты'],
  ['работоспособности.'],

  ['В нашем','У нас в'],
  ['сервисном центре','мастерской'],
  ['работают дипломированные'],
  ['инженеры','специалисты'],
  ['со стажем от 2 лет – благодаря высокой квалификации'],
  ['специалисты','инженеры'],
  ['в'],
  ['кратчайший','минимальный'],
  ['срок'],
  ['устраняют','исправят'],
  [$ap[0].' и '.$ap[1]],
  ['неисправности','поломки'],
  ['различной','разной'],
  ['степени'],
  ['сложности.','трудности.'],

  ['Доверьте','Доверяйте'],
  ['ремонт','проведение ремонта'],
  ['техники','устройств'],
  ['профессионалам','специалистам'],
  ['своего дела!']
];
$p2 = self::_createTree($p2, $feed);

?>

<?php helpers6::breadcrumbs([
	['/', 'Главная'],
  [0, 'Неисправности'],
]); ?>

<? 
$text = require_once ('data/text/defects.php');
 if ($this->_datas['marka']['name'] == 'Brandt' && $this->_datas['region']['name']=='Москва'){
 }
?>
<?
  // if ($this->_datas['site_id'] == 37127){

  //     //print_r($this->_datas);
  //   print_r($types);
  // }
  ?>
  
<style type="text/css">
  .accessories-list__item ul li a:hover{
    color: #696969;
  }
  .accessories-list__item ul li a{
    color: #000000;
  }
</style>

<main>
    <section class="section-malfunction">
        <div class="container">
            <div class="part_header">
                <h1 class="part-title part-title__center part-title__bold" style="font-size: 30px">Неисправности устройств <?=$marka?></h1>
            </div>
                <p class="part-txt"><?=$p1?></p>
                
                <div class="accessories-list">
                    <?php         
          foreach ($types as $typeName => $typeDefect) {            
                      if (count($typeDefect)) { ?>
                    <div class="accessories-list__item">
                        <h2><?=$this->firstup($typeName)?></h2>
                        <ul>
                          <?php foreach ($typeDefect as $defect) { 

                    if (!empty($defect['url'])){

              ?>
                            <li>
                                <a href = "<?=defect_service::fullUrl($defect['type'], $defect['url'])?>"><?=$this->firstup($defect['name'])?></a>
                                <?//=$this->firstup($defect['name'])?>
                            </li>
              <?php } else {
                ?>
                             <li>
                                <a><?=$this->firstup($defect['name'])?></a>
                            </li>               
            <?
              }} ?>
                        </ul>
                    </div>
                    <?php }}?>
                </div>
        
        <p class="part-txt"><?=$p2?></p>

        </div>
    </section>
</main>