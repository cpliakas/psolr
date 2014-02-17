<?php

namespace PSolr\Response;

class SystemInfo extends Response
{
    /**
     * @return string
     */
    public function schema()
    {
        return $this['core']['schema'];
    }

    /**
     * @return string
     */
    public function host()
    {
        return $this['core']['host'];
    }

    /**
     * @return \DateTime
     */
    public function now()
    {
        return new \DateTime($this['core']['now']);
    }

    /**
     * @return \DateTime
     */
    public function start()
    {
        return new \DateTime($this['core']['start']);
    }

    /**
     * @return string
     */
    public function instanceDirectory()
    {
        return $this['core']['directory']['instance'];
    }

    /**
     * @return string
     */
    public function dataDirectory()
    {
        return $this['core']['directory']['data'];
    }

    /**
     * @return string
     */
    public function indexDirectory()
    {
        return $this['core']['directory']['index'];
    }

    /**
     * @return string
     */
    public function solrSpecVersion()
    {
        return $this['lucene']['solr-spec-version'];
    }

    /**
     * @return string
     */
    public function solrImplVersion()
    {
        return $this['lucene']['solr-impl-version'];
    }

    /**
     * @return string
     */
    public function luceneSpecVersion()
    {
        return $this['lucene']['lucene-spec-version'];
    }

    /**
     * @return string
     */
    public function luceneImplVersion()
    {
        return $this['lucene']['lucene-impl-version'];
    }

    /**
     * @return string
     */
    public function jvmVersion()
    {
        return $this['jvm']['version'];
    }

    /**
     * @return string
     */
    public function jvmName()
    {
        return $this['jvm']['version'];
    }

    /**
     * @return int
     */
    public function jvmProcessors()
    {
        return $this['jvm']['processors'];
    }

    /**
     * @return string
     */
    public function jvmMemoryFree()
    {
        return $this['jvm']['memory']['free'];
    }

    /**
     * @return string
     */
    public function jvmMemoryTotal()
    {
        return $this['jvm']['memory']['total'];
    }

    /**
     * @return string
     */
    public function jvmMemoryMax()
    {
        return $this['jvm']['memory']['max'];
    }

    /**
     * @return string
     */
    public function jvmMemoryUsed()
    {
        return $this['jvm']['memory']['used'];
    }

    /**
     * @return string
     */
    public function jmxBootClassPath()
    {
        return $this['jvm']['jmx']['bootclasspath'];
    }

    /**
     * @return string
     */
    public function jmxClassPath()
    {
        return $this['jvm']['jmx']['classpath'];
    }

    /**
     * @return array
     */
    public function jmxCommandLineArgs()
    {
        return $this['jvm']['jmx']['commandLineArgs'];
    }

    /**
     * @return \DateTime
     */
    public function jmxStartTime()
    {
        return new \DateTime($this['jvm']['jmx']['startTime']);
    }

    /**
     * @return int
     */
    public function jmxUptimeMS()
    {
        return $this['jvm']['jmx']['upTimeMS'];
    }

    /**
     * @return string
     */
    public function systemName()
    {
        return $this['system']['name'];
    }

    /**
     * @return string
     */
    public function systemVersion()
    {
        return $this['system']['version'];
    }

    /**
     * @return string
     */
    public function systemArch()
    {
        return $this['system']['arch'];
    }

    /**
     * @return float
     */
    public function systemLoadAverage()
    {
        return $this['system']['systemLoadAverage'];
    }

    /**
     * @return string
     */
    public function systemUname()
    {
        return $this['system']['uname'];
    }

    /**
     * @return init
     */
    public function systemUlimit()
    {
        return $this['system']['ulimit'];
    }

    /**
     * @return string
     */
    public function systemUptime()
    {
        return $this['system']['uptime'];
    }
}
