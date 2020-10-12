<?

$marka_lower = mb_strtolower($this->_datas['marka']['name']);
$url = $this->_datas['arg_url'];

$relinks = array(
   'acer' => array(
    	'remont_proyektorov' => array('remont_monoblokov', 'remont_noutbukov'),
    	'remont_monoblokov' => array('remont_smartfonov', 'remont_noutbukov'),
    	'remont_smartfonov' => array('remont_planshetov', 'remont_noutbukov'),
    	'remont_planshetov' => array('remont_proyektorov', 'remont_noutbukov'),
    	'remont_noutbukov' => array('remont_proyektorov', 'remont_monoblokov', 'remont_smartfonov', 'remont_planshetov'), 
   ),
   'apple' => array(
        'remont_smartfonov' => array('remont_noutbukov', 'remont_planshetov'),
        'remont_noutbukov' => array('remont_planshetov', 'remont_smartfonov'), 
        'remont_planshetov' => array('remont_monoblokov', 'remont_smartfonov'),
	    'remont_monoblokov' => array('remont_smartfonov', 'remont_planshetov'),
    ),
    'dell' => array(
    	'remont_monitorov' => array('remont_monoblokov', 'remont_noutbukov'),
    	'remont_monoblokov' => array('remont_serverov', 'remont_noutbukov'),
    	'remont_serverov' => array('remont_monitorov', 'remont_noutbukov'),
    	'remont_noutbukov' => array('remont_monitorov', 'remont_monoblokov', 'remont_serverov'),
    ),
    'hp' => array(
    	'remont_noutbukov' => array('remont_monoblokov', 'remont_printerov'),
    	'remont_monoblokov' => array('remont_printerov', 'remont_noutbukov'),
    	'remont_printerov' => array('remont_kompyuterov', 'remont_noutbukov'),
    	'remont_kompyuterov' => array('remont_noutbukov', 'remont_printerov'),
    ),
    'huawei' => array(
    	'remont_planshetov' => array('remont_noutbukov', 'remont_smartfonov'),
    	'remont_noutbukov' => array('remont_smartfonov', 'remont_planshetov'), 
    	'remont_smartfonov' => array('remont_serverov', 'remont_planshetov'),
    	'remont_serverov' => array('remont_planshetov', 'remont_smartfonov'),
	),
    'nokia' => array(
    	'remont_smartfonov' => array('remont_planshetov'),
    	'remont_planshetov' => array('remont_smartfonov'),
     ),
    'xiaomi' => array(
    	'remont_smartfonov' => array('remont_noutbukov'),
    	'remont_noutbukov' => array('remont_planshetov', 'remont_smartfonov'), 
        'remont_planshetov' => array('remont_smartfonov', 'remont_noutbukov'),
	),	
    'sony' => array(
    	'remont_smartfonov' => array('remont_proyektorov', 'remont_noutbukov'),
    	'remont_proyektorov' => array('remont_fotoapparatov', 'remont_planshetov'),
        'remont_fotoapparatov' => array('remont_noutbukov', 'remont_smartfonov'),
    	'remont_noutbukov' => array('remont_igrovykh_pristavok', 'remont_smartfonov'),
        'remont_igrovykh_pristavok' => array('remont_planshetov', 'remont_noutbukov'),
    	'remont_planshetov' => array('remont_televizorov', 'remont_smartfonov'),
    	'remont_televizorov' => array('remont_smartfonov', 'remont_noutbukov'),
   	),
    'toshiba' => array(
    	 'remont_planshetov' => array('remont_noutbukov'),
    	 'remont_noutbukov' => array('remont_planshetov'),
	),
    'lenovo' => array(
  	    'remont_smartfonov' => array('remont_monoblokov', 'remont_noutbukov'),
        'remont_monoblokov' => array('remont_noutbukov', 'remont_smartfonov'), 
        'remont_noutbukov' => array('remont_planshetov', 'remont_smartfonov'),
        'remont_planshetov' => array('remont_smartfonov', 'remont_noutbukov'),
	),
    'samsung' => array(
    	'remont_smartfonov' => array('remont_kholodilnikov', 'remont_planshetov'),
    	'remont_kholodilnikov' => array('remont_fotoapparatov', 'remont_planshetov'),
	    'remont_fotoapparatov' => array('remont_noutbukov', 'remont_smartfonov'),
     	'remont_noutbukov' => array('remont_televizorov', 'remont_smartfonov'),
    	'remont_televizorov' => array('remont_planshetov', 'remont_noutbukov'),
    	'remont_planshetov' => array('remont_smartfonov', 'remont_noutbukov'),
	),
);

$accord_link = array(
	'remont_proyektorov' => 'Ремонт проекторов',
	'remont_monoblokov' => 'Ремонт моноблоков',
	'remont_smartfonov' => 'Ремонт смартфонов',
	'remont_planshetov' => 'Ремонт планшетов',
	'remont_noutbukov' => 'Ремонт ноутбуков',

    'remont_monitorov' => 'Ремонт мониторов',
	'remont_serverov' => 'Ремонт серверов',
	
	'remont_printerov' => 'Ремонт принтеров',
	'remont_kompyuterov' => 'Ремонт компьютеров',

	'remont_fotoapparatov' => 'Ремонт фотоаппаратов',
	'remont_igrovykh_pristavok' => 'Ремонт игровых приставок',
	'remont_televizorov' => 'Ремонт телевизоров',
	'remont_kholodilnikov' => 'Ремонт холодильников',
);

if ($marka_lower == 'apple')
{
    $accord_link['remont_smartfonov'] = 'Ремонт iPhone';
    $accord_link['remont_noutbukov'] = 'Ремонт MacBook';
    $accord_link['remont_planshetov'] = 'Ремонт iPad';
    $accord_link['remont_monoblokov'] = 'Ремонт iMac';
}

if ($marka_lower == 'sony')
{
    $accord_link['remont_smartfonov'] = 'Ремонт Xperia';
    $accord_link['remont_planshetov'] = 'Ремонт Xperia Tab';
    $accord_link['remont_noutbukov'] = 'Ремонт VAIO';
    $accord_link['remont_igrovykh_pristavok'] = 'Ремонт Playstation';
}

if (isset($relinks[$marka_lower][$url]))
{
    echo '<div class="relink"><div>';
    
    if (isset($accord_link[$url])) echo '<span>'.$accord_link[$url].'</span>';	

    foreach ($relinks[$marka_lower][$url] as $link)
    {
        if (isset($accord_link[$link])) echo '<a href="/'.$link.'/">'.$accord_link[$link].'</a>';
    }

    echo '</div></div>';		
}

?>