<?

use framework\tools;

$this->_datas['block_form'] = 'block';

$metrica = $this->_datas['metrica'];
$menu = $this->_datas['menu'];
$urlm = ($this->_datas['arg_url'] != '/') ? '/' . $this->_datas['arg_url'] . '/' : '/';
$analytics = $this->_datas['analytics'];
$local = $this->_datas['isLocal'];

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/custom/saapservice/img/favicon.ico" rel="shortcut icon">

    <title><?= $this->_ret['title'] ?></title>
    <meta name="description" content="<?= $this->_ret['description'] ?>"/>

	<!--<link href="/custom/saapservice/css/main.full.css" rel="stylesheet">-->
    <link href="/custom/saapservice/css/all.css" rel="stylesheet">
	<link href="/custom/saapservice/css/font-awesome.min.css" rel="stylesheet">
	<style>
		nav .top-nav .contacts i{
			font-size: 17px;
			color: #2196f3;
		}
		.top-nav {
			position: fixed;
			z-index: 999;
			top: 0;
		}
		header {
			margin-top: 43px;
		}
		.main_block {
			margin-top: 69px;
		}
		@media screen and (max-width: 768px) {
			nav .top-nav .contacts i{
				display: none;
			}
			header {
				margin-top: 0px;
			}
			.main_block {
				margin-top: 25px;
			}
		}
	</style>
	<!--<link href="/custom/saapservice/js/swal/sweetalert.css" rel="stylesheet">-->
	
	<script src="/custom/saapservice/js/all.js"></script>
	<!--<script src="/custom/saapservice/js/jquery.min.js"></script>
    <script src="/custom/saapservice/js/bootstrap.min.js"></script>
	<script src="/custom/saapservice/js/jquery.maskedinput.min.js"></script>
	<script src="/custom/saapservice/js/mod.js"></script>
	<script src="/custom/saapservice/js/app.js"></script>-->
    <!--<script async src="https://use.fontawesome.com/38c46b4f11.js"></script>-->
    <!--<script src="/custom/saapservice/js/swal/sweetalert2.all.js"></script>-->
	
    <? if ($this->_datas['arg_url'] == 'about/contacts'):?>
		<script async src="https://api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU" type="text/javascript"></script>
        <script async src="/custom/saapservice/js/map.js"></script>
    <?endif;?>
	<?php if (!empty($analytics) && !$local) :; ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?= $analytics; ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', '<?= $analytics; ?>');
        </script>
    <?php endif; ?>
	<?php if (!empty($metrica) && !$local) { ?>
		<!-- Yandex.Metrika counter -->
		<script async type="text/javascript" >
			(function (d, w, c) {
				(w[c] = w[c] || []).push(function() {
					try {
						w.yaCounter<?= $metrica; ?> = new Ya.Metrika({
							id:<?= $metrica; ?>,
							clickmap:true,
							trackLinks:true,
							accurateTrackBounce:true,
							webvisor:true
						});
					} catch(e) { }
				});

				var n = d.getElementsByTagName("script")[0],
					s = d.createElement("script"),
					f = function () { n.parentNode.insertBefore(s, n); };
				s.type = "text/javascript";
				s.async = true;
				s.src = "https://mc.yandex.ru/metrika/watch.js";

				if (w.opera == "[object Opera]") {
					d.addEventListener("DOMContentLoaded", f, false);
				} else { f(); }
			})(document, window, "yandex_metrika_callbacks");
		</script>
		<noscript><div><img src="https://mc.yandex.ru/watch/<?= $metrica; ?>" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
		<!-- /Yandex.Metrika counter -->
	<?php } ?>
    <?php if (!empty($this->_datas['piwik'])) { ?>
        <!-- Matomo -->
        <script type="text/javascript">
        var _paq = _paq || [];
        /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function() {
            var u="/stat/";
            _paq.push(['setTrackerUrl', u+'piwik.php']);
            _paq.push(['setSiteId', '<?=$this->_datas['piwik']?>']);
            var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
            g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
        })();
        </script>
		<noscript><p><img src="/stat/piwik.php?idsite=<?=$this->_datas['piwik']?>&amp;rec=1" style="border:0;" alt="" /></p></noscript>
        <!-- End Matomo Code -->
    <?php } ?>
</head>
<body>

<nav>
    <div class="top-nav">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <?php if ($urlm == '/') :; ?>
                        <img style="margin: -13px 0px;" class="navbar-brand brand_logo" src="/custom/saapservice/img/logo.png" alt="">
                    <?php else: ?>
                        <a href="/"><img style="margin: -13px 0px;" class="navbar-brand brand_logo" src="/custom/saapservice/img/logo.png" alt=""></a>
                    <?php endif; ?>
                    <ul>
                        <?php if ($urlm == '/about/') :; ?>
                            <li class="active-menu"><span>О компании</span></li>
                        <?php else: ?>
                            <li><a href="/about/">О компании</a></li>
                        <?php endif; ?>
						<?php if ($urlm == '/about/diagnostic/') :; ?>
                            <li class="active-menu"><span>Диагностика</span></li>
                        <?php else: ?>
                            <li><a href="/about/diagnostic/">Диагностика</a></li>
                        <?php endif; ?>
                        <?php if ($urlm == '/about/services-list/') :; ?>
                            <li class="active-menu"><span>Цены</span></li>
                        <?php else: ?>
                            <li><a href="/about/services-list/">Цены</a></li>
                        <?php endif; ?>
						<?php if ($urlm == '/about/testimonials/') :; ?>
                            <li class="active-menu"><span>Отзывы</span></li>
                        <?php else: ?>
                            <li><a href="/about/testimonials/">Отзывы</a></li>
                        <?php endif; ?>
                        <?php if ($urlm == '/about/contacts/') :; ?>
                            <li class="active-menu"><span>Контакты</span></li>
                        <?php else: ?>
                            <li><a href="/about/contacts/">Контакты</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="col-sm-4 contacts">
                    <i class="fa fa-phone" aria-hidden="true"></i><a href="tel:+<?= $this->_datas['phone'] ?>" class="phone">+<?= tools::format_phone($this->_datas['phone']) ?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="main-nav">
        <nav class="navbar">
            <div class="container">
                <div class="collapse navbar-collapse mobile_menu" id="main-nav-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <? foreach ($menu as $key => $value) {
                            if ($urlm == $key)
                                echo '<li class="active-menu"><span>' . $value . '</span></li>';
                            else
                                echo '<li><a href="' . $key . '">' . $value . '</a></li>';
                        }
                        ?>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container -->
			<script>
				$(document).on('click',function(){$('.navbar-collapse').collapse('hide');})
			</script>
        </nav>
    </div>
</nav>
