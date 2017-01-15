<?php

namespace controllers;

use models\Table;

class ApiController extends BaseController
{
    public function tableAction($params = [])
    {
        $table = isset($params['table']) ? $params['table'] : false;

        if(!$table) {
            $this->response(false, [], 'Не указана таблица');
            return;
        }
        if (!Table::inAccess($table)) {
            $this->response(false, [], 'Не верная таблица');
            return;
        }

        $id = isset($params['id']) ? (int)$params['id'] : false;

        $this->response(true, Table::getInfo($table, $id));
    }

    public function sessionSubscribeAction()
    {

    }

    public function postNewsAction()
    {

    }
}