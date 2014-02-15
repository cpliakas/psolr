<?php

namespace PSolr\Request;

/**
 * Interface implemented by component classes, e.g. Highlight and Spellcheck.
 */
interface ComponentInterface
{
    /**
     * Pre-merge hook that is usually used to set default parameters based on
     * what is set in the query this component is being added to.
     *
     * For example, the spellcheck component will set the "spellcheck.q"
     * parameter to match the select query's "q" parameter unless it is already
     * set.
     */
    public function preMergeParams(SolrRequest $request);

    /**
     * Returns an array of query string parameters. This method is usually
     * implemented by the \Guzzle\Http\QueryString class.
     *
     * @return array
     */
    public function toArray();
}
