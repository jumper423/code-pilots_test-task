<?php

namespace core;

class Router
{
    public function urlParsing() {
        $uri = explode('?', $_SERVER['REQUEST_URI'])[0];

        $result = [];
        $result['controller'] = explode('/', $uri)[1];
        $result['action'] = explode('/', $uri)[2];
        $result['params'] = $_POST;

        return $result;
    }

    public function callAction() {
        $url = $this->urlParsing();
        $name = ucfirst($url['controller']);
        $test = '\controllers\\'.$name.'Controller';
        $obj = new $test();

        return $obj->{lcfirst($url['action']).'Action'}($url['params']);
    }
}