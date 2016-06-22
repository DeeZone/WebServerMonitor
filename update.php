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
use UberSmith\ServerStatus\StatusRequestThread;

try
{
    // Load target sites from database
    $serverUtil = new ServerUtil();
    $targetServers = $serverUtil->gatherServers();


    try
    {
        $requestStatus = new RequestStatusAsync($targetServers);
        $results = $requestStatus->sendRequests();
    }
    catch(Exception $e)
    {
        echo '- Status Check Exception: ' . $e->getMessage();
    }
    
    // Write results to database

}
catch(Exception $e) {
    echo '- Pre or Post flight Exception: ' . $e->getMessage();
}
