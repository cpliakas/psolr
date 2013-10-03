<?php

namespace PSolr\Test\Client;

use PSolr\Client\RequestHandler;
use PSolr\Client\SolrClient;

class SolrClientTest extends \PHPUnit_Framework_TestCase
{
    public function testClientDefaultConfigs()
    {
        $solr = SolrClient::factory();

        $this->assertEquals('http://localhost:8983', $solr->getConfig('base_url'));
        $this->assertEquals('/solr', $solr->getConfig('base_path'));
        $this->assertEquals(SolrClient::MAX_QUERY_LENGTH, $solr->getConfig('max_query_length'));
    }

    public function testHasHandler()
    {
        $solr = SolrClient::factory();
        $this->assertTrue($solr->hasRequestHandler('select'));
        $this->assertFalse($solr->hasRequestHandler('bad-handler'));
    }

    public function testGetHandler()
    {
        $solr = SolrClient::factory();
        $select = $solr->getRequestHandler('select');
        $this->assertTrue($select instanceof RequestHandler);
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testGetBadHandler()
    {
        $solr = SolrClient::factory();
        $select = $solr->getRequestHandler('bad-handler');
    }

    public function testRemoveHandler()
    {
        $solr = SolrClient::factory();
        $solr->removeRequestHandler('select');
        $this->assertFalse($solr->hasRequestHandler('select'));
    }

    public function testNormalizeParams()
    {
        $solr = SolrClient::factory();
        $handler = $solr->getRequestHandler('select');
        $expected = array('wt' => 'json', 'json.nl' => 'map', 'q' => 'test');

        $params = $solr->normalizeParams($handler, 'test');
        $this->assertEquals($params, $expected);

        $params = $solr->normalizeParams($handler, array('q' => 'test'));
        $this->assertEquals($params, $expected);

        $params = $solr->normalizeParams($handler, new \ArrayObject(array('q' => 'test')));
        $this->assertEquals($params, $expected);
    }

    public function testPing()
    {
        $solr = SolrClient::factory();
        $response = $solr->ping();
        $this->assertEquals(array(), $response);
    }
}