<?     
        //include_once "text/index.php";
         
        function head($i)
        {
            $head = '<div class="price-content'.(($i==1)? " active" : "").'" id="price-tabs-'.$i.'">';
            return $head;
        }

        use framework\tools;
        use framework\pdo;
        use framework\ajax\parse\parse;

        $marka_lower = mb_strtolower($this->_datas['marka']['name']);
        //$accord = array('смартфон' => 'telefonov', 'ноутбук' => 'notebooks', 'планшет' => 'planshetov', 'фотоаппарат' => 'foto');
        //$accord2 = array('смартфон' => 'telefon', 'ноутбук' => 'notebook', 'планшет' => 'planshet', 'фотоаппарат' => 'foto');  
        
        $accord = $this->_datas['accord_url'];
        $accord2 = $this->_datas['accord_image']; 
        
        $setka_name = $this->_datas['setka_name'];
        
        $apple_device_type = array('ноутбук' => 'MacBook', 'планшет' => 'iPad', 'смартфон' => 'iPhone'); 
        
        $count_devices = count($this->_datas['all_devices']);
                        
        $break = $count_devices;
        if ($count_devices % 3 == 0) $break = 3;
        if (!$break && ($count_devices % 2 == 0)) $break = 2;
             
        $i = 0;


// Get price content
function getByMultiCurl($pricesUrl) {
    $mh = curl_multi_init();
    $arr = [];
    
    foreach ($pricesUrl as $k => $url) {
        $ch_name = 'ch_'.$k;
        $$ch_name = curl_init();

        if (function_exists("idn_to_ascii")) {
            $new_url = str_ireplace(parse_url($url)['host'], @idn_to_ascii(parse_url($url)['host']), $url);
            if ($new_url != $url) {
                $url = $new_url;
            }
        }

        curl_setopt($$ch_name, CURLOPT_URL, $url);
        curl_setopt($$ch_name, CURLOPT_HEADER, 0);

        curl_setopt($$ch_name, CURLOPT_RETURNTRANSFER, true);
        curl_multi_add_handle($mh,$$ch_name);
    }

    do {
        $status = curl_multi_exec($mh, $active);
        if ($active) {
            curl_multi_select($mh);
        }
    } while ($active && $status == CURLM_OK);

    foreach ($pricesUrl as $k => $url) {
        $ch_name = 'ch_'.$k;

        $result  = curl_multi_getcontent($$ch_name);
        preg_match('|(<div class="prices">)(.*?)(</div>)|is', $result, $array);
        // var_dump($array);
        $arr[] = $array[0];
        curl_multi_remove_handle($mh, $$ch_name);
    }

    curl_multi_close($mh);

    return $arr;
}



?>
    <section class="page">
        <div class="container">
            <?php include_once __DIR__ . '/breadcrumb.php' ?>
            <div class="textblock">
                <h1><span class="smallh1"><?=$this->_ret['h1']?></span></h1>
                <div>
                    <div class="services-list owl-carousel owl-theme owl-loaded nav nav-tabs" role="tablist" id="price-table-tabs">
                        <?php
                        $pricesUrl = [];
                        $i = 0;
                        foreach ($this->_datas['all_devices'] as $devices)
                        {
                            // if(preg_match('/[a-zA-Z]/',$this->_datas['site_name']==0)){
                            $pricesUrl[] = 'https://' . $this->_datas['site_name']."/remont-".$accord[$devices['type']]."-".$marka_lower . '/';
                            
                            // }else{
                            //     $pricesUrl[] = 'https://' . idn_to_ascii($this->_datas['site_name'])."/remont-".$accord[$devices['type']]."-".$marka_lower . '/';
                            // }
                            $i++; 
                            if (file_exists("/var/www/www-root/data/www/sc5/bitrix/templates/remont/images/".$marka_lower."/".$accord2[$devices['type']]."-mini.png")){
                                $littleImg = "background-image: url(/bitrix/templates/remont/images/".$marka_lower."/".$accord2[$devices['type']]."-mini.png)";
                            }else{
                                $littleImg = "background-image: url(/bitrix/templates/remont/images/stub/little/".$accord2[$devices['type']].".png)";
                            } 
                            ?>
                            <div role="presentation"  class="item<?=(($i==1)? " active" : "")?>">
                                <a href="#price-tabs-<?=$i?>" class="service-link" aria-controls="price-tabs-<?=$i?>" role="tab" data-toggle="tab">
                                    <div class="service-images contain-img" style="<?=$littleImg?>">
                                        <img src="/bitrix/templates/remont/images/shared/empty-service.png"/>
                                    </div>
                                    <?if ($marka_lower == 'apple'):?>
                                        <div class="service-title"><?=(isset($apple_device_type[$devices['type']]) ? $apple_device_type[$devices['type']] : tools::mb_ucfirst($devices['type']))?></div>
                                    <?else:?>
                                        <div class="service-title"><?=tools::mb_ucfirst($devices['type'])?></div>
                                    <?endif;?>
                                </a>
                            </div>
                        <?php }; ?>
                    </div>

                    <div class="price-content tab-content">
                    <?php $pricesTables = getByMultiCurl($pricesUrl);
                        foreach ($this->_datas['all_devices'] as $k => $devices) {
                            $tabIndex = $k+1;
                            $activeClass = ( 1 === $tabIndex ) ? ' in active' : '';
                            echo '<div role="tabpanel" class="tab-pane fade'.$activeClass.'" id="price-tabs-'.$tabIndex.'">';
                                echo $pricesTables[$k];
                            echo '</div>';
                        }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include __DIR__.'/ask_expert.php'; ?>

    <?php
        $section_class = 'whitebg';
        include __DIR__.'/preims.php';
        unset($section_class);
    ?>
