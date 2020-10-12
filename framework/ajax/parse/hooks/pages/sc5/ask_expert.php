<section class="inner-page gradient-reverse cut-reverse target ask-expert">
    <div class="container">
        <div class="row">

            <div class="col-sm-6 displaySmaller">
                <div class="image-clip " style="background-image: url(/bitrix/templates/remont/images/girl.png); background-size: contain;"></div>
            </div>

            <div class="col-sm-6 textblock">
                <?php if(isset($ask_text) && !empty($ask_text)) :;
                    echo $ask_text;

                    else :;?>
                    <h2 class="auto-line h1"><span class="smallh1">Спросите эксперта</span>
                        <span class="boldh1"><?=$marka?> </span> прямо сейчас!</h2>

                    <div class="image" style="background-image: url(/bitrix/templates/remont/images/girl.png)"></div>

                    <div class="margin-bottom margin-top block-button">
                        <button type="button" class="callback-modal button button-reverse mr-20 <?=$marka_lower?>"
                                data-title="Задайте вопрос эксперту"
                                data-button="задать вопрос" data-textarea="ваш вопрос"
                                data-title-tip="и мы свяжемся с вами в течении 3х минут"
                        >хочу задать вопрос</button>
                        <button type="button" class="callback-modal button margin-left-little no-margin-left-sm margin-top-little-sm <?=$marka_lower?>"
                                data-title="Закажите обратный звонок"
                                data-button="перезвоните мне"
                                data-title-tip="и мы свяжемся с вами в течении 3х минут"
                        >перезвоните мне!</button>
                    </div>

                    <p>Мы на связи с нашими пользователями 24 часа в сутки, 7 дней в неделю, 365 дней в году.</p>

                    <p> 
                        И мы приложим все усилия,
                        чтобы помочь вам наслаждаться вашим <?=$marka?> каждую секунду
                    </p> 
                <?php endif;?>
                <? if (!$use_choose_city):?>
                    <div class="block-button">
                    <p class="phone"><i class="fa fa-phone"></i>
                        <a href="tel:+<?=$phone?>" class="font-bold"><?=$phone_format?></a>
                    </p>
                </div>
                <?endif;?>
            </div>
        </div>

    </div>
</section>