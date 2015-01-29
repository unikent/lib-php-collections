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
abstract class Result
{
    /**
     * Result document.
     */
    protected $_document;

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

    /**
     * Get document title.
     */
    public abstract function get_title();

    /**
     * Get a description.
     */
    public abstract function get_description();

    /**
     * Get an image url (or urls).
     */
    public function image_url($size = 'full') {
        if (!isset($this->file_count_i)) {
            return null;
        }

        if ($this->file_count_i == 1) {
            return "http://collections.kent.ac.uk/api/image.php?request=" . $this->files_t . '/' . $size;
        }

        $files = explode(',', $this->files_t);

        $result = array();
        foreach ($files as $file) {
            $result[] = "http://collections.kent.ac.uk/api/image.php?request=" . $file . '/' . $size;
        }

        return $result;
    }

    /**
     * Get an image thumbnail urls.
     */
    public function thumbnail_url() {
        return $this->image_url('thumb');
    }
}
