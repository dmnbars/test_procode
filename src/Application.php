<?php

namespace App;

class Application
{
    private $handlers = [];
    private $services = [];

    public function get($route, $handler)
    {
        $this->append('GET', $route, $handler);
    }

    public function delete($route, $handler)
    {
        $this->append('DELETE', $route, $handler);
    }

    public function post($route, $handler)
    {
        $this->append('POST', $route, $handler);
    }

    public function register($key, $object)
    {
        if (!isset($this->services[$key])) {
            $this->services[$key] = $object;
        }
    }

    public function unRegister($key)
    {
        if (isset($this->services[$key])) {
            unset($this->services[$key]);
        }
    }

    public function getService($key)
    {
        return isset($this->services[$key]) ? $this->services[$key] : null;
    }

    public function run()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && array_key_exists('_method', $_POST)) {
            $method = strtoupper($_POST['_method']);
        } else {
            $method = $_SERVER['REQUEST_METHOD'];
        }
        $response = null;
        foreach ($this->handlers as $item) {
            list($route, $handlerMethod, $handler) = $item;
            $preparedRoute = str_replace('/', '\/', $route);
            $matches = [];
            if ($method == $handlerMethod && preg_match("/^$preparedRoute$/i", $uri, $matches)) {
                error_log($route);
                $attributes = array_filter($matches, function ($key) {
                    return !is_numeric($key);
                }, ARRAY_FILTER_USE_KEY);

                $session = new Session();
                $session->start();
                $this->register('session', $session);
                /** @var Response $response */
                $response = $handler($this, $attributes, array_merge($_GET, $_POST));
                break;
            }
        }

        if (is_null($response)) {
            $response = new Response(Template::render('404'));
            $response->withStatus(404);
        }

        http_response_code($response->getStatusCode());
        foreach ($response->getHeaderLines() as $header) {
            header($header);
        }
        echo $response->getBody();
        return;
    }

    private function append($method, $route, $handler)
    {
        $updatedRoute = $route;
        if (preg_match_all('/:([^\/]+)/', $route, $matches)) {
            $updatedRoute = array_reduce($matches[1], function ($acc, $value) {
                $group = "(?P<$value>[\w-]+)";
                return str_replace(":{$value}", $group, $acc);
            }, $route);
        }
        $this->handlers[] = [$updatedRoute, $method, $handler];
    }
}
