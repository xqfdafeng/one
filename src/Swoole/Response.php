<?php

namespace One\Swoole;

use One\Facades\Log;

/**
 * Class Response
 * @package One\Swoole
 * @mixin \swoole_http_response
 */
class Response extends \One\Http\Response
{

    /**
     * @var \swoole_http_response
     */
    private $httpResponse;

    /**
     * @var \swoole_http_request
     */
    protected $httpRequest;

    public function __construct(Request $request, \swoole_http_response $response)
    {
        $this->httpResponse = $response;
        $this->httpRequest  = $request;
    }

    public function header($key, $val, $replace = false, $code = null)
    {
        $this->httpResponse->header($key, $val, $replace);
        if ($code) {
            $this->code($code);
        }
    }

    /**
     * @param $code
     * @return $this|\One\Http\Response
     */
    public function code($code)
    {
        $this->httpResponse->status($code);
        return $this;
    }

    public function cookie(...$args)
    {
        $this->httpResponse->cookie(...$args);
    }

    public function write($html)
    {
        $this->httpResponse->write($html);
    }

    public function __call($name, $arguments)
    {
        if (method_exists($this->httpResponse, $name)) {
            return $this->httpResponse->$name(...$arguments);
        }
    }

}