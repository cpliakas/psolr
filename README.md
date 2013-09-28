# PSolr

A simple PHP client for [Apache Solr](http://lucene.apache.org/solr/) that is
built on top of [Guzzle](http://guzzlephp.org/) and inspired by
[RSolr](https://github.com/mwmitchell/rsolr).

## Installation

PSolr can be installed with [Composer](http://getcomposer.org) by adding the
library as a dependency to your composer.json file.

```json
{
    "require": {
        "cpliakas/psolr": "*"
    }
}
```

After running `php composer.phar update` on the command line, include the
autoloader in your PHP scripts so that the SDK classes are made available.

```php
require_once 'vendor/autoload.php';
```

Please refer to the [Composer's documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction)
for installation and usage instructions.

## Usage

```php

use PSolr\SolrClient;

// Connect to a Solr server.
$solr = SolrClient::factory(array(
    'base_url' => 'http://myserver.com:8080', // defaults to "http://localhost:8983"
    'base_path' => '/solr/myIndex',           // defaults to "/solr"
));

// Send a request to the /select handler.
$response = $solr->select(array('q' => '*:*'));

// Send arbitrary requests to Solr.
// @see http://guzzlephp.org/http-client/client.html#creating-requests-with-a-client
$response = $solr->get('admin/ping?wt=json')->send()->json();

// Set default parameters and execute a simple keyword search.
$solr->setDefaultParams(array(
    'wt' => 'xml',
    'rows' => 15,
));
$solr->select('my keywords');

```

## Integrations

* The [Acquia PHP SDK](https://github.com/cpliakas/acquia-sdk-php)

