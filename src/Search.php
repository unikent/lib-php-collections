<?php
/**
 * Special Collections API for is-dev applications.
 *
 * @copyright  2014 Skylar Kelty <S.Kelty@kent.ac.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace unikent\SpecialCollections;

/**
 * Special Collections Search API.
 */
class Search
{
    /**
     * Collection name.
     */
    private $_collection;

    /**
     * Constructor.
     */
    public function __construct($collection) {
        $this->_collection = $collection;
    }

    /**
     * Set the query terms.
     */
    public function set_query() {
    }


    /**
     * Return the results.
     */
    public function get_results() {
    }
}