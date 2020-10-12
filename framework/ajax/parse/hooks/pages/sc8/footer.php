<?php
$menu = $this->_datas['menu_footer'];
$menu_type = $this->_datas['menu_types'];
$menu_dop = $this->_datas['menu_dop'];

$urlm = ($this->_datas['arg_url'] != '/') ? '/'.$this->_datas['arg_url'].'/' : '/';
$local = $this->_datas['isLocal'];

?>
    <? include __DIR__.'/'.$this->_datas['block_form'] .'.php'; ?>
    
    <footer id="footer">
      <div class="container">
        <div class="row">
          <div class="col-sm-3">
            <img src="/custom/saapservice/img/logo-footer.png" alt="">
          </div>
          <div class="col-sm-9">
            <!--<ul class="footer-top-nav">
                <? foreach ($menu_dop as $key => $value) {
                    if ($urlm == $key)
                        echo '<li class="active-menu"><span>' . $value . '</span></li>';
                    else
                        echo '<li><a href="' . $key . '">' . $value . '</a></li>';
                }
                ?>
            </ul>-->
          </div>
        </div>
        <div class="row" style="margin-top: 25px;">
          <div class="col-sm-7">
            <p class="nav-title">Услуги ремонта</p>
           <?php
            unset($menu_type['/fridge-service/'], $menu_type['/washing-machine-service/']); 
            $type_cnt = count($menu_type);
             ?>
            <div class="col-sm-6" style="padding-left: 0;">
                <ul class="footer-sec-nav">
                     <? foreach (array_slice($menu_type, 0,$type_cnt / 2 + 1) as $key => $value) {
                        if ($urlm == $key)
                            echo '<li class="active-menu"><span>' . $value . '</span></li>';
                        else
                            echo '<li><a href="' . $key . '">' . $value . '</a></li>';
                    }
                    ?>
                </ul>
            </div>
            <div class="col-sm-6" style="padding-left: 0;">
                <ul class="footer-sec-nav">
                    <? foreach (array_slice($menu_type, $type_cnt / 2 + 1) as $key => $value) {
                        if ($urlm == $key)
                            echo '<li class="active-menu"><span>' . $value . '</span></li>';
                        else
                            echo '<li><a href="' . $key . '">' . $value . '</a></li>';
                    }
                    ?>
                </ul>
            </div>
          </div>
          <div class="col-sm-3">
            <p class="nav-title">Клиентам</p>
            <ul class="footer-sec-nav">
                <? foreach ($menu as $key => $value)
                {
                    if ($urlm == $key)
                        echo '<li class="active-menu"><span>'.$value.'</span></li>';
                    else
                        echo '<li><a href="'.$key.'">'.$value.'</a></li>';
                }
                ?>
            </ul>
          </div>
          <div class="col-sm-2">
            <p class="nav-title">Компания</p>
            <ul class="footer-sec-nav">
                <?php if ($urlm == '/about/') :;?>
                    <li class="active-menu"><span>О компании</span></li>
                <?php else: ?>
                    <li><a href="/about/">О компании</a></li>
                <?php endif; ?>
                <?php if ($urlm == '/about/testimonials/') :;?>
                    <li class="active-menu"><span>Отзывы</span></li>
                <?php else: ?>
                    <li><a href="/about/testimonials/">Отзывы</a></li>
                <?php endif; ?>
                <?php if ($urlm == '/about/quality-control/') :;?>
                    <li class="active-menu"><span>Контроль качества</span></li>
                <?php else: ?>
                    <li><a href="/about/testimonials/">Контроль качества</a></li>
                <?php endif; ?>
                <?php if ($urlm == '/about/contacts/') :;?>
                    <li class="active-menu"><span>Контакты</span></li>
                <?php else: ?>
                    <li><a href="/about/contacts/">Контакты</a></li>
                <?php endif; ?>
            </ul>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <p class="copyright">&copy <?=date("Y")?> <?=mb_strtoupper($this->_datas['site_name']);?> <br>Все права защищены. <a href="/about/privacy-policy/">Политика обработки персональных данных</a></p>
          </div>
        </div>
      </div> 
    </footer>
    </body>
</html>