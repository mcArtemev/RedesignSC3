<?php

use framework\tools;
use framework\rand_it;
use framework\ajax\parse\hooks\sc;

$mesh = array();
if (isset($this->_datas['orig_model_type'][0]['name'])) {
	if (($handle = fopen(__DIR__ . "/../data/malfunctions.csv", "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ';')) !== FALSE) {
			if ($data[0] != "Модель") {
				if (mb_strtolower($data[3]) == mb_strtolower($this->_datas['orig_model_type'][0]['name'])) {
					$mesh[] = [
						"problem" => tools::mb_ucfirst($data[0]),
						"desc"    => tools::mb_ucfirst($data[1]),
						"price"   => $data[2]
					];
				}
			}
		}
		fclose($handle);
	}
}

if (count($mesh) > 0) {
	while ((count($mesh) % 3) != 0 && count($mesh) > 0) {
		unset($mesh[count($mesh)-1]);
	}
?>
<div class="content brand-content mal_mesh" style="background-color: #fff;">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h2 style="text-align: center;">Ремонтируем любые неисправности</h2>
            </div>
        </div>
        <div class="row">
            <ul class="listd">   
				<?php foreach($mesh as $value) { ?>
				<li>                    
					<div class="name"><?=$value['problem']?></div>
					<div class="description hidden-sm hidden-xs"><?=$value['desc']?></div>
					<div class="opacity">Стоимость от <?=$value['price']?> руб</div>
					<a class="opacity btn btn-gr tabbut" data-toggle="modal" data-target="#getPrice">Записаться на ремонт</a>
				</li>
				<?php } ?>
			</ul>
		</div>
    </div>
</div>
<? } ?>