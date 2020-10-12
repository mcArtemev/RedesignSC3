<?
use framework\tools;
$r1=rand(0,1);
$r2=rand(0,2);
$r3=rand(0,3);
$r4=rand(0,4);
srand($this->_datas['feed']);
$description_banner=tools::new_gen_text("{
		<li>
	{
		{
			{Стабильно|Неизменно|Постоянно} высокий доход
		}|{
			Постоянно высокая {зарплата|заработная плата}
		}
	}
		</li>
	{
		<li>
		{
			{Официальное трудоустройство|Трудоустраиваем официально|Официально трудоустраиваем}
			{
				{
					с {первого|1} {дня|рабочего дня}
				}|{
					{по|согласно} {ТК РФ|Трудовому кодексу РФ}
				}
			}
		}
		</li>
	}
	<li>
	{Возможность|Есть возможность|Даем возможность|Предоставляем возможность}
	{
		{
			пройти
			{
				{
					{обучающие|учебные} {курсы|спецкурсы}
				}|{
					{обучающий|учебный} {курс|спецкурс}
				}|{
					{обучение|}
				}
			}
		}|{
			записаться {на обучающие|на учебные} {курсы|спецкурсы}
		}
	}
	</li>
}");
$r2_3=(rand(2,3));
$tmp=[
		['профессию','{специальность|квалификацию|компетенцию}','профессии','{специальности|квалификации|компетенции}'],
		['специальность','{профессию|квалификацию|компетенцию}','специальности','{профессии|квалификации|компетенции}',],
		['компетенцию','{профессию|специальность|квалификацию}','компетенции','{профессии|специальности|квалификации}',],
		['квалификацию','{профессию|специальность|компетенцию}','квалификации','{профессии|специальности|компетенции}',],

];
$tmp2=[
		['холодильников','^стиральных^(1) и ^посудомоечных^(1) машин,'],
		['^стиральных^(1) и ^посудомоечных^(1) машин,','холодильников'],
];

$description_vacancy=tools::new_gen_text("{
	{
		{
			{Для тех, кто|Тем, кто} {хочет|желает|стремится}
		}|{
			{Всем|} желающим
		}
	}
	{получить|обрести} {новую|дополнительную|новую или дополнительную|дополнительную или новую} ".$tmp[$r3][1].",
	{
		{
			мы {предоставляем|даем} {возможность|шанс} {сделать|осуществить} это в {нашем сервисном центре|нашем сервис-центре|нашем  сервисе}.
		}|{
			{наш сервисный центр|наш сервис-центр|наш сервис} {предоставляет|дает} {возможность|шанс} {сделать|осуществить} это {у нас|прямо у нас}.
		}
	}
	{
		{
			{Чтобы|Для того, чтобы} 
			{пройти обучение на|получить ".$tmp[$r2][1]."}
		}|{
			Для получения ".$tmp[$r2][3]."
		}
	}
	{мастера|специалиста} {по ремонту|по обслуживанию} ".$tmp2[$r1][1]." {либо|или} {повысить|улучшить} квалификацию, вам ^{всего лишь|только лишь|}^(2) ^{нужно|необходимо}^(2) {выбрать один из|записаться на один из} {наших|предлагаемых|} {курсов|учебных курсов|обучающих курсов|спецкурсов|профкурсов}.
}");

$description_holodilnik=tools::new_gen_text("{
	{Курс|Спецкурс} {– мастер|- специалист|} {по ремонту|по обслуживанию} {холодильного оборудования|холодильников|холодильных систем} - {срок|продолжительность} {2 недели|две недели|14 дней}.
	{
		{
				{Теоретические|Базовые|Основные|} знания, которые вы {получите|обретете|приобретете}:
			}|{
				{Программа|Содержание} {курса|спецкурса|обучающего курса}:
		}
	}
}");

$tmp3=[
		['{устройство|конструкция|системы}','{холодильников|холодильного оборудования}'],
		['{устройство|конструкция}','{холодильников|холодильних систем|холодильного оборудования}'],
];

$description_holodilnik_p1=tools::new_gen_text("{
	".$tmp3[$r1][0]." {и|, а также|, в том числе,} {компоненты|элементы|детали|узлы|модули} ".$tmp3[$r1][1]. " {от|} {различных|разных|любых|всех} {брендов|производителей}
}");


$description_all_p1=tools::new_gen_text("{
	{типовые|основные|популярные|распространенные|часто встречающиеся} {неисправности|неполадки|поломки|дефекты} {и|, а также} {методы|способы|методики|варианты|алгоритмы} их {диагностики|определения|выявления}
}");

$description_all_p2=tools::new_gen_text("{
	{типовые|основные|популярные|распространенные|часто встречающиеся} {неисправности|неполадки|поломки|дефекты} {и|, а также} {методы|способы|методики|варианты|алгоритмы} их {диагностики|определения|выявления}
}");

$description_all_p3=tools::new_gen_text("{
	{принципы|основы} {работы|функционирования}
	{
		{
			{электронных|электрических|электротехнических} и механических систем
		}|{
			{электронных|электрических|электротехнических} систем и	механизмов
		}
	}

}");

$description_all_p4=tools::new_gen_text("{
	{технологии|способы|методы|шаблоны}
	{
		{
			{устранения|ликвидации} {поломок|неисправностей|дефектов|неполадок|сбоев}
		}|{
			{восстановления|ремонта|обслуживания}
		}
	}
	{,|, а также|, в том числе} {замена|монтаж|установка|демонтаж} {блочных|модульных} {компонентов|деталей|комплектующих|элементов|составных частей|конструкций|узлов}
}");

$description_all_p5=tools::new_gen_text("{
	{общение|контакт|обсуждение|коммуникация|взаимодействие} с {заказчиками|клиентами|пользователями} и
	{
		{
			{расчет|вычисление|калькуляция|определение} {сметы|расходов|затрат}
		}|{
			составление {сметы|отчетности}
		}
	}
}");

$description_holodilnik_p6=tools::new_gen_text("{
	{Стоимость|Цена } {обучения|курса} {всего| - } {15 000 р.|15 000 руб.|15 000 рублей}
}");

$description_mashin=tools::new_gen_text("{
	{Курс|Спецкурс} {– мастер|- специалист|} {по ремонту|по обслуживанию} {стиральных и посудомоечных|посудомоечных и стиральных} машин - {срок|продолжительность} {2 недели|две недели|14 дней}.
	{
		{
				{Теоретические|Базовые|Основные|} знания, которые вы {получите|обретете|приобретете}:
			}|{
				{Программа|Содержание} {курса|спецкурса|обучающего курса}:
		}
	}
}");

$description_mashin_p1=tools::new_gen_text("{
	{устройство|конструкция|системы} {и|, а также|, в том числе,} {компоненты|элементы|детали|узлы|модули} {стиральных, посудомоечных|стиральных и посудомоечных|посудомоечных, стиральных|посудомоечных и стиральных} машин {от|} {различных|разных|любых|всех} {брендов|производителей}
}");

$description_mashin_p6=tools::new_gen_text("{
	{Стоимость|Цена } {обучения|курса} {всего| - } {14 000 р.|14 000 руб.|14 000 рублей}
}");

$description_text=tools::new_gen_text("{
	{
		{
			{Практические навыки|Методики ремонта|Полученные знания}
		}|{
			Методики ремонта практикуются
		}
	}
	{после|по окончании|по итогам|по завершении} каждого {занятия|урока} в
	{
		{
			{оборудованных|оснащенных} аппаратурой {учебных|}
		}|{
			оснащенных {аппаратурой|оборудованием} {учебных|}
		}|{
			всем {необходимым,|нужным} {учебных|}
		}
	}
	{классах|кабинетах|помещениях|мастерских|ремонтных боксах}.
}");

$description_question=tools::new_gen_text("{
	Спросите ".$this->_datas['marka']['ru_name']."
	{
		{
			Получите {консультацию|информацию от|консультацию от}
		}|{
			Проконсультируйтесь	у
		}
	}
	{специалистов|менеджеров|операторов|сотрудников} ".$this->_datas['marka']['ru_name']." 
	{
		{
			{по актуальным|по открытым} вакансиям {или|, а также} о подробной программе
		}|{
			{об актуальных|о свободных|об открытых} вакансиях {или|, а также} о расписании
		}
	}
	{курсов|занятий|спецкурсов|профкурсов|лекций|уроков}.
}");

$description_description= tools::new_gen_text("{
	{Открыта|Свободна} вакансия } {мастера|специалиста} {по ремонту|по обслуживанию} {крупной|} бытовой техники в ".$this->_datas['region']['name_re'].".
	{Кандидатам|Соискателям} без {опыта|практического опыта|нужного опыта|необходимого опыта|достаточного опыта} {предлагаем|предоставляем} {профильное|специализированное|профессиональное} {двухнедельное|2 недельное|14 дневное} обучение.
}");
?>