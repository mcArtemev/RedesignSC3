<?
namespace framework\ajax\compare;

use framework\pdo;
use framework\ajax as ajax;

class compare extends ajax\ajax {
    public function __construct($args = array()) {              
        error_reporting(E_ALL);
        ini_set('display_errors', 1);        
        parent::__construct('compare');
        $mode = isset($args['mode']) ? (string) $args['mode'] : '';        
        $this->getWrapper()->getAttributes()->addAttr('id', 'compare-'.$mode);                
        $answer = '';
        
                
        switch ($mode) {
            case 'lidstat':
                
            break;
        
            case 'setka':
                $sites = isset($args['sites']) ? $args['sites'] : array();
                $old_phone_name = isset($args['old_phone_name']) ? $args['old_phone_name'] : '00000000';
                $mango_phone = isset($args['mango_phone']) ? $args['mango_phone'] : '00000000';
                $mango_type = isset($args['mango_type']) ? $args['mango_type'] : 'None';
                $setka_mode = isset($args['setka_mode']) ? $args['setka_mode'] : 'None';
                $user_id = isset($args['user_id']) ? $args['user_id'] : 'None';
                $file = isset($args['file']) ? $args['file'] : 'None'; 

                $sites = explode(",", $sites);

                if ($setka_mode != 'None') {
                    if ($setka_mode == 'require') {
                        if ($user_id != 'None') {
                            //$this->getWrapper()->addChildren("OK!");
                            $this->require_hypersetka($sites, $old_phone_name, $mango_phone, $mango_type, $user_id);
                        }
                    }
                    else if ($setka_mode === 'update') {
                        if ($file != 'None') {
                            $this->update_hypersetka($file);
                        }
                    }
                }                                
            break;
            
            case 'setka_delete_file':
                $file= isset($args['file']) ? $args['file'] : 'None';
                if ($file != 'None') {
                    unlink("framework/ajax/compare/$file"); 
                }         
            break;
            
            case 'get_setka_sites':
                $sites = "";
                $sql = "
                    SELECT
                        sites.name,
                        sites.phone,
                        sites.phone_yd,
                        sites.phone_ga
                    FROM
                        sites
                    ORDER BY
                        sites.name
                ";
                try {
                    $stmt = pdo::getPDO()->prepare($sql);
                    $stmt->execute();
                }
                catch (PDOException $e) {
                    print $e->getMessage();
                }
                while ($row = $stmt->fetch(\PDO::FETCH_NUM)) {   
                    for ($i = 0; $i < 4; $i++) {
                        if (is_null($row[$i]) || $row[$i] == '') {
                            $sites .= "e,";
                        }
                        else {
                            $sites .= "{$row[$i]},";
                        }
                    }                  
                    $sites = trim($sites, ",");
                    $sites .= " ";
                }
                $sites = trim($sites);
                $this->getWrapper()->addChildren($sites);
            break;
        }
    }
	
    
    private function require_lidstat($dop_filter, $old_phone_name, $mango_phone, $mango_type) {

    }
    
    
    private function require_hypersetka($all_sites, $old_phone_name, $mango_phone, $mango_type, $user_id) {
        if ($mango_type == '`mangos`.`name`') {
            $mango_type = 'phone';
        }
        else if ($mango_type == '`yandex`.`name`') {
            $mango_type = 'phone_yd';
        }
        else if ($mango_type == '`google`.`name`') {
            $mango_type = 'phone_ga';
        }        
        
        $sites = [];
        $mirrors = [];
        foreach ($all_sites as $site) {
            $site = explode(" ", $site);
            if ($site[0] === '*') {
                $site = implode(" ", $site);
                $mirrors[] = $site;
            }
            else {
                $site = implode(" ", $site);
                $sites[] = $site;
            }
        }
                
        if (count($sites) === 0) {
            $msg = "<div><h4>По фильтрам выбраны только зеркала. Смена номера произведена не будет.</h4></div>";
        }                                
        else {
            $check_phone = "
                SELECT
                    name,
                    $mango_type
                FROM
                    sites
                WHERE
                    name IN ('".implode("','", $sites)."')
            ";

            $sites = [];
            $dif_sites = [];
            try {
                $stmt = pdo::getPDO()->prepare($check_phone);
                $stmt->execute();                      
            }
            catch (PDOException $e) {
                print $e->getMessage();
            }
            while ($row = $stmt->fetch()) { 
                if ($row[$mango_type] != $old_phone_name) {
                    $dif_sites[] = $row;
                    $sites[] = $row;
                }
                else {
                    $sites[] = $row;
                }
            }
                        
            if (count($mirrors) != 0) {
                $msg = "<div><h4>На следующих сайтах-зеркалах в гиперсетке смена номера не произойдет (в сетке нет зеркал):</div></h4>";
                $msg .= "
                    <table class = 'table table-bordered table-condensed'>
                        <thead>
                            <tr>
                                <th class='text-center'>№</th>
                                <th class='text-center'>Сайт-зеркало</th>
                            </tr>
                        </thead>
                        <tbody>
                ";
                $number = 0;
                foreach ($mirrors as $mirror) {
                    ++$number;
                    $msg .= "
                            <tr>
                                <td class='text-center'>$number</td>
                                <td class='text-center'>$mirror</td>
                            </tr>
                    ";
                }
                $msg .= "
                        </tbody>
                    </table>
                ";
            }
            else {
                $msg = "<div><h4>Хорошо. В выбранных сайтах нет зеркал.</div></h4>";
            }
            
            if (count($dif_sites) === 0) {
                $msg .= "<div><h4>Все прекрасно. Различий в номерах телефонов ciba и гиперсетки не найдено.</div></h4>";
            }
            else {
                $msg .= "<div><h4>Опа. Найдены различия в номерах телефонов ciba и гиперсетки:</div></h4>";
                $msg .= "
                    <table class = 'table table-bordered table-condensed'>
                        <thead>
                            <tr>
                                <th class='text-center'>№</th>
                                <th class='text-center'>Сайт</th>
                                <th class='text-center'>Номер ciba</th>
                                <th class='text-center'>Номер setka</th>
                            </tr>
                        </thead>
                        <tbody>
                ";
                $number = 0;
                foreach ($dif_sites as $site) {
                    ++$number;
                    $msg .= "
                            <tr>
                                <td class='text-center'>$number</td>
                                <td class='text-center'>{$site['name']}</td>
                                <td class='text-center'>{$this->set_phone_mask($old_phone_name)}</td>
                                <td class='text-center'>{$this->set_phone_mask($site[$mango_type])}</td>
                            </tr>
                    ";
                }
                $msg .= "
                        </tbody>
                    </table>
                ";
            } 
            
            $msg .= "<div><h4>Для гиперсетки произойдут следующие изменения:</div></h4>";
            $msg .= "
                <table class = 'table table-bordered table-condensed'>
                    <thead>
                        <tr>
                            <th class='text-center'>№</th>
                            <th class='text-center'>Сайт</th>
                            <th class='text-center'>Номер старый</th>
                            <th class='text-center'>Номер новый</th>
                        </tr>
                    </thead>
                    <tbody>
            ";
            $update_sites = [];
            $number = 0;
            foreach ($sites as $site) {
                ++$number;
                $msg .= "
                        <tr>
                            <td class='text-center'>$number</td>
                            <td class='text-center'>{$site['name']}</td>
                            <td class='text-center'>{$this->set_phone_mask($site[$mango_type])}</td>
                            <td class='text-center'>{$this->set_phone_mask($mango_phone)}</td>
                        </tr>
                ";
                $update_sites[] = $site['name'];
            }
            $msg .= "
                    </tbody>
                </table>
            ";
   
            $file = "$user_id.txt";
            if (!file_exists("framework/ajax/compare/$file")) {
            //if (!file_exists(__DIR__ . "$file")) {
                $query = "
                    UPDATE
                        sites
                    SET
                        $mango_type = '$mango_phone'
                    WHERE
                        name IN ('".implode("','", $update_sites)."')
                ";
                $fp = fopen("framework/ajax/compare/$file", "w");
                //$fp = fopen(__DIR__ . "$file", "w");
                fwrite($fp, $query);
                fclose($fp);
                $msg .= "
                    <input type='hidden' name='user_id' value='$file'>
                ";
            }
            else {
                $msg .= "
                    <input type='hidden' name='user_id' value='created'>
                ";
            }            
        }
        $this->getWrapper()->addChildren($msg);
    }
    
    
    private function update_lidstat() {
        
    }
    
    
    private function update_hypersetka($file) {
        $msg = '';
        if (file_exists("framework/ajax/compare/$file")) {
            $query = file_get_contents("framework/ajax/compare/$file");
            try {
                $stmt = pdo::getPDO()->prepare($query);
                $stmt->execute();                      
                $stmt = null;
            }
            catch (PDOException $e) {
                print $e->getMessage();
            } 
            $msg .= "
                <div><h4>Сайты на гиперсетке также успешно были обновлены.</h4></div>
            ";
        }
        else {
            $msg .= "
                <div><h4>Обновление сайтов на гиперсетке не произошло. Не был найден файл с запросом.</h4></div>
            ";
        }        
        $this->getWrapper()->addChildren($msg);
    }
    
    
    private function set_phone_mask($phone) {
        $a = str_split($phone);
        if (count($a)==11) {
            $phone = "+$a[0] ($a[1]$a[2]$a[3]) $a[4]$a[5]$a[6]-$a[7]$a[8]-$a[9]$a[10]";
        }
        else {
            unset($a);
        }
        return $phone;
    }
}
