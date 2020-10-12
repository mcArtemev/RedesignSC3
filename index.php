<?

define('CFG_FOLDER', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'cfg');
define("CFG_FILE", CFG_FOLDER . DIRECTORY_SEPARATOR . 'cfg.php');

$_ENV['CFG_DATA'] = require_once CFG_FILE;

header('Content-Type: text/html; charset=utf-8');
spl_autoload_extensions('.php');
spl_autoload_register();

define('TEMPLATE_PATH', '/template');
global $argv;
if ($argv) parse_str(implode('&', array_slice($argv, 1)), $_POST); 

if (isset($_POST['op']))
{   
    $op = trim($_POST['op']);
    if (file_exists(__DIR__.'/framework/ajax/'.$op.'/'.$op.'.php'))
    {
        $op = 'framework\\ajax\\'.$op.'\\'.$op;
        if (!isset($_POST['args'])) $_POST['args'] = array();
        $ajax = new $op($_POST['args']);

        echo json_encode(array('answer' => (string) $ajax->getWrapper()->getChildren(0), 'code' => $ajax->getCode()));
    }
    else
    {
       header("HTTP/1.0 404 Not Found");
    }
    exit();
}
 
use framework\shape\page;
use framework\ajax\auth\auth;

$page = page::getInstance();
        
$page->getCss()->addItems(TEMPLATE_PATH.'/css/reset.css');
$page->getCss()->addItems(TEMPLATE_PATH.'/css/style.css');
$page->getJs()->addItems(TEMPLATE_PATH.'/js/jquery-2.2.4.min.js');
$page->getJs()->addItems(TEMPLATE_PATH.'/js/jquery.maskedinput.min.js');
$page->getJs()->addItems(TEMPLATE_PATH.'/js/main.js');

$auth = new auth();
$page->getMain()->addChildren($auth);
echo $page;  

?>