<?
use framework\tools;
use framework\pdo;
$region_name = $this->_datas['region']['name'];
$region_name_pe = $this->_datas['region']['name_pe'];
$phone = $this->_datas['params']['phone'];

	$description_description=tools::new_gen_text("{
		{Поможем|Помогаем} с ^установкой^(0) {и|или} ^настройкой^(0)
	{
		{
			{любых|различных|всех|разнообразных}
			^программ^(1) {и|или} ^{компонентов|элементов системы}^(1)
		}|{
			{любого|различного|всего|разнообразного}
			{ПО|программного обеспечения}
			{и|или}
		}
	}
	{компонентов|элементов системы} на
	{вашу технику|ваше устройство} RUSSUPPORT.
	{Восстановим|Восстанавливаем}
	{
		{
			{поврежденные|удаленные|отформатированные|стертые}
			данные
		}|{
			{поврежденную|удаленную|отформатированную|стертую}
			информацию
		}
	}
	- {быстро|срочно|экстренно|без задержек}
	{и|,} по
	{низкой|доступной|регламентированной|фиксированной}
	{цене|стоимости}.
	{Выезд|Выезжаем|Приезжаем}
	^{на дом|домой|к вам домой}^(2) или ^{в офис|на работу|на рабочее место}^(2).
	}");

	$description_baner=tools::new_gen_text("{
		{Специализация|Профиль|Область специализации|Квалификация|Сфера специализации}
		{сервисного центра|сервис центра|сервиса} RUSSUPPORT — это
		{оказание|предоставление}
		{широкого|богатого|огромного|обширного|большого}
		{спектра|ряда|ассортимента|разнообразия}
		{услуг|работ} по компьютерной помощи,
		{в том числе|включающих}, восстановление данных.
		Работаем
		{с любыми|со всеми|с каждыми}
		{типами|видами}
		{техники|устройств} и
		{носителями|накопителями}
		{информации|данных} от
		{компьютеров|моноблоков|ПК|ноутбуков|лэптопов|персональных компьютеров|серверов|мфу} до
		{SD-карт|карт памяти|Nand Flash|дисковых RAID массивов|RAID|RAID-массивов|аппаратных RAID|РЕЙД|USB-флешек|флешек|USB|miniSD карт|microSD карт|TF карт|M2 карт|SSD|твердотельных накопителей|SSHD|SSD-накопителей|NAND SSD|RAM SSD|HDD|жестких дисков}, на
		{комфортных и понятных|понятных и комфортных|удобных и понятных|понятных и удобных|комфортных|удобных} условиях:
		^{сжатые сроки|быстрые сроки|короткие сроки|четкие сроки|конкретные сроки}^(0),
		^{регламентированная стоимость|фискированная стоимость|низкая стоимость|регламентированные цены|фискированные цены|низкие цены|доступные цены}^(0),
		^{продолжительная гарантия|длительная гарантия|продолжительный гарантийный срок|продолжительный срок гарантии|длительный срок гарантии|длительный гарантийный срок|увеличенный гарантийный срок|увеличенная гарантия|увеличенный срок гарантии|расширенный срок гарантии|расширенный гарантийный срок}^(1) и
		^{бесплатная диагностика|бесплатное выявление неисправностей|бесплатная диагностика неисправностей|бесплатная диагностика проблем}^(1)
	}");

	$description_antivirus_helper=tools::new_gen_text("{
		{Удаляем|Ликвидируем|Устраняем|Удалим|Ликвидируем|Устраним}
		{все|любые}
		{виды|типы|категории|классы}
		{вирусов|вредоносных программ|вредоносных программных обеспечений|вредоносных ПО}
		{
			{
				{со всех|с любых}
				устройств
			}|{
				с вашего
				{ПК|компьютера|ноутбука|лэптопа|моноблока|планшета}
			}
		}
		, {устанавливаем|установим}
		{антивирусное программное обеспечение|антивирусное ПО|антивирусные программы|антивирусную защиту}.
		{Настраиваем|Настроим}
		{службы|системы}
		{сетевой безопасности|безопасности сети} для
		{техники|устройств} Russupport.
	}");

	$description_antivirus_text=tools::new_gen_text("{
		Russupport
		{проведет|произведет|выполнит|сделает}
		{очистку|чистку}
		{
			{
				любого
				{устройства|типа техники}
			}|{
				всех
				{устройств|типов техники}
			}
		}
		от
		{вирусов|вредоносных программ|вредоносного программного обеспечения|вредоносного ПО},
		{а также|в том числе|или же}
		{настроит|установит и настроит|устновит или настроит|настроит или установит}
		{
			{
				{антивирусные программы|защитные программы} и
				{системы|слубжы}
			}|{
				{антивирусное ПО|защитное ПО} и
				{систему|службу}
			}	
		}
		{сетевой безопасности|безопасности сети}.
		{Итоговая|Конечная|Окончательная}
		{стоимость|цена}
		{
			{
				{зависит|будет зависеть} от
				{затраченного|потраченнго|истраченного}
				{времени|количества времени} на
				{произведенные|осуществленные|законченные}
				работы.
			}|{
				{складывается|будет складываться} из
				{времени|количества времени}
				{затраченного|потраченнго|истраченного} на
				работы.
			}
		}		
	}");

$description_install_OC=tools::new_gen_text("{
	{Устанавливаем|Установим}
	{все|любые}
	{виды|типы}
	{операционных систем|ОС} на
	{технику|устройства}
	{Russupport|RUSSUPPORT}.
	{Проведем|Сделаем|Осуществим|Выполним}
	{настройку|полную настройку|необходимую настройку|нужную настройку}
	или {восстановление|переустановку} {ОС|операционной системы}.
	{Низкие цены|Умеренные цены} на
	{
		{
			{все виды|любые виды}
			{работ|услуг}.
		}|{
			все
			{работы|услуги}.
		}
	}
	{Выписываем|Выдаем|Предоставляем}
	{гарантию|гарантийный талон|гарантийный бланк|гарантийный чек}.
}");

$description_install_OC_text=tools::new_gen_text("{
	{Специалисты|Мастера|Сотрудники|Инженеры} Russupport
	{выполнят|проведут|произведут|выполняют|проводят|осуществляют}
	^{установку|инсталляцию}^(0) {и|или} ^{настройку|персонализацию}^(0)
	любой {операционной системы|ОС}
	{на вашем|у	вас на}
	{компьютере|моноблоке|ноутбуке|лэптопе|ПК}.
	{Проведение|Осуществление|Выполнение}
	{работ|необходимых работ|требуемых работ}
	{возможно|доступно}
	^{на дому|дома|у вас дома}^(1) {и|или} ^{в офисе|на работе|на рабочем месте}^(1).
	{Оформляем|Выписываем|Выдаем|Предоставляем|Даем}
	{гарантию|гарантийный чек|гарантийный талон|гарантийный бланк|бланк гарантии} на 
	{все|каждые|любые|}
	{выполненные|проведенные|осуществленные}
	{услуги|работы}.
}");
$r = rand(0,1);
$tmp= [
		['или','и'],
		['и','или'],
];
$description_data_recovery=tools::new_gen_text("{
	{Проводим|Проведем|Выполним|Выполняем}
	^программное^(0) ".$tmp[$r][0]." ^программно-аппаратное^(0)
	{извлечение|изъятие} ".$tmp[$r][1]." восстановление
	{
		{
			{потерянных|утерянных|поврежденных|удаленных|отформатированных}
			данных.
		}|{
			{потерянной|утерянной|поврежденной|удаленной|отформатированной}
			информации.
		}
	}
	Работаем
	{
		{
			с {любыми|разными}
		}|{
			со всеми
		}
	}
	{носителями|накопителями|устройствами}.
	{Бесплатный|Абсолюбно бесплатный}
	{выезд|приезд}
	^{мастера|специалиста}^(1) или ^{курьера|сотрудника курьерской службы}^(1).
}");

$description_data_recovery_text=tools::new_gen_text("{
	{Сервисный центр|Сервис центр|Сервис} Russupport
	{
		{
			{оказывает|предоставляет}
			помощь в восстановлении данных с
		}|{
			помогает восстановить
			{данные|информацию} с
		}
	}
	{цифровых|электронных}
	{носителей|накопителей|устройств|запоминающих устройств}.
	{
		{
			{Извлеченные|Восстановленные}
			{данные|сведения|файлы|материалы}
		}|{
			{Извлеченную|Восстановленную} информацию
		}
	}
	{передаем|возвращаем}
	{лично|только|лично в руки}
	{заказчику|клиенту|владельцу устройства}.
	{
		{
			{Гарантируем|Обеспечиваем|Соблюдаем}
			{конфиденциальность|сохранность|неразглашение}
		}|{
			{Гарантия|Гарантируем соблюдение}
			{конфиденциальности|сохранности|неразгашения|приватности}
		}
	}
	{информации|данных|сведений}.
}");

$description_install_PO=tools::new_gen_text("{
	{
		{
			{Оказываем|Предлагаем|Предоставляем} услуги
		}|{
			{Проводим|Выполняем} работы	
		}
	}
	по ^найстроке^(0) и ^{установке|инсталляции}^(0)
	{
		{
			{любых|всех} программ
		}|{
			любого
			{программного обеспечения|ПО}
		}
	}
	для {ОС|операционных систем|операционный системы}.
	{Настройка|Перенастройка|Прошивка|Перепрошивка|Работа с}
	{Биос|Bios|BIOS|БИОС},
	{обновление|установка|настройка|переустановка}
	{драйверов|пакета драйверов}.
	{
		{
			{Низкие|Доступные|Фиксированные|Регламентированные|Приемлемые} цены.
		}|{
			{Низкая|Доступная|Фиксированная|Регламентированная|Приемлемая} стоимость.
		}
	}
	{
		{
			Гарантия результата.
		}|{
			{Гарантированный|Качественный|Надежный} результат.
		}
	}
	}");
$description_install_PO_text=tools::new_gen_text("{
	{Мастера|Специлисты|Сотрудники|Инженеры} Russupport
	{
		{
			помогут
			{
				{
					при {необходимости|желании|потребности}
				}|{
					по {желанию|потребности}
				}
			}
			^{установить|инсталлировать}^(0) и ^настроить^(0)
			{
				{
					{любое|выбранное}
					{программное обеспечение|ПО}
				}|{
					{любые|выбранные} программы
				}
			}
		}|{
			^установят^(1) и ^настроят^(1)
			{
				{
					{любое|необходимое|выбранное}
					{программное обеспечение|ПО}
				}|{
					{любые|выбранные|необходимые} программы
				}
			}
		}
	}
	на {компьютер|моноблок|ноутбук|лэптоп|ПК|персональный компьютер} или другие типы техники.
	{
		{
			{Предоставляем|Оказываем|Выполняем|Реализуем} услуги
		}|{
			{Выполняем|Проводим} работы 
		}
	}
	на {комфортных|удобных|выгодных} условиях, 
	{
		{
			{возможен|закажите|доступен|предусмотрен|оформите заказ на|сделайте заказ на|принимаем заказы на}
			выезд
		}|{
			{возможен|доступен|предусмотрен}
			вызов
		}
	}
	{специалиста|мастера|сотрудника}
	{на дом или в офис|в офис или на дом|к клиенту|к заказчику|на дом, а также в офис|на дом или на работу|на дом или на рабочее место|на работу или на дом|на рабочее место или на дом}.
}");

$description_setting=tools::new_gen_text("{
	{
		{
			{Помогаем|Поможем} в найстроке
			{интернет роутеров|интернет-роутеров|роутеров интернет|роутеров|маршрутизаторов|маршрутизаторов интернет|интернет маршрутизаторов}
	^{МТС|MTS}^(0),^{Теле2|Tele2}^(0),^{Билайн|Beeline}^(0),^{Мегафон|МегаФон}^(0),^{Ростелеком|РосТелеком}^(0)
		}|{
			{Помогаем|Поможем} настроить
			{интернет роутеры|интернет-роутеры|роутеры интернет|роутеры|маршрутизаторы|маршрутизаторы интернет|интернет маршрутизаторы}
	^{МТС|MTS}^(0),^{Теле2|Tele2}^(0),^{Билайн|Beeline}^(0),^{Мегафон|МегаФон}^(0),^{Ростелеком|РосТелеком}^(0)
		}
	}

	и {других|иных|прочих}
	{провайдеров|поставщиков|операторов} связи.
	{Бесплатный|Абсолютно бесплатный|Срочный|Экстренный|Быстрый}
	{выезд|приезд}
	{мастера|специалиста|сотрудника}
	{на дом|домой|к вам домой} или
	{в офис|на рабочее место|на работу}.
}");

$description_setting_text=tools::new_gen_text("{
	{Специалисты|Мастера|Инженеры}
	{сервисного центра|сервис центра|сервис-центра|сервиса} Russupport
	{оказывают|предоставляют|осуществлют|выполняют}
	{различную|любую|} компьютерную помощь, от
	{настройки|наладки}
	{роутера|маршрутизатора|интернет роутера|интернет маршрутизатора} до
	{создания|внедрения|подключения|построения}
	{домашней сети|домашней локальной сети|локальной домашней сети}.
	{Вызвать|Заказать выезд}
	{мастера|специалиста|сотрудника|инженера}
	{на дом|домой|к вам домой|на дом или в офис|на дом или на рабочее место|на дом или на работу|в офис|на работу|на рабочее место|к вам в офис}
	{можно|возможно} по
	{телефону|номеру телефона|контактному телефону|контактному номеру телефона|единому номеру|единому номеру телефона|единому телефону|многоканальному телефону|по многоканальному номеру телефона}
	{или|, либо} через
	{сайт|форму на сайте|онлайн форму|онлайн форму на сайте|online форму|online форму на сайте|форму заявки|форму online заявки}.
}");

$r2= rand(0,2);
$tmp2 = [
		[	
			['копировальных аппаратов','устройств {ввода и вывода|вывода и ввода|ввода или вывода|вывода или ввода} информации.'],
			['копировальных аппаратов','периферийных устройств.'],
			['копировальных аппаратов','периферийной техники.'],
		],
		[
			['копировальной техники','{устройств|аппаратов} {ввода и вывода|вывода и ввода|ввода или вывода|вывода или ввода} информации.'],
			['копировальной техники','{периферийных устройств|периферийных аппаратов}.'],
			['копировальной техники','периферийной аппаратуры.'],
		],
];
$description_periphery=tools::new_gen_text("{
	{Выполняем|Осуществляем|Проводим}
	{установку и подключение|подключение и установку|подключение и настройку|настройку и подключение|установку и настройку|настройку и установку}
	^{принтеров|МФУ|лазерных и струйных принтеров|струйных и лазерных принтеров|струйных или лазерных принтеров|лазерных или струйных принтеров}^(0),^{сканеров|копиров|".$tmp2[$r][$r2][0]."}^(0),^{мониторов|экранов}^(0)
	{и|или}
	{
		{
			{иных|других} ".$tmp2[$r][$r][1]."
		}|{
			{иной|другой} ".$tmp2[$r][2][1]."
		}
	}
	{Вызов|Выезд|Прибытие|Приезд}
	{мастера|специалиста|сотрудника|инженера|сервисного специалиста|сервисного мастера|сервисного инженера} -
	{бесплатный|абсолютно бесплатный}
	{
		{
			^{на дом|к вам на дом|к вам домой}^(1) {и|или} ^{в офис|на работу|на рабочее место|на место работы}^(1)
		}|{
			{по вашему адресу|на ваш адрес|по указанному адресу|на указанный адрес|по обозначенному адресу|на обозначенный адрес|на указанный вами адрес|по указанному вами адресу}.
		}
	}
}");

$description_periphery_text=tools::new_gen_text("{
	{
		{
			{При возникновении|При появлении}
			{проблем|сложностей|трудностей}
		}|{
			При возникающих
			{проблемах|сложностях|трудностях}
		}
	}
	с {периферийными устройствами|периферийным оборудованием}
	{мастера|сотрудники|специалисты|инженеры} Russuport
	{
		{
			помогут
			{настроить и подключить|установить и настроить|настроить и установить}
		}|{
			{подключат и настроят|настроят и подключат|установят и настроят|настроят и установят}
		}
	}
	{
		{
			{дополнительное|вспомогательное} оборудование
		}|{
			{дополнительную|вспомогательную} {технику|аппаратуру}
		}
	}
	– работаем {со сканерами|с копирами|с копировальной техникой},
	{МФУ|принтерами|лазерными и струйными принтерами|струйными и лазерными принтерами|струйными или лазерными принтерами|лазерными или струйными принтерами} и
	{
		{
			{другим|прочим|иным} оборудованием.
		}|{
			{другой|прочей|иной} {техникой|аппаратурой}.
		}
	}
	{На предоставленные|На оказанные|На осуществленные|На выполненные}
	{услуги|работы}
	{даем|выдаем|выписываем|оформляем}
	{гарантию|гарантийный чек|гарантийный бланк|гарантийный талон|гарантийный документ}.
}");
$total = [1500,2000,2500];
$price = ($region_name == 'Москва' || 'Санкт-Питербург')? 3000: $total[rand(0,2)]; 
$description_block_promo=tools::new_gen_text("{
	{
		{
			<p class='block-promo-title'>{ДАРИМ|ДАЕМ}
			{скидку 20%|бонус -20%}</p>
		}|{
			<p class='block-promo-title'>Узнать
			{промокод|промо-код|код}
			{на скидку|со скидкой}
			{ПРОСТО|ЛЕГКО}!</p>
		}
	}
	<p class=block-promo-title-text>
	<span class='number'>1</span>Получите 
	{
		{
			{промокод|код|код со скидкой} в {SMS|СМС}
		}|{
			{SMS сообщение|СМС сообщение|SMS-сообщение} с {промокодом|кодом|промо-кодом}
		}
	}
	{сообщении|}</br>
	<span class='number'>2</span>{Сообщите|Назовите|Передайте} {промокод|код|промо-код|код со скидкой}
	{по окончании|по итогу|после всех|после окончания|после завершения|по завершению} работ
	{мастеру/курьеру|курьеру/мастеру|специалисту/курьеру|инженеру/курьеру|мастеру или курьеру|курьеру или мастеру|специалисту или курьеру}</br>
	<span class='number'>3</span>Получите {20% скидку|скидку 20%|скидку -20%} на {любые|все} {работы|услуги} от ".$price."</p>
}");

$description_block_how_we_work1=tools::new_gen_text("{
	{
		{
			Воспользуйтесь
			{формой|онлайн формой|формой на сайте|online формой}
		}|{
			Используйте
			{форму|онлайн форму|форму на сайте|online форму}
		}
	}
	или {позвоните|наберите|звоните} нам
}");

$description_block_how_we_work2=tools::new_gen_text("{
	{Профессиональные|Квалифицированные|Опытные|Высококвалифицированные}
	{мастера|специалисты|сотрудники|инженеры}
	{выявляют|диагностируют|выявят}
	{
		{
			{причину|происхождение} {проблемы|неполадки|неисправности}
		}|{
			источник {проблем|неполадок}
		}
	}
}");

$description_block_how_we_work3=tools::new_gen_text("{
	{Оказываем|Выполняем|Проводим}
	компьютерную помощь или
	{восстанавливаем информацию|восстанавливаем данные}
}");

$description_block_how_we_work4=tools::new_gen_text("{
	{Вы получаете|Вы получите|Вам выдают|Вам выдадут}
	{
		{
			восстановленное {устройство|запоминающее устройство}
		}|{
			восстановленную технику
		}|{
			восстановленный {носитель|накопитель}
		}
	}
	или {данные|информацию|файлы}
}");

 $tmp3 = [
 			['{Заполняйте|Заполните}','{оставляйте|оставьте}'],
 			['{Оставляйте|Оставьте}','{заполняйте|заполните}'],
 ];
 $description_block_consultation=tools::new_gen_text("{
	".$tmp3[$r][0]."
	{свой|ваш}
	{телефон|номер телефона|контактный номер|контактный телефон}
	{
		{
			через {онлайн форму|форму|online форму|on-line форму}
		}|{
			{с помощью|при помощи} {онлайн формы|формы|online формы|on-line формы}
		}
	}
	и ".$tmp3[$r][1]." {заявку|запрос} - 
	{сотрудники|специалисты|менеджеры|операторы} {колл центра|call центра|колл-центра|call-центра} {ответят|дадут ответы} на
	{вопросы|интересующие вопросы} {по всем|по любым|по} {видам|категориям} {работ|услуг}
	компьютерной помощи и {восстановления данных|восстановления информации}
 }");

 $description_page_services=tools::new_gen_text("{
	{Компьютерная помощь RUSSUPPORT в}
	{сервисном центре|сервис центре|сервисе} RUSSUPPORT {это|-}
	{
		{
			{индивидуальный|персональный|особый|нестандартный|оригинальный} подход
		}|{
			{индивидуальное|персональное|особое|нестандартное|оригинальное} решение
		}
	}
	к {каждой|любой} {проблеме|неполадке}.
	{Все|Любые} {необходимые|нужные} {действия|манипуляции|работы} {происходят|проводятся|выполняются|исполняются|осуществляются}
	{с помощью|при помощи} {профессиональных|ремонтных|профильных|специализированных} {стендов|установок} с
	{использованием|привлечением}
	{
		{
			{качественного|новейшего|оригинального|фирменного} {оборудования|оснащения}.
		}|{
			{качественной|новейшей|оригинальной|фирменной} аппаратуры.
		}
	}
	{
		{
			{Благодаря|Вследствие} {этому|чему}
		}|{
			Ввиду {чего|этого}
		}
	}
	{мы|мы - }
	{
		{
			лучший сервис
		}|{
			один из лучших {сервисов|мастерских|сервис центров|сервисных центров}
		}
	}
	{в городе ".$region_name."|в ".$region_name_pe."}
 }");

 $description_page_components=tools::new_gen_text("{
 	{После|По итогу|По завершению|По окончанию} {выполнения|} {работ|действий|манипуляций} по {восстановлению данных|восстановлению информации}
 	{
 		{
			с {неисправного|нерабочего|поврежденного}
 		}|{
			со сломанного
 		}
 	}
 	{устройства|запоминающего устройства},
 	{
 		{
			извлеченную информацию
 		}|{
			извлеченные {файлы|данные}
 		}
 	}
 	{необходимо|требуется|потребуется} {перенести|скопировать|загрузить} на {новый|}
 	{работающий|работоспособный|исправный} {носитель|накопитель}.
 	RUSSUPPORT {предлагает|предлагает возможность|предоставляет возможность|дает возможность} {приобрести|купить}
 	{накопители|носители|устройства|запоминающие устройства} для {копирования|передачи|загрузки}
 	{
 		{
 			{восстановленных данных|восстановленных файлов}.
 		}|{
 			восстановленной информации.
 		}
 	}
 }");
$tmp4 = [
			['сотрудник курьерской слубжы','{мастер|инженер|мастер сервиса|инженер сервиса}'],
			['{курьер|сотрудник сервиса}','{мастер|специалист|инженер|мастер сервиса|специалист сервиса|инженер сервиса}']
];

  $description_page_info=tools::new_gen_text("{
	{Сервис центр|Сервисный центр|Сервис|Сервис-центр} {предлагает|предоставляет}
	{
		{
			{большой|широкий} {спектр|ассортимент|диапазон}
		}|{
			{большое|широкое} разнообразие
		}
	}
	{услуг|работ},
	{
		{
			как по компьютерной помощи, так и по восстановлению данных.
		}|{
			как на компьютерную помощь, так и на восстановление данных.
		}
	}
	{Специально|} {для|ради}
	{
		{
			{
				{
					вашего {удобства|комфорта} 
				}|{
					{клиентов|заказчиков} {сервиса|сервисного центра|сервис центра}
				}
			}
			RUSSUPPORT {предоставляет|предлагает} {дополнительные|бонусные|следующие|осуществляет} услуги:
		}|{
			{удобства|комфорта} {клиентов|заказчиков} {сервиса|сервисного центра|сервис центра} RUSSUPPORT
			{предоставляет|предлагает|оказывает|осуществляет} {дополнительные|бонусные|следующие} услуги:
		}
	}
	 <p>{Срочные|Экстренные|Неотложные|Быстрые} работы - {мы|} {устраним|ликвидируем} {проблемы|неполадки|дефекты}
	{
		{
			{с вашим} {устройством|накопителем|носителем}
		}|{
			вашего {устройства|накопителя|носителя}
		}
	}
	{
		{
			в {экспресс формате|оперативном формате|короткие сроки}.
		}|{
			за короткий срок.
		}
	}
	</br>{Выезд и доставка|Доставка и выезд|Выезд на дом|Выезд к клиенту} - ".$tmp4[$r][0]." {сам|} {приедет|заедет|прибудет} за вашим
	{неисправным|поврежденным|вышедшим из строя|неработающим|дефектным} {аппаратом|устройством|накопителем|носителем|девайс}, {либо|или же|или}
	".$tmp4[$r][1]." {проведет|выполнит|осуществит} {все|необходимые|нужные} {работы|действия}
	{
		{
			у вас ^{на дому|дома}^(0) {или|и/или} ^{в офисе|на рабочем месте|на работе}^(0).
		}|{
			{по вашему адресу|по адресу указанному вами|по указанному вами адресу}.
		}
	}
	{После|По окончании|По итогам|По итогу|По завершении} {работ|восстановительных работ|работ по восстановлению}
	{курьер|сотрудник службы доставки|сотрудник курьерской службы|сотрудник сервиса} {привезет|доставит|вернет}
	{
		{
			{исправное|работающее|работоспособное} устройство.
		}|{
			{исправный|работающий|работоспособный} {накопитель|носитель|аппарат}.
		}
	}
	</p><p>
	{
		{
			{Можете быть|Будьте} {уверены|спокойны},
		}|{
			{Не переживайте,|Не волнуйтесь,|Мы гарантируем, что} 
		}
	}
	{
		{
			ваше устройство попадет
		}|{
			ваш {накопитель|носитель|аппарат}
		}
	}
	{
		{
			попадет {в надежные руки|в умелые руки}
		}|{
			окажется {в надежных руках|в умелых руках}
		}
	}
	{-|, поскольку|, так как}
	{
		{
			{все|} {наши|} {мастера|специалисты|инженеры} {дипломированы|выкоквалифицированы|сертифицированы|имеют сертификаты|имеют сертификаты соответствия|обладают сертификатами|обладают сертификатами соответствия}
		}|{
			{
				{
					каждый {наш|мастер|специалист|инженер} {мастер|специалист|инженер}
				}|{
					любой из {наших|} {мастеров|специалистов|инженеров}
				}
			}
			{дипломирован|выкоквалифицирован|сертифицирован|имеет сертификат|имеет сертификат соответствия|обладает сертификатом|обладает сертификатом соответствия}
		}
	}</p>
  }");
$tmp5 = [
			[
				['очень','{существенная|значимая} {часть|доля|составляющая}'],
				['очень','{существенное|значимое} звено'],
				['очень','{существенный|значимый} элемент'],
			],
			[
				['стратегически','{существенная|необходимая|значимая} {часть|доля|составляющая}'],
				['стратегически','{существенное|необходимое|значимое} звено'],
				['стратегически','{существенный|необходимый|значимый} элемент'],
			],
			[
				['','{существенная|необходимая|значимая} {часть|доля|составляющая}'],
				['','{существенное|необходимое|значимое} звено'],
				['','{существенный|необходимый|значимый} элемент'],
			],
];
 $description_hot_work = tools::new_gen_text("{
 	<p>Мы {понимаем|осознаем|отдаем себе отчет|знаем},	что	
 	{
 		{
			ваше устройство	– 
 		}|{
			ваш {девайс|накопитель|носитель информации|носитель}
 		}
 	}
	".$tmp5[$r2][$r2][0].$tmp5[$r2][$r2][1]." {жизни|работы|жизни и работы|работы и жизни}.
	А
	{
		{
			{потерянные|удаленные|поврежденные} {данные|файлы} {могут|способны}
		}|{
			{потерянная|утерянная|удаленная|поврежденная} информация {может|способна}
		}
	}
	{остановить|приостановить|затормозить} {важные|значительные|критически важные|серьезные} {процессы работы|рабочие процессы|процессы деятельности}.
	{Именно по этой причине|Именно поэтому|Поэтому|В связи с чем|В этой связи} {RUSSUPPORT|Russupport}
	{предлагает|предоставляет|оказывает|осуществляет} услугу {срочных|экспресс|быстрых|экстренных} {работ|восстановительных работ|работ по восстановлению}.</p>
	<p>{Экспресс|Срочные|Быстрые|Экстренные} {работы|услуги} {у нас|с нами} это:</p><ul>
	<li>
	{
		{
			{Программная|Аппаратная|Программная или аппаратная|Аппаратная или программная|Программная и аппаратная|Аппаратная и программная}
			{диагностика|проверка устройства|проверка носителя|проверка накопителя}
		}|{
			{Программное|Аппаратное|Программное или аппаратное|Аппаратное или программное|Программное и аппаратное|Аппаратное и программное}
			{выявление неисправностей|выявление причины неисправностей}
		}
	}
	, {разбор|разборка}, {восстановление данных|восстановление информации} от {20 минут|20 мин|15 минут|15 мин} до {часа|одного часа|1 часа|60 минут|60 мин}.</li>
	<li>
	{Исправление|Устранение|Ликвидация}
	{
		{
			{всех|любых|} {часто|зачастую|многократно} {возникающих|встречающихся}
		}|{
			{самых|наиболее} {частых|популярных|распространенных}
		}
	}
	{проблем|неисправностей|повреждений}.</li><li>
	{Дипломированные|Сертифицированные|Компетентные|Профессиональные|Квалифицированные|Опытные} {сервисные специалисты|сервисные мастера|сервисные инженеры|мастера сервиса|специалисты сервиса|инженеры сервиса}.</li></ul>
	{Условия|Об условиях|Об условиях работы} {уточняйте|спрашивайте|узнавайте|можно узнать|можно уточнить|можно спросить} по
	{телефону|номеру телефона|контактному номеру|контактному телефону|контактному номеру телефона|единому номеру|единому номеру телефона}: <a href='tel:+'".$phone.">".tools::format_phone($phone)."</a>
	</br>{Срочные|Экспресс|Быстрые|Экстренные} {работы|услуги} для {устройств|накопителей|носителей|девайсов} <span>от {20|15|25|30} минут</span>
 }");

$tmp6 = [
			['{услуги|виды услуг|типы услуг|разновидности услуг} ','{необходимо|нужно|потребуется} {выполнить|осуществить}'],
			['{работы|виды работ|типы работ|разновидности работ} ','{необходимо|нужно|потребуется} {провести|выполнить|осуществить|сделать}'],
];
$description_delivery = tools::new_gen_text("{
	{Выезд и доставка|Доставка и выезд|Выезд мастера и доставка|Выезд специалиста и доставка|Выезд инженера и доставка}
	{осуществляется|выполняется|производится} при любом {количестве|числе|множестве} {сдаваемых|принимаемых|получаемых}
	{устройств|аппаратов|носителей|накопителей} {в городе ".$region_name."|в ".$region_name_pe."}.
	{Услуга|Услуги|Сервис} {приёма и доставки|выезда и доставки|доставки и выезда|доставки и приема} {на дом|к вам домой}
	{
		{
			{
				{
					{направлена|нацелена} на то, чтобы
				}|{
					{реализована|сделана} для того, чтобы
				}
			}
			{экономить|съэкономить|сберечь} {время|свободное время}
		}|{
			{осуществляется|выполняется|исполняется} {с целью|в целях} {экономии|сбережения} {времени|свободного времени}
		}
	}
	{клиентов|заказчиков}.
	{К вам|По вашему адресу|На ваш адрес} {приедет|выедет|прибудет|подъедет} {мастер|специалист|инженер|мастер сервиса|специалист сервиса|инженер сервиса},
	{который|он|сотрудник} {предварительно|заранее|в ходе диагностики|проведет диагностику и |при осмотре|при осмотре устройства|после диагностики устройства}
	{определит|выявит|выяснит|сообщит|озвучит|предупредит}, {какие|какие именно} ".$tmp6[$r][0].$tmp6[$r][1].".
	{
		{
			В случае {несерьезных|незначительных|несложных|несущественных} {проблем|неполадок|неисправностей}
		}|{
			{В случае если|Если|В том случае, если} {проблемы|неполадки|неисправности} {несерьезные|незначительные|несложные}
		}
	}
	, {сервисный специалист|сервисный мастер|сервисный инженер} {выполнит|проведет|произведет}
	{
		{
			{все|любые} {работы|работы по восстановлению|восстановительные работы}
		}|{
			{все|любое} обслуживание
		}
	}
	{прямо|}
	{
		{
			у вас ^{на дому|дома}^(0) {или|и/или} ^{в офисе|на рабочем месте|на работе}^(0).
		}|{
			на месте.
		}
	}
	{При неисправностях|При проблемах|При неполадках|При дефектах} {серьезнее|значительнее|сложнее} {отвезет|доставит|выполнит доставку|осуществит доставку}
	{в сервис|в сервисный центр|в сервис центр} {RUSSUPPORT|Russupport} и
	{
		{
			восстановив {устройство|носитель|накопитель|устройство или данные|накопитель или данные|носитель или данные|устройство или информацию|носитель или информацию|накопитель или информацию}
		}|{
			{проведя восстановление|выполнив восстановление} {устройства|носителя|накопителя|устройства или данных|накопителя или данных|носителя или данных|устройства или информации|носителя или информации|накопителя или информации}
		}
	}
	{
		{
			, {вернет|привезет} его {вам|}
		}|{
			, {возвратит|привезет}
		}
	}
	{назад|обратно}.
}");

$tmp7 = [
			['Мы являемся','{компании|бренда|сервиса|сервисного центра|сервис центра}'],
			['{Сервис|Сервисный центр|Сервис центр} {является|выступает}','{компании|бренда}']
];
$description_company = tools::new_gen_text("{
	{Компания|Бренд|Сервис|Сервисный центр|Сервис центр} {RUSSUPPORT|Russupport} {существует|лидирует|работает} {на рынке|в сфере}
	восстановления {устройств|носителей|накопителей|данных|информации|устройств и данных|устройств и накопителей|устройств и носителей}
	{больше|более|около|свыше} {7|6|5|8|4} лет.
	".$tmp7[$r][0]." {подтвержденным|официальным|авторизованным} {партнёром|представителем} ".$tmp7[$r][1]." {RUSSUPPORT|Russupport}.
	{Опытные|Профессиональные|Опытнейшие|Высокопрофессиональные|Дипломированные|Сертифицированные} {специалисты|мастера|инженеры|сотрудники} и их
	{
		{
			{высокая|подтвержденная} {квалификация|компетентность}
		}|{
			{безупречная|солидная} репутация
		}
	}
	, {позволяет|помогает|дает возможность} {нам|нашему сервису|нашему сервисному центру|нашему сервис центру|нашей компании}
	{осуществлять|выполнять|проводить} {работы|услуги} {по компьютерной помощи|по обслуживанию компьютеров}
	{
		{
			и {восстановлению данных|восстановлению информации}.
		}|{
			{, а также|, в том числе} {восстановление данных|восстановление информации} {любой|разной|различной}
			{сложности|категории сложности|специфики} {в кратчайшие сроки|в короткие сроки|в сжатые сроки|оперативно|срочно}.
		}
	}
	{
		{
			Наш {офис|филиал} имеет {удобное|очень удобное} {расположение|местоположение|место расположения|место нахождения}:
		}|{
			Наше представительство
			{
				{
					{располагается|находится|размещено|открыто}:
				}|{
					{располагается|находится|размещено|можно найти|работает|принимает клиентов|принимает заказчиков} по адресу:
				}
			} 
		}
	}
	".$this->_datas['partner']['address1']."
}");
?>