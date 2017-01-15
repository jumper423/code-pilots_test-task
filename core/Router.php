<?php

namespace core;

class Router
{
    public function urlParsing() {
        $uri = $_SERVER['REQUEST_URI'];

        $result = [];
        $result['controller'] = explode($uri, '/')[0];
        $result['action'] = explode($uri, '/')[1];
        $result['params'] = $_POST;

        return $result;
    }

    public function callAction() {
        $url = $this->urlParsing();
        $name = ucfirst($url['controller']);
        $obj = new ('\controllers\/'.$name.'Controller')();

        return $obj->{lcfirst($url['action']).'Action'}($url['params']);
    }
}