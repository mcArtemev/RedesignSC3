<div class="breadcrumbs">
    <span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/"><span itemprop="title">Главная</span></a></span>
    <?php if(preg_match('/^company\/(.+)?/', $this->_datas['arg_url'])) :; ?>
        &nbsp;|&nbsp;
        <span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/company/">
                        <span itemprop="title">О компании</span>
                    </a></span>
        &nbsp;|&nbsp;
        <span><?php echo $this->_datas['menu']['/'.$this->_datas['arg_url'].'/']; ?></span>
    <?php else :; ?>
        &nbsp;|&nbsp;
        <span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
            <span itemprop="title">О компании</span>
        </span>
    <?php endif; ?>
</div>