<?php

namespace PSolr\Request;

use Guzzle\Http\QueryString;
use PSolr\Client\SolrClient;

/**
 * Base class for PSolr request objects.
 */
class SolrRequest extends QueryString
{
    /**
     * @var string|null
     */
    protected $handlerName = null;

    /**
     * $var string
     */
    protected $responseClass = '\PSolr\Response\Response';

    /**
     * @param array $params
     */
    public function __construct(array $params = array())
    {
        parent::__construct($params);
        $this->init();
    }

    /**
     * @param array $params
     *
     * @return \PSolr\Request\SolrRequest
     */
    static public function factory(array $params = array())
    {
        return new static($params);
    }

    /**
     * Initialization hook. Useful for setting default params.
     */
    public function init() {}

    /**
     * {@inheritDoc}
     *
     * Converts booleans to strings.
     */
    public function set($key, $value)
    {
        if (is_bool($value)) {
            $value = $value ? 'true' : 'false';
        }

        return parent::set($key, $value);
    }

    /**
     * @param string $handlerName
     *
     * @return \PSolr\Request\SolrRequest
     */
    public function setHandlerName($handlerName)
    {
        $this->handlerName = $handlerName;
        return $this;
    }

    /**
     * @return string
     */
    public function getHandlerName()
    {
        return $this->handlerName;
    }

    /**
     * Renders the body, most often overridden by request objects that generate
     * JSON or XML, e.g. update requests.
     *
     * @return string|null
     */
    public function renderBody()
    {
        return null;
    }

    /**
     * Escape a value for use in XML.
     *
     * @param string $value
     *
     * @return string
     */
    public static function escapeXml($value)
    {
        return htmlspecialchars($value, ENT_NOQUOTES, 'UTF-8');
    }

    /**
     * Replace control (non-printable) characters from string that are invalid
     * to Solr's XML parser with a space.
     *
     * @param string $rawXml
     *
     * @return string
     *
     * @see http://drupalcode.org/project/apachesolr.git/blob/1dc510227f5077ccbc047be13dcf0de3120b100c:/Apache_Solr_Document.php#l399
     */
    public static function stripCtrlChars($rawXml)
    {
        // @see http://w3.org/International/questions/qa-forms-utf-8.html
        // Printable utf-8 does not include any of these chars below x7F
        return preg_replace('@[\x00-\x08\x0B\x0C\x0E-\x1F]@', ' ', $rawXml);
    }

    /**
     * @param \Psolr\Component\ComponentInterface $component
     *
     * @return \PSolr\Request\SolrRequest
     */
    public function addComponent(ComponentInterface $component)
    {
        $component->preMergeParams($this);
        return $this->overwriteWith($component->toArray());
    }

    /**
     * @param \PSolr\Request\SolrClient $solr
     * @param array|null $headers
     * @param array $options
     *
     * @return \PSolr\Response\Response|\SimpleXMLElement
     *
     * @throws \UnexpectedValueException
     */
    public function sendRequest(SolrClient $solr, $headers = null, array $options = array())
    {
        // If we don't have a request handler, then the passed request is only a
        // component and we cannot execute the search.
        if (null === $this->handlerName) {
            throw new \UnexpectedValueException('Unable to send request: handler name missing');
        }

        // @todo Add a method in \PSolr\Response\Response to normalize the XML
        // in to an array. Just use JSON and all is right in the world.
        $params = $this->toArray();
        $data = $solr->sendRequest($this->handlerName, $params, $this->renderBody(), $headers, $options);
        return is_array($data) ? new $this->responseClass($data, $params) : $data;
    }
}
