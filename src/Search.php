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
     * SOLR Client.
     */
    private $_solrclient;

    /**
     * Raw SOLR query.
     */
    private $_query;

    /**
     * Query terms.
     */
    private $_query_terms;

    /**
     * Query modifiers.
     */
    private $_query_modifiers;

    /**
     * Constructor.
     */
    public function __construct($solrclient) {
        $this->_solrclient = $solrclient;
        $this->_query = '';
        $this->_query_terms = array();
        $this->_query_modifiers = array();
    }

    /**
     * Set the query terms.
     */
    public function set_query($key, $value) {
        $this->_query_terms[$key] = $value;
    }

    /**
     * Set a raw SOLR query (if you know what you're doing).
     * Note: This will then ignore everything from set_query()
     */
    public function set_raw_query($query) {
        $this->_query = $query;
    }

    /**
     * Builds a SOLR query.
     */
    private function build_query() {
        if (!empty($this->_query)) {
            return $this->_query;
        }

        $query = array();
        foreach ($this->_query_terms as $k => $v) {
            $query[] = "$k:$v";
        }
        return implode(' AND ', $query);
    }

    /**
     * Limit the number of results.
     */
    public function limit($count) {
        $this->_query_modifiers['limit'] = $limit;
    }

    /**
     * Offset the number of results.
     */
    public function offset($offset) {
        $this->_query_modifiers['offset'] = $offset;
    }

    /**
     * Set the fields we want to return.
     * E.g. array('id', 'refNo')
     */
    public function set_fields($fields = '*') {
        $this->_query_modifiers['fields'] = $fields;
    }

    /**
     * Sort by a specific field.
     * E.g. 'refNo', ASC/DESC
     */
    public function add_sort($field, $direction = 'ASC') {
        if (!isset($this->_query_modifiers['sort'])) {
            $this->_query_modifiers['sort'] = array();
        }

        $this->_query_modifiers['sort'][$field] = $direction;
    }

    /**
     * Return the results.
     */
    public function get_results() {
        $query = $this->build_query();
        $query = $this->_solrclient->createSelect($query);

        if (isset($this->_query_modifiers['limit'])) {
            $query->setRows($this->_query_modifiers['limit']);
        }

        if (isset($this->_query_modifiers['offset'])) {
            $query->setStart($this->_query_modifiers['offset']);
        }

        if (isset($this->_query_modifiers['fields'])) {
            $query->setFields($this->_query_modifiers['fields']);
        }

        if (isset($this->_query_modifiers['sort'])) {
            foreach ($this->_query_modifiers['sort'] as $k => $dir) {
                $dir = $dir == 'ASC' ? $query::SORT_ASC : $query::SORT_DESC;
                $query->addSort($k, $dir);
            }
        }

        $results = array();

        $resultsset = $this->_solrclient->select($query);
        foreach ($resultset as $document) {
            $class = $document->collection = 'cartoons' ? 'CartoonsResult' : 'CollectionsResult';
            $results[] = new $class($document);
        }

        return $results;
    }
}
