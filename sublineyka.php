<?

spl_autoload_extensions('.php');
spl_autoload_register();

use framework\pdo;
use framework\tools;
use framework\gen\gen_m_model;

  $exclude_models = [
            'BJC-1000',
            'BJC-2100',
            'BJC-55',
            'BJC-85',
            'i320',
            'i350',
            'i450',
            'i455',
            'i80',
            'i9950',
            'imagePROGRAF iPF510',
            'imagePROGRAF iPF605',
            'imagePROGRAF iPF6400S',
            'imagePROGRAF iPF670',
            'imagePROGRAF iPF750',
            'imagePROGRAF iPF760',
            'imagePROGRAF iPF770',
            'imagePROGRAF iPF780',
            'imagePROGRAF iPF830',
            'imagePROGRAF iPF840',
            'imagePROGRAF MFP Solution',
            'imagePROGRAF PRO-2000',
            'imagePROGRAF TX-3000',
            'imagePROGRAF TX-4000',
            'MAXIFY iB4040',
            'MAXIFY iB4140',
            'MAXIFY MB2040',
            'MAXIFY MB2140',
            'MAXIFY MB2340',
            'MAXIFY MB2740',
            'MAXIFY MB5040',
            'MAXIFY MB5140',
            'MAXIFY MB5340',
            'MAXIFY MB5440',
            'PIXMA E404',
            'PIXMA E414',
            'PIXMA E464',
            'PIXMA G1400',
            'PIXMA G1410',
            'PIXMA G2400',
            'PIXMA G2410',
            'PIXMA G3400',
            'PIXMA G3410',
            'PIXMA G4400',
            'PIXMA G4410',
            'PIXMA iP100',
            'PIXMA iP1000',
            'PIXMA iP110',
            'PIXMA iP1200',
            'PIXMA iP1300',
            'PIXMA iP1500',
            'PIXMA iP1600',
            'PIXMA iP1700',
            'PIXMA iP1800',
            'PIXMA iP1900',
            'PIXMA iP2000',
            'PIXMA iP2200',
            'PIXMA iP2500',
            'PIXMA iP2600',
            'PIXMA iP2700',
            'PIXMA iP2840',
            'PIXMA iP3000',
            'PIXMA iP3300',
            'PIXMA iP3500',
            'PIXMA iP3600',
            'PIXMA iP4000',
            'PIXMA iP4200',
            'PIXMA iP4300',
            'PIXMA iP4500',
            'PIXMA iP4600',
            'PIXMA iP4700',
            'PIXMA iP4840',
            'PIXMA iP4940',
            'PIXMA iP5000',
            'PIXMA iP5200',
            'PIXMA iP5300',
            'PIXMA iP6000D',
            'PIXMA iP6220D',
            'PIXMA iP6600D',
            'PIXMA iP6700D',
            'PIXMA iP7240',
            'PIXMA iP8500',
            'PIXMA iP8740',
            'PIXMA iP90',
            'PIXMA iP90v',
            'PIXMA iX4000',
            'PIXMA iX5000',
            'PIXMA iX6540',
            'PIXMA iX6840',
            'PIXMA MG2140',
            'PIXMA MG2240',
            'PIXMA MG2440',
            'PIXMA MG2540',
            'PIXMA MG2540S',
            'PIXMA MG2940',
            'PIXMA MG3040',
            'PIXMA MG3140',
            'PIXMA MG3240',
            'PIXMA MG3250',
            'PIXMA MG3540',
            'PIXMA MG3640',
            'PIXMA MG4140',
            'PIXMA MG4240',
            'PIXMA MG5140',
            'PIXMA MG5240',
            'PIXMA MG5340',
            'PIXMA MG5440',
            'PIXMA MG5540',
            'PIXMA MG5640',
            'PIXMA MG5740',
            'PIXMA MG6140',
            'PIXMA MG6240',
            'PIXMA MG6340',
            'PIXMA MG6440',
            'PIXMA MG6640',
            'PIXMA MG6840',
            'PIXMA MG7140',
            'PIXMA MG7540',
            'PIXMA MG7740',
            'PIXMA MG8140',
            'PIXMA MG8240',
            'PIXMA MP110',
            'PIXMA MP130',
            'PIXMA MP140',
            'PIXMA MP150',
            'PIXMA MP160',
            'PIXMA MP170',
            'PIXMA MP180',
            'PIXMA MP190',
            'PIXMA MP210',
            'PIXMA MP220',
            'PIXMA MP230',
            'PIXMA MP240',
            'PIXMA MP250',
            'PIXMA MP252',
            'PIXMA MP260',
            'PIXMA MP270',
            'PIXMA MP280',
            'PIXMA MP282',
            'PIXMA MP450',
            'PIXMA MP460',
            'PIXMA MP480',
            'PIXMA MP490',
            'PIXMA MP492',
            'PIXMA MP495',
            'PIXMA MP500',
            'PIXMA MP510',
            'PIXMA MP520',
            'PIXMA MP540',
            'PIXMA MP550',
            'PIXMA MP560',
            'PIXMA MP600',
            'PIXMA MP610',
            'PIXMA MP630',
            'PIXMA MP640',
            'PIXMA MP750',
            'PIXMA MP800',
            'PIXMA MP810',
            'PIXMA MP970',
            'PIXMA MP990',
            'PIXMA MX300',
            'PIXMA MX310',
            'PIXMA MX320',
            'PIXMA MX340',
            'PIXMA MX360',
            'PIXMA MX374',
            'PIXMA MX394',
            'PIXMA MX454',
            'PIXMA MX494',
            'PIXMA MX514',
            'PIXMA MX524',
            'PIXMA MX870',
            'PIXMA MX884',
            'PIXMA MX924',
            'PIXMA PRO-1',
            'PIXMA PRO-10',
            'PIXMA PRO-100',
            'PIXMA PRO-100S',
            'PIXMA PRO-10S',
            'PIXMA Pro9000',
            'PIXMA Pro9500',
            'PIXMA Pro9500 Mark II',
            'PIXMA TR7540',
            'PIXMA TR8540',
            'PIXMA TS3140',
            'PIXMA TS5040',
            'PIXMA TS5140',
            'PIXMA TS6040',
            'PIXMA TS6140',
            'PIXMA TS8040',
            'PIXMA TS8140',
            'PIXMA TS9040',
            'PIXMA TS9140',
            'S100',
            'S200',
            'S300',
            'Selphy CP1200',
            'SELPHY CP1300',
         ];

$m_model2 = 
'i-SENSYS LBP6030B
i-SENSYS LBP214dw
i-SENSYS LBP212dw
i-SENSYS LBP113w
i-SENSYS LBP653Cdw
i-SENSYS LBP6030w
i-SENSYS LBP6300dn
i-SENSYS LBP162dw
i-SENSYS LBP112
i-Sensys LBP215x
i-SENSYS LBP6310dn
i-SENSYS LBP215x
i-SENSYS LBP352x
i-SENSYS LBP351x
imageRUNNER 1435P
i-SENSYS LBP7780Cx
imageRUNNER ADVANCE C356P
imageRUNNER ADVANCE 6555iPRT
imageRUNNER ADVANCE C350P
iSensys LBP212dw
iSensys LBP214dw
i-SENSYS LBP5300
i-SENSYS LBP6750DN
iR C1335iF
Plain Pedestal Type-J1
iR C1325iF
i-Sensys MF522x
iR 2530i
imageRUNNER ADVANCE C3025i
i-SENSYS MF421dw
i-SENSYS MF264dw
iSensys MF428x
i-Sensys Colour MF631Cn
i-Sensys Colour LBP710Cx
i-SENSYS LBP-6030B';

$mas = explode(PHP_EOL, $m_model2);
//print_r($mas);

//var_dump($mas[0]);

foreach ($mas as $k => $m)
    //$mas[$k] = trim($m);
    $mas[$k] = "remont_printerov/".mb_strtolower(preg_replace("/\s+/", "_", trim($m)));

foreach ($exclude_models as $m_model)
{
    $url1 = "remont_printerov/".mb_strtolower(preg_replace("/\s+/", "_", $m_model));
    $url2 = $mas[rand(0, count($mas) - 1)];
    
    echo "'".$url1."' => '".$url2 . "', ".PHP_EOL;
}        

//var_dump($mas[0]);*/

/*$i = 3739;
foreach ($mas as $key => $value)
{
    //$insert[] = "(".$i.",'".$value."','',144)";
    $insert[] = "(".$i.",6,1)";
    $i++;        
}

//print_r($insert);

/*$sql = "INSERT INTO `models2` (`id`, `name`,`name_ru`,`model_type_mark`) VALUES " . implode(',', $insert);
echo $sql;
/*pdo::getPdo()->query($sql);*/

/*$sql = "SELECT `sites`.`name`, `sites`.`id` FROM `marka_to_sites` LEFT JOIN `sites` ON `marka_to_sites`.`site_id` = `sites`.`id` 
                    WHERE `marka_id` = 23 AND `setka_id` = 6";
$sites = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

print_r($sites);

foreach ($sites as $site)
{
    $i = 3739;
    foreach ($mas as $m_model)
    {
        $url = "remont_printerov/".mb_strtolower(preg_replace("/\s+/", "_", $m_model));
        $params = serialize(array('model_id' => $i));
        $urls[] = array($site['id'], "'$url'",
                      "'".$params."'", tools::get_rand_dop());
                      
        $i++;
    }    
}

print_r($urls);

foreach ($urls as $url)
    $insert_urls[] = '('.implode(',', $url).','.tools::get_time().')';

$sql = "INSERT IGNORE INTO `urls` (`site_id`,`name`,`params`,`feed`,`date`) VALUES ".implode(',', $insert_urls);
echo $sql;
pdo::getPdo()->query($sql);


/*$sql = "INSERT INTO `models2_to_setka` (`id_model`,`id_setka`,`active`) VALUES " . implode(',', $insert);
echo $sql;
pdo::getPdo()->query($sql);


/*$sql = "SELECT `sublineyka`,`ru_sublineyka`,`m_models`.`marka_id` as `marka_id`,
            `m_models`.`model_type_id` as `model_type_id`, `m_models`.`id` as `m_model_id` FROM `models` 
    INNER JOIN `m_models` ON `m_models`.`id` = `models`.`m_model_id` GROUP BY `marka_id`,`model_type_id`,`sublineyka`";
$sublineykas = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

$sql = "SELECT `sites`.`id` as `site_id`, `marka_to_sites`.`marka_id` as `marka_id` FROM
    `marka_to_sites` 
     INNER JOIN `sites` ON `sites`.`id` = `marka_to_sites`.`site_id` 
     INNER JOIN `setkas` ON `setkas`.`id` = `sites`.`setka_id` WHERE `setkas`.`name`=:setka_name";   
$stm = pdo::getPdo()->prepare($sql);
$stm->execute(array('setka_name' => 'СЦ-3')); 
$sites = $stm->fetchAll(\PDO::FETCH_ASSOC);
$t = array();

foreach ($sites as $site)
{
    $t[$site['marka_id']][] = $site['site_id'];
}

$sites = $t;

foreach ($sublineykas as $value)
{
    $sql = "INSERT INTO `sublineykas` (`name`,`ru_name`,`marka_id`,`model_type_id`) VALUES
            ('".$value['sublineyka']."','".$value['ru_sublineyka']."',".$value['marka_id'].",".$value['model_type_id'].")";
    pdo::getPdo()->query($sql);
    $id = pdo::getPdo()->lastInsertId();
    
    $sql = "UPDATE `models` SET `sublineyka_id`=:sublineyka_id WHERE `sublineyka`=:sublineyka AND `m_model_id`=:m_model_id";
    $stm = pdo::getPdo()->prepare($sql);
    $stm->execute(array('sublineyka_id' => $id, 'sublineyka' => $value['sublineyka'], 'm_model_id' => $value['m_model_id']));
    
    if (isset($sites[$value['marka_id']]))
    {
        foreach ($sites[$value['marka_id']] as $site)
        {
            $gen = new gen_m_model($id, $site);
            $gen->setPass(false);
            $gen->setSynMode(true);
            $gen->genSyns();
            $gen->genUrls();
            $gen->genContent();
        }
    }
}*/

        /*$services = array('defect','service','complect');
        $suffics_array = array('p','n','f');
        
        foreach ($suffics_array as $suffics)
        {
            foreach ($services as $service)
            {
                $tables[] = $suffics.'_'.$service.'_model_vals';
                $tables[] = $suffics.'_'.$service.'_to_m_models';
            }
        }
        
        foreach ($tables as $table)
        {
            $sql = "DELETE FROM `{$table}` WHERE `sublineyka_id` IS NOT NULL";          
                
            pdo::getPdo()->query($sql);
        }
        
         $sql = "UPDATE `models` SET `sublineyka_id`= NULL";
         pdo::getPdo()->query($sql);
         
         $sql = "DELETE FROM `urls` WHERE `params` LIKE '%sublineyka_id%'";
         pdo::getPdo()->query($sql);
         
         
        $sql = "TRUNCATE sublineykas";
        pdo::getPdo()->query($sql);*/
?>