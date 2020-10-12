<?

namespace framework\ajax\action;

use framework\ajax as ajax;
use framework\dom\node;
use framework\pdo;
use framework\shape\form as form;

class action extends ajax\ajax
{
    public function __construct($args)
    {
        parent::__construct('action');
        $this->getWrapper()->getAttributes()->getClass()->addItems('wide');
        
        $action_wrapper = new node('div');
        
        $name = $args['name'];
        $args['on_submit'] = isset($args['on_submit']) ? (bool) $args['on_submit'] : false;
         
        $this->getWrapper()->getAttributes()->addAttr('id', 'action-'.$name);        
        
        $sql = "SELECT `desc` FROM `actions` WHERE `name`=:name";
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array('name' => $name));
        $desc = $stm->fetchColumn();
        
        $form = new form\form();
        
        $error_str = '';
        if ($args['on_submit'])
        {
            $hook_obj = null;
               
            if (file_exists(__DIR__.'/hooks/'.$name.'.php'))
            {
               $hook = 'framework\\ajax\\action\\hooks\\'.$name;
               $hook_obj = new $hook;  
            }
            
            if (method_exists($hook_obj, 'doAction'))
                $error_str = (string) $hook_obj->doAction();
        }
        
        $hidden = new form\hidden();
        $hidden->setName('name');
        $hidden->setValue($name);              
        $form->addChildren($hidden);        
        
        $form->setSubmit($desc);       
        $form->setMessage($error_str);
     
        $action_wrapper->addChildren($form);        
        
        $this->getWrapper()->addChildren($action_wrapper);
    }
}

interface idoAction
{
    public function doAction();
}

?>