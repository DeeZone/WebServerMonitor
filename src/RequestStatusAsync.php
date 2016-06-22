<?php
/**
 * Manage server status requests using Guzzle3 parallel requests
 * http://guzzle3.readthedocs.io/http-client/client.html#sending-requests-in-parallel
 *
 * Other thread references:
 * - How can one use multi threading in PHP applications
 * http://stackoverflow.com/questions/70855/how-can-one-use-multi-threading-in-php-applications
 * - Thread carefully
 * https://blog.madewithlove.be/post/thread-carefully/
 */

namespace UberSmith\ServerStatus;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use GuzzleHttp\Stream\Stream;
use Exception;

/**
 * Class RequestStatusAsync
 *
 * @package UberSmith\ServerStatus
 */
class RequestStatusAsync {

    /**
     * The website to request the server status details from.
     * @var string $url
     */
    private $servers;

    /*
     *
     * @var object $client
     */
    public $client;

    /*
     * The response of the server status request
     * @var string $data
     */
    public $data;

    /**
     * StatusRequestTread constructor.
     *
     * @param array $server
     *   Settings for target server to gather status details for.
     */
    public function __construct($servers)
    {
        $this->servers = $servers;
        $this->client = new Client();
    }

    /**
     * Request server status data asynchronously
     */
    public function sendRequests()
    {

        foreach($this->servers as $server)
        {
            $address = $server['address'];
            if (!empty($server['port'])) {
                $address .= ':' . $server['port'];
            }
            $promises[$server['address']] = $this->client->getAsync($address);
        }
        $results = Promise\settle($promises)->wait();
        $results = Promise\unwrap($promises);

        // @todo Move to separate method
        // Extract body contents from responses
        $statusBodies = [];
        foreach($results as $address => $result)
        {
          $body = $result->getBody();
          $statusBodies[$address] = $body->getContents();
        }

        // Parse responses for values based on httpd class

        return $statuses;
    }

}
