<?php

namespace PSolr\Request;

/**
 * @see http://wiki.apache.org/solr/UpdateXmlMessages#The_Update_Schema
 */
class Field
{
    const UPDATE_REPLACE   = 'set';
    const UPDATE_ADD       = 'add';
    const UPDATE_INCREMENT = 'inc';

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $values;

    /**
     * @var float
     */
    protected $boost;

    /**
     * @var string
     */
    protected $update;

    /**
     * @param string $name
     * @param string|array $values
     * @param float $boost
     */
    public function __construct($name, $values, $boost = 0.0)
    {
        $this->name   = $name;
        $this->values = !is_array($values) ? (array) $values : $values;
        $this->boost  = $boost;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param float $boost
     *
     * @return \PSolr\Request\Document
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
     * @param string $values
     *
     * @return \PSolr\Request\Document
     */
    public function setValues($values)
    {
        $this->values = $values;
        return $this;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @return string
     *
     * @return \PSolr\Request\Document
     */
    public function addValue($value)
    {
        return $this->values[] = $value;
    }

    /**
     * @param string $update
     *
     * @return \PSolr\Request\Document
     *
     * @see http://wiki.apache.org/solr/UpdateXmlMessages#Optional_attributes_for_.22field.22
     */
    public function setAtomicUpdate($update)
    {
        $this->update = $update;
        return $this;
    }

    /**
     * @return string
     */
    public function asXml()
    {
        $xml = '';
        foreach ($this->values as $key => $value) {
            $attributes = '';

            if (!$key && $this->boost > 0.0) {
                $attributes = 'boost="' . (float) $this->boost . '" ';
            }

            if (isset($this->update)) {
                $attributes = 'update="' . SolrRequest::escapeXml($this->update) . '" ';
            }

            $xml .= '<field ' . $attributes . 'name="'. SolrRequest::escapeXml($this->name) . '">';
            $xml .= SolrRequest::escapeXml($value);
            $xml .= '</field>';
        }

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
