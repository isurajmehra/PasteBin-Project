<?php

class mysqli_wrapper {

    private $connection;

    public function __construct() {
        $this->connection = new mysqli("localhost", "user", "pass", "db");

        if (!$this->connection)
            throw new Exception('Error connecting to DB');
    }

    public function __destruct() {
        $this->connection->close();
    }

    public function query(string $query, array $args = [], string $types = null) {
        if ($types === null && $args !== [])
            $types = str_repeat('s', count($args));

        $stmt = $this->connection->prepare($query);

        if (!$stmt)
            throw new Exception('Error preparing query');

        if (strpos($query, '?') !== false)
            $stmt->bind_param($types, ...$args);

        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();

        return $result;
    }

    public function get_connection(): mysqli {
        return $this->connection;
    }

}
