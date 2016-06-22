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

use Guzzle\Batch\Batch;
use Guzzle\Http\BatchRequestTransfer;
use DoSomething\StatHat\Client as StatHat;
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

        $transferStrategy = new BatchRequestTransfer(getenv("MAX_LOAD"));
        $divisorStrategy = $transferStrategy;
        $this->batch = new Batch($transferStrategy, $divisorStrategy);
    }

    /**
     *
     */
    public function sendRequests()
    {

        foreach($this->servers as $server)
        {
            $address = $server['address'];
            if (!empty($server['port'])) {
                $address .= ':' . $server['port'];
            }
            $this->batch->add($address);
        }
        // Flush the queue and retrieve the flushed items
        $results = $batch->flush();

        return $results;
    }

}
