<?php

namespace Psolr;

use Guzzle\Parser\UriTemplate\UriTemplate;

class SolrUriTemplate extends UriTemplate
{
    /**
     * {@inheritdoc}
     *
     * Only allow expansion of the {+base_path} expression.
     *
     * @see http://guzzlephp.org/http-client/uri-templates.html
     * @see http://wiki.apache.org/solr/LocalParams
     * @see https://github.com/guzzle/guzzle-docs/pull/56
     */
    public function expand($template, array $variables)
    {
        return str_replace('{+base_path}', $variables['base_path'], $template);
    }
}
