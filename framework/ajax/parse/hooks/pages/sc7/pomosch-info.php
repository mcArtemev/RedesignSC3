<?
use framework\tools;
use framework\ajax\parse\hooks\sc;

$servicename = $this->_datas['servicename']; //SONY Russia

srand($this->_datas['feed']);

$feed = $this->_datas['feed'];

?>

<main>
<section class="breadcrumbs">
            <div class="container">
                <div class="grid-12" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                    <ul class="breadcrumbs-inside">
                       <li itemprop="name"><a href="/" itemprop="url">Главная</a></li>  
                       <li itemprop="name"><span>Информация</span></li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="title-block">
            <div class="container">
                <div class="grid-12">
                    <h1>Информация</h1>
                </div>
            </div>
            </section>
    <section class="block-section">
        <div class="container">
            <div class="grid-12">
                <div class="block-list">
                    <div class="block block-big block-bottom-image">
                        <div class="block-inside">
                            <p><?=$description_page_info?></p>
                        </div>
                    </div>
                    <div class="block block-big block-diagramm">
                        <div class="block-inside">
                            <div class="diagramm-list-title"><?=$servicename?> цифрами:</div>
                            <canvas id="chart-bar-0" width="530" height="433"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="link-block-section">
        <div class="container">
            <div class="grid-12">
                <div class="link-block-list">
                     <? foreach ($this->_datas['blocks'] as $block)
                            echo sc::_createTree($block, $feed); ?>
                </div>
                <div class="block-list center">      
                    <ul class="block-list-links line">
                        <li><a href="/about/">О компании</a></li>
                        <li><a href="/info/time-to-repair/">Время работ</a></li>
                        <li><a href="/info/delivery/">Выезд и доставка</a></li>
                        <li><a href="/info/diagnostics/">Диагностика</a></li>
                        <li><a href="/info/components/">Комплектующие</a></li>
                        <li><a href="/info/hurry-up-repairs/">Срочные работы</a></li>  
                    </ul>                    
                </div>
            </div>
    </section>      
    <?
    echo '<div class="label-wrapper" style="display:none">';
    foreach (array("Срочные работы", "Восстановлено устройств", "Выездов сделано", "Диагностик проведено", "Данных восстановлено") as $key => $label)
    {
        echo '<span style="display:none" class="label" data-val="'.$this->_datas['r'][$key].'">'.$label.'</span>';
    }
    
    echo '<input type="hidden" name="max" value="'.$this->_datas['rand_ustroistva'].'"></div>'; ?>
</main>