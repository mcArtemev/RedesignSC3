<?

use framework\pdo;

include __DIR__.'/data/exclude_model.php';

if(!empty($this->_datas['orig_model_type'][0]['name_rm'])){ 
 $model_type_name_rm = $this->_datas['orig_model_type'][0]['name_rm'];
}

srand($this->_datas['feed']);

if(!empty($model_type_id)){
    $stmt = pdo::getPdo()->prepare("SELECT m_models2.name
    FROM m_models2
    JOIN m_models2_to_setka ON m_models2.id = m_models2_to_setka.m_model_id
    WHERE m_models2_to_setka.setka_id = 7 AND m_models2.model_type_id = ? AND m_models2.marka_id = ?");
    $stmt->execute([$model_type_id, $marka_id]);
    $m_models = $stmt->fetchAll(\PDO::FETCH_ASSOC);


    shuffle($m_models); 
    
    $stmt = pdo::getPdo()->prepare("SELECT models2.name
    FROM models2
    JOIN models2_to_setka ON models2.id = models2_to_setka.id_model
    JOIN model_type_to_markas ON models2.model_type_mark = model_type_to_markas.id
    WHERE models2_to_setka.id_setka = 7 AND model_type_to_markas.model_type_id = ? AND model_type_to_markas.marka_id = ?
        ORDER BY `models2`.`id` ASC");
    $stmt->execute([$model_type_id, $marka_id]);
    $models = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    if(is_string($models)){
        $models = [$models];
    }
    
    foreach ($models as $key => $model)
        if (in_array($model['name'], $exclude_models)) unset($models[$key]);
        
    shuffle($models);
}

if(empty($models)){
    if(empty($model_type_id)){
        $stmt = pdo::getPdo()->prepare("SELECT id FROM model_types where name = ?");
        $stmt->execute([$gadget['type']]);
        $model_type_id =$stmt->fetchColumn();
    }
    
    $stmt = pdo::getPdo()->prepare("SELECT name FROM models_list
        WHERE marka_id = ? AND model_type_id = ?");
    $stmt->execute([$marka_id,$model_type_id]);
    $modelsListN = $stmt->fetchAll(\PDO::FETCH_COLUMN);
}


//var_dump($gadget['type']); 
?>


<?php if (!empty($models) && (count($m_models) > 0 || count($models) > 0)) { ?>
<div class="block block-full block-auto block-model">
  <?php if (count($m_models) > 0) { ?>
  <div class="grid-4">
    <h3>Линейки <?=$model_type_name_rm?></h3>
    <ul class = "listModels">
    <?php foreach ($m_models as $mm) { ?>
      <li><a href = "/repair-<?=$this->_datas['accord_image'][$this->_datas['orig_model_type'][0]['name']]?>/<?=strtolower(preg_replace('/(\s+)/', '-', $this->_datas['marka']['name'].' '.$mm['name']))?>/">Ремонт <?=$this->_datas['marka']['name'].' '.$mm['name']?></a></li>
    <?php } ?>
    </ul>
  </div>
  <?php } ?>
  <?php if (count($models) > 0) { ?>
  <div class="grid-8">
    <h3>Модели <?=$model_type_name_rm?></h3>
    <ul class = "listModels listModelsSplit2">
    <?php foreach (array_slice($models, 0, 10) as $m) { ?>
      <li><a href = "/repair-<?=$this->_datas['accord_image'][$this->_datas['orig_model_type'][0]['name']]?>/<?=strtolower(preg_replace('/(\s+)/', '-', $this->_datas['marka']['name'].' '.$m['name']))?>/">Ремонт <?=$m['name']?></a></li>
    <?php } ?>
    </ul>
  </div>
  <?php } ?>
</div>
<?php } elseif(!empty($modelsListN)) {
        $modelsList =$modelsListN;
?>
<div  class="block block-full block-auto block-model">

        <div class="grid-8 modelListN">
            <h3>Модели <?=$model_type_name_rm?></h3>
<?php
            if(count($modelsList) <= 4){
            shuffle($modelsList);
?>
                <ul class ="listModels listModelsSplit4">
                    <?php foreach($modelsList as $model){?>
                        <li><a  href="#callback"><?=$model?></a></li>
                    <?php } ?>
                </ul>

<?php
            }else{
                if(count($modelsList)>5){
                    $tempArrModels = array_slice($modelsList, 0, 5);
                    unset($modelsList[0],$modelsList[1],$modelsList[2],$modelsList[3],$modelsList[4]);
                    shuffle($tempArrModels);
                    shuffle($modelsList);
                    //var_dump($this->org['region']); 
                    if(count($modelsList)>6){
                        $maxModels = (count($modelsList)>15) ? 15 : count($modelsList);
                        shuffle($modelsList);
                        $modelsList = array_slice($modelsList, 0,rand(7,$maxModels));
                    }
                        
                    $modelsList = array_merge($tempArrModels,$modelsList);
                }else{
                    shuffle($modelsList);
                }
                //$part = ceil(count($modelsList)/2);
                //$part = ceil($part/2);
                //var_dump(array_chunk($modelsList,$part));
?>
                <ul class ="listModels listModelsSplit4">
                    <?php foreach($modelsList as $model){?>
                        <li><a  href="#callback" data-toggle="modal"><?=$model?></a></li>
                    <?php } ?>
                </ul>
                                    
<?php       } ?>
    </div>

</div>
<?php }else{ ?>
<div></div>
<? } ?>

