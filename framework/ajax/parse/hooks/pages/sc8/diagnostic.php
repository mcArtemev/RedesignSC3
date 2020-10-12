<header class="secondary diagnostic">
    <div class="container">
        <ul class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <a itemprop="name" href="/">Главная</a>
                <meta itemprop="position" content="1" />
            </li>
            <li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <span itemprop="name">Диагностика техники</span>
                <meta itemprop="position" content="2" />
            </li>
        </ul>
    </div>
</header>

<div class="diag-banner">
    <div class="container">
        <h1><?= $this->_ret['h1'] ?></h1>
        <p>Стоимость диагностики составляет 0 рублей, кроме случаев заказа этой услуги отдельной. Заказ диагностики без ремонта – 500 рублей. Среднее время диагностики 25-45 минут. Важно принимать во внимание, что проверка устройств может стать долгой в плане времени, из-за серьезности поломки. В сложных случаях комплексное тестирование аппарата может занимать до 2-3 дней.</p>
        <a href="#" class="btn scroll-btn btn-gr" style="margin-top: 37px;">Записаться на диагностику</a>
    </div>
</div>

<div class="diag-desc">
    <div class="container">
        <h2><?= $this->_ret['h2']; ?></h2>
        <p class="mb-30">Мы можем осуществить диагностику любой техники, начиная с смартфонов и заканчивая холодильниками. Бренд и его распространенность не доставляют затруднения для проведения диагностики. Мастера производят глобальную проверку и находят дефект. Запись осуществляется не только по телефону или офисе сервис-центра, но и дистанционно путем формирования заявки через официальный сайт. В форме желательно указать фирму, вид технического устройства, и происшествие, которое привело к поломке данной модели. После заполнения формы следует подождать 15-25 минут, и с вами свяжется оператор сервиса.</p>

        <?php include __DIR__ . '/inc/work_scheme.php'; ?>

    </div>
</div>

<? $this->_datas['form_title'] = '  Записаться на диагностику'; ?>