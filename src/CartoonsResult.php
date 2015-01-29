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
class CartoonsResult extends Result
{
    /**
     * Get document title.
     */
    public function get_title() {
        $str = '';

        if (isset($this->refno_t)) {
            $str = $this->refno_t;

            if (isset($this->altrefno_t)) {
                $str .= ' / ' . $this->altrefno_t;
            }
        }

        return $str;
    }

    /**
     * Get a description.
     */
    public function get_description() {
        if (isset($this->embeddedText_t)) {
            return $this->embeddedText_t;
        }

        return '';
    }
}
