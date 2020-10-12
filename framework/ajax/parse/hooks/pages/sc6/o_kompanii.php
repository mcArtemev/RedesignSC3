<?php
use framework\tools;
use framework\ajax\parse\hooks\pages\sc6\data\src\helpers6;

$marka = $this->_datas['marka']['name'];  // SONY
$marka_lower = mb_strtolower($marka);
$servicename = $this->_datas['servicename']; //SONY Russia
$ru_servicename = $this->_datas['ru_servicename']; //
$ru_marka = $this->_datas['marka']['ru_name']; // СОНИ

$feed = $this->_datas['feed'];

$region_name = $this->_datas['region']['name'];//Москва
$region_name_eng = $this->_datas['region']['translit2'];//Moscow
$region_name_pril = $this->_datas['region']['pril'];//Московского
$region_name_pe = $this->_datas['region']['name_pe'];//в Москве (в Владивостоке)
$region_name_de = $this->_datas['region']['name_de'];//по Москве (Владивостоку)
$region_name_re = $this->_datas['region']['name_re'];//служба Москвы (Владивостока)
$phone = $this->_datas['phone'];
$phone_format = tools::format_phone($phone);

srand($feed);

$_month = [
    1 => 'Январь', 2 => 'Февраль', 3 => 'Март', 4 => 'Апрель',
    5 => 'Май', 6 => 'Июнь', 7 => 'Июль', 8 => 'Август',
    9 => 'Сентябрь', 10 => 'Октябрь', 11 => 'Ноябрь', 0 => 'Декабрь',
    12 => 'Декабрь'
];

$y = date('Y');
$m = date('n')-1;

$month = [];

$minCount = 280;
$maxCount = 420;

$percentHeight = ($maxCount)/(95);

for ($i = $m-5; $i <= $m; $i++) {
  $n = ($i+12)%12;
  srand($this->_datas['site_id']+$y+$i);
  $count = rand($minCount, $maxCount)-rand(1,5);
  $month[$n] = [
    'count' => $count,
    'height' => (ceil(($count)/$percentHeight)),
  ];
}

$p1 = [
  ['В '.$region_name_pe],
  ['десятки','большое количество','много'],
  ['мастерских,','сервис-центров,'],
  ['оказывающих','предоставляющих'],
  ['услуги по'],
  ['ремонту','починке'],
  ['электроники.'],

  ['Почему Вам стоит выбрать именно наш'],
  ['сервисный центр?','сервис-центр?'],

  ['Мы'],
  ['предлагаем','предоставляем'],
  ['клиентам','заказчикам'],
  ['основные преимущества:'],
];

$ps = [
  [
    ['выгодные','доступные'],
    ['цены']
  ],
  [
    ['запись'],
    ['в режиме онлайн', 'онлайн'],
  ],
  [
    ['оригинальные'],
    ['комплектующие','детали']
  ],
  [
    ['сжатые','минимальные'],
    ['сроки'],
    ['проведения','выполнения'],
    ['ремонта']
  ],
  [
    ['гарантию на'],
    ['выполненную','проведенную','сделанную'],
    ['работу и установленные'],
    ['детали','запчасти'],
  ],
  [
    ['возможность вызвать курьера для доставки неисправной техники в'],
    ['сервисный центр','мастерскую','сервис-центр'],
    ['и обратно'],
    ['заказчику','клиенту'],
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

$bk = ['быстро','качественно'];
helpers6::shuffle($bk, 0, $feed);

$p1 = array_merge($p1, [
  ['Если Вам','Когда Вам'],
  ['необходим','нужен'],
  ['надежный','проверенный'],
  ['партнер, который ремонтирует технику'],
  [$bk[0].' и '.$bk[1].','],
  ['обратитесь','обращайтесь'],
  ['в наш'],
  ['сервисный центр!','сервис-центр!'],
]);
$p1 = self::_createTree($p1, $feed);

$accord_url = array();
$typeList = array_column($this->_datas['all_devices'], 'type_rm');

foreach ($this->_datas['all_devices'] as $value)
{
    $accord_url[$value['type_rm']] = $this->_datas['types_urls'][$value['type']];    
}

helpers6::shuffle($typeList, 0, $feed);
foreach ($typeList as $i => $t)
    $typeList[$i] = '<a href="/'.$accord_url[$t].'/">'.$t.'</a>'; 
       
$typeList = implode(', ', $typeList).'.';

$p2 = [
  ['Квалифицированные','Опытные'],
  ['мастера','инженеры','специалисты'],
  ['в'],
  ['кратчайший','минимальный'],
  ['срок'],
  ['проведут','осуществят'],
  ['диагностику и'],
  ['оперативно','быстро'],
  ['устранят','отремонтируют'],
  ['неисправность'],
  ['любой','не зависимо от'],
  ['сложности.'],

  ['Наш сервисный центр специализируется на'],
  ['ремонте','починке'],
  ['различных','разных'],
  ['видов'],
  ['техники:','устройств:'],
  $typeList,

  ['Преимущество','Достоинство'],
  ['нашего'],
  ['сервисного центра','сервис-центра'],
  ['в том, что'],
  ['работы','работу','ремонт'],
  ['выполняют','осуществляют'],
  ['дипломированные'],
  ['специалисты','мастера','инженеры'],
  ['со стажем','с опытом'],
  ['не менее 2 лет.'],

  ['Доверьте','Поручите'],
  ['ремонт','работу'],
  ['профессионалам!','нашим профессионалам!'],
];
$p2 = self::_createTree($p2, $feed);

$block_chisel = array();

$block_chisel[0][] = array("Свободных операторов","Свободных диспетчеров","Операторов call-центра","Диспетчеров call-центра","Операторов колл-центра","Диспетчеров колл-центра");
$block_chisel[0][] = array(rand(2,5));
$block_chisel[1][] = array("Заказов в работе","Устройств в работе","Аппаратов в работе","Устройств в ремонте","Аппаратов в ремонте","Устройств в лаборатории",
    "Аппаратов в лаборатории","Ремонтируется устройств","Ремонтируется аппаратов");
$block_chisel[1][] = array(rand(11,37));
$block_chisel[2][] = array("Всего инженеров","Сервисных инженеров","Мастеров","Мастеров по ремонту","Сервисных мастеров","Ремонтных мастеров");
$block_chisel[2][] = array(rand(8,14));
$block_chisel[3][] = array("Отремонтировано устройств","Отремонтировано аппаратов","Отремонтировано техники","Починили устройств","Починили аппаратов","Починили техники");
$block_chisel[3][] = array(rand(4500,15500));

?>

<?php helpers6::breadcrumbs([
 ['/', 'Главная'],
  [0, 'О компании'],
]); ?>

<main>
    <section class="about-company">
        <div class="container">
            <div class="part_header">
                <h1 class="part-title part-title__center part-title__bold" style="font-size: 30px">О компании</h1>
            </div>
        <noindex>

            <p class="part-txt"><?=$p1?></p>
			
			<div class="section-about">
				<div class="container">
					<div class="row section-about__inner">
						<div class="col-md-3 col-sm-3 text-center section-about__item">
							<p><?=$this->checkcolumn($block_chisel[0][0])?></p>
							<span class="count-detail"><?=$this->checkcolumn($block_chisel[0][1])?></span>
						</div>
						<div class="col-md-3 col-sm-3 text-center section-about__item">
							<p><?=$this->checkcolumn($block_chisel[1][0])?></p>
							<span class="count-detail"><?=$this->checkcolumn($block_chisel[1][1])?></span>
						</div>
						<div class="col-md-3 col-sm-3 text-center section-about__item">
							<p><?=$this->checkcolumn($block_chisel[2][0])?></p>
							<span class="count-detail"><?=$this->checkcolumn($block_chisel[2][1])?></span>
						</div>
						<div class="col-md-3 col-sm-3 text-center section-about__item">
							<p><?=$this->checkcolumn($block_chisel[3][0])?></p>
							<span class="count-detail"><?=$this->checkcolumn($block_chisel[3][1])?></span>
						</div>
					</div>
				</div>
			</div>

			
            <section class="part-4">
              <div class="container">
                <div class="chart-repaired">
                  <h3>Сколько мы починили устройств за последние пол года?</h3>
                  <ul class="chart-repaired__inner">
                    <?php foreach ($month as $mNum => $m) { ?>
                      <li class="chart-repaired__item">
                        <p class="chart-month"><?=$_month[$mNum]?></p>
                        <div class="chart-share" style = "height: <?=$m['height']?>%;">
                          <span><?=$m['count']?></span>
                        </div>
                      </li>
                    <?php } ?>
                  </ul>
                </div>

                <p class="part-txt"><?=$p2?></p>
				
              </div>
            </section>	
            
            <?php /*<div class="certificate-list">
                <h3>Наши сертификаты</h3>
                <div class="certificate-list__inner">
                    <div class="certificate-list__item">
                        <div class="certificate-img certificate-img__1">
                            <img src="/_mod_files/_img/certificate-1.jpg" alt="">
                        </div>
                    </div>
                    <div class="certificate-list__item">
                        <div class="certificate-img certificate-img__2">
                            <img src="/_mod_files/_img/certificate-2.jpg" alt="">
                        </div>
                    </div>
                    <div class="certificate-list__item">
                        <div class="certificate-img certificate-img__3">
                            <img src="/_mod_files/_img/certificate-3.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>*/ ?>


        </noindex>


        </div>
		
    </section>
    <div class="about_comp_no_div" >
                <img src="../_mod_files/_img/no_name.jpg" >
    </div>

    <?php srand($this->_datas['feed']); include 'preference.php'; ?>


</main>
