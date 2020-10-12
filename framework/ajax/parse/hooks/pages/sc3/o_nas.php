<?

use framework\tools;
use framework\ajax\parse\hooks\sc;
use framework\rand_it;
use framework\pdo;

$marka_lower = mb_strtolower($this->_datas['marka']['name']);
$marka_upper = mb_strtoupper($this->_datas['marka']['name']);
$marka = $this->_datas['marka']['name'];
$marka_ru =  $this->_datas['marka']['ru_name'];

$text = array();
$text[] = array('<p>Компания');
$text[] = array($this->_datas['servicename']);
$text[] = array('это специализированный московский');
$text[] = array('сервисный центр', 'сервис центр', 'сервис');
$text[] = array('по ремонту');

$t_array = array('техники', 'устройств');
$feed = $this->_datas['feed'];

srand($feed);

$url = ($this->_datas['arg_url'] != '/') ? '/'.$this->_datas['arg_url'].'/' : '/';

$choose = rand(0, 1);
$text[] = array($t_array[$choose] . (!in_array($url, ['/o_nas/', '/kontakty/', '/vakansii/', '/dostavka/']) ? ' '.$marka.'.' : '.'));

if ($choose == 0)
    $t_array = array('аппаратурой');
else
    $t_array = array('аппаратурой', 'техникой');

$text[] = array('Мы работаем с');
$text[] = $t_array;
$text[] = array('этого бренда');
$text[] = array('более', 'больше');
$text[] = array('5', '6', '7');
$text[] = array('лет и знаем о каждой модели все.');

$text[] = array('Знания и большой опыт', 'Знания и регулярная практика', 'Образование и опыт', 'Многолетний пыт и образование',
        'Регулярная практика', 'Постоянная практика и квалификация', 'Ежедневная практика', 'Высокая квалификация и многолетний опыт');

$text[] = array('мастеров', 'мастеров по ремонту', 'сервисных инженеров');
$text[] = array('позволяет', 'дает возможность');
$text[] = array('производить', 'проводить', 'выполнять', 'осуществлять');
$text[] = array('нам');
$text[] = array('ремонт', 'ремонтные работы', 'сложный ремонт', 'сложные ремонтные работы', 'даже самый сложный ремонт',
            'даже самый сложные работы', 'даже сложный ремонт', 'даже сложные работы', 'ремонт любой сложности', 'ремонтные работы любой сложности');
$text[] = array('максимально быстро.', 'максимально оперативно.', 'быстро.','оперативно.', 'в кротчайшие сроки.', 'быстро и качественно.',
            'качественно и быстро.', 'максимально быстро и качественно.', 'быстрее, чем в других сервисных центрах.');

$text[] = array($this->_datas['servicename']);
$text[] = array('имеет');
$text[] = array('14', '16', '17', '12', '9', '18');
$text[] = array('сертификатов, подтверждающих нашу компетенцию');
$text[] = array('и высокий', 'и высочайший');
$text[] = array('уровень профессионализма.</p>');

$h2 = array('<h2>Лучшие сотрудники</h2>', '<h2>Наша гордость</h2>', '<h2>Наши лучшие сотрудники</h2>', '<h2>Лучшие из лучших</h2>', '<h2>Лучшие в команде</h2>');
$peoples_text = array();
$peoples_text[] = array('<p>Среди');
$peoples_text[] = array('специалистов', 'сотрудников', 'работников');
$peoples_text[] = array('компании', 'центра', 'сервисного центра', 'сервис центра');
$peoples_text[] = array($this->_datas['servicename']);
$peoples_text[] = array('отдельно', '');
$peoples_text[] = array('стоит', 'нужно');
$peoples_text[] = array('выделить:</p>', 'отметить:</p>');

$peoples = array();
$str = '';

$sql = "SELECT `sites`.`id` FROM `sites` INNER JOIN `setkas` ON `setkas`.`id` = `sites`.`setka_id` WHERE `setkas`.`name`= 'СЦ-3' ORDER BY `sites`.`id`";
$posl = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN);

//print_r($posl);

$array_key = array_search($this->_datas['site_id'], $posl);

if ($array_key <= 12 && $this->_datas['region']['name'] == 'Москва')
{
    for ($i = ($array_key * 5 + 1); $i <= ($array_key + 1) * 5; $i++)
        $man_index[] = 'man/'.(string) $i;

    $woman_index = 'woman/'.(string) ($array_key + 1);

    $names['woman'] = array('Александра', 'Алёна', 'Алина', 'Алла', 'Анастасия', 'Ангелина', 'Анна', 'Антонина', 'Анфиса',
         'Арина', 'Ася', 'Богдана', 'Влада', 'Валентина', 'Валерия', 'Варвара', 'Василиса', 'Венера', 'Вера',
         'Вета', 'Евгения', 'Виктория', 'Вилена', 'Виолетта', 'Виталина', 'Владана', 'Владислава', 'Галина',
         'Дарья', 'Дина', 'Домника', 'Евдокия', 'Екатерина', 'Елена', 'Елизавета', 'Есения', 'Зинаида', 'Зиновий',
         'Злата', 'Зоя', 'Инесса', 'Инна', 'Иоанна', 'Ира', 'Ираида', 'Ирина', 'Карина', 'Кира', 'Кристина', 'Ксения',
         'Лариса', 'Лера', 'Лидия', 'Лика', 'Людмила', 'Майя', 'Маргарита', 'Марина', 'Мария', 'Марфа', 'Мила', 'Милана',
         'Милена', 'Мира', 'Мирослава', 'Мирра', 'Надежда', 'Наталья', 'Нелли', 'Ника', 'Нина', 'Оксана', 'Октябрина', 'Олеся',
         'Ольга', 'Павлина', 'Пелагея', 'Полина', 'Раиса', 'Рената', 'Римма', 'Руслана', 'Сабина', 'Светлана', 'Серафима', 'Соня',
         'Софья', 'Стелла', 'Таисия', 'Татьяна', 'Ульяна', 'Юлиан', 'Юлия', 'Юния', 'Яна', 'Янина');

    $names['woman'] = rand_it::randMas($names['woman'], count($names['woman']), '', $feed);

    $names['man'] = array('Аким', 'Александр', 'Алексей', 'Анатолий', 'Андрей', 'Антон', 'Анфим', 'Аркадий', 'Арсений', 'Артём', 'Богдан',
         'Борис', 'Вадим', 'Валентин', 'Василий', 'Валерий', 'Виктор', 'Виталий', 'Владислав', 'Владимир', 'Влас', 'Всеволод',
         'Вячеслав', 'Гавриил', 'Геннадий', 'Георгий', 'Герасим', 'Глеб', 'Гордей', 'Григорий', 'Даниил', 'Данислав', 'Денис',
         'Дмитрий', 'Евгений', 'Евдоким', 'Егор', 'Елисей', 'Емельян', 'Еремей', 'Ефим', 'Захар', 'Иван', 'Игнат', 'Игорь', 'Илья',
         'Кирилл', 'Константин', 'Кузьма', 'Леонид', 'Максим', 'Марк', 'Мартин', 'Матвей', 'Мирослав', 'Михаил', 'Никита', 'Никодим',
         'Никола', 'Николай', 'Олег', 'Остап', 'Павел', 'Пётр', 'Платон', 'Прохор', 'Радий', 'Радик', 'Радомир', 'Радослав',
         'Ренат', 'Родион', 'Роман', 'Ростислав', 'Руслан', 'Савелий', 'Святослав', 'Севастьян', 'Семён', 'Потап', 'Сергей', 'Станислав',
         'Степан', 'Тарас', 'Тимофей', 'Тихон', 'Трофим', 'Фёдор', 'Федот', 'Филипп', 'Фома', 'Юрий', 'Яков', 'Ярослав');

    $names['man'] = rand_it::randMas($names['man'], count($names['man']), '', $feed);

    $count_device = count($this->_datas['all_devices']);

    $j = 0;

    foreach ($this->_datas['all_devices'] as $device)
    {
        switch ($device['type'])
        {
            case 'ноутбук':
                $peoples[] = tools::get_rand(
                    array(
                        array('Мастер по ремонту ноутбуков', tools::get_rand($names['man'], false), $man_index[$j]),
                        array('Специалист по ноутбукам', tools::get_rand($names['man'], false), $man_index[$j]),
                    ), false);
                    $j++;
            break;
            case 'планшет':
                $peoples[] = tools::get_rand(
                    array(
                        array('Мастер по ремонту планшетов', tools::get_rand($names['man'], false), $man_index[$j]),
                        array('Специалист по планшетам', tools::get_rand($names['man'], false), $man_index[$j]),
                    ), false);
                $j++;
            break;
            case 'смартфон':
                $peoples[] = tools::get_rand(
                    array(
                        array('Мастер по ремонту ' . tools::get_rand(array('телефонов', 'смартфонов'), false), tools::get_rand($names['man'], false), $man_index[$j]),
                        array('Специалист по ' . tools::get_rand(array('телефонам', 'смартфонам'), false), tools::get_rand($names['man'], false), $man_index[$j])
                    ), false);
                $j++;
            break;
        }
    }

    $peoples[] = tools::get_rand(
                    array(
                        array('Оператор call-центра', tools::get_rand($names['woman'], false), $woman_index),
                        array('Оператор коллцентра', tools::get_rand($names['woman'], false), $woman_index)
                    ), false);

    $t_peoples = array();

    $t_peoples[] = array('Менеджер по закупкам', tools::get_rand($names['man'], false));
    $t_peoples[] = array('Гарантийный мастер', tools::get_rand($names['man'], false));
    $t_peoples[] = array('Руководитель' ,tools::get_rand($names['man'], false));
    $t_peoples[] = array('Приемщик', tools::get_rand($names['man'], false));
    $t_peoples[] = array('Курьер', tools::get_rand($names['man'], false));
    $t_peoples[] = array('Администратор', tools::get_rand($names['man'], false));

    $t_peoples = rand_it::randMas($t_peoples, 6-count($peoples), '', $feed);

    foreach ($t_peoples as $people)
    {
        $peoples[] = array_merge($people, array($man_index[$j]));
        $j++;
    }

    foreach ($peoples as $key => $people)
    {
        $str .= '<div class="tables"><div class="title">'.$people[0].'</div><div class="preiman"><img src="/templates/moscow/img/shared/'.$people[2].'.png">'.$people[1].'</div></div>';
    }
}

$total = array();
$total[] = array('<p>Работаем', '<p>Чиним');
$total[] = array('на совесть -');
$total[] = array('возврат');
$total[] = array('по гарантии', 'на гарантийный ремонт');
$total[] = array('меньше', '<', 'менее');
$total[] = array('1%', 'одного процента');
$total[] = array('устройств</p>', 'аппаратов</p>');

$this->_datas['total'] =  sc::_createTree($total, $feed);
?>

        <div class="title-row">
            <div class="container">
                <h1><?=$this->_ret['h1']?></h1>
            </div>
        </div>

         <? $banner_img = '/templates/moscow/img/shared/banners/'.$this->_datas['images']['o_nas'];
         include __DIR__.'/banner.php'; ?>

        <div class="aboutrow">
            <div class="container">
                <div class="abouttext">
                    <?=sc::_createTree($text, $feed);?>
                </div>
            </div>
        </div>

        <? if ($str):?>
        <div class="popularrow">
            <div class="container">
                 <?=tools::get_rand($h2, $feed);?>
                 <?=sc::_createTree($peoples_text, $feed);?>
                <div class="tables-wrapper">
                    <?=$str;?>
                </div>
            </div>
        </div>
        <?endif;?>

        <? include __DIR__.'/banner-total.php'; ?>

         <?=$this->_datas['preims']?>

        <ul class="breadcrumb">
            <li><a href="/">Главная</a></li>
            <li>О сервисе</li>
        </ul>
