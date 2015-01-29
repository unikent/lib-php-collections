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
    public function image_url() {
        if (!isset($this->file_count_i)) {
            return null;
        }

        if ($this->file_count_i == 1) {
            return "http://collections.kent.ac.uk/{$this->collection}/image.php?id=" . $this->files_t;
        }

        $files = explode(',', $this->files_t);

        $result = array();
        foreach ($files as $file) {
            $result[] = "http://collections.kent.ac.uk/{$this->collection}/image.php?id=" . $file;
        }

        return $result;
    }

    /**
     * Get an image thumbnail urls.
     */
    public function thumbnail_url() {
        $urls = $this->image_url();
        if (!$urls) {
            return null;
        }

        if (!is_array($urls)) {
            return $urls . '&size=thumb';
        }

        return array_map(function($url) {
            return $url . '&size=thumb';
        }, $urls);
    }
}
