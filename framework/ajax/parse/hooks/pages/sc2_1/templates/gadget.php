<?
use framework\tools;

$marka = $this->_datas['marka']['name'];
$ru_marka =  $this->_datas['marka']['ru_name'];
$servicename = $this->_datas['servicename'];

$add_device_type = $this->_datas['add_device_type'];

$info_block = array(
    'computers' => array(
        '<table class="priceTable"> <tbody> <tr> <td>Название услуги</td> <td>Сроки&nbsp;ремонта</td> <td>Цена, р.</td> </tr> <tr> <td>Замена матрицы</td> <td>45-60&nbsp;мин</td> <td>790</td> </tr> <tr> <td>Замена материнской платы моноблока</td> <td>1-3 ч</td> <td>1190</td> </tr> <tr> <td>Замена процессора моноблока</td> <td>1 ч</td> <td>790</td> </tr> <tr> <td>Замена видеочипа, чипа южного или северного моста</td> <td>2-3 ч</td> <td>2590</td> </tr> <tr> <td>Замена разъема ЗУ</td> <td>30-40 мин</td> <td>1290</td> </tr> <tr> <td>Замена разъема платы</td> <td>30-40 мин</td> <td>790</td> </tr> <tr> <td>Замена разъема HDMI, USB и других, за ед.</td> <td>30-45 мин</td> <td>1490</td> </tr> <tr> <td>Ремонт цепи питания моноблока</td> <td>2-3 ч</td> <td>2690</td> </tr> <tr> <td>Замена модуля WiFi</td> <td>30 мин</td> <td>290</td> </tr> <tr> <td>Замена HDD или SSD</td> <td>30 мин</td> <td>290</td> </tr> <tr> <td>Замена модуля ОЗУ моноблока</td> <td>15&nbsp;мин</td> <td>140</td> </tr> <tr> <td>Ремонт корпуса устройства</td> <td>1-2&nbsp;ч</td> <td>1190</td> </tr> <tr> <td>Замена стекла экрана</td> <td>1-2 ч</td> <td>1240</td> </tr> <tr> <td>Замена батареи Bios</td> <td>30 мин</td> <td>440</td> </tr> <tr> <td>Чистка интерфейсов и системы охлаждения</td> <td>30-60 мин</td> <td>1390</td> </tr> <tr> <td>Удаление жидкости с поверхности материнской платы</td> <td>1-2 ч</td> <td>1190</td> </tr> <tr> <td>Восстановление контактных элементов чипов, разъемов и портов, за ед.</td> <td>30-60 мин</td> <td>390</td> </tr> <tr> <td>Настройка программного обеспечения</td> <td>от 30 мин</td> <td>от 790</td> </tr> </tbody> </table>',
        '<table class="priceTable"> <tbody> <tr> <td>Название комплектующей</td> <td>Наличие</td> <td>Цена, р.</td> </tr> <tr> <td>Матрица экрана моноблока</td> <td>в наличии / на заказ</td> <td>от 4490</td> </tr> <tr> <td>Твердый накопитель HDD / SSD</td> <td>есть в наличии</td> <td>от 2490</td> </tr> <tr> <td>Модуль ОЗУ для моноблока</td> <td>есть в наличии</td> <td>от 1440</td> </tr> <tr> <td>Материнская плата</td> <td>на складе / на заказ</td> <td>от 6490</td> </tr> <tr> <td>Мультиконтроллер</td> <td>в наличии / на&nbsp;складе</td> <td>1190</td> </tr> <tr> <td>Разъемы HDMI, USB и другие, за ед.</td> <td>в наличии / на заказ</td> <td>540</td> </tr> <tr> <td>Разъем&nbsp;питания ЗУ</td> <td>есть в наличии</td> <td>440</td> </tr> <tr> <td>Чип южного или северного моста, видеочип)</td> <td>в наличии / на заказ</td> <td>1490 – 3490</td> </tr> <tr> <td>Вентилятор охлаждения</td> <td>есть в наличии</td> <td>1390</td> </tr> </tbody> </table>',
        '290',
    ),

   'foto' => array(
        '<table class="priceTable"> <tbody> <tr> <td>Название услуги</td> <td>Цена, р.</td> <td>Сроки&nbsp;ремонта</td> </tr> <tr> <td>Ремонт шторок объектива</td> <td>590</td> <td>45-60 мин</td> </tr> <tr> <td>Ремонт разъема USB</td> <td>490</td> <td>30-45 мин</td> </tr> <tr> <td>Ремонт аккумулятора</td> <td>390</td> <td>30-45 мин</td> </tr> <tr> <td>Ремонт линз</td> <td>390</td> <td>30-45 мин</td> </tr> <tr> <td>Ремонт вспышки</td> <td>390</td> <td>30-45 мин</td> </tr> <tr> <td>Ремонт платы питания</td> <td>1890</td> <td>1,5 ч</td> </tr> <tr> <td>Ремонт LCD дисплея</td> <td>890</td> <td>50-60 мин</td> </tr> <tr> <td>Ремонт контроллера</td> <td>1790</td> <td>1,5 ч</td> </tr> <tr> <td>Ремонт корпусной детали</td> <td>390</td> <td>30-45 мин</td> </tr> <tr> <td>Ремонт спускового механизма</td> <td>1190</td> <td>1-1,5 ч</td> </tr> <tr> <td>Ремонт ЛПМ</td> <td>1190</td> <td>1-1,5 ч</td> </tr> <tr> <td>Ремонт материнской платы</td> <td>4000</td> <td>1,5-2 ч</td> </tr> <tr> <td>Конфигурирование дисплея</td> <td>1190</td> <td>1-1,5 ч</td> </tr> <tr> <td>Ремонт затвора</td> <td>490</td> <td>30-45 мин</td> </tr> <tr> <td>Ремонт объектива</td> <td>590</td> <td>45-60 мин</td> </tr> <tr> <td>Ремонт ПЗС матрицы</td> <td>1190</td> <td>1-1,5 ч</td> </tr> <tr> <td>Настройка и восстановление ПО</td> <td>1090</td> <td>1-1,5 ч</td> </tr> <tr> <td>Ремонт разъёма Flash</td> <td>590</td> <td>45-60 мин</td> </tr> <tr> <td>Ремонт системной платы</td> <td>790</td> <td>50-60 мин</td> </tr> <tr> <td>Ремонт матрицы</td> <td>690</td> <td>45-60 мин</td> </tr> <tr> <td>Ремонт цепи питания</td> <td>390</td> <td>30-45 мин</td> </tr> <tr> <td>Ремонт шлейфа</td> <td>1390</td> <td>1-1,5 ч</td> </tr> </tbody> </table>',
        '<p>Наличие и цены на комплектующие узнавайте по телефону горячей линии.</p>',
        '390',
   ),

   'all-in-one' => array(
        '<table class="priceTable"> <tbody> <tr> <td>Название услуги</td> <td>Сроки&nbsp;ремонта</td> <td>Цена, р.</td> </tr> <tr> <td>Ремонт деталей в узле формирования изображения</td> <td>2390</td> <td>1,5 ч</td> </tr> <tr> <td>Ремонт деталей узла переноса изображения</td> <td>1290</td> <td>50-60 мин</td> </tr> <tr> <td>Ремонт деталей узла сканирования</td> <td>3190</td> <td>1,5-2 ч</td> </tr> <tr> <td>Ремонт деталей узла транспортировки</td> <td>1390</td> <td>1-1,5 ч</td> </tr> <tr> <td>Ремонт детали узла подачи</td> <td>1290</td> <td>50-60 мин</td> </tr> <tr> <td>Ремонт резинового вала</td> <td>490</td> <td>30-45 мин</td> </tr> <tr> <td>Ремонт термоплёнки</td> <td>690</td> <td>30-45 мин</td> </tr> <tr> <td>Ремонт узла закрепления</td> <td>3490</td> <td>2 ч</td> </tr> <tr> <td>Ремонт узлов допоборудования</td> <td>3490</td> <td>2 ч</td> </tr> <tr> <td>Ремонт шестерни редуктора</td> <td>1190</td> <td>45-60 мин</td> </tr> <tr> <td>Переборка картриджа с барабаном</td> <td>1390</td> <td>1-1,5 ч</td> </tr> <tr> <td>Ремонт блока лазера</td> <td>1190</td> <td>45-60 мин</td> </tr> <tr> <td>Ремонт механических узлов</td> <td>890</td> <td>30-45 мин</td> </tr> <tr> <td>Ремонт платы питания</td> <td>2490</td> <td>1,5 ч</td> </tr> <tr> <td>Ремонт платы управления</td> <td>1390</td> <td>1-1,5 ч</td> </tr> <tr> <td>Техническое обслуживание узлов</td> <td>1890</td> <td>1-1,5 ч</td> </tr> </tbody> </table>',
        '<p>Наличие и цены на комплектующие узнавайте по телефону горячей линии.</p>',
        '490',
   ),

   'printers' => array(
        '<table class="priceTable"> <tbody> <tr> <td>Название услуги</td> <td>Сроки&nbsp;ремонта</td> <td>Цена, р.</td> </tr> <tr> <td>Ремонт деталей в узле формирования изображения</td> <td>2390</td> <td>1,5 ч</td> </tr> <tr> <td>Ремонт деталей узла переноса изображения</td> <td>1290</td> <td>50-60 мин</td> </tr> <tr> <td>Ремонт деталей узла сканирования</td> <td>3190</td> <td>1,5-2 ч</td> </tr> <tr> <td>Ремонт деталей узла транспортировки</td> <td>1390</td> <td>1-1,5 ч</td> </tr> <tr> <td>Ремонт детали узла подачи</td> <td>1290</td> <td>50-60 мин</td> </tr> <tr> <td>Ремонт резинового вала</td> <td>490</td> <td>30-45 мин</td> </tr> <tr> <td>Ремонт термоплёнки</td> <td>690</td> <td>30-45 мин</td> </tr> <tr> <td>Ремонт узла закрепления</td> <td>3490</td> <td>2 ч</td> </tr> <tr> <td>Ремонт узлов допоборудования</td> <td>3490</td> <td>2 ч</td> </tr> <tr> <td>Ремонт шестерни редуктора</td> <td>1190</td> <td>45-60 мин</td> </tr> <tr> <td>Переборка картриджа с барабаном</td> <td>1390</td> <td>1-1,5 ч</td> </tr> <tr> <td>Ремонт блока лазера</td> <td>1190</td> <td>45-60 мин</td> </tr> <tr> <td>Ремонт механических узлов</td> <td>890</td> <td>30-45 мин</td> </tr> <tr> <td>Ремонт платы питания</td> <td>2490</td> <td>1,5 ч</td> </tr> <tr> <td>Ремонт платы управления</td> <td>1390</td> <td>1-1,5 ч</td> </tr> <tr> <td>Техническое обслуживание узлов</td> <td>1890</td> <td>1-1,5 ч</td> </tr> </tbody> </table>',
        '<p>Наличие и цены на комплектующие узнавайте по телефону горячей линии.</p>',
        '490',
   ),

   'desctops' => array(
        '<table class="priceTable"> <tbody> <tr> <td>Название услуги</td> <td>Сроки&nbsp;ремонта</td> <td>Цена, р.</td> </tr> <tr> <td>Замена матрицы ноутбука</td> <td>30 мин</td> <td>300</td> </tr> <tr> <td>Ремонт разъема ЗУ</td> <td>30 мин</td> <td>1190</td> </tr> <tr> <td>Ремонт HDMI, USB и других разъемов</td> <td>30-45 мин</td> <td>1490</td> </tr> <tr> <td>Чистка интерфейсов и системы охлаждения</td> <td>30-60 мин</td> <td>1390</td> </tr> <tr> <td>Удаление жидкости с поверхности платы</td> <td>1-2 ч</td> <td>1290</td> </tr> <tr> <td>Ремонт разъемов материнской платы</td> <td>30-40 мин</td> <td>790</td> </tr> <tr> <td>Замена видеочипа,чипа северного или южного моста</td> <td>2-3 ч</td> <td>2590</td> </tr> <tr> <td>Замена материнской платы ноутбука</td> <td>1-3 ч</td> <td>1190</td> </tr> <tr> <td>Замена модуля WiFi</td> <td>30 мин</td> <td>290</td> </tr> <tr> <td>Замена HDD/SSD</td> <td>30 мин</td> <td>0&nbsp;</td> </tr> <tr> <td>Замена модулей ОЗУ ноутбука</td> <td>15&nbsp;мин</td> <td>0</td> </tr> <tr> <td>Замена петель крепления</td> <td>1-2 ч</td> <td>1240</td> </tr> <tr> <td>Настройка и перепрошивка Bios</td> <td>1-2 ч</td> <td>1190</td> </tr> <tr> <td>Восстановление контактных элементов чипов, разъемов и портов, за ед.</td> <td>30-60 мин</td> <td>390</td> </tr> <tr> <td>Ремонт цепи питания ноутбука</td> <td>от 3 ч</td> <td>2690</td> </tr> <tr> <td>Восстановление корпуса ноутбука</td> <td>2 ч</td> <td>2190</td> </tr> <tr> <td>Установка и настройка программного обеспечения</td> <td>от 30 мин</td> <td>от 790</td> </tr> </tbody> </table>',
        '<table class="priceTable"> <tbody> <tr> <td>Название&nbsp;комплектующей</td> <td>Наличие</td> <td>Цена, р.</td> </tr> <tr> <td>Твердый накопитель HDD</td> <td>есть в наличии</td> <td>от 2490</td> </tr> <tr> <td>Матрица ноутбука</td> <td>в наличии / на заказ</td> <td>2490 – 4490</td> </tr> <tr> <td>Вентилятор охлаждения</td> <td>есть в наличии</td> <td>1190</td> </tr> <tr> <td>Материнская плата ноутбука</td> <td>на складе / на заказ</td> <td>от 4490</td> </tr> <tr> <td>Мультиконтроллер платы</td> <td>в наличии / на&nbsp;складе</td> <td>790 - 1490</td> </tr> <tr> <td>Модуль ОЗУ</td> <td>есть в наличии</td> <td>от 1390</td> </tr> <tr> <td>Разъемы HDMI, USB и другие, за ед.</td> <td>в наличии / на заказ</td> <td>от 490</td> </tr> <tr> <td>Разъем питания ЗУ</td> <td>есть в наличии</td> <td>от 340</td> </tr> <tr> <td>Видеочип, чип южного или северного моста</td> <td>в наличии / на заказ</td> <td>1190 – 2490</td> </tr> </tbody> </table>',
        '290',
   ),

   'servers' => array(
        '<table class="priceTable"> <tbody> <tr> <td>Название услуги</td> <td>Сроки&nbsp;ремонта</td> <td>Цена, р.</td> </tr> <tr> <td>Замена матрицы ноутбука</td> <td>30 мин</td> <td>300</td> </tr> <tr> <td>Ремонт разъема ЗУ</td> <td>30 мин</td> <td>1190</td> </tr> <tr> <td>Ремонт HDMI, USB и других разъемов</td> <td>30-45 мин</td> <td>1490</td> </tr> <tr> <td>Чистка интерфейсов и системы охлаждения</td> <td>30-60 мин</td> <td>1390</td> </tr> <tr> <td>Удаление жидкости с поверхности платы</td> <td>1-2 ч</td> <td>1290</td> </tr> <tr> <td>Ремонт разъемов материнской платы</td> <td>30-40 мин</td> <td>790</td> </tr> <tr> <td>Замена видеочипа,чипа северного или южного моста</td> <td>2-3 ч</td> <td>2590</td> </tr> <tr> <td>Замена материнской платы ноутбука</td> <td>1-3 ч</td> <td>1190</td> </tr> <tr> <td>Замена модуля WiFi</td> <td>30 мин</td> <td>290</td> </tr> <tr> <td>Замена HDD/SSD</td> <td>30 мин</td> <td>0&nbsp;</td> </tr> <tr> <td>Замена модулей ОЗУ ноутбука</td> <td>15&nbsp;мин</td> <td>0</td> </tr> <tr> <td>Замена петель крепления</td> <td>1-2 ч</td> <td>1240</td> </tr> <tr> <td>Настройка и перепрошивка Bios</td> <td>1-2 ч</td> <td>1190</td> </tr> <tr> <td>Восстановление контактных элементов чипов, разъемов и портов, за ед.</td> <td>30-60 мин</td> <td>390</td> </tr> <tr> <td>Ремонт цепи питания ноутбука</td> <td>от 3 ч</td> <td>2690</td> </tr> <tr> <td>Восстановление корпуса ноутбука</td> <td>2 ч</td> <td>2190</td> </tr> <tr> <td>Установка и настройка программного обеспечения</td> <td>от 30 мин</td> <td>от 790</td> </tr> </tbody> </table>',
        '<table class="priceTable"> <tbody> <tr> <td>Название&nbsp;комплектующей</td> <td>Наличие</td> <td>Цена, р.</td> </tr> <tr> <td>Твердый накопитель HDD</td> <td>есть в наличии</td> <td>от 2490</td> </tr> <tr> <td>Матрица ноутбука</td> <td>в наличии / на заказ</td> <td>2490 – 4490</td> </tr> <tr> <td>Вентилятор охлаждения</td> <td>есть в наличии</td> <td>1190</td> </tr> <tr> <td>Материнская плата ноутбука</td> <td>на складе / на заказ</td> <td>от 4490</td> </tr> <tr> <td>Мультиконтроллер платы</td> <td>в наличии / на&nbsp;складе</td> <td>790 - 1490</td> </tr> <tr> <td>Модуль ОЗУ</td> <td>есть в наличии</td> <td>от 1390</td> </tr> <tr> <td>Разъемы HDMI, USB и другие, за ед.</td> <td>в наличии / на заказ</td> <td>от 490</td> </tr> <tr> <td>Разъем питания ЗУ</td> <td>есть в наличии</td> <td>от 340</td> </tr> <tr> <td>Видеочип, чип южного или северного моста</td> <td>в наличии / на заказ</td> <td>1190 – 2490</td> </tr> </tbody> </table>',
        '290',
   ),

   'consoles' => array(
        '<table class="priceTable"> <tbody> <tr> <td>Название услуги</td> <td>Сроки&nbsp;ремонта</td> <td>Цена, р.</td> </tr> <tr> <td>Замена блока питания консоли</td> <td>1-2 ч</td> <td>1490</td> </tr> <tr> <td>Ремонт привода Bluray&nbsp;устройства</td> <td>30-60 мин</td> <td>1490</td> </tr> <tr> <td>Замена твердого накопителя HDD</td> <td>30 мин</td> <td>1190</td> </tr> <tr> <td>Чистка&nbsp;системы охлаждения</td> <td>45-60&nbsp;м</td> <td>1190</td> </tr> <tr> <td>Замена материнской платы</td> <td>2-3 ч</td> <td>1990</td> </tr> <tr> <td>Замена видеочипа, чипа северного или южного моста</td> <td>1-3 ч</td> <td>1490</td> </tr> <tr> <td>Ремонт&nbsp;разъема HDMI</td> <td>30-45 мин</td> <td>1190</td> </tr> <tr> <td>Обновление&nbsp;программного обеспечения</td> <td>40 мин</td> <td>790</td> </tr> </tbody> </table>',
        '<p>Наличие и цены на комплектующие узнавайте по телефону горячей линии.</p>',
        '790',
   ),

   'photo_video' => array(
        '<table class="priceTable"> <tbody> <tr> <td>Название услуги</td> <td>Сроки&nbsp;ремонта</td> <td>Цена, р.</td> </tr> <tr> <td><span>Замена дисплея видеокамеры</span></td> <td>50-60 мин</td> <td>800</td> </tr> <tr> <td><span>Ремонт объектива видеокамеры</span></td> <td>2-3 ч</td> <td>2500-4500</td> </tr> <tr> <td><span>Ремонт механизмов видеокамеры</span></td> <td>от 30 мин</td> <td>от 1300</td> </tr> <tr> <td>Ремонт ЛПМ</td> <td>2 ч</td> <td>1100-2400</td> </tr> <tr> <td>Ремонт контроллера</td> <td>от 1,5 ч</td> <td>1900-2600</td> </tr> <tr> <td>Ремонт привода DVD</td> <td>1-2 ч</td> <td>2600</td> </tr> <tr> <td>Ремонт платы питания</td> <td>2 ч</td> <td>2700</td> </tr> <tr> <td>Ремонт цепи питания</td> <td>от 1,5 ч</td> <td>от 900</td> </tr> <tr> <td>Замена ПЗС матрицы</td> <td>1 ч</td> <td>1100</td> </tr> </tbody> </table>',
        '<p>Наличие и цены на комплектующие узнавайте по телефону горячей линии.</p>',
        '800',
   ),

   'tv' => array(
        '<table class="priceTable"> <tbody> <tr> <td>Название услуги</td> <td>Сроки&nbsp;ремонта</td> <td>Цена, р.</td> </tr> <tr> <td>Ремонт процессора, ремонт контроллера</td> <td>1-2 часа</td> <td>1590</td> </tr> <tr> <td>Ремонт&nbsp;ТВ тюнера</td> <td>2-3 часа</td> <td>2400</td> </tr> <tr> <td>Ремонт матрицы</td> <td>1-2&nbsp;часа</td> <td>1690</td> </tr> <tr> <td>Ремонт разъема HDMI, аудио, USB</td> <td>30-45 минут</td> <td>1790</td> </tr> <tr> <td>Замена блока питания</td> <td>2 часа</td> <td>2400</td> </tr> <tr> <td>Замена цепи питания</td> <td>3 часа</td> <td>3400</td> </tr> <tr> <td>Чистка материнской платы от жидкости</td> <td>1-2 часа</td> <td>1190</td> </tr> <tr> <td>Ремонт материнской платы</td> <td>1-3 часа</td> <td>1190</td> </tr> <tr> <td>Ремонт разъема зарядного устройства</td> <td>45-60 мин</td> <td>1590</td> </tr> <tr> <td>Замена блока управления</td> <td>45-60 минут</td> <td>1090</td> </tr> <tr> <td>Ремонт батареи&nbsp;памяти</td> <td>30-45 минут</td> <td>450</td> </tr> <tr> <td>Замена подсветки</td> <td>1-2 часа</td> <td>1790</td> </tr> <tr> <td>Замена&nbsp;Wi Fi</td> <td>1-2 часа</td> <td>2400</td> </tr> <tr> <td>Ремонт&nbsp;лампы подсветки</td> <td>30-60 минут</td> <td>1390</td> </tr> <tr> <td>Замена ТВ тюнера</td> <td>1 час</td> <td>1250</td> </tr> <tr> <td>Прошивка&nbsp;блока управления</td> <td>1 час</td> <td>1090</td> </tr> <tr> <td>Прошивка&nbsp;ПО</td> <td>45-60 мин</td> <td>1190</td> </tr> <tr> <td>Восстановление контактов BGA, разъемов, портов (за 1 шт.)</td> <td>30-60 минут</td> <td>390</td> </tr> </tbody> </table>',
        '<p>Наличие и цены на комплектующие узнавайте по телефону горячей линии.</p>',
        '390',
   ),

   'laptop' => array(
        '<table class="priceTable"><tbody><tr><td>Название услуги</td><td>Сроки&nbsp;ремонта</td><td>Цена, р.</td></tr><tr><td>Замена матрицы ноутбука</td><td>30 мин</td><td>300</td></tr><tr><td>Ремонт разъема ЗУ</td><td>30 мин</td><td>1190</td></tr><tr><td>Ремонт HDMI, USB и других разъемов</td><td>30-45 мин</td><td>1490</td></tr><tr><td>Чистка интерфейсов и системы охлаждения</td><td>30-60 мин</td><td>1390</td></tr><tr><td>Удаление жидкости с поверхности платы</td><td>1-2 ч</td><td>1290</td></tr><tr><td>Ремонт разъемов материнской платы</td><td>30-40 мин</td><td>790</td></tr><tr><td>Замена видеочипа,чипа северного или южного моста</td><td>2-3 ч</td><td>2590</td></tr> <tr><td>Замена материнской платы ноутбука</td><td>1-3 ч</td><td>1190</td></tr><tr><td>Замена модуля WiFi</td><td>30 мин</td><td>290</td></tr><tr><td>Замена HDD/SSD</td><td>30 мин</td><td>0&nbsp;</td></tr><tr><td>Замена модулей ОЗУ ноутбука</td><td>15&nbsp;мин</td><td>0</td></tr><tr> <td>Замена петель крепления</td><td>1-2 ч</td><td>1240</td></tr><tr><td>Настройка и перепрошивка Bios</td><td>1-2 ч</td><td>1190</td></tr><tr><td>Восстановление контактных элементов чипов, разъемов и портов, за ед.</td><td>30-60 мин</td><td>390</td> </tr><tr><td>Ремонт цепи питания ноутбука</td><td>от 3 ч</td><td>2690</td></tr><tr><td>Восстановление корпуса ноутбука</td><td>2 ч</td><td>2190</td></tr><tr><td>Установка и настройка программного обеспечения</td><td>от 30 мин</td><td>от 790</td></tr></tbody></table>',
        '<table class="priceTable"><tbody><tr><td>Название&nbsp;комплектующей</td><td>Наличие</td><td>Цена, р.</td></tr><tr><td>Твердый накопитель HDD</td><td>есть в наличии</td><td>от 2490</td></tr><tr><td>Матрица ноутбука</td><td>в наличии / на заказ</td><td>2490 – 4490</td></tr><tr><td>Вентилятор охлаждения</td><td>есть в наличии</td><td>1190</td></tr><tr><td>Материнская плата ноутбука</td><td>на складе / на заказ</td><td>от 4490</td></tr><tr><td>Мультиконтроллер платы</td><td>в наличии / на&nbsp;складе</td><td>790 - 1490</td></tr><tr><td>Модуль ОЗУ</td><td>есть в наличии</td><td>от 1390</td></tr><tr><td>Разъемы HDMI, USB и другие, за ед.</td><td>в наличии / на заказ</td><td>от 490</td></tr><tr><td>Разъем питания ЗУ</td><td>есть в наличии</td><td>от 340</td></tr><tr><td>Видеочип, чип южного или северного моста</td><td>в наличии / на заказ</td><td>1190 – 2490</td></tr></tbody></table>',
        '290',
   ),

   'tablets' => array(
        '<table class="priceTable"><tbody><tr><td>Название услуги</td><td>Сроки&nbsp;ремонта</td><td>Цена, р.</td></tr><tr><td>Замена&nbsp;батареи</td><td>30 мин</td><td>590</td></tr><tr><td>Замена&nbsp;экрана планшета</td><td>1-2 ч</td><td>1490</td></tr><tr><td>Замена задней крышки</td><td>30 мин</td><td>490</td></tr><tr><td>Замена модуля камеры</td><td>45 мин</td><td>790</td></tr><tr><td>Замена микрофона</td><td>45&nbsp;мин</td><td>790</td></tr><tr><td>Замена динамика планшета</td><td>30 мин</td><td>590</td></tr><tr><td>Замена вибромотора</td><td>40 мин</td><td>590</td></tr><tr><td>Замена кнопки включения устройства</td><td>40 мин</td><td>790</td></tr><tr><td>Замена микросхемы управления</td><td>2-3 ч</td><td>3190</td></tr><tr><td>Ремонт цепи питания планшета</td><td>2 ч</td><td>2490</td></tr><tr><td>Замена шлейфа</td><td>40 мин</td><td>690</td></tr><tr><td>Замена разъема Micro-Usb</td><td>45&nbsp;мин</td><td>790</td></tr><tr><td>Замена разъема Audio</td><td>40-60 мин</td><td>690</td></tr><tr><td>Восстановление дорожек платы или шлейфа, за ед.</td><td>30 мин</td><td>390</td></tr><tr><td>Чистка аппарата от жидкости</td><td>1-2 ч</td><td>1690</td></tr><tr><td>Замена flash-лотка</td><td>30-60 мин</td><td>890</td></tr><tr><td>Замена sim-лотка</td><td>45-60&nbsp;мин</td><td>1190</td></tr><tr><td>Настройка программного обеспечения</td><td>от 30 мин</td><td>от 590</td></tr><tr><td>Перепрошивка без сохранения информации</td><td>30 мин</td><td>590</td></tr><tr><td>Перепрошивка с сохранением информации</td><td>2-3 ч</td><td>2490</td></tr></tbody></table>',
        '<table class="priceTable"><tbody><tr><td>Название комплектующей</td><td>Наличие</td><td>Цена, р.</td></tr><tr><td>Экран/дисплей (модуль)</td><td>в наличии / на заказ</td><td>3490 – 6490</td></tr><tr><td>Материнская плата планшета</td><td>в наличии / на заказ</td><td>3490-8490</td></tr><tr><td>Микросхема управления</td><td>в наличии / на&nbsp;складе</td><td>590-2490</td></tr><tr><td>Мультиконтроллер</td><td>в наличии / на&nbsp;складе</td><td>1190</td></tr><tr><td>Кнопка включения аппарта</td><td>есть в наличии</td><td>240</td></tr><tr><td>Задняя крышка</td><td>в наличии / на заказ</td><td>1190</td></tr><tr><td>Динамик планшета</td><td>есть в наличии</td><td>240</td></tr><tr><td>Микрофон планшета</td><td>есть в наличии</td><td>340</td></tr><tr><td>Разъем Audio</td><td>есть в наличии</td><td>290</td></tr><tr><td>Разъем Micro-Usb</td><td>есть в наличии</td><td>340</td></tr></tbody></table>',
        '390',
   ),

);

$gadget = $add_device_type[$this->_datas['arg_url']];
$accord_image = $this->_datas['accord_image'];
$name = tools::mb_ucfirst($gadget['type']);
?>

    <section class="fixed content-wrapper">
            <div class="content-block">

                <section class="crumbs">
                    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/"><meta itemprop="title" content="Главная"/><amp-img src="/img/home.png" alt="home"/></a></span>
                    <span> / </span>
                    <span><?=tools::mb_ucfirst($gadget['type_m'], 'utf-8', false)?></span>
                </section>

                <div class="content-block__top">

                    <div class="info-block remont-block">

                        <h1><?=$this->_ret['h1']?></h1>

                        <amp-img src="/bitrix/templates/centre/img/site/large/<?=$accord_image[$gadget['type']].'-'.mb_strtolower($this->_datas['marka']['name']).'.png'?>" alt="<?=$name?>" title="<?=$name?>">

                        <div class="block-wrp">
                            <?php
                              include_once "text/type.php";
                              $genText = false;
                              if ($this->_datas['region']['name'] == "Москва" && isset($typeText) && is_array($typeText)) {
                                if (isset($typeText[$gadget['type_m']])) {
                                  $text = $typeText[$gadget['type_m']];
                                  $genText = true;
                                  echo '<p>'.$text['desc'].'</p>';
                                }
                              }
                              if (!$genText) {
                            ?>
                            <p><?=tools::mb_ucfirst($gadget['type_m'], 'utf-8', false)?> <?=$ru_marka?> зарекомендовали себя с лучшей стороны как для решения бизнес-задач, так и для повседневных потребностей пользователей <?=$marka?>. <?=tools::mb_ucfirst($gadget['type_m'], 'utf-8', false)?> <?=$marka?> - мощные и надежные,
                                    но, к сожалению, случается, что из строя выходят даже они.</p>
                            <p>Если это случилось и с вашим <?=$ru_marka?> – не отчаивайтесь и звоните в <?=$servicename?>. Мы профессионалы и знаем, как все исправить.</p>
                            <?php } ?>
                            <span class="price">от <span><?=$info_block[$this->_datas['arg_url']][2]?></span> р.</span>
                            <a href="/order/"  class="btn btn--fill">Записаться на ремонт</a>


                        </div>

                        <div class="clear"></div>
                    </div>

                </div>

                <div class="divider divider--three"></div>

                <div class="content-block__bottom">

                  <?php
                    if ($this->_datas['region']['name'] == "Москва" && isset($typeText) && is_array($typeText)) {
                      if (isset($typeText[$gadget['type_m']])) {
                        $text = $typeText[$gadget['type_m']];
                        if (isset($text['text'][0])) {
                          echo '<div class = "info-block">';
                          renderTypeText($text['text'][0]);
                          echo '</div>';
                        }
                      }
                    }
                  ?>

                    <div class="info-block">
                        <span class="h2">Услуги по обслуживанию&nbsp;<?=$gadget['type_rm']?> <?=$ru_marka?></span>
                        <?=$info_block[$this->_datas['arg_url']][0]?>
                        <span class="h2">Цены на комплектующие&nbsp;<?=$gadget['type_rm']?>&nbsp;<?=$marka?></span>
                        <?=$info_block[$this->_datas['arg_url']][1]?>
                    </div>

                    <?php
                      if ($this->_datas['region']['name'] == "Москва" && isset($typeText) && is_array($typeText)) {
                        if (isset($typeText[$gadget['type_m']])) {
                          $text = $typeText[$gadget['type_m']];
                          if (isset($text['text'][1])) {
                            echo '<div class = "info-block">';
                            renderTypeText($text['text'][1]);
                            echo '</div>';
                          }
                        }
                      }
                    ?>
                </div>
        </div>

        <? include __DIR__.'/aside2.php'; ?>
    </section>
<div class="clear"></div>
