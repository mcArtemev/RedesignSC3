<?
use framework\tools;
$metrica = $this->_datas['metrica'];
?>

    <section class="fixed content-wrapper">
            
            <div class="content-block">
                <section class="crumbs">
                    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="<?=$multiMirrorLink?>/"><meta itemprop="title" content="Главная"/><img src="/img/home.png" alt="home"/></a></span>
                    <span> / </span>
                    <span>Статус заказа</span>
                </section>
                <div class="content-block__top">
                    <div class="info-block">
                        <h1><?=$this->_ret['h1']?></h1>                        
                        <p>Чтобы узнать информацию о заказе введите номер квитанции. Номер указан в левом верхнем углу.</p>
                        <div class="modalDialog">
                            <form data-metrica="<?=$this->_datas['metrica'];?>">
                                <input class="bill_id" value="" placeholder="Номер квитанции * ">
                                <p>* обязательно для заполнения</p>
                                <input type="submit" class="btn btn--fill" value="Узнать статус">
                                <div class="clear"></div>
                            </form>                                
                        </div>
                        
                        <div class="tab-block status-block">
                            <table class="priceTable"><tbody><tr><td>Статус</td><td>Дата и время</td></tr>
                            <tr><td></td><td></td></tr></tbody></table>
                                                    
                            <p class="status-more"><a href="#">Подробнее</a></p>
                            <table class="priceTable status-man"><tbody><tr><td>Должность</td><td>ФИО</td></tr></tbody></table>
                            <div class="status-more-text"></div>
                        </div>
                        
                        <div class="status-none">
                            <p>Заказ не найден.</p>
                        </div>
                        
                    </div>
                </div>
            </div>   
            <? include __DIR__.'/aside.php'; ?>
     </section>
     <div class="clear"></div>        
