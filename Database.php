<?php
class Database
{
    private $mysqli;

    public function __construct($host, $user, $password, $database)
    {
        $this->mysqli = new mysqli($host, $user, $password, $database);

        if ($this->mysqli->connect_error) {
            die("Ошибка подключения: " . $this->mysqli->connect_error);
        }
    }

    public function query($sql, $params = [])
    {
        $stmt = $this->mysqli->prepare($sql);
        if ($params) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result();
    }

    public function close()
    {
        $this->mysqli->close();
    }
}
