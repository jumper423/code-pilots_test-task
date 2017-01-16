<?php

namespace core;


class DataBase
{
    /**
     * @var \PDO
     */
    private $db;
    private static $instance = null;

    /**
     * @param string $database
     * @param string $user
     * @param string $password
     * @param string $host
     * @param int $port
     * @return $this
     */
    public static function connect($database, $user, $password, $host = 'localhost', $port = 3306)
    {
        if (is_null(self::$instance)) {
            self::$instance = new DataBase(new \PDO(
                "mysql:host=$host;port=$port;dbname=$database",
                $user,
                $password
            ));
        }
        return self::$instance;
    }

    /**
     * @return DataBase
     */
    public static function i()
    {
        return self::$instance;
    }

    private function __construct($db)
    {
        $this->db = $db;
    }

    public function query($string)
    {
        return $this->db->query($string);
    }

    public function begin()
    {
        return $this->db->beginTransaction();
    }

    public function commit()
    {
        return $this->db->commit();
    }

    public function rollback()
    {
        return $this->db->rollBack();
    }

    public function row($string)
    {
        $stmt = $this->db->prepare($string);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_LAZY);
    }

    public function columnValue($string)
    {
        $stmt = $this->db->prepare($string);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function rows($string)
    {
        $stmt = $this->db->prepare($string);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function bringing(&$rows){
        foreach ($rows as &$value) {
            if (is_array($value)) {
                $this->bringing($value);
            } else {
                if (is_numeric($value)) {
                    $value = (int)$value;
                }
            }
        }
    }

    public function joining($rows, $key, $joinRows, $joinKey, $arrayKey){
        if (!$joinRows) {
            return $rows;
        }
        $sessions = [];
        foreach ($rows as $row) {
            $sessions[$row[$key]] = $row;
        }
        foreach ($joinRows as $joinRow) {
            $sessionId = $joinRow[$joinKey];
            unset($joinRow[$joinKey]);
            if (!isset($sessions[$sessionId][$arrayKey])) {
                $sessions[$sessionId][$arrayKey] = [];
            }
            $this->bringing($joinRow);
            $sessions[$sessionId][$arrayKey][] = $joinRow;
        }
        return array_values($sessions);
    }
}