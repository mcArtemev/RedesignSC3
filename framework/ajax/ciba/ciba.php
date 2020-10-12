<?

namespace framework\ajax\ciba;

use framework\pdo;
use framework\ajax as ajax;

class ciba extends ajax\ajax {

    public function __construct($args = array())
    {
        parent::__construct('');
		
		$db = pdo::getPdo();
		
		$sites = $db->prepare("SELECT `sites`.`id` AS `id`, `sites`.`name` AS `site`, `sites`.`phone`, `sites`.`phone_yd`, `sites`.`phone_ga`, `sites`.`phone_yd_rs`, `sites`.`phone_yd_mb`, `partners`.`email` FROM `sites` LEFT JOIN `partners` ON `partners`.`id`=`sites`.`partner_id`");
		$sites->execute();
		
		$data = [];
		
		while($row = $sites->fetch(\PDO::FETCH_ASSOC)) {
			$data[$row['site']] = $row;
		}

        $result = serialize($data);
        $this->getWrapper()->addChildren($result);
    }
}

?>