<?php
use framework\tools;
use framework\ajax\parse\hooks\pages\sc6\data\src\helpers6;

$marka = $this->_datas['marka']['name'];  // SONY

$brand = mb_strtolower($marka);
$city = $this->_datas['region']['name'];
$types = array_column($this->_datas['all_devices'], 'type');

$feed = $this->_datas['feed'];

$reviews = json_decode(file_get_contents(__DIR__.'/data/text/reviews.json'), true);

$date = time();
$revs = [];

foreach ($reviews as $rev) {
	if ($rev['site_id'] == $this->_datas['site_id'] && (int)$rev['date'] < $date) {
		$revs[] = $rev;
	}
}


?>

<?php helpers6::breadcrumbs([
	['/', 'Главная'],
  [0, 'Отзывы'],
]); ?>
<main>
    <section class="block-comment">
        <div class="container">
            <div class="part_header">
                <h1 class="part-title part-title__center part-title__bold" style="font-size: 30px">Отзывы клиентов о работе сервисного центра</h1>
            </div>
            <noindex>

                <button class = "btn btn-blue" data-toggle="modal" data-target="#feedbackModal" >
                    <i class="fa fa-pencil" aria-hidden="true"></i> Оставить отзыв
                </button>

								<div class = "listReviews">
								<?php if (count($revs)) { ?>
								<?php foreach ($revs as $rev) { ?>
                        <div class="comment-item">
                            <span class="comment-item__name"><?=explode(',',$rev['name'])[0]?></span>
                            <p class="comment-item__txt"><?=$rev['text']?></p>
														<?php if (isset($rev['reason'])) { ?>
                            <span class="comment-item__reason">
															Причина обращения: <?=$rev['reason']?>
														</span>
														<?php } ?>
                        </div>
								<?php }
							} else {?>
								<p>Пока никто не оставлял отзыв. Будьте первым.</p>
							<?php } ?>
								</div>

            </noindex>
        </div>
    </section>
</main>
