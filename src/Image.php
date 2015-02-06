<?php
/**
 * Special Collections API for is-dev applications.
 *
 * @copyright  2014 Skylar Kelty <S.Kelty@kent.ac.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace unikent\SpecialCollections;

/**
 * Special Collections Image API.
 */
class Image
{
    const FORMAT_THUMB = 'thumb';
    const FORMAT_STANDARD = 'standard';
    const FORMAT_PRINT = 'print';
    const FORMAT_FULL = 'full';

    /**
     * API Ref.
     */
    private $_api;

    /**
     * Image ID.
     */
    private $_id;

    /**
     * Constructor.
     */
    public function __construct($api, $id) {
        $this->_api = $api;
        $this->_id = $id;
    }

    /**
     * Get available formats.
     */
    public function get_formats() {
        return array(
            static::FORMAT_THUMB,
            static::FORMAT_STANDARD,
            static::FORMAT_PRINT,
            static::FORMAT_FULL
        );
    }

    /**
     * Get URL.
     */
    public function get_url($format = 'standard') {
        return $this->_api->get_image_url($this->_id, $format);
    }

    /**
     * To String
     */
    public function __toString() {
        return $this->_id;
    }
}
