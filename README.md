Special Collections PHP API
=====================

[![Latest Stable Version](https://poser.pugx.org/unikent/lib-php-collections/v/stable.png)](https://packagist.org/packages/unikent/lib-php-collections)

Full API docs available here: http://unikent.github.io/lib-php-collections/

Add this to your composer require:
 * "unikent/lib-php-collections": "dev-master"

Example Usage:
```
use \unikent\SpecialCollections\API as SCAPI;

$api = new SCAPI();
$api->set_collection(SCAPI::BCAD); // Or SCAPI::VERDI.

$search = $api->get_search();
$search->set_query('refno', 'GW0047')
$results = $search->get_results();

foreach ($results as $result) {
    echo '<h3>' . $result->get_title() . '</h3>';
    echo '<img src="' . $result->image_url() . '" />';
    echo '<p>' . $result->get_description() . '</p>';
    echo '<br />';
}
```
