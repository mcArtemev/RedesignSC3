<?
use framework\tools;
$phone = $this->_datas['phone'];
$phone_format = tools::format_phone($phone);
srand();
$r1 = rand(0,1);
$tmp1 = [
		['профессию {мастера|ремонтного мастера|ремонтного специалиста|специалиста по ремонту|мастера по ремонту}'],
		['специальность {мастера|ремонтного мастера|мастера по ремонту}']
];
$tmp2 = [
		['подтверждающее {удостоверение|свидетельство}'],
		['удостоверяющее свидетельство']
];

$tmp3 = [
		['Уточнить', 'выяснить'],
		['Выяснить','уточнить']
];

$r4 = rand(0,1);
$r5 = rand(0,2);
$tmp4 = [
	['деталями','{подробную|полную}','{подробные|полные}'],
	['{инструментами|запчастями|комплектующими}','{подробную|детальную|полную}','{подробные|детальные|полные}']
];

$tmp5 = [
	['Получить','{задать|выяснить|проянить}','{спросить|уточнить}'],
	['Уточнить','{задать|выяснить|проянить}','спросить'],
	['Выяснить','{задать|прояcнить}','{спросить|уточнить}']
];

$vacancy=tools::new_gen_text("
{
	{Повысить|Улучшить|Усовершенствовать|Поднять} {уровень|класс} 
		{
			{
				своего {мастерства|умения}
			}|{
				своих {умений|навыков}
			}|{
				своей {квалификации|компетентности}
			}
		}
	{или|и/или|, либо|или же}
		{
			{
				{получить|освоить|обрести} {новую|другую|дополнительную} {специальность|профессию}
			}|{
				овладеть {новой|другой|дополнительной} {специальностью|профессией}
			}
		}
	{можно|возможно}
		{
			{
				пройдя наш
			}|{
				записавшись на наш
			}
		}
	{курс|учебный курс|спецкурс} по
}
");


$education_master=tools::new_gen_text("
{
	{Разнообразие|Ассортимент|Большой спектр|Огромный спектр|Широкий спектр|Широкий ассортимент} 
	{
		{
			бытовой техники, используемой {в каждой|в любой} семье, 
		}|{
			{бытовых устройств,|бытовых приборов,} используемых {в каждом|в любом} доме,
		}
	}
	делает 
			".$tmp1[$r1][0]." {крайне|очень|чрезвычайно|весьма} {востребованной:|популярной:|необходимой:} 
			{каждому|любому|всякому} {из этих|из данных} {устройств|приборов} {со временем|с течением времени}
			{
				{
					{требуется|нужен} ^ремонт ^(0)  
				}|{
					{требуется|нужна} ^починка^(0) 
					
				}
			}
			или ^{профилактическое обслуживание|профилактика}^(0).			
	 {При этом|Поэтому|Потому|Из-за чего} {профессия|специальность} 
	 {мастера по ремонту|мастера по обслуживанию|ремонтного мастера}
	 
			 {бытовой техники|бытовых устройств|бытовых приборов}
	 
	 требует {постоянного|непрерывного|переодического} {повышения|улучшения}
	 {квалификации|компетенции} 
	 	{
		 	{
			 	{в силу|в виду} того, что
		 	}|{

			 } , поскольку
		}
		у 
		{
			{
				стиральных машин и 
		 {
			{
				{других|иных|прочих} {бытовых устройств|бытовых приборов}
					
			}|{
				{другой|иной|прочей} бытовой техники	
			}
		}
			}|{
				{бытовых устройств|бытовых приборов}, {в частности|а в частности} стиральных машин
			}
		}
		{постоянно|все время|часто|очень часто} 
		{
			{
				{добавляются|появляются} {новые|современные|новейшие} {опции|функции|механизмы}	
			}|{
				{добавляется|появляется} {новый|современный|новейший} функционал	
			}
		} 
		, усложняется {программная среда|программное обеспечение|ПО}.
	{Если| Если вы} {хотите|желаете|планируете} {освоить|получить|обрести} {перспективную|востребованную} {профессию|специальность}
	, {обращайтесь|приходите} к нам {–|, мы} {проводим|организуем|предлагаем} {курсы|учебные курсы|спецкурсы|занятия}
	по обучению {мастеров|специалистов} по {ремонту|обслуживанию} стиральных машин. 
}
");


$education_master2=tools::new_gen_text("
{
 {Все|} 
 {
	{
 		{занятия|учебные занятия} по ^теории^(0) {и|и/или} ^практике^(0) {проходят|проводятся}
		 {в аудиториях|в классах|в кабинетах|в комнатах} , {оборудованных|оснащенных} {специальными|специализированными|ремонтными|профессиональными}
		 {стендами|площадками} {и|, а также} всеми {необходимыми|нужными|требующимися} {инструментами|запчастями|деталями|комплектующими}.		
	}|{
		^теоретические^(1) {или|и} ^практические^(1) {занятия|учебные занятия} {проходят|проводятся} {в аудиториях|в классах|в кабинетах|в комнатах},
		{оборудованных|оснащенных} {специальными|специализированными|ремонтными|профессиональными} {стендами|площадками} {и|, а также} всеми ".$tmp4[$r4][0]."
		{необходимыми|нужными|требующимися} {инструментами|запчастями|деталями} .
	}
  }	

	".$tmp5[$r5][0]."
	{
		{
			".$tmp4[$r4][1]." информацию 	
		}|{
			".$tmp4[$r4][2]." сведения
				
		}
	}
		о {программах|программе|расписании} курсов, {их продолжительности|их длительности|их сроках} {и|,|или|, а также}
		{
			{
				".$tmp5[$r5][1]." {все|любые} {интересующие|возникающие|волнующие} вопросы
			}|{
				".$tmp5[$r5][2]." обо всех {интересующих|возникающих|волнующих} воспросах
			}
		}	
		{можно|возможно} {по телефону|по номеру телефона|по контактному номеру|по единому номеру|по контактному телефону|по контактному номеру телефона|по единому номеру телефона|по единому телефону} : <a href=".$phone.">".$phone_format."</a>
				
}
");

//Description
//1
$description_vacancy=tools::new_gen_text("
{
		{Проводим|Организованы|Осуществляем|Предлагаем} {учебные курсы|специальные курсы|спецкурсы|курсы} по {обслуживанию|ремонту} стиральных машин
		{
			{
				{от|} {различных|разных}
					
			}|{ 
				всех {популярных|распространенных|известных}
			}
		}
	{производителей|брендов}.			
	{Новая|Востребованная|Прибыльная} {профессия|специальность} {за|всего за} {14 дней|2 недели}.		
	{Низкая|Честная|Приемлемая} {стоимость|цена}.
	{Выдаем|Выписываем|Предоставляем|Вручаем} 
		{
			{
				{подтверждающий|удостоверяющий} {сертификат|диплом}		
			}|{
				".$tmp2[$r1][0].".
			}
		}	
}
");

?>