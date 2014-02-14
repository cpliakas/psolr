# PSolr

[![Build Status](https://travis-ci.org/cpliakas/psolr.png?branch=master)](https://travis-ci.org/cpliakas/psolr)
[![Latest Stable Version](https://poser.pugx.org/cpliakas/psolr/v/stable.png)](https://packagist.org/packages/cpliakas/psolr)

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

### Client Instantiation

```php
use PSolr\Client\SolrClient;
use PSolr\Request as Request;

// Connect to a Solr server.
$solr = SolrClient::factory(array(
    'base_url' => 'http://myserver.com:8080', // defaults to "http://localhost:8983"
    'base_path' => '/solr/myIndex',           // defaults to "/solr"
));

```

### Searching Documents

```php

$select = Request\Select::factory()
  ->setQuery('*:*')
  ->setStart(0)
  ->setRows(10)
;

$response = $select->sendRequest($solr);
$response->numFound();
```

For simple use cases:

```php
$response = $solr->select(array('q' => '*:*'));
```

### Adding Documents

```php
$add = Request\Add::factory();

$document        = new Request\Document();
$document->id    = '123';
$document->title = 'Test document';
$document->tag   = 'Category 1';
$document->tag   = 'Category 2';
$add->addDocument($document);

$response = $add->sendRequest($solr)
```

### Deleting Documents

```php
$response = Request\Delete::factory()
    ->addId('123')
    ->addId('456')
    ->addQuery('platform:solr')
    ->sendRequest($solr)
;
```

### Sending Arbitrary Solr Requests

```php
$response = $solr->get('admin/ping?wt=json')->send()->json();
```

Refer to [Guzzle's documentation](http://guzzlephp.org/http-client/client.html#creating-requests-with-a-client)
for more details on making web requests.

Refer to [Apache Solr's documentation](http://lucene.apache.org/solr/documentation.html)
for more details on the API.

## Integrations

* The [Acquia SDK for PHP](https://github.com/acquia/acquia-sdk-php)

