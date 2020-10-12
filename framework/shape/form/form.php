<?

namespace framework\shape\form;

use framework\pdo;
use framework\dom\node;
use framework\tools;

class form extends node 
{
    protected $_message = '';
    protected $_submit = '';
    
    public function __construct()
    {
        parent::__construct('form');
        $this->getAttributes()->getClass()->addItems('form');
    }
    
    public function setMessage($message)
    {
        parent::setMessage($message);
        if (!$this->getChildren('message'))
        { 
            $p_node = new node('p');
            $p_node->getAttributes()->getClass()->addItems('error-message');
            $this->addChildren('message', $p_node);   
        }
        $this->getChildren('message')->setChildren($this->_message);
    }
    
    public function fillValuesBase($args, $types = array())
    {
        if (isset($args['id']) && isset($args['table']))
        {
            $table = $args['table'];
            $id =  $args['id'];
            
            $sql = "SELECT * FROM `{$table}` WHERE `id`=:id";
            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array('id' => $id));
            $this->fillValues(current($stm->fetchAll(\PDO::FETCH_ASSOC)), $types);          
        }
    }
    
    public function fillValues($values, $types = array())
    {
        $childrens = $this->_recursion($this->getChildren());
        foreach ($values as $key => $value)
        {
            foreach ($childrens as $children)
            {
                if ($children->getName() === $key)
                {
                    $def = true;
                    if ($types && $value)
                    {
                       if (isset($types[$key]))
                       {
                           switch ($types[$key])
                           {
                                case 8:
                                    $children->setValue(tools::format_phone($value));
                                    $def = false;
                                break; 
                                case 9:                                    
                                    $children->setValue(date('d.m.y H:i:s', $value));
                                    $def = false;
                                break;
                           }
                       }
                       
                    }
                    if ($def) $children->setValue((string) $value);
                    break;
                }
            }
        }
    }
    
    private function _recursion($childrens)
    {
        $arr = array();
        foreach ($childrens as $children)
        {
            if (is_subclass_of($children, 'framework\dom\node'))
            {
                $arr[] = $children;
                if ($children->getChildren()) 
                    $arr = array_merge($arr, $this->_recursion($children->getChildren()));
            }     
        }
        return $arr;
    }
    
    public function setSubmit($submit)
    {
         parent::setSubmit($submit);
         if ($this->_submit !== '')
         {
             if (!$this->getChildren('button-item'))
             { 
                $button_form_item = new form_item('form-block');
                $button = new button();
                $button_form_item->addChildren($button);
                $this->addChildren('button-item', $button_form_item);
              }
              $this->getChildren('button-item')->getChildren(0)->setValue($this->_submit);        
         }
         else
         {
            $this->delChildren('button-item');
         }
    }
}

?>