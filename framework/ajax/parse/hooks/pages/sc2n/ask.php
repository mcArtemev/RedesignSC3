<?
$metrica = $this->_datas['metrica'];
?>    
    <section class="fixed content-wrapper">
            
            <div class="content-block">
                <section class="crumbs">
                    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="<?=$multiMirrorLink?>/"><meta itemprop="title" content="Главная"/><img src="/img/home.png" alt="home"/></a></span>
                    <span> / </span>
                    <span>Задать вопрос</span>
                </section>
                <div class="content-block__top">
                    <div class="info-block">
                        <h1><?=$this->_ret['h1']?></h1>
                        
                        
                        <div class="modalDialog">
                            <form onsubmit="yaCounter<?=$metrica?>.reachGoal('ASK'); return true;">
                                <textarea rows="8" placeholder="Ваш вопрос"></textarea>
                                <input type="text" value="" placeholder="Имя и фамилия">
                                <input type="tel" class="phone_id" value="" placeholder="Номер телефона * ">
                                <p>* обязательно для заполнения</p>
                                <input type="submit" class="btn btn--fill" value="Отправить сообщение">
                                <div class="clear"></div>
                            </form>                                
                        </div>
                    </div>
                </div>              
            </div>            
            <? 
            $mode = 0;
            include __DIR__.'/aside.php'; ?>                
        </section>
        <div class="clear"></div>  