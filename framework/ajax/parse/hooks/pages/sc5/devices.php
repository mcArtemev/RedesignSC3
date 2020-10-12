<?      use framework\tools;
        $marka_lower = mb_strtolower($this->_datas['marka']['name']);
        //$accord = array('смартфон' => 'telefonov', 'ноутбук' => 'notebooks', 'планшет' => 'planshetov', 'фотоаппарат' => 'foto');
        //$accord2 = array('смартфон' => 'telefon', 'ноутбук' => 'notebook', 'планшет' => 'planshet', 'фотоаппарат' => 'foto');
        
        $accord = $this->_datas['accord_url'];
        $accord2 = $this->_datas['accord_image'];
        
        $apple_device_type = array('ноутбук' => 'MacBook', 'планшет' => 'iPad', 'смартфон' => 'iPhone'); 
        
        $count_devices = count($this->_datas['all_devices']);
                        
        $break = $count_devices;
        if ($count_devices % 3 == 0) $break = 3;
        if (!$break && ($count_devices % 2 == 0)) $break = 2;
             
        $i = 0;
?>
    <section class="whitebg">
        <div class="container">
            <h2>Что вам нужно отремонтировать?</h2>
            <div class="row services-list">


                <? foreach ($this->_datas['all_devices'] as $devices) {
                    if (file_exists("/var/www/www-root/data/www/sc5/bitrix/templates/remont/images/".$marka_lower."/".$accord2[$devices['type']]."-mini.png")){
                        $littleImg = "background-image: url(/bitrix/templates/remont/images/".$marka_lower."/".$accord2[$devices['type']]."-mini.png)";
                    }else{
                        $littleImg = "background-image: url(/bitrix/templates/remont/images/stub/little/".$accord2[$devices['type']].".png)";
                    }
                ?>
                    <div class="col-sm-4 col-xs-6">
                        <div     class="item">
                            <a href="/remont-<?= $accord[$devices['type']] ?>-<?= $marka_lower ?>/" class="service-link">
                                <div class="service-images contain-img" style="<?=$littleImg?>">
                                    <img src="/bitrix/templates/remont/images/shared/empty-service.png"/>
                                </div>
                                <?
                                if ($marka_lower == 'apple'):?>
                                    <div class="service-title"><?= (isset($apple_device_type[$devices['type']]) ? $apple_device_type[$devices['type']] : tools::mb_ucfirst($devices['type'])) ?></div>
                                <? else:?>
                                    <div class="service-title"><?= tools::mb_ucfirst($devices['type']) ?></div>
                                <?endif; ?>
                            </a>
                        </div>
                    </div>
                <? } ?>
            </div>
        </div>
    </section>


