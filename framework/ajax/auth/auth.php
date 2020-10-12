<?  

namespace framework\ajax\auth;

use framework\pdo;
use framework\ajax as ajax;
use framework\ajax\screen\screen;
use framework\shape\form as form;
use framework\dom\node;
use framework\shape\page;

class auth extends ajax\ajax
{
    public function __construct($args = array())
    {
        $create_claster = false;
         
        if (isset($_COOKIE["AUTH"]))
        {
            $sql = "SELECT `id` FROM `users` WHERE `id`=:id";
            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array('id' => base64_decode($_COOKIE["AUTH"])));
            if ($stm->fetchColumn())
                $create_claster = true;
        }
        
        if ($create_claster)
        {
            $screen = new screen(array('number' => 0));
        }
        else
        {
            $name = $args['name'] = isset($args['name']) ? $args['name'] : '';
            $pass = $args['pass'] = isset($args['pass']) ? $args['pass'] : '';    
            $args['on_submit'] = isset($args['on_submit']) ? $args['on_submit'] : false;
            
            $error_str = '';
        
            if ($args['on_submit'])
            {      
                $sql = "SELECT `id`,`pass` FROM `users` WHERE `name`=:name";
                $stm = pdo::getPdo()->prepare($sql);
                $stm->execute(array('name' => $name));
                $original = current($stm->fetchAll(\PDO::FETCH_ASSOC));

                if ($original['pass'] !== base64_encode('grid' . $pass))
                {
                    $error_str = 'Неверный логин или пароль.';
                }
                else
                {
                    setcookie('AUTH', base64_encode($original['id']), time() + 24*60*60, '/');
                    $this->setCode('refresh_page');
                }
            }
            else
            {
                header("HTTP/1.0 403 Forbidden");
            }
            
            $page = page::getInstance();
            $page->getHtml()->getChildren('body')->delChildren('header');          
            $page->getHtml()->getChildren('body')->delChildren('footer');
            
            parent::__construct('auth');          
            
            $this->getWrapper()->getAttributes()->addAttr('id', 'auth-wrapper');
            
            $auth_wrapper = new node('div');
            
            $form = new form\form();
            $name_form_block = new form\form_item('form-block');
            $pass_form_block = new form\form_item('form-block');
    
            $name_node = new form\input_box();
            $name_node->setName('name');
            $name_node->setError('логин');
            
            $pass_node = new form\pass_box(false);
            $pass_node->setName('pass');
            $pass_node->setError('пароль');
            
            $name_form_block->setLabel('Логин');
            $name_form_block->addChildren($name_node);
            
            $pass_form_block->setLabel('Пароль');
            $pass_form_block->addChildren($pass_node);
            
            $form->getAttributes()->getClass()->addItems('form-auth');
            $form->setChildren(array($name_form_block, $pass_form_block));
            $form->fillValues($args);
            $form->setSubmit('Авторизоваться');
            $form->setMessage($error_str);        
            
            $auth_wrapper->addChildren($form);
            $this->getWrapper()->addChildren($auth_wrapper);
        }
    }
}