<?php

#SELECT markas.name, markas.ru_name FROM `marka_to_sites` JOIN sites ON marka_to_sites.site_id = sites.id JOIN markas ON marka_to_sites.marka_id = markas.id WHERE sites.setka_id = 7 GROUP BY markas.id

#SELECT regions.name, regions.name_pe FROM sites JOIN regions ON sites.region_id = regions.id GROUP BY regions.id ORDER BY regions.id

#SELECT sites.name, IF(regions.name IS NULL, 'Москва', regions.name), markas.name, sites.setka_id FROM `sites` LEFT JOIN regions ON sites.region_id = regions.id LEFT JOIN marka_to_sites ON sites.id = marka_to_sites.site_id LEFT JOIN markas ON marka_to_sites.marka_id = markas.id WHERE setka_id = 7

/*
соотношение
60% 1 словные
25% 2 словные
15% 3 словные

соотношение между главной и хабами
60-70% главная
40-30% хабовые
*/

class Ankor
{

// Бренды

  public static $setkas = [
    7 => 'СЦ-7',
	6 => 'СЦ-6'
  ];

  public static $brandTypes = [
    '3q' => 'планшет,ноутбук,смартфон',
    '4good' => 'планшет,ноутбук,смартфон',
    'acer' => 'планшет,ноутбук,проектор,смартфон,моноблок',
    'apple' => 'планшет,ноутбук,смартфон,моноблок',
    'archos' => 'планшет,смартфон',
    'asus' => 'планшет,ноутбук,монитор,смартфон,моноблок',
    'benq' => 'смартфон,монитор,проектор',
    'blackberry' => 'смартфон',
    'bq' => 'планшет,смартфон',
    'canon' => 'принтер,фотоаппарат',
    'dell' => 'ноутбук,моноблок,сервер,монитор',
    'dexp' => 'планшет,ноутбук,смартфон,компьютер,моноблок',
    'digma' => 'смартфон,планшет,ноутбук',
    'emachines' => 'ноутбук',
    'explay' => 'смартфон,планшет',
    'fly' => 'планшет,смартфон',
    'fujitsu' => 'планшет,ноутбук,принтер',
    'ginzzu' => 'смартфон,планшет,компьютер,монитор',
    'haier' => 'смартфон,планшет,ноутбук',
    'highscreen' => 'смартфон',
    'hp' => 'ноутбук,компьютер,принтер,моноблок',
    'htc' => 'смартфон',
    'huawei' => 'планшет,ноутбук,сервер,смартфон',
    'iconbit' => 'смартфон,планшет',
    'irbis' => 'смартфон,планшет,ноутбук',
    'keneki' => 'смартфон,телефон',
    'kyocera' => 'принтер',
    'leeco' => 'смартфон',
    'lenovo' => 'планшет,ноутбук,смартфон,моноблок',
    'lexand' => 'смартфон,телефон',
    'lg' => 'телевизор,смартфон',
    'magic' => 'смартфон,планшет',
    'meizu' => 'смартфон',
    'micromax' => 'смартфон,телефон',
    'motorola' => 'смартфон',
    'msi' => 'ноутбук,моноблок,компьютер',
    'nautilus' => 'планшет,ноутбук',
    'nikon' => 'фотоаппарат',
    'nokia' => 'планшет,смартфон',
    'oneplus' => 'смартфон',
    'oysters' => 'смартфон,планшет,компьютер,сервер',
    'packardbell' => 'ноутбук',
    'prestigio' => 'смартфон,планшет,ноутбук',
    'qumo' => 'смартфон,планшет',
    'ritmix' => 'смартфон,планшет',
    'samsung' => 'планшет,ноутбук,телевизор,холодильник,смартфон,фотоаппарат',
    'sony' => 'ноутбук,планшет,телевизор,проектор,смартфон,фотоаппарат,игровая приставка',
    'texet' => 'смартфон,планшет',
    'thl' => 'смартфон',
    'toshiba' => 'ноутбук,планшет',
    'viewsonic' => 'монитор,проектор',
    'wexler' => 'смартфон,планшет,электронная книга',
    'xiaomi' => 'ноутбук,планшет,смартфон',
    'zopo' => 'смартфон',
    'zte' => 'смартфон',
  ];

  //Бренды русские

  public static $brandName = [
    'sony' => ['Sony', 'Сони'],
    'samsung' => ['Samsung', 'Самсунг'],
    'asus' => ['Asus', 'Асус'],
    'acer' => ['Acer', 'Асер'],
    'lenovo' => ['Lenovo', 'Леново'],
    'hp' => ['HP', 'НР'],
    'toshiba' => ['Toshiba', 'Тошиба'],
    'msi' => ['MSI', 'МСИ'],
    'dell' => ['Dell', 'Делл'],
    'htc' => ['HTC', 'НТС'],
    'nokia' => ['Nokia', 'Нокиа'],
    'fly' => ['Fly', 'Флай'],
    'huawei' => ['Huawei', 'Хуавей'],
    'xiaomi' => ['Xiaomi', 'Ксиаоми'],
    'meizu' => ['Meizu', 'Мейзу'],
    'apple' => ['Apple', 'Эпл'],
    'nikon' => ['Nikon', 'Никон'],
    'canon' => ['Canon', 'Кэнон'],
    'bq' => ['BQ', 'БКю'],
    'dexp' => ['DEXP', 'Дексп'],
    'digma' => ['Digma', 'Дигма'],
    'explay' => ['Explay', 'Эксплей'],
    'haier' => ['Haier', 'Хайер'],
    'highscreen' => ['Highscreen', 'Хайскрин'],
    'irbis' => ['Irbis', 'Ирбис'],
    'motorola' => ['Motorola', 'Моторола'],
    'prestigio' => ['Prestigio', 'Престижио'],
    'texet' => ['teXet', 'Тексет'],
    'zte' => ['ZTE', 'ЗТЕ'],
	'wexler' => ['Wexler', 'Векслер'],
	'blackberry' => ['Blackberry', 'Блэкберри'],
  ];

  public static $cities = [
    'москва' => ['Москва', 'Москве'],
    'краснодар' => ['Краснодар', 'Краснодаре'],
    'екатеринбург' => ['Екатеринбург', 'Екатеринбурге'],
    'челябинск' => ['Челябинск', 'Челябинске'],
    'омск' => ['Омск', 'Омске'],
    'воронеж' => ['Воронеж', 'Воронеже'],
    'санкт-петербург' => ['Санкт-Петербург', 'Санкт-Петербурге'],
    'нижний новгород' => ['Нижний Новгород', 'Нижнем Новгороде'],
    'новосибирск' => ['Новосибирск', 'Новосибирске'],
    'казань' => ['Казань', 'Казани'],
    'самара' => ['Самара', 'Самаре'],
    'ростов-на-дону' => ['Ростов-на-Дону', 'Ростове-на-Дону'],
    'волгоград' => ['Волгоград', 'Волгограде'],
    'саратов' => ['Саратов', 'Саратове'],
    'тюмень' => ['Тюмень', 'Тюмени'],
    'томск' => ['Томск', 'Томске'],
    'рязань' => ['Рязань', 'Рязани'],
    'пенза' => ['Пенза', 'Пензе'],
    'липецк' => ['Липецк', 'Липецке'],
    'уфа' => ['Уфа', 'Уфе'],
    'пермь' => ['Пермь', 'Перми'],
    'ульяновск' => ['Ульяновск', 'Ульяновске'],
    'оренбург' => ['Оренбург', 'Оренбурге'],
    'тула' => ['Тула', 'Туле'],
    'набережные челны' => ['Набережные Челны', 'Набережных Челнах'],
    'тверь' => ['Тверь', 'Твери'],
    'тольятти' => ['Тольятти', 'Тольятти'],
    'калининград' => ['Калининград', 'Калининграде'],
    'ставрополь' => ['Ставрополь', 'Ставрополе'],
    'сочи' => ['Сочи', 'Сочи'],
    'сургут' => ['Сургут', 'Сургуте'],
    'калуга' => ['Калуга', 'Калуге'],
    'орёл' => ['Орёл', 'Орле'],
    'череповец' => ['Череповец', 'Череповце'],
    'смоленск' => ['Смоленск', 'Смоленске'],
    'саранск' => ['Саранск', 'Саранске'],
    'мурманск' => ['Мурманск', 'Мурманске'],
    'нижнекамск' => ['Нижнекамск', 'Нижнекамске'],
    'иркутск' => ['Иркутск', 'Иркутске'],
    'кемерово' => ['Кемерово', 'Кемерово'],
    'новороссийск' => ['Новороссийск', 'Новороссийске'],
    'сыктыквар' => ['Сыктыквар', 'Сыктыкваре'],
    'хабаровск' => ['Хабаровск', 'Хабаровске'],
    'псков' => ['Псков', 'Пскове'],
    'подольск' => ['Подольск', 'Подольске'],
    'химки' => ['Химки','Химках'],
    'балашиха' => ['Балашиха', 'Балашихе'],
	'астрахань' => ['Астрахань','Астрахани'],
	'белгород'=>['Белгород','Белгороде'],
	'брянск'=>['Брянск','Брянске'],
	'барнаул'=>['Барнаул','Барнауле'],
	'вологда'=>['Вологда','Вологде'],
	'иваново'=>['Иваново','Иваново'],
	'ижевск'=>['Ижевск','Ижевске'],
	'йошкар-ола'=>['Йошкар-ола','Йошкар-оле'],
	'владимир'=>['Владимир','Владимире'],

  ];

  public static $urlHub = [
    7 => [
      'смартфон' => 'repair-smartphones',
      'ноутбук' => 'repair-laptops',
      'планшет' => 'repair-tablets',
      'моноблок' => 'repair-monoblock',
    ],
	6 => [
	'телевизор' =>'remont_televizorov',
	'фотоаппарат' => 'remont_fotoapparatov',
	'проектор' => 'remont_proyektorov',
	'ноутбук' => 'remont_noutbukov',
	'игровая приставка' => 'remont_igrovykh_pristavok',
	'планшет' => 'remont_planshetov',
	'смартфон' => 'remont_smartfonov',
	'электронная книга'=>	'remont_elektronnykh_knig',
	'моноблок' => 'remont_monoblokov',
	'холодильник' => 'remont_kholodilnikov',
	'компьютер' => 'remont_kompyuterov',
	'монитор' => 'remont_monitora',
	'сервер' => 'remont_servera',
	'видеокамера' => 'remont_videokamer',
	'принтер' => 'remont_printera',

	]
  ];


  public static $ankor = [

    1 => [

      //Главная обязательные 1-словные
      //название бренда одно из обязательно 1-словные
      'count' => 0.6,
      'req' => ["сервис", "ремонт", "центр"], //минимум 2, чаще 3
      //одно из больший вес на английскую версию, кроме леново/сони/мейзу/самсунг

      'zhopa' => [
        'brand' => ["%brandru%","%branden%"],
      ],

      //Главная разбавочные 1-словные

      'razAdd' => [
        "%url%"
      ],

      'raz' => [
      	["адрес", "адреса"],
      	["гарантийный", "гарантия", "гарантии"],
      	["отзывы"],
      	["авторизованный"],
      	["официальный"],
      	["список"],
      	["сертифицированный"],
      	["Russupport"],
      	["стоимость"],
      	["фирменный"],
      	["%city%"],
      	["сайт"],
      	["сервис-центр"],
      	["центр-ремонта"],
      	["ремонтируют"],
      	["отремонтируют"],
      	["чиним"],
      	["починим"],
      	["здесь"],
      	["тут"],
      	["главная"],
      	["технический"],
      ],

      'razBrand' => [
        'apple' => [
          'itunes',
        ],
        'sony' => [
          'видеотехника',
        ],
        'htc' => [
          'viva',
        ],
        'xiaomi' => [
          'ксиоми',
        ],

      ],
    ],

    2 => [

      //Главная обязательные 2-словные
      'count' => 0.25,
      'req' => ["сервисный центр", ["ремонт %brandru%", "ремонт %branden%"]],

      'raz' => [
      	"центр %brandru%",
      	"центр %branden%",
      	"центр ремонта",
      	"ремонтный центр",
      	"на дому",
      	"по гарантии",
      	"официальный сервис",
      	"сервис центр",
      	"авторизованный сервис",
      	"авторизованный центр",
      	"сертифицированный сервис",
      	"сервис %branden%",
      	"сервис %brandru%",
      	"мастера отремонтируют",
      	"инженеры отремонтируют",
      ],

      'razAdd' => [
        'apple' => [
          'apple watch',
          'эппл вотч',
          'mac os',
          'мак ос',
          'Apple TV',
          'настольные пк',
          'ipod touch ',
        ],
        'sony' => [
          'playstation VR',
        ],
        'samsung' => [
          'самсунг 2016',
        ],
        'lenovo' => [
          'lenovo прошивка',
          'сервера Lenovo',
          'сервера Леново',
          'lenovo vibe',
        ],
        'acer' => [
          'монитор acer',
        ],
        'asus' => [
          'роутер асус',
          'настройка асус',
          'асус макс',
          'asus драйвера',
          'asus geforce',
          'asus gtx',
        ],
        'meizu' => [
          'мейзу плей',
        ],
        'msi' => [
          'msi gaming',
          'видеокарта msi',
        ],
      ],
    ],

    3 => [
      //Главная обязательные 3-словные
      'req' => [["сервисный центр %brandru%","сервисный центр %branden%"]],
      'count' => 0.1,
      //Разбавочные 3-словные в 50% случаев при формировнаие должен один присуствовать в списке конечном
      //пускай - меняется на : переодически
      'razAdd' => [
      	"%url% - сервисный центр %brandru%",
      	"%url% - сервис центр %brandru%",
      	"%url% - центр ремонта %brandru%",
      	"%url% - сервисный центр %branden%",
      	"%url% - сервис центр %branden%",
      	"%url% - центр ремонта %branden%",
      	"%url% - официальный центр %branden%",
      	"%url% - сертифицированный центр %branden%",
      	"%url% - авторизованный центр %branden%",
      	"%url% - гарантийный центр %branden%",
      	"%url% - официальный центр %brandru%",
      	"%url% - сертифицированный центр %brandru%",
      	"%url% - авторизованный центр %brandru%",
      	"%url% - гарантийный центр %brandru%",
      	"%url% - центр %brandru% в %city1%",
      	"%url% - центр %branden% в %city1%",
      	"%url% - сервис %branden% в %city1%",
      	"%url% - сервис %brandru% в %city1%",
      	"%url% - ремонт %brandru% в %city1%",
      	"%url% - ремонт %branden% в %city1%",
      ],

      //Обычные разбавочные 3-словные
      'raz' => [
      	"сервис центр %brandru%",
      	"сервис центр %branden%",
      	"сервисный центр в %city1%",
      	"сервис центр в %city1%",
      	"центр ремонта в %city1%",
      	"центр ремонта %branden%",
      	"центр ремонта %brandru%",
      	"официальный центр %brandru%",
      	"официальный центр %branden%",
      	"официальный сервисный центр",
      	"авторизованный сервисный центр",
      	"сертифицировнный сервисный центр",
      	"гарантийный сервисный центр",
      	"авторизованный центр %brandru%",
      	"авторизованный центр %branden%",
      	"гарантийный центр %branden%",
      	"гарантийный центр %brandru%",
      	"официальный ремонтный центр",
      	"авторизованный ремонтный центр",
      	"сертифицированный ремонтный центр",
      	"ремонт на дому",
      	"ремонт по гарантии",
        'ремонт и настройка apple',
      ],

      'razAdd' => [
        'apple' => [
          'ремонт и настройка apple',
        ],
        'sony' => [
          '4K Ultra HD',
        ],
        'asus' => [
          'asus geforce gtx',
          'материнская плата asus',
        ],
        'msi' => [
          'msi geforce gtx',
        ],
      ],
    ],

    4 => [
      'count' => 0.05,

      'raz' => [
        'настройка в сервисном центре %brandru%',
        'настройка в сервисном центре %brandru%',
        'настройка в сервисном центре %branden%',
        'настройка в сервисе центре %branden%',
        'настройка в сервисе центре %brandru%',
        'настройка в гарантийном центре %brandru%',
        'настройка в гарантийном центре %branden%',
        'настройка в гарантийном сервисе %branden%',
        'настройка в гарантийном сервисе %brandru%',
        'настройка в официальном сервисе центр',
        'настройка в официальном центре %brandru%',
        'настройка в официальном центре %branden%',
        'настройка в сервисном центре - %url%',
        'настройка в сервисном центре - %url%',
        'настройка в сервисе центр - %url%',
        'настройка в сервисе центр - %url%',
        'настройка в гарантийном центре - %url%',
        'настройка в гарантийном сервисе - %url%',
        'настройка в официальном сервисе центр',
        'настройка в официальном центре - %url%',
        'настройка в сервисном центре - %url%',
        'настройка в сервисе центр - %url%',
        'настройка в гарантийном центре - %url%',
        'настройка в гарантийном сервисе - %url%',
        'настройка в официальном центре - %url%',
        'профессиональный ремонт и диагностика %brandru%',
        'профессиональный ремонт и диагностика %branden%',
        'диагностика и настройка электронной техники',
        'всегда можно обратиться по гарантии',
        'выездные работы по настройке техники',
        'срочный качественный ремонт на месте',
        'починить и настроить любую технику',
        'авторизованный центр ремонта техники',
        'услуги диагностики и настройки на дому',
        'профессиональные квалифицированные услуги мастера',
        'сервисный центр %brandru%  - %url%',
        'сервисный центр %branden%  - %url%',
        'сервис центр %branden%  - %url%',
        'сервис центр %brandru%  - %url%',
        'центр ремонта %brandru%  - %url%',
        'центр ремонта %branden%  - %url%',
        'гарантийный ремонт %brandru%  - %url%',
        'гарантийный ремонт %branden%  - %url%',
        'гарантийный центр %brandru%  - %url%',
        'гарантийный центр %branden%  - %url%',
        'гарантийный сервис %branden%  - %url%',
        'гарантийный сервис %brandru%  - %url%',
        'официальный сервис центр  - %url%',
        'официальный центр %brandru%  - %url%',
        'официальный центр %branden%  - %url%',
        'ремонтный центр %branden%  - %url%',
        'ремонтный центр %brandru%  - %url%',
        'ремонтный сервис %brandru%  - %url%',
        'ремонтный сервис %branden%  - %url%',
        'сервисный центр %brandru%  - %url%',
        'сервисный центр %branden%  - %url%',
        'сервис центр %branden%  - %url%',
        'сервис центр %brandru%  - %url%',
        'центр ремонта %brandru%  - %url%',
        'центр ремонта %branden%  - %url%',
        'гарантийный ремонт %brandru%  - %url%',
        'гарантийный ремонт %branden%  - %url%',
        'гарантийный центр %brandru%  - %url%',
        'гарантийный центр %branden%  - %url%',
        'гарантийный сервис %branden%  - %url%',
        'гарантийный сервис %brandru%  - %url%',
        'официальный сервис центр  - %url%',
        'официальный центр %brandru%  - %url%',
        'официальный центр %branden%  - %url%',
        'ремонтный центр %branden%  - %url%',
        'ремонтный центр %brandru%  - %url%',
        'ремонтный сервис %brandru%  - %url%',
        'ремонтный сервис %branden%  - %url%',
      ],
    ],

  ];

/*

//множеcтвенное число
array("ноутбук" => array("ноутбуков"));
array("смартфон" => array("смартфонов", "телефонов"));
array("планшет" => array("планшетов"));

*/

//обязательные хабовые 1-словн в зависимости от типа берем один
  public static $ankorHub = [

    1 => [
      'count' => 0.6,

      'req' => [
        "ноутбук" => ["ноутбуки","ноутбук"],
        "смартфон" => ["смартфоны", "телефоны", "телефон", "смартфон"],
        "планшет" => ["планшет", "планшеты"],
      ],

      // 'replace' => [
      //   'chanсe' => 0.4,
      //   'brands' => [
      //     'apple' => [
      //       'chanсe' => 0.7,
      //       'смартфон' => ['айфон','iphone'],
      //       'ноутбук' => ['макбук','macbook','mac'],
      //       'планшет' => ['ipad','айпад'],
      //     ],
      //     'sony' => [
      //       'chanсe' => 0.6,
      //       'смартфон' => ['xperia','иксперия'],
      //     ],
      //     'samsung' => [
      //       'смартфон' => ['галакси','galaxy'],
      //     ],
      //     'lenovo' => [
      //       'смартфон' => ['vibe','вайб'],
      //       'планшет' => ['ideapad'],
      //       'ноутбук' => ['thinkpad'],
      //     ],
      //     'acer' => [
      //       'ноутбук' => ['aspire','extensa'],
      //     ],
      //     'asus' => [
      //       'смартфон' => ['zenfone','зенфон'],
      //       'планшет' => ['zenpad','зенпад'],
      //     ],
      //     'htc' => [
      //       'смартфон' => ['desire'],
      //     ],
      //     'huawei' => [
      //       'смартфон' => ['honor','хонор'],
      //       'планшет' => ['mediapad','медиапад'],
      //     ],
      //   ],
      // ],

      'raz' => [
      	"цена",
      	"стоимость",
      	"гаджет",
      	"устройство",
      	"аппарат",
      ],

      'razBrand' => [
        'apple' => [
          'айфон' => 'смартфон',
          'iphone' => 'смартфон',
          'macbook' => 'ноутбук',
          'mac' => 'ноутбук',
          'retina' => 'ноутбук',
          'айпад' => 'планшет',
          'ipad' => 'планшет',
          'ipod' => 'планшет',
          'айпад' => 'планшет',
          'макбук' => 'ноутбук',
          'imac' => 'моноблок',
          'аймак' => 'моноблок',
        ],
        'sony' => [
          'playstation' => 'игровая приставка',
          'камера' => 'видеокамера',
          'фотокамера' => 'видеокамера',
          'xperia' => 'смартфон',
          'фотоаппарат' => 'видеокамера',
          'проектор' => 'проектор',
        ],
        'samsung' => [
          'галакси' => 'смартфон',
          'galaxy' => 'смартфон',
        ],
        'lenovo' => [
          'ideapad' => 'ноутбук',
          'thinkpad' => 'ноутбук',
        ],
        'acer' => [
          'aspire' => 'ноутбук',
        ],
        'asus' => [
          'zenpad' => 'планшет',
          'zenfone' => 'смартфон',
        ],
        'msi' => [
          'afterburner' => 'ноутбук',
        ],
        'htc' => [
          'desire' => 'смартфон',
        ],
        'huawei' => [
          'honor' => 'смартфон',
          'mediapad' => 'смартфон',
        ],
        'xiaomi' => [
          'mi' => 'смартфон',
        ],
      ],

    ],

    2 => [
      'count' => 0.2,

      'req' => [
        "ноутбук" => [
        	"ноутбуки %branden%",
        	"ноутбук %branden%",
        	"ноутбуки %brandru%",
        	"ноутбук %brandru%",
        ],
        "смартфон" => [
        	"смартфоны %branden%",
        	"телефоны %branden%",
        	"телефон %branden%",
        	"смартфон %branden%",
        	"смартфоны %brandru%",
        	"телефоны %brandru%",
        	"телефон %brandru%",
        	"смартфон %brandru%",
        ],
        "планшет" => [
        	"планшет %branden%",
        	"планшеты %branden%",
        	"планшет %brandru%",
        	"планшеты %brandru%",
        ],
      ],

      // 'replace' => [
      //   'chanсe' => 0.4,
      //   'brands' => [
      //     'apple' => [
      //       'chanсe' => 0.7,
      //       'смартфон' => ['apple iphone','эпл айфон'],
      //       'ноутбук' => ['apple macbook','эпл макбук'],
      //       'планшет' => ['apple ipad','эпл айпад'],
      //     ],
      //     'sony' => [
      //       'chanсe' => 0.6,
      //       'смартфон' => ['sony xperia','сони иксперия'],
      //     ],
      //     'samsung' => [
      //       'смартфон' => ['samsung galaxy','самсунг галакси'],
      //     ],
      //     'lenovo' => [
      //       'смартфон' => ['леново вайб','lenovo vibe'],
      //       'планшет' => ['lenovo ideapad'],
      //       'ноутбук' => ['lenovo thinkpad'],
      //     ],
      //     'acer' => [
      //       'ноутбук' => ['acer aspire','acer extensa'],
      //     ],
      //     'asus' => [
      //       'смартфон' => ['asus zenfone','асус зенфон'],
      //       'планшет' => ['асус зенпад','asus zenpad'],
      //     ],
      //     'htc' => [
      //       'смартфон' => ['htc desire'],
      //     ],
      //     'huawei' => [
      //       'смартфон' => ['huawei honor','хуавей хонор'],
      //       'планшет' => ['huawei mediapad','хуавей медиапад'],
      //     ],
      //   ],
      // ],

      'razBrand' => [
        'apple' => [
          'apple macbook' => 'ноутбук',
          'macbook air' => 'ноутбук',
          'macbook pro' => 'ноутбук',
          'macbook retina' => 'ноутбук',
          'apple ipad' => 'планшет',
          'ipad pro' => 'планшет',
          'ipad 2' => 'планшет',
          'ipad mini' => 'планшет',
          'ремонт iphone' => 'смартфон',
          'iphone x' => 'смартфон',
          'iphone 8' => 'смартфон',
          'айфон х' => 'смартфон',
          'айфон 8' => 'смартфон',
        ],
        'sony' => [
          'sony playstation' => 'игровая приставка',
          'playstation 4' => 'игровая приставка',
          'playstation 3' => 'игровая приставка',
          'ps 4' => 'игровая приставка',
          'проектор Sony' => 'проектор',
          'проектор сони' => 'проектор',
          'sony xperia' => 'смартфон',
        ],
        'samsung' => [
          'самсунг галакси' => 'смартфон',
          'галакси s8' => 'смартфон',
          'галакси s7' => 'смартфон',
          'samsung galaxy' => 'смартфон',
          'galaxy s8' => 'смартфон',
          'galaxy s7' => 'смартфон',
          'galaxy note' => 'смартфон',
          'холодильник самсунг',
          'самсунг j5' => 'смартфон',
          'самсунг j7' => 'смартфон',
          'самсунг s7' => 'смартфон',
          'самсунг s8' => 'смартфон',
          'самсунг а3' => 'смартфон',
          'самсунг а5' => 'смартфон',
          'самсунг джей' => 'смартфон',
          'самсунг джи' => 'смартфон',
          'самсунг джой' => 'смартфон',
          'смартфоны самсунг' => 'смартфон',
          'телевизор самсунг' => 'телевизор',
        ],
        'lenovo' => [
          'lenovo ideapad' => 'ноутбук',
          'ноутбук ideapad' => 'ноутбук',
          'lenovo thinkpad' => 'ноутбук',
          'ноутбук Леново' => 'ноутбук',
          'ноутбук Lenovo' => 'ноутбук',
          'леново таб' => 'планшет',
          'планшет леново' => 'планшет',
          'телефон леново' => 'смартфон',
          'леново йога' => 'ноутбук',
          'lenovo yoga' => 'ноутбук',
          'lenovo tab' => 'планшет',
        ],
        'acer' => [
          'acer aspire' => 'ноутбук',
          'acer драйвера',
          'acer predator' => 'ноутбук',
          'acer 571g' => 'ноутбук',
          'acer 7' => 'ноутбук',
          'acer e1' => 'ноутбук',
          'acer e5' => 'ноутбук',
          'acer extensa' => 'ноутбук',
          'acer iconia' => 'ноутбук',
          'acer predator' => 'ноутбук',
          'acer tab' => 'планшет',
          'acer v3' => 'ноутбук',
          'acer v5' => 'ноутбук',
        ],
        'asus' => [
          'asus zenfone' => 'смартфон',
          'asus max' => 'смартфон',
          'asus rog',
          'asus strix',
          'asus rt',
          'асус зенфон' => 'смартфон',
        ],
        'meizu' => [
          'мейзу м3' => 'смартфон',
          'мейзу м5' => 'смартфон',
          'мейзу про' => 'смартфон',
          'мейзу нот' => 'смартфон',
          'мейзу м6' => 'смартфон',
          'meizu note' => 'смартфон',
          'meizu pro' => 'смартфон',
          'meizu m3' => 'смартфон',
          'meizu m5' => 'смартфон',
          'meizu m6' => 'смартфон',
          'meizu mx4' => 'смартфон',
          'meizu mx5' => 'смартфон',
        ],
        'msi' => [
          'msi gtx' => 'ноутбук',
          'msi afterburner' => 'ноутбук',
          'мси афтербернер' => 'ноутбук',
        ],
        'htc' => [
          'htc desire' => 'смартфон',
          'htc ones' => 'смартфон',
          'htc sim' => 'смартфон',
          'htc u11' => 'смартфон',
          'htc viva' => 'смартфон',
          'htc ones' => 'смартфон',
        ],
        'huawei' => [
          'huawei honor' => 'смартфон',
          'huawei lite' => 'смартфон',
          'huawei p-series' => 'смартфон',
          'huawei nova' => 'смартфон',
          'huawei mediapad' => 'смартфон',
          'хуавей хонор' => 'смартфон',
          'хуавей нова' => 'смартфон',
          'хуавей лайт' => 'смартфон',
        ],
        'xiaomi' => [
          'xiaomi redmi' => 'смартфон',
          'xiaomi note' => 'смартфон',
          'xiaomi mi' => 'смартфон',
          'xiaomi 4 x' => 'смартфон',
          'xiaomi 5' => 'смартфон',
          'xiaomi 2' => 'смартфон',
          'xiaomi 4' => 'смартфон',
          'xiaomi 5a' => 'смартфон',
          'xiaomi 3' => 'смартфон',
          'редми ноут' => 'смартфон',
          'ксиаоми редми' => 'смартфон',
          'ксиаоми ми' => 'смартфон',
        ],
      ],


    ],

    3 => [
      'count' => 0.15,

      'req' => [
        "ноутбук" => [
        	"Ремонт ноутбуков %branden%",
        	"Ремонт ноутбука %branden%",
        	"Ремонт ноутбуков %brandru%",
        	"Ремонт ноутбука %brandru%"
        ],
        "смартфон" => [
        	"Ремонт смартфона %branden%",
        	"Ремонт смартфонов %branden%",
        	"Ремонт смартфона %brandru%",
        	"Ремонт смартфонов %brandru%",
        	"Ремонт телефона %brandru%",
        	"Ремонт телефонов %brandru%",
        	"Ремонт телефона %branden%",
        	"Ремонт телефонов %branden%"
        ],
        "планшет" => [
        	"Ремонт планшетов %branden%",
        	"Ремонт планшета %branden%",
        	"Ремонт планшетов %brandru%",
        	"Ремонт планшета %brandru%"
        ],
      ],

      'razBrand' => [
        'айфон 8 плюс' => 'смартфон',
      ],
      'sony' => [
        'sony playstation 4' => 'игровая приставка',
      ],
      'samsung' => [
        'samsung galaxy s8' => 'смартфон',
        'samsung galaxy 2017' => 'смартфон',
        'samsung galaxy s7' => 'смартфон',
        'самсунг галакси s8' => 'смартфон',
      ],
      'acer' => [
        'ноутбук acer aspire' => 'ноутбук',
        'acer iconia tab' => 'планшет',
        'acer aspire e1' => 'ноутбук',
        'acer aspire e5' => 'ноутбук',
        'acer aspire v3' => 'ноутбук',
      ],
      'asus' => [
        'асус зенфон 3' => 'смартфон',
        'асус зенфон макс' => 'смартфон',
        'asus zenfone max' => 'смартфон',
        'asus zenfone 4' => 'смартфон',
      ],
      'meizu' => [
        'мейзу про 7' => 'смартфон',
        'мейзу про 6' => 'смартфон',
        'мейзу м5s' => 'смартфон',
        'meizu mx6' => 'смартфон',
        'meizu u20' => 'смартфон',
      ],
      'htc' => [
        'htc desire dual' => 'смартфон',
      ],
      'huawei' => [
        'хуавей 8 лайт' => 'смартфон',
        'хуавей 10 про' => 'смартфон',
      ],
      'xiaomi' => [
        'xiaomi redmi note' => 'смартфон',
        'xiaomi redmi 4x' => 'смартфон',
        'xiaomi redmi 5' => 'смартфон',
        'xiaomi redmi 4' => 'смартфон',
        'xiaomi redmi 5a' => 'смартфон',
        'xiaomi mi 2' => 'смартфон',
        'xiaomi note 5a' => 'смартфон',
      ],
    ],

    4 => [
      'count' => 0.05,

      'razBrand' => [
        'asus' => [
          'асус зенфон 3 макс' => 'смартфон',
        ],
        'meizu' => [
          'meizu 7 plus' => 'смартфон',
          'мейзу м3 ноте' => 'смартфон',
          'мейзу м3 ноут' => 'смартфон',
          'meizu pro plus' => 'смартфон',
        ],
        'htc' => [
          'htc desire dual sim' => 'смартфон',
        ],
        'xiaomi' => [
          'xiaomi redmi note 5' => 'смартфон',
        ],
      ],
    ],
  ];

  public static $count = null;
  public static $brand = null;
  public static $city = null;
  public static $site = null;
  public static $setka = null;

  public static function mb_ucfirst($string, $encoding = 'UTF-8') {
      $strlen = mb_strlen($string, $encoding);
      $firstChar = mb_substr($string, 0, 1, $encoding);
      $then = mb_substr($string, 1, $strlen - 1, $encoding);
      return mb_strtoupper($firstChar, $encoding) . $then;
  }

  public static function getRand(&$arr, $del = false) {
    $ind = array_rand($arr);
    if ($del) unset($arr[$ind]);
    return $arr[$ind];
  }

  public static function setParams($params) {
    foreach ($params as $k=>$v) {
      self::$$k = mb_strtolower($v);
    }
  }

  public static function link($ank, $type = false) {
    $page = $type !== false ? self::mb_ucfirst($type) : 'Главная';
    $url = 'https://'.self::$site.'/'.($type === false ? '' : self::$urlHub[self::$setka][$type].'/');
    return [$ank, self::mb_ucfirst(self::$brand), self::mb_ucfirst(self::$city), $page, $url, self::$setka];
  }

  public static function generate() {

    $res = [];

    $_count = self::$count;
    $_brand = self::$brand;
    $_city = self::$city;
    $_site = self::$site;
    $_setka = self::$setka;

    foreach (self::$ankor as $countWord => $block) {

      $c = 0;
      $count = ceil($_count*0.65*$block['count']);

      if (isset($block['req'])) {
        foreach ($block['req'] as $value) {
          if ($c >= $count) break;
          if (!is_array($value))
            $value = [$value];

          $res[] = self::link($value[rand(0, count($value)-1)]);
          $c++;
          if ($c >= $count) break;
        }
        if ($c >= $count) continue;
      }

      if (isset($block['zhopa'])) {
        if ($countWord == 1) {
          $brand = $block['zhopa']['brand'];
          if (in_array($_brand, ['lenovo', 'sony', 'meizu', 'samsung']))   {
            $arr = [0,0,0,0,0,0,1,1,1,1];
          }
          else {
            $arr = [1,1,1,1,1,1,0,0,0,0];
          }
          $res[] = self::link($brand[$arr[rand(0,count($arr)-1)]]);
        }
      }

      if (isset($block['razAdd']) && rand(0,1)) {
        $value = $block['razAdd'][array_rand($block['razAdd'])];
        if (!is_array($value))
          $value = [$value];

        $res[] = self::link($value[rand(0, count($value)-1)]);
        $c++;
      }

      if (isset($block['razBrand'][$_brand])) {
        if (isset($block['raz']))
         $block['raz'] = array_merge($block['raz'], $block['razBrand'][$_brand]);
        else {
          $block['raz'] = $block['razBrand'][$_brand];
        }
      }

      if (isset($block['raz'])) {
        for ($i = 1; $i <= $count-$c; $i++) {
          if (count($block['raz']) > 0) {
            $ind = array_rand($block['raz']);
            $value = $block['raz'][$ind];
            #if (is_numeric($ind)) {
              if (!is_array($value))
                $value = [$value];
              $res[] = self::link($value[rand(0, count($value)-1)]);
            #}


            unset($block['raz'][$ind]);
          }
          else {
            break;
          }
        }
      }

    }


    $types = explode(',', self::$brandTypes[$_brand]);
    foreach ($types as $k => $type) {
      if (!in_array($type, ['смартфон', 'планшет', 'ноутбук'])) unset($types[$k]);
    }

    if (count($types) == 0) {
      return false;
    }

    foreach (self::$ankorHub as $countWord => $block) {

      $c = 0;
      $count = ceil($_count*0.35*$block['count']);

      if (isset($block['req'])) {
        foreach ($block['req'] as $type => $value) {
          if (in_array($type, $types)) {
            if ($c >= $count) break;
            if (!is_array($value))
              $value = [$value];

            $res[] = self::link($value[rand(0, count($value)-1)], $type);
            if (isset($block['replace']['brands'][$_brand][$type])) {
              $chance = (isset($block['replace']['brands'][$_brand]['chanсe']) ? $block['replace']['brands'][$_brand]['chanсe'] : $block['replace']['chanсe'])*100;
              if (rand(1,100) <= $chance) {
                $res[] = self::link($block['replace']['brands'][$_brand][$type][rand(0,count($block['replace']['brands'][$_brand][$type])-1)], $type);
              }
            }
            $c++;
            if ($c >= $count) break;
          }
        }
        if ($c >= $count) continue;
      }

      if (isset($block['zhopa'])) {
        if ($countWord == 1) {
          $brand = $block['zhopa']['brand'];
          if (in_array($_brand, ['lenovo', 'sony', 'meizu', 'samsung']))   {
            $arr = [0,0,0,0,0,0,1,1,1,1];
          }
          else {
            $arr = [1,1,1,1,1,1,0,0,0,0];
          }
          $res[] = self::link($brand[$arr[rand(0,count($arr)-1)]], self::getRand($types));
        }
      }

      if (isset($block['razAdd']) && rand(0,1)) {
        $value = $block['razAdd'][array_rand($block['razAdd'])];
        if (!is_array($value))
          $value = [$value];

        $res[] = self::link($value[rand(0, count($value)-1)], self::getRand($types));
        $c++;
      }

      if (isset($block['razBrand'][$_brand])) {
        if (isset($block['raz']))
         $block['raz'] = array_merge($block['raz'], $block['razBrand'][$_brand]);
        else {
          $block['raz'] = $block['razBrand'][$_brand];
        }
      }

      if (isset($block['raz'])) {
        for ($i = 1; $i <= $count-$c; $i++) {
          if (count($block['raz']) > 0) {
            $ind = array_rand($block['raz']);
            $value = $block['raz'][$ind];

            if (is_numeric($ind)) {
              if (!is_array($value))
                $value = [$value];
              $res[] = self::link($value[rand(0, count($value)-1)], self::getRand($types));
            }
            else {
              $res[] = self::link($ind, $value);
            }
            unset($block['raz'][$ind]);
          }
          else {
            break;
          }
        }
      }

    }

    $replace = [
      '%brandru%' => self::$brandName[$_brand][1],
      '%branden%' => self::$brandName[$_brand][0],
      '%url%' => 'https://'.$_site,
      '%city%' => self::$cities[$_city][0],
      '%city1%' => self::$cities[$_city][1],
    ];

    foreach ($res as $k=>$v) {
      $replace['%url%'] = $v[4];
      $res[$k][0] = strtr($v[0], $replace);
    }

    return $res;

  }

  public static function toCsv($array) {
    foreach ($array as $k=>$v) {
      $array[$k] = implode(';', $v);
    }
    return implode("\r\n", $array);
  }

}

?>
