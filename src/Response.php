<?php
namespace App;

class Response implements ResponseInterface
{
    protected $headers = [];
    protected $status = 200;
    protected $body;

    public function __construct($body = '')
    {
        $this->body = $body;

        return $this;
    }

    public function redirect($url)
    {
        $this->status = 302;
        $this->headers['Location'] = $url;

        return $this;
    }

    public function withStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function format($format)
    {
        switch ($format) {
            case 'json':
                $this->headers['Content-Type'] = 'json';
                $this->body = json_encode($this->body);
        }

        return $this;
    }

    public function getStatusCode()
    {
        return $this->status;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getHeaderLines()
    {
        return array_map(function ($key, $value) {
            return "$key: $value";
        }, array_keys($this->headers), $this->headers);
    }
}
