<? use framework\tools; 
$accord = $accord = $this->_datas['accord']; ?> 
        <aside class="aside-menu">                
                <ul>
                <? foreach ($this->_datas['all_devices'] as $devices)
                     {
                        $st_url = "/".$accord[$devices['type']]."/";
                        $v = tools::mb_ucfirst($devices['type_m'], 'utf-8', false);
                        if ($url == $st_url)
                            echo '<li><span class="active">'.$v.'</span></li>';
                        else
                            echo '<li><a href="'.$st_url.'">'.$v.'</a></li>';
                     }
                ?>
                </ul>                
                
                <!--noindex-->
                <section class="prefMain no-height">
 
                 <div class="block-menu-new">
                     <div class="pref">
                        <a href="/delivery/">Выезд курьера</a>
                        <p>Курьерская доставка в сервисный центр из любой точки <?=$this->_datas['region']['name_re']?></p>
                     </div>
                     <div class="pref">
                        <a href="/diagnostics/">Диагностика за 15 минут</a>
                        <p>Выявление неисправности устройства в кратчайшие сроки.</p>
                     </div>
                     <div class="pref last">
                        <a href="/services/">Срочный ремонт</a>
                        <p>Экспресс ремонт за 1-2 часа. Комплектующие в наличии.</p>
                     </div>        
                    <div class="clear"></div>
                </div>
        
                </section>
                <!--/noindex-->
            </aside>