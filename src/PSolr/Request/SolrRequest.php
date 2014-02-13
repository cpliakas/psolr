<?php

namespace PSolr\Request;

use PSolr\Client\SolrClient;

class SolrRequest extends \ArrayObject
{
    /**
     * @var string|null
     */
    protected $body;

    /**
     * @var protected
     */
    protected $handlerName = 'select';

    /**
     * $var string
     */
    protected $responseClass = '\PSolr\Response\Response';

    /**
     * @param array $params
     * @param string|null $body
     */
    public function __construct(array $params = array(), $body = null)
    {
        parent::__construct($params);
        $this->body = $body;
    }

    /**
     * @param array $params
     * @param string|null $body
     *
     * @return \PSolr\Request\SolrRequest
     */
    static public function factory(array $params = array(), $body = null)
    {
        return new static($params, $body);
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->getArrayCopy();
    }

    /**
     * @param string|null $body
     *
     * @return \PSolr\Request\SolrRequest
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBody()
    {
        return $this->body;
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
        $this->exchangeArray(array_merge((array) $this, (array) $component));
        return $this;
    }

    /**
     * @param \PSolr\Request\SolrClient $solr
     * @param array|null $headers
     * @param array $options
     *
     * @return \PSolr\Response\Response|\SimpleXMLElement
     */
    public function sendRequest(SolrClient $solr, $headers = null, array $options = array())
    {
        $body = (string) $this ?: null;
        $params = (array) $this;

        // @todo Add a method in \PSolr\Response\Response to normalize the XML
        // in to an array. Just use JSON and all is right in the world.
        $data = $solr->sendRequest($this->handlerName, $params, $body, $headers, $options);
        return is_array($data) ? new $this->responseClass($data, $params) : $data;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->body ?: '';
    }
}
