<?php
include '../head.php';
?>

<div class="uk-container">
    <div class="uk-grid">
        <div class="uk-width-1-1@m">
            <form method="POST">
                <fieldset class="uk-fieldset">
                    <legend class="uk-legend"></legend>
                    <div class="uk-margin">
                        <input name="sites" class="uk-input" autocomplete="off" type="text" placeholder="Домены без протокола через пробел">
                    </div>
                    <div class="uk-margin">
                        <select name="mode" class="uk-select">
                            <option value="">Выберите действие</option>
                            <option value="BASE">Автооткрытие по списку</option>
                            <option value="SEARCH_GOOGLE">Массовые запросы в ПС Google</option>
                            <option value="SEARCH_YANDEX">Массовые запросы в ПС Yandex</option>
                        </select>
                    </div>
                    <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                        <label><input class="uk-radio" type="radio" name="proto" checked value="http:"> Протокол доменов HTTP</label>
                        <label><input class="uk-radio" type="radio" name="proto" value="https:"> Протокол доменов HTTPS</label>
                    </div>
                    <div class="">
                        <input class="uk-button uk-button-primary" type="submit" value="Запустить">
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>


<?php
if (isset($_POST['sites'])) {
    $sites = str_replace($replace_w, "", trim($_POST['sites']));
    if (substr($sites, -1) == ';') {
        $sites = substr_replace($sites, "", -1);
    }
}

if (isset($_POST['proto'])) {
    $protocol = $_POST['proto'];

    if ($protocol == 'https:') {
        $port = ':443';
    } else {
        $port = ':80';
    }
}

switch (MODE) {

    case 'GENREG':

        $arrSites = $web->Explode($sites, ' ');
        $pref = $autol->ModeR();
        $autol->OpenLinks($arrSites, $pref, $protocol, $port);

        break;

    case 'IMPORTANT':

        $arrSites = $web->Explode($sites, ' ');
        $pref = $autol->ModeR();
        $autol->OpenLinks($arrSites, $pref, $protocol, $port);

        break;

    case 'REINDEX':

        $arrSites = $web->Explode($sites, ' ');
        $pref = $autol->ModeR();
        $autol->OpenLinks($arrSites, $pref, $protocol, $port);

        break;

    case 'MIRRORS':

        $arrSites = $web->Explode($sites, ' ');
        $pref = $autol->ModeR();
        $autol->OpenLinks($arrSites, $pref, $protocol, $port);

        break;

    case 'VER_GOOGLE':

        $arrSites = $web->Explode($sites, ' ');
        $pref = $autol->ModeR();
        $autol->OpenLinks($arrSites, $pref, $protocol);

        break;

    case 'SEARCH_GOOGLE':

        $replace_gs = ['; ', ' '];
        $replacement_gs = [';', '+'];
        $sites = str_replace($replace_gs, $replacement_gs, $sites);
        $arrSites = $web->Explode($sites, ';');
        $pref = $autol->ModeR();
        $autol->OpenLinks($arrSites, $pref);

        break;
    
     case 'SEARCH_YANDEX':

        $replace_gs = ['; ', ' '];
        $replacement_gs = [';', '+'];
        $sites = str_replace($replace_gs, $replacement_gs, $sites);
        $arrSites = $web->Explode($sites, ';');
        $pref = $autol->ModeR();
        $autol->OpenLinks($arrSites, $pref);

        break;

    case 'BASE':

        $arrSites = $web->Explode($sites, ' ');
        $pref = $autol->ModeR();
        $autol->OpenLinks($arrSites, $pref);

        break;
}
?>

