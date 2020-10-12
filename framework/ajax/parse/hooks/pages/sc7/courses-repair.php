<?
use framework\tools;

$marka = $this->_datas['marka']['name'];  // SONY
$servicename = $this->_datas['servicename']; //SONY Russia
$ru_servicename = $this->_datas['ru_servicename']; //
$ru_marka = $this->_datas['marka']['ru_name']; // СОНИ
$region_name = $this->_datas['region']['name'];//Москва
$region_name_pril = $this->_datas['region']['pril'];//Московского
$region_name_pe = $this->_datas['region']['name_pe'];//в Москве (в Владивостоке)
$region_name_de = $this->_datas['region']['name_de'];//по Москве (Владивостоку)
$region_name_re = $this->_datas['region']['name_re'];//служба Москвы (Владивостока)
$phone = $this->_datas['phone'];
$phone_format = tools::format_phone($phone);
include('description_vacancy.php');
?>
<style>
	.container {
		position:static;
	}
    p{
        margin: revert;
        text-align: justify;
    }
    .btn.btn-accent a {
        color:white;
    }
    .btn.btn-accent {
        padding: 0;
        margin: 0 auto;
        display: flex;
        justify-content: center;
        text-align: center;
        margin-top: 25px;
        max-width: 250px;
    }
    .btn.btn-accent:after {
        content: '';
    }
    .block {
        margin-right: 50px;
        width: auto;
    }
</style>

<main>
    <section class="breadcrumbs">
        <div class="container">
            <div class="grid-12" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                <ul class="breadcrumbs-inside">
                       <li itemprop="name"><a href="/" itemprop="url">Главная</a></li>  
                            <li class="breadcrumbs-inside-drop">
                                <span itemprop="name"><a itemprop="url" href="/about/">О компании</a></span>
                                <span class="breadcrumbs-inside-drop-btn"></span>
                                <ul class="drop">
                                    <li itemprop="name"><a itemprop="url" href="/about/action/">Акции</a></li>
                                    <li itemprop="name"><a itemprop="url" href="/about/contacts/">Контакты</a></li>
                                    <li itemprop="name"><a itemprop="url" href="/about/price/">Услуги и цены</a></li>
                                </ul>
                            </li>
                        <li itemprop="name"><span>Обучение мастеров</span></li>
                </ul>
            </div>
        </div>
    </section>

    <section class="title-block">
        <div class="container">
            <div class="grid-12">
                <h1><?=$this->_ret['h1']?></h1>
            	<p class="non-block-text"><?=$education_master?></p>
            </div>
        </div>
    </section>
    <section class="block-section">
        <div class="container">
            <div class="grid-12">
                <div class="block-list block-list">
                    <div class="block block-auto block-table">
                        <div class="block-inside">
	                        <h3>Учебные курсы:</h3>
                            <div class="services-item-table">
                                <span class="services-item-row">
                                    <span class="services-item-name">Повышение квалификации</span>
                                    <span class="services-item-value">8 000</span>
                                </span>
                                <span class="services-item-row">
                                    <span class="services-item-name">Полная программа обучения</span>
                                    <span class="services-item-value">16 000</span>
                                </span>
                            </div>
                    	</div>
                    </div>
                </div>
                <div class="btn btn-accent">
                    <a href="#callback"data-toggle="modal">Записаться на курс</a>
                </div>
                <section class="title-block">
                    <p class="non-block-text"><?=$education_master2?></p>
                </section>
            </div>
<!--         <div class="grid-12">
            <div class="link-block-list perelink">
                <a href="/about/vacancy/" class="link-block">
                    <div class="link-block-title-strong">Контакты</div>
                </a>
                <a href="/about/price/" class="link-block">
                    <div class="link-block-title-strong">Услуги</div>
                </a>
                <a href="/about/action/" class="link-block">
                    <div class="link-block-title-strong">Акции</div>
                </a>
            </div> 
        </div> -->
        </div>
    </section>
</main>