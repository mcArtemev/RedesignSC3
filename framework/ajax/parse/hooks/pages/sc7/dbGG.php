<?
$sql_charset = 'utf8';
$sql_opt = [
  \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
  \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
  \PDO::ATTR_EMULATE_PREPARES   => false,
];
$sql_host_gg    = '93.95.97.77';
$sql_db_gg      = 'service-3_gg';
$sql_user_gg    = 'service-3_mysql';
$sql_pass_gg    = 'Q0h2H8p9';
$sql_charset_gg = 'utf8';
$sql_dsn_gg     = "mysql:host={$sql_host_gg };dbname={$sql_db_gg};charset={$sql_charset}";
?>