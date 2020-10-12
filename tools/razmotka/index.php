<?php

ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL );
ini_set( 'max_execution_time', 0 );

define( 'DO_ACTION', false );
define( 'DS', DIRECTORY_SEPARATOR );

if ( !DO_ACTION )
    exit('Action is blocked!');

spl_autoload_register( function ( $class ) {
    include  dirname(dirname(dirname(__FILE__ ))) . DIRECTORY_SEPARATOR .  str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
});

use framework\pdo;

$host = 'ruservicecenters.com';
$setka_id = 9;
$servicename = '';
$sitesForInsert = array();

$data_arrays = require_once __DIR__ . DS . 'datas' . DS . 'data_arrays.php';

$dbh = pdo::getPdo();

// ================================================================================================================== //
// Processing
// ================================================================================================================== //

// Add urls

if ( false ) {

    $sql = "SELECT id, name FROM sites WHERE setka_id = 9 AND name != 'asus.ruservicecenters.com'";

    $stmt = $dbh->prepare( $sql );
    $stmt->execute();
    $sitesRaw = $stmt->fetchAll( \PDO::FETCH_KEY_PAIR );

    $sites = array();
    foreach ( $sitesRaw as $id => $name ) {
        $t_arra = array();
        $t_array['sid'] = $id;
        $markaName = preg_replace( '#^[a-z]{3}-([a-z]+).ruservicecenters.com$#', '$1', $name );
        $t_array['mid'] = getMarkaId( $markaName );
        $sites[] = $t_array;
    }


    foreach ($sites as $site ) {

        $params = serialize( array( 'marka_id' => $site['mid'], 'static' => '/' ) );
        $c_date = time();
        $feed = rand();
        $sql = "INSERT INTO urls(`site_id`, `name`, `params`, `date`, `feed`) VALUES ( {$site['sid']}, '/', '{$params}', {$c_date}, $feed )";
        $stmt = $dbh->prepare( $sql );
        $stmt->execute( );
        echo $site['sid'] . '<br>';
    }
}

// Update sites name

if ( false ) {

    /*
     *
     * Update site name, replace dot (.) by period (-) after region name
     *
     * */

    $sql = "SELECT name FROM sites WHERE setka_id = 9 AND name != 'asus.ruservicecenters.com'";

    $stmt = $dbh->prepare( $sql );
    $stmt->execute();
    $sitesRaw = $stmt->fetchAll( \PDO::FETCH_ASSOC );


    foreach ( array_column( $sitesRaw, 'name' ) as $siteName ) {
        $res = updateSiteName( $siteName );
        if ( $res )
            echo $siteName . ' Is Updated' . '<br>';
        else
            echo $siteName . ' Error' . '<br>';
    }
}

// Insert sites in table sites

if ( false ) {

    /*
     *
     * Insert sites in table sites
     *
     * */

    $brandsSql = '';
    foreach ($data_arrays['brands'] as $k => $brand) {
        $brandsSql .= '\'' . $brand . '\'';
        if (isset($data_arrays['brands'][$k + 1]) )
            $brandsSql .= ',';
    }

    $sql = "SELECT * FROM markas WHERE name IN (" . $brandsSql . ")" ;

    $stmt = $dbh->prepare( $sql );
    $stmt->execute();
    $markas = $stmt->fetchAll( \PDO::FETCH_ASSOC );

    foreach ( $data_arrays['regions'] as $k => $region ) {
        foreach ( $markas as $marka) {
            $t_array = array();
            $t_array['name'] = $region[1] . '.' . mb_strtolower($marka['name']) . '.' . $host;
            $t_array['setka_id'] = $setka_id;
            $t_array['servicename'] = $servicename;
            $t_array['phone'] = $region[2];
            $t_array['region_id'] = $k;
            $t_array['partner_id'] = getPartnerId( $region[3], $k );
            $t_array['timestamp'] = time();
            $sitesForInsert[] = $t_array;
        }
    }

    $sql = "INSERT INTO sites(`name`, `setka_id`, `servicename`, `phone`, `region_id`, `partner_id`, `timestamp`) VALUES ";

    $insertQuery = '';

    foreach ( $sitesForInsert as $k => $value ) {
        $insertQuery .= '(\'' .  $value['name'] . '\',\'' . $value['setka_id'] . '\',\'\',\'' . $value['phone']  . '\',\'' . $value['region_id'] . '\',\'' . $value['partner_id'] . '\',\''. $value['timestamp'] . '\'' . ')';
        if (isset($sitesForInsert[$k + 1]) )
            $insertQuery .= ',';
    }

    $sql .= $insertQuery;

    $stmt = $dbh->prepare( $sql );
    $res = $stmt->execute();
}

// ================================================================================================================== //
// Functions
// ================================================================================================================== //

function getMarkaId( $marka ) {
    global $dbh;

    $sql = "SELECT id FROM markas WHERE name = '{$marka}'" ;

    $stmt = $dbh->prepare( $sql );
    $stmt->execute();
    return $stmt->fetch( \PDO::FETCH_COLUMN);
}

function updateSiteName( $name ) {
    global $dbh;

    $sql = "UPDATE sites SET name = '" . preg_replace( '#^([a-z]{3})(?:\.)([a-z]+)(\.ruservicecenters\.com)$#', '$1-$2$3', $name );
    $sql .= "' WHERE name = '" . $name . "' AND setka_id = 9";

    $stmt = $dbh->prepare( $sql );
    return $stmt->execute( );
}

function getPartnerId( $setkaId, $regionId ) {
    global $dbh;

    $sql = "SELECT partner_id FROM sites WHERE region_id = :region_id AND setka_id = :setka_id LIMIT 1";
    $stmt = $dbh->prepare( $sql );
    $stmt->execute( array( 'region_id' => $regionId, 'setka_id' => $setkaId ) );
    return $stmt->fetchColumn();
}