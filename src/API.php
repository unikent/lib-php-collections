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
     * Internal numbers for collections.
     */
    const TYPE_CARTOONS = 1;
    const TYPE_COLLECTIONS = 2;

    /**
     * The name of the Cartoons collection.
     */
    const CARTOONS = 'cartoons';

    /**
     * The name of the Special Collections collection.
     */
    const COLLECTIONS = 'collections';

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
        if ($collection != static::CARTOONS || $collection != static::COLLECTIONS) {
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
     * Returns our numeric type.
     *
     * @internal
     */
    public function get_type() {
        return ($this->_collection == static::CARTOONS) ? static::TYPE_CARTOONS : static::TYPE_COLLECTIONS;
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

    /**
     * CURL shorthand.
     *
     * @internal
     * @param string $url The URL to curl.
     */
    protected function curl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,            $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER,         false);
        curl_setopt($ch, CURLOPT_HTTP_VERSION,   CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 2000);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 2000);

        return curl_exec($ch);
    }

    /**
     * Build a REST URL.
     *
     * @internal.
     */
    protected function build_rest_url($url, $params) {
        $base = '';
        if (substr($this->_url, 0, 4) !== 'http') {
            $base .= 'http://';
        }

        $bcase .= $this->_url;

        $rurl = new \Rapid\URL($bcase . '/api/' . $url, $params);
        return $rurl->out();
    }

    /**
     * Shorthand for API call.
     */
    protected function api_call($url, $params) {
        $url = $this->build_rest_url($url, $params);
        $result = $this->curl($url);
        return json_decode($result);
    }

    /**
     * Returns a list of images in the collection.
     */
    public function list_images() {
        return $this->api_call('images.php', array(
            'collection' => $this->get_type()
        ));
    }
}
