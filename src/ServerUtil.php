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
        $this->dbConn = new Mysql(
            $config['host'],
            $config['user'],
            $config['password'],
            $config['database']
        );
    }
    
    /**
     *
     * @return array
     */
    private function gatherDBConfig()
    {
        $config = [
            'host'       => 'localhost:8889',
            'user'       => 'root',
            'password'   => 'root',
            'database'   => 'ubersmith',
    
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
        $results = $this->dbConn->fetchRowMany('SELECT * FROM server');
    
        if ($results) {
    
            foreach ($results as $result) {
                $servers[] = [
                    'server_id' => $result['server_id'],
                    'name' => $result['name'],
                    'httpd' => $result['httpd'],
                    'address' => $result['address'],
                    'port' => $result['port']
                ];
            }
    
            return $servers;
    
        }
        else {
            throw new Exception('ServerUtil->gatherServers() failed to gather servers.');
        }
    
    }
    
}
