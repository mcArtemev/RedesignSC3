<?

use framework\tools;

$site_id = $this->_site_id;

if ($this->_mode)
{
    $model_type = $this->_datas['model_type'][3];
}

$model_type_id = $this->_datas['model_type']['id'];

$marka_id = $this->_datas['marka']['id'];

if ($this->_mode == 2)
{
    $model_id = $this->_datas['model']['id'];
    $full_type_name = $model_type['name_re'].' '.$this->_datas['model']['name'];
    $full_name = $this->_datas['model']['name'];
}

if ($this->_mode == 3)
{
    $full_name = $full_type_name = $model_type['name_re'].' '.$this->_datas['marka']['name'];
}

if ($this->_mode == 0)
{
    $full_name = $full_type_name = $this->_datas['marka']['name'];
}

$setka_name = $this->_datas['setka_name'];

$eds = $this->_datas['eds'];
$availables = $this->_datas['availables']; 

$vals = $this->_datas['vals'];

$dop_reasons = isset($this->_datas['dop_reasons']) ? $this->_datas['dop_reasons'] : array();        
$dop_services = isset($this->_datas['dop_services']) ? $this->_datas['dop_services'] : array();
$other_defects = isset($this->_datas['other_defects']) ? $this->_datas['other_defects'] : array();
$region_code = ($this->_datas['region']['code']) ? '-'.$this->_datas['region']['code'] : '';
    
$defect_price = tools::format_price($this->_datas['price'], $setka_name);

$accord_image = $this->_datas['accord_image'];
$this->_ret['img'] = 'wp-content/uploads/2015/03/'.$marka_lower.'/'.$accord_image[$this->_datas['orig_model_type']['0']['name']].$region_code.'.png';
$metrica = $this->_datas['metrica'];

srand($this->_datas['feed']);

    // Неисправности М
    if ($this->_mode == 2)
    {

        $model_type_re = $this->_datas['model_type'][3]['name_rm']; // тип устройства
        $model_name = $this->_datas['model']['name']; // модель
        $marka = $this->_datas['marka']['name'];  // SONY
        $servicename = $this->_datas['servicename']; //SONY Russia
        $region_name = $this->_datas['region']['name'];//Москва
        $region_name_a = $this->_datas['region']['translit1'];// Omsk

        $gen = array();
        $gen[0][] = array("Информация о причинах неисправности","Причины неисправности","Симптомы неисправности","Возможные причины неисправности","Частые симптомы неисправности",
            "Популярные симптомы неисправности","Популярные причины неисправности","Частые причины неисправности","Информация о причинах неисправности",
            "Причины возникновения неисправности","Симптомы возникновения неисправности","Причины появления неисправности","Симптомы появления неисправности",
            "Причины возникновения проблемы","Симптомы возникновения проблемы","Причины проблемы","Симптомы проблемы","Возможные причины проблемы",
            "Частые симптомы проблемы","Популярные симптомы проблемы","Популярные причины проблемы","Частые причины проблемы","Информация о причинах проблемах",
            "Причины возникновения проблемы","Симптомы возникновения проблемы","Причины появления проблемы","Симптомы появления проблемы","Информация о причинах данной неисправности",
            "Причины данной неисправности","Симптомы данной неисправности","Возможные причины данной неисправности","Частые симптомы данной неисправности",
            "Популярные симптомы данной неисправности","Популярные причины данной неисправности","Частые причины данной неисправности","Информация о причинах неисправности",
            "Причины возникновения данной неисправности","Симптомы возникновения данной неисправности","Причины появления данной неисправности",
            "Симптомы появления данной неисправности","Причины возникновения данной проблемы","Симптомы возникновения данной проблемы","Причины данной проблемы",
            "Симптомы данной проблемы","Возможные причины данной проблемы","Частые симптомы данной проблемы","Популярные симптомы данной проблемы","Популярные причины данной проблемы",
            "Частые причины данной проблемы","Информация о причинах данной проблемы","Причины возникновения данной проблемы","Симптомы возникновения данной проблемы",
            "Причины появления данной проблемы","Симптомы появления данной проблемы");
        $gen[1][] = array("Другие","Остальные","Прочие","Иные");
        $gen[1][] = array("причины","причины этой","");
        $gen[1][] = array("поломки","неисправности","проблемы");
        $gen[2][] = array("Другое","Остальное","Прочее");
        $gen[2][] = array("непопулярные","нераспространенные");
        $gen[2][] = array("поломки","неисправности","проблемы","причины");

        // echo $this->checkcolumn($gen[0]); // h2 переменная

        //монетка для Последняя строка в неисправностях
        $gen_last_rand = rand(1,2);
        // выдаёт "Последняя строка в неисправностях"
        if($gen_last_rand == 1)
        {
            $gen_last_a = $this->checkarray($gen[1]);
        }
        if($gen_last_rand == 2)
        {
            $gen_last_a = $this->checkarray($gen[2]);
        }

        // второй h2
        $gen_h2 = array();
        $gen_h2[0][] = array("Услуги,","Работы,");
        $gen_h2[0][] = array("которые могут потребоваться","которые могут понадобиться","которые могут быть актуальны","которые могут быть нужны",
            "которые может потребоваться проводить","которые может потребоваться выполнять","которые может понадобиться проводить",
            "которые может понадобиться выполнять","которые может потребоваться производить","которые может понадобиться производить");

        // кидаем монетку 1 или 2 во втором h2
        $gen_h2_rand = rand(1,2);
        // в $gen_h2_выдаёт одно из двух значний второго h2
        if($gen_h2_rand == 1)
        {
            $gen_h2_a = $this->checkarray($gen_h2[0]);
        }
        if($gen_h2_rand == 2)
        {
            $gen_h2[1][] = array("Вероятно возможные","Возможные");
            $gen_h2[1][] = array("услуги","работы");
            $gen_h2[1][] = array("по ремонту","по ремонту $model_type_re $model_name","по ремонту $model_name","по ремонту $model_type_re","");

            $gen_h2_orange = $this->checkcolumn($gen_h2[1][2]);
            $gen_h2_a = $this->checkcolumn($gen_h2[1][0]) . " " . $this->checkcolumn($gen_h2[1][1]) . " " . $gen_h2_orange;
        }
        //третий h2
        $gen_h2_3 = array();
        $gen_h2_3[] = array("Информация о","Информация о других","Информация о других частых","Информация о распространенных","Дополнительная информация о",
            "Дополнительная информация о других","Дополнительная информация о других частых","Дополнительная информация о распространенных");
        $gen_h2_3[] = array("неисправностях","проблемах","поломках");
        $gen_h2_3[] = array("$model_type_re $model_name","$model_name","","$model_type_re");

        // выдаём третий h2 в $gen_h2_3_a

        if($gen_h2_rand == 2) // удаляем из третьего h2 повторные значения
        {
            if ($gen_h2_orange == "по ремонту $model_type_re $model_name")
            {
                unset($gen_h2_3[2][0]);
                unset($gen_h2_3[2][1]);
            }
            if ($gen_h2_orange == "по ремонту $model_name")
            {
                unset($gen_h2_3[2][0]);
                unset($gen_h2_3[2][1]);
            }
            if ($gen_h2_orange == "")
            {
                unset($gen_h2_3[2][2]);
            }
        }
        $gen_h2_3_a = $this->checkarray($gen_h2_3);

        //вывод последний а
        $gen_h2_last_a = array();
        $gen_h2_last_a[] = array("Самые","");
        $gen_h2_last_a[] = array("распространенные","частые","часто встречающиеся");
        $gen_h2_last_a_rand = rand(1,2);
        if($gen_h2_last_a_rand == 1)
        {
            $gen_h2_last_a[] = array("неисправности","проблемы","поломки");
            $gen_h2_last_a[] = array("$model_type_re $model_name,","$model_name,","$model_type_re,");
            if($gen_h2_rand == 2) // даляем из третьего h2 повторные значения
            {
                if ($gen_h2_orange == "по ремонту $model_type_re $model_name")
                {
                    unset($gen_h2_last_a[3][0]);
                    unset($gen_h2_last_a[3][1]);
                }
                if ($gen_h2_orange == "по ремонту $model_name")
                {
                    unset($gen_h2_last_a[3][0]);
                    unset($gen_h2_last_a[3][1]);
                }
                if ($gen_h2_orange == "$model_type_re")
                {
                    unset($gen_h2_last_a[3][2]);
                }
            }
        }
        if($gen_h2_last_a_rand == 2)
        {
            $gen_h2_last_a[] = array("неисправности,","проблемы,","поломки,");
            $gen_h2_last_a[] = array("");
        }


        /*if($gen_h2_rand == 2) // даляем из третьего h2 повторные значения
        {
            if ($gen_h2_orange == "по ремонту $model_type_re $model_name")
            {
                unset($gen_h2_last_a[3][0]);
            }
            if ($gen_h2_orange == "по ремонту $model_name")
            {
                unset($gen_h2_last_a[3][1]);
            }
            if ($gen_h2_orange == "")
            {
                unset($gen_h2_last_a[3][2]);
            }

        }*/
        // кидаем монетку и выбираем какой из трёх вариантов
        $gen_h2_last_a_temporary = rand(1,3);
        if($gen_h2_last_a_temporary == 1)
        {
            $gen_h2_last_a[] = array("которые");
            $gen_h2_last_a[] = array("наши специалисты","наши мастера","наши сервисные мастера","наши сервисные специалисты","специалисты","мастера",
                "сервисные мастера","сервисные специалисты","специалисты нашего сервиса","мастера нашего сервиса","сервисные мастера нашего сервиса",
                "сервисные специалисты нашего сервиса","специалисты нашего центра","мастера нашего центра","сервисные мастера нашего центра",
                "сервисные специалисты нашего центра","специалисты $servicename","мастера $servicename","сервисные мастера $servicename",
                "сервисные специалисты $servicename","специалисты сервиса $servicename","мастера сервиса $servicename","сервисные мастера сервиса $servicename",
                "сервисные специалисты сервиса $servicename","специалисты центра $servicename","мастера центра $servicename","сервисные мастера центра $servicename",
                "сервисные специалисты центра $servicename","специалисты $servicename $region_name_a","мастера $servicename $region_name_a",
                "сервисные мастера $servicename $region_name_a","сервисные специалисты $servicename $region_name_a","специалисты сервиса $servicename $region_name_a",
                "мастера сервиса $servicename $region_name_a","сервисные мастера сервиса $servicename $region_name_a","сервисные специалисты сервиса $servicename $region_name_a",
                "специалисты центра $servicename $region_name_a","мастера центра $servicename $region_name_a","сервисные мастера центра $servicename $region_name_a",
                "сервисные специалисты центра $servicename $region_name_a");
            $gen_h2_last_a[] = array("ремонтируют","чинят","устраняют","исправляют");
            $gen_h2_last_a[] = array("в нашей лаборатории","в нашей мастерской");
            $gen_h2_last_a[] = array("регулярно","еженедельно","ежемесячно");
        }
        if($gen_h2_last_a_temporary == 2)
        {
            $gen_h2_last_a[] = array("которые");
            $gen_h2_last_a[] = array("мы");
            $gen_h2_last_a[] = array("ремонтируем","чиним","восстанавливаем");
            $gen_h2_last_a[] = array("в нашей лаборатории","в нашей мастерской");
            $gen_h2_last_a[] = array("регулярно","еженедельно","ежемесячно");
        }
        if($gen_h2_last_a_temporary == 3)
        {
            $gen_h2_last_a[] = array("с которыми");
            $gen_h2_last_a[] = array("аппараты","устройства","$model_type_re","техника","аппараты");
            $gen_h2_last_a[] = array("этой модели","");
            $gen_h2_last_a[] = array("поступают","приносят");
            $gen_h2_last_a[] = array("в наш сервис","к нашему сервису","на ремонт","на восстановление");
        }
        // выводим последнее значение в $gen_h2_last_a_conclusion
        $gen_h2_last_a_conclusion = $this->checkarray($gen_h2_last_a);
    }

    // Неисправности Т
    if ($this->_mode == 3)
    {
        $model_type_re = $this->_datas['model_type'][3]['name_rm']; // тип устройства
        $model_type_m = $this->_datas['model_type'][3]['name_m'];
        $marka = $this->_datas['marka']['name'];  // SONY
        $servicename = $this->_datas['servicename']; //SONY Russia
        $region_name = $this->_datas['region']['name'];//Москва
        $region_name_a = $this->_datas['region']['translit1'];// Omsk
        $gen_t = array();
        $gen_t[] = array("Информация о причинах неисправности","Причины неисправности","Симптомы неисправности","Возможные причины неисправности",
            "Частые симптомы неисправности","Популярные симптомы неисправности","Популярные причины неисправности","Частые причины неисправности",
            "Информация о причинах неисправности","Причины возникновения неисправности","Симптомы возникновения неисправности","Причины появления неисправности",
            "Симптомы появления неисправности","Причины возникновения проблемы","Симптомы возникновения проблемы","Причины проблемы","Симптомы проблемы",
            "Возможные причины проблемы","Частые симптомы проблемы","Популярные симптомы проблемы","Популярные причины проблемы","Частые причины проблемы",
            "Информация о причинах проблемах","Причины возникновения проблемы","Симптомы возникновения проблемы","Причины появления проблемы",
            "Симптомы появления проблемы","Информация о причинах данной неисправности","Причины данной неисправности","Симптомы данной неисправности",
            "Возможные причины данной неисправности","Частые симптомы данной неисправности","Популярные симптомы данной неисправности","Популярные причины данной неисправности",
            "Частые причины данной неисправности","Информация о причинах неисправности","Причины возникновения данной неисправности","Симптомы возникновения данной неисправности",
            "Причины появления данной неисправности","Симптомы появления данной неисправности","Причины возникновения данной проблемы","Симптомы возникновения данной проблемы",
            "Причины данной проблемы","Симптомы данной проблемы","Возможные причины данной проблемы","Частые симптомы данной проблемы","Популярные симптомы данной проблемы",
            "Популярные причины данной проблемы","Частые причины данной проблемы","Информация о причинах данной проблемы","Причины возникновения данной проблемы",
            "Симптомы возникновения данной проблемы","Причины появления данной проблемы","Симптомы появления данной проблемы");

        // вывод первого h2
        ///echo $this->checkarray($gen_t);

        $gen_t_h2 = array();
        $gen_t_h2[0][] = array("Услуги,","Работы,");
        $gen_t_h2[0][] = array("которые могут потребоваться","которые могут понадобиться","которые могут быть актуальны","которые могут быть нужны",
        "которые может потребоваться проводить","которые может потребоваться выполнять","которые может понадобиться проводить",
        "которые может понадобиться выполнять");
        $gen_t_h2[1][] = array("Вероятно возможные","Возможные");
        $gen_t_h2[1][] = array("услуги","работы");
        $gen_t_h2[1][] = array("по ремонту","по ремонту $model_type_re","");

        // Кидаем монетку для второго h2 и выводим в $gen_t_h2_rand_a
        $gen_t_h2_rand = rand(1,2);
        if($gen_t_h2_rand == 1)
        {
            $gen_t_h2_rand_a = $this->checkarray($gen_t_h2[0]);
        }

        if($gen_t_h2_rand == 2)
        {
            //  в $gen_t_h2_rand_a_temporary храним то что выпало во втором варианте , нужно для удаления третьего h2 и а
            $gen_t_h2_rand_a_temporary = $this->checkcolumn($gen_t_h2[1][2]);
            $gen_t_h2_rand_a = $this->checkcolumn($gen_t_h2[1][0]) . " " . $this->checkcolumn($gen_t_h2[1][1]) . " " . $gen_t_h2_rand_a_temporary;
        }

        $gen_t_h2_3 = array();
        $gen_t_h2_3[] = array("Информация о","Информация о других","Информация о других частых","Информация о распространенных","Дополнительная информация о",
            "Дополнительная информация о других","Дополнительная информация о других частых","Дополнительная информация о распространенных");
        $gen_t_h2_3[] = array("неисправностях","проблемах","поломках");
        $gen_t_h2_3[] = array("$model_type_re","");


        $gen_t_h2_a = array();
        $gen_t_h2_a[] = array("Самые","");
        $gen_t_h2_a[] = array("распространенные","частые","часто встречающиеся");

        $gen_t_h2_a_rand_zpt = rand(1,2);
        if($gen_t_h2_a_rand_zpt == 1)
        {
            $gen_t_h2_a[] = array("неисправности,","проблемы,","поломки,");
            $gen_t_h2_a[] = array("");
        }
        if($gen_t_h2_a_rand_zpt == 2)
        {
            $gen_t_h2_a[] = array("неисправности","проблемы","поломки");
            $gen_t_h2_a[] = array("$model_type_re,");
        }

        $gen_t_h2_a_rand = rand(1,3);
        if($gen_t_h2_a_rand == 1)
        {
            $gen_t_h2_a[] = array("которые");
            $gen_t_h2_a[] = array("наши специалисты","наши мастера","наши сервисные мастера","наши сервисные специалисты","специалисты","мастера","сервисные мастера",
                "сервисные специалисты","специалисты нашего сервиса","мастера нашего сервиса","сервисные мастера нашего сервиса","сервисные специалисты нашего сервиса",
                "специалисты нашего центра","мастера нашего центра","сервисные мастера нашего центра","сервисные специалисты нашего центра",
                "специалисты $servicename","мастера $servicename","сервисные мастера $servicename","сервисные специалисты $servicename","специалисты сервиса $servicename",
                "мастера сервиса $servicename","сервисные мастера сервиса $servicename","сервисные специалисты сервиса $servicename","специалисты центра $servicename",
                "мастера центра $servicename","сервисные мастера центра $servicename","сервисные специалисты центра $servicename","специалисты $servicename $region_name_a",
                "мастера $servicename $region_name_a","сервисные мастера $servicename $region_name_a","сервисные специалисты $servicename $region_name_a",
                "специалисты сервиса $servicename $region_name_a","мастера сервиса $servicename $region_name_a","сервисные мастера сервиса $servicename $region_name_a",
                "сервисные специалисты сервиса $servicename $region_name_a","специалисты центра $servicename $region_name_a","мастера центра $servicename $region_name_a",
                "сервисные мастера центра $servicename $region_name_a","сервисные специалисты центра $servicename $region_name_a");
            $gen_t_h2_a[] = array("ремонтируют","чинят","устраняют");
            $gen_t_h2_a[] = array("в нашей лаборатории","в нашей мастерской");
            $gen_t_h2_a[] = array("регулярно","еженедельно","ежемесячно");
        }
        if($gen_t_h2_a_rand == 2)
        {
            $gen_t_h2_a[] = array("которые");
            $gen_t_h2_a[] = array("мы");
            $gen_t_h2_a[] = array("ремонтируем","чиним","восстанавливаем");
            $gen_t_h2_a[] = array("в нашей лаборатории","в нашей мастерской");
            $gen_t_h2_a[] = array("регулярно","еженедельно","ежемесячно");
        }
        if($gen_t_h2_a_rand == 3)
        {
            $gen_t_h2_a[] = array("с которыми");
            $gen_t_h2_a[] = array("аппараты","устройства",$model_type_m,"техника","аппараты");
            $gen_t_h2_a[] = array("этой модели","");
            $gen_t_h2_a[] = array("поступают","приносят");
            $gen_t_h2_a[] = array("в наш сервис","к нашему сервису","на ремонт","на восстановление");
        }

        if($gen_t_h2_rand == 2)
        {
            if($gen_t_h2_rand_a_temporary == $gen_t_h2[1][2][0])
            {
                unset($gen_t_h2_3[2][1]);
                unset($gen_t_h2_a[3][1]);
            }

            if($gen_t_h2_rand_a_temporary == $gen_t_h2[1][2][1])
            {
                $gen_t_h2_3_unset = rand(1,2);

                if($gen_t_h2_3_unset == 1 )
                {
                    unset($gen_t_h2_3[2][0]);
                    unset($gen_t_h2_a[3][1]);
                }
                if($gen_t_h2_3_unset == 2 && $gen_t_h2_a_rand_zpt == 2)
                {
                    unset($gen_t_h2_3[2][1]);
                    //unset($gen_t_h2_a[3][0]);
                }
                //echo "<br>";
                //print_r($gen_t_h2_3_unset);
            }

            /*if($gen_t_h2_rand_a_temporary == $gen_t_h2[1][2][2])
            {
                unset($gen_t_h2_3[2][1]);
                unset($gen_t_h2_a[3][1]);
            }*/
        }
    }

    // генерация процентов
    $percent_max = round(rand(69,93)/count($dop_reasons));
    $percent_summ = 0;
    $percent_array = array();
    for($i=0;$i<count($dop_reasons);$i++)
    {
        $percent_array[] = array($percent_max);
    }


    for($i=0;$i<7;$i++)
    {
        $rand_keys = array_rand($percent_array, 2);

        $rand_a = rand(1,7);
        if($percent_array[$rand_keys[1]][0]- $rand_a >7)
        {
            $percent_array[$rand_keys[0]][0] = $percent_array[$rand_keys[0]][0] + $rand_a;
            $percent_array[$rand_keys[1]][0] = $percent_array[$rand_keys[1]][0] - $rand_a;
        }
    }

    for($i = 0; $i < count($percent_array); $i++) {
        for($j = 0; $j < count($percent_array[$i]); $j++) {
            $percent_summ += $percent_array[$i][$j];
        }
    }
    $percent_summ = 100 - $percent_summ;

    $last_line_in_malfunctions = array();
    $last_line_in_malfunctions_rand = rand(1,2);

    if($last_line_in_malfunctions_rand == 1)
    {
        $last_line_in_malfunctions[] = array("Другие","Остальные","Прочие","Иные");
        $last_line_in_malfunctions_rand2 = rand(1,2);

        if($last_line_in_malfunctions_rand2 == 1)
        {
            $last_line_in_malfunctions[] = array("причины","причины этой","");
            $last_line_in_malfunctions[] = array("поломки","неисправности","проблемы");
        }

        if($last_line_in_malfunctions_rand2 == 2)
        {
            $last_line_in_malfunctions[] = array("непопулярные","нераспространенные");
            $last_line_in_malfunctions[] = array("поломки","неисправности","проблемы","причины");
        }
    }

    if($last_line_in_malfunctions_rand == 2)
    {
        $last_line_in_malfunctions[] = array("Другое","Остальное","Прочее");
    }
    
$use_choose_city = $this->_datas['use_choose_city'];
$add_class = ($use_choose_city) ? " js-choose-city" : "";

?>

    <div class="sr-main target">
        <div class="uk-width-medium-1-1 bgcolorwhite uk-hidden-small breadcrumbs">
            <div class="uk-container-center uk-container">
                <? if ($this->_mode == 2): ?>
                    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/" class="uk-icon-home uk-text-muted"><meta itemprop="title" content="Главная"/></a></span>
                    &nbsp;/&nbsp;
                    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/"><span itemprop="title">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?></span></a></span>
                    &nbsp;/&nbsp;
                    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('model_id' => $model_id)))?>/"><span itemprop="title">Ремонт <?=$this->_datas['model']['name']?></span></a></span>
                    &nbsp;/&nbsp;
                    <span class="uk-text-muted"><?=tools::mb_firstupper($this->_datas['syns'][3])?></span>
                <? endif; ?>
                <? if ($this->_mode == 3): ?>
                    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/" class="uk-icon-home uk-text-muted"><meta itemprop="title" content="Главная"/></a></span>
                    &nbsp;/&nbsp;
                    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/"><span itemprop="title">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?></span></a></span>
                    &nbsp;/&nbsp;
                    <span class="uk-text-muted"><?=tools::mb_firstupper($this->_datas['syns'][3])?></span>
                <? endif; ?>
            </div>
        </div>
        
        <div class="uk-width-medium-1-1 bgcolorwhite uk-visible-small<?=$add_class?>">
            <div class="uk-container-center uk-container">
               <a href="tel:+<?=$phone?>" class="uk-text-muted"><?=$phone_format?></a>
            </div>
        </div>
        
        <div class="uk-container-center uk-container" itemscope itemtype="http://schema.org/Product">
            <div class="uk-grid uk-margin-remove" data-uk-grid-margin>
                <div class="uk-width-medium-4-10 ">
                    <img itemprop="image" src="/<?=$this->_ret['img']?>" class="uk-margin-top uk-align-center">
                </div>
                <div class="uk-width-medium-6-10 whiteblock ">
                    <h1 itemprop="name"><?=$this->_ret['h1']?></h1>
                    <span itemprop="description"><?=$this->_ret['text']?></span>
                    <p class="textPrice" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                        <span class="uk-align-left uk-text-large target-price" itemprop="price">от <?=$defect_price?> руб.</span>
                        <meta itemprop="priceCurrency" content="RUB"/>
                        <span class="uk-align-right"><input type="button" data-uk-modal="{target:'#popup'}" class=" uk-button  uk-button-large uk-button-success uk-margin-right" onclick="if (typeof window['yaCounter<?=$metrica?>'] !== 'undefined') yaCounter<?=$metrica?>.reachGoal('ORDER'); return false;" value="Записаться на ремонт"/></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="sr-content">
        <div class="uk-container-center uk-container uk-margin-bottom">
            <div class="uk-flex sr-contetnt-block uk-margin-top sr-content-main">
                <div class="uk-width-large-7-10 sr-content-white ">
                 <? if ($dop_reasons):?>
                    <p class="uk-h2 uk-margin-top">
                        <?
                            if ($this->_mode == 2)
                            {
                                echo $this->checkarray($gen[0]);
                            }
                            if ($this->_mode == 3)
                            {
                                echo $this->checkarray($gen_t);
                            }
                        ?>
                    </p>
                      <table class="priceTable uk-table uk-table-striped defect">
                        <tbody>
                        <?  $i=0; 
                            foreach ($dop_reasons as $value):?>
                             <tr<?=((!$i) ? ' class="green"' : '')?>>
                                <td><?=tools::mb_firstupper($value)?></td>
                                <td><?=$percent_array[$i][0] . " %"?></td>
                             </tr>
                            <? $i++;
                            endforeach; ?>
                        <tr>
                            <td><?=$this->checkarray($last_line_in_malfunctions)?></td>
                            <td><?="$percent_summ %"?></td>
                        </tr>
                        </tbody>
                      </table>
                  <? endif;?>

                 <?if ($dop_services):?>
                    <p class="uk-h2 uk-margin-medium-top">
                        <?
                        if ($this->_mode == 2)
                        {
                            echo $gen_h2_a;
                        }
                        if ($this->_mode == 3)
                        {
                            echo $gen_t_h2_rand_a;
                        }
                        ?>
                    </p>
                    
                    <table class="priceTable uk-table uk-table-hover uk-table-striped services">
                        <tbody>
                            <tr class="uk-text-small">
                                <th>Наименование услуги</th>
                                <th class="uk-text-center">Время ремонта, мин</th>
                                <th class="uk-text-center">Цена, руб</th>
                            </tr>
                            <? 
                            foreach ($dop_services as $value):?>
                            <? 
                               if ($this->_mode == 2) 
                                    $href = tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));
                                    
                               if ($this->_mode == 3) 
                                    $href = tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));
                            ?>
                            <tr>
                                <td><a href="/<?=$href?>/"><?=tools::mb_firstupper($value['name'])?></a></td>
                                <td><?=tools::format_time($value['time_min'], $value['time_max'], $eds[$value[$this->_suffics.'_service_id']]['ed_time'], $setka_name)?></td>
                                <td><?=tools::format_price($value['price'], $setka_name)?></td>
                           </tr>
                        <? endforeach;?>
                    </tbody>
                 </table>
                 <? endif;?>                 
                       
                <? include __DIR__.'/form_new.php'; ?>
                
                <p class="uk-h2 uk-margin-medium-top">
                    <?
                    if ($this->_mode == 2)
                    {
                        echo $gen_h2_3_a;
                    }
                    if ($this->_mode == 3)
                    {
                        echo $this->checkarray($gen_t_h2_3);
                    }
                    ?>
                </p>
                <? if ($other_defects):?>    
                
                    <p class="uk-h3">
                        <?
                        if ($this->_mode == 2)
                        {
                            echo $this->firstup(trim($gen_h2_last_a_conclusion));
                        }
                        if ($this->_mode == 3)
                        {
                            echo $this->firstup(trim($this->checkarray($gen_t_h2_a)));
                        }
                        ?>
                    </p>
                    <div class="uk-grid uk-grid-small uk-grid-match popular" data-uk-grid-margin="" data-uk-grid-match="{target:'.uk-panel'}">
                    
                    <? foreach ($other_defects as $key => $value):?>
                    <? 
                        if ($this->_mode == 2)  
                            $href = tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'defect', 'id' => $value[$this->_suffics.'_defect_id'])));  
                                
                        if ($this->_mode == 3) 
                            $href = tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'defect', 'id' => $value[$this->_suffics.'_defect_id'])));    
                    ?>
                        <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-2">
                           <div class="uk-panel uk-panel-box uk-text-center uk-grid-match uk-vertical-align">
                                <a class="uk-vertical-align-middle" href="/<?=$href?>/"><?=tools::mb_firstupper($value['name'])?></a>
                            </div>
                        </div>
                    <? endforeach; ?> 
                    </div>          
                <? endif; ?> 
                
                <?
                    if ($this->_mode == 2) 
                        $href = tools::search_url($site_id, serialize(array('model_id' => $model_id))); 
                    
                    if ($this->_mode == 3) 
                        $href = tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)));                      
                 ?>
                 <div class="uk-panel uk-panel-box uk-text-center uk-margin-top">
                        <a href="/<?=$href?>/">Все комплектующие и услуги по ремонту <?=$full_name?></a>
                 </div> 
                </div>
                <? include __DIR__.'/right_part_new.php'; ?>  
            </div>
        </div>
    </div>