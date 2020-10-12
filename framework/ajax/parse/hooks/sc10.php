<?

namespace framework\ajax\parse\hooks;

use framework\tools;
use framework\pdo;
use framework\rand_it;
use framework\ajax\parse\hooks\pages\sc10\sxgeo\SxGeo;

class sc10 extends sc
{
    public function generate($answer, $params)
    {
        $this->_datas = $this->_datas + $params;
        
        $this->_datas['zoom'] = 16;
                        
        $this->_datas['partner'] = $this->_getPartner($params['partner_id']);      
        $this->_datas['region'] = $this->_getRegion($params['region_id']);
        
        if (isset($params['marka_id']))
        {
            $sql = "SELECT * FROM `markas` WHERE `id`= ?";
            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array($params['marka_id']));
            $this->_datas['marka'] = current($stm->fetchAll(\PDO::FETCH_ASSOC));
    
            $marka_lower = mb_strtolower($this->_datas['marka']['name']); 
            
            include ('pages/sc10/brands.php'); // Бренды и типы устройств
            $all_devices = $all_brands; 
            
            $t = array();
            foreach ($all_devices as $key => $value)
               $t[mb_strtolower($key)] = $value; 
            
            $all_devices = $t;
            
            $this->_datas['all_devices'] = $all_devices[$marka_lower];
           
            $file_name = 'index';
        }
        else
        {
            $file_name = 'black_index';
            
            $this->_datas['all_devices'] = [
                                            ['type' => 'стиральная машина', 'type_m' => 'стиральные машины'],
                                            ['type' => 'сушильная машина', 'type_m' => 'сушильные машины'],
                                            ['type' => 'посудомоечная машина', 'type_m' => 'посудомоечные машины'],
                                            ['type' => 'холодильник', 'type_m' => 'холодильники'],
                                            ['type' => 'телевизор', 'type_m' => 'телевизоры'],
                                            ['type' => 'пылесос', 'type_m' => 'пылесосы'],
                                            ['type' => 'проектор', 'type_m' => 'проекторы'],
                                           ];
        }
        
        $this->_sdek();
       
        $body = $this->_body($file_name, basename(__FILE__, '.php'));
        return array('body' => $body);
    }
    
    private function _sdek()
    {
        $this->_datas['sdek'] = false;
        if ($this->_datas['partner']['email'] == 'litovchenko@list.ru')
        {
            $point = $this->_one_point($this->_datas['region']['name'], $this->_datas['setka_name']);
            if ($point)
            {
                //$this->_datas['partner']['x'] = $point[0];
                //$this->_datas['partner']['y'] = $point[1];
                $this->_datas['partner']['exclude'] = 1;
                $this->_datas['zoom'] = 11;
            }
        }
        return;
    }
}

?>