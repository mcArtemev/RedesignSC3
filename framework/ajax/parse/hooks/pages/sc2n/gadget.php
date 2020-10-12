<?
use framework\tools;
use framework\pdo;

$marka = $this->_datas['marka']['name'];
$ru_marka =  $this->_datas['marka']['ru_name'];
$servicename = $this->_datas['servicename'];

$add_device_type = $this->_datas['add_device_type'];

include __DIR__.'/text/model_info.php'; 
include __DIR__.'/text/getGadgetsData.php'; 

$gadget = $add_device_type[$this->_datas['arg_url']];
$accord_image = $this->_datas['accord_image'];
$name = tools::mb_ucfirst($gadget['type']);

$dbh = pdo::getPdo();
$stmt = $dbh->prepare("SELECT models_list.name 
                        FROM models_list
                        LEFT JOIN model_types ON models_list.model_type_id = model_types.id
                        WHERE model_types.name = :model_type
        	                AND marka_id = :marka_id
                        ORDER BY request_count DESC");
$stmt->execute(['model_type'=>$gadget['type'],'marka_id'=>$this->_datas['marka']['id']]);
$modelList = $stmt->fetchAll(\PDO::FETCH_COLUMN);
?>

    <section class="fixed content-wrapper">
            <div class="content-block">

                <section class="crumbs">
                    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="<?=$multiMirrorLink?>/"><meta itemprop="title" content="Главная"/><img src="/img/home.png" alt="home"/></a></span>
                    <span> / </span>
                    <span><?=tools::mb_ucfirst($gadget['type_m'], 'utf-8', false)?></span>
                </section>

                <div class="content-block__top">

                    <div class="info-block remont-block">

                        <h1><?=$this->_ret['h1']?></h1>
                        <div class="block-wrp">
                            <!--<div>-->
                    <?php   if(file_exists("/var/www/www-root/data/www/sc2/userfiles/site/large/".$accord_image[$gadget['type']]."-".mb_strtolower($this->_datas['marka']['name']).".png")) :?>
                                <img src="/userfiles/site/large/<?=$accord_image[$gadget['type']].'-'.mb_strtolower($this->_datas['marka']['name']).'.png'?>" alt="<?=$name?>" title="<?=$name?>">
                    <?php    else: ?>
                                <img src="/img/alt/<?=$accord_image[$gadget['type']]?>.png" alt="<?=$name?>" title="<?=$name?>">
                    <?php   endif; ?> 
                                
                                
                                
                     <!--{-->
                     <!--               $str .= '<img src="/userfiles/clauses/large/'.$accord_image[$device['type']].'-'.$marka_lower.'.png" alt="'.$name.'" title="'.$name.'">';-->
                     <!--           } else {-->
                     <!--               $str .= '<img src="/img/alt/'.$accord_image[$device['type']].'.png" alt="'.$name.'" title="'.$name.'">';-->
                     <!--           }            -->
                            
                                <!--<span class="price">от <span><?//=$info_block[$this->_datas['arg_url']][2]?></span> руб</span>-->
                            <!--</div>    -->
                        </div>
                        <div class="block-wrp">
                            <?php
                              include_once "text/type.php";
                              $genText = false;
                              if ($this->_datas['region']['name'] == "Москва" && isset($typeText) && is_array($typeText)) {
                                if (isset($typeText[$gadget['type_m']])) {
                                  $text = $typeText[$gadget['type_m']];
                                  $genText = true;
                                  echo '<p>'.$text['desc'].'</p>';
                                }
                              }
                              if (!$genText) {
                            ?>
                            <p><?=tools::mb_ucfirst($gadget['type_m'], 'utf-8', false)?> <?=$ru_marka?> зарекомендовали себя с лучшей стороны как для решения бизнес-задач, так и для повседневных потребностей пользователей <?=$marka?>. <?=tools::mb_ucfirst($gadget['type_m'], 'utf-8', false)?> <?=$marka?> - мощные и надежные,
                                    но, к сожалению, случается, что из строя выходят даже они.</p>
                            <p>Если это случилось и с вашим <?=$ru_marka?> – не отчаивайтесь и звоните в <?=$servicename?>. Мы профессионалы и знаем, как все исправить.</p>
                            <?php } ?>
                            <span class="price">от <span><?=(!empty(getGadgetsData($marka,$gadget['type'])['min_price'])) ? getGadgetsData($marka,$gadget['type'])['min_price']:''?></span> руб</span>
                            <a href="<?=$multiMirrorLink?>/order/"  class="btn btn--fill">Записаться на ремонт</a>


                        </div>

                        <div class="clear"></div>
                    </div>

                </div>

                <div class="divider divider--three"></div>

                <div class="content-block__bottom">

                  <?php
                    if ($this->_datas['region']['name'] == "Москва" && isset($typeText) && is_array($typeText)) {
                      if (isset($typeText[$gadget['type_m']])) {
                        $text = $typeText[$gadget['type_m']];
                        if (isset($text['text'][0])) {
                          echo '<div class = "info-block">';
                          renderTypeText($text['text'][0]);
                          echo '</div>';
                        }
                      }
                    }
                  ?>

                    <div class="info-block">
        <!--            Услуги и цены          -->            
                        
                        <?php //if(!empty($info_block[$this->_datas['arg_url']][0])):?>
                        <?php if(!empty(getGadgetsData($marka,$gadget['type'])['services'])):?>
                        
                        <span class="h2">Услуги по обслуживанию&nbsp;<?=$gadget['type_rm']?> <?=$ru_marka?></span>
                        <?//=$info_block[$this->_datas['arg_url']][0]?>
                        <?=getGadgetsData($marka,$gadget['type'])['services']?>
                        <?php endif; ?>
                        
                        
        <!--            комплектующие         -->
        
                        <?php if(!empty($info_block[$this->_datas['arg_url']][1])):?>
                        <span class="h2">Цены на комплектующие&nbsp;<?=$gadget['type_rm']?>&nbsp;<?=$marka?></span>
                        <?=$info_block[$this->_datas['arg_url']][1]?>
                        <?php endif; ?>
                        
                        <?php //if(!empty($info_block[$this->_datas['arg_url']][3])):?>
                        <!--<span class="h2">Неисправности <?//=$gadget['type_rm']?>&nbsp;<?//=$marka?></span>-->
                        <?//=$info_block[$this->_datas['arg_url']][3]?>
                        <?php //endif; ?>
                    </div>
                    
                    

                    <?php
                      if ($this->_datas['region']['name'] == "Москва" && isset($typeText) && is_array($typeText)) {
                        if (isset($typeText[$gadget['type_m']])) {
                          $text = $typeText[$gadget['type_m']];
                          if (isset($text['text'][1])) {
                            echo '<div class = "info-block">';
                            renderTypeText($text['text'][1]);
                            echo '</div>';
                          }
                        }
                      }
                    ?>
                    
                </div>
                
        
<?php   //if(!empty($modelList)):
            // if(count($modelList)>3){
            //     $tempModelArr = array_slice($modelList,3);
            //     $modelList = array_slice($modelList,0,3);
                
            //     srand($this->_datas['marka']['id']+$this->_datas['region']['id']);
            //     shuffle($tempModelArr);
            //     srand();
                                
            //     $modelList = array_merge($modelList,$tempModelArr);
            //     $maxModel = (count($modelList)>9)?9:count($modelList);
            //     $modelList = array_slice($modelList,0,$maxModel);
            // }
?>
<?php if(!empty(getGadgetsData($marka,$gadget['type'])['models'])):?>
            <span class="h2">Популярные модели <?=$gadget['type_rm']?> <?=$marka?></span>
            <section class="modalAndDefect" >
                <?=getGadgetsData($marka,$gadget['type'])['models']?>
                
               <!--<ul class="modelList" >-->
<?php     //  foreach ($modelList as $model):?>
                    <!--<li>-->
                         <?//= $model?> 
                    <!--</li>-->
<?php     //  endforeach; ?>
            <!--    </ul>-->
            
            </section>
<?php   endif; ?>
        
        
            <section class="modalAndDefect" >
                <?php if(!empty($info_block[$this->_datas['arg_url']][3])):?>
                
                <span class="h2">Частые неисправности <?=$gadget['type_rm']?>&nbsp;<?//=$marka?></span>
                <div>
                    <?=$info_block[$this->_datas['arg_url']][3]?>
                </div> 
                <?php endif; ?>
                       
            </section>
        
        
        
        
        
        </div>
        
        <? include __DIR__.'/aside2.php'; ?>
    </section>
    
<div class="clear"></div>
