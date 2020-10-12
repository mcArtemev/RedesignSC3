<?

use framework\tools;
use framework\pdo;
use framework\ajax\parse\hooks\sc;
use framework\rand_it;
use framework\func;
// include ('pages/sc7/description_help_pc.php');

include __DIR__.'/data/exclude_model.php';


$marka = $this->_datas['marka']['name'];
$setka_id = $this->_datas['setka_id'];
$site_id = $this->_site_id;
$genText = tools::new_gen_text(" {
    {Поможем|Сможем|Мы способны|Мы поможем} {разобраться|решить проблему} с {«синим экраном смерти»|Bsod|BSOD|Биос|BIOS|Bios} , 
    {излечить|удалить|вылечить} {вирусы|вредоносные программы|вредоносное ПО|все вирусы|все виды вирусов|все типы вирусов|все вредоносные программы|любые вирусы|любое вредоносное ПО}
    {и|,|или} {настроим|наладим|установим|настроим и установим|установим и настроим|установим и наладим}
    {безопасность вашей сети|систему безопасности сети|сетевую безопасность|систему сетевой безопасности}. 
    { } {Наши|Опытные|Профессиональные|Квалифицированные|Сертифицированные} {специалисты|мастера|сервисные специалисты|сисадмины|системные администраторы|сервисные мастера}
    {легко|без труда|с легкостью} 
    {
        {
            справятся с {переустановкой|установкой|настройкой|переустановкой и настройкой|переустановкой и наладкой|наладкой|установкой и настройкой|установкой и наладкой}
            {операционной системы|ОС|любой ОС|любой операционной системы} , {подключат|подсоединят|присоединят} {всю периферию|периферийные устройства|периферийное оборудование|все периферийные устройства|все периферийное оборудование} ,
            {
                {
                    {а при|и при} {необходимости|желании}   
                }|{
                    {а по|и по} запросу
                }
            }
            {
                {
                    проведут 
                    {
                        {
                            {урок|занятие по} компьютерной грамотности.     
                        }|{
                            обучение работе на компьютере.
                        }
                    }
                }|{
                    {научат|обучат} {компьютерной грамотности|работе на компьютере} .      
                }
            }
        }|{
            {выполнят|проведут|осуществят} {переустановку|установку|настройку|переустановку и настройку|переустановку и наладку|наладку|установку и настройку|установку и наладку}
            {операционной системы|ОС|любой ОС|любой операционной системы} , {подключат|подсоединят|присоединят}
            {всю периферию|периферийные устройства|периферийное оборудование|все периферийные устройства|все периферийное оборудование} , 
            {
                {
                    {а при|и при} {необходимости|желании} 
                }|{
                    {а по|и по} запросу
                }
            }   
                {
                    {
                        проведут 
                        {
                            {
                              {урок|занятие по} компьютерной грамотности.   
                            }|{
                                обучение работе на компьютере.  
                            }
                        }
                    }|{
                        {научат|обучат} {компьютерной грамотности|работе на компьютере} .
                    }
                }     
        }
    }
  }");

  
$price_list = [
    ''=>[
            ['Выезд мастера',0],
            ['Диагностика',0],
            ['Лечение от вирусов', 370],
            ['Удаление вирусов', 320],
            ['Установка антивируса на 1 год', 390],
            ['Активация антивируса', 350],
            ['Настройка системы сетевой безопасности', 375],
            ['Антивирусная профилактика ПК', 455],
            ['Восстановление не работающей ОС', 400],
            ['Обновление операционной системы', 255],
            ['Переустановка операционной системы', 350],
            ['Установка двух и более ОС на 1 устройство', 450],
            ['Установка и настройка программ', 460],
            ['Настройка или обновление БИОС', 565],
            ['Установка драйверов', 300],
            ['Обновление драйверов', 320],
            ['Установка MS Office', 695],
            ['Настройка почты', 420],
            ['Настройка 1С и другого специального ПО', 660],
            ['Установка графических программ', 345],
            ['Установка и настройка удаленного доступа', 415],
            ['Настройка Wi-Fi роутера', 490],
            ['Восстановление пароля Wi-Fi роутера', 700],
            ['Обновление программы роутера', 110],
            ['Устранение причины неисправности сигнала роутера', 210],
            ['Создание домашней сети - больше 5 устройств', 460],
            ['Создание домашней сети - менее 5 устройств', 410],
            ['Тестирование Интернет-соединения', 335],
            ['Рекомендации и помощь в подключении к провайдеру', 355],
            ['Подключение и настройка принтера', 420],
            ['Подключение роутера', 490],
            ['Подключение клавиатуры, мышки', 120],
            ['Подключение и настройка МФУ', 420],
            ['Подключение и настройка сканера', 420],
    ],

];

?>
 <main>
            <section class="breadcrumbs">
                <div class="container">
                    <div class="grid-12" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                        <ul class="breadcrumbs-inside">
                            <li itemprop="name"><a href="/" itemprop="url">Главная</a></li>
                            <li itemprop="name"><span>Компьютерная помощь </span></li>
                        </ul>
                    </div>
                </div>
            </section>
            <section class="title-block">
                <div class="container">
                    <div class="grid-12">
                        <h1 style="float: left;"><?=$this->_ret['h1']?></h1>
					</div>
                </div>
            </section>
            <section class="block-section">
                <div class="container">
                    <div class="grid-12">
                        <div class="block-list">
                            <div class="block block-small block-text-image">
                            <img src="/images/sample/dellbiglaptops.png" width="250" style="max-height: 150px;">
                                <p><?
                                echo $genText;
                                ?>
                                 
                                <br>
                                <br>
                                <i class="fa fa-fw fa-money"></i>Бесплатная диагностика</p>
                            </div>
                            
                            <? include __DIR__.'/block-recall.php' ?>
                            <!--<a class = "btn btn-dark btn-mb" data-slideDown = "allServices">Показать все услуги</a><br>-->

                            <div class="block block-auto block-full block-table block-service-table">
                                <div class="block-inside">
                                    <h2>Все виды услуг компьютерной помощи: </h2>
                                    <div class="services-item-table services-item-table-full">
										<a class="services-item-row" style="color: black; font-weight: 500;">
											<span class="services-item-name" style="text-decoration: none;">Название услуги</span>
											<span class="services-item-value" style="margin-right: 33%;">Стоимость, руб</span>
											
										</a>
                                        <? foreach ($price_list as $key => $value){ ?>
                                
                                    <h3 style="text-align: center;"><?=$key?></h3>
                                    
                                    <?foreach ($value as $key) { ?>
                                        
                                
                                    <div class="a services-item-row">
                                        <span class="services-item-name" itemprop="name"><?=$key[0]?></span>
                                        <span class="services-item-value"><?=$key[1]?></span>
                                        <span class="services-item-callback">
                                            <button href="#callback" class="service-button-callback" data-toggle="modal">
                                                <span>Заказать звонок</span>
                                            </button>
                                        </span>
                                                <meta itemprop="price" content="700"><meta itemprop="priceCurrency" content="RUB">
                                    </div>
                                
                                    <? }
                                  }
                                ?>
										
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
                </div>
                    <!--block-promo-->
                <div class="container">
    <div class="grid-12">
    <!--noindex-->
    <div class="block block-small block-image block-promo-wrapper">
    <?php if (!empty($this->_datas['hb'])) { ?>
        <div class="block-image-url" style="background-image: url('/images/hab/computer.jpg'); background-position: 50% 50%;">
    <?php } else { ?>
        <div class="block-image-url" style="background-image: url('/images/hab/computer.jpg'); background-position: 50% 50%;">
    <?php } ?>
             <div class="block-promo">
                <p class="block-promo-title">ДАРИМ 1000 рублей</p>
                <p class="block-promo-title"><small>Получить промокод на работы ПРОСТО!</small></p>
                <p class="block-promo-title-text"><span class="number">1</span> Получите промокод SMS сообщением<br />
                <span class="number">2</span> Сообщите промокод мастеру перед оплатой услуг<br />
                <span class="number">3</span> Оплачивайте до 1000 рублей полностью с помощью промокода*<br />
                <small>* - оплачивать промокодом можно не более 20% от суммы работ</small></p>
            </div>
        </div>
        <div class=" block-small block-form">
		<button type="button" class="close x_pos">&times;</button>
		<form class="block-form-inside" data-op="promo">
			<div class="send">
				<div class="form-title">Получить SMS с промокодом</div>
				<div class="form-input">
					<input type="text" class="phone inputform" placeholder="Телефон" required>
					<i class="fa fa-question-circle"></i>
					<div class="input-tooltip">Обязательное поле</div>
				</div>
				<!--<div class="form-input">
					<input type="text" class="name inputform" placeholder="Имя">
				</div>-->
				<div class="form-btn">
					<div class="btn btn-accent btn-with-input">
						<input type="submit" class="" value="Отправьте мне SMS">
					</div>
				</div>
			</div>
			<div class="success">
                <div class="block-text">
    				<img src="/templates/russupport/img/success-512.png" style="width: 30%;" />
    				<p></p>
                </div>
			</div>
		</form>
	</div>
    </div>
    <!--/noindex-->
                             
	
    
    </div>
 </div>

                <section class="link-block-section">
        <div class="container">
            <div class="grid-12">
                <div class="link-block-list perelink">
                    <a  class="link-block">
                    <div class="link-block-title-strong"><i class="number">1</i>Оставляете заявку</div>Воспользуйтесь формой или позвоните нам
                    </a>
                    <a  class="link-block">
                    <div class="link-block-title-strong"><i class="number">2</i>Проводим диагностику</div>Выявляем неисправность с помощью профессионального стенда
                    </a>
                    <a  class="link-block">
                    <div class="link-block-title-strong"><i class="number">3</i>Устраняем неисправность</div>Проводим все необходимые действия, после вашего одобрения
                    </a>
                    <a  class="link-block">
                    <div class="link-block-title-strong"><i class="number">4</i>Вы довольны</div>Вы забираете восстановленный гаджет
                    </a>
            </div>
            </div>
    </section>
			
        </main>