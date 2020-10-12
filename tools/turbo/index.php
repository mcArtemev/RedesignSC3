<?php
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL );
ini_set( 'max_execution_time', 0 );

define( 'DO_FEED', false );
define( 'DO_ACTION', false );

if ( !DO_ACTION )
    exit('Action is blocked!');

define( 'FEED_FILE', 'feed-1.xml' );
define( 'DS', DIRECTORY_SEPARATOR );

define( 'SITE_HOST', 'https://centre.moscow' );
define( 'SITE_ID', '4779' );
define( 'MAX_ITEMS', 500 );
define( 'YA_METRICA', '48054149' );
define( 'GA_ANALYTICS', 'UA-115748006-1' );
define( 'SITE_CATEGORY', 'Ремонт планшетов и ноутбуков, Компьютерный ремонт и услуги, Ремонт сотовых телефонов' );

chdir( '../../../sc2_1' );
define( 'SC2N_DIR', getcwd() );
define( 'FEED_DIR', SC2N_DIR . DS . 'userfiles' . DS . 'feed' );
chdir( __DIR__ );

spl_autoload_register( function ( $class ) {
    include  dirname(dirname(dirname(__FILE__ ))) . DIRECTORY_SEPARATOR .  str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
});

use framework\pdo;
use framework\ajax\parse\parse;
use tools\turbo\src\SomeBrand\YandexTurbo\Feed;
use tools\turbo\src\SomeBrand\YandexTurbo\Channel;
use tools\turbo\src\SomeBrand\YandexTurbo\Counter;
use tools\turbo\src\SomeBrand\YandexTurbo\Item;
use tools\turbo\src\SomeBrand\YandexTurbo\RelatedItem;
use tools\turbo\src\SomeBrand\YandexTurbo\RelatedItemsList;

require_once __DIR__ . DS . 'src' . DS . 'simple_html_dom.php';

$dbh = pdo::getPdo( 2 );

// $sql = "SELECT name FROM urls WHERE params NOT LIKE '%service_id%'"; // All SC2N Urls except services ~ 4500
 $sql = "SELECT `name`, `date` FROM urls WHERE params NOT LIKE '%service_id%' AND params NOT LIKE '%static%'"; // All SC2N Urls except services and Static
//$sql = "SELECT `name`, `date` FROM urls WHERE params LIKE '%static%'"; // Only static urls and pages

$stmt = $dbh->prepare( $sql );
$stmt->execute( );
$rawUrls = $stmt->fetchAll(\PDO::FETCH_KEY_PAIR );

$urls = createUrlsArray( array_keys( $rawUrls ), MAX_ITEMS, SITE_HOST );

unset( $sql, $stmt );

$html = file_get_html( SITE_HOST );

$title = $html->find( 'title',0 );
$title = $title->plaintext;

$descr = $html->find( 'meta[name=\'description\']', 0 );
$descr = $descr->content;

$feed = new Feed();

$channel = new Channel();
$channel
	->title( $title )
	->link( SITE_HOST )
	->description( $descr )
	->language('ru')
//	->adNetwork(Channel::AD_TYPE_YANDEX, 'RA-123456-7', 'first_ad_place')
	->appendTo($feed);

unset( $html, $title, $descr );

$googleCounter = new Counter(Counter::TYPE_GOOGLE_ANALYTICS, GA_ANALYTICS );
$googleCounter->appendTo($channel);

$yandexCounter = new Counter(Counter::TYPE_YANDEX, YA_METRICA);

$iteration = 0;

$start_mu = round( ( memory_get_usage() / 1024 / 1024 ), 2 );
echo 'Start memory usage ' . $start_mu . ' Mb.' . '<br>' ;

foreach ( array_slice( $urls[0], 0, 200  ) as $url ) {
    $iteration++;

    if ( 0 === ( $iteration  % 50 ) ) {
        sleep( 1 );
        echo 'Step ' . $iteration . ': ' . round( ( memory_get_usage() / 1024 / 1024 ), 2 ) . ' Mb.' . '<br>' ;
    }

    $html = file_get_html( $url );

    $title = $html->find( 'title',0 );
    $title = $title->plaintext;

    $descr = $html->find( 'meta[name=\'description\']', 0 );
    $descr = $descr->content;

    $body = $html->getElementsByTagName("body");

    $t_url = ( $url === SITE_HOST ) ? '/'  : str_replace( SITE_HOST . '/', '', $url );
    $pageModDate = date( $rawUrls[$t_url] );

    $item = new Item();
	$item
		->title( $title )
		->link( $url )
		->category( SITE_CATEGORY )
		->turboContent( $body  )
		->pubDate( date($pageModDate ) )
		->appendTo( $channel );
}

echo 'File size: ' . round( strlen( $feed ) / 1024 / 1024, 2 ) . ' Mb.' ;

if ( DO_FEED )
    file_put_contents(  FEED_DIR . DS . FEED_FILE, $feed );

/* Functions */

function createUrlsArray( $urls = array(), $items = 500, $host = '' )
{
	foreach ( $urls as $k => $url ) {
		if ( '/' === $url )
			$urls[$k] = $host;
		else
			$urls[$k] = $host . '/' . $url;
	}

	return array_chunk( $urls, $items );
}