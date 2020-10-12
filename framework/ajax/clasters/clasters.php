<?

namespace framework\ajax\clasters;

use framework\pdo;
use framework\tools;
use framework\shape\form as form;
use framework\ajax as ajax;
use framework\dom\node;

class clasters extends ajax\ajax
{
    public function __construct($args = array())
    {
        parent::__construct('clasters');
        
        $claster = isset($args['claster']) ? (integer) $args['claster'] : 0;
        $mode = isset($args['mode']) ? (integer) $args['mode'] : 0;
        
        $this->getWrapper()->getAttributes()->addAttr('id', 'clasters-'.$claster);
        $this->getWrapper()->getAttributes()->getClass()->addItems('wide');
        
        $values = array();
        
        $clasters_wrapper = new node('div');
        
        $mode_node = new node('div');
        $mode_node->getAttributes()->getClass()->addItems('change-mode');
        $change_node = new node('a');
        $change_node->getAttributes()->addAttr('href', '#');
        $mode_node->addChildren($change_node);
        
        $form = new form\form();
        $form_block = new form\form_item('form-block');
        $item = new form\select();
        
        $sql = "SELECT `id`, `name`, ISNULL(`sort`) FROM `clasters` ORDER BY ISNULL(`sort`) ASC, `sort` ASC, `id` ASC";
        $data = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
 
        foreach ($data as $value)
            $values[$value['id']] = $value['name'];
            
        $item->setValues(array(0 => '-- выберите --') + $values);
        $item->setName('claster');
        $item->setValue($args['claster']);
        
        $sql = "SELECT `fields`.`label` FROM `fields` INNER JOIN `tables` ON `tables`.`id` = `fields`.`table_id` 
                    WHERE `tables`.`name` = 'clasters' AND `fields`.`name` = 'id'";
        $label = pdo::getPdo()->query($sql)->fetchColumn();
        
        $form_block->setLabel(tools::mb_ucfirst($label)); 
        $form_block->addChildren($item);
        $form->addChildren($form_block);
        $form->getAttributes()->getClass()->addItems('filter');
        
        $sql = "SELECT `name`, `big_data`, ISNULL(`sort`) FROM `tables` WHERE `claster_id`=:claster ORDER BY ISNULL(`sort`) ASC, `sort` ASC, `id` ASC";
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array('claster' => $claster));
        $tables = $stm->fetchAll(\PDO::FETCH_ASSOC);
        
        $edit_tables = array();
        
        if ($mode == 0)
        {
            foreach ($tables as $table)
            { 
                if (!$table['big_data'])
                    $edit_tables[] = new ajax\edit_table\edit_table(array('table' => $table['name']));
            }
            $change_node->addChildren('Режим таблицы');
            $change_node->getAttributes()->addAttr('data-mode', '1');
        }
        else
        {
            foreach ($tables as $table)
            {
                $edit_tables[] = new ajax\color_table\color_table(array('table' => $table['name']));
            }
            $change_node->addChildren('Режим редактирования');
            $change_node->getAttributes()->addAttr('data-mode', '0');
        }
            
        $clasters_wrapper->setChildren(array_merge(array($mode_node, $form), $edit_tables));
        $this->getWrapper()->addChildren($clasters_wrapper);
    }
}