<? use framework\tools;
$accord = $this->_datas['typeUrl'];
$url = ($this->_datas['arg_url'] != '/') ? '/'.$this->_datas['arg_url'].'/' : '/';
?>
        <aside class="aside-menu">
                <ul>
                <? foreach ($this->_datas['all_devices'] as $devices)
                     {
                        $st_url = "/".$accord[$devices['type']]."/";
                        $v = tools::mb_ucfirst($devices['type_m'], 'utf-8', false);
                        if ($url == $st_url)
                            echo '<li><span class="active">'.$v.'</span></li>';
                        else if (isset($this->_datas['model_type']['id']) && $this->_datas['model_type']['id'] == $devices['type_id'])
                            echo '<li><a class="active" href="/amp'.$st_url.'">'.$v.'</a></li>';
                        else
                            echo '<li><a href="/amp'.$st_url.'">'.$v.'</a></li>';
                     }
                ?>
                  </ul>

                <!--noindex-->
                <section class="prefMain no-height">

                 <div class="block-menu-new">
                     <div class="pref">
                        <a href="/dostavka/">Выезд курьера</a>
                        <p>Курьерская доставка в сервисный центр из любой точки <?=$this->_datas['region']['name_re']?></p>
                     </div>
                     <div class="pref">
                        <a href="/diagnostika-<?=strtolower($this->_datas['marka']['name'])?>/">Диагностика за 15 минут</a>
                        <p>Выявление неисправности устройства в кратчайшие сроки.</p>
                     </div>
                     <div class="pref last">
                        <a href="/ekspress-remont/">Срочный ремонт</a>
                        <p>Экспресс ремонт за 1-2 часа. Комплектующие в наличии.</p>
                     </div>
                    <div class="clear"></div>
                </div>

                </section>
                <!--/noindex-->
            </aside>
