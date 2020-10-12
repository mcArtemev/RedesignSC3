<?php

namespace framework\ajax\parse\hooks\pages\sc6\data\src;

class type_service
{

  const TYPES_URL = array(
        'ноутбук' => 'remont_noutbukov', 
        'планшет' => 'remont_planshetov', 
        'смартфон' => 'remont_smartfonov', 
        'моноблок' => 'remont_monoblokov', 
        'компьютер' => 'remont_kompyuterov', 
        'сервер' => 'remont_serverov', 
        'телевизор' => 'remont_televizorov', 
        'холодильник' => 'remont_kholodilnikov', 
        'монитор' => 'remont_monitorov', 
        'проектор' => 'remont_proyektorov', 
        'телефон' => 'remont_telefonov', 
        'принтер' => 'remont_printerov', 
        'электронная книга' => 'remont_elektronnykh_knig', 
        'фотоаппарат' => 'remont_fotoapparatov', 
        'игровая приставка' => 'remont_igrovykh_pristavok',
        'кофемашина' =>'remont_kofemashin',
        
        'пылесос'=> 'remont_pylesosov',
        'варочная панель'=> 'remont_varochnyh_panelej',
        'микроволновая печь'=> 'remont_mikrovolnovyh_pechej',
        'кондиционер'=> 'remont_kondicionerov',
        'робот-пылесос'=> 'remont_robotov-pylesosov',
        'домашний кинотеатр'=> 'remont_domashnih_kinoteatrov',
        'хлебопечка'=> 'remont_hlebopechek',
        'морозильник'=> 'remont_morozilnikov',
        'посудомоечная машина'=> 'remont_posudomoechnyh_mashin',
        'духовой шкаф'=> 'remont_duhovyh_shkafov',
        'смарт-часы'=> 'remont_smart-chasov',
        'вытяжка'=> 'remont_vytyazhek',
        'видеокамера'=> 'remont_videokamer',
        'массажное кресло'=> 'remont_massazhnyh_kresel',
        'стиральная машина'=>'remont_stiralnayh_mashin',
        'водонагреватель'=>'remont_vodonagrevatelej',
        'квадрокоптер'=>'remont_kvadrokopterov',
        'плоттер'=>'remont_plotterov',
        'гироскутер'=>'remont_giroskuterov',
        'электросамокат'=> 'remont_elektrosamokatov',
        'моноколесо' => 'remont_monokoles',
        'сегвей' => 'remont_segveev',
        'сушильная машина'=> 'remont_sushilnyh_mashin',
        'лазерный принтер'=>'remont_lazernyh_printerov',
        'наушники'=>'remont_naushnikov',
        );

  public static function names($types) {
    return array_column($types, 'type');
  }

  public static function ids($types) {
    return array_column($types, 'type_id');
  }

}


?>
