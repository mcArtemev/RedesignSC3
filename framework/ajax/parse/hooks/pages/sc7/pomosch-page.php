<?  
    $price_list = [
    'antivirus-help'=>[
                    ['Выезд мастера',0],
                    ['Диагностика',0],
                    ['Лечение от вирусов',370],
                    ['Удаление вирусов',320],
                    ['Удаление вирусов в системных файлах',345],
                    ['Удаление вирусов на съемных носителях с сохранением информации',345],
                    ['Установка антивируса на 1 год',390],
                    ['Установка антивируса с дистрибутива клиента',350],
                    ['Активация антивируса - лицензионный ключ клиента',350],
                    ['Полная настройка системы сетевой безопасности',375],
                    ['Полная антивирусная профилактика ПК',455],
    ],
    'installing-software'=>[
                    ['Выезд мастера',0],
                    ['Диагностика',0],
                    ['Установка и настройка программ',460],
                    ['Настройка БИОС',565],
                    ['Обновление БИОС',560],
                    ['Установка драйверов',300],
                    ['Обновление драйверов',320],
                    ['Установка пакета MS Office',695],
                    ['Настройка почты',420],
                    ['Настройка 1С и другого специального ПО',660],
                    ['Установка графических редакторов',345],
                    ['Установка и настройка Банк-Клиент',660],
                    ['Установка и настройка удаленного доступа',415],
    ],
    'installing-devices'=>[
                    ['Диагностика',0],
                    ['Подключение и настройка принтера',420],
                    ['Подключение роутера',490],
                    ['Подключение клавиатуры, мышки',120],
                    ['Подключение и настройка МФУ',420],
                    ['Подключение и настройка сканера',420],
    ],
    'configuring-internet'=>[
                    ['Выезд мастера',0],
                    ['Диагностика',0],
                    ['Настройка Wi-Fi роутера',490],
                    ['Восстановление пароля Wi-Fi роутера',700],
                    ['Клонирование MAC-адреса устройства',160],
                    ['Обновление микропрограммы роутера',110],
                    ['Определение причины неисправности сигнала роутера',210],
                    ['Создание домашней сети "под ключ" - более 5 устройств',460],
                    ['Создание домашней сети "под ключ" - до 5 устройств',410],
                    ['Тестирование качества Интернет-соединения',335],
                    ['Рекомендации и помощь в подключении к новому провайдеру связи',355],
    ],
    'installing-os'=>[
                    ['Выезд мастера',0],
                    ['Диагностика',0],
                    ['Восстановление не работающей ОС',400],
                    ['Обновление операционной системы',255],
                    ['Переустановка операционной системы',350],
                    ['Установка двух и более ОС на 1 устройство',450],
                    ['Установка WINDOWS',365],
                    ['Настройка WINDOWS',555],
                    ['Установка Linux',365],
                    ['Настройка Linux',555],
                    ['Установка MacOS',400],
                    ['Настройка MacOS',700],
    ],
    'data-recovery'=>[
                ''=>[
                        ['Выезд мастера',0],
                        ['Диагностика',0],
                ],
            'HDD и SSHD'=>[
                    ['Копирование восстановленных данных',0],
                    ['Подробное исследование жесткого диска с составлением отчета',1200],
                    ['Копирование данных с исправного носителя - восстановления данных',1200],
                    ['Создание посекторной копии исправного носителя',2000],
                    ['Логические проблемы на исправных жестких дисках',1000],
                    ['Нечитаемые сектора, BAD блоки',2000],
                    ['Неисправность контроллера',2000],
                    ['Неисправность блока магнитных головок',5000],
                    ['Залипание магнитных головок',3000],
                    ['Заклинивание вала двигателя жесткого диска',6000],
                    ['Проблемы с микропрограммой - служебная область диска',3000],
                    ['Снятие пароля c HDD с сохранением информации',3000],
                    ['Повреждения поверхности пластин',10000],
            ],
            'RAID и NAS'=>[
                    ['Копирование восстановленных данных',0],
                    ['Восстановление данных массива RAID 0, RAID 1 (за массив)',2000],
                    ['Восстановление данных массива из 3 и более дисков (за каждый диск массива)',3000],
                    ['Сбор RAID (за диск)',5800],
            ],
            'Флешки, карты памяти, SSD диски'=>[
                    ['Копирование восстановленных данных',0],
                    ['Выпайка и вычитка чипов на оборудовании',1400],
                    ['Логические проблемы на исправных носителях',1000],
                    ['Физические неисправности устройств - до 16 Гб',3000],
                    ['Физические неисправности устройств - свыше 16 Гб',8000],
                    ['Аппаратные неисправности',4000],
                    ['Повреждение контроллера, разрушение ячеек памяти NAND 2',500],
                    ['Повреждение памяти или транслятора SSD диска',8000],
                    ['Восстановление данных SSD диска с шифрующим алгоритмом контроллера',15000],
                    ['Разрушение транслятора флешки - служебной микропрограммы',2500],
            ],
            'Файлы, файловые системы, шифрование'=>[
                    ['Восстановление поврежденных файлов',3000],
                    ['Восстановление паролей файлов, архивов',3000],
                    ['Восстановление шифрованных разделов, папок, файлов, контейнеров',10000],
                    ['Восстановление баз данных',10000],
                    ['Восстановление виртуальных машин',20000],
            ],
            'CD/DVD, ZIP/JAZ/MO, дискеты'=>[
                    ['Повреждение логической структуры данных',2000],
                    ['Механические неисправности носителя',2000],
            ],
    ],
];

?>
<main>
    <section class="breadcrumbs">
        <div class="container">
            <div class="grid-12" itemscope="" itemtype="http://schema.org/BreadcrumbList" id="breadcrumbs">
                <ul class="breadcrumbs-inside">
                       <li itemprop="name"><a href="/" itemprop="url">Главная</a></li>
                            <li class="breadcrumbs-inside-drop">
                                <span itemprop="name"><a itemprop="url" href="/about/">О компании</a></span>
                                <span class="breadcrumbs-inside-drop-btn"></span>
                                <ul class="drop">
                                    <li itemprop="name"><a itemprop="url" href="/about/action/">Акции</a></li>
                                    <li itemprop="name"><a itemprop="url" href="/about/vacancy/">Вакансии</a></li>
                                    <li itemprop="name"><a itemprop="url" href="/about/contacts/">Контакты</a></li>
                                </ul>
                            </li>
                        <li itemprop="name"><span><?=$this->_ret['h1']?></span></li>
                </ul>
            </div>
        </div>
    </section>
<section class="title-block">
        <div class="container">
            <div class="grid-12">
                <h2><?=$this->_ret['h1']?></h2>
            </div>
        </div>
</section>
        <div class="container">
            <div class="grid-12">
                <p class="non-block-text" style="color:black;"><?=$this->_datas['content']?></p>
            </div>
        </div>
    <section class="block-section">
       <div class="container">
            <div class="grid-12">
                <div class="block-list block-list block-list-auto">
                    <div class="block block-table block-auto block-service-table">
                        <div class="block-inside">
                            <h3><?=$this->_datas['text']?></h3>
                            <div class="services-item-table services-item-table-full">
                                <a class="services-item-row" style="color: black; font-weight: 500;">
                                    <span class="services-item-name" style="text-decoration: none;">Название услуги</span>
                                    <span class="services-item-value" style="margin-right: 33%;">Стоимость</span>
                                </a> 
                                <? 
                                    foreach ($price_list[$this->_datas['static']] as $key => $value){
                                    if (is_array($value[0])){
                                        ?>
                                            <h3 style="margin: 20px;"><?=$key?></h3>
                                        <?
                                        foreach ($value as $value) {
                                        ?>
                                        <div class="a services-item-row">
                                            <span class="services-item-name" itemprop="name"><?=$value[0]?></span>
                                            <span class="services-item-value"><?=$value[1]?></span>
                                            <span class="services-item-callback">
                                                <button href="#callback" class="service-button-callback" data-toggle="modal">
                                                    <span>Заказать звонок</span>
                                                </button>
                                            </span>
                                                    <meta itemprop="price" content="700"><meta itemprop="priceCurrency" content="RUB">
                                        </div>
                                        <?
                                        }
                                    }else{        
                                ?>
                                    <div class="a services-item-row">
                                        <span class="services-item-name" itemprop="name"><?=$value[0]?></span>
                                        <span class="services-item-value"><?=$value[1]?></span>
                                        <span class="services-item-callback">
                                            <button href="#callback" class="service-button-callback" data-toggle="modal">
                                                <span>Заказать звонок</span>
                                            </button>
                                        </span>
                                                <meta itemprop="price" content="700"><meta itemprop="priceCurrency" content="RUB">
                                    </div>
                                <?
                                    }}
                                ?>
                               
                            </div>
                        </div>
                    </div>
               </div>
            </div>
        </div>
    </section>
        <? include ('pomosch-block-promo.php');
       include ('pomosch-block-how-we-work.php'); ?>
<!--     <section class="link-block-section">
        <div class="container">
            <div class="grid-12">
                <div class="link-block-list perelink">
                    <a href="/about/action/" class="link-block">
                        <div class="link-block-title-strong">Акции</div>Акционные услуги, снижение стоимости, скидки 
                    </a>
                    <a href="/about/vacancy/" class="link-block">
                        <div class="link-block-title-strong">Вакансии</div>Работа в успешной компании, карьера 
                    </a>
                    <a href="/about/contacts/" class="link-block">
                        <div class="link-block-title-strong">Контакты</div>Телефон, время работы, адрес
                    </a>
            </div>
            </div>
    </section> -->
</main>