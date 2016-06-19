<?php
/**
 * Class ServerUtil
 * 
 */

namespace UberSmith\ServerStatus;

use Simplon\Mysql\Mysql as Mysql;
use DoSomething\StatHat\Client as StatHat;
use Exception;

/**
 * Class ServerUtil
 *
 * @package UberSmith\ServerStatus
 */
class ServerUtil
{
    /**
     * Connection to MySQL database using Simplon.
     * @var object $dbConn
     */
    private $dbConn;

    /**
     * ServerUtil constructor.
     */
    public function __construct()
    {
        $config = $this->gatherDBConfig();
        $this->dbConn = new Mysql($config);
    }

    /**
     *
     * @return array
     */
    private function gatherDBConfig()
    {
        $config = [
            'host'       => 'localhost',
            'user'       => 'rootuser',
            'password'   => 'rootuser',
            'database'   => 'our_database',

            // optional

            'fetchMode'  => \PDO::FETCH_ASSOC,
            'charset'    => 'utf8',
            'port'       => 3306,
            'unixSocket' => null,
        ];

        return $config;
    }

    /**
     * gatherServers(): Gather details of all the target servers. Will be used to make requests to gather server
     * status responses.
     *
     * @return array
     */
    public function gatherServers()
    {
        $servers = [];
        $results = $this->dbConn->fetchColumnMany('SELECT * FROM server');

        foreach ($results as $result) {
            $servers[] = [
                '' => '',
            ];
        }

        return $servers;
    }
    
}
