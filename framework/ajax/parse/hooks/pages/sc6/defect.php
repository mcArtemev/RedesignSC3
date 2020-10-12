<?php

use \framework\tools;

use framework\ajax\parse\hooks\pages\sc6\data\src\model_service;
use framework\ajax\parse\hooks\pages\sc6\data\src\service_service;
use framework\ajax\parse\hooks\pages\sc6\data\src\helpers6;

$defect = $this->_datas['defect'];
$models = model_service::getForTypeMark($this->_datas['model_type']['id'], $this->_datas['marka']['id'], $this->_datas['site_id']);

?>

<?php helpers6::breadcrumbs([
	['/', 'Главная'],
  [$this->_datas['types_urls'][$this->_datas['model_type']['name']], 'Ремонт '.$this->_datas['model_type']['name_rm']],
	[0, tools::mb_ucfirst(tools::get_rand($defect['names'], $this->_datas['feed']))],
]);

$text = require_once 'data/text/defects.php';
$text = $text[$this->_datas['model_type']['name']][mb_strtolower($defect['name'])];

?>

<main class="page-main">

	<section class="part">
		<div class="container">
			<header class="part-header">
				<h1 class="part-title__left"><?=$this->_ret['h1']?></h1>
			</header>
      <div class="row">
				<div class="col-md-7 col-sm-7 ">
					<?=helpers6::renderText($text[0], ['[brand]' => $this->_datas['marka']['name']])?>
					<div class="block-select">
						<?php include 'data/inc/selectModel.php'; ?>
					</div>
				</div>
				<div class="col-md-4 col-md-offset-1 col-sm-5">
					<?php include 'data/inc/form.php'; ?>
				</div>
			</div>
		</div>
	</section>


	<section class="part2">
		<div class="container">
			<? for($i = 1; $i < count($text); $i++) {
				echo helpers6::renderText($text[$i], ['[бренд]' => $this->_datas['marka']['name']]);
			} ?>
      <?/*<div class="row">
				<div class="col-md-6 col-sm-6 ">
          <div class="cause-problem">
          <h3>Возможные причины данной неисправности:</h3>
          <ul class="cause-problem__inner">
            <li>
              Нарушение работы чипов материнской платы
            </li>
            <li>
              Повреждение цепи питания
            </li>
            <li>
              Попадание жидкости на поверхность платы и разъемы
            </li>
            <li>
              Механическое повреждение при ударе
            </li>
          </ul>
        </div>
        </div>
        <div class="col-md-6 col-sm-6 ">
          <div class="block-select">
            <?php include 'data/inc/selectModel.php'; ?>
          </div>
        </div>
      </div>*/ ?>
    </div>
  </section>
  <?php if (count($models) != 0) { ?>
	<section class="part">
		<div class="container">
			<h2>С этой проблемой чаще всего обращаются владельцы моделей</h2>
			<div class="row dell-box">
				<?php foreach(array_slice($models, 0, 4) as $model) {
					$urlModel = '/'.$this->_datas['types_urls'][$this->_datas['model_type']['name']].'/'.model_service::renderUrl($model['name']).'/';
					$img = '/_mod_files/_img/models/'.service_service::TYPES_TR_NAME[$this->_datas['model_type']['name']].'/'.
					mb_strtolower($this->_datas['marka']['name']).'/'.model_service::renderUrl($model['name']).'.jpg';
					?>
				<div class="col-md-3 col-sm-6 dell-box__item">
					<div class="dell-price">
					  <div class="dell-price__img">
					    <img src="<?=$img?>" alt="">
					  </div>
					  <div class="dell-price__title text-left">
					    <a href="<?=$urlModel?>"><?=$this->_datas['marka']['name'].' '.$model['name']?></a>
					  </div>
					</div>
				</div>
			<?php }  ?>
			</div>
		</div>
	</section>
  <?php } ?>
  <?php include 'defect_relink.php'; ?>
</main>
