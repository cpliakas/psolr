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
     *
     * Enables highlighting.
     */
    public function init()
    {
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
        return $this->set('highlight', $highlight);
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
        return $this->set('hl.q', $query);
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
        return $this->set('hl.snippets', $snippets);
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
        return $this->set('hl.fragsize', $fragsize);
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
        return $this->set('hl.mergeContiguous', $merge);
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
        return $this->set('hl.requireFieldMatch', $require);
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
        return $this->set('hl.maxAnalyzedChars', $chars);
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
        return $this->set('hl.alternateField', $field);
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
        return $this->set('hl.maxAlternateFieldLength', $length);
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
        return $this->set('hl.preserveMulti', $preserve);
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
        return $this->set('hl.maxMultiValuedToExamine', $max);
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
        return $this->set('hl.maxMultiValuedToMatch', $max);
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
        return $this->set('hl.formatter', $formatter);
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
        return $this->set('hl.simple.pre', $text);
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
        return $this->set('hl.simple.post', $text);
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
        return $this->set('hl.fragmenter', $fragmenter);
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
        return $this->set('hl.fragListBuilder', $builder);
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
        return $this->set('hl.boundaryScanner', $scanner);
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
        return $this->set('hl.fragmentsBuilder', $builder);
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
        return $this->set('hl.bs.maxScan', $maxScan);
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
        return $this->set('hl.bs.chars', $chars);
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
        return $this->set('hl.bs.type', $type);
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
        return $this->set('hl.bs.language', $language);
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
        return $this->set('hl.bs.country', $country);
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
        return $this->set('hl.useFastVectorHighlighter', $use);
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
        return $this->set('hl.usePhraseHighlighter', $use);
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
        return $this->set('hl.highlightMultiTerm', $multiTerm);
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
        return $this->set('hl.regex.slop', $slop);
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
        return $this->set('hl.regex.pattern', $pattern);
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
        return $this->set('hl.regex.maxAnalyzedChars', $max);
    }
}
