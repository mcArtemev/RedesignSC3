<?
use framework\tools;
$metrica = $this->_datas['metrica'];
?>

    <section class="fixed content-wrapper">
            
            <div class="content-block">
                <section class="crumbs">
                    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="<?=$multiMirrorLink?>/"><meta itemprop="title" content="Главная"/><img src="/img/home.png" alt="home"/></a></span>
                    <span> / </span>
                    <span>Запись на ремонт</span>
                </section>
                <div class="content-block__top">
                    <div class="info-block">
                        <h1><?=$this->_ret['h1']?></h1>
                        
                        <div class="promo-order">
                            	<div class="promo-info promo-left">
                            		<p>Получите <strong>10% скидку</strong> по промо-коду.<br/>Скидка действует на все услуги сервисного центра.</p>	
                            	</div>
                            	<div class="promo-info promo-right">
                            		<a href="#" class="btn btn--fill">Получить промо-код</a>
                            		<div class="promo"></div>
                            		<div class="promo-tooltip"><p>Ваш промо-код</p></div>
                            	</div>	
                            	<div class="clear"></div>
                            	<div class="divider"></div>
                        </div>
                        
                        <p class="promo-kod" id="text-1">&nbsp;</p>
                        <p class="promo-kod" id="text-2">Промо-код действителен при заполнении заявки.</p>
                        <div class="modalDialog">
                            <form onsubmit="yaCounter<?=$metrica?>.reachGoal('ORDER'); return true;">
                            
                                <input type="tel" class="phone_id" value="" placeholder="Телефон * ">
                                <input type="text" value="" placeholder="ФИО">
                                <select>
                                <? foreach($this->_datas['all_devices'] as $device): ?>
                                    <option value="<?=$device['type']?>"><?=tools::mb_ucfirst($device['type'])?></option>
                                 <? endforeach; ?>
                                </select>                                    
                                <textarea cols="40" rows="8" placeholder="Комментарий к заказу"></textarea>
                              
                                <p>* обязательно для заполнения</p>
                                <input type="submit" class="btn btn--fill" value="Отправить заявку">
                                <div class="clear"></div>
                            </form>                                    
                        </div>
                    </div>
                </div>
            </div>   
            <? include __DIR__.'/aside.php'; ?>
     </section>
     <div class="clear"></div>        
