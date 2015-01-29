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
class CollectionsResult extends Result
{
    /**
     * Get document title.
     */
    public function get_title() {
        return '';
    }

    /**
     * Get a description.
     */
    public function get_description() {
        return '';
    }
}
