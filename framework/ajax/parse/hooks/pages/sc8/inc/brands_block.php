<?php
use framework\tools;
use framework\rand_it;
//echo '<div style="display:none">'.print_r($this->_datas, true).'</div>';
$brandsName = isset($brandsName ) ? $brandsName : $this->brands;

$salesBrands = array_column($this->_datas['brands_special'], 0);

$brandsAll = array();
foreach ($brandsName as $brand) {
    srand(tools::gen_feed($brand . $this->_datas['region']['geo_region'] . $this->_datas['region']['translit1']));
    $brandsAll[mb_strtolower($brand)]['name'] = $brand;
    if (in_array($brand, $salesBrands))
        $brandsAll[mb_strtolower($brand)]['sale'] = round(rand(5, 30) / 5) * 5;
}

ksort($brandsAll);

// slice brand to 5 + 6 + 5 for render by design
$brandsSliced = array();

if ('/' === $this->_datas['arg_url']) {
    $brandsSliced[] = array_slice($brandsAll, 0, 5);
    $brandsSliced[] = array_slice($brandsAll, 5, 6);
    $brandsSliced[] = array_slice($brandsAll, 11, 5);
} else {
    $brandsSliced[] = $brandsAll;
}
?>
<div class="content brand-content">
    <div class="container">
		<div class="row brendh2">
			<h2>Выберите бренд</h2>
		</div>
		<div class="brend_imgs">
			<div class="row">
				<?php $temp_item = 0; ?>
				<?php foreach ($brandsSliced as $k => $brandsSlice) :; ?>
				<?php foreach ($brandsSlice as $key => $brand) :; ?>
					<div class="col-sm-2 col-xs-6 <?= ($temp_item === 0 || $temp_item === 11) && '/' === $this->_datas['arg_url'] ? 'col-sm-offset-1' : ''; ?>">
						<a href="/<?= isset($dev_type_name) ? strtolower($key) . '/' . $dev_type_name . '-service' : strtolower($key); ?>/">
							<div class="brand-logo-sm">
								<div class="logo__inner"
									 style="background-image: url(/custom/saapservice/img/brands/<?= $key; ?>-logo.png);"></div>
								<?php if (!empty($brand['sale'])) :; ?>
									<span class="discount"><?= $brand['sale']; ?>%</span>
								<?php endif; ?>
							</div>
						</a>
					</div>
					<?php $temp_item++; ?>
				<?php endforeach; ?>
				<?php if ($k < 2) :; ?>
			</div>
			<div class="row">
				<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="brend_lis">
			<div class="row">
				<?php $temp_item = 0; ?>
				<?php foreach ($brandsSliced as $k => $brandsSlice) :; ?>
				<?php foreach ($brandsSlice as $key => $brand) :; ?>
					<a href="/<?= isset($dev_type_name) ? strtolower($key) . '/' . $dev_type_name . '-service' : strtolower($key); ?>/">
						<?=$key?>
					</a>
					<?php $temp_item++; ?>
				<?php endforeach; ?>
				<?php if ($k < 2) :; ?>
			</div>
			<div class="row">
				<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
    </div>
</div>