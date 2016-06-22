<?php
/**
 * update
 *
 * Monitor statistics detailing how web servers are currently performing and store those
 * statistics in a database.
 *
 * PHP Thread References
 *
 * MULTITHREADING IN PHP: DOING IT RIGHT!
 *  - http://masnun.com/2013/12/15/multithreading-in-php-doing-it-right.html
 */

date_default_timezone_set('America/New_York');

// Define application enviroment
require_once __DIR__ . '/config/config.mode.inc';

// Based on application mode, load approprate configuration settings
$mode = getenv("APP_MODE");
require_once __DIR__ . '/config/config.' . $mode . '.inc';

// Load up the Composer autoload magic
require_once __DIR__ . '/vendor/autoload.php';
use UberSmith\ServerStatus\ServerUtil;
use UberSmith\ServerStatus\StatusRequestTread;

$threades = [];

$serverUtil = new ServerUtil();
$targetServers = $serverUtil->gatherServers();

// Start thread for each target server
foreach ($targetServers as $server) {
    $threades[$server['server_id']] = new StatusRequestTread($server);
    $threades[$server['server_id']]->start();
}

// main thread to wait for the child threads to return
foreach ($threades as $threadID => $thread) {
    $threades[$threadID]->join();
}
