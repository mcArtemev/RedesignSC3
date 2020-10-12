<?

spl_autoload_extensions('.php');
spl_autoload_register();

define('ONLY_SERVICE', true);

use framework\pdo;
use framework\tools;

/* site */
$site_name = 'asus-centre.com';

$sql = "SELECT `*d` FROM `sites` WHERE `name`= ?";
$stm = pdo::getPdo()->prepare($sql);
$stm->execute(array($site_name));
$data = current($stm->fetchAll(\PDO::FETCH_ASSOC));

$site_id = $data['site_id'];
$service_name = $data['servicename'];

/* global */
$url = 'http://'.$site_name.'/';
$vis_link = 'Ремонт';

$links = array();
$link_h = array();
$link_u = array();

$links[] = array('Ремонт с 10% скидкой', 'order');
$links[] = array('Задать вопрос эксперту', 'ask');

foreach ($links as $key => $link)
{
    $link_h[] = $link[0]
    $link_u[] = 'http://'.$site_name.'/'.$link[1].'/'; 
}

$t_link_h = implode('||', $link_h);
$t_link_u = implode('||', $link_u);
 
/* m_models */
$sql = "SELECT 
            `m_model`.`id` as `id`,
            `m_models`.`name` as `name`, 
            `m_models`.`name` as `ru_name`,
            `markas`.`name` as `marka_name`,
            `markas`.`ru_name` as `marka_ru_name`, 
            `model_types`.`name` as `model_type`
        FROM `m_model_to_sites`
    INNER JOIN `m_models` ON `m_models`.`id` = `m_model_to_sites`.`m_model_id`
    INNER JOIN `markas` ON `markas`.`id` = `m_models`.`marka_id`
    INNER JOIN `model_types` ON `model_types`.`id` = `m_models`.`model_type_id`
         WHERE `site_id`= ?";
         
$stm = pdo::getPdo()->prepare($sql);
$stm->execute(array($site_id));
$m_models = $stm->fetchAll(\PDO::FETCH_ASSOC);

/* models */
$models = array();
$sql = "SELECT 
            `models`.`lineyka` as `lineyka`,
            `models`.`sublineyka` as `sublineyka`,
            `models`.`submodel` as `submodel`,
            `models`.`ru_submodel` as `ru_submodel`,            
            `models`.`ru_submodel_syn` as `ru_submodel_syn`, 
             models`.`ru_lineyka` as `ru_lineyka`,
            `m_models`.`id` as `m_model_id`
        FROM `model_to_sites`
    INNER JOIN `models` ON `models`.`id` = `model_to_sites`.`model_id`
    INNER JOIN `m_models` ON `m_models`.`id` = `models`.`m_models_id`
         WHERE `site_id`= ?";
         
$stm = pdo::getPdo()->prepare($sql);
$stm->execute(array($site_id));
$data = $stm->fetchAll(\PDO::FETCH_ASSOC);

foreach ($data as $value)
    $models[$value['m_model_id']][] = $value;

/* base */
$base = array();
$costs = array();
$t_costs = array();

$accord_suffics = array('ноутбук' => 'n', 'планшет' => 'p', 'смартфон' => 'f');
$tables_array = array('service', 'defect');

foreach ($accord_suffics as $suffics)
{
    foreach ($tables_array as $table)
    {
        $base[$suffics.'_'.$table] = tools::get_base($suffics, $table.'_context_syn');
    }
        
    $t_costs[$suffics] = tools::get_base($suffics, 'service_cost'); 
}

/* costs */ 
foreach ($t_costs as $key => $value)
{
    $costs[$value['setka_id']][$value[$key.'_service_id']] = $value['price'];
}    

$ads = array();
$null_keywords = array();

foreach ($m_models as $m_model)
{
    $suffics = $accord_suffics[$m_model['model_type']];
    $service_table = $base[$suffics.'_service'];
    $service_table[] = 'Ремонт';
    
    foreach ($base[$accord_suffics[$m_model['model_type']].'_service'] as $syn)
    {
        $syn = $syn['name'];
        
        $keywords = array();
        $marka_name = $m_model['marka_name'];
        $marka_ru_name = $m_model['marka_ru_name'];
        
        $header = $syn.' '.$marka_ru_name.' '.$m_model['ru_name'];
        
        $suffics.'_service_id';
        
        $text = 'Ремонт в '.$service_name.'! от '.$costs[$setka_name][''] 
        
        //$header = '#'.$syn.' '.$marka_ru_name.' '.$m_model['ru_name'].'#';
        //if (mb_strlen($header > 33))
        
        foreach ($models[$m_model['id']] as $model)
        {
            if (mb_strtolower($model['lineyka']) != mb_strtolower($model['sublineyka']))
            {
                $keywords[] = $syn.' '.$marka_name.' '.$m_model['name'].' '.$model['submodel'];                
                $keywords[] = $syn.' '.$marka_ru_name.' '.$m_model['name'].' '.$model['submodel'];
                $keywords[] = $syn.' '.$marka_ru_name.' '.$m_model['ru_name'].' '.$model['submodel'];                 
                $keywords[] = $syn.' '.$marka_ru_name.' '.$m_model['ru_name'].' '.$model['ru_submodel'];
                $keywords[] = $syn.' '.$marka_ru_name.' '.$m_model['ru_name'].' '.tools::mb_ucfirst($model['ru_submodel_syn']);
                
                $keywords[] = $syn.' '.$m_model['name'].' '.$model['submodel'];
                $keywords[] = $syn.' '.$m_model['ru_name'].' '.$model['submodel'];                 
                $keywords[] = $syn.' '.$m_model['ru_name'].' '.$model['ru_submodel'];
                $keywords[] = $syn.' '.$m_model['ru_name'].' '.tools::mb_ucfirst($model['ru_submodel_syn']);
                
                if (mb_strlen($model['submodel']) > 1)
                {
                    $null_keywords[] = $syn.' '.$marka_name.' '.$model['submodel'];
                    $null_keywords[] = $syn.' '.$marka_ru_name.' '.$model['submodel'];
                }
                
                if (mb_strlen($model['ru_submodel']) > 1)
                { 
                    $null_keywords[] = $syn.' '.$marka_ru_name.' '.$model['ru_submodel'];
                }
                
                if (mb_strlen($model['ru_submodel_syn']) > 1)
                {
                    $null_keywords[] = $syn.' '.$marka_ru_name.' '.tools::mb_ucfirst($model['ru_submodel_syn']);
                }  
            }
            else
            {
                 $null_keywords[] = array($syn.' '.$marka_name.' '.$model['submodel'];  
                 
                 $null_keywords[] = array($syn.' '.$marka_ru_name.' '.$model['submodel']; 
                 $null_keywords[] = array($syn.' '.$marka_ru_name.' '.$model['ru_submodel'];
                 $null_keywords[] = array($syn.' '.$marka_ru_name.' '.tools::mb_ucfirst($model['ru_submodel_syn']);
                                        
                 $null_keywords[] = array($syn.' '.$marka_name.' '.$model['lineyka'];
                 $null_keywords[] = array($syn.' '.$marka_ru_name.' '.$model['ru_lineyka'];      
            } 
        }        
        
        $keywords[] = $syn.' '.$marka_name.' '.$m_model['name'];               
        $keywords[] = $syn.' '.$marka_ru_name.' '.$m_model['name'];
        $keywords[] = $syn.' '.$marka_ru_name.' '.$m_model['ru_name'];
        
        //$ad = array('header' => $header, 'text' => $text, 'keywords' => $keywords);
        //$ads[] = $ad;
    }                
}


/*foreach ($ads as $ad)
{        
    $t_keywords = implode(";", $ad['keywords']);
    $header = $ad['header'];
    $text = $ad['text'];
    
    $sql = "INSERT INTO `ads_yd` (`header`, `text`, `keywords`, `url`, `vis_link`, `link_h`, `link_u`, `site_name`) VALUES 
            ('{$header}','{$text}', '{$t_keywords}', '{$url}', '{$vis_link}', '{$t_link_h}', '{$t_link_u}', '{$site_name}')"; 
}*/
?>
