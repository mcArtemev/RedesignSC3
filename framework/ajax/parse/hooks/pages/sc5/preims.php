<?
 use framework\ajax\parse\hooks\sc;

$h2 = array();

$feed = $this->_datas['feed'];
srand($feed);
$choose = rand(0, 9);

switch ($choose)
{
    case 0:
        $h2[] = array('Почему можно');
        $h2[] = array('смело обращаться в', 'обратиться в');
        $h2[] = array('сервисный центр Remont Centre', 'сервис центр Remont Centre', 'мастерскую Remont Centre',
            'наш сервисный центр', 'наш сервис центр', 'нашу мастерскую');
    break;
    case 1:
        $h2[] = array('4 причины, почему можно');
        $h2[] = array('смело обращаться в', 'обратиться в');
        $h2[] = array('сервисный центр Remont Centre', 'сервис центр Remont Centre', 'мастерскую Remont Centre',
            'наш сервисный центр', 'наш сервис центр', 'нашу мастерскую');
    break;
    case 2:
        $h2[] = array('Основные условия работы', 'Основные правила работы', 'Основные условия ремонта',
                'Основные правила ремонта');
        $h2[] = array('сервисного центра Remont Centre', 'сервис центра Remont Centre', 'мастерской Remont Centre',
                'нашего сервисного центра', 'нашего сервис центра', 'нашей мастерской');
        $h2[] = array('', $this->_datas['marka']['name'], $this->_datas['marka']['ru_name']);
    break;
    case 3:
        $h2[] = array('Наши правила работы', 'Наши условия ремонта', 'Наши правила работы', 'Наши условия ремонта');
        $h2[] = array('сервисного центра Remont Centre', 'сервис центра Remont Centre', 'мастерской Remont Centre');
        $h2[] = array('', $this->_datas['marka']['name'], $this->_datas['marka']['ru_name']);
    break;
    case 4:
        $h2[] = array('Преимущества ремонта в', 'Преимущества проведения ремонта в', 'Преимущества ремонта техники в');
        $h2[] = array('сервисном центре Remont Centre', 'сервис центре Remont Centre', 'мастерской Remont Centre',
                    'нашем сервисном центре',  'нашем сервис центре', 'нашей мастерской');
        $h2[] = array('', $this->_datas['marka']['name'], $this->_datas['marka']['ru_name']);
    break;
    case 5:
         $h2[] = array('Испытайте преимущества работы с', 'Испытайте преимущества сотрудничества с');
         $h2[] = array('сервисным центром Remont Centre', 'сервис центром Remont Centre', 'мастерской Remont Centre',
            'нашим сервисным центром', 'нашим сервис центром', 'нашей мастерской');
         $h2[] = array('', $this->_datas['marka']['name'], $this->_datas['marka']['ru_name']);
    break;
    case 6:
        $h2[] = array('Испытайте преимущества ремонта в');
        $h2[] = array('сервисном центре Remont Centre', 'сервис центре Remont Centre', 'мастерской Remont Centre',
                'нашем сервисном центре', 'нашем сервис центре', 'нашей мастерской');
        $h2[] = array('', $this->_datas['marka']['name'], $this->_datas['marka']['ru_name']);
    break;
    case 7:
        $h2[] = array('Выгодные условия сотрудничества с', 'Прозрачные условия сотрудничества с', 'Понятные условия сотрудничества с');
        $h2[] = array('сервисным центром Remont Centre', 'сервис центром Remont Centre', 'мастерской Remont Centre');
        $h2[] = array('', $this->_datas['marka']['name'], $this->_datas['marka']['ru_name']);
    break;
    case 8:
        $h2[] = array('Прозрачные условия ремонта в', 'Понятные условия ремонта в', 'Выгодные условия ремонта в');
        $h2[] = array('сервисном центре Remont Centre', 'сервис центре Remont Centre', 'мастерской Remont Centre');
        $h2[] = array('', $this->_datas['marka']['name'], $this->_datas['marka']['ru_name']);
    break;
    case 9:
        $h2[] = array('Быть клиентом');
        $h2[] = array('сервисного центра Remont Centre', 'сервис центра Remont Centre', 'мастерской Remont Centre',
            'нашего сервисного центра', 'нашего сервис центра', 'нашей мастерской');
        $h2[] = array('', $this->_datas['marka']['name'], $this->_datas['marka']['ru_name']);
        $h2[] = array('выгодно');
    break;
}

?>


            <section class="<?php echo isset($section_class) ? $section_class : 'greybg'?>">
                <div class="container">
                    <h2 class="title"><?=sc::_createTree($h2, $feed);?></h2>

                    <?php
                        $genText = false;
                        if (isset($indexText) && is_array($indexText)) {
                          if (isset($indexText[$marka_lower])) {
                              renderIndexText($indexText[$marka_lower][1]);
                            $genText = true;
                          }
                        }
                        echo '<div class="row reason">';
                         echo $this->_datas['preims'];
                        echo '</div>';

                        if ('/'=== $this->_datas['arg_url']) {

                            // Text: Нет времени отвести компьютер?
                                $genText = false;
                                if (isset($indexText) && is_array($indexText)) {
                                    if (isset($indexText[$marka_lower])) {
                                        renderIndexText($indexText[$marka_lower][2], 'displaySmaller');
                                        $genText = true;
                                    }
                                }
                                if (!$genText)
                                    echo '<p class="displaySmaller">'.sc::_createTree($h3, $feed).'</p>';
                        }
                    ?>
                </div>
            </section>
