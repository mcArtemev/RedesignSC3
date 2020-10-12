<section class = "hello">
  <div class="fixed">
    <h1>Сеть сервисных центров <?=$this->_datas['servicename']?> в <?=$this->_datas['region']['name_pe']?></h1>
    <div class="hello__photo">
        <img src="/bitrix/templates/centre/img/site/large/sony-centre2.png" width="415" height="221" alt="Sony Centre - сервисный центр Сони" title="Sony Centre - сервисный центр Сони">
    </div>
    <div class="hello__info">
      <p><?=$this->_datas['servicename']?> - сеть сервисных центров по России. <?=$this->_datas['servicename']?> проводит ремонт различных типов техники: <?=implode(', ', array_column($this->_datas['allTypes'], 'type_m'))?> от именитых брендов: <?=implode(', ', array_keys($this->_datas['markaTypes']))?>.</p>
    </div>
  </div>
</section>
<section class = "experts">
  <div class = "wrapper lgray">
    <div class = "fixed">
      <span class = "h2">Выберите свой бренд</span>
      <?php foreach ($this->_datas['markaTypes'] as $marka => $types) { ?>
      <a href = "/servis-<?=strtolower($marka)?>/" class = "mainBrand">
              <img src = "/bitrix/templates/centre/img/mainBrand/<?=strtolower($marka)?>.png">
        <span><?=$marka?></span>
      </a>
      <?php } ?>
    </div>
    <div class="display-none"><?=$this->_datas['phone_yd'].' '.$this->_datas['phone_ga']?></div>
  </div>
</section>
