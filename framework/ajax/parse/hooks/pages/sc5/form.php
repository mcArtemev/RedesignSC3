<?

use framework\ajax\parse\hooks\sc;
use framework\tools;

$marka = $this->_datas['marka']['name'];
$marka_ru = $this->_datas['marka']['ru_name'];
$feed = $this->_datas['feed'];

$dop = array();
$dop[] = array('Заполняйте телефон через онлайн форму', 'Заполняйте номер телефона через онлайн форму', 'Заполняйте свой телефон через онлайн форму',
    'Заполняйте свой номер телефона через онлайн форму', 'Заполняйте номер своего телефона через онлайн форму', 'Заполняйте телефон через online форму',
    'Заполняйте номер телефона через online форму', 'Заполняйте свой телефон через online форму', 'Заполняйте свой номер телефона через online форму',
    'Заполняйте номер своего телефона через online форму');
$dop[] = array('и отправляйте', 'и посылайте', 'и оставляйте');
$dop[] = array('заявку -', 'заказ -', 'запрос -',);
$dop[] = array('перезвоним');
$dop[] = array('в течение');
$dop[] = array(tools::get_rand(array('30 минут', '25 минут', '40 минут'), tools::gen_feed($this->_datas['site_name'])));
$dop[] = array('и проконсультируем по любым вопросам ремонта', 'и проконсультируем по любым вопросам ремонта и обслуживания',
    'и проконсультируем по всем вопросам ремонта', 'и проконсультируем по всем вопросам ремонта и обслуживания',
    'и проведем консультацию по любым вопросам ремонта', 'и ответим на вопросы по любым видам ремонта',
    'и ответим на вопросы по любым видам ремонта и обслуживания', 'и ответим на вопросы по всем видам ремонта',
    'и ответим на вопросы по всем видам ремонта и обслуживания', 'и ответим на любые вопросы по любым видам ремонта и обслуживания',
    'и ответим на все вопросы по любым видам ремонта', 'и ответим на все вопросы по любым видам ремонта и обслуживания');

$dop_text = sc::_createTree($dop, $feed);

$dop_str = '';


$feed = tools::gen_feed($this->_datas['site_name']);
$rand_devices = tools::get_rand(array_values($this->_datas['all_devices']), $feed);

if (isset($use_padding)) {
    if ($use_padding)
        $dop_str = ' style = "padding-bottom: 30px"';
}

$hour = date("H");
if($hour >= 20 || $hour < 8){
   $hold = 'hold';
   //$hold = 'required';
}else{
    $hold = '';
}
?>

<div class="modal fade" id="callback" tabindex="-1">
    <div class="modal-content">
        <p id="default" class="auto-line"><span class="title-middle">Запишитесь на ремонт</span><br/><span
                    class="title-tip font-little">и мы свяжемся с вами в течении 3х минут</span></p>

        <p id="good" class="title-middle align-center margin-bottom-little">Отлично!</p>
        <p id="double-title" class="title-middle align-center margin-bottom-little">Попробуйте позже</p>
        <p id="bravo" class="title-middle align-center margin-bottom-little">Поздравляем!</p>

        <form>
            <div class="form-send">
                <div class="form-content">

                    <input name="tel" type="tel" class="font-button inputbox" placeholder="телефон*"/>
                    <p id="error" class="margin-bottom-very-little font-tip font-color-gray">укажите телефон</p>
                    <p class="margin-bottom-very-little font-tip font-color-gray">пример: +7 (926) 123-45-67</p>

                    <input name="name" type="text" class="font-button inputbox margin-top-little-sm" placeholder="имя"/>
                    <p class="margin-bottom-very-little font-tip font-color-gray">пример: Сидоров Иван Петрович</p>
                    <select name="type" type='type'  data-placeholder="тип устройства"  >
                        <option></option>
                        <? foreach ($this->_datas['all_devices'] as $key => $device): ?>
                            <option><?= $device['type'] ?></option>
                            <p id="error" class="margin-bottom-very-little font-tip font-color-gray">укажите тип устройства</p>
                        <? endforeach; ?>
                    </select>
                    <p id="typeError" class="margin-bottom-very-little font-tip font-color-gray <?= $hold ?>">укажите тип устройства</p><!--добавил Tony, требование выбрать хотябы одно условие после 20 вечера-->
                    <p class="margin-bottom-very-little font-tip font-color-gray">
                        пример: <?= $rand_devices['type'] ?></p>
                    <? if ($use_choose_city): ?>
                        <select name="city" data-placeholder="регион" class="green">
                            <? foreach ($address_choose as $key => $value):
                                $selected = ($value['region_name'] == $city) ? ' selected' : ''; ?>
                                <option<?= $selected ?>><?= $value['region_name'] ?></option>
                            <? endforeach; ?>
                        </select>
                        <p class="margin-bottom-very-little font-tip font-color-gray">пример: <?= $city ?></p>
                    <? endif; ?>

                    <textarea rows="3" name="comment" class="font-button inputbox margin-top-little-sm"
                              placeholder="ваша неисправность"></textarea>
                    <p class="font-tip font-color-gray">пример: <?= $default_textarea_tip ?></p>
                </div>

                <div class="row mt-20">

                    <div class="col-sm-5">
                        <p class="font-tip font-color-gray auto-line" id="promo-tip">*промокод будет привязан к указанному номеру телефона</p>
                        <p class="font-tip font-color-gray auto-line" id="license-tip">отправляя заявку вы даете согласие на обработку персональных данных</p>
                    </div>
                    <div class="col-sm-7 col-xs-12">
                        <button type="submit" class="font-button button <?= $marka_lower ?>">записаться на ремонт</button>
                    </div>
                </div>
            </div>

            <div class="form-double">
                <p class="font-little" id="double">Вы уже <span id="double-text">отправляли заявку или получали промокод</span>.<br/><br/>
                    Повторно <span id="double-tip">это можно сделать</span> через <span id="second">30 секунд</span>.
                </p>
            </div>

            <div class="form-success">
                <p class="font-little" id="success">Наш специалисты получили заявку и уже приступили к ее обработке.<br/><br/>Всего 3 минуты и мы свяжемся с вами.</p>
            </div>
            <i class="fa fa-spinner fa-pulse spinner" style="display: none"></i>
        </form>

        <button type="button" class="close font-button" data-dismiss="modal" title="закрыть"><i class="fa fa-times"></i></button>
    </div>
</div>