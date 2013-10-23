<?php
namespace CarlosIO\Jenkins;

use CarlosIO\Jenkins\Job;
use CarlosIO\Jenkins\Exception\SourceNotAvailableException;

class Source
{
    private $_url;
    private $_json;

    public function __construct($url, $stream_context = null)
    {
        $this->_url = $url;

        $json = @file_get_contents($url, null, $stream_context);
        $this->_json = @json_decode($json);

        if (!$this->_json) {
            throw new SourceNotAvailableException();
        }
    }

    public function getJobs()
    {
        $array = $this->_json->jobs;
        $jobs = array();
        foreach($array as $row) {
            $jobs[] = new Job($row);
        }

        return $jobs;
    }
}

