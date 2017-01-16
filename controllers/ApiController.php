<?php

namespace controllers;

use core\DataBase;
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

    public function sessionSubscribeAction($params)
    {
        $sessionId  = isset($params['sessionId']) ? (int)$params['sessionId'] : false;
        $userEmail   = isset($params['userEmail']) ? $params['userEmail'] : false;

        $userId = DataBase::i()->columnValue("SELECT ID FROM Users WHERE Email = '$userEmail'");
        if (!$userId) {
            $this->response(false, [], 'Нет пользователя');
            return;
        }

        DataBase::i()->query("SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;");
        DataBase::i()->begin();
        DataBase::i()->query("INSERT INTO `SessionSubscribe` (`SessionID`, `UserID`) VALUES ($sessionId, $userId) ON DUPLICATE KEY UPDATE UserID = $userId");
        if(DataBase::i()->columnValue("SELECT COUNT(*) FROM SessionSubscribe WHERE SessionID = $sessionId") <= DataBase::i()->columnValue("SELECT NumberOfSeats FROM Session WHERE ID = $sessionId")) {
            DataBase::i()->commit();
            $this->response(true, [], "Спасибо, вы успешно записаны!");
        } else {
            DataBase::i()->rollback();
            $this->response(true, [], "Извините, все места заняты!");
        }

    }

    public function postNewsAction()
    {

    }
}