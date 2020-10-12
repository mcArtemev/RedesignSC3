<?

namespace framework\dom;

class node extends \framework\main 
{
    protected $_tag = '';
    protected $_close = true;
    
    protected $_attributes;
    protected $_children = array();
    
    public function __construct($tag, $close = true)
    {
        $this->setTag($tag);
        $this->setClose($close);
        
        $this->_attributes = new attr();
    }
    
    public function __toString()
    {
        if (!$this->_tag) return '';
        
        $str = '';
        $str .= '<'.$this->_tag.$this->_attributes;
        
        if ($this->_close) 
        {
            $str .= '>';
            foreach ($this->_children as $value)
                $str .= (string) $value;
                
            $str .= '</'.$this->_tag.'>';
        }
        else
            $str .= '/>';
            
        return $str;
    }
}

?>