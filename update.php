<?php
/**
 * update
 *
 * Monitor statistics detailing how web servers are currently performing and store those
 * statistics in a database.
 */

date_default_timezone_set('America/New_York');

// Load up the Composer autoload magic
require_once __DIR__ . '/vendor/autoload.php';
use UberSmith\ServerStatus\ServerUtil;

$serverUtil = new ServerUtil();
$targetServers = $serverUtil->gatherServers();

foreach ($targetServers as $server) {

}
