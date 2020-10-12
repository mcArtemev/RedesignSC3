<?

namespace framework\ajax\actions;

use framework\ajax as ajax;
use framework\dom\node;
use framework\pdo;

class actions extends ajax\ajax {
    
    public function __construct()
    {
        parent::__construct('');
        
        $this->getWrapper()->getAttributes()->getClass()->addItems('wide');

        $actions_wrapper = new node('div');
        $actions_array = array();
      
        try
        { 
            $sql = "SELECT `name`, ISNULL(`sort`) FROM `actions` ORDER BY ISNULL(`sort`) ASC, `sort` ASC, `id` ASC";
            $actions = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN);
            
            foreach ($actions as $action)
                $actions_array[] = new ajax\action\action(array('name' => $action));
        }
        catch (\PDOException $e) 
        {
             $actions_array[] = 'Действия не определены.';
        }
        
        $actions_wrapper->setChildren($actions_array);
        $this->getWrapper()->addChildren($actions_wrapper);
    }
}