<?php
$cache = [];
srand($this->_datas['feed']);
function getGadgetsData($brand, $type){
    global $cache;
    switch ($type) {
        case 'камера':
            $type = 'видеокамера';
            break;
        case 'приставка':
            $type = 'игровая приставка';      
            break;
    }
    if (!empty($cache[$brand][$type])) {
        return $cache[$brand][$type];
    }

    $getData = json_decode(file_get_contents("https://gc.cibacrm.com/api?method=get_services&brand={$brand}&type={$type}&api_key=qoWJBPnXpkbiiEQgFJIHxFa0z2KcOL4flbysj1Jx1xTmZcoECx3bVKLRfohxJHBI"), true);
    $geModal = json_decode(file_get_contents("https://gc.cibacrm.com/api?method=get_models&brand={$brand}&type={$type}&api_key=qoWJBPnXpkbiiEQgFJIHxFa0z2KcOL4flbysj1Jx1xTmZcoECx3bVKLRfohxJHBI&url=" . json_encode($_POST)), true);

    $min_price = '';

    // услуги и цены
    if(!empty($getData['response'])){
        $strServices = '';
        $priceTabl = '<table class="priceTable"><tbody>';
        $priceTabl .=    '<tr><td>Название услуги</td><td>';
        // $priceTabl .=    'Сроки ремонта';
        $priceTabl .=    '</td><td>Цена</td></tr>';
        $getData['response'] = array_slice($getData['response'], 0, 15);
        $first='';
        foreach ($getData['response'] as $value) {
            $strServices .= '<tr>';
            if ($value['name'] == 'Диагностика') {
                $first = '<td>' . $value['name'] . '</td><td></td><td>' . $value['min_price'] . '</td>';
            } else {
                $price = rand($value['min_price'], $value['max_price']);
                $price = substr_replace($price, '0', -1);
                if (empty($min_price) || $min_price > $price) {
                    $min_price = $price;
                }
                $strServices .= '<td>' . $value['name'] . '</td><td></td><td>' . $price . ' руб</td>';
            }
            $strServices .= '</tr>';
        }
        $strServices = $priceTabl . $first . $strServices . '</tbody></table>';
    }

    // модели
    if(!empty($geModal['response'])){
        $geModal['response'] = array_reverse($geModal['response']);
        $top3Modals = array_slice($geModal['response'], 0, 3);
        unset($geModal['response'][0], $geModal['response'][1], $geModal['response'][2]);
        shuffle($geModal['response']);
        $geModal['response'] = array_slice($geModal['response'], 0, 6);
        $geModal['response'] = array_merge($top3Modals, $geModal['response']);
        
        $strModal = '<ul class="modelList">';
        foreach ($geModal['response'] as $value) {
            $value['name'] = str_replace(ucfirst($brand),'',$value['name']);
            $value['name'] = str_replace(ucfirst($brand),'',$value['name']);
            trim($value['name']);
            $strModal .= '<li><div>' . $value['name'] . '</div></li>';
        }
        $strModal .= '</ul>';
    }

    $info_block =[
        'services' => (!empty($strServices)) ? $strServices : '',
        'min_price' => (!empty($min_price)) ? $min_price : '',
        'models' => (!empty($strModal)) ? $strModal : '',
    ];
    if (empty($cache[$brand][$type])) {
        $cache[$brand][$type] = $info_block;
    }
    return $info_block;
}
// echo getGadgetsData($brand, $type,$feed)[0];