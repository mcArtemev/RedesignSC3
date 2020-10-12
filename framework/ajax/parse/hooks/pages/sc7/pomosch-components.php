<?
    $price_list = [
            'Накопители'=>[
                    ['HDD 1 Тб',4000],
                    ['HDD 500 Гб',3000],
                    ['SSD 500 Гб',4000],
                    ['SSD 1 Тб',8000],
                    ['SD - карта до 16 Гб',450],
                    ['SD - карта от 16 Гб',1000],
            ],
    ];


?>
<main>
    <section class="breadcrumbs">
        <div class="container">
            <div class="grid-12" itemscope="" itemtype="http://schema.org/BreadcrumbList" id="breadcrumbs">
            <ul class="breadcrumbs-inside">
                <li itemprop="name"><a href="/" itemprop="url">Главная</a></li>
                <li class="breadcrumbs-inside-drop"><a href="/info/">
                    <span itemprop="name">Информация</span></a>
                    <span class="breadcrumbs-inside-drop-btn"></span>
                <ul class="drop">
                     <li itemprop="name"><a itemprop="url" href="/info/time-to-repair/">Время ремонта</a></li>
                     <li itemprop="name"><a itemprop="url" href="/info/delivery/">Выезд и доставка</a></li>
                     <li itemprop="name"><a itemprop="url" href="/info/diagnostics/">Диагностика</a></li>
                     <li itemprop="name"><a itemprop="url" href="/info/hurry-up-repairs/">Срочные работы</a></li>
                </ul>
                </li>
                <li itemprop="name">
                <span>Комплектующие</span>
                </li>
            </ul>
            </div>
        </div>
    </section>
<section class="title-block">
        <div class="container">
            <div class="grid-12">
                <h1>Комплектующие</h1>
            </div>
        </div>
</section>
        <div class="container">
            <div class="grid-12">
                <p class="non-block-text" style="color:black;"><?=$description_page_components?></p>
            </div>
        </div>
    <section class="block-section">
       <div class="container">
            <div class="grid-12">
                <div class="block-list block-list block-list-auto">
                    <div class="block block-table block-auto block-service-table">
                        <div class="block-inside">
                            <div class="services-item-table services-item-table-full">
                                <a class="services-item-row" style="color: black; font-weight: 500;">
                                    <span class="services-item-name" style="text-decoration: none;">Название услуги</span>
                                    <span class="services-item-value" style="margin-right: 33%;">Стоимость</span>
                                </a>
                                <? foreach ($price_list as $key => $value){ 
                                ?>
                                    <h3 style="text-align: center;margin:20px;"><?=$key?></h3>
                                <?    
                                    foreach ($value as $key) {
                                        
                                ?>
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
                                <?
                                    }
                                  }
                                ?>
                               
                            </div>
                        </div>
                    </div>
               </div>
            </div>
        </div>
    </section>
<section class="link-block-section">
    <div class="container">
        <div class="link-block-list perelink">
            <a href="/info/hurry-up-repairs/" class="link-block">
                <div class="link-block-title-strong">Срочные работы</div>Время, условия </a>
                <a href="/info/delivery/" class="link-block">
                    <div class="link-block-title-strong">Выезд и доставка</div>Сроки, условия, цена </a>
                    <a href="/info/diagnostics/" class="link-block">
                        <div class="link-block-title-strong">Диагностика</div>Внешняя, программная, аппаратная </a>
                        <a href="/info/time-to-repair/" class="link-block">
                            <div class="link-block-title-strong">Время ремонта</div>Время восстановления: компьютеров </a>
        </div>
    </div>
</section>
</main>