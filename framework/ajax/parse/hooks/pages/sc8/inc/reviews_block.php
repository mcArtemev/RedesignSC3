<?php
use framework\tools;
use framework\rand_it;
   $reviewsRaw = require __DIR__ . '/../data/reviews.php';

   $reviews = array_slice($reviewsRaw, 0, 5);

    srand(tools::gen_feed($this->_datas['site_name']));
    $procent = rand(96, 99);
    $personas = rand(15, 25);
    $devices = rand(1300, 1800);
    $number = rand(7, 12);
?>
<h2>Нам доверяют!</h2>
<p>Несколько отзывов от наших клиентов</p>
<div class="row">
    <div class="col-sm-12">
        <div id="feedbackCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
                <?php foreach ($reviews as $k => $review) :;?>
                    <div class="item carousel-item feedback-item <?= $k === 0 ? 'active' : '';?>">
                        <p class="author">
                            <?= $review['name']; ?> - <?= $review['date']; ?>
                        </p>
                        <p class="fbText">
                            <?= mb_substr($review['review'], 0, 400); ?>
                            <?php if(strlen($review['review']) > 400) :; ?>
                                ...
                            <?php endif; ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
            <ol class="carousel-indicators">
                <?php foreach(range(0, count($reviews))  as $item) :;?>
                    <?php if($item > 4) break ; ?>
                    <li data-target="#feedbackCarousel" data-slide-to="<?= $item; ?>" <?= $item == 0 ? 'class="active"' : '' ;?>></li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
</div>
<div class="row">
    <?

    $array = array();
    $array[] = array($number, tools::declOfNum($number, array('Год на рынке', 'Года на рынке', 'Лет на рынке'), false, false));
    $array[] = array($procent.'%', tools::declOfNum($procent, array('Довольный клиент', 'Довольных клиента', 'Довольных клиентов'), false, false));
    $array[] = array($personas,tools::declOfNum($personas, array('Сотрудник', 'Сотрудника', 'Сотрудников'), false, false));
    $array[] = array(tools::format_price($devices, 'СЦ-8'), tools::declOfNum($devices, array('Выполненный заказ', 'Выполненных заказа', 'Выполненных заказов'), false, false));

    $array = rand_it::randMas($array, 4, '', $this->_datas['feed']);

    foreach ($array as $ar)
    {
        echo '<div class="col-sm-3 number-col text-center">
          <p class="number">'.
            $ar[0].
            '</p>
          <p>'.$ar[1].'</p>
        </div>';
    }
    ?>
</div>