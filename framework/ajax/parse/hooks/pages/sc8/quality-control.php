<header class="secondary order-master">
    <div class="container">
        <ul class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <a itemprop="name" href="/">Главная</a>
                <meta itemprop="position" content="1"/>
            </li>
            <li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <span itemprop="name">Отдел контроля качества</span>
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
                <h1><?= $this->_ret['h1']; ?></h1>
                <p class="text-justify"><?= $this->_ret['banner_txt']; ?></p>
                <a href="#" class="btn scroll-btn" style="margin-top: 83px;">Записаться на ремонт</a>
            </div>
        </div>
    </div>
</div>
