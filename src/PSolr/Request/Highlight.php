<?php

namespace PSolr\Request;

/**
 * @see http://wiki.apache.org/solr/HighlightingParameters
 */
class Highlight extends SolrRequest implements ComponentInterface
{
    const FORMATTER_SIMPLE = 'formatter';

    /**
     * {@inheritDoc}
     *
     * Sets the query that is used in the base query.
     */
    public function preMergeParams(SolrRequest $request)
    {
        if (isset($request['q']) && !isset($this['hl.q'])) {
            $this['hl.q'] = $request['q'];
        }
    }

    /**
     * {@inheritDoc}
     */
    public function __construct(array $array = array())
    {
        parent::__construct($array);
        $this->highlight();
    }

    /**
     * @param bool $highlight
     *
     * @return \Psolr\Component\Highlight
     *
     * @see http://wiki.apache.org/solr/HighlightingParameters#hl
     */
    public function highlight($highlight = true)
    {
        $this['hl'] = $highlight ? 'true' : 'false';
        return $this;
    }

    /**
     * @param string $query
     *
     * @return \Psolr\Component\Highlight
     *
     * @see http://wiki.apache.org/solr/HighlightingParameters#hl.q
     */
    public function setQuery($query)
    {
        $this['hl.q'] = $query;
        return $this;
    }

    /**
     * @param int $snippets
     *
     * @return \Psolr\Component\Highlight
     *
     * @see http://wiki.apache.org/solr/HighlightingParameters#hl.snippets
     */
    public function setSnippets($snippets)
    {
        $this['hl.snippets'] = $snippets;
        return $this;
    }

    /**
     * @param int $fragsize
     *
     * @return \Psolr\Component\Highlight
     *
     * @see http://wiki.apache.org/solr/HighlightingParameters#hl.fragsize
     */
    public function setFragsize($fragsize)
    {
        $this['hl.fragsize'] = $fragsize;
        return $this;
    }

    /**
     * @param bool $merge
     *
     * @return \Psolr\Component\Highlight
     *
     * @see http://wiki.apache.org/solr/HighlightingParameters#hl.mergeContiguous
     */
    public function mergeContiguous($merge = true)
    {
        $this['hl.mergeContiguous'] = $merge ? 'true' : 'false';
        return $this;
    }

    /**
     * @param bool $require
     *
     * @return \Psolr\Component\Highlight
     *
     * @see http://wiki.apache.org/solr/HighlightingParameters#hl.requireFieldMatch
     */
    public function requireFieldMatch($require = true)
    {
        $this['hl.requireFieldMatch'] = $require ? 'true' : 'false';
        return $this;
    }

    /**
     * @param int $chars
     *
     * @return \Psolr\Component\Highlight
     *
     * @see http://wiki.apache.org/solr/HighlightingParameters#hl.maxAnalyzedChars
     */
    public function setMaxAnalyzedChars($chars)
    {
        $this['hl.maxAnalyzedChars'] = $chars;
        return $this;
    }

    /**
     * @param string $field
     *
     * @return \Psolr\Component\Highlight
     *
     * @see http://wiki.apache.org/solr/HighlightingParameters#hl.alternateField
     */
    public function setAlternateField($field)
    {
        $this['hl.alternateField'] = $field;
        return $this;
    }

    /**
     * @param int $length
     *
     * @return \Psolr\Component\Highlight
     *
     * @see http://wiki.apache.org/solr/HighlightingParameters#hl.maxAlternateFieldLength
     */
    public function setMaxAlternateFieldLength($length)
    {
        $this['hl.maxAlternateFieldLength'] = $length;
        return $this;
    }

    /**
     * @param bool $preserve
     *
     * @return \Psolr\Component\Highlight
     *
     * @see http://wiki.apache.org/solr/HighlightingParameters#hl.preserveMulti
     */
    public function preserveMulti($preserve = true)
    {
        $this['hl.preserveMulti'] = $preserve ? 'true' : 'false';
        return $this;
    }

    /**
     * @param int $max
     *
     * @return \Psolr\Component\Highlight
     *
     * @see http://wiki.apache.org/solr/HighlightingParameters#hl.maxMultiValuedToExamine
     */
    public function setMaxMultiValuedToExamine($max)
    {
        $this['hl.maxMultiValuedToExamine'] = $max;
        return $this;
    }

    /**
     * @param int $max
     *
     * @return \Psolr\Component\Highlight
     *
     * @see http://wiki.apache.org/solr/HighlightingParameters#hl.maxMultiValuedToMatch
     */
    public function setMaxMultiValuedToMatch($max)
    {
        $this['hl.maxMultiValuedToMatch'] = $max;
        return $this;
    }

    /**
     * @param string $formatter
     *
     * @return \Psolr\Component\Highlight
     *
     * @see http://wiki.apache.org/solr/HighlightingParameters#hl.formatter
     */
    public function setFormatter($formatter)
    {
        $this['hl.formatter'] = $formatter;
        return $this;
    }

    /**
     * @param string $text
     *
     * @return \Psolr\Component\Highlight
     *
     * @see http://wiki.apache.org/solr/HighlightingParameters#hl.simple.pre.2Fhl.simple.post
     */
    public function setSimplePre($text)
    {
        $this['hl.simple.pre'] = $text;
        return $this;
    }

    /**
     * @param string $text
     *
     * @return \Psolr\Component\Highlight
     *
     * @see http://wiki.apache.org/solr/HighlightingParameters#hl.simple.pre.2Fhl.simple.post
     */
    public function setSimplePost($text)
    {
        $this['hl.simple.post'] = $text;
        return $this;
    }

    /**
     * Sets the html element used for highlighting, e.g. "em"
     *
     * @param string $element
     *
     * @return \Psolr\Component\Highlight
     *
     * @see \Psolr\Component\Highlight::setFormatter()
     * @see \Psolr\Component\Highlight::setSimplePre()
     * @see \Psolr\Component\Highlight::setSimplePost()
     */
    public function setHighlighterElement($element)
    {
        return $this
            ->setFormatter(self::FORMATTER_SIMPLE)
            ->setSimplePre('<' . $element . '>')
            ->setSimplePost('</' . $element . '>')
        ;
    }

    /**
     * @param string $fragmenter
     *
     * @return \Psolr\Component\Highlight
     *
     * @see http://wiki.apache.org/solr/HighlightingParameters#hl.fragmenter
     */
    public function setFragmenter($fragmenter)
    {
        $this['hl.fragmenter'] = $fragmenter;
        return $this;
    }

    /**
     * @param string $builder
     *
     * @return \Psolr\Component\Highlight
     *
     * @see http://wiki.apache.org/solr/HighlightingParameters#hl.fragListBuilder
     */
    public function setFragListBuilder($builder)
    {
        $this['hl.fragListBuilder'] = $builder;
        return $this;
    }

    /**
     * @param string $scanner
     *
     * @return \Psolr\Component\Highlight
     *
     * @see http://wiki.apache.org/solr/HighlightingParameters#hl.boundaryScanner
     */
    public function setBoundaryScanner($scanner)
    {
        $this['hl.boundaryScanner'] = $scanner;
        return $this;
    }

    /**
     * @param string $builder
     *
     * @return \Psolr\Component\Highlight
     *
     * @see http://wiki.apache.org/solr/HighlightingParameters#hl.fragmentsBuilder
     */
    public function setFragmentsBuilder($builder)
    {
        $this['hl.fragmentsBuilder'] = $builder;
        return $this;
    }

    /**
     * @param int $maxScan
     *
     * @return \Psolr\Component\Highlight
     *
     * @see http://wiki.apache.org/solr/HighlightingParameters#hl.bs.maxScan
     */
    public function setBoundaryScannerMaxScan($maxScan)
    {
        $this['hl.bs.maxScan'] = $maxScan;
        return $this;
    }

    /**
     * @param string $chars
     *
     * @return \Psolr\Component\Highlight
     *
     * @see http://wiki.apache.org/solr/HighlightingParameters#hl.bs.chars
     */
    public function setBoundaryScannerChars($chars)
    {
        $this['hl.bs.chars'] = $chars;
        return $this;
    }

    /**
     * @param string $type
     *
     * @return \Psolr\Component\Highlight
     *
     * @see http://wiki.apache.org/solr/HighlightingParameters#hl.bs.type
     */
    public function setBoundaryScannerType($type)
    {
        $this['hl.bs.type'] = $type;
        return $this;
    }

    /**
     * @param string $language
     *
     * @return \Psolr\Component\Highlight
     *
     * @see http://wiki.apache.org/solr/HighlightingParameters#hl.bs.language
     */
    public function setBoundaryScannerLanguage($language)
    {
        $this['hl.bs.language'] = $language;
        return $this;
    }

    /**
     * @param string $country
     *
     * @return \Psolr\Component\Highlight
     *
     * @see http://wiki.apache.org/solr/HighlightingParameters#hl.bs.country
     */
    public function setBoundaryScannerCountry($country)
    {
        $this['hl.bs.country'] = $country;
        return $this;
    }

    /**
     * @param bool $use
     *
     * @return \Psolr\Component\Highlight
     *
     * @see http://wiki.apache.org/solr/HighlightingParameters#hl.useFastVectorHighlighter
     */
    public function useFastVectorHighlighter($use = true)
    {
        $this['hl.useFastVectorHighlighter'] = $use ? 'true' : 'false';
        return $this;
    }

    /**
     * @param bool $use
     *
     * @return \Psolr\Component\Highlight
     *
     * @see http://wiki.apache.org/solr/HighlightingParameters#hl.usePhraseHighlighter
     */
    public function usePhraseHighlighter($use = true)
    {
        $this['hl.usePhraseHighlighter'] = $use ? 'true' : 'false';
        return $this;
    }

    /**
     * @param bool $multiTerm
     *
     * @return \Psolr\Component\Highlight
     *
     * @see http://wiki.apache.org/solr/HighlightingParameters#hl.highlightMultiTerm
     */
    public function highlightMultiTerm($multiTerm = true)
    {
        $this['hl.highlightMultiTerm'] = $multiTerm ? 'true' : 'false';
        return $this;
    }

    /**
     * @param float $slop
     *
     * @return \Psolr\Component\Highlight
     *
     * @see http://wiki.apache.org/solr/HighlightingParameters#hl.regex.slop
     */
    public function setRegexSlop($slop)
    {
        $this['hl.regex.slop'] = $slop;
        return $this;
    }

    /**
     * @param string $pattern
     *
     * @return \Psolr\Component\Highlight
     *
     * @see http://wiki.apache.org/solr/HighlightingParameters#hl.regex.pattern
     */
    public function setRegexPattern($pattern)
    {
        $this['hl.regex.pattern'] = $pattern;
        return $this;
    }

    /**
     * @param int $max
     *
     * @return \Psolr\Component\Highlight
     *
     * @see http://wiki.apache.org/solr/HighlightingParameters#hl.regex.maxAnalyzedChars
     */
    public function setRegexMaxAnalyzedChars($max)
    {
        $this['hl.regex.maxAnalyzedChars'] = $max;
        return $this;
    }
}
