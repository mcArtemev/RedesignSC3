<?

use framework\tools;

$marka = $this->_datas['marka']['name'];
$marka_lower = mb_strtolower($this->_datas['marka']['name']);
$ru_marka =  $this->_datas['marka']['ru_name'];
$servicename = $this->_datas['servicename'];
$metrica = $this->_datas['metrica'];
$region_code = ($this->_datas['region']['code']) ? '-'.$this->_datas['region']['code'] : '';

$add_device_type = $this->_datas['add_device_type'];

$default_array = array( 
    '<table class="priceTable uk-table uk-table-hover uk-table-striped services gadget"><tbody><tr class="uk-text-small"><th>Наименование услуги</th><th class="uk-text-center">Время ремонта<th class="uk-text-center">Цена, руб</th></tr>  <tr> <td>Диагностика</td> <td>2ч</td> <td>Бесплатно</td></tbody></table>',
            '',
            '0',
        );

$info_block  = array(
  
    'remont-varochnyh-panelej' => array( 
    '<table class="priceTable uk-table uk-table-hover uk-table-striped services gadget">
        <tbody>
            <tr class="uk-text-small">
                <th>Наименование услуги</th>
                <th class="uk-text-center">Время ремонта
                <th class="uk-text-center">Цена, руб
                </th>
            </tr>  
            <tr> <td>Диагностика</td> <td>30м</td> <td>Бесплатно</td>
            <tr> <td>Демонтаж встраиваемой панели</td> <td>2ч</td> <td>600</td>
            <tr> <td>Монтаж встраиваемой панели</td> <td>2ч</td> <td>600</td>
            <tr> <td>Замена инвертора индукционной варочной панели</td> <td>2ч</td> <td>2400</td>
            <tr> <td>Замена клеммной коробки</td> <td>2ч</td> <td>1400</td>
            <tr> <td>Замена конфорки</td> <td>2ч</td> <td>800</td>
            <tr> <td>Замена панели управления</td> <td>2ч</td> <td>1800</td>
            <tr> <td>Замена платы сенсорного управления</td> <td>2ч</td> <td>1700</td>
            <tr> <td>Замена регулятора мощности конфорки</td> <td>2ч</td> <td>900</td>
            <tr> <td>Замена реле</td> <td>2ч</td> <td>1100</td>
            <tr> <td>Замена сетевого шнура</td> <td>2ч</td> <td>800</td>
            <tr> <td>Замена стекла стеклокерамических варочных панелей</td> <td>2ч</td> <td>2000</td>
        </tbody>
    </table>',
    '',
    '600',
    ),
    'remont-monokoles' => array('
                     <table class="priceTable uk-table uk-table-hover uk-table-striped services gadget">
                <tbody>
                    <tr class="uk-text-small active">
                        <th>Наименование услуги</th>
                        <th class="uk-text-center">Время ремонта
                        <th class="uk-text-center">Цена, руб</th>
                    </tr>
                    <tr class="active"><td>Диагностика</td>
                       <td>30м</td><td>0</td>
                    </tr>
                    <tr class="active"><td>Замена bluetooth-платы</td>
                        <td>1ч</td><td>450</td>
                    </tr>
                    <tr class="active"><td>Замена аккумулятора</td>
                        <td>1ч</td><td>450</td>
                    </tr>
                    <tr class="active"><td>Замена габаритных огней</td>
                        <td>1ч</td><td>500</td>
                    </tr>
                    <tr class="active"><td>Замена гироскопа</td>
                        <td>1ч</td><td>600</td>
                    </tr>
                    <tr class="active"><td>Замена гнезда зарядки</td>
                        <td>1ч</td><td>500</td>
                    </tr>
                    <tr class="active"><td>Замена динамика</td>
                        <td>1ч</td><td>600</td>
                    </tr>
                    <tr class="active"><td>Замена камеры в колесе</td>
                        <td>30м</td><td>450</td>
                    </tr>
                    <tr class="active"><td>Замена комплекта плат</td>
                        <td>1ч</td><td>1200</td>
                    </tr>
                    <tr class="active"><td>Замена мотор-колеса</td>
                        <td>30м</td><td>600</td>
                    </tr>
                    <tr class="active"><td>Замена покрышки</td>
                        <td>1ч</td><td>450</td>
                    </tr>
                    <tr class="active"><td>Замена центральной платы</td>
                        <td>1ч</td><td>900</td>
                    </tr>
                    <tr class="active"><td>Ремонт каркаса</td>
                        <td>1д</td><td>1800</td>
                    </tr>
                    <tr class="active"><td>Ремонт мотор-колеса</td>
                        <td>1д</td><td>1200</td>
                    </tr>
                    <tr class="active"><td>Ремонт проводки</td>
                        <td>1д</td><td>450</td>
                    </tr>
                    <tr class="active"><td>Чистка мотор-колеса</td>
                        <td>1ч</td><td>1200</td>
                    </tr>
               </tbody>
            </table>
            ',
            '',
            '450'
            ),
    'remont-segveev' => array('             <table class="priceTable uk-table uk-table-hover uk-table-striped services gadget">
                <tbody>
                    <tr class="uk-text-small active">
                        <th>Наименование услуги</th>
                        <th class="uk-text-center">Время ремонта
                        <th class="uk-text-center">Цена, руб</th>
                    </tr>
                    <tr class="active"><td>Диагностика</td>
                        <td>30м</td><td>0</td>
                    </tr>
                    <tr class="active"><td>Замена аккумулятора </td>
                        <td>1ч</td><td>900</td>
                    </tr>
                    <tr class="active"><td>Замена амортизатора </td>
                        <td>1ч</td><td>150</td>
                    </tr>
                    <tr class="active"><td>Замена гнезда зарядного устройства </td>
                        <td>1д</td><td>600</td>
                    </tr>
                    <tr class="active"><td>Замена датчиков </td>
                        <td>1ч</td><td>1000</td>
                    </tr>
                    <tr class="active"><td>Замена датчиков Холла </td>
                        <td>1ч</td><td>1000</td>
                    </tr>
                    <tr class="active"><td>Замена двигателя </td>
                        <td>1ч</td><td>1300</td>
                    </tr>
                    <tr class="active"><td>Замена диска тормоза </td>
                        <td>1ч</td><td>300</td>
                    </tr>
                    <tr class="active"><td>Замена замка зажигания </td>
                        <td>1ч</td><td>200</td>
                    </tr>
                    <tr class="active"><td>Замена звездочки </td>
                        <td>1ч</td><td>300</td>
                    </tr>
                    <tr class="active"><td>Замена камеры</td>
                        <td>1ч</td><td>900</td>
                    </tr>
                    <tr class="active"><td>Замена кнопок </td>
                        <td>1ч</td><td>500</td>
                    </tr>
                    <tr class="active"><td>Замена контроллера </td>
                        <td>1ч</td><td>1000</td>
                    </tr>
                    <tr class="active"><td>Замена корпуса </td>
                        <td>1ч</td><td>1000</td>
                    </tr>
                    <tr class="active"><td>Замена крыльев </td>
                        <td>1ч</td><td>1000</td>
                    </tr>
                    <tr class="active"><td>Замена лампочек </td>
                        <td>1ч</td><td>300</td>
                    </tr>
                    <tr class="active"><td>Замена подножек </td>
                        <td>1ч</td><td>100</td>
                    </tr>
                    <tr class="active"><td>Замена подшипников </td>
                        <td>1ч</td><td>200</td>
                    </tr>
                    <tr class="active"><td>Замена ручки газа </td>
                        <td>1ч</td><td>200</td>
                    </tr>
                    <tr class="active"><td>Замена ручки тормоза </td>
                        <td>1ч</td><td>200</td>
                    </tr>
                    <tr class="active"><td>Замена спидометра </td>
                        <td>1ч</td><td>1000</td>
                    </tr>
               </tbody>
            </table>
            ',
            '',
            '150'
            ),
    'remont-giroskuterov' => array('
             <table class="priceTable uk-table uk-table-hover uk-table-striped services gadget">
                <tbody>
                    <tr class="uk-text-small active">
                        <th>Наименование услуги</th>
                        <th class="uk-text-center">Время ремонта
                        <th class="uk-text-center">Цена, руб</th>
                    </tr>
                    <tr class="active"><td>Диагностика</td>
                        <td>30м</td><td>0</td>
                    </tr>
                    <tr class="active"><td>Замена мотора колеса</td>
                        <td>30м</td><td>600</td>
                    </tr>
                    <tr class="active"><td>Замена гнезда зарядки</td>
                        <td>2ч</td><td>750</td>
                    </tr>
                    <tr class="active"><td>Ремонт материнской платы</td>
                        <td>2ч</td><td>700</td>
                    </tr>
                    <tr class="active"><td>Ремонт платы гироскопа</td>
                        <td>12ч</td><td>400</td>
                    </tr>
                    <tr class="active"><td>Ремонт платы управления</td>
                        <td>10м</td><td>1500</td>
                    </tr>
                    <tr class="active"><td>Замена элементов аккумулятора</td>
                        <td>12ч</td><td>2000</td>
                    </tr>
                    <tr class="active"><td>Калибровка аккумулятора</td>
                        <td>12ч</td><td>2000</td>
                    </tr>
                    <tr class="active"><td>Замена корпуса</td>
                        <td>40м</td><td>670</td>
                    </tr>
                    <tr class="active"><td>Замена покрышки</td>
                        <td>30м</td><td>1000</td>
                    </tr>
                    <tr class="active"><td>Замена датчиков холла</td>
                        <td>12ч</td><td>800</td>
                    </tr>
                    <tr class="active"><td>Ремонт блютуз</td>
                        <td>12ч</td><td>1000</td>
                    </tr>
                    <tr class="active"><td>Восстановление после попадания влаги</td>
                        <td>12ч</td><td>1750</td>
                    </tr>
               </tbody>
            </table>
            ',
            '',
            '400'
            ),
    'remont-vytyazhek' => array('
             <table class="priceTable uk-table uk-table-hover uk-table-striped services gadget">
                <tbody>
                    <tr class="uk-text-small active">
                        <th>Наименование услуги</th>
                        <th class="uk-text-center">Время ремонта
                        <th class="uk-text-center">Цена, руб</th>
                    </tr>
                    <tr class="active"><td>Диагностика</td>
                        <td>30м</td><td>0</td>
                    </tr>
                    <tr class="active"><td>Замена вентилятора</td>
                        <td>1д</td><td>600</td>
                    </tr>
                    <tr class="active"><td>Замена выпускных решеток</td>
                        <td>2д</td><td>1000</td>
                    </tr>
                    <tr class="active"><td>Замена клеммной колодки</td>
                        <td>1д</td><td>300</td>
                    </tr>
                    <tr class="active"><td>Замена кнопок</td>
                        <td>1д</td><td>600</td>
                    </tr>
                    <tr class="active"><td>Замена лампы</td>
                        <td>20м</td><td>500</td>
                    </tr>
                    <tr class="active"><td>Замена направляющих</td>
                        <td>1ч</td><td>700</td>
                    </tr>
                    <tr class="active"><td>Замена предохранителя</td>
                        <td>1ч</td><td>1300</td>
                    </tr>
                    <tr class="active"><td>Замена угольного фильтра</td>
                        <td>20м</td><td>500</td>
                    </tr>
                    <tr class="active"><td>Замена шнура питания</td>
                        <td>1ч</td><td>700</td>
                    </tr>
               </tbody>
            </table>
            ',
            '',
            '300'
            ),
    'remont-duhovyh-shkafov' => array(
    '
     <table class="priceTable uk-table uk-table-hover uk-table-striped services gadget">
        <tbody>
            <tr class="uk-text-small active">
                <th>Наименование услуги</th>
                <th class="uk-text-center">Время ремонта</th>
                <th class="uk-text-center">Цена, руб</th>
            </tr>
            <tr class="active"><td>Диагностика</td>
                <td>30ч</td><td>0</td>
            </tr>
            <tr class="active"><td>Демонтаж + монтаж встроенного прибора</td>
                <td>1ч</td><td>600</td>
            </tr>
            <tr class="active"><td>Замена блока электроподжига</td>
                <td>1ч</td><td>700</td>
            </tr>
            <tr class="active"><td>Замена клеммной колодки</td>
                <td>1ч</td><td>900</td>
            </tr>
            <tr class="active"><td>Замена выключателя гриля</td>
                <td>1ч</td><td>860</td>
            </tr>
            <tr class="active"><td>Замена газового шланга</td>
                <td>1ч</td><td>790</td>
            </tr>
            <tr class="active"><td>Замена двери в сборке</td>
                <td>1ч</td><td>530</td>
            </tr>
            <tr class="active"><td>Замена жирового фильтра вытяжки</td>
                <td>1ч</td><td>660</td>
            </tr>
             <tr class="active"><td>Ремонт вентилятора</td>
                <td>3д</td><td>890</td>
            </tr>
             <tr class="active"><td>Ремонт выключателей</td>
                <td>3д</td><td>1450</td>
            </tr>
             <tr class="active"><td>Ремонт сетевого шнура</td>
                <td>3д</td><td>700</td>
            </tr>
             <tr class="active"><td>Ремонт сетевых фильтров</td>
                <td>3д</td><td>1500</td>
            </tr>
             <tr class="active"><td>Чистка форсунки духовки или гриля</td>
                <td>3д</td><td>600</td>
            </tr>
       </tbody>
    </table>
    ',
    '',
    '600'
        ),
    'remont-kondicionerov' => array(
    '
     <table class="priceTable uk-table uk-table-hover uk-table-striped services gadget">
        <tbody>
            <tr class="uk-text-small active">
                <th>Наименование услуги</th>
                <th class="uk-text-center">Время ремонта</th>
                <th class="uk-text-center">Цена, руб</th>
            </tr>
            <tr class="active"><td>Диагностика</td>
                <td>3д</td><td>0</td>
            </tr>
            <tr class="active"><td>Дозаправка хладагентом</td>
                <td>3д</td><td>350</td>
            </tr>
            <tr class="active"><td>Замена 4-х ходового клапана</td>
                <td>3д</td><td>3000</td>
            </tr>
            <tr class="active"><td>Замена вальцовочного соединения </td>
                <td>3д</td><td>400</td>
            </tr>
            <tr class="active"><td>Замена дренажного насоса</td>
                <td>3д</td><td>1300</td>
            </tr>
            <tr class="active"><td>Замена дренажной трубки</td>
                <td>3д</td><td>300</td>
            </tr>
            <tr class="active"><td>Профилактика кондиционера</td>
                <td>3д</td><td>1500</td>
            </tr>
            <tr class="active"><td>Развальцовка трубы</td>
                <td>3д</td><td>450</td>
            </tr>
             <tr class="active"><td>Ремонт дренажной системы </td>
                <td>3д</td><td>250</td>
            </tr>
             <tr class="active"><td>Ремонт теплообменника</td>
                <td>3д</td><td>1500</td>
            </tr>
             <tr class="active"><td>Ремонт электронных плат</td>
                <td>3д</td><td>800</td>
            </tr>
             <tr class="active"><td>Чистка крыльчатки вентилятора</td>
                <td>3д</td><td>400</td>
            </tr>
             <tr class="active"><td>Чистка фильтров</td>
                <td>3д</td><td>200</td>
            </tr>
       </tbody>
    </table>
    ',
    '',
    '200'
        ),
    'remont-mikrovolnovyh-pechej' => array(
    '
     <table class="priceTable uk-table uk-table-hover uk-table-striped services gadget">
        <tbody>
            <tr class="uk-text-small active">
                <th>Наименование услуги</th>
                <th class="uk-text-center">Время ремонта</th>
                <th class="uk-text-center">Цена, руб</th>
            </tr>
            <tr class="active"><td>Диагностика</td>
                <td>1д</td><td>0</td>
            </tr>
            <tr class="active"><td>Восстановление блока питания микроволновки      </td>
                <td>1д</td><td>800</td>
            </tr>
            <tr class="active"><td>Восстановление корпусных элементов микроволновки    </td>
                <td>1д</td><td>800</td>
            </tr>
            <tr class="active"><td>Восстановление платы управления</td>
                <td>1д</td><td>550</td>
            </tr>
            <tr class="active"><td>Восстановление системы после ошибки микроволновки </td>
                <td>1д</td><td>800</td>    
            </tr>
            <tr class="active"><td>Восстановление цепи питания микроволновки         </td>
                <td>1д</td><td>700</td>
            </tr>
            <tr class="active"><td>Замена  блока питания микроволновки      </td>
                <td>1д</td><td>800</td>
            </tr>
            <tr class="active"><td>Замена  вентилятора</td>
                <td>1д</td><td>600</td>
            </tr>
            <tr class="active"><td>Замена  датчика духовки</td>
                <td>1д</td><td>500</td>
            </tr>
            <tr class="active"><td>Замена  двигателя поддона</td>
                <td>1д</td><td>600</td>
            </tr>
            <tr class="active"><td>Замена  конденсатора</td>
                <td>1д</td><td>600</td>
            </tr>
            <tr class="active"><td>Замена  корпусных элементов микроволновки    </td>
                <td>1д</td><td>800</td>
            </tr>
            <tr class="active"><td>Замена  подсветки микроволновки </td>
                <td>1д</td><td>350</td>
            </tr>
            <tr class="active"><td>Замена  рассеивающего экрана</td>
                <td>1д</td><td>100</td>
            </tr>
            <tr class="active"><td>Замена  трансформатора</td>
               <td>1д</td><td>700</td>
            </tr>
            <tr class="active"><td>Замена  ТЭНа</td>
               <td>1д</td><td>600</td>
            </tr>
            <tr class="active"><td>Замена  цепи питания микроволновки         </td>
               <td>1д</td><td>400</td>
            </tr>
            <tr class="active"><td>Замена волновода</td>
               <td>1д</td><td>1000</td>
            </tr>
            <tr class="active"><td>Замена высоковольтного предохранителя</td>
                <td>1д</td><td>250</td>
            </tr>
            <tr class="active"><td>Замена датчика закрытия двери</td>
                <td>1д</td><td>250</td>
            </tr>
            <tr class="active"><td>Замена дверцы</td>
                <td>1д</td><td>1000</td>
            </tr>
            <tr class="active"><td>Замена двигателя поворотного стола</td>
                <td>1д</td><td>800</td>
            </tr>
            <tr class="active"><td>Замена кнопок микроволновки   </td>
                <td>1д</td><td>400</td>
            </tr>
       </tbody>
    </table>
    ',
    '',
    '100'
        ),
    'remont-morozilnikov' => array(
    '
     <table class="priceTable uk-table uk-table-hover uk-table-striped services gadget">
        <tbody>
            <tr class="uk-text-small active">
                <th>Наименование услуги</th>
                <th class="uk-text-center">Время ремонта</th>
                <th class="uk-text-center">Цена, руб</th>
            </tr>
            <tr class="active"><td>Диагностика</td>
                <td>30м</td><td>0</td>
            </tr>
            <tr class="active"><td>Замена вентилятора</td>
                <td>12ч</td><td>1000</td>
            </tr>
            <tr class="active"><td>Замена дисплея</td>
                <td>2ч</td><td>1000</td>
            </tr>
            <tr class="active"><td>Замена капиллярной трубки</td>
                <td>3д</td><td>4000</td>
            </tr>
            <tr class="active"><td>Замена компрессора</td>
                <td>1д</td><td>1900</td>
            </tr>
            <tr class="active"><td>Замена панели управления</td>
                <td>2ч</td><td>1000</td>
            </tr>
            <tr class="active"><td>Замена реле</td>
                <td>1д</td><td>850</td>
            </tr>
            <tr class="active"><td>Замена таймера</td>
                <td>2д</td><td>1400</td>
            </tr>
            <tr class="active"><td>Замена термометра</td>
                <td>1д</td><td>1400</td>
            </tr>
            <tr class="active"><td>Замена терморегулятора</td>
                <td>1д</td><td>950</td>
            </tr>
            <tr class="active"><td>Замена шнура электропитания</td>
                <td>45м</td><td>800</td>
            </tr>
            <tr class="active"><td>Заправка фреоном</td>
                <td>3ч</td><td>1800</td>
            </tr>
            <tr class="active"><td>Регулировка дверцы</td>
                <td>2ч</td><td>500</td>
            </tr>
            <tr class="active"><td>Ремонт испарителя</td>
                <td>1д</td><td>2100</td>
            </tr>
            <tr class="active"><td>Ремонт ледогенератора</td>
                <td>2д</td><td>1900</td>
            </tr>
            <tr class="active"><td>Ремонт проводки</td>
                <td>2д</td><td>1000</td>
            </tr>
            <tr class="active"><td>Удаление влаги</td>
                <td>2д</td><td>1500</td>
            </tr>

       </tbody>
    </table>
    ',
    '',
    '800'
        ),
    'remont-stiralnyh-mashin' => array(
    '
     <table class="priceTable uk-table uk-table-hover uk-table-striped services gadget">
        <tbody>
            <tr class="uk-text-small active">
                <th>Наименование услуги</th>
                <th class="uk-text-center">Время ремонта</th>
                <th class="uk-text-center">Цена, руб</th>
            </tr>
            <tr class="active"><td>Диагностика</td>
                <td>30м</td><td>0</td>
            </tr>
            <tr class="active"><td>Изъятие постороннего предмета</td>
                <td>45м</td><td>1290</td>
            <tr class="active"><td>Замена амортизаторов</td>
                <td>1д</td><td>2180</td>
            <tr class="active"><td>Замена бака</td>
                <td>1д</td><td>3470</td>
            <tr class="active"><td>Замена верхнего противовеса</td>
                <td>1д</td><td>1780</td>
            <tr class="active"><td>Замена водоприёмника</td>
                <td>1д</td><td>2700</td>
            <tr class="active"><td>Замена термостата</td>
                <td>1д</td><td>1290</td>
            <tr class="active"><td>Замена проводки</td>
                <td>2ч</td><td>1490</td>
            <tr class="active"><td>Замена заливного клапана</td>
                <td>1д</td><td>1490</td>
            <tr class="active"><td>Замена заливного шланга</td>
                <td>1ч</td><td>890</td>
            <tr class="active"><td>Замена замка двери</td>
                <td>1ч</td><td>1940</td>
            <tr class="active"><td>Замена кнопки</td>
                <td>1ч</td><td>990</td>
            <tr class="active"><td>Замена крестовины</td>
                <td>1ч</td><td>2870</td>
            <tr class="active"><td>Замена люка</td>
                <td>1ч</td><td>1190</td>
            <tr class="active"><td>Замена манжеты люка</td>
                <td>1ч</td><td>1580</td>
            <tr class="active"><td>Замена моечного бака</td>
                <td>1ч</td><td>3780</td>
            <tr class="active"><td>Замена нижнего противовеса</td>
                <td>1д</td><td>3470</td>
            <tr class="active"><td>Замена опоры бака</td>
                <td>1д</td><td>3270</td>
            <tr class="active"><td>Замена панели управления</td>
                <td>1ч</td><td>1730</td>
            <tr class="active"><td>Замена подшипника</td>
                <td>1д</td><td>3270</td>
       </tbody>
    </table>
    ',
    '',
    '890'
        ),
    'remont-sushilnyh-mashin' => array(
    '
     <table class="priceTable uk-table uk-table-hover uk-table-striped services gadget">
        <tbody>
            <tr class="uk-text-small active">
                <th>Наименование услуги</th>
                <th class="uk-text-center">Время ремонта</th>
                <th class="uk-text-center">Цена, руб</th>
            </tr>
            <tr class="active"><td>Диагностика</td>
                <td>30м</td><td>0</td>
            </tr>
            <tr class="active"><td>Замена бака</td>
                <td>4д</td><td>3500</td>
            <tr class="active"><td>Замена устройства блокировки люка</td>
                <td>4д</td><td>1600</td>
            <tr class="active"><td>Замена вентилятора</td>
                <td>4д</td><td>1700</td>
            <tr class="active"><td>Замена ворсовых фильтров</td>
                <td>4д</td><td>1600</td>
            <tr class="active"><td>Замена датчика температуры</td>
                <td>4д</td><td>1400</td>
            <tr class="active"><td>Замена загрузочного люка</td>
                <td>4д</td><td>1200</td>
            <tr class="active"><td>Замена компрессора теплового насоса</td>
                <td>4д</td><td>3000</td>
            <tr class="active"><td>Замена нагревательного элемента</td>
                <td>4д</td><td>1900</td>
            <tr class="active"><td>Замена натяжного ролика</td>
                <td>4д</td><td>2200</td>
            <tr class="active"><td>Замена обрамления люка</td>
                <td>4д</td><td>1200</td>
            <tr class="active"><td>Замена опорного ролика</td>
                <td>4д</td><td>1500</td>
            <tr class="active"><td>Замена петли люка</td>
                <td>4д</td><td>1200</td>
            <tr class="active"><td>Замена платы управления</td>
                <td>4д</td><td>2500</td>
            <tr class="active"><td>Замена подшипника</td>
                <td>4д</td><td>3000</td>
            <tr class="active"><td>Замена помехоподавляющего фильтра</td>
                <td>4д</td><td>1200</td>
            <tr class="active"><td>Замена помпы</td>
                <td>4д</td><td>1700</td>
            <tr class="active"><td>Замена программатора </td>
                <td>4д</td><td>2200</td>
            <tr class="active"><td>Замена пускового конденсатора</td>
                <td>4д</td><td>1200</td>
            <tr class="active"><td>Ремонт устройства блокировки люка</td>
                <td>4д</td><td>250</td>
            <tr class="active"><td>Ремонт датчика температуры</td>
                <td>4д</td><td>350</td>
       </tbody>
    </table>
    ',
    '',
    '250'
        ),
    'remont-domashnih-kinoteatrov' => array(
    '
     <table class="priceTable uk-table uk-table-hover uk-table-striped services gadget">
        <tbody>
            <tr class="uk-text-small active">
                <th>Наименование услуги</th>
                <th class="uk-text-center">Время ремонта</th>
                <th class="uk-text-center">Цена, руб</th>
            </tr>
            <tr class="active"><td>Диагностика</td>
                <td>3д</td><td>0</td>
            </tr>
            <tr class="active"><td>BGA монтаж</td>
                <td>3д</td><td>2250</td>
            <tr class="active"><td>Восстановление печатной платы </td>
                <td>3д</td><td>250</td>
            <tr class="active"><td>Замена динамика акустики</td>
                <td>3д</td><td>350</td>
            <tr class="active"><td>Замена микросхем</td>
                <td>3д</td><td>125</td>
            <tr class="active"><td>Замена разъема акустики</td>
                <td>3д</td><td>150</td>
            <tr class="active"><td>Замена регуляторов</td>
                <td>3д</td><td>250</td>
            <tr class="active"><td>Перемотка трансформаторов</td>
                <td>3д</td><td>1250</td>
            <tr class="active"><td>Ремонт  Wi-Fi систем</td>
                <td>3д</td><td>850</td>
            <tr class="active"><td>Ремонт Bluetooth систем</td>
                <td>3д</td><td>850</td>
            <tr class="active"><td>Ремонт CD чейнджера</td>
                <td>3д</td><td>1500</td>
            <tr class="active"><td>Ремонт DVD привода</td>
                <td>3д</td><td>450</td>
            <tr class="active"><td>Ремонт активной акустической системы</td>
                <td>3д</td><td>650</td>
            <tr class="active"><td>Ремонт блока питания</td>
                <td>3д</td><td>500</td>
            <tr class="active"><td>Ремонт динамика акустики</td>
                <td>3д</td><td>450</td>
            <tr class="active"><td>Ремонт материнской платы</td>
                <td>3д</td><td>600</td>
            <tr class="active"><td>Ремонт модуля усилителя мощности</td>
                <td>3д</td><td>600</td>
            <tr class="active"><td>Ремонт разъема акустики</td>
                <td>3д</td><td>250</td>
            <tr class="active"><td>Ремонт регуляторов</td>
                <td>3д</td><td>250</td>
            <tr class="active"><td>Чистка селектора</td>
                <td>3д</td><td>500</td>
        
       </tbody>
    </table>
    ',
    '',
    '125'
    ),
    'remont-vodonagrevatelej' => array(
    '
     <table class="priceTable uk-table uk-table-hover uk-table-striped services gadget">
        <tbody>
            <tr class="uk-text-small active">
                <th>Наименование услуги</th>
                <th class="uk-text-center">Время ремонта</th>
                <th class="uk-text-center">Цена, руб</th>
            </tr>
            <tr class="active"><td>Диагностика</td>
                <td>30м</td><td>0</td>
            </tr>
            <tr class="active"><td>Замена датчика температуры</td>
                <td>1д</td><td>550</td>
            <tr class="active"><td>Замена датчика тяги</td>
                <td>1д</td><td>1000</td>
            <tr class="active"><td>Замена кабеля питания</td>
                <td>1д</td><td>350</td>
            <tr class="active"><td>Замена клапана обратного давления</td>
                <td>2ч</td><td>800</td>
            <tr class="active"><td>Замена кнопки пуска</td>
                <td>2ч</td><td>350</td>
            <tr class="active"><td>Замена лампы индикации</td>
                <td>1ч</td><td>350</td>
            <tr class="active"><td>Замена магниевого анода</td>
                <td>1ч</td><td>900</td>
            <tr class="active"><td>Замена нагревательного элемента</td>
                <td>1ч</td><td>350</td>
            <tr class="active"><td>Замена панели управления</td>
                <td>1ч</td><td>550</td>
            <tr class="active"><td>Замена прокладки</td>
                <td>1д</td><td>650</td>
            <tr class="active"><td>Замена силового модуля</td>
                <td>3ч</td><td>550</td>
            <tr class="active"><td>Замена фланца тэна</td>
                <td>3ч</td><td>900</td>
            <tr class="active"><td>Замена шланга</td>
                <td>1ч</td><td>500</td>
            <tr class="active"><td>Монтаж водонагревателя</td>
                <td>1ч</td><td>1000</td>
            <tr class="active"><td>Чистка бака</td>
                <td>2ч</td><td>750</td>
       </tbody>
    </table>
    ',
    '',
    '350'
    ),
    'remont-monoblokov' => array(
    '
    <table class="priceTable uk-table uk-table-hover uk-table-striped services gadget">
        <tbody>
            <tr class="uk-text-small">
                <th>Наименование услуги</th>
                <th class="uk-text-center">Время ремонта, мин</th>
                <th class="uk-text-center">Цена, руб</th>
            </tr> 
            <tr> 
                <td>Диагностика</td> <td>30м</td> <td>0</td> 
            </tr>  
            <tr> 
                <td>Замена DVI порта</td> <td>2д</td> <td>2200</td> 
            </tr> 
            <tr> 
                <td>Замена Ethernet порта</td> <td>2д</td> <td>2200</td> 
            </tr> 
            <tr> 
                <td>Замена HDD</td> <td>2д</td> <td>500</td> 
            </tr> 
            <tr> 
                <td>Замена SSD</td> <td>2д</td> <td>500</td> 
            </tr> 
            <tr> 
                <td>Замена HDMI порта</td> <td>2д</td> <td>2300</td> 
            </tr> 
            <tr> 
                <td>Замена S-Video порта</td> <td>2д</td> <td>2200</td> 
            </tr> 
            <tr> 
                <td>Замена USB порта</td> <td>2д</td> <td>2200</td> 
            </tr> 
            <tr> 
                <td>Замена VGA порта</td> <td>2д</td> <td>2200</td> 
            </tr> 
            <tr> 
                <td>Замена аудиоразъема</td> <td>2д</td> <td>2250</td> 
            </tr> 
            <tr> 
                <td>Замена блока питания</td> <td>2д</td> <td>600</td> 
            </tr> 
            <tr> 
                <td>Замена вентилятора жесткого диска</td> <td>2д</td> <td>1200</td> 
            </tr> 
            <tr> 
                <td>Замена видеоадаптера</td> <td>2д</td> <td>2200</td> 
            </tr> 
            <tr> 
                <td>Замена звуковой карты</td> <td>2д</td> <td>800</td> 
            </tr> 
            <tr> 
                <td>Замена камеры</td> <td>2д</td> <td>900</td> 
            </tr> 
            <tr> 
                <td>Замена кнопки включения</td> <td>2д</td> <td>1950</td> 
            </tr> 
            <tr> 
                <td>Замена контроллера заряда</td> <td>2д</td> <td>1200</td> 
            </tr> 
            <tr> 
                <td>Замена материнской платы</td> <td>2д</td> <td>1000</td> 
            </tr> 
            <tr> 
                <td>Замена матрицы</td> <td>2д</td> <td>1000</td> 
            </tr> 
            <tr> 
                <td>Замена микрофона</td> <td>2д</td> <td>1000</td> 
            </tr> 
            <tr> 
                <td>Замена модуля Wi-Fi</td> <td>2д</td> <td>800</td> 
            </tr>
        </tbody>
    </table>',
    // '<table class="priceTable uk-table uk-table-hover uk-table-striped">
    //     <tbody>
    //         <tr class="uk-text-small">
    //             <th>Наименование оборудования</th>
    //             <th class="uk-text-center">Статус</th>
    //             <th class="uk-text-center">Цена, руб</th>
    //         </tr> 
    //         <tr> 
    //             <td>Жесткий диск HDD 500 Gb</td> <td>есть в наличии</td> <td>2500</td>
    //         </tr> 
    //         <tr> 
    //             <td>Матрица экрана ноутбука</td> <td>в наличии / на заказ</td> <td>4500 – 8500</td> 
    //         </tr> 
    //         <tr> 
    //             <td>Матрица экрана ноутбука с тачскрином</td> <td>в наличии / на заказ</td> <td>7500 – 12500</td> 
    //         </tr> 
    //         <tr> 
    //             <td>Кулер системы охлаждения</td> <td>есть в наличии</td> <td>1400</td> 
    //         </tr> 
    //         <tr> 
    //             <td>Материнская плата</td> <td>на складе / на заказ</td> <td>6500 – 10500</td> 
    //         </tr> 
    //         <tr> 
    //             <td>Мультиконтроллер</td> <td>в наличии / на&nbsp;складе</td> <td>1200</td> 
    //         </tr> 
    //         <tr> 
    //             <td>Оперативная память DDR 3 4Gb</td> <td>есть в наличии</td> <td>1450</td> 
    //         </tr> 
    //         <tr> 
    //             <td>Разъем HDMI, аудио, USB</td> <td>в наличии / на заказ</td> <td>550</td> 
    //         </tr> 
    //         <tr> 
    //             <td>Разъем&nbsp;питания</td> <td>есть в наличии</td> <td>450</td> 
    //         </tr> 
    //         <tr> 
    //             <td>Чип BGA (видеочип, южный мост, северный мост)</td> <td>в наличии / на заказ</td> <td>1500 – 3500</td> 
    //         </tr> 
    //     </tbody>
    // </table>',
    '<p>Стоимость и наличие комплектующих уточняйте у менеджеров по телефону.</p>',
    '500',
    ),
	'remont-telefonov' => array(
    '<table class="priceTable uk-table uk-table-hover uk-table-striped services gadget">
        <tbody>
            <tr class="uk-text-small">
                <th>Наименование услуги</th>
                <th class="uk-text-center">Время ремонта</th>
                <th class="uk-text-center">Цена, руб</th>
            </tr> 
                <tr> <td>Диагностика</td> <td>30м</td> <td>0</td> </tr> 
                <tr> <td>Восстановление IMEI</td> <td>45м</td> <td>1500</td> </tr> 
                <tr> <td>Замена GPS</td> <td>2ч</td> <td>1100</td> </tr> 
                <tr> <td>Замена NFC</td> <td>2ч</td> <td>3500</td> </tr> 
                <tr> <td>Замена АКБ</td> <td>2ч</td> <td>1000</td> </tr> 
                <tr> <td>Замена виброматора</td> <td>2ч</td> <td>800</td> </tr> 
                <tr> <td>Замена входа ЗУ</td> <td>2ч</td> <td>1000</td> </tr> 
                <tr> <td>Замена гарнитурного разъема</td> <td>2ч</td> <td>800</td> </tr> 
                <tr> <td>Замена голосового динамика</td> <td>2ч</td> <td>1200</td> </tr> 
                <tr> <td>Замена датчика света</td> <td>2ч</td> <td>1200</td> </tr> 
                <tr> <td>Замена динамика полифонии</td> <td>2ч</td> <td>1200</td> </tr> 
                <tr> <td>Замена дисплейного модуля</td> <td>2ч</td> <td>3000</td> </tr> 
                <tr> <td>Замена кнопки включения</td> <td>2ч</td> <td>1200</td> </tr> 
                <tr> <td>Замена контроллера питания</td> <td>2ч</td> <td>3000</td> </tr> 
                <tr> <td>Замена корпуса</td> <td>2ч</td> <td>1200</td> </tr> 
                <tr> <td>Замена микрофона</td> <td>2ч</td> <td>800</td> </tr> 
                <tr> <td>Замена модуля Wi-Fi</td> <td>2ч</td> <td>1500</td> </tr> 
                <tr> <td>Замена основной камеры</td> <td>2ч</td> <td>3000</td> </tr> 
                <tr> <td>Замена приемопередатчика</td> <td>2ч</td> <td>3000</td> </tr> 
                <tr> <td>Замена разъема симкарты</td> <td>2ч</td> <td>1000</td> </tr> 
                <tr> <td>Замена разъема флеш</td> <td>2ч</td> <td>1000</td> 
            </tr> 
        </tbody> 
    </table>',
        // '<table class="priceTable uk-table uk-table-hover uk-table-striped">
        //     <tbody><tr class="uk-text-small"><th>Наименование оборудования</th><th class="uk-text-center">Статус</th><th class="uk-text-center">Цена, руб</th></tr><tr> <td>Аудио разъем</td> <td>есть в наличии</td> <td>450</td> </tr> <tr> <td>Динамик слуховой / полифонический</td> <td>есть в наличии</td> <td>1400-1900</td> </tr> <tr> <td>Дисплейный модуль</td> <td>в наличии / на заказ</td> <td>4500</td> </tr> <tr> <td>Задняя крышка аппарата</td> <td>в наличии / на заказ</td> <td>800</td> </tr> <tr> <td>Микросхема BGA (звук,процессор,контроллер)</td> <td>в наличии / на&nbsp;складе</td> <td>600-2200</td> </tr> <tr> <td>Микрофон</td> <td>есть в наличии</td> <td>1400-1900</td> </tr> <tr> <td>Мультиконтроллер</td> <td>в наличии / на&nbsp;складе</td> <td>1200</td> </tr> <tr> <td>Разъем Micro USB</td> <td>есть в наличии</td> <td>250</td> </tr> 
        //     </tbody> 
        // </table>',
        '<p>Стоимость и наличие комплектующих уточняйте у менеджеров по телефону.</p>',
        '800',
    ),
	'remont-holodilnikov' => array(
        '<table class="priceTable uk-table uk-table-hover uk-table-striped services gadget">
            <tbody>
                <tr class="uk-text-small">
                    <th>Наименование услуги</th>
                    <th class="uk-text-center">Время ремонта<th class="uk-text-center">Цена, руб</th>
                </tr> 
                    <tr><td>Диагностика</td><td>30м</td><td>0</td></tr> 
                    <tr><td>Замена вентилятора</td><td>1д</td><td>1520</td></tr> 
                    <tr><td>Замена вентилятора обдува</td><td>1д</td><td>2100</td></tr> 
                    <tr><td>Замена герконового выключателя</td><td>1д</td><td>1190</td></tr>
                    <tr><td>Замена датчика оттайки</td><td>1д</td><td>1190</td></tr> 
                    <tr><td>Замена датчика температуры</td><td>1д</td><td>1190</td></tr> 
                    <tr><td>Замена дисплея</td><td>1д</td><td>1190</td></tr> 
                    <tr><td>Замена испарителя</td><td>1д</td><td>1520</td></tr> 
                    <tr><td>Замена компрессора</td><td>1д</td><td>1200</td></tr> 
                    <tr><td>Замена конденсатора</td><td>1д</td><td>2030</td></tr> 
                    <tr><td>Замена модуля управления</td><td>1д</td><td>1610</td></tr> 
                    <tr><td>Замена мотора-компрессора</td><td>1д</td><td>1610</td></tr> 
                    <tr><td>Замена нагревателя испарителя</td><td>1д</td><td>2030</td></tr> 
                    <tr><td>Замена нагревателя оттайки</td><td>1д</td><td>1100</td></tr> 
                    <tr><td>Замена панели управления</td><td>2ч</td><td>1100</td></tr> 
                    <tr><td>Замена петли</td><td>1ч</td><td>1020</td></tr> 
                    <tr><td>Замена плавкого предохранителя</td><td>1д</td><td>1190</td></tr> 
                    <tr><td>Замена пускозащитного реле</td><td>1д</td><td>900</td>
                </tr> 
            </tbody> 
        </table>',
    '<p>Стоимость и наличие комплектующих уточняйте у менеджеров по телефону.</p>',
    '1100',
    ),

'remont-posudomoechnyh-mashin' =>array(
    '<table class="priceTable uk-table uk-table-hover uk-table-striped services gadget">
        <tbody>
            <tr class="uk-text-small">
                <th>Наименование услуги</th>
                <th class="uk-text-center">Время ремонта<th class="uk-text-center">Цена, руб</th>
            </tr>
                <tr> <td>Диагностика</td> <td>30м</td> <td>0</td> </tr>  
                <tr> <td>Замена вентилятора</td> <td>1д</td> <td>1520</td> </tr> 
                <tr> <td>Замена вентилятора обдува</td> <td>1д</td> <td>2100</td> </tr> 
                <tr> <td>Замена герконового выключателя</td> <td>1д</td> <td>1190</td> </tr> 
                <tr> <td>Замена датчика оттайки</td> <td>1д</td> <td>1190</td> </tr> 
                <tr> <td>Замена датчика температуры</td> <td>1д</td> <td>1190</td> </tr> 
                <tr> <td>Замена дисплея</td> <td>1д</td> <td>1190</td> </tr> 
                <tr> <td>Замена испарителя</td> <td>1д</td> <td>1520</td> </tr> 
                <tr> <td>Замена компрессора</td> <td>1д</td> <td>1200</td> </tr> 
                <tr> <td>Замена конденсатора</td> <td>1д</td> <td>2030</td> </tr> 
                <tr> <td>Замена модуля управления</td> <td>1д</td> <td>1610</td> </tr> 
                <tr> <td>Замена мотора-компрессора</td> <td>1д</td> <td>1610</td> </tr> 
                <tr> <td>Замена нагревателя испарителя</td> <td>1д</td> <td>2030</td> </tr> 
        </tbody> 
    </table>',
'<p>Стоимость и наличие комплектующих уточняйте у менеджеров по телефону.</p>',
'1200',
),


	'remont-televizorov' => array(
        '<table class="priceTable uk-table uk-table-hover uk-table-striped services gadget">
            <tbody>
                <tr class="uk-text-small">
                    <th>Наименование услуги</th>
                    <th class="uk-text-center">Время ремонта<th class="uk-text-center">Цена, руб</th>
                </tr>  
                    <tr> <td>Диагностика</td> <td>30м</td> <td>0</td> </tr> 
                    <tr> <td>Восстановление после залития жидкостью</td> <td>3ч</td> <td>3050</td> </tr> 
                    <tr> <td>Замена DVI разъема</td> <td>3ч</td> <td>1950</td> </tr> 
                    <tr> <td>Замена HDMI разъема</td> <td>3ч</td> <td>1950</td> </tr> 
                    <tr> <td>Замена SCART разъема</td> <td>3ч</td> <td>1800</td> </tr> 
                    <tr> <td>Замена S-video разъема</td> <td>3ч</td> <td>1950</td> </tr> 
                    <tr> <td>Замена USB разъема</td> <td>3ч</td> <td>1950</td> </tr> 
                    <tr> <td>Замена VGA разъема</td> <td>3ч</td> <td>2100</td> </tr> 
                    <tr> <td>Замена аудио разъёма</td> <td>3ч</td> <td>1200</td> </tr> 
                    <tr> <td>Замена блока питания</td> <td>3ч</td> <td>1800</td> </tr> 
                    <tr> <td>Замена блока подсветки</td> <td>3ч</td> <td>1800</td> </tr> 
                    <tr> <td>Замена ИК приемника</td> <td>3ч</td> <td>1800</td> </tr> 
                    <tr> <td>Замена кнопки включения</td> <td>3ч</td> <td>1950</td> </tr> 
                    <tr> <td>Замена кнопок управления</td> <td>3ч</td> <td>2100</td> </tr> 
                    <tr> <td>Замена конденсатора</td> <td>3ч</td> <td>2000</td> </tr> 
                    <tr> <td>Замена контроллера</td> <td>3ч</td> <td>1600</td> </tr> 
                    <tr> <td>Замена корпуса</td> <td>3ч</td> <td>1850</td> </tr> 
                    <tr> <td>Замена лампы подсветки</td> <td>3ч</td> <td>1400</td> </tr> 
                    <tr> <td>Замена материнской платы</td> <td>3ч</td> <td>1850</td> </tr> 
            </tbody> 
        </table>',
    '<p>Стоимость и наличие комплектующих уточняйте у менеджеров по телефону.</p>',
    '1400',
    ),
	'remont-pylesosov' => array(
        '<table class="priceTable uk-table uk-table-hover uk-table-striped services gadget">
            <tbody>
                <tr class="uk-text-small">
                    <th>Наименование услуги</th>
                    <th class="uk-text-center">Время ремонта<th class="uk-text-center">Цена, руб</th>
                </tr>
                    <tr><td>Диагностика</td><td>30м</td><td>0</td></tr> 
                    <tr><td>Замена двигателя</td><td>2ч</td><td>1500</td></tr> 
                    <tr><td>Замена кнопок</td><td>2ч</td><td>300</td></tr> 
                    <tr><td>Замена платы управления</td><td>2ч</td><td>500</td></tr> 
                    <tr><td>Замена сетевого выключателя</td><td>2ч</td><td>900</td></tr> 
                    <tr><td>Замена сетевого шнура</td><td>2ч</td><td>900</td></tr> 
                    <tr><td>Замена фильтра</td><td>2ч</td><td>300</td></tr> 
            </tbody> 
        </table>',
    '<p>Стоимость и наличие комплектующих уточняйте у менеджеров по телефону.</p>',
    '300',
    ), 
	/*<tr><td>Техническое обслуживание</td><td></td><td>1200</td></tr>
	<tr><td>Ремонт платы робота-пылесоса</td><td></td><td>1700</td></tr>
	<tr><td>Ремонт блока питания</td><td></td><td>900</td></tr>
	<tr><td>Замена датчиков движения</td><td></td><td>2100</td></tr>
	<tr><td>Замена модуля колеса</td><td></td><td>1200</td></tr>
	<tr><td>Ремонт/замена модуля щеток</td><td></td><td>1500</td></tr>
	*/
	'remont-printerov' => array(
        '<table class="priceTable uk-table uk-table-hover uk-table-striped services gadget">
            <tbody>
                <tr class="uk-text-small">
                    <th>Наименование услуги</th>
                    <th class="uk-text-center">Время ремонта<th class="uk-text-center">Цена, руб</th>
                </tr>
                    <tr><td>Диагностика</td><td>30м</td><td>0</td></tr> 
                    <tr><td>Замена абсорбера</td><td>2ч</td><td>1200</td></tr> 
                    <tr><td>Замена блока лазера</td><td>2ч</td><td>1200</td></tr> 
                    <tr><td>Замена блока питания</td><td>2ч</td><td>1300</td></tr> 
                    <tr><td>Замена валика</td><td>2ч</td><td>900</td></tr> 
                    <tr><td>Замена втулок вала</td><td>2ч</td><td>100</td></tr> 
                    <tr><td>Замена датчика бумаги</td><td>2ч</td><td>800</td></tr> 
                    <tr><td>Замена дуплекса</td><td>2ч</td><td>900</td></tr> 
                    <tr><td>Замена капы</td><td>2ч</td><td>900</td></tr> 
                    <tr><td>Замена каретки</td><td>2ч</td><td>800</td></tr> 
                    <tr><td>Замена лотка листов</td><td>2ч</td><td>800</td></tr> 
                    <tr><td>Замена материнской платы</td><td>2ч</td><td>2600</td></tr> 
                    <tr><td>Замена модуля Wi-Fi</td><td>2ч</td><td>1000</td></tr> 
                    <tr><td>Замена мотора привода</td><td>2ч</td><td>2200</td></tr> 
                    <tr><td>Замена печатной головки</td><td>2ч</td><td>1100</td></tr> 
                    <tr><td>Замена печки</td><td>2ч</td><td>3000</td></tr> 
                    <tr><td>Замена платы управления двигателем</td><td>2ч</td><td>1800</td></tr> 
            </tbody> 
        </table>',
    '<p>Стоимость и наличие комплектующих уточняйте у менеджеров по телефону.</p>',
    '100',
    ),
	'remont-fotoapparatov' => array(
        '<table class="priceTable uk-table uk-table-hover uk-table-striped services gadget">
            <tbody>
                <tr class="uk-text-small"> 
                    <th>Наименование услуги</th>
                    <th class="uk-text-center">Время ремонта<th class="uk-text-center">Цена, руб</th>
                </tr>
                    <tr><td>Диагностика</td><td>30м</td><td>0</td></tr>  
                    <tr><td>Замена CCD матрицы</td><td>2ч</td><td>1040</td></tr> 
                    <tr><td>Замена аккумулятора</td><td>2ч</td><td>400</td></tr> 
                    <tr><td>Замена байонета объектива</td><td>1ч</td><td>1560</td></tr> 
                    <tr><td>Замена внутреннего зеркала</td><td>2ч</td><td>2400</td></tr> 
                    <tr><td>Замена вспышки</td><td>3ч</td><td>960</td></tr> 
                    <tr><td>Замена диафрагмы</td><td>2ч</td><td>1120</td></tr> 
                    <tr><td>Замена диска управления</td><td>1ч</td><td>960</td></tr> 
                    <tr><td>Замена дисплея</td><td>2ч</td><td>960</td></tr> 
                    <tr><td>Замена задней панели</td><td>1ч</td><td>960</td></tr> 
                    <tr><td>Замена затвора</td><td>2ч</td><td>1100</td></tr> 
                    <tr><td>Замена кнопки включения</td><td>1ч</td><td>1040</td></tr> 
                    <tr><td>Замена контроллера питания</td><td>2ч</td><td>960</td></tr> 
                    <tr><td>Замена корпуса</td><td>1ч</td><td>960</td></tr> 
                    <tr><td>Замена линз</td><td>2ч</td><td>900</td></tr> 
                    <tr><td>Замена материнской платы</td><td>2ч</td><td>960</td></tr> 
                    <tr><td>Замена микрофона</td><td>2ч</td><td>960</td></tr> 
                    <tr><td>Замена передней панели</td><td>1ч</td><td>960</td></tr> 
                    <tr><td>Замена разъёма </td><td>2ч</td><td>1000</td></tr> 
                    <tr><td>Замена слота карты памяти</td><td>3ч</td><td>1040</td></tr> 
                    <tr><td>Замена стекла объектива</td><td>2ч</td><td>1040</td></tr> 
                    <tr><td>Замена узла взвода</td><td>2ч</td><td>1040</td></tr> 
                    <tr><td>Замена устройства стабилизации</td><td>2ч</td><td>1200</td></tr> 
            </tbody>
        </table>',
    '<p>Стоимость и наличие комплектующих уточняйте у менеджеров по телефону.</p>',
    '400',
    ),
	'remont-monitorov' => array(
        '<table class="priceTable uk-table uk-table-hover uk-table-striped services gadget">
            <tbody>
                <tr class="uk-text-small">
                    <th>Наименование услуги</th>
                    <th class="uk-text-center">Время ремонта<th class="uk-text-center">Цена, руб</th>
                </tr>
                    <tr> <td>Диагностика</td> <td>30м</td> <td>0</td> </tr>
                    <tr> <td>Замена блока питания</td> <td>1д</td> <td>1850</td> </tr> 
                    <tr> <td>Замена инвертора</td> <td>1д</td> <td>1650</td> </tr> 
                    <tr> <td>Замена лампы подсветки</td> <td>1д</td> <td>1400</td> </tr> 
                    <tr> <td>Замена матрицы</td> <td>1д</td> <td>1700</td> </tr> 
                    <tr> <td>Замена платы управления</td> <td>1д</td> <td>1300</td> </tr> 
                    <tr> <td>Замена процессора</td> <td>1д</td> <td>1600</td> </tr> 
                    <tr> <td>Замена разъема ЗУ</td> <td>1д</td> <td>1600</td> </tr> 
                    <tr> <td>Замена разъёмов</td> <td>1д</td> <td>1850</td> </tr>  
                    <tr> <td>Замена электронных компонентов </td> <td>1д</td> <td>2050</td> </tr> 
                    <tr> <td>Прошивка блока управления</td> <td>1д</td> <td>1100</td> </tr> 
                    <tr> <td>Ремонт блока питания</td> <td>1д</td> <td>2500</td> </tr> 
                    <tr> <td>Ремонт блока управления</td> <td>1д</td> <td>1100</td> </tr> 
                    <tr> <td>Ремонт подсветки</td> <td>1д</td> <td>1800</td> </tr> 
                    <tr> <td>Ремонт цепи питания</td> <td>1д</td> <td>3500</td> </tr> 
            </tbody> 
        </table>',
    '<p>Стоимость и наличие комплектующих уточняйте у менеджеров по телефону.</p>',
    '1100'
    ),
	'remont-ultrabukov' => array(
        '<table class="priceTable uk-table uk-table-hover uk-table-striped services gadget"><tbody><tr class="uk-text-small"><th>Наименование услуги</th><th class="uk-text-center">Время ремонта<th class="uk-text-center">Цена, руб</th></tr> <tr> <td>Замена матрицы</td> <td>30</td> <td>300</td> </tr> <tr> <td>Замена матрицы с тачскрином</td> <td>1ч</td> <td>800</td> </tr> <tr> <td>Замена разъема зарядного устройства</td> <td>30</td> <td>1200</td> </tr> <tr> <td>Замена разъема HDMI, аудио, USB</td> <td>30-45</td> <td>1500</td> </tr> <tr> <td>Чистка от пыли (замена термопасты,смазка кулера)</td> <td>30-60</td> <td>1400</td> </tr> <tr> <td>Чистка материнской платы от жидкости</td> <td>60-120</td> <td>1300</td> </tr> <tr> <td>Замена разъема на материнской плате</td> <td>30-40</td> <td>800</td> </tr> <!--<tr> <td>Замена процессора с заменой термопасты</td> <td>60</td> <td>800</td> </tr>--> <tr> <td>Замена чипа BGA (видеочип,южный мост,северный мост)</td> <td>120-180</td> <td>2600</td> </tr> <tr> <td>Замена материнской платы</td> <td>60-180</td> <td>1200</td> </tr> <tr> <td>Замена Wi Fi</td> <td>30</td> <td>300</td> </tr> <tr> <td>Замена жесткого диска</td> <td>30</td> <td>бесплатно</td> </tr> <tr> <td>Замена оперативной памяти</td> <td>15&nbsp;</td> <td>бесплатно</td> </tr> <tr> <td>Замена петель</td> <td>60-120</td> <td>1250</td> </tr> <!-- <tr> <td>Замена батареи Bios</td> <td>30</td> <td>450</td> </tr> --> <tr> <td>Прошивка Bios</td> <td>60-120</td> <td>1200</td> </tr> <tr> <td>Восстановление контактов BGA, разъемов, портов (за 1 шт.)</td> <td>30-60</td> <td>400</td> </tr> <tr> <td>Ремонт цепи питания</td> <td>180</td> <td>2700</td> </tr> <tr> <td>Ремонт корпуса</td> <td>120</td> <td>2200</td> </tr> <tr> <td>Настройка ПО</td> <td>30</td> <td>800</td> </tr> </tbody> </table>',
        // '<table class="priceTable uk-table uk-table-hover uk-table-striped"><tbody><tr class="uk-text-small"><th>Наименование оборудования</th><th class="uk-text-center">Статус</th><th class="uk-text-center">Цена, руб</th></tr> <tr> <td>Жесткий диск HDD 500 Gb</td> <td>есть в наличии</td> <td>2500</td> </tr> <tr> <td>Матрица экрана ультрабука</td> <td>в наличии / на заказ</td> <td>2500 – 4500</td> </tr> <tr class="accordion-header1" href="#accordion-1"> <!-- --> <td>Матрица экрана ультрабука с тачскрином</td> <td>в наличии / на заказ</td> <td>6500 – 12500</td> </tr>    <tr> <td>Кулер системы охлаждения</td> <td>есть в наличии</td> <td>1200</td> </tr> <tr class="accordion-header1" href="#accordion-2"> <td>Материнская плата</td> <td>на складе / на заказ</td> <td>4500 – 8500</td> </tr><tr class="accordion-collapse" id="accordion-2"><td>Матрица экрана ультрабука с тачскрином</td> <td>в наличии / на заказ</td><td>12500</td></tr> <tr> <td>Мультиконтроллер</td> <td>в наличии / на&nbsp;складе</td> <td>800</td> </tr> <tr> <td>Оперативная память DDR 3 4Gb</td> <td>есть в наличии</td> <td>1400</td> </tr> <tr> <td>Разъем HDMI, аудио, USB</td> <td>в наличии / на заказ</td> <td>400</td> </tr> <tr> <td>Разъем&nbsp;питания</td> <td>есть в наличии</td> <td>350</td> </tr> <tr class="accordion-header1" href="#accordion-3"> <td>Чип BGA (видеочип, южный мост, северный мост)</td> <td>в наличии / на заказ</td> <td>1200 – 2500</td> </tr>   </tbody> </table>',
        '<p>Стоимость и наличие комплектующих уточняйте у менеджеров по телефону.</p>',
        '300',
    ),
	'remont-pristavok' => array(
        '<table class="priceTable uk-table uk-table-hover uk-table-striped services gadget">
            <tbody>
                <tr class="uk-text-small">
                    <th>Наименование услуги</th>
                    <th class="uk-text-center">Время ремонта<th class="uk-text-center">Цена, руб</th>
                </tr>
                    <tr> <td>Диагностика</td> <td>30м</td> <td>0</td> </tr>
                    <tr> <td>Замена Blu-ray</td> <td>1д</td> <td>1950</td> </tr> 
                    <tr> <td>Замена Ethernet разъема</td> <td>1д</td> <td>1650</td> </tr> 
                    <tr> <td>Замена HDD</td> <td>1д</td> <td>500</td> </tr> 
                    <tr> <td>Замена HDMI разъема</td> <td>1д</td> <td>1750</td> </tr> 
                    <tr> <td>Замена аудио выхода</td> <td>1д</td> <td>1650</td> </tr> 
                    <tr> <td>Замена блока питания</td> <td>1д</td> <td>2050</td> </tr> 
                    <tr> <td>Замена кулера</td> <td>1д</td> <td>1950</td> </tr> 
                    <tr> <td>Замена материнской платы</td> <td>1д</td> <td>1950</td> </tr> 
                    <tr> <td>Замена модуля Bluetooth</td> <td>1д</td> <td>2550</td> </tr> 
            </tbody> 
        </table>',
    '<p>Стоимость и наличие комплектующих уточняйте у менеджеров по телефону.</p>',
    '500',
    ),
    'remont-planshetov' => array(
        '<table class="priceTable uk-table uk-table-hover uk-table-striped services gadget">
            <tbody>
                <tr class="uk-text-small">
                    <th>Наименование услуги</th>
                    <th class="uk-text-center">Время ремонта<th class="uk-text-center">Цена, руб</th>
                </tr> 
                    <tr><td>Диагностика</td><td>30м</td><td>0</td></tr>
                    <tr><td>Восстановление IMEI</td><td>1ч</td><td>1500</td></tr>
                    <tr><td>Замена GPS</td><td>1ч</td><td>700</td></tr>
                    <tr><td>Замена GSM антенны</td><td>1ч</td><td>1190</td></tr>
                    <tr><td>Замена HDMI</td><td>1ч</td><td>600</td></tr>
                    <tr><td>Замена NAND FLASH</td><td>1ч</td><td>850</td></tr>
                    <tr><td>Замена USB</td><td>1ч</td><td>600</td></tr>
                    <tr><td>Замена Wi-Fi</td><td>1ч</td><td>500</td></tr>
                    <tr><td>Замена АКБ</td><td>1ч</td><td>500</td></tr>
                    <tr><td>Замена акселерометра</td><td>1ч</td><td>1000</td></tr>
                    <tr><td>Замена болтов</td><td>1ч</td><td>500</td></tr>
                    <tr><td>Замена верхнего шлейфа</td><td>1ч</td><td>1300</td></tr>
                    <tr><td>Замена вибромотора</td><td>1ч</td><td>500</td></tr>
                    <tr><td>Замена вспышки</td><td>1ч</td><td>1000</td></tr>
                    <tr><td>Замена встроенного микрофона</td><td>1ч</td><td>500</td></tr>
                    <tr><td>Замена гарнитурного разъема</td><td>1ч</td><td>800</td></tr>
                    <tr><td>Замена глазка камеры</td><td>1ч</td><td>300</td></tr>
                    <tr><td>Замена голосового динамика</td><td>1ч</td><td>1200</td></tr>
                    <tr><td>Замена датчика попадания влаги</td><td>1ч</td><td>1100</td></tr>
                    <tr><td>Замена датчика света</td><td>1ч</td><td>1200</td></tr>
                    <tr><td>Замена держателя сим</td><td>1ч</td><td>800</td></tr>
            </tbody>
        </table>',
        // '<table class="priceTable uk-table uk-table-hover uk-table-striped"><tbody><tr class="uk-text-small"><th>Наименование оборудования</th><th class="uk-text-center">Статус</th><th class="uk-text-center">Цена, руб</th></tr><tr><td>Аудио разъем</td><td>есть в наличии</td><td>300</td></tr><tr><td>Динамик</td><td>есть в наличии</td><td>250</td></tr><tr><td>Дисплейный модуль</td><td>в наличии / на заказ</td><td>3500 – 6500</td></tr><tr><td>Задняя крышка аппарата</td><td>в наличии / на заказ</td><td>1200</td></tr><tr><td>Кнопка включения</td><td>есть в наличии</td><td>250</td></tr><tr><td>Материнская плата</td><td>в наличии / на заказ</td><td>3500-8500</td></tr><tr><td>Микросхема BGA (звук,процессор,контроллер)</td><td>в наличии / на&nbsp;складе</td><td>600-2500</td></tr><tr><td>Микрофон</td><td>есть в наличии</td><td>350</td></tr><tr><td>Мультиконтроллер</td><td>в наличии / на&nbsp;складе</td><td>1200</td></tr><tr><td>Разъем Micro USB</td><td>есть в наличии</td><td>350</td></tr></tbody></table>',
        '<p>Стоимость и наличие комплектующих уточняйте у менеджеров по телефону.</p>',
        '300',
    ),
    'remont-noutbukov' => array(
        '<table class="priceTable uk-table uk-table-hover uk-table-striped services gadget">
            <tbody>
                <tr class="uk-text-small">
                    <th>Наименование услуги</th>
                    <th class="uk-text-center">Время ремонта<th class="uk-text-center">Цена, руб</th>
                </tr> 
                    <tr><td>Диагностика</td><td>30м</td><td>0</td></tr>
                    <tr><td>Замена DVI порта</td><td>2ч</td><td>500</td></tr>
                    <tr><td>Замена eSATA порта</td><td>2ч</td><td>400</td></tr>
                    <tr><td>Замена Ethernet порта</td><td>2ч</td><td>1770</td></tr>
                    <tr><td>Замена ExpressCard порта</td><td>2ч</td><td>2200</td></tr>
                    <tr><td>Замена SSD</td><td>2ч</td><td>400</td></tr>
                    <tr><td>Замена HDD</td><td>2ч</td><td>400</td></tr>
                    <tr><td>Замена HDMI</td><td>2ч</td><td>500</td></tr>
                    <tr><td>Замена IEEE порта</td><td>2ч</td><td>1400</td></tr>
                    <tr><td>Замена S-Video порта</td><td>2ч</td><td>1950</td></tr>
                    <tr><td>Замена USB порта</td><td>2ч</td><td>800</td></tr>
                    <tr><td>Замена VGA порта</td><td>2ч</td><td>1570</td></tr>
                    <tr><td>Замена Wi-Fi модуля</td><td>2ч</td><td>500</td></tr>
                    <tr><td>Замена АКБ</td><td>2ч</td><td>100</td></tr>
                    <tr><td>Замена аудиоразъема</td><td>2ч</td><td>2250</td></tr>
                    <tr><td>Замена вентилятора</td><td>2ч</td><td>900</td></tr>
                    <tr><td>Замена видеоадаптера</td><td>2ч</td><td>2200</td></tr>
                    <tr><td>Замена встроенного микрофона</td><td>2ч</td><td>900</td></tr>
                    <tr><td>Замена встроенной камеры</td><td>2ч</td><td>900</td></tr>
                    <tr><td>Замена зарядного устройства</td><td>2ч</td><td>100</td></tr>
                    <tr><td>Замена звуковой карты</td><td>2ч</td><td>800</td></tr>
            </tbody>
        </table>',
        // '<table class="priceTable uk-table uk-table-hover uk-table-striped"><tbody><tr class="uk-text-small"><th>Наименование оборудования</th><th class="uk-text-center">Статус</th><th class="uk-text-center">Цена, руб</th></tr><tr><td>Жесткий диск HDD 500 Gb</td><td>есть в наличии</td><td>2500</td></tr><tr><td>Матрица экрана ноутбука</td><td>в наличии / на заказ</td><td>2500 – 4500</td></tr><tr><td>Матрица экрана ноутбука с тачскрином</td><td>в наличии / на заказ</td><td>6500 – 12500</td></tr><tr><td>Кулер системы охлаждения</td><td>есть в наличии</td><td>1200</td></tr><tr><td>Материнская плата</td><td>на складе / на заказ</td><td>4500 – 8500</td></tr><tr><td>Мультиконтроллер</td><td>в наличии / на&nbsp;складе</td><td>800</td></tr><tr><td>Оперативная память DDR 3 4Gb</td><td>есть в наличии</td><td>1400</td></tr><tr><td>Разъем HDMI, аудио, USB</td><td>в наличии / на заказ</td><td>400</td></tr><tr><td>Разъем&nbsp;питания</td><td>есть в наличии</td><td>350</td></tr><tr><td>Чип BGA (видеочип, южный мост, северный мост)</td><td>в наличии / на заказ</td><td>1200 – 2500</td></tr></tbody></table>',
        '<p>Стоимость и наличие комплектующих уточняйте у менеджеров по телефону.</p>',
        '100',
    ),
    'remont-kompyuterov' => array(
        '<table class="priceTable uk-table uk-table-hover uk-table-striped services gadget">
            <tbody>
                <tr class="uk-text-small">
                    <th>Наименование услуги</th>
                    <th class="uk-text-center">Время ремонта<th class="uk-text-center">Цена, руб</th>
                </tr>
                    <tr><td>Восстановление информации с жёсткого диска</td><td>1д</td><td>640</td></tr>
                    <tr><td>Замена HDD</td><td>1ч</td><td>500</td></tr>
                    <tr><td>Замена блока питания</td><td>1ч</td><td>400</td></tr>
                    <tr><td>Замена видеочипа</td><td>1ч</td><td>2200</td></tr>
                    <tr><td>Замена звуковой платы</td><td>1ч</td><td>800</td></tr>
                    <tr><td>Замена кулера</td><td>45м</td><td>1200</td></tr>
                    <tr><td>Замена материнской платы</td><td>2ч</td><td>600</td></tr>
                    <tr><td>Замена оперативной памяти</td><td>45м</td><td>160</td></tr>
                    <tr><td>Замена процессора</td><td>1д</td><td>310</td></tr>
                    <tr><td>Замена северного моста</td><td>30м</td><td>2100</td></tr>
            </tbody>
        </table>',
        //'<table class="priceTable uk-table uk-table-hover uk-table-striped"><tbody><tr class="uk-text-small"><th>Наименование оборудования</th><th class="uk-text-center">Статус</th><th class="uk-text-center">Цена, руб</th></tr><tr><td>Материнская плата</td><td>более 100 шт.</td><td>2500 – 6800</td></tr><tr><td>Процессор</td><td>более 50 шт.</td><td>2300 – 9200</td></tr><tr><td>Оперативная память</td><td>более 75 шт.</td><td>1100 – 4300</td></tr><tr><td>Видеокарта</td><td>более 30 шт.</td><td>2400 – 13500</td></tr><tr><td>Блок питания</td><td>более 50 шт.</td><td>1800 – 6400</td></tr> <tr><td>HDD и SSD</td><td>более 60 шт.</td><td>2200 – 7100</td></tr><tr><td>CD/DVD-ROM</td><td>более 80 шт.</td><td>1400 – 3800</td></tr> <tr><td>Корпус ПК</td><td>более 20 шт.</td><td>2200 – 6500</td></tr></tbody></table>',
        '<p>Стоимость и наличие комплектующих уточняйте у менеджеров по телефону.</p>',
        '150',
    ),
    'remont-smartfonov' => array(
        '<table class="priceTable uk-table uk-table-hover uk-table-striped services gadget">
            <tbody>
                <tr class="uk-text-small">
                    <th>Наименование услуги</th>
                    <th class="uk-text-center">Время ремонта<th class="uk-text-center">Цена, руб</th>
                </tr>
                    <tr><td>Диагностика</td><td>30м</td><td>0</td></tr>
                    <tr><td>Восстановление IMEI</td><td>2ч</td><td>1190</td></tr>
                    <tr><td>Замена GPS</td><td>2ч</td><td>700</td></tr>
                    <tr><td>Замена NFC</td><td>2ч</td><td>3500</td></tr>
                    <tr><td>Замена USB</td><td>2ч</td><td>600</td></tr>
                    <tr><td>Замена Wi-Fi</td><td>2ч</td><td>500</td></tr>
                    <tr><td>Замена АКБ</td><td>2ч</td><td>500</td></tr>
                    <tr><td>Замена акселерометра</td><td>2ч</td><td>800</td></tr>
                    <tr><td>Замена антенного модуля</td><td>2ч</td><td>550</td></tr>
                    <tr><td>Замена аудиокодека</td><td>2ч</td><td>1850</td></tr>
                    <tr><td>Замена аудио разъема</td><td>2ч</td><td>800</td></tr>
                    <tr><td>Замена болтов</td><td>2ч</td><td>300</td></tr>
                    <tr><td>Замена верхнего шлейфа</td><td>2ч</td><td>700</td></tr>
                    <tr><td>Замена вибромотора</td><td>2ч</td><td>500</td></tr>
                    <tr><td>Замена вспышки</td><td>2ч</td><td>550</td></tr>
                    <tr><td>Замена встроенного микрофона</td><td>2ч</td><td>500</td></tr>
                    <tr><td>Замена глазка камеры</td><td>2ч</td><td>300</td></tr>
                    <tr><td>Замена гнезда питания</td><td>2ч</td><td>800</td></tr>
                    <tr><td>Замена голосового динамика</td><td>2ч</td><td>500</td></tr>
                    <tr><td>Замена датчика отпечатка пальца</td><td>2ч</td><td>990</td></tr>
                    <tr><td>Замена датчика пападания влаги</td><td>2ч</td><td>800</td></tr>
            </tbody>
        </table>',

            // '<table class="priceTable uk-table uk-table-hover uk-table-striped"><tbody><tr class="uk-text-small"><th>Наименование оборудования</th><th class="uk-text-center">Статус</th><th class="uk-text-center">Цена, руб</th></tr>
            // <tr><td>Передняя / задняя камера</td><td>есть в наличии</td><td>1850</td></tr>
            // <tr><td>Вибро</td><td>в наличии на складе</td><td>750</td></tr>
            // <tr><td>Мультиконтроллер</td><td>есть в наличии</td><td>950</td></tr>
            // <tr><td>HDMI разъем</a></td><td>есть в наличии</td><td>650</td></tr>
            // <tr><td>Чип GPS</a></td><td>есть в наличии</td><td>750</td></tr>
            // <tr><td>Внутренний микрофон</td><td>есть в наличии</td><td>1350</td></tr>
            // <tr><td>Шлейф платы</td><td>в наличии на складе</td><td>650</td></tr>
            // <tr><td>Цельный корпус</td><td>в наличии на складе</td><td>850</td></tr>
            // <tr><td>Слуховой динамик</td><td>в наличии на складе</td><td>1750</td></tr>
            // <tr><td>Съемная крышка</td><td>есть в наличии</td><td>850</td></tr>
            // <tr><td>Кнопка включения</td><td>в наличии на складе</td><td>550</td></tr>
            // <tr><td>Разъем для зарядки</td><td>в наличии на складе</td><td>850</td></tr>
            // <tr><td>Плата</td><td>в наличии на складе</td><td>1950</td></tr>
            // <tr><td>Держатель сим</td><td>в наличии на складе</td><td>650</td></tr>
            // <tr><td>Дисплейный модуль</td><td>в наличии на складе</td><td>2650</td></tr>
            // <tr><td>АКБ</td><td>есть в наличии</td><td>1650</td></tr>
            // <tr><td>USB модуль</td><td>в наличии на складе</td><td>650</td></tr>
            // <tr><td>Модуль Wi fi</td><td>в наличии на складе</td><td>750</td></tr></tbody></table>',
            '<p>Стоимость и наличие комплектующих уточняйте у менеджеров по телефону.</p>',
            '300'
    ),
    'remont-ekshen-kamer' => array(
        '<table class="priceTable uk-table uk-table-hover uk-table-striped services gadget"><tbody><tr class="uk-text-small"><th>Наименование услуги</th><th class="uk-text-center">Время ремонта<th class="uk-text-center">Цена, руб</th></tr>  
                <tr><td>Диагностика</td><td>30м</td><td>0</td></tr>
                <tr><td>Восстановление после попадания влаги</td><td>2ч</td><td>3250</td></tr> 
                <tr><td>Замена USB разъема</td><td>2ч</td><td>1390</td></tr> 
                <tr><td>Замена Wi-Fi модуля</td><td>2ч</td><td>2750</td></tr> 
                <tr><td>Замена датчика температуры</td><td>2ч</td><td>1490</td></tr> 
                <tr><td>Замена дисплея</td><td>2ч</td><td>1490</td></tr> 
                <tr><td>Замена картридера SD</td><td>2ч</td><td>1390</td></tr> 
                <tr><td>Замена микрофона</td><td>2ч</td><td>1490</td></tr> 
                <tr><td>Замена оптики</td><td>2ч</td><td>3350</td></tr> 
                <tr><td>Замена системной платы</td><td>2ч</td><td>1750</td></tr> 
                <tr><td>Настройка оптики</td><td>2ч</td><td>2250</td></tr> 
                <tr><td>Прошивка </td><td>2ч</td><td>1850</td></tr> 
                <tr><td>Чистка оптики</td><td>2ч</td><td>1950</td></tr> 
            </tbody> 
        </table>',
        '<p>Стоимость и наличие комплектующих уточняйте у менеджеров по телефону.</p>',
        '1400',
    ),
	'remont-apple-watch' => array(
        '<table class="priceTable uk-table uk-table-hover uk-table-striped services gadget"><tbody><tr class="uk-text-small"><th>Наименование услуги</th><th class="uk-text-center">Время ремонта<th class="uk-text-center">Цена, руб</th></tr>
                <tr><td>Диагностика</td><td>30м</td><td>0</td></tr>
        		<tr><td>Восстановление ПО</td><td>1ч</td><td>1500</td></tr>
        		<tr><td>Замена аккумулятора</td><td>3ч</td><td>1050</td></tr>
        		<tr><td>Замена беспроводной зарядки</td><td>3ч</td><td>2350</td></tr>
        		<tr><td>Замена вибромотора</td><td>1ч</td><td>1050</td></tr>
        		<tr><td>Замена динамика</td><td>2ч</td><td>1050</td></tr>
        		<tr><td>Замена дисплея в сборе со стеклом</td><td>2ч</td><td>1150</td></tr>
        		<tr><td>Замена корпуса</td><td>2ч</td><td>1450</td></tr>
        		<tr><td>Замена механизма включения</td><td>1ч</td><td>1050</td></tr>
        		<tr><td>Замена микрофона</td><td>2ч</td><td>1050</td></tr>
        		<tr><td>Замена модуля Bluetooth</td><td>3ч</td><td>2100</td></tr>
		</tbody></table>',
		'<p>Стоимость и наличие комплектующих уточняйте у менеджеров по телефону.</p>',
		'1050',
    ),
	'remont-materinskih-plat' => array(
        '<table class="priceTable uk-table uk-table-hover uk-table-striped services gadget"><tbody><tr class="uk-text-small"><th>Наименование услуги</th><th class="uk-text-center">Время ремонта<th class="uk-text-center">Цена, руб</th></tr>
        <tr><td>Диагностика</td><td>30м</td><td>0</td></tr>
		<tr><td>Замена контроллера питания </td>2ч<td></td><td>3350</td></tr>
		<tr><td>Замена порта  Ethernet</td>2ч<td></td><td>1950</td></tr>
		<tr><td>Замена порта USB</td>2ч<td></td><td>1950</td></tr>
		<tr><td>Замена порта аудио</td>2ч<td></td><td>1950</td></tr>
		<tr><td>Замена северного моста</td>2ч<td></td><td>4850</td></tr>
        <tr><td>Замена слотов оперативной памяти</td>2ч<td></td><td>2150</td></tr>
		<tr><td>Замена южного моста</td>2ч<td></td><td>4850</td></tr>
		<tr><td>Прошивка BIOS</td>2ч<td></td><td>2450</td></tr>
		<tr><td>Ремонт цепи питания</td>2ч<td></td><td>3550</td></tr>
		</tbody></table>',
		'<p>Стоимость и наличие комплектующих уточняйте у менеджеров по телефону.</p>',
		'1900',
    ),
	'remont-samsung-gear' => array(
        '<table class="priceTable uk-table uk-table-hover uk-table-striped services gadget"><tbody><tr class="uk-text-small"><th>Наименование услуги</th><th class="uk-text-center">Время ремонта<th class="uk-text-center">Цена, руб</th></tr>
		        <tr><td>Диагностика</td><td>30м</td><td>0</td></tr>
                <tr><td>Восстановление ПО</td><td>1ч</td><td>1500</td></tr>
                <tr><td>Замена аккумулятора</td><td>3ч</td><td>1050</td></tr>
                <tr><td>Замена беспроводной зарядки</td><td>3ч</td><td>2350</td></tr>
                <tr><td>Замена вибромотора</td><td>1ч</td><td>1050</td></tr>
                <tr><td>Замена динамика</td><td>2ч</td><td>1050</td></tr>
                <tr><td>Замена дисплея в сборе со стеклом</td><td>2ч</td><td>1150</td></tr>
                <tr><td>Замена корпуса</td><td>2ч</td><td>1450</td></tr>
                <tr><td>Замена механизма включения</td><td>1ч</td><td>1050</td></tr>
                <tr><td>Замена микрофона</td><td>2ч</td><td>1050</td></tr>
                <tr><td>Замена модуля Bluetooth</td><td>3ч</td><td>2100</td></tr>
		</tbody></table>', 		
		'<p>Стоимость и наличие комплектующих уточняйте у менеджеров по телефону.</p>',
		'1050',
    ),
	'remont-videocamer' => array(
        '<table class="priceTable uk-table uk-table-hover uk-table-striped services gadget"><tbody><tr class="uk-text-small"><th>Наименование услуги</th><th class="uk-text-center">Время ремонта<th class="uk-text-center">Цена, руб</th></tr>  
                <tr><td>Диагностика</td><td>30м</td><td>0</td></tr> 
                <tr><td>Замена аккумулятора</td><td>15м</td><td>850</td></tr> 
                <tr><td>Замена диафрагмы</td><td>2ч</td><td>2000</td></tr>
                <tr><td>Замена диска управления</td><td>1ч</td><td>2300</td></tr> 
                <tr><td>Замена дисплея </td><td>2ч</td><td>1850</td></tr> 
                <tr><td>Замена кнопки включения</td><td>2ч</td><td>1600</td></tr> 
                <tr><td>Замена контроллера питания</td><td>2ч</td><td>1850</td></tr> 
                <tr><td>Замена корпуса</td><td>2ч</td><td>2150</td></tr> 
                <tr><td>Замена линз</td><td>2ч</td><td>1850</td></tr> 
                <tr><td>Замена микрофона</td><td>2ч</td><td>1600</td></tr> 
                <tr><td>Замена платы управления </td><td>2ч</td><td>2000</td></tr> 
                <tr><td>Замена слота карты памяти</td><td>2ч</td><td>850</td></tr> 
                <tr><td>Замена шлейфа фокусировки</td><td>2ч</td><td>2000</td></tr> 
                <tr><td>Программный ремонт</td><td>2ч</td><td>2300</td></tr> 
                <tr><td>Ремонт диафрагмы</td><td>2ч</td><td>2000</td></tr> 
            </tbody>
        </table>',
        '<p>Стоимость и наличие комплектующих уточняйте у менеджеров по телефону.</p>',
        '850',
    ),
	'remont-elektrosamokatov' => array(
        '<table class="priceTable uk-table uk-table-hover uk-table-striped services gadget"><tbody><tr class="uk-text-small"><th>Наименование услуги</th><th class="uk-text-center">Время ремонта<th class="uk-text-center">Цена, руб</th></tr>
        		<tr><td>Диагностика</td><td>30м</td><td>0</td></tr>
        		<tr><td>Замена АКБ</td><td>1ч</td><td>500</td></tr>
        		<tr><td>Замена болта узла складывания</td><td>15м</td><td>1100</td></tr>
        		<tr><td>Замена камеры</td><td>15м</td><td>500</td></tr>
        		<tr><td>Замена комплекта болтов оси</td><td>1ч</td><td>1000</td></tr>
        		<tr><td>Замена крыла</td><td>15м</td><td>600</td></tr>
        		<tr><td>Замена платы управления</td><td>1д</td><td>500</td></tr>
        		<tr><td>Замена подножки</td><td>15м</td><td>500</td></tr>
        		<tr><td>Замена подшипников</td><td>1ч</td><td>500</td></tr>
        		<tr><td>Замена предохранителя</td><td>2ч</td><td>600</td></tr>
        		<tr><td>Замена язычка узла складывания</td><td>15м</td><td>200</td></tr>
        		<tr><td>Настройка механического тормоза</td><td>15м</td><td>300</td></tr>
        		<tr><td>Проклейка оригинальных покрышек</td><td>2ч</td><td>300</td></tr>
        		<tr><td>Установка заглушки гнезда зарядки</td><td>15м</td><td>1500</td></tr>
        		<tr><td>Установка защиты днища</td><td>1ч</td><td>600</td></tr>
        		<tr><td>Установка литой покрышки</td><td>1ч</td><td>200</td></tr>
		<tbody></table>', 		
		'<p>Стоимость и наличие комплектующих уточняйте у менеджеров по телефону.</p>',
		'200',
    ),
	'remont-robotov-pylesosov' => array(
        '<table class="priceTable uk-table uk-table-hover uk-table-striped services gadget">
        <tbody>
        <tr class="uk-text-small">
            <th>Наименование услуги</th>
            <th class="uk-text-center">Время ремонта<th class="uk-text-center">Цена, руб</th>
        		<tr><td>Восстановление после попадания влаги</td><td>2ч</td><td>2650</td></tr>
        		<tr><td>Замена аккумулятора</td><td>45м</td><td>1850</td></tr>
        		<tr><td>Замена датчиков</td><td>2ч</td><td>1750</td></tr>
        		<tr><td>Замена колеса управления</td><td>45м</td><td>1850</td></tr>
        		<tr><td>Замена платы управления</td><td>2ч</td><td>1750</td></tr>
        		<tr><td>Замена щёток</td><td>45м</td><td>1750</td></tr>
		<tbody></table>', 		
		'<p>Стоимость и наличие комплектующих уточняйте у менеджеров по телефону.</p>',
		'1750',
    ),
	'remont-naushnikov' => array(
	   '<table class="priceTable uk-table uk-table-hover uk-table-striped services gadget"><tbody><tr class="uk-text-small"><th>Наименование услуги</th><th class="uk-text-center">Время ремонта, мин<th class="uk-text-center">Цена, руб</th></tr>
        <tr><td>Диагностика</td><td>30</td><td>0</td></tr>
        <tr><td>Восстановление динамических излучателей</td><td>120</td><td>2000</td></tr>
		<tr><td>Замена Y - разветвителя</td><td>120</td><td>700</td></tr>
		<tr><td>Замена аккумулятора</td><td>120</td><td>600</td></tr>
		<tr><td>Замена амбушюр</td><td>120</td><td>200</td></tr>
		<tr><td>Замена джека</td><td>120</td><td>300</td></tr>
		<tr><td>Замена динамика</td><td>120</td><td>400</td></tr>
		<tr><td>Замена дуги</td><td>120</td><td>600</td></tr>
		<tr><td>Замена кабеля</td><td>120</td><td>200</td></tr>
        <tr><td>Замена коннекторов</td><td>120</td><td>900</td></tr>
        <tr><td>Замена корпусной детали</td><td>120</td><td>300</td></tr>
        <tr><td>Замена разъемов</td><td>120</td><td>500</td></tr>
        <tr><td>Измерение АЧХ</td><td>120</td><td>50</td></tr>
		<tbody></table>', 		
		'<p>Стоимость и наличие комплектующих уточняйте у менеджеров по телефону.</p>',
		'50',
    ),
    'remont-proektorov' => array(
        '<table class="priceTable uk-table uk-table-hover uk-table-striped services gadget"><tbody><tr class="uk-text-small"><th>Наименование услуги</th><th class="uk-text-center">Время ремонта<th class="uk-text-center">Цена, руб</th></tr>
        		<tr><td>Диагностика</td><td>30</td><td>0</td></tr>
        		<tr><td>Восстановление блока питания</td><td>1ч</td><td>1200</td></tr>
        		<tr><td>Замена DMD-чипа</td><td>2ч</td><td>910</td></tr>
        		<tr><td>Замена вентилятора системы охлаждения</td><td>2ч</td><td>950</td></tr>
        		<tr><td>Замена колеса цветофильтров</td><td>2ч</td><td>850</td></tr>
        		<tr><td>Замена лампы</td><td>2ч</td><td>330</td></tr>
        		<tr><td>Замена материнской платы</td><td>2ч</td><td>1150</td></tr>
                <tr><td>Замена оптического блока</td><td>2ч</td><td>1000</td></tr>
                <tr><td>Замена платы сопряжения</td><td>2ч</td><td>1000</td></tr>
                <tr><td>Замена системы накала лампы</td><td>2ч</td><td>850</td></tr>
                <tr><td>Профилактическая чистка </td><td>2ч</td><td>800</td></tr>
                <tr><td>Ремонт балластера</td><td>2ч</td><td>1450</td></tr>
                <tr><td>Ремонт блока управления</td><td>2ч</td><td>1500</td></tr>
                <tr><td>Ремонт материнской платы </td><td>2ч</td><td>1600</td></tr>
                <tr><td>Ремонт системы охлаждения</td><td>2ч</td><td>1300</td></tr>
		<tbody></table>', 		
		'<p>Стоимость и наличие комплектующих уточняйте у менеджеров по телефону.</p>',
		'330',
    ),
    'remont-coffee-machin' => array(
        '<table class="priceTable uk-table uk-table-hover uk-table-striped services gadget"><tbody><tr class="uk-text-small"><th>Наименование услуги</th><th class="uk-text-center">Время ремонта<th class="uk-text-center">Цена, руб</th></tr>
                <tr><td>Диагностика</td><td>30м</td><td>0</td></tr>
                <tr><td>Замена термоблока</td><td>4д</td><td>2500</td></tr>
                <tr><td>Замена бака воды</td><td>4д</td><td>800</td></tr>
                <tr><td>Замена бойлера</td><td>4д</td><td>1000</td></tr>
                <tr><td>Замена гидросистемы</td><td>4д</td><td>1000</td></tr>
                <tr><td>Замена датчика танка воды</td><td>4д</td><td>1000</td></tr>
                <tr><td>Замена двигателя кофемолки</td><td>4д</td><td>2500</td></tr>
                <tr><td>Замена дисплея</td><td>4д</td><td>4000</td></tr>
                <tr><td>Замена жерновов</td><td>4д</td><td>1000</td></tr>
                <tr><td>Замена заварного механизма</td><td>4д</td><td>1000</td></tr>
                <tr><td>Замена клапана пара</td><td>4д</td><td>2500</td></tr>
                <tr><td>Замена контактов поддона</td><td>4д</td><td>1000</td></tr>
                <tr><td>Замена крана пара</td><td>4д</td><td>1000</td></tr>
                <tr><td>Замена микровыключателя</td><td>4д</td><td>1000</td></tr>
                <tr><td>Замена мультиклапана</td><td>4д</td><td>1000</td></tr>
                <tr><td>Замена платы логики</td><td>4д</td><td>1500</td></tr>
                <tr><td>Замена помпы</td><td>4д</td><td>1000</td></tr>
                <tr><td>Замена предохранителя</td><td>4д</td><td>2500</td></tr>
                <tr><td>Замена прокладок</td><td>4д</td><td>800</td></tr>
                <tr><td>Замена редуктора в сборе </td><td>4д</td><td>4000</td></tr>
                <tr><td>Замена силовой платы</td><td>4д</td><td>4000</td></tr>
                <tr><td>Замена счетчика воды</td><td>4д</td><td>1000</td></tr>
                <tr><td>Замена термостата</td><td>4д</td><td>1000</td></tr>
                <tr><td>Замена трансформатора</td><td>4д</td><td>2500</td></tr>
        <tbody></table>',
        '<p>Стоимость и наличие комплектующих уточняйте у менеджеров по телефону.</p>',
		'800',
    ),
    'remont-obogrevatelej' => array(
        '<table class="priceTable uk-table uk-table-hover uk-table-striped services gadget"><tbody><tr class="uk-text-small"><th>Наименование услуги</th><th class="uk-text-center">Время ремонта<th class="uk-text-center">Цена, руб</th></tr>
            	<tr><td>Замена вилок</td><td>40-60</td><td>1450
            	<tr><td>Замена датчика температуры</td><td>50-120</td><td>1390
            	<tr><td>Замена двигателя</td><td>50-120</td><td>1350
            	<tr><td>Замена индикатора включения</td><td>50-120</td><td>1400
            	<tr><td>Замена кнопок</td><td>50-120</td><td>1500
            	<tr><td>Замена корпуса</td><td>50-120</td><td>1800
            	<tr><td>Замена лампочек</td><td>50-120</td><td>1750
            	<tr><td>Замена ремня</td><td>50-120</td><td>1650
            	<tr><td>Замена ТЭНов</td><td>50-120</td><td>1850
            	<tr><td>Замена узла регулировки температуры</td><td>50-120</td><td>1600
            	<tr><td>Замена узла управления</td><td>50-120</td><td>1300
            	<tr><td>Замена шестерен</td><td>50-120</td><td>1250
            	<tr><td>Замена шнура</td><td>50-120</td><td>1700
            	<tr><td>Замена шнэка</td><td>50-120</td><td>1800
            	<tr><td>Замена электропроводки</td><td>50-120</td><td>1900
            	<tr><td>Пайка проводов</td><td>50-120</td><td>1100
            	<tr><td>Регулировка электронных узлов</td><td>60-120</td><td>1200
            	<tr><td>Ремонт вилок</td><td>60-120</td><td>1250
            	<tr><td>Ремонт датчика температуры</td><td>60-120</td><td>1300
            	<tr><td>Ремонт двигателя</td><td>50-120</td><td>1250
            	<tr><td>Ремонт индикатора включения</td><td>50-120</td><td>1790
            	<tr><td>Ремонт намоточного устройства</td><td>50-120</td><td>1400
        <tbody></table>',
        '<p>Стоимость и наличие комплектующих уточняйте у менеджеров по телефону.</p>',
        '1100',
    ),
        
    'remont-serverov' => array(
        '<table class="priceTable uk-table uk-table-hover uk-table-striped services gadget"><tbody><tr class="uk-text-small"><th>Наименование услуги</th><th class="uk-text-center">Время ремонта<th class="uk-text-center">Цена, руб</th></tr> 
                <tr><td>Диагностика</td><td>30</td><td>0</td></tr>
                <tr><td>Восстановление массива</td><td>2ч</td><td>2000</td></tr>
                <tr><td>Замена процессора</td><td>1ч</td><td>950</td></tr>
                <tr><td>Замена DVD привода</td><td>45м</td><td>1000</td></tr>
                <tr><td>Замена HDD</td><td>45м</td><td>500</td></tr>
                <tr><td>Замена RAID контроллера</td><td>1ч</td><td>1000</td></tr>
                <tr><td>Замена блока питания</td><td>45м</td><td>500</td></tr>
                <tr><td>Замена корзины для жестких дисков</td><td>45м</td><td>1000</td></tr>
                <tr><td>Замена корпуса</td><td>2ч</td><td>5000</td></tr>
                <tr><td>Замена кулера</td><td>45м</td><td>700</td></tr>
                <tr><td>Замена лицевой панели</td><td>45м</td><td>1000</td></tr>
                <tr><td>Замена материнской платы</td><td>2ч</td><td>950</td></tr>
                <tr><td>Замена платы расширения</td><td>45м</td><td>1500</td></tr>
                <tr><td>Замена северного моста</td><td>30м</td><td>950</td></tr>
                <tr><td>Замена трансивера</td><td>45м</td><td>1000</td></tr>
                <tr><td>Замена южного моста</td><td>30м</td><td>850</td></tr>
                <tr><td>Модернизация</td><td>2ч</td><td>2000</td></tr>
                <tr><td>Обновление BIOS </td><td>2ч</td><td>500</td></tr>
                <tr><td>Настройка</td><td>2ч</td><td>2900</td></tr>
                <tr><td>Ремонт USB</td><td>3ч</td><td>1600</td></tr>
                <tr><td>Ремонт блока питания</td><td>2ч</td><td>700</td></tr>
                <tr><td>Ремонт кнопок</td><td>30м</td><td>900</td></tr>
                <tr><td>Ремонт материнской платы</td><td>3ч</td><td>2500</td></tr>
                <tr><td>Ремонт северного моста</td><td>45м</td><td>1400</td></tr>
                <tr><td>Сборка</td><td>3ч</td><td>2500</td></tr>
                <tr><td>Установка операционной системы</td><td>45м</td><td>5000</td></tr>
                <tr><td>Установка RAID-массива, SCSI контроллера</td><td>2ч</td><td>1500</td></tr>
                <tr><td>Замена термопасты</td><td>45м</td><td>800</td></tr>
                <tr><td>Чистка от влаги</td><td>45м</td><td>400</td></tr>
                <tr><td>Чистка сервера от пыли</td><td>45м</td><td>700</td></tr>
        </tbody></table>',
        '',
        '400',
    ), 
);

$gadget = $add_device_type[$this->_datas['arg_url']];
$accord_image = $this->_datas['accord_image'];
$name = tools::mb_ucfirst($gadget['type']);
if (strpos($accord_image[$gadget['type']], 'brand') !== false) {
	$accord_image[$gadget['type']] = str_replace('brand', $marka_lower, $accord_image[$gadget['type']]);
}	
$this->_ret['img'] = 'wp-content/uploads/2015/03/'.$marka_lower.'/'.$accord_image[$gadget['type']].$region_code.'.png';

$accord_apple = array('ноутбук' => 'MacBook', 'смартфон' => 'iPhone', 'планшет' => 'iPad', 'моноблок' => 'iMac', 'смарт-часы' => 'Watch');

$use_choose_city = $this->_datas['use_choose_city'];
$add_class = ($use_choose_city) ? " js-choose-city" : "";

?>

    <div class="sr-main target">
        <div class="uk-width-medium-1-1 bgcolorwhite uk-hidden-small breadcrumbs">
            <div class="uk-container-center uk-container">
                 <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/" class="uk-icon-home uk-text-muted"><meta itemprop="title" content="Главная"/></a></span>
                 &nbsp;/&nbsp;
                 <span class="uk-text-muted"><?=tools::mb_ucfirst($gadget['type_m'], 'utf-8', false)?></span>
            </div>
        </div>

        <div class="uk-width-medium-1-1 bgcolorwhite uk-visible-small<?=$add_class?>">
            <div class="uk-container-center uk-container">
               <a href="tel:+<?=$phone?>" class="uk-text-muted"><?=$phone_format?></a>
            </div>
        </div>


        <div class="uk-container-center uk-container" itemscope itemtype="http://schema.org/Product">
            <div class="uk-grid uk-margin-remove" data-uk-grid-margin>
                <div class="uk-width-medium-4-10 ">
                    <img itemprop="image" src="/<?=$this->_ret['img']?>" class="uk-margin-top uk-align-center">
                </div>
                <div class="uk-width-medium-6-10 whiteblock ">
                    <h1 itemprop="name"><?=$this->_ret['h1']?></h1>
                    <span itemprop="description">
						<?php
						$feed = $this->_datas['feed'];
						srand($feed);
						
						$S1 = array('[name]', '[brand]', '[types]');
						$S2 = array($servicename, $marka, $gadget['type_rm']);

						switch ($gadget['type']) {
							case 'смарт-часы':
								echo tools::gen_text($S1, $S2, "{Специалисты|Мастера} сервисного центра [name] занимаются ремонтом [types] [brand]. При работе {используются|применяются} только {оригинальные|фирменные} комплектующие. Мастера являются {дипломированными|сертифицированными} специалистами, с большим опытом ремонта данного бренда. Наши {специалисты|инженеры} знают все {характерные|специфичный} особенности устройства часов [brand]. После проведения ремонта в нашем сервисе, устройство {прослужит|будет служить} вам гарантированно долго.");
							break;
							case 'материнская плата':
								echo tools::gen_text($S1, $S2, "Ремонт материнских плат [brand] в нашем сервисном центре – вы получите гарантированно качественный результат. Имея в штате только {квалифицированных|сертифицированных} специалистов и {современное|новое} оборудование, ремонт будет {произведен|проведен} по всем стандартам. Вы можете {самостоятельно|сами} привезти деталь или вызвать курьера. Услуга бесплатной диагностики гарантирует точное {определение|выявление} причины поломки и {последующее|дальнейшее} ее эффективное устранение.");
							break;
							case 'принтер':
								echo tools::gen_text($S1, $S2, "Сервисный центр [name] осуществляет ремонт принтеров [brand]. В распоряжении наших мастеров современное оборудование, позволяющее эффективно исправить неполадку. Наш мастер может провести диагностику при некорректной работе устройства. Диагностика является бесплатной услугой и проводится в течении 20 минут. После проведения ремонта, дается гарантия на проведенную работу.");
							break;
							case 'фотоаппарат':
								echo tools::gen_text($S1, $S2, "Сервисный центр [name] поможет быстро и качественно выполнить ремонт фотоаппаратов [brand]. На все проведенные работы и установленные запчасти дается гарантия, это позволит вам быть уверенным в проведенном ремонте. При ремонте мастера используют самое современное оборудование, которое позволяет максимально эффективно выполнить работы любой сложности. Свяжитесь с нашим менеджером, который ответит на все возникшие вопросы.");
							break;
							case 'видеокамера':
								echo tools::gen_text($S1, $S2, "Сервисный центр [name] {выполнит|осуществляет} ремонт видеокамеры [brand] не зависимо от модели вашего устройства. Диагностика в {сервисе|мастерской} проводится бесплатно, она поможет {выявить|определить} даже скрытые дефекты вашего устройства. Мастера специализируются на {ремонте|обслуживании} техники [brand], это позволяет знать все {особенности| специфика} данного бренда. На все выполненные работы {дается|выдается} гарантия.");
							break;
							case 'телевизор':
								echo tools::gen_text($S1, $S2, "Наш сервисный центр [name] занимается ремонтом телевизоров [brand]. {Специалисты|Мастера} {возьмут|примут} в ремонт любую модель, за исключением кинескопной. {Благодаря|По причине} обязательной аттестации мастеров, работы {проводятся|выполняются} максимально оперативно и качественно. Для получения {подробной|полной} информации, можно связаться с нашим {менеджером|оператором} по телефону или оставить заявку на ремонт через сайт. На установленные детали и выполненные работы дается гарантия.");
							break;
							case 'электросамокат':
								echo tools::gen_text($S1, $S2, "Мастера сервисного центра [name] готовы провести ремонт электросамокатов Xiaomi Mijia. Мы отремонтируем как видимые повреждения корпуса, так и скрытые дефекты. Для определения точной причины поломки, перед началом работы, мастер проведет диагностику техники. Сервис обладает современным оборудованием и оригинальными деталями Xiaomi, это позволяет быть уверенным в выполненном ремонте. Узнать подробнее интересующую информацию можно у менеджеров по телефону.");
							break;
							case 'пылесос':
								if ($marka_lower == 'xiaomi')
									echo tools::gen_text($S1, $S2, "Специалисты [name] проводят ремонт роботов-пылесосов Xiaomi. Обращаясь в наш сервис, вы получаете качественный ремонт. Детали заказываются у официальных поставщиков без лишней наценки, это позволяет не завышать цены на проводимые работы. Благодаря постоянному повышению квалификации, специалисты качественно выполняют ремонт самых высокотехнолочных устройств. Записаться на ремонт можно оставив заявку на сайте или связавшись с нашим менеджером по телефону.");
								else {
									?>
									<p>Чтобы ни случилось с <?=$gadget['type_de']?> - вам не стоит беспокоиться. Специалисты <?=mb_strtoupper($marka)?> Russia придут на помощь тогда, когда это будет необходимо.</p>

									<? if ($marka_lower == 'apple'):?>
										<p><?=$marka?> <?=(isset($accord_apple[$gadget['type']]) ? $accord_apple[$gadget['type']] : tools::mb_ucfirst($gadget['type_m'], 'utf-8', false))?> отличаются своей надежностью. Но как и любой технике, им требуется регулярная профилактика, а в некоторых случаях - и сервисное обслуживание.</p>
									<?else:?>
										<p><?=tools::mb_ucfirst($gadget['type_m'], 'utf-8', false)?> <?=$marka?> отличаются своей надежностью. Но как и любой технике, им требуется регулярная профилактика, а в некоторых случаях - и сервисное обслуживание.</p>
									<?endif;?>
									<?
								}
							break;
							case 'наушники':
								echo tools::gen_text($S1, $S2, "Специалисты [name] проведут ремонт наушников Xiaomi с максимальной выгодой для заказчика. Все процессы по проведению ремонта четко регламентированы внутренними документами сервиса. Это позволяет проводить ремонт в кратчайшие сроки, не завышая цену работы. При возникновении первых признаков неполадки, мастер проведет диагностику, это позволит выявить даже скрытые дефекты устройства. Свяжитесь с нашим менеджером по телефону и выясните все интересующие вопросы.");
							break;
							default:
						?>
							<p>Чтобы ни случилось с <?=$gadget['type_de']?> - вам не стоит беспокоиться. Специалисты <?=mb_strtoupper($marka)?> Russia придут на помощь тогда, когда это будет необходимо.</p>

							<? if ($marka_lower == 'apple'):?>
								<p><?=$marka?> <?=(isset($accord_apple[$gadget['type']]) ? $accord_apple[$gadget['type']] : tools::mb_ucfirst($gadget['type_m'], 'utf-8', false))?> отличаются своей надежностью. Но как и любой технике, им требуется регулярная профилактика, а в некоторых случаях - и сервисное обслуживание.</p>
							<?else:?>
								<p><?=tools::mb_ucfirst($gadget['type_m'], 'utf-8', false)?> <?=$marka?> отличаются своей надежностью. Но как и любой технике, им требуется регулярная профилактика, а в некоторых случаях - и сервисное обслуживание.</p>
							<?endif;?>
							<?
							break;
						}
						
						?>
                    </span>
                    <p class="textPrice" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                        <span class="uk-align-left uk-text-large target-price" itemprop="price">от <?=$info_block[$this->_datas['arg_url']][2]?> руб.</span>
                        <meta itemprop="priceCurrency" content="RUB"/>
                        <span class="uk-align-right"><input data-uk-modal="{target:'#popup'}" class=" uk-button  uk-button-large uk-button-success uk-margin-right" onclick="if (typeof window['yaCounter<?=$metrica?>'] !== 'undefined') yaCounter<?=$metrica?>.reachGoal('ORDER'); return false;" value="Записаться на ремонт"/></span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="sr-content">
        <div class="uk-container-center uk-container uk-margin-bottom">
            <div class="uk-flex sr-contetnt-block uk-margin-top sr-content-main">
                <div class="uk-width-large-7-10 sr-content-white ">
                    <p class="uk-h2 uk-margin-top">Цены на услуги по ремонту <?=$gadget['type_rm']?> <?=$marka?></p>
                    <?=$info_block[$this->_datas['arg_url']][0]?>
                    <?php if (strpos($info_block[$this->_datas['arg_url']][1], '<table>') !== false) { ?>
                    <p class="uk-h2 uk-margin-top">Цены на комплектующие для <?=$gadget['type_rm']?> <?=$marka?></p>
                    <?=$info_block[$this->_datas['arg_url']][1]?>
                    <? } ?>
                </div>
                <? include __DIR__.'/right_part_new.php'; ?>
            </div>
        </div>
    </div>
