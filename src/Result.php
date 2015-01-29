<?php
/**
 * Special Collections API for is-dev applications.
 *
 * @copyright  2014 Skylar Kelty <S.Kelty@kent.ac.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace unikent\SpecialCollections;

/**
 * Special Collections Result API.
 */
class Result
{
    /**
     * Result document.
     */
    private $_document;

    /**
     * Constructor.
     */
    public function __construct($document) {
        $this->_document = $document;
    }

    /**
     * Magic get.
     */
    public function __get($k) {
        return $this->_document->$k;
    }

    /**
     * Magic isset.
     */
    public function __isset($k) {
        return isset($this->_document->$k);
    }
}
