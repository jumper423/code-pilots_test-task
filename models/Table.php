<?php

namespace models;

use core\DataBase;

class Table
{
    public static function inAccess($table)
    {
        return !!DataBase::i()->columnValue("SELECT COUNT(*) FROM AccessTable WHERE Name = '$table'");
    }

    public static function getInfo($table, $id = null)
    {
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

                    $rows = DataBase::i()->joining($rows, 'ID', $speakers, 'SessionID', 'Speakers');
                    break;
            }
        }
        return $rows;
    }
}