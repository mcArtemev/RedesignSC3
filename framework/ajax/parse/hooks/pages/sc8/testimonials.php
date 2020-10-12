<?php

$reviews = array();
if (($handle = fopen(__DIR__ . "/data/reviews.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 4096, ';')) !== FALSE) {
		if ($data[0] != "Дата") {
			$reviews[] = [
				"time"   => strtotime($data[0]),
				"date"   => $data[0],
				"name"   => $data[1],
				"rate" 	 => $data[2],
				"review" => $data[3]
			];
		}
    }
    fclose($handle);
}

function sorta($a, $b) {
	if ($a['time'] < $b['time'])
		return 1;
}

usort($reviews, "sorta");


// pagination
$max_items = 5;
$pages = count($reviews) / $max_items;
$start_page = 1;

//var_dump(array_sum(array_column($reviews, 'rate')) / count($reviews));

?>
<header class="secondary main_block">
    <div class="container">
        <ul class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <a itemprop="name" href="/">Главная</a>
                <meta itemprop="position" content="1"/>
            </li>
            <li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <span itemprop="name">Отзывы наших клиентов</span>
                <meta itemprop="position" content="2"/>
            </li>
        </ul>
        <div class="row">
            <div class="col-sm-8 brand-top">
                <h1><?= $this->_ret['h1'] ?></h1>
                <!--<a href="/"><p class="back-home">Вернуться на главную страницу</p></a>-->
            </div>
            <div class="col-sm-4 text-right">
                <a href="#" class="btn btn-fb scroll-btn">Оставить отзыв</a>
            </div>
        </div>
    </div>
</header>

    <div class="main-content feedbacks">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">
                <div class="reviews active" data-page="<?= $start_page; ?>">
                    <?php foreach ($reviews as $rew_k => $review) :;?>
                    <div class="fb-card" itemscope itemtype="http://schema.org/Review">
                      <span itemprop="itemReviewed" itemscope itemscope itemtype="http://schema.org/Service">
                          <meta itemprop="serviceType" content="Ремонт техники" />
                      </span>
                        <div class="col-sm-2">
                            <p class="author" itemprop="author" itemscope itemtype="http://schema.org/Person">
                                    <span itemprop="name">
                                        <?= $review['name']; ?>
                                    </span>
                            </p>
                            <p class="date" itemprop="datePublished"
                               content="<?= implode('-', array_reverse(explode('.', $review['date']))); ?>"><?= $review['date']; ?></p>
                            <p class="rating" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
                                <span itemprop="ratingValue"><?= $review['rate']; ?></span>
                                <span itemprop="bestRating" content="5"></span>
                            </p>
                            <p class="stars">Общая оценка <br>
                                <?php foreach (range(0, 4) as $r) :;?>
                                    <?php if ($review['rate']) :;?>
                                        <span class="starY"></span>
                                    <?php else :;?>
                                        <span class="starN"></span>
                                    <?php endif;?>
                                    <?php --$review['rate']; ?>
                                <?php endforeach; ?>
                            </p>
                        </div>
                        <div class="col-sm-10">
                            <p class="fb-text" itemprop="description"><?= $review['review']; ?></p>
                        </div>
                    </div>
                    <?php if(($rew_k + 1) % $max_items === 0) :; ?>
                        </div><div class="reviews hidden" data-page="<?= ++$start_page; ?>">
                    <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 text-center">
<!--              <a href="#" class="prev"></a>-->
              <ul class="pagination">
                  <?php for ($i = 0; $i < $pages; $i++) :; ?>
                      <li><a href="#" <?= $i + 1 === 1 ? 'class="active"' : ''?> data-page="<?= $i + 1; ?>"><?= $i + 1; ?></a></li>
                  <?php endfor; ?>
              </ul>
<!--              <a href="#" class="next"></a>-->
            </div>
          </div>
        </div>
    </div>
    <? $this->_datas['block_form'] = 'leavefeedback'; ?>
