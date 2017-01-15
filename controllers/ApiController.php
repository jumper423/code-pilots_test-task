<?php

namespace controllers;

use core\DataBase;

class ApiController extends BaseController
{
    public function tableAction($params = [])
    {
        $table = isset($params['table']) ? $params['table'] : false;

        if($table) {
            if (DataBase::i()->columnValue("SELECT COUNT(*) FROM AccessTable WHERE Name = '$table'")) {

                $id = isset($params['id']) ? (int)$params['id'] : false;

                $sql = 'SELECT * FROM ' . $table;
                if ($id) {
                    $sql .= ' WHERE ID = ' . $id;
                }
                $rows = DataBase::i()->rows($sql);
                DataBase::i()->bringing($rows);

                if ($rows) {
                    switch ($table) {
                        case 'Session':
                            $ids = array_map(function ($row) {
                                return $row['ID'];
                            }, $rows);
                            $speakers = DataBase::i()->rows(
                                "SELECT s.*, sp.SessionID
                                FROM Speaker s
                                JOIN SessionSpeaker sp ON s.ID = sp.SpeakerID
                                WHERE sp.SessionID IN (" . implode(',', $ids) . ")");
                            if ($speakers) {
                                $sessions = [];
                                foreach ($rows as $row) {
                                    $sessions[$row['ID']] = $row;
                                }
                                foreach ($speakers as $speaker) {
                                    $sessionId = $speaker['SessionID'];
                                    unset($speaker['SessionID']);
                                    if (!isset($sessions[$sessionId]['Speakers'])) {
                                        $sessions[$sessionId]['Speakers'] = [];
                                    }
                                    DataBase::i()->bringing($speaker);
                                    $sessions[$sessionId]['Speakers'][] = $speaker;
                                }
                                $rows = array_values($sessions);
                            }
                            break;
                    }
                }
                $this->response(true, $rows);
            } else {
                $this->response();
            }
        } else {
            $this->response();
        }
    }

    public function sessionSubscribeAction()
    {

    }

    public function postNewsAction()
    {

    }
}