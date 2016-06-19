<?php
/**
 * AsyncStatusRequest class used to mange server status requests using ptthreads
 * http://php.net/manual/en/book.pthreads.php
 *
 * References:
 * - How can one use multi threading in PHP applications
 * http://stackoverflow.com/questions/70855/how-can-one-use-multi-threading-in-php-applications
 */

namespace UberSmith\ServerStatus;

use DoSomething\StatHat\Client as StatHat;
use Exception;

/**
 * Class AsyncStatusRequest
 *
 * @package UberSmith\AsyncStatusRequest
 */
class AsyncStatusRequest extends Thread {
    
    /**
     * The website to request the server status details from.
     * @var string $url
     */
    private $url;
    
    /*
     * The response of the server status request
     * @var string $data
     */
    private $data;
    
    public function __construct($url) {
        $this->url = $url;
    }
    
    public function run() {
        if (($url = $this->url)) {
            /*
             * If a large amount of data is being requested, you might want to
             * fsockopen and read using usleep in between reads
             */
            $this->data = file_get_contents($url);
        } else
            printf("Thread #%lu was not provided a URL\n", $this->getThreadId());  // Thread::getCurrentThreadId()
    }
}
