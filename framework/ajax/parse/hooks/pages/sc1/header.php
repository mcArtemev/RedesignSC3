<?

use framework\tools;

$marka = $this->_datas['marka']['name']; 
$marka_lower = mb_strtolower($marka);
$phone = $this->_datas['phone'];
$phone_format = tools::format_phone($phone);
//$addresis = $this->_normalize_addresis($this->_footer_addresis(array('Москва', 'Санкт-Петербург'), 8));

$addresis = $this->_normalize_addresis($this->_pay_addr());

$menu = $this->_datas['header_menu'];
$url = ($this->_datas['arg_url'] != '/') ? '/'.$this->_datas['arg_url'].'/' : '/';

$geo_address = $this->_datas['partner']['address1'].', '.$this->_datas['region']['name'].', Россия'.(($this->_datas['partner']['index']) ? ', '.$this->_datas['partner']['index'] : '');
$time = ($this->_datas['partner']['time']) ? $this->_datas['partner']['time'] : 'Ежедневно, с 10:00 до 21:00';

$sr_style = '';
$add_style = '';
$new_sams = false;
$add_style2 = '';
$phone_style = '';

if ($this->_datas['setka_name'] == 'СЦ-1' && $marka_lower == 'samsung') 
{
    if ($this->_datas['region']['name'] != 'Москва')
    {
        $logo_str = 'logo2.png';
        $add_style = ' region';
    }
    else 
    {
        $logo_str = 'logo.png';
        $sr_style = ' style="background-color: #16026d"';
        $add_style = ' moskva';
     }
     $new_sams = true;
}
else
{
    if ($this->_datas['setka_name'] == 'СЦ-1' && $marka_lower == 'meizu') 
    {
        if ($this->_datas['region']['name'] == 'Москва')
        {
            $logo_str = 'logo2.png';
            $add_style = ' region';  
            $sr_style = ' style="background-color: #32a3e7"';  
            $add_style2 = ' style="color: #fff !important"';    
            $new_sams = true;
        }
        else
        {
            $sr_style = ' style="background-color: #32a3e7"';  
            $add_style2 = ' style="color: #fff !important"'; 
            $logo_str = 'logo.png'; 
        }
    }
    else
    {
        if ($this->_datas['setka_name'] == 'СЦ-1' && $marka_lower == 'nikon') 
        {
            if ($this->_datas['region']['name'] == 'Москва')
            {
                 $logo_str = 'logo2.png';
                 
            }
            else
            {
                 $logo_str = 'logo.jpg';
     
            }
            $new_sams = true;
        }
        else
        {
            if ($this->_datas['setka_name'] == 'СЦ-1' && $marka_lower == 'dell') 
            {
                $logo_str = 'logo2.png';
            }
            else
            {
                $logo_str = 'logo.jpg';
            }
        }
    }
         
}
if($this->_datas['region']['name'] == 'Москва' && $marka_lower == 'nikon') {
	$favicon = 'favicon-n.ico';
} else {
	$favicon = 'favicon.ico';
}

$google_meta = [
	['sony-russia-mobile.com','3KE1LdK2_Vw4eOS9Sc4jwcptk4FZ13rqjfoi-A-EthM'],
	['asus-russia-support.com','URhe6TXmnKKXYg4VttqaVJtpsDMDejQ6toeA4RLgyZU'],
	['acer-russia-support.ru','EegAwrhQ_NsI6aVR3QsQEmg2iqzTIdRVx_RSYqYVXqk'],
	['lenovo-russia-support.com','UG5S_1XIRIBSmqrHnVzHdphy6rQYIx05HPLDBk3f8Es'],
	['htc-russia-support.ru','xzYNYRxRlNhB-jcbApvyxZmNE3jciTEPWk11jV-ksGM'],
	['hp-russia-support.com','aRcK2chJ_yYrYWZTOemBbt947VAM34cFWXPFLnMs1hM'],
	['lg-russia-mobile.com','-8bkrvCZtx6MEP4ogdx87aPuBA9EQEUNEuosTzzQzLw'],
	['toshiba-russia-mobile.ru','mtgH2lBTfKSQcO-0juwlHTlRc2PdBTChTe6LfT3ixYU'],
	['msi-russia-support.com','DzCGd4GxbKwF8LkIotWGJesqrnwipiEecIqRlXUlHwQ'],
	['dell-russia-support.com','ZPZ8mJh-zZQ7Bi4UHgpjLfJzAoJRKdFqoW2wWpGLBF4'],
	['nokia-russia-support.com','AjWWT-hQ8gGW9WwBm7pbhoXZB0X5oMyP2XrQlzoC1XI'],
	['galaxy-russia-mobile.com','-cv-_msrZXHQz2FqAhhWueyMXtHewOqIFou4FxTb0f4'],
	['alcatel.russia-mobile.com','7sSm_zMqCIIEhgrXQt-ykeb_ojuNVFkahtP41DYWVTQ'],
	['compaq.russia-mobile.com','7sSm_zMqCIIEhgrXQt-ykeb_ojuNVFkahtP41DYWVTQ'],
	['fly.russia-mobile.com','7sSm_zMqCIIEhgrXQt-ykeb_ojuNVFkahtP41DYWVTQ'],
	['apple-russia-support.com','ODj1-TxHTTVtkrS7Z0mBrPP7rdROtsuGMG4rc6-HS1A'],
	['meizu-russia-support.com','Rl9tVm5EwEwL0VSEZABZLAHUW40cQ39XG4C4adMezVE'],
	['xiaomi-russia-support.com','ZSUXK8wztdDlTfwAaMZtGxat6jpQO41jyM7vAGiIi8k'],
	['huawei-russia-support.com','JIPszWiTn4cQlcgjXBo2EKQSgtMOs8J8iGXTzazuvuM'],
	['nikon-russia-support.ru','RVkOCUQtYn3vEYjFiztQKt6MO61ueCpPP5Zbq6rMds4'],
	['canon-russia-support.ru','4YC8ye2Hz5I4bnHdkImVyA9UFJZEmzTmKQsTqNX-Pak'],
	['indesit.russia-centre.com','CYxVQt2XWOToM3FS8Yt2hNta0Bi7e6xmPjQtM2bvVH4'],
	['electro.russia-centre.com','CYxVQt2XWOToM3FS8Yt2hNta0Bi7e6xmPjQtM2bvVH4'],
	['epson-russia-support.ru','0fKrbk87hMm9eHLdw8BsYbHQjnPBijswztmpIygor3w'],
	['bbk.russia-mobile.com','7sSm_zMqCIIEhgrXQt-ykeb_ojuNVFkahtP41DYWVTQ'],
	['panasonic-russia-mobile.ru','YStnug1wYR3eELbRdGoit0lvYwlEacyYeUihbBZ91X4'],
	['philips-russia-mobile.ru','kR5CeXyW-NQ-kGDrV9ZriWUUtJWnfFx1VmeonVA_cLE'],
	['ariston.russia-centre.com','CYxVQt2XWOToM3FS8Yt2hNta0Bi7e6xmPjQtM2bvVH4'],
	['bosch.russia-centre.com','CYxVQt2XWOToM3FS8Yt2hNta0Bi7e6xmPjQtM2bvVH4'],
	['zte.russia-mobile.com','7sSm_zMqCIIEhgrXQt-ykeb_ojuNVFkahtP41DYWVTQ'],
];

$mail_meta = [
    'alcatel.russia-mobile.com' => '837f2906bccffefd736853268577e09e',
    'apple-russia-mobile.com' => '6ebdd7cc20f0ac349a90e3e61afebde0',
    'ariston.russia-centre.com' => 'c4627f4be11a5edf91a00b747d53440e',
    'asus-russia-support.com' => 'bb9cf1e55017b6ba20fbdb1b1cf5c6e6',
    'bbk.russia-mobile.com' => '117f775046a18cff3b32dc09c536344e',
    'bosch.russia-centre.com' => '1b31f09fa9cf0d23b253561e6e1b0b78',
    'canon-russia-support.ru' => 'f5f4620b3c3189f97c8b8e4e8ead8a46',
    'compaq.russia-mobile.com' => '3e2ab1ad6185cfa51b50cf0824860930',
    'dell-russia-support.com' => '43529f27f886be8e08d7b09f9f9febec',
    'electro.russia-centre.com' => 'ffbcdb44879061f6014504b90b18b573',
    'epson-russia-support.ru' => '06f74be4b2e7448dd2741f2d24108ba4',
    'fly.russia-mobile.com' => '1f62f397577845fed68a1e8c0dcd022c',
    'hp-russia-support.com' => '227ce26204a2d9ce9425b811d05a4248',
    'htc-russia-support.ru' => '9b01e37e63bb994d058ba2a7738d7aea',
    'huawei-russia-support.com' => '0915a1d1e6b62e194d257f386ceb32dd',
    'indesit.russia-centre.com' => '8561461ef93062aeac67052a7539071b',
    'lenovo-russia-support.com' => 'd9996f3773cd4f30b78cf24b5b745ac3',
    'lg-russia-mobile.com' => 'cfa0539a7e93d45f798d67720bbad69c',
    'meizu-russia-support.com' => 'c79e6e1801af1a2b2fd2cd7c69d9bf22',
    'msi-russia-support.com' => 'c6d657be631ffd7d16ac5f5bae9c9250',
    'nikon-russia-support.ru' => 'e32a00e6b54f77c25c3ec0e139b7aead',
    'nokia-russia-support.com' => '195422c89dcad2c8269f30cf9ec6a54e',
    'panasonic-russia-mobile.ru' => 'ea1712fffb06df1d5ca6b6893d22d301',
    'philips-russia-mobile.ru' => '71b702517e7367f2ffedf57aa5ba66c3',
    'galaxy-russia-mobile.com' => '0a0c26c8d194b04549ed69c04d99e129',
    'xperia-russia-mobile.com' => 'd67346bb08c8ff1306283b9283bce884',
    'toshiba-russia-mobile.ru' => '2ecf68d07afdc8da0b5d559b359961dd',
    'xiaomi-russia-support.com' => '13d8b91a58405050d171fe95fef54e63',
    'zte.russia-mobile.com' => '29f8495a202c60ae98aaf2df9f60ea2d',
    'spb.acer-russia-support.ru' => '2319f8bb4362603f8be8b0f76b3de6ce',
    'spb-alcatel.russia-mobile.com' => '790e1e6119f00e01ebdffcf0e70f66c9',
    'spb.apple-russia-mobile.com' => 'eb79e472a5170b08ca109a5e3fb4172c',
    'spb-ariston.russia-centre.com' => 'f6d8c896e80bf931a0d9b67d17089561',
    'spb.asus-russia-support.com' => '5b9cadde9cc258589dd4cc7a465e5b0c',
    'spb-bbk.russia-mobile.com' => '7c4c9c4068b1fdfcbb2ec2a387809276',
    'spb-bosch.russia-centre.com' => '3bac9768071f9e100ce5f9b1b4a556db',
    'spb.canon-russia-support.ru' => '497aa1e500e31f4be63eda44eb4e9ac2',
    'spb-compaq.russia-mobile.com' => '736a01a56e9b6d9c1c9195bc50cb4ec5',
    'spb.dell-russia-support.com' => '337dfa523d2cce12ba0d8de7742e47a7',
    'spb-electro.russia-centre.com' => 'e202f0880f424f5bab7e3a7bf7cbc770',
    'spb.epson-russia-support.ru' => 'e905e07719aca64fda2274f08bb0c835',
    'spb-fly.russia-mobile.com' => 'ae35d78a84e72233ddde61f20a64d2ae',
    'spb.hp-russia-support.com' => '7d6af473eb5dd633231d4c7e3ebec559',
    'spb.htc-russia-support.ru' => '6234faa70924a45514bd828096c10c64',
    'spb.huawei-russia-support.com' => '24b4f52d15452163f43cd15ba25a6257',
    'spb-indesit.russia-centre.com' => '7d1986d0e3f6344ff5b753bcc5e92eea',
    'spb.lenovo-russia-support.com' => 'f02a40785a7dc9b9177e725860a9cdb2',
    'spb.lg-russia-mobile.com' => 'f40a3511665c2c957b5dc656d5487d0f',
    'spb.meizu-russia-support.com' => '828dc25900bc863540d12efec7e314d9',
    'spb.msi-russia-support.com' => '91f171094abbfcbd963598e5acb26de4',
    'spb.nikon-russia-support.ru' => '2e8327c13707316517846a0e8d3c1e51',
    'spb.nokia-russia-support.com' => '584608b00111ba1584437ef4a1ef4579',
    'spb.panasonic-russia-mobile.ru' => '6016c35beef734e123e9a5de9c21a712',
    'spb.philips-russia-mobile.ru' => '9e869901d21308b7c67d2aaadcacc37d',
    'spb.galaxy-russia-mobile.com' => 'b7999a7345380c0600eee64dbcf24c30',
    'spb.xperia-russia.com' => '27a75715fe8efcf0f280676a37d1b7b6',
    'spb.toshiba-russia-mobile.ru' => 'f9badcc24a5b76634a57ce5837931722',
    'spb.xiaomi-russia-support.com' => 'e8d8afeeafd38a22fe72a36b53ee8fd0',
    'spb-zte.russia-mobile.com' => '5bdad3e58dfe40a8935c7385dd2c2c3d',
    'vlg.acer-russia-support.ru'=>'260fdf2f43012db561f195fc54fff8cf',
    'vlg.apple-russia-mobile.com'=>'4fd07e30b680e76e1f9e8c67f2d1d275',
    'vlg.asus-russia-support.com'=>'da235e6d1ca0d8408f9b9dd5efa92855',
    'vlg.canon-russia-support.ru'=>'7013678ec1d75ce0be8ecaa9e7d26d78',
    'vlg.dell-russia-support.com'=>'7d11d0f05ca7fc2a032e01a930b349f1',
    'vlg.hp-russia-support.com'=>'f60b8038ee574ae331f3762baa3868c9',
    'vlg.htc-russia-support.ru'=>'8db82b7899a959647afe9fcfe857446e',
    'vlg.huawei-russia-support.com'=>'2d31cdd3b68b54ba3342ec784c113e7f',
    'vlg.lenovo-russia-support.com'=>'8219585c5fb2fc820f9a1aeedb08a319',
    'vlg.lg-russia-mobile.com'=>'3a60dba6331674065e009ccf0e4c423b',
    'vlg.meizu-russia-support.com'=>'49f699e129be7bfbe3eca96f9c4dff08',
    'vlg.msi-russia-support.com'=>'200be87eb98837e31b7ab4d8a1c92cda',
    'vlg.nikon-russia-support.ru'=>'31f8400fa4f815aa3a805631e4277180',
    'vlg.nokia-russia-support.com'=>'8d664217bf66f5212a94158791c6ef80',
    'vlg.galaxy-russia-mobile.com'=>'efe6e8776de25335e5539c46f9381dd0',
    'vlg.xperia-russia.com'=>'4e6b589949d2e37d79cbae400ed44e6e',
    'vlg.toshiba-russia-mobile.ru'=>'68360376f798fae6298841d0837b13f2',
    'vlg.xiaomi-russia-support.com'=>'26f21550188a3ce1271609619d799b95',
    'vrn.acer-russia-support.ru'=>'5d21c2c8387da598f5dbb94095d990b8',
    'vrn.apple-russia-mobile.com'=>'be13f188702f6825b430a15595daf13f',
    'vrn.asus-russia-support.com'=>'d566132691db318e773150232fcd8d3c',
    'vrn.canon-russia-support.ru'=>'2ef36b154e10b0f8a97d1106c8a16b53',
    'vrn.dell-russia-support.com'=>'fa69bb307b9a91e7bf251776b0793727',
    'vrn.hp-russia-support.com'=>'001abe5a739a4ccd1b8898cfca7cffba',
    'vrn.htc-russia-support.ru'=>'15bb9b558d2e33df123068de0026746b',
    'vrn.huawei-russia-support.com'=>'2cc314332b1236d4c067b5775224befd',
    'vrn.lenovo-russia-support.com'=>'287c7bb877aaaeac3d617da0a7fa0410',
    'vrn.lg-russia-mobile.com'=>'d15bf49731a09d4b6b2c195d38b564d7',
    'vrn.meizu-russia-support.com'=>'f5604888f28beebd1a478fabe174cf13',
    'vrn.msi-russia-support.com'=>'1cb853c7ede4efa0e69efc4433ce87a9',
    'vrn.nikon-russia-support.ru'=>'1d866e4471d0bf7544e7dd7e2b68836b',
    'vrn.nokia-russia-support.com'=>'caceb7102d8b25fa1fd17eb08f807e05',
    'vrn.galaxy-russia-mobile.com'=>'5e037852167019d96c58419299734b4f',
    'vrn.xperia-russia.com'=>'c7a730dc182ca425b17e4d00fd51bec8',
    'vrn.toshiba-russia-mobile.ru'=>'8390d6b281b9a1a0049e6fd6536ce789',
    'vrn.xiaomi-russia-support.com'=>'5b0c948a028db0ad308af2c634482501',
    'ekb.acer-russia-support.ru'=>'caf2105aebe88b9c06e65247d0715a2e',
    'ekb.apple-russia-mobile.com'=>'64746b7f6a00d331e254c2702a47e234',
    'ekb.asus-russia-support.com'=>'33d19dbf782ce0e2bd54a98e83610af9',
    'ekb.canon-russia-support.ru'=>'5e6d2f7793fb44a491806e1f4aaa32f1',
    'ekb.dell-russia-support.com'=>'92bde1066951e76ff438d940c02742ab',
    'ekb.epson-russia-support.ru'=>'159ea71cb10a10e8e882815874bbdeff',
    'ekb.hp-russia-support.com'=>'6ab66cd2957fb1a74fe1c177da9c29e3',
    'ekb.htc-russia-support.ru'=>'796ba69154aa61077abdff136f04d7b9',
    'ekb.huawei-russia-support.com'=>'cc0a8429bfad6e89add9092eceeda384',
    'ekb.lenovo-russia-support.com'=>'9c03ab1461a1255219720b7be16ff39d',
    'ekb.lg-russia-mobile.com'=>'3944d48fb5c52f0d9eed0e8004278f21',
    'ekb.meizu-russia-support.com'=>'0438a06a13ec590f4d820f132e025e47',
    'ekb.msi-russia-support.com'=>'6f33d7cf3b883ce81cab6d582977cef3',
    'ekb.nikon-russia-support.ru'=>'5ec0788bf8b75a8c38e7c50e4d8c4058',
    'ekb.nokia-russia-support.com'=>'08aacf5e2d1116a4b277dd8c95a66803',
    'ekb.panasonic-russia-mobile.ru'=>'5fcff9b3b199a6053646ac60a22d5286',
    'ekb.philips-russia-mobile.ru'=>'624349060578382b72c23138bde24bf8',
    'ekb.galaxy-russia-mobile.com'=>'41d611226a75ae369c03f80031ca73d2',
    'ekb.xperia-russia.com'=>'b3803ae06ca00fb7e00cd8acb297e263',
    'ekb.toshiba-russia-mobile.ru'=>'00b1eedbdaa072d587acb822fdf694a0',
    'ekb.xiaomi-russia-support.com'=>'a00eed6ac4b9bba72eac1ab2289c4ab8',
    'krd.acer-russia-support.ru'=>'12ba6f449303866d428ba297f9569d0b',
    'krd.apple-russia-mobile.com'=>'919fbd5beb26048e7ea4c7de528faa0f',
    'krd.asus-russia-support.com'=>'c3a4c788fc159ff9760855dfa270774a',
    'krd.canon-russia-support.ru'=>'57cf1ac293197ddd4d226c5d72de32cc',
    'krd.dell-russia-support.com'=>'143fb78e4bd72c886ce538dfdee952fa',
    'krd.hp-russia-support.com'=>'e026818e68bd9a0bd8a05b7240b8c760',
    'krd.htc-russia-support.ru'=>'41550a5ca4eb207acbc40f64f0b8d5ca',
    'krd.huawei-russia-support.com'=>'1199ced45088436d41f1e4b71afc9e38',
    'krd.lenovo-russia-support.com'=>'1e9c20b54697e3f5bd03f96dca7e9f1f',
    'krd.lg-russia-mobile.com'=>'b68423f9df75e741aa20df79cbca2b90',
    'krd.meizu-russia-support.com'=>'3fd51a682a7db78858a868f7a1a3c730',
    'krd.msi-russia-support.com'=>'d1ec015671e1a8a785c4d2836710aac3',
    'krd.nikon-russia-support.ru'=>'2dae6e892a32ecec8c87f96abba36118',
    'krd.nokia-russia-support.com'=>'b48023b129c10ff1b3f3ca6ad4402072',
    'krd.galaxy-russia-mobile.com'=>'95b42c52650cc528fa43c54a574051fa',
    'krd.xperia-russia.com'=>'aadebab0cb87a6f99e0dc37e291aa036',
    'krd.toshiba-russia-mobile.ru'=>'04305a50d0606338df954f36c630eb75',
    'krd.xiaomi-russia-support.com'=>'4c8767c2f6731e5eec68c4e234c93ed5',
    'lip.acer-russia-support.ru'=>'808de22dab0f8e9d79b8177c5bfe19f1',
    'lip.apple-russia-mobile.com'=>'0a743789eebdfe2d8edf18ae32378843',
    'lip.asus-russia-support.com'=>'9c40497c0f9b5d4d111a3f4cde652eb6',
    'lip.canon-russia-support.ru'=>'0642fb46eea6d31eb35e90cbde31f48f',
    'lip.dell-russia-support.com'=>'5585885c8553e3e3f0e94fd259417566',
    'lip.hp-russia-support.com'=>'a3343f289ca9cb2bd85c39dbc48575da',
    'lip.htc-russia-support.ru'=>'0cae5504a03378ac3b74086d2040ec66',
    'lip.huawei-russia-support.com'=>'b69ab345f2cd284da5e3a7a11a9c78b4',
    'lip.lenovo-russia-support.com'=>'51c536935dbe6a9816e44823d7a0fe63',
    'lip.lg-russia-mobile.com'=>'02875b208711bdb33fc8260b8c46ef5e',
    'lip.meizu-russia-support.com'=>'7fe01178ec38064f27be0f6dfed7db3e',
    'lip.msi-russia-support.com'=>'f641bdaea8fbb6cf817e6bcc408fbe53',
    'lip.nikon-russia-support.ru'=>'7c14b850f37dacbb7c26b1862428b011',
    'lip.nokia-russia-support.com'=>'cbf3df6bfd4fbf3bb5e1090f74436c7a',
    'lip.galaxy-russia-mobile.com'=>'da8ce81678c49ed94c3827ec485d847c',
    'lip.xperia-russia.com'=>'192a618a2eee896f1ecf9db47e449f57',
    'lip.toshiba-russia-mobile.ru'=>'09d6178bc4daaecaf58aaba7b8ed83b2',
    'lip.xiaomi-russia-support.com'=>'49c0f3efbf96a7b4433a18e47c8d95a6',
    'pdl.acer-russia-support.ru'=>'68b14ebe3b34b329624ab4cd859b574e',
    'pdl.apple-russia-mobile.com'=>'1d78bd2f94c0c1e1d753ca926064a33a',
    'pdl.asus-russia-support.com'=>'6e84ba5a13364e34f1458fab033508d1',
    'pdl.canon-russia-support.ru'=>'4420157f97b05667e63269c35709e1e2',
    'pdl.dell-russia-support.com'=>'32cb76d8f215b5c05d0f4cbb7c2425e7',
    'pdl.hp-russia-support.com'=>'d456f8bd5d0d7114b519c2200129a016',
    'pdl.htc-russia-support.ru'=>'4eae7a164c72cdc0c03b98008768bf57',
    'pdl.huawei-russia-support.com'=>'8f3d16a58e4425b93d039f25da9456bc',
    'pdl.lenovo-russia-support.com'=>'e99d9129393fba3e7298e0fdc94a3959',
    'pdl.lg-russia-mobile.com'=>'65296ddbb438dcab15acc6a515e2ff18',
    'pdl.meizu-russia-support.com'=>'007dac7186cd846a2e678b6ff5358340',
    'pdl.msi-russia-support.com'=>'c3883daf1da03196f3f3c79928f5f4bf',
    'pdl.nikon-russia-support.ru'=>'f1309ab286f4ecac1e1150724ae746ea',
    'pdl.nokia-russia-support.com'=>'8e6568ed91b6e1a7fc1d3475ff65c98f',
    'pdl.galaxy-russia-mobile.com'=>'4a93166767d1a783b0622b1244126d8e',
    'pdl.xperia-russia.com'=>'885281a79c0b8839d32bdb060ed54821',
    'pdl.toshiba-russia-mobile.ru'=>'f1c57e8cb1b652805431d067753a3dc1',
    'pdl.xiaomi-russia-support.com'=>'2cd178d303dbb530b62c29f08ddf0856',
    'ros.apple-russia-mobile.com'=>'6a124cf70834ca476594110b2b543752',
    'ros.asus-russia-support.com'=>'6539138ed9e267f4c88a5247a5466d53',
    'ros.canon-russia-support.ru'=>'f7d86a5de296f42a99288b28477e619f',
    'ros.dell-russia-support.com'=>'b7f1de1ed11239099f960583c0d98cd4',
    'ros.hp-russia-support.com'=>'f908d959fddbc8259a44ca5cd757b440',
    'ros.htc-russia-support.ru'=>'b0cd2f734025e178f5f7a8eac65f2d0f',
    'ros.huawei-russia-support.com'=>'fc0b364f8948a8f0d426dfd328dac0ad',
    'ros.lenovo-russia-support.com'=>'7e1ce78d0cbda2334f12353d3a107a9f',
    'ros.lg-russia-mobile.com'=>'957f800a4db0bcb35c6d26e991421dc7',
    'ros.meizu-russia-support.com'=>'f527b1f5b3e030db40975736e5a4773b',
    'ros.msi-russia-support.com'=>'0b15857bbf7bd8f4d4bf85162919199a',
    'ros.nikon-russia-support.ru'=>'a018ece8ad94b15cb8ab45496ad9e2d0',
    'ros.nokia-russia-support.com'=>'a35534dd66e2fb7a2fd513738bf02ce8',
    'ros.galaxy-russia-mobile.com'=>'b593d056f684bc1b301defd1561ebe01',
    'ros.xperia-russia.com'=>'e33f0b911689b936a49f6165a12ad5ba',
    'ros.toshiba-russia-mobile.ru'=>'d947d4b9f9685145289bba308307454f',
    'ros.xiaomi-russia-support.com'=>'5d9ededc5cb4742534342de1e9a8803d',
    'tul.apple-russia-mobile.com'=>'de7969b030fe009805d79c2bb1ca4897',
    'tul.asus-russia-support.com'=>'a98af57f69e6e7843483d71488540777',
    'tul.canon-russia-support.ru'=>'e4273614b59c35a1ebf0b95042eada80',
    'tul.dell-russia-support.com'=>'bf2f39e904d454c82e4305994621db6f',
    'tul.hp-russia-support.com'=>'bc04b7aa6f585094d1d68454b0e41c0c',
    'tul.htc-russia-support.ru'=>'2b4851240138cfddcfb395fba34ce91d',
    'tul.huawei-russia-support.com'=>'3698e101a0a3809aa2406b7b096c9a39',
    'tul.lenovo-russia-support.com'=>'72d9155a27988f625eaf1fb9073705ab',
    'tul.lg-russia-mobile.com'=>'d8fa75d1c6fb8b3869ef9693d024bd5e',
    'tul.meizu-russia-support.com'=>'74d14a3ef0f654c892189773315c8e85',
    'tul.msi-russia-support.com'=>'b1a04a597690c1b39112d5af5c67d83b',
    'tul.nikon-russia-support.ru'=>'6ea541af5a707c432a40a8d44ffc42e5',
    'tul.nokia-russia-support.com'=>'b5f33cb30341988c0a3af42868bdabd3',
    'tul.galaxy-russia-mobile.com'=>'4ceae31ffd99080f99ab112de885c472',
    'tul.xperia-russia.com'=>'ade9924b5f2a1f3fcf6bb709ddfab5ff',
    'tul.toshiba-russia-mobile.ru'=>'d3936cab70a44e46e8544a4488018fe2',
    'tul.xiaomi-russia-support.com'=>'eb653f374328c98b45910f9ef3d7ebc4',
];
	
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?=$this->_ret['title']?></title>
    <meta name="viewport" content="width=device-width"/>
    <meta name="description" content="<?=$this->_ret['description']?>"/>
    <meta name="geo.region" content="RU<?=(($this->_datas['region']['geo_region']) ? '-'.mb_strtoupper($this->_datas['region']['geo_region']) : '')?>" />
    <meta name="geo.placename" content="<?=$geo_address?>"/>
    <? if ($this->_datas['partner']['x'] && $this->_datas['partner']['y']):?>
    <meta name="geo.position" content="<?=$this->_datas['partner']['x']?>;<?=$this->_datas['partner']['y']?>" />
    <meta name="ICBM" content="<?=$this->_datas['partner']['x']?>, <?=$this->_datas['partner']['y']?>" />
    <? endif; ?>
    
	<?php for ($i=0; $i<count($google_meta); $i++) { 
		if (strpos($this->_datas['site_name'], $google_meta[$i][0]) !== false) { ?>
        <meta name="google-site-verification" content="<?php echo $google_meta[$i][1]; ?>" />
		<?php break; } ?>
	<?php } ?>
	<link rel="icon" href="/wp-content/themes/studiof1/img/<?=$marka_lower?>/<?=$favicon?>" type="image/x-icon"/>
	<?php if( $this->_datas['realHost'] != $this->_datas['site_name'] && strpos($this->_datas['realHost'],'nikon-russia.net') ===false):?>
	    <meta name="yandex" content="noindex, nofollow" />
	<?php endif; ?>
	 
    <meta property="og:title" content="<?=$this->_ret['title']?>" />
    <meta property="og:type" content="website" />
    

    <meta property="og:url" content="https://<?=$this->_datas['site_name']?><?=$url?>" />
    <meta property="og:image" content="https://<?=$this->_datas['site_name']?>/wp-content/themes/studiof1/img/<?=$marka_lower?>/og-<?=$marka_lower?>.jpg" />

    
    <meta property="og:image:width" content="968" />
    <meta property="og:image:height" content="504" />
    <meta property="og:site_name" content="<?=$this->_datas['servicename']?>" />
    <meta property="og:description" content="<?=$this->_ret['description']?>" />
    <meta property="og:locale" content="ru_RU" />
    
    <? if (isset($mail_meta[$this->_datas['site_name']])):?>
        <meta name='wmail-verification' content='<?=$mail_meta[$this->_datas['site_name']]?>' />
    <? endif;?>
    
    <link href='https://fonts.googleapis.com/css?family=Exo+2:300,400,400i,700&subset=cyrillic' rel='stylesheet' type='text/css'/>
    <? $add_slider = '';
    if ($this->_datas['arg_url'] == 'o-nas' || $this->_datas['arg_url'] == 'kontakty') $add_slider = ',/wp-content/themes/studiof1/css/components/slider.css,/wp-content/themes/studiof1/css/components/slidenav.css';
    ?>
    <link href="/min/f=/wp-content/themes/studiof1/css/uikit.css,/wp-content/themes/studiof1/css/style.css<?=$add_slider?>&123456" rel="stylesheet" type="text/css">
    
    
     
     <? $moscow = false; 
     $spb = false;
     if ( count(explode('.', $this->_datas['site_name'])) == 2 ):
        $moscow = true; ?>
        <script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://vk.com/js/api/openapi.js?160",t.onload=function(){VK.Retargeting.Init("VK-RTRG-343259-2k0Dv"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-343259-2k0Dv" style="position:fixed; left:-999px;" alt=""/></noscript>
     <?endif;?>
     
     <? if ( mb_strpos($this->_datas['site_name'], '.russia-mobile.com') !== false ):
            $mas = explode('.', $this->_datas['site_name']);
            if (mb_strpos($mas[0], '-') === false ): 
                $moscow = true;?>
                <script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://vk.com/js/api/openapi.js?160",t.onload=function(){VK.Retargeting.Init("VK-RTRG-343259-2k0Dv"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-343259-2k0Dv" style="position:fixed; left:-999px;" alt=""/></noscript>       
            <?endif;
     endif;?>   
         
         
     <? if (  mb_strpos($this->_datas['site_name'], 'spb') !== false ):
         $spb = true; ?>
        <script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://vk.com/js/api/openapi.js?160",t.onload=function(){VK.Retargeting.Init("VK-RTRG-353167-78aLV"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-353167-78aLV" style="position:fixed; left:-999px;" alt=""/></noscript>
     <?endif;?>                               
    
    <? if ($moscow):?>
    <!-- Facebook Pixel Code -->
    <script>
      !function(f,b,e,v,n,t,s)
      {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
      n.callMethod.apply(n,arguments):n.queue.push(arguments)};
      if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
      n.queue=[];t=b.createElement(e);t.async=!0;
      t.src=v;s=b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t,s)}(window, document,'script',
      'https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', '298625697485886');
      fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
      src="https://www.facebook.com/tr?id=298625697485886&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->  
    <?endif;?>
    
    <? if ($spb):?>
        <!-- Facebook Pixel Code -->
        <script>
          !function(f,b,e,v,n,t,s)
          {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
          n.callMethod.apply(n,arguments):n.queue.push(arguments)};
          if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
          n.queue=[];t=b.createElement(e);t.async=!0;
          t.src=v;s=b.getElementsByTagName(e)[0];
          s.parentNode.insertBefore(t,s)}(window, document,'script',
          'https://connect.facebook.net/en_US/fbevents.js');
          fbq('init', '2915552518485079');
          fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
          src="https://www.facebook.com/tr?id=2915552518485079&ev=PageView&noscript=1"
        /></noscript>
        <!-- End Facebook Pixel Code -->  
    <?endif;?> 
    
    <?if (!$moscow && !$spb):?>
        <script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://vk.com/js/api/openapi.js?160",t.onload=function(){VK.Retargeting.Init("VK-RTRG-365642-aJU6p"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-365642-aJU6p" style="position:fixed; left:-999px;" alt=""/></noscript>
        <!-- Facebook Pixel Code -->
        <script>
          !function(f,b,e,v,n,t,s)
          {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
          n.callMethod.apply(n,arguments):n.queue.push(arguments)};
          if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
          n.queue=[];t=b.createElement(e);t.async=!0;
          t.src=v;s=b.getElementsByTagName(e)[0];
          s.parentNode.insertBefore(t,s)}(window, document,'script',
          'https://connect.facebook.net/en_US/fbevents.js');
          fbq('init', '1170065773174086');
          fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
          src="https://www.facebook.com/tr?id=1170065773174086&ev=PageView&noscript=1"
        /></noscript>
        <!-- End Facebook Pixel Code -->
    <?endif;?>
</head>

<?

//address
$address_choose = $this->_datas['addresis'];

$t_addres = [];
$t_addres_name = [];

foreach ($address_choose as $value)
{
    $value['region_name'] = ($value['region_name']) ? $value['region_name'] : 'Москва';
    
    $t_addres[] = $value;
    $t_addres_name[$value['region_name']] = $value;
}
        
uasort($t_addres, function($a, $b){
    return strcmp($a['region_name'], $b['region_name']);
});

$address_choose = $t_addres;

$p_mode = $this->_datas['p_mode'];

$use_choose_city = (($p_mode == 'VK' || $p_mode == 'FB') && !$moscow && !$spb);  

$ip = $this->_datas['remote'];
$city = '';

$query = $this->_datas['query'];

if ($query && $use_choose_city) 
{
    parse_str($query, $output);
    if (isset($output['find_region']))
    {
        $use_choose_city = false;
    }
}

if ($use_choose_city)
{    
    $use_choose_city = false;
    
    if ($ip)
    {
        /* подключаем библиоткеу для определения ip */
        require_once(__DIR__.'/sxgeo/SxGeo.php');
        $SxGeo = new SxGeo(__DIR__.'/sxgeo/SxGeoCity.dat');
        
        mb_internal_encoding("8bit");
        $region = $SxGeo->getCity($ip);
       
        mb_internal_encoding("UTF-8");
        
        if (isset($region['city']['name_ru']))
        {
            $city = $region['city']['name_ru'];
            
            if (isset($t_addres_name[$city]))
            {
                $use_choose_city = true;
            }
        }
    }
}

$this->_datas['use_choose_city'] = $use_choose_city;
$this->_datas['address_choose'] = $address_choose;
$this->_datas['find_city'] = $city;


// #rat
if(!empty($this->_datas['original_setka_id']) && ($this->_datas['original_setka_id']==1 || $this->_datas['original_setka_id'] ==12)){
    if($this->_datas['original_setka_id'] ==1){
        $attention_text = 'Сервисный центр '.mb_strtoupper($marka).' готов предложить своим клиентам бесконтактную курьерскую доставку. 
                Наш курьер бесплатно приедет на указанный в заявке адрес, предварительно связавшись с вами и 
                обсудив все детали по телефону. Воспользоваться доставкой можно до и после ремонта.';
    }else{
        $attention_text = 'Чтобы отремонтировать технику, не выходя из дома, достаточно сделать заказ на сайте. 
                    Мастер приедет по указанному адресу и отремонтирует неисправное устройство за короткий срок. 
                    Наши сотрудники снабжены масками, антисептиками и регулярно проходят проверку на вирус. ';
    }
}
// var_dump($attention_text);
?>

   


<body>
    <?php if(false):?>
        <div class="attention">
            <img src="/wp-content/themes/studiof1/img/attention.png" alt="альтернативный текст">
        </div>
        
        <div id="attention">
        
            <div class="attention_massage" >
                <p>
                    <?=$attention_text?>
                </p>
            </div>
        </div>
    <?php endif;?> 
    
    
    <div class="sr-header"<?=$sr_style?>>
        <div class="uk-container-center uk-container">
            <div class="uk-flex uk-flex-space-between uk-flex-middle">
                <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-5-10 ">
                    <? if ($url != '/') :?>
                        <a href="/" class="logo <?=$marka_lower?><?=$add_style?>" style="background: url(/wp-content/themes/studiof1/img/<?=$marka_lower?>/<?=$logo_str?>) no-repeat; background-size: contain;"></a>
                    <?else:?>
                        <span class="logo <?=$marka_lower?><?=$add_style?>" style="background: url(/wp-content/themes/studiof1/img/<?=$marka_lower?>/<?=$logo_str?>) no-repeat; background-size: contain;"></span>
                    <?endif;?>
                    
                    <? if ($this->_datas['setka_name'] != 'СЦ-1' || $marka_lower != 'samsung'):?>
                    <div class="uk-text-muted uk-button-dropdown center-mobile" data-uk-dropdown="{pos:'top-right',mode:'click'}" aria-haspopup="true" aria-expanded="false"<?=$add_style2?>>
                        <?php if ($this->_datas['region']['name'] == 'Москва' && $marka_lower == 'nikon') { echo '<span class="uk-text-muted">Сервисный центр фотоаппаратов в </span>'; } else { ?>
                        Сервисный центр <?=mb_strtoupper($marka)?> <span class="uk-hidden-small">в </span><?php } ?>


                        <?php if ( $this->_datas['realHost'] == $this->_datas['site_name'] ) :; ?>
                        <span class="uk-text-muted uk-hidden-small menu-open"<?=$add_style2?>><?=$this->_datas['region']['name_pe']?> <i class="uk-icon-caret-down"></i></span>
                        <div class="uk-dropdown uk-dropdown-small">
                            <ul class="uk-nav uk-nav-dropdown">
                            <?  $t_addresis = $addresis;
                                unset($t_addresis[0]);
                                foreach ($t_addresis as $key => $value)
                                {
                                    $region_name_pe = ($value['region_name_pe']) ? $value['region_name_pe'] : 'Москве';
                                    echo '<li><a href="http://'.$value['site'].($url).'">'.$region_name_pe.'</a></li>';
                                }
                            ?>
                            </ul>
                        </div>
                        <?php else :;?>
                        <span class="uk-text-muted uk-hidden-small"<?=$add_style2?>><?=$this->_datas['region']['name_pe']?></span>
                        <?php endif; ?>
                    </div>
                       
                    <?else:?>
                       <? if ($this->_datas['region']['name'] != 'Москва')
                            echo '<span class="uk-text-muted">Сервисный центр '. mb_strtoupper($marka).' в '.$this->_datas['region']['name_pe'].'</span>';
                          else 
                            echo '<span class="uk-text-muted uk-margin-medium-left" style="display: inline-block; vertical-align: middle;">Ремонт техники<br>'. mb_strtoupper($marka).' в '.$this->_datas['region']['name_pe'].'</span>'; 
                       ?>  
                    <?endif;?>
                </div>
				<?php if($this->_datas['region']['name'] == 'Челябинск' && $marka_lower == 'xiaomi') { ?>
					<form class="search">
						<input type="text" placeholder="Поиск" />
						<!--<input type="submit" />-->
					</form>
				<?php } ?>
                <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-2 uk-text-right sr-header-small uk-hidden-small ">
                    <div class="uk-text-large k-text-bold phone"><a href="tel:+<?=$phone?>"<?=$phone_style?>>(<?=$phone[1].$phone[2].$phone[3]?>) <span><?=$phone[4].$phone[5].$phone[6]."-".$phone[7].$phone[8]."-".$phone[9].$phone[10]?></span></a></div>
                    <div class="uk-text-muted"<?=$add_style2?>><?=$time?></a></div>
                </div>
                <div class="uk-width-small-5-10 uk-text-right uk-visible-small mob-button">
                    <button type="button" class="uk-button uk-margin" data-uk-offcanvas="{target:'#mobmenu'}"><i class="uk-icon-bars"></i></button>
                </div>
                
                <?if ($use_choose_city):?>
                    <div class="city_source uk-text-center">
                        Ваш город
                        <p class="city" data-uk-modal="{target:'#js_cityModal'}"><?=$this->_datas['find_city']?> <i class="uk-icon-caret-down"></i></p>
                        <button type="button" class="uk-button uk-button-success" data-uk-region="<?=$t_addres_name[$city]['site']?>">Да</button>
                        <button type="button" data-uk-modal="{target:'#js_cityModal'}" class="uk-button uk-button-grey">Нет</button>
                    </div>
                <?endif;?>
            </div>
        </div>
    </div>
    
    <div class="sr-navigation uk-hidden-small">
        <div class="uk-container-center uk-container">
            <div class="uk-flex uk-flex-space-between uk-flex-nowrap menu">
                <? foreach ($menu as $key => $value)
                {                
                    if ($key == '#')
                    {
                        echo '<input type="button" class="uk-button" data-uk-modal="{target:\'#status\'}" value="'.$value.'"/>';     
                    }
                    else
                    {
                        if ($url == $key)
                            echo '<span class="active">'.$value.'</span>';
                        else
                            echo '<a href="'.$key.'">'.$value.'</a>'; 
                    }
                }
                ?>
                <!--<p class="menuactived"><i class="uk-icon-medium uk-icon-bars uk-margin-right"></i> Меню</p>-->
            </div>
        </div>
    </div>