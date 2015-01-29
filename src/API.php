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
     * The collection we are using.
     */
    private $_collection;

    /**
     * Constructor.
     */
    public function __construct() {
        $this->set_collection(static::BCAD);
    }

    /**
     * Set the collection we want to query.
     *
     * @see \unikent\SpecialCollections\API::BCAD
     * @see \unikent\SpecialCollections\API::VERDI
     * @param string $collection The name of the collection.
     */
    public final function set_collection($collection) {
        if ($collection != static::BCAD || $collection != static::VERDI) {
            throw new \Exception("Invalid collection name: '{$collection}'");
        }

        $this->_collection = $collection;
    }

    /**
     * Returns a search interface.
     */
    public function get_search() {
        return new Search($this->_collection);
    }
}
