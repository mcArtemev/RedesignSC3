<header class="secondary order-master">
    <div class="container">
        <ul class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <a itemprop="name" href="/">Главная</a>
                <meta itemprop="position" content="1"/>
            </li>
            <li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <span itemprop="name">Гарантии</span>
                <meta itemprop="position" content="2"/>
            </li>
        </ul>
        <!--<a href="/"><p class="back-home">Вернуться на главную страницу</p></a>-->
    </div>
</header>

<div class="master-banner  pt-40 pb-55">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1><?= $this->_ret['h1'] ?></h1>
                <p class="text-justify"><?= $this->_ret['guarant_txt_1']; ?> <?= $this->_ret['guarant_txt_2']; ?>
                    <?= $this->_ret['guarant_txt_3']; ?> <?= $this->_ret['guarant_txt_4']; ?></p>
                <a href="#" class="btn scroll-btn" style="margin-top: 37px;">Записаться на ремонт</a>
            </div>

        </div>
    </div>
</div>

<div class="master-desc">
    <div class="container">
        <h2><?= $this->_ret['h2'] ?></h2>
        <p class="text-justify mb-30">Обычно все возможные недочеты по произведенному ремонт проявляются в течении нескольких
            месяцев. Мы заботимся о своих клиентах, поэтому всегда готовы контролировать выполненную нами работу.
            Гарантия выдается как на услуги мастера, так и на сами установленные детали. На все ремонтные работы,
            выполненные специалистами, в нашем сервисном центре дается обязательная гарантия, ее период мастер
            определяет самостоятельно, оценивая все детали выполненной работы. Минимальный срок гарантии составляет не
            менее трех месяцев, но обычно мы указываем больший период. Поскольку, все используемые детали только
            оригинальные и от официальных поставщиков, у каждой есть свой указанный производителем гарантийный срок
            службы. Для подтверждения своих обязательств, при приеме заказчиком отремонтированной техники, обязательно
            выдается гарантийный талон с четко прописанными в нем сроками и перечислением всех случаев, в которых они
            будут выполнены.</p>
        <?php include __DIR__ . '/inc/work_scheme.php'; ?>
    </div>
</div>
