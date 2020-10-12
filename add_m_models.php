<?

spl_autoload_extensions('.php');
spl_autoload_register();

use framework\pdo;
use framework\ajax\edit_table\hooks\m_model_to_sites;
use framework\ajax\edit_table\hooks\model_to_sites;

$sql = "SELECT `sites`.`id` FROM `marka_to_sites`
    INNER JOIN `markas` ON `marka_to_sites`.`marka_id` = `markas`.`id` 
    INNER JOIN `sites` ON `marka_to_sites`.`site_id` = `sites`.`id`
    INNER JOIN `setkas` ON `sites`.`setka_id`= `setkas`.`id`     
            WHERE `setkas`.`name`=:setka_name AND `markas`.`name`=:marka_name";   
            
$stm = pdo::getPdo()->prepare($sql);
$stm->execute(array('setka_name' => 'СЦ-5', 'marka_name' => 'MSI')); 
$sites = $stm->fetchAll(\PDO::FETCH_COLUMN);

print_r($sites);

$sql = "SELECT `m_models`.`id` FROM `m_models` 
                INNER JOIN `markas` ON `markas`.`id` = `m_models`.`marka_id` 
                    WHERE `markas`.`name`=:marka_name AND `m_models`.`brand` = 0";   
            
$stm = pdo::getPdo()->prepare($sql);
$stm->execute(array('marka_name' => 'MSI')); 
$m_models = $stm->fetchAll(\PDO::FETCH_COLUMN);

print_r($m_models);

/*foreach ($sites as $site)
{
    foreach ($m_models as $m_model)
    {
        $args = array('m_model_id' => $m_model, 'site_id' => $site);
        
        $sql = "INSERT INTO `m_model_to_sites` SET ".pdo::prepare($args);
        $stm = pdo::getPdo()->prepare($sql);  
        $stm->execute($args);   
        
        $gen = new m_model_to_sites();
        $gen->afterAdd($args);
    }
}*/

$sql = "SELECT `models`.`id` FROM `models` WHERE `m_model_id` IN (".implode(',', $m_models).")";
$models = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN);

print_r($models);

/*foreach ($sites as $site)
{
    foreach ($models as $model)
    {
        $args = array('model_id' => $model, 'site_id' => $site);
            
        $sql = "INSERT INTO `model_to_sites` SET ".pdo::prepare($args);
        $stm = pdo::getPdo()->prepare($sql);                               
        $stm->execute($args);
            
        $gen = new model_to_sites();
        $gen->afterAdd($args);                     
    }   
}*/

?>