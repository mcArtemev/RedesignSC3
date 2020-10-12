<?

namespace framework\ajax\service;

use framework\pdo;
use framework\ajax as ajax;

class service extends ajax\ajax {

    public function __construct($args)
    {
        parent::__construct('');

        $sc = (int)substr($args[0], 5);
        $type = mb_strtolower($args[1]);

        $prefixType = [
          'ноутбук' => 'n',
          'планшет' => 'p',
          'смартфон'=> 'f',
        ];

        if ($sc == 2) {
          $dbh = pdo::getPdo(2);
          $sql = "SELECT services.name, cost FROM services JOIN model_types ON services.model_type_id = model_types.id WHERE model_types.name = ?";
          $params = [$type];
        }
        else if (isset($prefixType[$type])) {
          $prefix = $prefixType[$type];
          $dbh = pdo::getPdo();
          $sql = "SELECT {$prefix}_service_syns.name, price FROM `{$prefix}_service_costs` JOIN {$prefix}_services ON {$prefix}_service_costs.{$prefix}_service_id = {$prefix}_services.id JOIN {$prefix}_service_syns ON {$prefix}_services.id = {$prefix}_service_syns.{$prefix}_service_id WHERE setka_id = ? GROUP BY {$prefix}_services.id";
          $params = [$sc];
        }

        if (isset($dbh)) {
          $stmt = $dbh->prepare($sql);
          $stmt->execute($params);
          $array = [];
          foreach ($stmt->fetchAll() as $v) {
            $array[$v[0]] = $v[1];
          }
        }

        if (!isset($array) || count($array) == 0) {
          $array = $this->getDefault($type);
        }

        $this->getWrapper()->addChildren(json_encode($array));
    }

    private function getDefault($type) {
      $services = require_once "default.php";
      return isset($services[$type]) ? $services[$type] : [];
    }

}

?>
