<?

namespace framework\ajax\edit_table\hooks;

use framework\pdo;
use framework\tools;

class gen_level
{
    public function beforeAdd(&$args)
    {
        //delete!!

        //setka
        $sql = "SELECT `setkas`.`name` FROM `sites` INNER JOIN `setkas` ON `sites`.`setka_id` = `setkas`.`id` WHERE `sites`.`id`=:site_id";
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array('site_id' => $args['site_id']));
        $setka_name = $stm->fetchColumn();

        //model_types && markas
        $sql = "SELECT  `model_types`.`name` AS  `model_type_name` , `markas`.`name` AS  `marka_name`,
                    `markas`.`id` AS `marka_id`, `model_types`.`id` AS `model_type_id`
                FROM  `model_to_sites`
                INNER JOIN  `models` ON  `models`.`id` =  `model_to_sites`.`model_id`
                INNER JOIN  `m_models` ON  `m_models`.`id` =  `models`.`m_model_id`
                INNER JOIN  `model_types` ON  `model_types`.`id` =  `m_models`.`model_type_id`
                INNER JOIN  `markas` ON  `markas`.`id` =  `m_models`.`marka_id`
                WHERE  `model_to_sites`.`site_id`=:site_id
                    GROUP BY `model_type_name`, `marka_name`";

        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array('site_id' => $args['site_id']));
        $datas = $stm->fetchAll(\PDO::FETCH_ASSOC);

        $markas = array();
        $marka_ids = array();
        $model_types = array();
        $model_type_ids = array();
        $mas_url = array();
        $insert_urls = array();

        if ($datas)
        {
            foreach ($datas as $data)
            {
                $markas[$data['marka_name']] = true;
                $marka_ids[$data['marka_name']] = $data['marka_id'];

                $model_types[$data['model_type_name']] = true;
                $model_type_ids[$data['model_type_name']] = $data['model_type_id'];
            }

            $markas = (array) array_keys($markas);
            $model_types = (array) array_keys($model_types);

            $table_mases = array();
            foreach ($model_types as $model_type)
                $table_mases[$model_type_ids[$model_type]] = tools::get_codes(tools::get_suffics($model_type));

            $urls = array();
            $codes = array();
        }
        else
        {
            $sql = "SELECT `markas`.`id` as `id`, `markas`.`name` as `name` FROM `marka_to_sites`
                        INNER JOIN `markas` ON `markas`.`id` = `marka_to_sites`.`marka_id` WHERE `site_id`=:site_id";
            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array('site_id' => $args['site_id']));
            $t = array();
            $datas = $stm->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($datas as $value)
                $t[$value['name']] = $value['id'];
            $marka_ids = $t;
        }

        $pass = false;

        switch ($setka_name)
        {
            case 'СЦ-1': case 'СЦ-1Б':

                foreach ($markas as $marka_name)
                {
                    foreach ($table_mases as $type => $table_mas)
                    {
                        foreach ($table_mas as $key => $mas)
                        {
                            foreach ($mas as $value)
                            {
                                $code = ($value['name2'] ? $value['name2'] : $value['name']).'-'.tools::translit($marka_name);
                                $urls[] = $code;
                                $codes[$code][] = array($key, (integer) $value['id'], (integer) $marka_ids[$marka_name], (integer) $type);
                            }
                        }
                    }
                }

                $static = array('/', 'diagnostika', 'dostavka', 'sroki', 'ceny', 'zapchasti', 'kontakty', 'otpravleno','o-nas');
                // $static = array('o-nas');

                $urls = array(
                    'acer' => array('remont-naushnikov','remont-monoblokov','remont-proektorov', 'remont-kompyuterov', 'remont-televizorov', 'remont-monitorov'),
                    'alcatel' => array('remont-telefonov','remont-smartfonov'),
                    'apple' => array('remont-naushnikov','remont-monoblokov', 'remont-apple-watch', 'remont-kompyuterov', 'remont-televizorov', 'remont-printerov', 'remont-monitorov'),
                    'ariston' => array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin'),
                    'asus' => array('remont-naushnikov','remont-monoblokov', 'remont-materinskih-plat', 'remont-kompyuterov', 'remont-televizorov', 'remont-monitorov','remont-proektorov'),
                    'bbk' => array('remont-televizorov'),
                    'bosch' => array('remont-holodilnikov','remont-stiralnyh-mashin','remont-pylesosov','remont-posudomoechnyh-mashin'),
                    'canon' => array('remont-printerov', 'remont-fotoapparatov','remont-proektorov', 'remont-monitorov'),
                    'compaq' => array('remont-monoblokov', 'remont-kompyuterov', 'remont-monitorov'),
                    'dell' => array('remont-naushnikov','remont-monoblokov','remont-proektorov', 'remont-kompyuterov', 'remont-printerov', 'remont-monitorov'),
                    'electrolux' => array('remont-holodilnikov', 'remont-stiralnyh-mashin','remont-posudomoechnyh-mashin'),
                    'epson' => array('remont-printerov','remont-proektorov', 'remont-televizorov'),
                	'fly' => array('remont-telefonov','remont-smartfonov'),
                	'hp' => array('remont-naushnikov','remont-monoblokov', 'remont-kompyuterov', 'remont-printerov', 'remont-televizorov', 'remont-monitorov','remont-proektorov'),
                	'indesit' => array('remont-holodilnikov', 'remont-stiralnyh-mashin','remont-posudomoechnyh-mashin'),
                	'lenovo' => array('remont-naushnikov','remont-monoblokov', 'remont-kompyuterov', 'remont-televizorov', 'remont-printerov', 'remont-monitorov','remont-proektorov'),
                	'lg' => array('remont-naushnikov','remont-televizorov','remont-proektorov', 'remont-kompyuterov', 'remont-printerov', 'remont-monitorov'),
                	'msi' => array('remont-naushnikov','remont-monoblokov', 'remont-materinskih-plat', 'remont-kompyuterov', 'remont-monitorov'),
                	'nikon' => array('remont-fotoapparatov'),
                	'panasonic' => array('remont-fotoapparatov', 'remont-holodilnikov', 'remont-televizorov', 'remont-printerov', 'remont-kompyuterov', 'remont-televizorov', 'remont-printerov'),
                	'philips' => array('remont-monitorov', 'remont-televizorov', 'remont-printerov', 'remont-pylesosov', 'remont-televizorov', 'remont-printerov', 'remont-monitorov'),
                	'samsung' => array('remont-naushnikov','remont-monoblokov', 'remont-monitorov', 'remont-televizorov', 'remont-samsung-gear', 'remont-kompyuterov', 'remont-printerov','remont-proektorov'),
                	'sony' => array('remont-naushnikov','remont-monoblokov', 'remont-ultrabukov', 'remont-pristavok', 'remont-fotoapparatov', 'remont-videocamer', 'remont-televizorov','remont-proektorov','remont-kompyuterov', 'remont-printerov'),
                	'xiaomi' => array('remont-televizorov', 'remont-noutbukov', 'remont-ekshen-kamer', 'remont-robotov-pylesosov', 'remont-naushnikov', 'remont-elektrosamokatov', 'remont-printerov','remont-proektorov'),
                    'nokia' => array('remont-naushnikov'),
        			'toshiba' => array('remont-naushnikov','remont-televizorov', 'remont-kompyuterov', 'remont-printerov', 'remont-monitorov','remont-proektorov'),
                    'candy' => array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin'),
                    'siemens' => array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin'),
                    'gorenje' => array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin'),
                    'hansa' => array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin'),
                    'zanussi' => array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin'),
                    'aeg' => array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin'),
                    'miele' => array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin'),
                    'atlant' => array('remont-holodilnikov','remont-stiralnyh-mashin'),
                    'kaiser' => array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin'),
                    'ardo' => array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin'),
                    'vestfrost' => array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin'),
                    'beko' => array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin'),
                    'htc' => array('remont-naushnikov','remont-televizorov'),
        			'huawei' => array('remont-naushnikov','remont-televizorov', 'remont-printerov'),
        			'vertu' => array('remont-naushnikov','remont-telefonov'),
                    'oneplus' => array('remont-naushnikov','remont-smartfonov'),
                    'zte' => array('remont-naushnikov','remont-proektorov'),
                    'meizu' => array('remont-naushnikov'),
                    // 'delonghi' => array('remont-coffee-machin','remont-posudomoechnyh-mashin','remont-pylesosov','remont-obogrevatelej'),
                    
                );

                if ($setka_name == 'СЦ-1Б')
                {
                    $urls['samsung'] = array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin');
                    $urls['lg'] = array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin');
                    $urls['delonghi'] = array('remont-coffee-machin','remont-posudomoechnyh-mashin','remont-pylesosov','remont-obogrevatelej');
                }

                foreach ($marka_ids as $marka_name => $marka_id)
                {
                    foreach ($static as $key)
                    {
                        $params = serialize(array('marka_id' => $marka_id, 'static' => $key));
                        $mas_url[] = array($args['site_id'], "'".$key."'",
                                "'".$params."'", tools::get_rand_dop());
                    }

                    if (isset($urls[mb_strtolower($marka_name)]))
                    {
                        foreach ($urls[mb_strtolower($marka_name)] as $url)
                        {
                            $params = serialize(array('marka_id' => $marka_id, 'static' => $url));
                            $mas_url[] = array($args['site_id'], "'".$url."'",
                                "'".$params."'", tools::get_rand_dop());
                        }
                    }
                }

                $pass = true;

            break;

            case 'СЦ-2':

                foreach ($markas as $marka_name)
                {
                    foreach ($table_mases as $type => $table_mas)
                    {
                        foreach ($table_mas as $key => $mas)
                        {
                            foreach ($mas as $value)
                            {
                                $code = $value['name'];
                                $urls[] = $code;
                                $codes[$code][] = array($key, (integer) $value['id'], (integer) $marka_ids[$marka_name], (integer) $type);
                            }
                        }
                    }
                }

                $static = array('/', 'order', 'diagnostics', 'services', 'delivery', 'price', 'contacts', 'ask', 'thank-you', 'politica');

                $urls = array(
                	"acer" => array('computers'),
                	"apple" => array('computers'),
                	"asus" => array('computers'),
                	"canon" => array('foto','all-in-one','printers'),
                	"dell" => array('desctops','computers'),
                	"hp" => array('computers','desctops','printers','all-in-one'),
                	"lenovo" => array('computers','desctops','servers'),
                	"msi" => array('computers'),
                	"nikon" => array('foto'),
                	"samsung" => array('computers'),
                	"sony" => array('computers','consoles','photo_video'),
                	"xiaomi" => array('tv', 'laptop'),
                    "nokia" => array('tablets'),
        	    );

                foreach ($marka_ids as $marka_name => $marka_id)
                {
                    foreach ($static as $key)
                    {
                        $params = serialize(array('marka_id' => $marka_id, 'static' => $key));
                        $mas_url[] = array($args['site_id'], "'".$key."'",
                                "'".$params."'", tools::get_rand_dop());
                    }

                    if (isset($urls[mb_strtolower($marka_name)]))
                    {
                        foreach ($urls[mb_strtolower($marka_name)] as $url)
                        {
                            $params = serialize(array('marka_id' => $marka_id, 'static' => $url));
                            $mas_url[] = array($args['site_id'], "'".$url."'",
                                "'".$params."'", tools::get_rand_dop());
                        }
                    }
                }

                /*foreach ($markas as $marka_name)
                {
                    $marka_id =(integer) $marka_ids[$marka_name];
                    $params = serialize(array('marka_id' => $marka_id, 'static' => 'status'));
                    $mas_url[] = array($args['site_id'], "'status'",
                                    "'".$params."'", tools::get_rand_dop());
                }*/

                $pass = true;

            break;

            case 'СЦ-3':

                $static = array('kontakty',
                    'o_nas', 'index', 'dostavka', 'vakansii', 'ceny');

                $static2 = array('neispravnosti', 'zapchasti', 'diagnostika');

                //$marka_ids['Acer'] = 4;
                //$marka_ids['Apple'] = 21;
                //$marka_ids['Asus'] = 3;
                //$marka_ids['Dell'] = 9;
                //$marka_ids['HP'] = 6;
                //$marka_ids['HTC'] = 10;
                //$marka_ids['Huawei'] = 17;
                //$marka_ids['Samsung'] = 2;
                //$marka_ids['Sony'] = 1;
                //$marka_ids['Toshiba'] = 7;
                //$marka_ids['Xiaomi'] = 18;
                //$marka_ids['Alcatel'] = 14;
                //$marka_ids['Electrolux'] = 29;
                //$marka_ids['Ariston'] = 24;
                //$marka_ids['BBK'] = 30;
                //$marka_ids['Canon'] = 23;
                //$marka_ids['Compaq'] = 15;
                //$marka_ids['Dexp'] = 38;
                //$marka_ids['Epson'] = 32;
                //$marka_ids['Fly'] = 16;
                //$marka_ids['Fujifilm'] = 71;
                //$marka_ids['Hasselblad'] = 72;
                //$marka_ids['LG'] = 12;
                //$marka_ids['MSI'] = 8;
                //$marka_ids['Nikon'] = 22;
                //$marka_ids['Nokia'] = 11;
                //$marka_ids['Olympus'] = 74;
                //$marka_ids['Panasonic'] = 26;
                //$marka_ids['Polaroid'] = 75;
                //$marka_ids['Prestigio'] = 58;
                //$marka_ids['Sigma'] = 76;
                //$marka_ids['Lenovo'] = 5;
                //$marka_ids['OnePlus'] = 55;
                //$marka_ids['Indesit'] = 33;
                //$marka_ids['BenQ'] = 35;
                //$marka_ids['Philips'] = 25;
                //$marka_ids['iconBIT'] = 46;
                //$marka_ids['Digma'] = 39;
                //$marka_ids['Leica'] = 73;
                //$marka_ids['ZTE'] = 66;
                //$marka_ids['AEG']=153;
                //$marka_ids['Ardo']=77;
                //$marka_ids['Atlant']=78;
                //$marka_ids['Bauknecht']=79;
                //$marka_ids['Beko']=80;
                //$marka_ids['Bosch']=81;
                //$marka_ids['Candy']=82;
                //$marka_ids['Gorenje']=83;
                //$marka_ids['Hansa']=84;
                //$marka_ids['Kaiser']=85;
                //$marka_ids['Kuppersberg']=86;
                //$marka_ids['Miele']=87;
                //$marka_ids['Neff']=88;
                //$marka_ids['Sharp']=89;
                //$marka_ids['Siemens']=90;
                //$marka_ids['Smeg']=91;
                //$marka_ids['Vestfrost']=92;
                //$marka_ids['Zanussi']=93;
                //$marka_ids['Blackmagic']=94;
                //$marka_ids['JVC']=95;
                //$marka_ids['Ricoh']=96;
                //$marka_ids['Brother']=97;
                //$marka_ids['GCC']=98;
                ////$marka_ids['Graphtec']=99;
                //$marka_ids['Mimaki']=100;
                //$marka_ids['Roland']=101;
                //$marka_ids['Silhouette']=102;
                //$marka_ids['Vicsign']=103;
                //$marka_ids['Barco']=104;
                //$marka_ids['Christie']=105;
                //$marka_ids['Cinemood']=106;
                //$marka_ids['Hitachi']=107;
                //$marka_ids['Infocus']=108;
                //$marka_ids['Kodak']=109;
                //$marka_ids['NEC']=110;
                //$marka_ids['Optoma']=111;
                //$marka_ids['ViewSonic']=112;
                //$marka_ids['Vivitek']=113;
                //$marka_ids['Xgimi']=114;
                //$marka_ids['Hiper']=115;
                //$marka_ids['Hoverbot']=116;
                //$marka_ids['Razor']=117;
                //$marka_ids['Zaxboard']=118;
                //$marka_ids['DJI']=119;
                //$marka_ids['Hubsan']=120;
                //$marka_ids['Walkera']=121;
                //$marka_ids['Xiro']=122;
                //$marka_ids['Airwheel']=123;
                //$marka_ids['Gotway']=124;
                //$marka_ids['Inmotion']=125;
                //$marka_ids['Kingsong']=126;
                //$marka_ids['Eltreco']=127;
                //$marka_ids['e-TWOW']=128;
                //$marka_ids['Globber']=129;
                //$marka_ids['Halten']=130;
                //$marka_ids['Kugoo']=131;
                //$marka_ids['Takasima']=132;
                //$marka_ids['Yamaguchi']=133;
                //$marka_ids['Ergonova']=134;
                //$marka_ids['Inada']=135;
                //$marka_ids['Casada']=136;
                //$marka_ids['Sensa']=137;
                //$marka_ids['Irest']=138;
                //$marka_ids['Us medica']=139;
                //$marka_ids['UNO']=140;
                //$marka_ids['EGO']=141;
                //$marka_ids['Gess']=142;
                //$marka_ids['Victoryfit']=143;
                //$marka_ids['Richter']=144;
                //$marka_ids['Restart']=145;
                //$marka_ids['Bork']=146;
                //$marka_ids['Sanyo']=147;
                //$marka_ids['Beurer']=148;
                //$marka_ids['Fujiiryoki']=149;
                //$marka_ids['Nvidia shield']=150;
                //$marka_ids['Microsoft']=151;
                //$marka_ids['Nintendo']=152;
                //$marka_ids['Meizu'] = 20;

                $urls = array(
                    'Acer' => array ('remont_computerov', 'remont_monitorov', 'remont_monoblockov', 'remont_projectorov', 'remont_televizorov','remont_smart_chasov'),
                    'Apple' => array ('remont_computerov', 'remont_monitorov', 'remont_monoblockov', 'remont_printerov', 'remont_televizorov','remont_smart_chasov'),
                    'Asus' => array ('remont_monitorov', 'remont_monoblockov','remont_projectorov','remont_smart_chasov'),
                    'Dell' => array ('remont_computerov', 'remont_monitorov', 'remont_monoblockov', 'remont_printerov', 'remont_projectorov'),
                    'HP' => array ('remont_computerov', 'remont_monitorov', 'remont_monoblockov', 'remont_printerov', 'remont_televizorov', 'remont_plotterov', 'remont_smart_chasov'),
                    'HTC' => array ('remont_televizorov','remont_smart_chasov'),
                    'Huawei' => array ('remont_televizorov','remont_smart_chasov'),
                    'Lenovo' => array ('remont_computerov', 'remont_monitorov', 'remont_monoblockov', 'remont_printerov', 'remont_televizorov','remont_smart_chasov', 'remont_projectorov'),
                    'Samsung' => array ('remont_computerov', 'remont_monitorov', 'remont_monoblockov', 'remont_printerov', 'remont_televizorov', 'remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin', 'remont_projectorov','remont_smart_chasov','remont_photoapparatov','remont_videocamer'),
                    'Sony' => array ('remont_computerov', 'remont_monitorov', 'remont_monoblockov', 'remont_printerov', 'remont_televizorov', 'remont_projectorov', 'remont_photoapparatov','remont_smart_chasov','remont_videocamer', 'remont_igrovyh_pristavok'),
                    'Toshiba' => array ('remont_computerov', 'remont_monitorov', 'remont_televizorov', 'remont_printerov', 'remont_holodilnikov', 'remont_stiralnyh_mashin', 'remont_projectorov'),
                    'Xiaomi' => array ('remont_photoapparatov', 'remont_printerov', 'remont_televizorov', 'remont_naushnikov', 'remont_projectorov', 'remont_smart_chasov', 'remont_kvadrokopterov', 'remont_sigveev', 'remont_elektrosamokatov','remont_monokolyos'),
                    'Alcatel' => array ('remont_telefonov', 'remont_planshetov','remont_smart_chasov'),
                    'Electrolux' => array('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'OnePlus' => array('remont_telefonov'),
                    'Ariston' => array('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'BBK' => array ('remont_televizorov'),
                    'Canon' => array ('remont_printerov', 'remont_photoapparatov', 'remont_monitorov', 'remont_projectorov',  'remont_plotterov', 'remont_videocamer'),
                    'Compaq' => array ('remont_computerov', 'remont_monitorov', 'remont_monoblockov', 'remont_noutbukov'),
                    'Dexp' => array ('remont_computerov', 'remont_monitorov', 'remont_naushnikov', 'remont_monoblockov', 'remont_noutbukov', 'remont_telefonov', 'remont_planshetov', 'remont_televizorov'),
                    'Epson' => array ('remont_printerov', 'remont_projectorov', 'remont_smart_chasov', 'remont_plotterov'),
                    'Fly' => array ('remont_telefonov'),
                    'Fujifilm' => array ('remont_photoapparatov','remont_projectorov'),
                    'Hasselblad' => array ('remont_photoapparatov'),
                    'Leica' => array ('remont_photoapparatov'),
                    'LG' => array ('remont_projectorov', 'remont_televizorov', 'remont_smart_chasov', 'remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'MSI' => array ('remont_computerov', 'remont_monitorov', 'remont_monoblockov'),
                    'Nikon' => array ('remont_photoapparatov'),
                    'Nokia' => array ('remont_planshetov', 'remont_smart_chasov'),
                    'Olympus' => array ('remont_photoapparatov'),
                    'Panasonic' => array ('remont_photoapparatov', 'remont_projectorov', 'remont_holodilnikov','remont_stiralnyh_mashin', 'remont_videocamer','remont_massazhnyh_kresel'),
                    'Polaroid' => array ('remont_photoapparatov'),
                    'Prestigio' => array ('remont_noutbukov', 'remont_telefonov', 'remont_televizorov'),
                    'Sigma' => array ('remont_photoapparatov'),
                    'ZTE' => array ('remont_planshetov','remont_smart_chasov'),
                    'Meizu' => array ('remont_smart_chasov'),
                    'Indesit' => array ( 'remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'BenQ'=> array ( 'remont_projectorov'),
                    'Philips'=> array('remont_smart_chasov', 'remont_projectorov'),
                    'iconBIT'=> array( 'remont_sigveev', 'remont_elektrosamokatov','remont_giroskuterov'),
                    'Digma'=> array('remont_giroskuterov'),
                    'AEG'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Ardo'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Atlant'=> array ('remont_holodilnikov', 'remont_stiralnyh_mashin'),
                    'Bauknecht'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Beko'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Bosch'=> array ('remont_smart_chasov','remont_holodilnikov', 'remont_stiralnyh_mashin'),
                    'Candy'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Gorenje'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Hansa'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Kaiser'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Kuppersberg'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Miele'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Neff'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Sharp'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Siemens'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Smeg'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Vestfrost'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Zanussi'=> array ('remont_holodilnikov', 'remont_posudomoechnyh_mashin', 'remont_stiralnyh_mashin'),
                    'Blackmagic'=> array ('remont_videocamer'),
                    'JVC'=> array ('remont_videocamer','remont_projectorov'),
                    'Ricoh'=> array ('remont_videocamer','remont_projectorov', 'remont_photoapparatov'),
                    'Brother'=> array ('remont_plotterov'),
                    'GCC'=> array ('remont_plotterov'),
                    'Graphtec'=> array ('remont_plotterov'),
                    'Mimaki'=> array ('remont_plotterov'),
                    'Roland'=> array ('remont_plotterov'),
                    'Silhouette'=> array ('remont_plotterov'),
                    'Vicsign'=> array ('remont_plotterov'),
                    'Barco'=> array ('remont_projectorov'),
                    'Christie'=> array ('remont_projectorov'),
                    'Cinemood'=> array ('remont_projectorov'),
                    'Hitachi'=> array ('remont_projectorov'),
                    'Infocus'=> array ('remont_projectorov'),
                    'Kodak'=> array ('remont_projectorov', 'remont_photoapparatov'),
                    'NEC'=> array ('remont_projectorov'),
                    'Optoma'=> array ('remont_projectorov'),
                    'ViewSonic'=> array ('remont_projectorov'),
                    'Vivitek'=> array ('remont_projectorov'),
                    'Xgimi'=> array ('remont_projectorov'),
                    'Hiper'=> array ('remont_giroskuterov','remont_elektrosamokatov'),
                    'Hoverbot'=> array ('remont_giroskuterov','remont_monokolyos','remont_sigveev'),
                    'Razor'=> array ('remont_giroskuterov','remont_elektrosamokatov'),
                    'Zaxboard'=> array ('remont_giroskuterov','remont_elektrosamokatov'),
                    'DJI'=> array ('remont_kvadrokopterov'),
                    'Hubsan'=> array ('remont_kvadrokopterov'),
                    'Walkera'=> array ('remont_kvadrokopterov'),
                    'Xiro'=> array ('remont_kvadrokopterov'),
                    'Airwheel'=> array ( 'remont_monokolyos','remont_sigveev','remont_elektrosamokatov'),
                    'Gotway'=> array ( 'remont_monokolyos'),
                    'Inmotion'=> array ( 'remont_monokolyos','remont_sigveev','remont_elektrosamokatov'),
                    'KingSong'=> array ( 'remont_monokolyos'),
                    'Eltreco'=> array ('remont_elektrosamokatov'),
                    'e-TWOW'=> array ('remont_elektrosamokatov'),
                    'Globber'=> array ('remont_elektrosamokatov'),
                    'Halten'=> array ('remont_elektrosamokatov'),
                    'Kugoo'=> array ('remont_elektrosamokatov'),
                    'Takasima'=> array ('remont_massazhnyh_kresel'),
                    'Yamaguchi'=> array ('remont_massazhnyh_kresel'),
                    'Ergonova'=> array ('remont_massazhnyh_kresel'),
                    'Inada'=> array ('remont_massazhnyh_kresel'),
                    'Casada'=> array ('remont_massazhnyh_kresel'),
                    'Sensa'=> array ('remont_massazhnyh_kresel'),
                    'Irest'=> array ('remont_massazhnyh_kresel'),
                    'Us medica'=> array ('remont_massazhnyh_kresel'),
                    'UNO'=> array ('remont_massazhnyh_kresel'),
                    'EGO'=> array ('remont_massazhnyh_kresel'),
                    'Gess'=> array ('remont_massazhnyh_kresel'),
                    'Victoryfit'=> array ('remont_massazhnyh_kresel'),
                    'Richter'=> array ('remont_massazhnyh_kresel'),
                    'Restart'=> array ('remont_massazhnyh_kresel'),
                    'Bork'=> array ('remont_massazhnyh_kresel'),
                    'Sanyo'=> array ('remont_massazhnyh_kresel'),
                    'Beurer'=> array ('remont_massazhnyh_kresel'),
                    'Fujiiryoki'=> array ('remont_massazhnyh_kresel'),
                    'Nvidia'=> array ( 'remont_igrovyh_pristavok'),
                    'Microsoft'=> array ( 'remont_igrovyh_pristavok'),
                    'Nintendo'=> array ( 'remont_igrovyh_pristavok')
	           	);

                foreach ($marka_ids as $marka_name => $marka_id)
                {
                    foreach ($static as $key)
                    {
                        $st_key = $key;
                        if ($key == 'index') $st_key = tools::translit($marka_name,'_');
                        if ($key == 'ceny') $st_key = tools::translit($marka_name,'_').'/'.$key;

                        $params = serialize(array('marka_id' => $marka_id, 'static' => $key));
                        $mas_url[] = array(0, "'".$st_key."'",
                                "'".$params."'", tools::get_rand_dop());
                    }

                    foreach ($static2 as $key)
                    {
                        $st_key = $key;
                        if ($key == 'zapchasti') $st_key = 'komplektuyushie';
                        $params = serialize(array('marka_id' => $marka_id, 'static' => $st_key));
                        $mas_url[] = array(0, "'".$key."_".tools::translit($marka_name,'_')."'",
                                "'".$params."'", tools::get_rand_dop());
                    }

                    if (isset($urls[$marka_name]))
                    {
                        foreach ($urls[$marka_name] as $url)
                        {
                            $params = serialize(array('marka_id' => $marka_id, 'static' => $url));
                            $mas_url[] = array(0, "'".$url."_".tools::translit($marka_name,'_')."'",
                                "'".$params."'", tools::get_rand_dop());
                        }
                    }
                }

                $pass = true;

            break;

            case 'СЦ-5':

                $static1 = array('/', 'company', 'promo');
                $static2 = array('/', 'price', 'garantiya', 'contacts');
                //$static3 = array('diagnostika', 'remont', 'dostavka', 'zapchasti');
                $static3 = array('diagnostika', 'remont', 'zapchasti');
                $static4 = array('zamena-ekrana');
                
                $urls = array(
                    // 'acer' => array('remont-monoblokov-acer', 'remont-monitorov-acer', 'remont-headphones-acer', 'remont-proektorov-acer', 'remont-computerov-acer'),
                    // 'apple' => array('remont-smartwatchs-apple', 'remont-monoblokov-apple', 'remont-monitorov-apple', 'remont-computerov-apple'),
                    // 'asus' => array('remont-smartwatchs-asus', 'remont-monoblokov-asus', 'remont-monitorov-asus', 'remont-proektorov-asus', 'remont-computerov-asus'),
                    // 'canon' => array('remont-foto-canon', 'remont-video-canon', 'remont-printerov-canon', 'remont-proektorov-canon'),
                    // 'dell' => array('remont-monoblokov-dell', 'remont-monitorov-dell', 'remont-headphones-dell', 'remont-serverov-dell', 'remont-proektorov-dell', 'remont-computerov-dell'),
                    // 'hp' => array('remont-smartwatchs-hp', 'remont-monoblokov-hp', 'remont-monitorov-hp', 'remont-printerov-hp', 'remont-headphones-hp', 'remont-serverov-hp', 'remont-routers-hp', 'remont-computerov-hp'),
                    
                    // 'htc' => array('remont-headphones-htc', 'remont-vive-htc'),
                    // 'huawei' => array(/*'remont-notebooks-huawei', 'remont-smartwatchs-huawei', 'remont-headphones-huawei', 'remont-routers-huawei',*/ 'remont-serverov-huawei',),
                    // 'lenovo' => array('remont-monoblokov-lenovo', 'remont-monitorov-lenovo', 'remont-serverov-lenovo', 'remont-proektorov-lenovo', 'remont-computerov-lenovo'),
                    // 'lg' => array('remont-monitorov-lg', 'remont-televizorov-lg', 'remont-headphones-lg', 'remont-proektorov-lg', 'remont-computerov-lg'),
                    // 'meizu' => array('remont-smartwatchs-meizu', 'remont-headphones-meizu'),
                    // 'msi' => array('remont-monoblokov-msi', 'remont-monitorov-msi', 'remont-headphones-msi', 'remont-routers-msi', 'remont-computerov-msi'),
                    
                    // 'nikon' => array('remont-foto-nikon', 'remont-video-nikon', 'remont-lens-nikon', 'remont-foto-nikon'),
                    // 'nokia' => array('remont-smartwatchs-nokia', 'remont-headphones-nokia'),
                    // 'samsung' => array('remont-smartwatchs-samsung', 'remont-monitorov-samsung', 'remont-televizorov-samsung', 'remont-printerov-samsung', 'remont-headphones-samsung', 'remont-vive-samsung', 'remont-foto-samsung', 'remont-proektorov-samsung', 'remont-computerov-samsung'),
                    // 'sony' => array('remont-smartwatchs-sony', 'remont-televizorov-sony', 'remont-foto-sony', 'remont-video-sony', 'remont-headphones-sony', 'remont-vive-sony', 'remont-computerov-sony'),
                    // 'toshiba' => array('remont-televizorov-toshiba', 'remont-printerov-toshiba', 'remont-proektorov-toshiba'),
                    // 'xiaomi' => array('remont-notebooks-xiaomi', 'remont-smartwatchs-xiaomi', 'remont-televizorov-xiaomi', 'remont-headphones-xiaomi', 'remont-routers-xiaomi', 'remont-vive-xiaomi', 'remont-pristavok-xiaomi', 'remont-foto-xiaomi', 'remont-proektorov-xiaomi'),
                    // 'zte' => array('remont-routers-zte'),
                    // 'panasonic' => array('remont-foto-panasonic', 'remont-proektorov-panasonic'),
                    // 'sigma' => array('remont-foto-sigma'),
                    // 'fujifilm' => array('remont-foto-fujifilm'),
                    // 'polaroid' => array('remont-foto-polaroid'),
                    // 'olympus' => array('remont-foto-olympus'),
                    // 'leica' => array('remont-foto-leica'),
                    // 'hasselblad' => array('remont-foto-hasselblad'),
                    'infocus' => array('remont-proektorov-infocus'),
                );

                foreach ($marka_ids as $marka_name => $marka_id)
                {
                    $marka_lower = mb_strtolower($marka_name);
           
                    foreach ($static1 as $key)
                    {
                        $params = serialize(array('marka_id' => $marka_id, 'static' => $key));
                        $mas_url[] = array($args['site_id'], "'".$key."'",
                                "'".$params."'", tools::get_rand_dop());
                    }

                    foreach ($static2 as $key)
                    {
                        $params = serialize(array('marka_id' => $marka_id, 'static' => $key));
                        $mas_url[] = array($args['site_id'], "'company/".$key."'",
                                "'".$params."'", tools::get_rand_dop());
                    }

                    foreach ($static3 as $key)
                    {
                        $params = serialize(array('marka_id' => $marka_id, 'static' => $key));
                        $mas_url[] = array($args['site_id'], "'company/".$key."-".tools::translit($marka_name)."'",
                                "'".$params."'", tools::get_rand_dop());
                    }
                    
                    if ($marka_name != 'nikon' && $marka_name != 'canon')
                    {
                        foreach ($static4 as $key)
                        {
                            $params = serialize(array('marka_id' => $marka_id, 'static' => $key));
                            $mas_url[] = array($args['site_id'], "'".$key."-".tools::translit($marka_name)."'",
                                    "'".$params."'", tools::get_rand_dop());
                        }
                    }
                    
                    if (isset($urls[mb_strtolower($marka_name)]))
                    {
                        foreach ($urls[mb_strtolower($marka_name)] as $url)
                        {
                            $params = serialize(array('marka_id' => $marka_id, 'static' => $url));
                            $mas_url[] = array($args['site_id'], "'".$url."'",
                                "'".$params."'", tools::get_rand_dop());
                        }
                    }
                }

                $pass = true;

            break;

            case 'СЦ-6':

                $static = array('/','uslugi', 'komplektuyshie', 'neispravnosti', 'o_kompanii');

                $static1 = array('akciya','price_list','informaciya','vakansii','vremya_remonta','diagnostika', 'otzivy','dostavka');

                foreach ($marka_ids as $marka_id)
                {
                    foreach ($static as $key)
                    {
                        $params = serialize(array('marka_id' => $marka_id, 'static' => $key));
                        $mas_url[] = array($args['site_id'], "'".$key."'",
                                "'".$params."'", tools::get_rand_dop());
                    }
                    foreach ($static1 as $key)
                    {
                        $params = serialize(array('marka_id' => $marka_id, 'static' => $key));
                        $mas_url[] = array($args['site_id'], "'o_kompanii/".$key."'",
                            "'".$params."'", tools::get_rand_dop());
                    }
                }

                $pass = true;

            break;

            case 'СЦ-7':  case 'СЦ-7Б':

                $static = array('/', 'info', 'about', 'sitemap');

                $static1 = array('price', 'action', 'contacts', 'vacancy');

                $static2 = array('components', 'defects', 'time-to-repair', 'hurry-up-repairs', 'diagnostics', 'delivery');

                $urls = array(
                    'apple' => array('repair-monitors','repair-computers'),
                    'acer' => array('repair-monitors'),
                    'asus' => array('repair-projectors'),
                    'canon' => array('repair-projectors','repair-video-cameras'),
                    'dexp' => array('repair-tvs','repair-projectors'),
                    'digma' => array('repair-projectors'),
                    'haier' => array('repair-tvs'),
                    'htc' => array('repair-tablets'),
                    'msi' => array('repair-tablets','repair-monitors'),
                    'prestigio' => array('repair-tvs'),
                    'samsung' => array('repair-monoblocks','repair-monitors','repair-projectors'),
                    'sony' => array('repair-monoblocks'),
                    'toshiba' => array('repair-tvs','repair-projectors','repair-fridges','repair-washing-machines'),
                    'xiaomi' => array( 'repair-tvs','repair-projectors', 'repair-cameras', 'repair-giroscooters','repair-quadrocopters','repair-samokats'),
                    'zte' => array('repair-routers'),
                    'hp' => array('repair-smartphones','repair-tablets','repair-monitors','repair-projectors'),
                    'meizu' => array('repair-tablets','repair-smart-watch'),
                    'vertu' => array('repair-smartphones'),
                    'oneplus' => array('repair-smartphones'),
                    'barco' =>  array('repair-projectors'),
                    'benq' =>  array('repair-smartphones', 'repair-monitors','repair-projectors'),
                    'christie' =>  array('repair-projectors'),
                    'cinemood' =>  array('repair-projectors'),
                    'epson' =>  array('repair-projectors','repair-printers'),
                    'hitachi' =>  array('repair-tvs','repair-projectors','repair-fridges'),
                    'infocus' =>  array('repair-projectors'),
                    'jvc' =>  array('repair-tvs','repair-projectors','repair-video-cameras'),
                    'lenovo' =>  array('repair-monitors','repair-computers','repair-projectors'),
                    'lg' =>  array('repair-smartphones','repair-tablets','repair-laptops','repair-tvs','repair-monitors','repair-projectors','repair-fridges','repair-washing-machines','repair-dishwashers'),
                    'nec' =>  array('repair-monitors','repair-projectors'),
                    'optoma' =>  array('repair-projectors'),
                    'panasonic'=>  array('repair-smartphones','repair-laptops','repair-tablets','repair-tvs','repair-monitors','repair-projectors','repair-cameras','repair-video-cameras','repair-printers','repair-fridges','repair-washing-machines'),
                    'philips' =>  array('repair-smartphones','repair-tvs','repair-monitors','repair-projectors','repair-printers','repair-coffee-machines'),
                    'ricoh' =>  array('repair-projectors','repair-cameras','repair-printers'),
                    'sharp' =>  array('repair-tvs','repair-projectors','repair-fridges','repair-washing-machines'),
                    'viewSonic' =>  array('repair-monitors','repair-projectors'),
                    'vivitek' =>  array('repair-projectors'),
                    'xgimi' =>  array('repair-projectors'),
                    'dell' =>  array('repair-smartphones','repair-tablets','repair-computers','repair-projectors'),
                    'sigma' =>  array('repair-cameras'),
                    'fujifilm' =>  array('repair-cameras','repair-printers'),
                    'polaroid' =>  array('repair-cameras','repair-printers'),
                    'olympus' =>  array('repair-cameras'),
                    'leica' =>  array('repair-cameras'),
                    'kodak' =>  array('repair-cameras'),
                    'hasselblad' =>  array('repair-cameras'),
                    'airwheel' => array('repair-monowheels','repair-segways','repair-giroscooters','repair-samokats'),
                    'zaxboard' => array('repair-samokats','repair-segways'),
                    'globber' => array('repair-samokats'),
                    'halten' => array('repair-samokats'),
                    'razor' => array('repair-giroscooters', 'repair-samokats'),
                    'hiper'  => array('repair-projectors','repair-samokats'),
                    'hoverbot' => array('repair-monowheels','repair-segways','repair-giroscooters','repair-samokats'),
                    'iconbit' => array('repair-samokats', 'repair-giroscooters','repair-smartphones','repair-tablets'),
                    'inmotion' => array('repair-monowheels','repair-samokats','repair-segways','repair-giroscooters'),
                    'polaris' => array( 'repair-giroscooters','repair-samokats'),
                    'ninebot' => array('repair-monowheels','repair-samokats','repair-segways','repair-giroscooters'),
                    'kugoo' => array('repair-samokats','repair-giroscooters'),
                    'kingsong' => array('repair-monowheels', 'repair-samokats'),
                    'gigabyte' => array('repair-computers','repair-servers','repair-laptops'),
                    'omen' => array('repair-computers','repair-laptops'),
                    'compaq' => array('repair-laptops', 'repair-computers', 'repair-monoblocks'),
                    'predator' => array('repair-laptops', 'repair-computers'),
                    'rover' => array('repair-laptops', 'repair-tablets'),
                    'vestel' => array('repair-laptops', 'repair-tablets', 'repair-smartphones', 'repair-tvs'),
                    'emachines' => array('repair-laptops','repair-monoblocks'),
                    '4good' => array('repair-laptops','repair-tablets','repair-smartphones'),
                    'honor' => array('repair-laptops','repair-tablets','repair-smartphones','repair-tvs'),
                    'microsoft' => array('repair-laptops','repair-tablets','repair-smartphones','repair-computers','repair-monoblocks','repair-game-consoles'),
                    'micromax' => array('repair-laptops','repair-tablets','repair-smartphones','repair-tvs'),
                    'mimaki'=> array('repair-plotter','repair-printers'),
                    'neff'=> array('repair-dishwashers','repair-fridges','repair-washing-machines','repair-coffee-machines','repair-microwave-ovens'),
                    'asko'=> array('repair-washing-machines','repair-fridges','repair-dishwashers','repair-coffee-machines','repair-microwave-ovens'),
                    'bauknecht'=> array('repair-washing-machines','repair-fridges','repair-dishwashers','repair-coffee-machines','repair-microwave-ovens'),
                    'bbk'=> array('repair-tvs','repair-microwave-ovens','repair-dishwashers','repair-vacuum-cleaners','repair-smartphones','repair-fridges','repair-tablets','repair-monitors'),
                    'beko'=> array('repair-washing-machines','repair-fridges','repair-dishwashers','repair-vacuum-cleaners','repair-microwave-ovens','repair-coffee-machines','repair-water-heaters'),
                    'bork'=> array('repair-coffee-machines','repair-vacuum-cleaners','repair-microwave-ovens'),
                    'bosch'=> array('repair-dishwashers','repair-washing-machines','repair-fridges','repair-vacuum-cleaners','repair-coffee-machines','repair-microwave-ovens','repair-robot-vacuum-cleaners','repair-water-heaters'),
                    'brandt'=> array('repair-tvs','repair-washing-machines','repair-fridges','repair-dishwashers','repair-coffee-machines','repair-microwave-ovens'),
                    'brother'=> array('repair-printers','repair-plotter'),
                    'candy'=> array('repair-washing-machines','repair-dishwashers','repair-fridges','repair-microwave-ovens','repair-vacuum-cleaners','repair-water-heaters'),
                    'delonghi'=> array('repair-coffee-machines','repair-microwave-ovens','repair-vacuum-cleaners','repair-dishwashers'),
                    'electrolux'=> array('repair-dishwashers','repair-washing-machines','repair-water-heaters','repair-vacuum-cleaners','repair-fridges','repair-microwave-ovens','repair-robot-vacuum-cleaners','repair-coffee-machines'),
                    'fujitsu'=> array('repair-laptops','repair-tvs','repair-smartphones','repair-monitors','repair-laptops','repair-monoblocks','repair-tablets','repair-servers'),
                    'gaggenau'=> array('repair-fridges','repair-dishwashers','repair-coffee-machines','repair-washing-machines','repair-microwave-ovens'),
                    'ginzzu'=> array('repair-vacuum-cleaners','repair-laptops','repair-fridges','repair-dishwashers','repair-smartphones','repair-tablets'),
                    'gorenje'=> array('repair-microwave-ovens','repair-washing-machines','repair-fridges','repair-dishwashers','repair-vacuum-cleaners','repair-water-heaters','repair-coffee-machines'),
                    'graude'=> array('repair-washing-machines','repair-fridges','repair-dishwashers','repair-coffee-machines','repair-microwave-ovens'),
                    'hansa'=> array('repair-dishwashers','repair-washing-machines','repair-fridges','repair-microwave-ovens','repair-vacuum-cleaners','repair-water-heaters'),
                    'aeg' => array('repair-fridges','repair-vacuum-cleaners','repair-coffee-machines','repair-washing-machines','repair-robot-vacuum-cleaners','repair-tvs','repair-dryer-machines','repair-dishwashers','repair-microwave-ovens'),
                    'ardo' => array('repair-microwave-ovens','repair-dishwashers','repair-washing-machines','repair-dryer-machines','repair-fridges'),
                    'ariston' => array('repair-coffee-machines','repair-vacuum-cleaners','repair-dishwashers','repair-microwave-ovens','repair-washing-machines','repair-dryer-machines','repair-fridges'),
                    'hisense' => array('repair-smartphones','repair-fridges','repair-washing-machines','repair-tvs'),
                    'hyundai' => array('repair-vacuum-cleaners','repair-tvs'),
                    'iiyama' => array('repair-tvs'),
                    'indesit' => array('repair-coffee-machines','repair-microwave-ovens','repair-dishwashers','repair-washing-machines','repair-dryer-machines','repair-fridges'),
                    'kaiser' => array('repair-coffee-machines','repair-microwave-ovens','repair-dishwashers','repair-washing-machines','repair-fridges'),
                    'kitchenaid' => array('repair-coffee-machines','repair-microwave-ovens','repair-dishwashers','repair-fridges'),
                    'kitfort' => array('repair-robot-vacuum-cleaners','repair-vacuum-cleaners'),
                    'kuppersbusch' => array('repair-coffee-machines','repair-microwave-ovens','repair-dishwashers','repair-washing-machines','repair-dryer-machines','repair-tvs','repair-fridges'),
                    'kyocera' => array('repair-laser-printers','repair-smartphones'),
                    'leran' => array('repair-coffee-machines','repair-microwave-ovens','repair-dishwashers','repair-vacuum-cleaners','repair-washing-machines','repair-fridges'),
                    'oki' => array('repair-laser-printers','repair-plotter'),
                    'oysters'=> array('repair-tablets','repair-smartphones','repair-coffee-machines',),
                    'packard bell'=> array('repair-laptops','repair-monitors','repair-monoblocks','repair-laptops','repair-tablets',),
                    'roland'=> array('repair-plotter','repair-printers',),
                    'sanyo'=> array('repair-tvs','repair-projectors',),
                    'zanussi'=> array('repair-washing-machines','repair-dishwashers','repair-fridges','repair-vacuum-cleaners','repair-microwave-ovens','repair-dryer-machines'),
                    'siemens'=> array('repair-coffee-machines','repair-washing-machines','repair-dishwashers','repair-fridges','repair-microwave-ovens','repair-dryer-machines'),
                    'smeg'=> array('repair-fridges','repair-coffee-machines','repair-dishwashers','repair-washing-machines','repair-microwave-ovens','repair-dryer-machines'),

                );

                if ($setka_name == 'СЦ-7Б')
                {
                    $urls['samsung'] = array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin');
                    $urls['lg'] = array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin');
                }

                foreach ($marka_ids as $marka_name => $marka_id)
                {
                    if (isset($urls[mb_strtolower($marka_name)]))
                    {
                        foreach ($urls[mb_strtolower($marka_name)] as $url)
                        {
                            $params = serialize(array('marka_id' => $marka_id, 'static' => $url));
                            $mas_url[] = array($args['site_id'], "'".$url."'",
                                "'".$params."'", tools::get_rand_dop());
                        }
                    }

                    foreach ($static as $key)
                    {
                        $params = serialize(array('marka_id' => $marka_id, 'static' => $key));
                        $mas_url[] = array($args['site_id'], "'".$key."'",
                                "'".$params."'", tools::get_rand_dop());
                    }

                    foreach ($static1 as $key)
                    {
                        $params = serialize(array('marka_id' => $marka_id, 'static' => $key));
                        $mas_url[] = array($args['site_id'], "'about/".$key."'",
                            "'".$params."'", tools::get_rand_dop());
                    }

                    foreach ($static2 as $key)
                    {
                        $params = serialize(array('marka_id' => $marka_id, 'static' => $key));
                        $mas_url[] = array($args['site_id'], "'info/".$key."'",
                            "'".$params."'", tools::get_rand_dop());
                    }
                }

                $pass = true;

            break;

            case 'СЦ-8':

                $static = array('/', 'about', 'status');

                $static1 = array('special', 'testimonials', 'contacts', 'privacy-policy');

                $static2 = array('urgent-repair', 'diagnostic',  'master', 'guarantees', 'quality-control', 'services-list');

                foreach ($static as $key)
                {
                    $params = serialize(array('static' => $key));
                    $mas_url[] = array($args['site_id'], "'".$key."'",
                            "'".$params."'", tools::get_rand_dop());
                }

                foreach ($static1 as $key)
                {
                    $params = serialize(array('static' => $key));
                    $mas_url[] = array($args['site_id'], "'about/".$key."'",
                        "'".$params."'", tools::get_rand_dop());
                }

                foreach ($static2 as $key)
                {
                    $params = serialize(array('static' => $key));
                    $mas_url[] = array($args['site_id'], "'about/".$key."'",
                        "'".$params."'", tools::get_rand_dop());
                }


                $urls = array(
                    'phone-service',
                    'laptop-service',
                    'tv-service',
                    'fridge-service',
                    'washing-machine-service',
                    'tablet-service',
                    'monobloc-service',
                    'computer-service',
                    'game-console-service',

                    'asus',
                    'lg',
                    'fly',
                    'meizu',
                    'indesit',
                    'huawei',
                    'dell',
                    'acer',
                    'apple',
                    'samsung',
                    'htc',
                    'lenovo',
                    'bosch',
                    'hp',
                    'sony',
                    'msi',
                );


                foreach ($urls as $key)
                {
                    $params = serialize(array('static' => $key));
                    $mas_url[] = array($args['site_id'], "'".$key."'",
                        "'".$params."'", tools::get_rand_dop());
                }


                $pass = true;

            break;

        }

        if (!$pass)
        {
            $t = array();
            foreach ($codes as $key => $value)
            {
                $first_val = current($value);

                $t[$key] = array('key' => $first_val[0], 'id' => array(), 'marka_id' => $first_val[2], 'model_type_id' => array());
                foreach ($value as $mas)
                {
                    $t[$key]['id'][] = $mas[1];
                    $t[$key]['model_type_id'][] = $mas[3];
                }

            }
            $codes = $t;

            $urls = array_count_values($urls);

            foreach ($urls as $key => $value)
            {
                if ($value > 1)
                {
                    $code = $codes[$key];
                    $params = serialize(array('model_type_id' => $code['model_type_id'], 'marka_id' => $code['marka_id'], 'key' => $code['key'], 'id' => $code['id']));
                    $mas_url[] = array($args['site_id'], "'".$key."'",
                                "'".$params."'", tools::get_rand_dop());
                }
            }
        }

        foreach ($mas_url as $url)
            $insert_urls[] = '('.implode(',', $url).','.tools::get_time().')';

        if ($insert_urls)
        {
            $sql = "INSERT IGNORE INTO `urls` (`site_id`,`name`,`params`,`feed`,`date`) VALUES ".implode(',', $insert_urls);
            
            if ($setka_name == 'СЦ-3')
                pdo::getPdo(3)->query($sql);
            else
                pdo::getPdo()->query($sql);
            //echo $sql;
        }

        return false;
    }

    /*public function processItems(&$items, $args)
    {
        $values = array();

        $sql = "SELECT `site_id` FROM `urls` WHERE `params` LIKE '%static%' GROUP BY `site_id`";
        $sites = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN);

        $sql = "SELECT `setkas`.`name` as `setka_name`, `sites`.`name` as `site_name`, `sites`.`id` as `site_id`
                    FROM `sites` LEFT JOIN `setkas` ON `sites`.`setka_id` = `setkas`.`id` WHERE `sites`.`id` NOT IN (".implode(',', $sites).")
                            ORDER BY `setkas`.`id` ASC, `sites`.`name` ASC";

        $data = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($data as $value)
            $values[$value['setka_name']][$value['site_id']] = $value['site_name'];

        $items['site_id']->setValues(array(0 => '-- нет данных --') + $values);
    }*/
}

?>
