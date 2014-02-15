<?php

namespace PSolr\Request;

interface ComponentInterface
{
    /**
     * Pre-merge hook that is usually used to set default parameters based on
     * what is set in the query this component is being added to.
     */
    public function preMergeParams(SolrRequest $request);

    /**
     * Returns an array of query string parameters.
     *
     * @return array
     */
    public function toArray();
}
