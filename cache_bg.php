<?

define('CFG_FOLDER', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'cfg');
define("CFG_FILE", CFG_FOLDER . DIRECTORY_SEPARATOR . 'cfg.php');

$_ENV['CFG_DATA'] = require_once CFG_FILE;

spl_autoload_extensions('.php');
spl_autoload_register();

use framework\ajax\parse\parse;
use framework\pdo;

use framework\ajax\edit_table\hooks\gen_level;
use framework\ajax\edit_table\hooks\fill_new;
use framework\ajax\edit_table\hooks\dell_sites;
use framework\ajax\edit_table\hooks\gen_urls;

// define('TEST_MODE', false);
// define('BATCH_MODE', 1);

// if (!TEST_MODE)
//     parse_str(implode('&', array_slice($argv, 1)), $_POST);
// else
//     $_POST['pid'] = 9;

// function stop($pid)
// {
//     $sql = "DELETE FROM `pids` WHERE `pid`=:pid";
//     $stm = pdo::getPdo()->prepare($sql);
//     $stm->execute(array('pid' => $pid));

//     $sql = "SELECT COUNT(*) FROM `pids`";
//     $pids = (integer) pdo::getPdo()->query($sql)->fetchColumn();

//     if ($pids == 0)
//     {
//         $sql = "UPDATE `customs` SET `value` = '0' WHERE `code` = 'process'";
//         pdo::getPdo()->query($sql);
//     }
// }

// if (isset($_POST['pid']))
// {
//     $pid = $_POST['pid'];

//     if (!TEST_MODE)
//     {
//         $sql = "SELECT `value` FROM `customs` WHERE `code` = 'process'";
//         $process = (integer) pdo::getPdo()->query($sql)->fetchColumn();
        
//         if ($process == 0)
//         {
//             stop($pid);
//             exit();
//         }
//     }

    // if (!BATCH_MODE)
    //     $sql = "SELECT * FROM `batchs` WHERE `pid`=:pid LIMIT 0,10";
    // else
    //     $sql = "SELECT * FROM `batch_site_id` WHERE `pid`=:pid LIMIT 0,1";

    // $stm = pdo::getPdo()->prepare($sql);
    // $stm->execute(array('pid' => $pid));
    // $data = $stm->fetchAll(\PDO::FETCH_ASSOC);

    // if (!$data)
    // {
    //     stop($pid);
    //     exit();
    // }

    // $ids = array();
    // foreach ($data as $d)
    // {
    //     if (!BATCH_MODE)
    //     {
    //         $ajax = new parse(array('site' => $d['site_name'], 'url' => $d['name'],
    //             'mode' => (integer) $d['mode'], 'batch_id' => (integer) $d['id']));
    //     }
    //     else
    //     {     
    
        $date =[
['site_id'=>52631],
['site_id'=>52632],
['site_id'=>52633],
['site_id'=>52634],
['site_id'=>52635],
['site_id'=>52636],
['site_id'=>52637],
['site_id'=>52638],
['site_id'=>52639],
['site_id'=>52640],
['site_id'=>52641],
['site_id'=>52642],
['site_id'=>52643],
['site_id'=>52644],
['site_id'=>52645],
['site_id'=>52646],
['site_id'=>52647],
['site_id'=>52648],
['site_id'=>52649],
['site_id'=>52650],
['site_id'=>52651],
['site_id'=>52652],
['site_id'=>52653],
['site_id'=>52654],
['site_id'=>52655],
['site_id'=>52656],
['site_id'=>52657],
['site_id'=>52658],
['site_id'=>52659],
['site_id'=>52660],
['site_id'=>52661],
['site_id'=>52662],
['site_id'=>52663],
['site_id'=>52664],
['site_id'=>52665],
['site_id'=>52666],
['site_id'=>52667],
['site_id'=>52668],
['site_id'=>52669],
['site_id'=>52670],
['site_id'=>52671],
['site_id'=>52672],
['site_id'=>52673],
['site_id'=>52674],
['site_id'=>52675],
['site_id'=>52676],
['site_id'=>52677],
['site_id'=>52678],

        ];    
        
        foreach($date as $d){    
        $args1 = $args2 = array('site_id' => $d['site_id']);
        
            
         $obj1 = new gen_level();
         $obj1->beforeAdd($args1); //генерация хабовых страниц + служебных

        //   $obj2 = new fill_new();
        //   $obj2->beforeAdd($args2); //сложная генерация страниц с услугами, неисправностями и т.д.
    }
        
        // }
//         $ids[] = $d['id'];
//     }

//     if (!TEST_MODE)
//     {
//         if (!BATCH_MODE)
//             $sql = "DELETE FROM `batchs` WHERE `id` IN (".implode(',', $ids).")";
//         else
//             $sql = "DELETE FROM `batch_site_id` WHERE `id` IN (".implode(',', $ids).")";

//         pdo::getPdo()->query($sql);

//         @exec("php /var/www/www-root/data/www/studiof1-test.ru/cache_bg.php pid={$pid} > /dev/null &", $output, $return_var);

//         if ($return_var == -1)
//         {
//             stop($pid);
//         }
//     }
// }

exit();

?>
