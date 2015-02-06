<?php
/**
 * Special Collections API for is-dev applications.
 *
 * @copyright  2014 Skylar Kelty <S.Kelty@kent.ac.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace unikent\SpecialCollections;

/**
 * Special Collections API.
 * 
 * @example ../examples/example-1/run.php How to grab a simple result set.
 */
class API
{
    /**
     * The name of the BCAD collection.
     */
    const BCAD = 'cartoons';

    /**
     * The name of the VERDI collection.
     */
    const VERDI = 'collections';

    /**
     * The solr client we are using.
     */
    private $_solrclient;

    /**
     * API endpoint.
     */
    private $_url;

    /**
     * Our chosen collection.
     */
    private $_collection;

    /**
     * Our port.
     */
    private $_port;

    /**
     * Constructor.
     *
     * @param string $url The endpoint of SOLR.
     * @param string $collection The name of the collection.
     */
    private function __construct($url, $collection, $port = 8080) {
        if ($collection != static::BCAD || $collection != static::VERDI) {
            throw new \Exception("Invalid collection name: '{$collection}'");
        }

        $this->_url = $url;
        $this->_collection = $collection;
        $this->_port = $port;
    }

    /**
     * Set the collection we want to query.
     *
     * @param string $url The endpoint of SOLR.
     * @param string $collection The name of the collection.
     */
    public static final function create($url, $collection) {
        return new static($url, $collection);
    }

    /**
     * Shortcut for creating a live collection.
     * 
     * @param string $collection The name of the collection.
     */
    public final function create_live($collection) {
        return static::create('collections.kent.ac.uk', $collection);
    }

    /**
     * Shortcut for creating a test collection.
     * 
     * @param string $collection The name of the collection.
     */
    public final function create_test($collection) {
        return static::create('collections-test.kent.ac.uk', $collection);
    }

    /**
     * Returns the SOLR client.
     */
    public function solr_client() {
        if (!isset($this->_solrclient)) {
            $this->_solrclient = new \Solarium\Client(array(
                'endpoint' => array(
                    'localhost' => array(
                        'host' => $this->_url,
                        'port' => $this->_port,
                        'path' => '/solr/' . $this->_collection . '/'
                    )
                )
            ));
        }

        return $this->_solrclient;
    }

    /**
     * Returns a search interface.
     */
    public function get_search() {
        return new Search($this->solr_client());
    }
}
