<? include __DIR__.'/data/sitemap.php';

$region_name_pe = $this->_datas['region']['name_pe'];
$sitemap = get_sitemap(mb_strtolower($this->_datas['marka']['name']), $region_name_pe);

?>

<main>
    <section class="breadcrumbs">
        <div class="container">
            <div class="grid-12" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                <ul class="breadcrumbs-inside">
                   <li itemprop="name"><a href="/" itemprop="url">Главная</a></li>  
                   <li itemprop="name"><span>Карта сайта</span></li>
                </ul>
            </div>
        </div>
    </section>
    <section class="title-block">
        <div class="container">
            <div class="grid-12">
                <h1><?=$this->_ret['h1']?></h1>
                <ul class="sitemap">
                    <? foreach ($sitemap as $url => $anchor):?>
                        <li><a href="<?=$url?>"><?=$anchor?></a></li>
                    <?endforeach;?>
                </ul>
            </div>
        </div>
    </section>
</main>