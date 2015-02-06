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
     * Get Zoomify Object.
     */
    public function render_zoomify($width = 800, $height = 500) {
        $zoomifyswfurl = $this->_api->get_zoomify_swf_url();
        $zoomifyurl = $this->_api->get_zoomify_url($this->_id);

        $params = array(
            'flashvars' => "zoomifyImagePath=$zoomifyurl",
            'src' => $zoomifyswfurl,
            'menu' => "false",
            'pluginspage' => "http://www.adobe.com/go/getflashplayer" ,
            'type' => "application/x-shockwave-flash",
            'width' => $width,
            'height' => $height,
            'name' => "zoomify-viewer"
        );
        $params = join(' ', $params);

        return <<<HTML5
            <embed $params></embed>
HTML5;
    }

    /**
     * To String
     */
    public function __toString() {
        return $this->_id;
    }
}
