<?

namespace framework\shape\form;

use framework\dom\node;
use framework\enum;

class select extends node
{
    protected $_values = array();
    
    protected $_name = '';
    protected $_value = '';
    protected $_error = '';
    protected $_readonly = false;
    
    public function __construct()
    {
        parent::__construct('select');
    }
    
    public function setName($name)
    {
         parent::setName($name);
         if ($this->_name !== '')
            $this->getAttributes()->setAttr('name', $this->_name);
         else
            $this->getAttributes()->delAttr('name');
    }
    
    public function setValue($value)
    {
        parent::setValue($value);
        $this->refresh("_values");
    }
    
    public function setError($error)
    {
        parent::setError($error);
        if ($this->_error !== '')
        {
            $this->getAttributes()->setAttr('data-error', $this->_error);
            $this->getAttributes()->getClass()->setItems('required', 'required');
        }
        else
        {
            $this->getAttributes()->delAttr('data-error');
            $this->getAttributes()->getClass()->delItems('required');
        }
    }
    
    protected function refresh($property)
    {
        if ($property == '_values')
        {
            $options = array();
            
            if (!$this->getChildren('options'))
            {        
                $values_enum = new enum();
                $values_enum->setSign('');
                $this->addChildren('options', $values_enum);
            }
                
            foreach ($this->_values as $key => $value)
            {
                if (is_array($value))
                {
                    $optgroup_node = new node('optgroup');
                    $optgroup_node->getAttributes()->addAttr('label', $key);
                    $optgroup = array();
                    
                    foreach ($value as $key1 => $value1)
                    {
                        if ($child = $this->getChildren('options')->getItems($key))
                        {
                            if ($child->getChildren($key1))
                                $option_node = $child->getChildren($key1);
                            else
                                $option_node = new node('option');
                        }
                        else
                        {
                            $option_node = new node('option');
                        }  
                        
                        $option_node->getAttributes()->addAttr('value', $key1);
                        $option_node->setChildren($value1);
                        
                        if ($this->_value === (string) $key1) 
                            $option_node->getAttributes()->setAttr('selected', 'selected');
                        else
                            $option_node->getAttributes()->delAttr('selected');
                        
                        $optgroup[$key1] = $option_node;
                    }
                    $optgroup_node->setChildren($optgroup);
                    $options[$key] = $optgroup_node;
                }
                else
                {
                    if ($this->getChildren('options')->getItems($key))
                        $option_node = $this->getChildren('options')->getItems($key);
                    else
                        $option_node = new node('option');  
                    
                    $option_node->getAttributes()->addAttr('value', $key);
                    $option_node->setChildren($value);
                    
                    if ($this->_value === (string) $key) 
                        $option_node->getAttributes()->setAttr('selected', 'selected');
                    else
                        $option_node->getAttributes()->delAttr('selected');
               
                    $options[$key] = $option_node;
               }
            }
            
            $this->getChildren('options')->setItems($options);
        }
    }
    
    public function __toString()
    {
        $str = '';
        
        if ($this->_readonly && $this->_value && $this->_name)
        {
            $name = $this->getAttributes()->getAttr('name');
            $this->getAttributes()->setAttr('name', $name.'-select');
            $this->getAttributes()->setAttr('disabled', 'disabled');
             
            $hidden = new hidden();
            $hidden->setName($this->_name);
            $hidden->setValue($this->_value);
            
            $str .= $hidden;
        }
        
        $str = parent::__toString() . $str;       
       
        return $str;
    }
}

?>