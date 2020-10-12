<?

namespace framework\ajax\screen;

use framework\ajax as ajax;
use framework\ajax\clasters\clasters;
use framework\ajax\auth\auth;
use framework\ajax\actions\actions;
use framework\dom\node;
use framework\shape\page;

class screen extends ajax\ajax
{
    public function __construct($args = array())
    {
        parent::__construct('');
        
        $number = isset($args['number']) ? (integer) $args['number'] : 0;
        
        switch ($number)
        {
            case 0:
            
                $h1_str = 'Рабочий стол';
                $main = new clasters(array('claster' => 8));
                $footer_str = 'действия&nbsp;&gt;&gt;';
                $change_screen = '1';
                
            break;
            case 1:
            
                $h1_str = 'Действия';                
                $main = new actions();
                $footer_str = '&lt;&lt;&nbsp;назад';
                $change_screen = '0';
                            
            break;
        }
        
        $h1 = new node('h1');
        $h1->addChildren($h1_str);
        
        $page = page::getInstance();
        
        $page->getHeader()->addChildren($h1);            
        $page->getMain()->setChildren(array($main));
    
        $footer = new node('a');
        $footer->getAttributes()->getClass()->addItems('bold');
        $footer->getAttributes()->addAttr('href', '#');
        $footer->getAttributes()->getClass()->addItems('change-screen');
        $footer->getAttributes()->addAttr('data-screen', $change_screen);
        
        $footer->addChildren($footer_str);
        $page->getFooter()->addChildren($footer);
        
        $this->getWrapper()->addChildren((string) $page->getHtml()->getChildren('body'));
    }      
}

?>