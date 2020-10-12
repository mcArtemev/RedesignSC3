<?php
use framework\tools;
use framework\ajax\parse\hooks\pages\sc6\data\src\helpers6;

$marka = $this->_datas['marka']['name'];  // SONY

$promo = [
	[
		'title' => 'Скидка 5%',
		'subtitle' => 'на ремонт смартфонов',
		'img' => 'img-5.jpg'
	],
	[
		'title' => 'Подарки',
		'subtitle' => 'постоянным клиентам',
		'img' => 'img-6.jpg',
	],
	[
		'title' => 'Акция',
		'subtitle' => 'приведи друга и получи скидку 5%',
		'img' => 'img-7.jpg',
	],
	[
		'title' => 'Скидка 5%',
		'subtitle' => 'при повторном обращении',
		'img' => 'img-8.jpg',
	],
	// [
	// 	'title' => 'Подарок',
	// 	'subtitle' => 'Защитное стекло при ремонте iPhone',
	// 	'img' => 'promo/1.jpg',
	// ],
	[
		'title' => 'Скидка 10%',
		'subtitle' => 'многодетным семьям',
		'img' => 'promo/2.jpg',
	],
	[
		'title' => 'Скидка 15%',
		'subtitle' => 'при комплексном ремонте техники',
		'img' => 'promo/3.jpg',
	],
	[
		'title' => 'Акция',
		'subtitle' => 'Скидка на чистку техники весной',
		'img' => 'promo/4.jpg',
	],
	[
		'title' => 'Акция',
		'subtitle' => 'Замена двух экранов по цене одного',
		'img' => 'promo/5.jpg',
	],
	[
		'title' => 'Скидка 5%',
		'subtitle' => 'При обращении до 12 дня в будние дни',
		'img' => 'promo/6.jpg',
	],
	[
		'title' => 'Скидка 10%',
		'subtitle' => 'Для пенсионеров',
		'img' => 'promo/7.jpg',
	],
	[
		'title' => 'Скидка 10%',
		'subtitle' => 'Каждому десятому клиенту нашего сервиса',
		'img' => 'promo/8.jpg',
	],
	[
		'title' => 'Акция',
		'subtitle' => 'Рассрочка на ремонт техники',
		'img' => 'promo/9.jpg',
	],
	[
		'title' => 'Скидка 10%',
		'subtitle' => 'Для всех студентов, предъявивших студенческий билет',
		'img' => 'promo/10.jpg',
	],
	[
		'title' => 'Акция',
		'subtitle' => 'Антивирус в подарок',
		'img' => 'promo/11.jpg',
	],
]	;

$y = date('Y');
$m = date('n');

helpers6::shuffle($promo, 0, $this->_datas['site_id']+$y+$m);

?>


<?php helpers6::breadcrumbs([
	['/', 'Главная'],
  [0, 'Акции'],
]); ?>
<main>
    <section class="section-shares">
        <div class="container">
            <div class="part_header">
                <h1 class="part-title part-title__center part-title__bold" style="font-size: 30px">Актуальные акции и скидки на услуги</h1>
            </div>
            <div class="shares-inner">
							<?php foreach (array_slice($promo, 0, 4) as $pr) { ?>
                <div class="shares-wrap">
                    <img src="/_mod_files/_img/<?=$pr['img']?>" alt="">
                    <div class="shares-wrap__inner">
                        <span><?=$pr['title']?></span>
                        <p><?=$pr['subtitle']?></p>
                    </div>
                </div>
							<?php } ?>
            </div>
        </div>
    </section>
</main>
