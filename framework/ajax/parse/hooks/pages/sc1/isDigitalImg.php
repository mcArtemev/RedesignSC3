<?
use framework\tools;
   $isDigital = true;
   foreach ($this->_datas['all_devices'] as $key => $value) {

    switch ($value['type']) {
        case 'стиральная машина':
        case 'сушильная машина':
        case 'холодильник':
        case 'посудомойка':
        case 'робот-пылесос':
        case 'пылесос':
        case 'посудомоечная машина':
            $isDigital = false;
            break;
    }
            switch ($this->_datas['arg_url']) {
            	case 'diagnostika':
            		$imgDigital_SC1 = '/wp-content/uploads/2015/03/diagnostics-SC1.jpg';
            		$imgDigital_SC1b = '/wp-content/uploads/2015/03/diagnostics-SC1b.jpg';
            		break;
            	case 'sroki':
            		$imgDigital_SC1 = '/wp-content/uploads/2015/03/srokiSC1.jpg';
            		$imgDigital_SC1b = '/wp-content/uploads/2015/03/srokiSC1b.jpg';
            		break;
            	case 'dostavka':
            		$imgDigital_SC1 = '/wp-content/uploads/2015/03/dostavkaSC1.jpg';
            		$imgDigital_SC1 = '/wp-content/uploads/2015/03/dostavkaSC1b.jpg';
            		break;
                case 'accessories':
                    $imgDigital_SC1 = '/wp-content/uploads/2015/03/imgContent-Parts.jpg';
                    $imgDigital_SC1 = '/wp-content/uploads/2015/03/imgContent-Parts.jpg';
                    break;
                    
            }
    break;
}

?>
