<?php

function renderTypeText($text) {
  foreach ($text as $tag => $t) {
    switch ($tag) {
      case 'h':
        echo "<span class=\"h2\">$t</span>";
      break;
      case 'ul':
        if (isset($t['before']))
          echo "<p>{$t['before']}</p>";
        if (isset($t['list'])) {
          echo '<ul class = "listUl">';
          foreach ($t['list'] as $li) {
            echo "<li>$li</li>";
          }
          echo '</ul>';
        }
        if (isset($t['after']))
          echo "<p>{$t['after']}</p>";
      break;
      case 'p':
        echo "<p>$t</p>";
      break;
    }
  }
}

$typeText = [
  'моноблоки' => [
    'desc' => 'Сегодня моноблоки составляют серьезную конкуренцию персональным компьютерам и ноутбукам. Наш сервисный центр в Москве производит ремонт моноблоков различных брендов. Наши мастера имеют богатый опыт ремонта моноблоков любой сложности. Опытные специалисты высокой квалификации устранят проблему быстро и ваше устройство снова будет работать.',
    'text' => [
      [
        'h' => 'Как мы работаем',
        'p' => 'При проведении ремонтных работ любой сложности мы пользуемся современным оборудованием и необходимым программным обеспечением. Любые бренды могут быть отремонтированы в кратчайшие сроки по максимально приемлемым ценам. Стоимость услуг варьируется и зависит от нескольких факторов: наличия необходимых для ремонта комплектующих, сложности поломки, и необходимости дополнительного заказа запасных частей.',
      ],
      [
        'h' => 'Как заказать услугу',
        'p' => 'Как правило, работы занимают от одного до нескольких дней, после чего вы получите работающее устройство с гарантией на наши услуги. Если вам потребовался ремонт моноблока в Москве - обращайтесь в нашу компанию, наши специалисты вам помогут. Стоимость услуг вы можете уточнить по телефонам, указанным на нашем сайте.'
      ]
    ] //+
  ],
  'смартфоны' => [
    'desc' => 'Современный мир сложно представить без мобильных телефонов - они прочно вошли в повседневную жизнь. Как и другой технике, им свойственно ломаться. Специалисты нашего сервисного центра произведут качественный ремонт телефонов любых брендов, будь то замена стекла или перепрошивка. Богатый опыт ремонтников плюс высокая квалификация позволяют устранить любые неисправности телефонов.',
    'text' => [
      [
        'h' => 'Что можем предложить',
        'p' => 'Для того, чтобы заказать услугу ремонта телефона, позвоните в наш центр - мастер поможет определить поломку и озвучит стоимость работ по ее устранению. Ремонт аппаратов любых брендов будет произведен в кратчайшие сроки - мы ценим оперативность и работаем для вашего удобства. Комфортные условия заказа, высокая скорость работы, низкие цены - вот составляющие успеха для нас.',
      ],
      [
        'h' => 'Выгоды сотрудничества с нами',
        'p' => 'Сервисный центр сотрудничаем с ведущими поставщиками запасных частей и комплектующих, что позволяет держать низкие цены для наших клиентов. Используем в работе современное высокотехнологичное оборудование и лицензионное программное обеспечение. Мастера отремонтируют телефон в Москве быстро, качественно, с гарантией на произведенные работы. Каждый наш клиент важен для нас!'
      ],
    ] //+
  ],
  'фотоаппараты' => [
    'desc' => 'Фотография на сегодняшний день - не только модное хобби. Для многих это - работа. Что делать, если сломался фотоаппарат? Обратиться в наш сервисный центр. Мастера быстро обнаружат поломку, затем качественно устранят неисправности. Производим ремонт фотоаппаратов марки никон и других брендов. Работаем с цифровыми, зеркальными аппаратами.',
    'text' => [
      [
        'h' => 'Преимущества компании',
        'ul' => [
          'before' => 'Сервисных центров в Москве сегодня много, почему стоит сотрудничать именно с нами:',
          'list' => [
            'Производим качественный ремонт, замену объективов.',
            'Всегда в наличии широкий выбор комплектующих, что позволяет сократить сроки ремонта до минимума.',
            'Собственный склад запчастей в Москве дает возможность ремонтировать фотоаппараты любых брендов, не зависимо от года выпуска и поломки.',
            'Cтараемся держать цены на доступном уровне'
          ]
        ]
      ],
      [
        'p' => 'Для заказа услуги вам нужно всего лишь позвонить по телефонам, указанным на сайте - мастер примет вашу технику для работы в кратчайшие сроки, затем займется ее ремонтом. Также можете заказать сервисное обслуживание фотоаппарата, объектива, устранение механических повреждений. Стоимость работ будет озвучена мастером после диагностики аппарата.'
      ]
    ] //+
  ],
  'принтеры' => [
    'desc' => 'Наша ремонтная мастерская оказывает услуги по ремонту принтеров любых брендов в Москве. Работаем с принтерами разных типов - лазерными, струйными, а также многофункциональными устройствами. Быстро и качественно произведем диагностику, выполним ремонт копировального аппарата, без которого невозможна жизнь современного офиса.',
    'text' => [
      [
        'h' => 'Почему именно мы',
        'ul' => [
          'before' => 'Сервисный центр имеет ряд преимуществ:',
          'list' => [
            'Отремонтируем мфу любой модели с гарантией.',
            'При необходимости мастер приедет в ваш офис..',
          ],
        ]
      ],
      [
        'p' => 'Ремонт лазерных, струйных принтеров - незаменимая услуга не только для офисов и государственных учреждений. Сейчас принтеры есть почти в каждом доме, как любая техника, они требуют ухода, периодического ремонта, а также заправки. В нашем распоряжении комплектующие высокого качества, рекомендованные производителями плюс современные инструменты, которые позволяют выполнить ремонтные работы, произвести калибровку принтера или копировального аппарата, а также настроить его на оптимальный режим работы.'
      ],
      [
        'p' => 'Специалисты нашей компании приедут к вам в указанное время, для этого нужно позвонить по номерам телефонов, указанным в разделе "контакты" затем заказать услуги выезда мастера по необходимому адресу в Москве.',
      ]
    ]
  ],
  'компьютеры' => [
    'desc' => 'Качественный ремонт компьютера - актуальная на сегодняшний день услуга. Компьютеры различных брендов есть почти у каждого. Перепады напряжения, перегрев, шерсть домашних животных и многие другие факторы влияют на исправность техники. Без должного внимания компьютер может сломаться. Если это случилось - потребуются услуги квалифицированного специалиста, который устранит неисправность.',
    'text' => [
      [
        'h' => 'Что мы предлагаем',
        'ul' => [
          'before' => 'Сервисный центр давно занимается ремонтом компьютеров любых брендов. Наши преимущества:',
          'list' => [
            'Высокая квалификацияперсонала.',
            'Собственный склад комплектующих.',
            'Скорость работы.',
            'Привлекательные цены на ремонт компьютеров любых брендов.',
            'Работаем по всей Москве.',
          ]
        ]
      ],
      [
        'h' => 'Вызов мастера',
        'p' => 'Для заказа услуги, вызова мастера позвоните по номеру телефона, который указан на сайте сервисного центра. Менеджеры примут звонок, ответят на все вопросы. Мастер приедет по указанному адресу, проведет диагностику затем выявит неполадки, после чего произведет ремонт и, при необходимости, заменит неисправные детали на новые. Для вашего удобства мы работаем за наличный, безналичный расчет. После окончания ремонта вы получите необходимые документы.'
      ]
    ]
  ],
  'приставки' => [
    'desc' => 'Игра на приставке playstation - любимое развлечение не только для детей и подростков. Многие взрослые тоже любят провести время за игрой на консоли. У особо ярых поклонников игр приставка может сломаться. Так как Sony Playstation - самый популярный бренд среди приставок, то ломаются они чаще других. Для того, чтобы не остаться без любимой игры, вызовите мастера. После качественного ремонта ваша игрушка станет как новая.',
    'text' => [
      [
        'h' => 'Что делать, если сломалась приставка',
        'p' => 'Позвоните нам. Мы определим, что именно сломалось затем, как это починить. Договоримся о времени, и специалисты нашего центра реанимируют ваш ps. Вы можете привезти консоль самостоятельно, а можете вызвать мастера домой. Краткосрочный ремонт может быть произведен при выезде. Однако, если потребуются более сложные манипуляции, мастер выдаст все необходимые документы забрав приставку в ремонт.'
      ],
      [
        'h' => 'Как работаем',
        'ul' => [
          'before' => 'Алгоритм работы такой:',
          'list' => [
            'Вы звоните.',
            'Мы приезжаем.',
            'Ремонтируем.',
            'Снова можете играть на своем playstation.'
          ],
          'after' => 'После визита мастера даются гарантии на все произведенные работы, а также необходимые финансовые документы, подтверждающие оплату предоставленной услуги.',
        ]
      ]
    ]
  ],
  'телевизоры' => [
    'desc' => 'Телевизоры - наиболее популярная техника всех времен и народов. В каждом доме есть хотя бы один, а то и несколько телевизоров разных брендов. Естественно, время от времени им требуется ремонт.',
    'text' => [
      [
        'h' => 'Случаи, при которых нужно обращаться к мастеру',
        'ul' => [
          'before' => 'Случаи, при которых нужно обращаться к мастеру:',
          'list' => [
            'Пропал цвет.',
            'Исчезло или искажено изображение.',
            'Телевизор перестал включаться.',
            'При включении есть звук, но нет изображения.',
            'Отсутствует звук.',
            'После включения в сеть появляются посторонние шумы, запахи.',
            'Происходят самопроизвольные выключения.',
          ],
          'after' => 'Если вы наблюдаете хотя бы один из этих признаков - это тревожный сигнал, говорящий о том, что пора обратиться к специалисту.'
        ]
      ],
      [
        'h' => 'Условия работы',
        'p' => 'Сервисный центр не один год занимается ремонтом телевизоров различных брендов. Специалисты, которые работают у нас, годами оттачивали свое мастерство они готовы помочь, в любую минуту. Вам осталось всего лишь набрать номер телефона, указанный на сайте и мастер приедет к вам на дом. Уже на месте будет выявлена неисправность, проведена замена необходимых деталей и проверка работоспособности. Любимые передачи снова будут радовать вас!'
      ]
    ]
  ],
  'ноутбуки' => [
    'desc' => 'Ноутбуки различных брендов давно и прочно обрели популярность в домашнем, офисном использовании. Капризная техника, страдающая от попадания пыли, часто ломается. Наш сервисный центр предлагает услуги по чистке и ремонту ноутбуков.',
    'text' => [
      [
        'h' => 'Наиболее распространенные причины поломок',
        'ul' => [
          'before' => 'Причин может быть много, самые распространенные из них, а также их последствия:',
          'list' => [
            'Попадание пыли в корпус, что приводит к перегревам. Требуется чистка ноутбука затем замена термопасты.',
            'Трещины на дисплее - крышка ноутбука любого бренда наиболее уязвима. При неудачном закрытии экран может быть серьезно поврежден, потребуется замена матрицы.',
            'Быстро разряжается батарея. Возможны неисправности в блоке питания, может быть сломан разъем или же требуется замена самой батареи.',
            'Выгорание пикселей на экране - также требуется ремонт или замена матрицы.',
            'Экран показывает полосы- возможны неисправности видеокарты.',
          ],
          'after' => 'Возможны другие поломки, которые так же потребуют вмешательства специалиста. Наша компания отремонтирует ноутбук, независимо от бренда. Качество, высокая скорость работы, низкие цены - вот наша визитная карточка. Звоните, вызывайте мастера на дом или в офис.'
        ]
      ]
    ] //+
  ],
  'планшеты' => [
    'desc' => 'Благодаря своим компактным размерам, удобству использования, различные бренды планшетов завоевали популярность. Устройства, которыми массово пользуются взрослые, дети, подростки, обречены на частые визиты в ремонтную мастерскую. У нас в сервисном центре есть все для быстрого и качественного ремонта планшетов любых брендов.',
    'text' => [
      [
        'h' => 'Какие услуги предлагаем',
        'p' => 'Во время эксплуатации планшета следует быть предельно внимательными и аккуратными, основная причина попадания в ремонт - поврежденное стекло. Мастер подберет подходящее стекло, затем произведет его замену. Также могут быть выявлены другие неполадки - мы предлагаем бесплатную диагностику. Иногда бывают гарантийные случаи, это касается производственного брака и дефектов. При любом случае нужно обращаться в сервисный центр.'
      ],
      [
        'h' => 'Что делать, если',
        'p' => 'Сломался планшет - несите его к нам. Специалисты центра определят причину, по которой устройство перестало работать, затем оперативно ее устранят. Для вашего удобства, принимаем заявки по телефону, форму обратной связи на сайте. Сочетание приемлемой цены, качества выполнения работы и его скорости приятно удивит - мы работаем для вас!'
      ]
    ]
  ]
];





?>