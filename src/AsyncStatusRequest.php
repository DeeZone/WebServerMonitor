<?php
/**
 * AsyncStatusRequest class used to mange server status requests using ptthreads
 * http://php.net/manual/en/book.pthreads.php
 *
 * References:
 * - How can one use multi threading in PHP applications
 * http://stackoverflow.com/questions/70855/how-can-one-use-multi-threading-in-php-applications
 * - Thread carefully
 * https://blog.madewithlove.be/post/thread-carefully/
 */

namespace UberSmith\ServerStatus;

use GuzzleHttp\Client as Client;
use DoSomething\StatHat\Client as StatHat;
use Exception;

/**
 * Class StatusRequestTread
 *
 * @package UberSmith\ServerStatus
 */
// class StatusRequestTread extends Thread {
class StatusRequestTread {
    
    /**
     * The website to request the server status details from.
     * @var string $url
     */
    private $server;
    
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
    public function __construct($server) {
        $this->server = $server;
        $this->client = new Client();
    }

    /**
     *
     */
    public function run() {
        if (($server = $this->server)) {

            $this->data =
        } else
            printf("Thread #%lu was not provided a URL\n", $this->getThreadId());  // Thread::getCurrentThreadId()
    }
}
