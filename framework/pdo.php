<?

namespace framework;

define('LOCAL', false);

class pdo
{
    private static $_pdo = null;

    private function __construct()
    {

    }

    private function __clone()
    {

    }

    public static function getPdo($num = false,$serv = 'localhost')
    {
        if ($num !== false || self::$_pdo === null)
        {

          if ($num == 2) {
              $dbname = $_ENV['CFG_DATA']['db']['sc2']['db_name'];
              $login = $_ENV['CFG_DATA']['db']['sc2']['sc2-user']['user'];
              $pass = $_ENV['CFG_DATA']['db']['sc2']['sc2-user']['pass'];
          }
          else if ($num == 3) {
              $dbname = $_ENV['CFG_DATA']['db']['sc3']['db_name'];
              $login = 'rootsc3';
              $pass = '1W9l3G9t';
          } else {
              $dbname = $_ENV['CFG_DATA']['db']['service-3_gg']['db_name'];
              $login = $_ENV['CFG_DATA']['db']['service-3_gg']['service-3_mysql']['user'];
              $pass = $_ENV['CFG_DATA']['db']['service-3_gg']['service-3_mysql']['pass'];
          }

       
            if (LOCAL)
                $pdo = new \PDO('mysql:host=93.95.97.77;dbname=sc3;charset=UTF8', 'rootsc3', '1W9l3G9t');
            else
                $pdo = new \PDO('mysql:host=93.95.97.77;dbname='.$dbname.';charset=UTF8', $login, $pass);

            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $pdo->query("SET NAMES utf8");
            if ($num === false) self::$_pdo = $pdo;
            return $pdo;
        }

       return self::$_pdo;
    }

     public static function prepare($source)
     {
        $set = '';

        foreach ($source as $key => $value)
            $set.="`".str_replace("`","``",$key)."`". "=:$key, ";

        return mb_substr($set, 0, -2);
     }
}

?>
