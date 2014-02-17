<?php

namespace PSolr\Request;

/**
 * @see http://wiki.apache.org/solr/UpdateXmlMessages#The_Update_Schema
 */
class Document
{
    /**
     * @var \PSolr\Request\Field[]
     */
    protected $fields = array();

    /**
     * @var float
     */
    protected $boost;

    /**
     * @param float $boost
     */
    public function __construct($boost = 0.0)
    {
        $this->setBoost($boost);
    }

    /**
     * @param float $boost
     *
     * @return \PSolr\Request\Document
     *
     * @see http://wiki.apache.org/solr/UpdateXmlMessages#Optional_attributes_on_.22doc.22
     */
    public function setBoost($boost)
    {
        $this->boost = $boost;
        return $this;
    }

    /**
     * @return float
     */
    public function getBoost($boost)
    {
        return $this->boost;
    }

    /**
     * @param \PSolr\Request\Field $field
     *
     * @return \PSolr\Request\Document
     */
    public function addField(Field $field)
    {
        $this->fields[$field->getName()] = $field;
        return $this;
    }

    /**
     * @param type $name
     * @param type $value
     */
    public function __set($name, $value)
    {
        if (isset($this->fields[$name])) {
            $this->fields[$name]->addValue($value);
        } else {
            $this->addField(new Field($name, $value));
        }
    }

    /**
     * @return string
     */
    public function asXml()
    {
        $xml = '<doc>';
        foreach ($this->fields as $field) {
            $xml .= $field;
        }
        $xml .= '</doc>';
        return $xml;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->asXml();
    }
}
