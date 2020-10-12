<?

/*spl_autoload_extensions('.php');
spl_autoload_register();

use framework\pdo;

foreach (array('f', 'n') as $suffics)
{
    $table = $suffics.'_service_costs';
    $table2 = $suffics.'_service_id';
    $table3 = $suffics.'_services';
    $table4 = $suffics.'_service_syns';
    
    $sql = "SELECT  `{$table4}`.`name` as `name`, `{$table}`.`price` as `price`, `setkas`.`name` as `setka_name` FROM `{$table}`
            LEFT JOIN `setkas` ON `setkas`.`id` = `{$table}`.`setka_id`
            LEFT JOIN `{$table3}` ON `{$table}`.`{$table2}` = `{$table3}`.`id`
            LEFT JOIN `{$table4}` ON `{$table3}`.`id` = `{$table4}`.`{$table2}` GROUP BY `setkas`.`id`, `$table4`.`$table2` ORDER BY `setkas`.`id`, `{$table4}`.`id` ASC";
            
    echo $sql.PHP_EOL;  
    $prices = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    
    foreach ($prices as $price)
        echo implode(';', $price).PHP_EOL;
}*/

?>