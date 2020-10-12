<?  //dont work!
    $marka = $this->_datas['marka']['name'];
    $marka_ru =  $this->_datas['marka']['ru_name'];
?>
      <main>
            <section class="description-section">
                <div class="container">
                    <div class="grid-12">
                        <h1><?=$this->_ret['h1']?></h1>
                    </div>
                </div>
                <div class="description-full container">
                    <div class="grid-12">
                        <div class="description-image">
                            <img src="/bitrix/templates/remont/images/shared/vyiezd.png"/>
                        </div>

                        <div class="description-text">
                            <div class="title">Почему 8 из 10 клиентов отмечают высокое качество сервиса?</div>
                            <div class="text">
                                Преимуществом услуг центра сервиса <?=$marka_ru?> в Москве является доставка неисправных гаджетов. В согласованное время 
                                представитель центра бесплатно приедет домой, в учреждение или организацию, незначительные поломки могут быть устранены на месте. 
                                Для аппаратного устранения неисправностей, требующего специальных условий, замены деталей, гаджет быстро и аккуратно доставят в
                                сервисный центр. Мастер-инженер или курьер выезжают к заказчику в течение часа после оформления заявки.
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
           <? include __DIR__.'/devices.php'; ?>
	       <? include __DIR__.'/form.php'; ?>
           <? include __DIR__.'/preims.php'; ?>
           
    </main>