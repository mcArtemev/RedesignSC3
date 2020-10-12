<?php
include '../head.php';

$files = scandir('data/setka/');
unset($files[0], $files[1]);
$replace_menu = ['.csv', 'sc'];
$replacement = ['', 'Сетка '];

if (MODE !== 'NEW') {
    ?>

    <div class="uk-container">
        <div class="uk-grid">
            <div class="uk-width-1-1@m">
                <form method="POST">
                    <fieldset class="uk-fieldset">
                        <legend class="uk-legend"></legend>
                        <div class="uk-margin">
                            <input name="sites" class="uk-input" autocomplete="off" type="text" placeholder="Список параметров">
                        </div>
                        <div class="uk-margin">
                            <select id="selector" name="sc" class="uk-select">
                                <option>Выберите сетку</option>
                                <?php foreach ($files as $value) { ?>
                                    <option value="<?= $value; ?>"><?= str_replace($replace_menu, $replacement, $value); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <input type="hidden" value="NEW" name="mode"/>
                        <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                            <label><input class="uk-radio" type="radio" name="md" value="worst"> Редко используемые бренды</label>
                        </div>
                        <div class="">
                            <input class="uk-button uk-button-primary" type="submit" value="Сгенерировать">
                        </div>
                    </fieldset>
                </form>
            </div>

            <div class="uk-width-1-1@m">
                <div class="uk-margin-top" uk-alert>
                    <h3>Инструкция по генерации списка новых сайтов</h3>
                    <p>1. Введите список параметров в формате:
                        город-разворота,префикс-домена-для-этого-города,номер-телефона;
                        краснодар,krd,77777777;новосибирск,nsk,8888888; и т.д.
                    </p>
                    <p>2. Выберите действие сетку.</p>
                    <p>3. При необходимости отметьте редко используемые бренды (по умолчанию генерирует популярные).</p>
                    <p>4. Нажмите СГЕНЕРИРОВАТЬ.</p>
                </div>
            </div>

        </div>
    </div>

    <?php
} else {

    if (isset($_POST['sc'])) {
        $sc = $_POST['sc'];
    }

    if (isset($_POST['md'])) {
        $md = $_POST['md'];
    } else {
        $md = 'best';
    }

    if (isset($_POST['sites'])) {
        $input = mb_strtolower($_POST['sites']);
        $input = str_replace('; ', ';', $input);
        if (substr($input, -1) == ';') {
            $input = substr_replace($input, "", -1);
        }
    }

    $s = ['[prefix]', '[phoneNumber]', '[regionIDgs]', '[regionIDls]'];
    $n = ['(', '+', ')', '-', ' '];

    $regionIDgs = [];
    $regionIDls = [];
    $regGSallNew = [];

    $out = $web->Explode($input, ';');
    $parametrs = $web->Explode_u($out, ',');

    $listBrands = file_get_contents('data/setka/' . $sc);
    $regionGS = mb_strtolower(file_get_contents('data/idgiper.csv'));
    $regionLS = mb_strtolower(file_get_contents('data/idlidst.csv'));

    $regGS = explode(PHP_EOL, $regionGS);
    $regGS = $web->Explode_u($regGS, ';');
    $regLS = explode(PHP_EOL, $regionLS);
    $regLS = $web->Explode_u($regLS, ';');
    $sites = explode(PHP_EOL, $listBrands);



    $c = [];
    foreach ($parametrs as $k => $v) {
        foreach ($regGS as $id) {
            if ($id[0] == $v[0]) {
                $regionIDgs[] = [$id[1]];
            }
        }
        foreach ($regLS as $id) {
            if ($id[0] == $v[0]) {
                $regionIDls[] = [$id[1]];
            }
        }
    }

    foreach ($parametrs as $k => $f) {
        $c[] = [$f[1], $f[2], $regionIDgs[$k][0], $regionIDls[$k][0]];
        foreach ($sites as $r => $v) {
            $allNew[] = str_replace($s, $c[$k], $v);
        }
    }


    $lastSites = $web->Explode_u($allNew, ';');
    $lastSites = array_chunk($lastSites, count($sites));
    ?>

    <ul class="uk-subnav uk-subnav-pill" uk-switcher>
        <li><a href="#">Гиперсетка</a></li>
        <li><a href="#">Лидстат</a></li>
    </ul>

    <ul class="uk-switcher uk-margin">
        <li>
            <table class="uk-margin-top uk-table uk-table-striped">
                <thead>
                    <tr>
                        <td>Домен</td>
                        <td>Название Английское</td>
                        <td>Название Русское</td>
                        <td>ID сетки</td>
                        <td>ID региона</td>
                        <td>Телефон</td>
                        <td>ID партнера</td>
                        <td>ID метрики</td>
                        <td>ID бренда</td>
                    </tr>
                </thead>
    <?php
    foreach ($lastSites as $key) {
        foreach ($key as $k => $value) {
            $value[12] = str_replace(array("\r","\n", "\t"),"",$value[12]);
			$md = str_replace(array("\r","\n", "\t"),"",$md);
            if (strcasecmp($md, $value[12]) === 0) {
                ?>
                            <tr>
                                <td><?= $value[0] ?></td>
                                <td><?= $value[1] ?></td>
                                <td><?= $value[2] ?></td>
                                <td><?= $value[3] ?></td>
                                <td><?= $value[4] ?></td>
                                <td><?= $value[5] ?></td>
                                <td><?= $value[6] . '-' . ($k + 1) ?></td>
                                <td><?= $value[7] ?></td>
                                <td><?= $value[8] ?></td>
                            </tr>
                <?php
            }
        }
    }
    ?> 
            </table>
        </li>
        <li>
            <table class="uk-margin-top uk-table uk-table-striped">
                <thead>
                    <tr>
                        <td>Домен</td>
                        <td>Телефон</td>
                        <td>ID бренда</td>
                        <td>ID сетки</td>
                        <td>ID региона</td>
                    </tr>
                </thead>
    <?php
    foreach ($lastSites as $key) {
        foreach ($key as $k => $value) {
            $value[12] = str_replace(array("\r","\n", "\t"),"",$value[12]);
			$md = str_replace(array("\r","\n", "\t"),"",$md);
            if (strcasecmp($md, $value[12]) === 0) {
                ?>
                            <tr>
                                <td><?= $value[0] ?></td>
                                <td><?= str_replace($n, '', $value[5]) ?></td>
                                <td><?= $value[10] ?></td>
                                <td><?= $value[11] ?></td>
                                <td><?= $value[9] ?></td>
                            </tr>
                <?php
            }
        }
    }
    ?>  
            </table>
        </li>
    </ul>
    <?php
}    