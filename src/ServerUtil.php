<?php
/**
 * Persistent storage utility class to manage interaction with database.
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
     * Define connection details for database.
     *
     * @return array
     */
    private function gatherDBConfig()
    {
        $config = [
            'host'       => getenv('DB_CONFIG_HOST'),
            'user'       => getenv('DB_CONFIG_USER'),
            'password'   => getenv('DB_CONFIG_PASSWORD'),
            'database'   => getenv('DB_CONFIG_DATABASE'),
    
            // optional
            'fetchMode'  => getenv('DB_CONFIG_FETCHMODE'),
            'charset'    => getenv('DB_CONFIG_CHARSET'),
            'port'       => getenv('DB_CONFIG_PORT'),
            'unixSocket' => getenv('DB_CONFIG_UNIXSOCKET'),
        ];
    
        return $config;
    }
    
    /**
     * Gather details of all the target servers. Will be used to make requests to gather server
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
