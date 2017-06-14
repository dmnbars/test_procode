<?php
namespace App;

class Session implements SessionInterface
{
    public function start()
    {
        \session_start();
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key, $default = null)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    public function destroy()
    {
        \session_destroy();
    }
}
