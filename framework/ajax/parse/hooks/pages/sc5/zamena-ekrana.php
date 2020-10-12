<?

use framework\pdo;
use framework\tools;
use framework\rand_it;
use framework\ajax\parse\hooks\pages\sc5\utils\pricebuilder;

    //исключения по именам!
    include __DIR__.'/text/exclude.php';
        
    $exclude = get_exclude();
    
    $site_id = $this->_datas['site_id'];
    
    $marka = $this->_datas['marka']['name'];
    $marka_lower = mb_strtolower($this->_datas['marka']['name']);
    $marka_ru =  $this->_datas['marka']['ru_name'];
    $marka_id = $this->_datas['marka']['id'];
    $accord2 = array('смартфон' => 'telefon', 'ноутбук' => 'notebook', 'планшет' => 'planshet');   
     
    $m_models_table = 'm_models';
    $m_models_link = 'm_model_id';
    
    $ex = array('marka_id' => $marka_id, 'site_id' => $site_id);
    $cond_model = "`m_models`.`marka_id`=:marka_id";
    
    $sql = "SELECT `models`.`id` as `id`, `models`.`name` as `name`, `model_types`.`name` as `type` FROM `model_to_sites`
                    INNER JOIN `sites` ON `sites`.`id`=`model_to_sites`.`site_id`
                    INNER JOIN `models` ON `models`.`id`=`model_to_sites`.`model_id`
                    INNER JOIN `{$m_models_table}` ON `{$m_models_table}`.`id`=`models`.`{$m_models_link}`
                    INNER JOIN `model_types` ON `m_models`.`model_type_id` = `model_types`.`id`
                        WHERE {$cond_model} AND `model_to_sites`.`site_id`=:site_id ORDER BY `models`.`id`";
                        
    $stm = pdo::getPdo()->prepare($sql);
    $stm->execute($ex);
    $data = $stm->fetchAll(\PDO::FETCH_ASSOC);

    $t = array();
    foreach ($data as $value)
    {
        if (!in_array($value['id'], $exclude))
            $t[$value['type']][] = $value;
    }
    
    $data = $t;

    foreach ($data as $key => $val)
    {
        $count_val = count($val);
        if ($count_val > 100) $count_val = 100;
        
        $data[$key] = rand_it::randMas($data[$key], $count_val, '', $this->_datas['feed']);
    }
    $accord = array('p' => '3', 'n' => '3', 'f' => '3');
    $apple_device_type = array('ноутбук' => 'MacBook', 'планшет' => 'iPad', 'смартфон' => 'iPhone'); 
    
    $ring = 20;

?>

    <section class="page">
        <div class="container">
            <div class="breadcrumbs">
                <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/"><span itemprop="title">Главная</span></a></span>
                &nbsp;|&nbsp;<span>Замена экрана <?=$this->_datas['marka']['name']?></span>
            </div>
            <div class="textblock">
                <h1><span class="smallh1"><?=$this->_ret['h1']?></span></h1>
                <?php
                    $pricePage = new pricebuilder($site_id, $data, $this->_datas['all_devices'], $marka);
                ?>
                <?php echo $pricePage->render(); ?>
            </div>
        </div>
    </section>

<? include __DIR__.'/ask_expert.php'; ?>
<?php
$section_class = 'whitebg';
include __DIR__.'/preims.php';
unset($section_class);
