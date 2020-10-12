<?php

define('MODE', isset($_POST['mode']) ? $_POST['mode'] : 'stop');

$url = $_SERVER['REQUEST_URI'];
$replace_w = ['http://', 'https://', '/'];
$replace_s = ['http://', 'https://', ' '];
$replace_m = ['http://', 'https://', ' ', '/'];

class Webmaster {

    static $api_URL = 'https://api.webmaster.yandex.net/v3/user/';
    static $mod = MODE;
    
    static function Explode($sites, $how) {
        $arrSites = explode($how, $sites);
        return $arrSites;
    }
    
    static function Explode_u($arrSites, $how) {
        foreach ($arrSites as $k => $v) {
            $arrSites[$k] = explode($how, $v);
        }
        return $arrSites;
    }
    
    static function Header() {
        $chead = [
            'Authorization: OAuth ' . Webmaster::$token,
            'Content-Type: application/json'
        ];
        return $chead;
    }
    
    //функция декодирования json ответа
    static function ErrorD($out) {
        $all = [];
        foreach ($out as $v) {
            $err = $v;
            $all[] = json_decode($err, true);
        }
        return $all;
    }
    
    //разбор ошибок операции
    function ErrorsWebmaster($errors) {
        switch ($errors) {
            case 'ENTITY_VALIDATION_ERROR':echo'Тело запроса не прошло валидацию';
                break;
            case 'FIELD_VALIDATION_ERROR':echo'Параметр не прошел валидацию';
                break;
            case 'ACCESS_FORBIDDEN':echo'Действие недоступно, у приложения нет требуемых разрешений';
                break;
            case 'INVALID_OAUTH_TOKEN':echo'OAuth-токен отсутствует или невалиден';
                break;
            case 'INVALID_USER_ID':echo'Ошибка в ID пользователя';
                break;
            case 'RESOURCE_NOT_FOUND':echo'Ресурс по запрошенному пути не существует';
                break;
            case 'REQUEST_ENTITY_TOO_LARGE':echo'Размер файла превышает ограничения';
                break;
            case 'TOO_MANY_REQUESTS_ERROR':echo'Превышен лимит на количество запросов';
                break;
            case 'VERIFIED':echo'Права подтверждены';
                break;
            case 'IN_PROGRESS':echo'Идет подтверждение прав';
                break;
            case 'VERIFICATION_FAILED':echo'Проверка проводилась, права не подтверждены';
                break;
            case 'INTERNAL_ERROR':echo'В процессе проверки прав произошла непредвиденная ошибка';
                break;
            case 'HOST_NOT_FOUND':echo'Сайт отсутствует в списке сайтов пользователя или на него не подтверждены права';
                break;
            case 'VERIFICATION_ALREADY_IN_PROGRESS':echo'Процесс подтверждения прав уже запущен';
                break;
            case 'HOSTS_LIMIT_EXCEEDED':echo'Превышен лимит сайтов (1703)';
                break;
        }
    }
    //вывод результата
    function Result($result, $arrSites = null) {
        switch (Webmaster::$mod) {
            case 'ADD':
                echo '<div class="uk-container"><div class="uk-grid"><div class="uk-width-1-1"><h3 class="uk-text-center uk-margin-top">Результат:</h3><table class="uk-margin-top uk-table uk-table-striped"><thead><tr><td class="uk-width-1-2">Домен</td><td class="uk-width-1-2">Статус операции</td></tr></thead>';
                foreach ($arrSites as $k => $value) {
                    if (isset($result[$k]['host_id'])) {
                        echo '<tr><td class="uk-width-1-2">';
                        echo $value;
                        echo '</a></td><td class="uk-width-1-2">';
                        echo 'Добавлен';
                        echo '</td></tr>';
                    } elseif (isset($result[$k]['error_code'])) {
                        echo '<tr><td class="uk-width-1-2">';
                        echo $value;
                        echo '</td><td class="uk-width-1-2">';
                        $this->ErrorsWebmaster($result[$k]['error_code']);
                        echo '</td></tr>';
                    }
                }
                echo '</table></div></div></div>';
                break;
            case 'VERIFY':
                echo '<div class="uk-container"><div class="uk-grid"><div class="uk-width-1-1"><h3 class="uk-text-center uk-margin-top">Результат:</h3><table class="uk-margin-top uk-table uk-table-striped"><thead><tr><td class="uk-width-1-2">Домен</td><td class="uk-width-1-2">Статус операции</td></tr></thead>';
                foreach ($arrSites as $k => $value) {
                    if (isset($result[$k]['verification_state'])) {
                        echo '<tr><td class="uk-width-1-2">';
                        echo $value;
                        echo '</a></td><td class="uk-width-1-2">';
                        $this->ErrorsWebmaster($result[$k]['verification_state']);
                        echo '</td></tr>';
                    } elseif (isset($result[$k]['error_code'])) {
                        echo '<tr><td class="uk-width-1-2">';
                        echo $value;
                        echo '</td><td class="uk-width-1-2">';
                        $this->ErrorsWebmaster($result[$k]['error_code']);
                        echo '</td></tr>';
                    }
                }
                echo '</table></div></div></div>';
                break;
            case 'DELETE':
                echo '<div class="uk-container"><div class="uk-grid"><div class="uk-width-1-1"><h3 class="uk-text-center uk-margin-top">Результат:</h3><table class="uk-margin-top uk-table uk-table-striped"><thead><tr><td class="uk-width-1-2">Домен</td><td class="uk-width-1-2">Статус операции</td></tr></thead>';
                foreach ($arrSites as $k => $value) {
                    if (empty($result[$k])) {
                        echo '<tr><td class="uk-width-1-2">';
                        echo $value;
                        echo '</a></td><td class="uk-width-1-2">';
                        echo 'Удален';
                        echo '</td></tr>';
                    } elseif (isset($result[$k]['error_code'])) {
                        echo '<tr><td class="uk-width-1-2">';
                        echo $value;
                        echo '</td><td class="uk-width-1-2">';
                        $this->ErrorsWebmaster($result[$k]['error_code']);
                        echo '</td></tr>';
                    }
                }
                echo '</table></div></div></div>';
                break;
            case 'SAITMAP':
                echo '<div class="uk-container"><div class="uk-grid"><div class="uk-width-1-1"><h3 class="uk-text-center uk-margin-top">Результат:</h3><table class="uk-margin-top uk-table uk-table-striped"><thead><tr><td class="uk-width-1-2">Домен</td><td class="uk-width-1-2">Статус операции</td></tr></thead>';
                foreach ($arrSites as $k => $value) {
                    if (isset($result[$k]['sitemap_id'])) {
                        echo '<tr><td class="uk-width-1-2">';
                        echo $value[0];
                        echo '</a></td><td class="uk-width-1-2">';
                        echo 'Карта сайта добавлена';
                        echo '</td></tr>';
                    } elseif (isset($result[$k]['error_code'])) {
                        echo '<tr><td class="uk-width-1-2">';
                        echo $value[0];
                        echo '</td><td class="uk-width-1-2">';
                        $this->ErrorsWebmaster($result[$k]['error_code']);
                        echo '</td></tr>';
                    }
                }
                echo '</table></div></div></div>';
                break;
        }
    }
    //обработчик задач вебмастера
    function Operation($arrSites, $protocol = null, $port = null, $type = null) {
        $task = [];
        $out = [];
        $multi = curl_multi_init();
        foreach ($arrSites as $k => $v) {
            $domen = $v;
            $curl = curl_init();
            switch (Webmaster::$mod) {
                case 'ADD':
                    $post = ['host_url' => $protocol . '//' . $domen];
                    curl_setopt($curl, CURLOPT_URL, Webmaster::$api_URL . Webmaster::$user_ID . '/hosts?oauth_token=' . Webmaster::$token);
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post));
                    break;
                case 'VERIFY':
                    $post = ['host_id' => $protocol . $domen . $port];
                    curl_setopt($curl, CURLOPT_URL, Webmaster::$api_URL . Webmaster::$user_ID . '/hosts/' . $protocol . $domen . $port . '/verification/?verification_type=' . $type);
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post));
                    break;
                case 'DELETE':
                    curl_setopt($curl, CURLOPT_URL, Webmaster::$api_URL . Webmaster::$user_ID . '/hosts/' . $protocol . $domen . $port . '?oauth_token=' . Webmaster::$token);
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                    break;
                case 'SAITMAP':
                    $domen = $v[0];
                    $sitemap = $v[1];
                    $post = ['url' => $protocol . '//' . $domen . '/' . $sitemap];
                    curl_setopt($curl, CURLOPT_URL, Webmaster::$api_URL . Webmaster::$user_ID . '/hosts/' . $protocol . $domen . $port . '/user-added-sitemaps/');
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post));
                    break;
            }
            curl_setopt($curl, CURLOPT_HTTPHEADER, $this->Header());
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_multi_add_handle($multi, $curl);
            $task[$domen] = $curl;
        }
        $active = null;
        do {
            $mrc = curl_multi_exec($multi, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);
        while ($active && $mrc == CURLM_OK) {
            if (curl_multi_select($multi) == -1) {
                usleep(100);
            }
            do {
                $mrc = curl_multi_exec($multi, $active);
            } while ($mrc == CURLM_CALL_MULTI_PERFORM);
        }

        foreach ($task as $chs) {
            $out[] = curl_multi_getcontent($chs);
            curl_multi_remove_handle($multi, $chs);
        }

        curl_multi_close($multi);
        return $out;
    }
    
    //обработчик списка сайтов
    function Summary($arrSites, $mode, $limit = null, $offset = null) {
        switch ($mode) {
            case 'summary':
                $mode = '/summary/';
                break;
            case 'external_links':
                $mode = '/links/external/samples/?offset=' . $offset . '&limit=' . $limit;
                break;
            case 'queries':
                $mode = '/search-queries/popular/?order_by=TOTAL_CLICKS&query_indicator=AVG_SHOW_POSITION';
                break;
        }
        $task = [];
        $multi = curl_multi_init();
        foreach ($arrSites['hosts'] as $value) {
            $url = $value['host_id'];
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, Webmaster::$api_URL . Webmaster::$user_ID . '/hosts/' . $url . $mode);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $this->Header());
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_multi_add_handle($multi, $curl);
            $task[$url] = $curl;
        }
        $active = null;
        do {
            $mrc = curl_multi_exec($multi, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);
        while ($active && $mrc == CURLM_OK) {
            if (curl_multi_select($multi) == -1) {
                usleep(100);
            }
            do {
                $mrc = curl_multi_exec($multi, $active);
            } while ($mrc == CURLM_CALL_MULTI_PERFORM);
        }

        foreach ($task as $chs) {
            $out[] = curl_multi_getcontent($chs);
            curl_multi_remove_handle($multi, $chs);
        }

        curl_multi_close($multi);
        return $out;
    }

}

//Работа с метрикой
class Metrika {

    //разбор ошибок
    function ErorrsMetrika($errors) {
        switch ($errors) {
            case 'backend_error':echo'Ошибка сервера';
                break;
            case 'invalid_parameter':echo'Неверно задан параметр';
                break;
            case 'not_found':echo'Указанный объект не найден';
                break;
            case 'missing_parameter':echo'Не указан необходимый параметр';
                break;
            case 'filter_limits':echo'Сложность фильтра превышает установленные ограничения';
                break;
            case 'access_denied':echo'Доступ запрещен';
                break;
            case 'invalid_token':echo'Неверный OAuth-токен';
                break;
            case 'unauthorized':echo'Неавторизованный пользователь';
                break;
            case 'quota_requests_by_uid':echo'Превышен лимит количества запросов к API в сутки для пользователя';
                break;
            case 'quota_delegate_requests':echo'Превышен лимит количества запросов к API на добавление представителей в час для пользователя';
                break;
            case 'quota_grants_requests':echo'Превышен лимит количества запросов к API на добавление доступов к счётчику в час';
                break;
            case 'quota_requests_by_ip':echo'Превышен лимит количества запросов к API в час для IP адреса';
                break;
            case 'quota_parallel_requests':echo'Превышен лимит количества параллельных запросов к API для пользователя';
                break;
            case 'quota_requests_by_counter_id':echo'Превышен лимит количества запросов к API в сутки для счётчика';
                break;
            case 'query_error':echo'Запрос слишком сложный';
                break;
            case 'too_much_rows':echo'Запрос читает слишком много данных';
                break;
            case 'conflict':echo'Нарушение целостности данных';
                break;
            case 'not_acceptable':echo'Неподдерживаемый формат';
                break;
            case 'timeout':echo'Запрос выполняется дольше отведенного времени';
                break;
            case 'invalid_uploading':echo'Некорректная загрузка файла';
                break;
            case 'invalid_json':echo'Переданный JSON имеет неверный формат';
                break;
            case 'limit_exceeded':echo'Превышен лимит целей (операций, фильтров)';
                break;
        }
    }

    //вывод результата операции
    function Result($result, $arrSites = null) {
        switch (Webmaster::$mod) {
            case 'ADD':
                echo '<div class="uk-container"><div class="uk-grid"><div class="uk-width-1-1"><h3 class="uk-text-center uk-margin-top">Результат:</h3><table class="uk-margin-top uk-table uk-table-striped"><thead><tr><td class="uk-width-1-2">Новый Домен</td><td class="uk-width-1-2">ID счетчика</td></tr></thead>';
                foreach ($arrSites as $k => $value) {
                    if (isset($result[$k]['counter'])) {
                        echo '<tr><td class="uk-width-1-2"><a href="https://metrika.yandex.ru/dashboard?group=day&period=quarter&id=' . $result[$k]['counter']['id'] . ' target="_blank">';
                        echo $result[$k]['counter']['site2']['site'];
                        echo '</a></td><td class="uk-width-1-2">';
                        echo $result[$k]['counter']['id'];
                        echo '</td></tr>';
                    } elseif (isset($result[$k]['errors'])) {
                        echo '<tr><td class="uk-width-1-2">';
                        echo $value;
                        echo '</td><td class="uk-width-1-2">';
                        $this->ErorrsMetrika($result[$k]['errors'][0]['error_type']);
                        echo '</td></tr>';
                    }
                }
                echo '</table></div></div></div>';
                break;
            case 'NEW_DOMEN':
                echo '<div class="uk-container"><div class="uk-grid"><div class="uk-width-1-1"><h3 class="uk-text-center uk-margin-top">Результат:</h3><table class="uk-margin-top uk-table uk-table-striped"><thead><tr><td class="uk-width-1-2">Новый домен</td><td class="uk-width-1-2">ID существующиего счетчика</td><td class="uk-width-1-2">Статус операции</td></tr></thead>';
                foreach ($arrSites as $k => $value) {
                    if (isset($result[$k]['counter'])) {
                        echo '<tr><td class="uk-width-1-2"><a href="https://metrika.yandex.ru/dashboard?group=day&period=quarter&id=' . $result[$k]['counter']['id'] . ' target="_blank">';
                        echo $result[$k]['counter']['site2']['site'];
                        echo '</a></td><td class="uk-width-1-2">';
                        echo $result[$k]['counter']['id'];
                        echo '</td>';
                        echo '<td class="uk-width-1-2">';
                        echo 'Изменение домена прошло успешно';
                        echo '</td></tr>';
                    } elseif (isset($result[$k]['errors'])) {
                        echo '<tr><td class="uk-width-1-2">';
                        echo $value[1];
                        echo '</td><td class="uk-width-1-2">';
                        echo $value[0];
                        echo '</td><td class="uk-width-1-2">';
                        $this->ErorrsMetrika($result[$k]['errors'][0]['error_type']);
                        echo '</td></tr>';
                    }
                }
                echo '</table></div></div></div>';
                break;
            case 'DELETE':
                echo '<div class="uk-container"><div class="uk-grid"><div class="uk-width-1-1"><h3 class="uk-text-center uk-margin-top">Результат:</h3><table class="uk-margin-top uk-table uk-table-striped"><thead><tr><td class="uk-width-1-2">ID удаляемого счетчика</td><td class="uk-width-1-2">Статус операции</td></tr></thead>';
                foreach ($arrSites as $k => $value) {
                    echo '<tr><td class="uk-width-1-2">';
                    echo $value;
                    echo '</td>';
                    echo '<td class="uk-width-1-2">';
                    if (isset($result[$k]['success']) && $result[$k]['success'] == 1) {
                        echo 'Счетчик удален';
                    } elseif (isset($result[$k]['errors'])) {
                        $this->ErorrsMetrika($result[$k]['errors'][0]['error_type']);
                    }
                    echo '</td></tr>';
                }

                echo '</table></div></div></div>';
                break;
        }
    }

    //обработчик задач метрики
    function Operation($arrSites) {
        $task = [];
        $out = [];
        $multi = curl_multi_init();
        foreach ($arrSites as $k => $v) {
            $url = $v;
            $curl = curl_init();
            switch (Webmaster::$mod) {
                case 'ADD':
                    $post = ["counter" =>
                        [
                            "name" => $url,
                            "site2" => ["site" => $url]
                        ]
                    ];
                    curl_setopt($curl, CURLOPT_URL, 'https://api-metrika.yandex.ru/management/v1/counters?oauth_token=' . Webmaster::$token);
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post));
                    break;
                case 'NEW_DOMEN':
                    $id = $v[0];
                    $url = $v[1];
                    $post = ["counter" =>
                        [
                            "site2" => ["site" => $url]
                        ]
                    ];
                    curl_setopt($curl, CURLOPT_URL, 'https://api-metrika.yandex.ru/management/v1/counter/' . $id);
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post));
                    break;
                case 'DELETE':
                    curl_setopt($curl, CURLOPT_URL, 'https://api-metrika.yandex.ru/management/v1/counter/' . $url . '?oauth_token=' . Webmaster::$token);
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                    break;
            }
            curl_setopt($curl, CURLOPT_HTTPHEADER, Webmaster::Header());
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_multi_add_handle($multi, $curl);
            $task[$url] = $curl;
        }
        $active = null;
        do {
            $mrc = curl_multi_exec($multi, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);
        while ($active && $mrc == CURLM_OK) {
            if (curl_multi_select($multi) == -1) {
                usleep(100);
            }
            do {
                $mrc = curl_multi_exec($multi, $active);
            } while ($mrc == CURLM_CALL_MULTI_PERFORM);
        }

        foreach ($task as $chs) {
            $out[] = curl_multi_getcontent($chs);
            curl_multi_remove_handle($multi, $chs);
        }

        curl_multi_close($multi);
        return $out;
    }

}

//класс автооткрытия
class AutoLinks {

    static $yandex_pref = 'https://webmaster.yandex.ru/site/';

    function ModeR() {
        switch (Webmaster::$mod) {
            case 'BASE':
                $pref = 'http://';
                $postfix = '';
                $mp = [$pref, $postfix];
                return $mp;
                break;
            case 'GENREG':
                $postfix = '/info/regions/';
                $mp = [AutoLinks::$yandex_pref, $postfix];
                return $mp;
                break;
            case 'IMPORTANT':
                $postfix = '/indexing/url-tracker/';
                $mp = [AutoLinks::$yandex_pref, $postfix];
                return $mp;
                break;
            case 'REINDEX':
                $postfix = '/indexing/reindex/';
                $mp = [AutoLinks::$yandex_pref, $postfix];
                return $mp;
                break;
            case 'MIRRORS':
                $postfix = '/indexing/mirrors/';
                $mp = [AutoLinks::$yandex_pref, $postfix];
                return $mp;
                break;
            case 'VER_GOOGLE':
                $prefix = 'https://www.google.com/webmasters/verification/verification?hl=ru&siteUrl=';
                $postfix = '/%26sig%3DALjLGbNNUNOK5mHSNq0QWJFHzxv2mXgivw&theme=wmt&authuser=0&priorities=vfile,vmeta,vdns,vanalytics,vtagmanager&tid=alternate';
                $mp = [$prefix, $postfix];
                return $mp;
                break;
            case 'SEARCH_GOOGLE':
                $prefix = 'https://www.google.ru/search?q=';
                $postfix = '';
                $mp = [$prefix, $postfix];
                return $mp;
                break;
            case 'SEARCH_YANDEX':
                $prefix = 'https://www.yandex.ru/search/?lr=213&text=';
                $postfix = '';
                $mp = [$prefix, $postfix];
                return $mp;
                break;
        }
    }

    function OpenLinks($arrSites, $mp, $protocol = null, $port = null) {
        foreach ($arrSites as $v) {
            $url = $v;
            echo '<script type="text/javascript">window.open("' . $mp[0] . $protocol . $url . $port . $mp[1] . '")</script>';
        }
    }

}

$web = new Webmaster;
$metr = new Metrika;
$autol = new AutoLinks;
