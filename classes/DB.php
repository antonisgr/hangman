<?php

class DB
{
    /**
     * Database connection.
     *
     * @var PDO
     */
    private $connection;

    public function __construct($driver, $host, $db, $user, $pass)
    {
        $this->connection = new PDO("$driver:host=$host;dbname=$db;charset=utf8;", $user, $pass);
        $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); // return objects
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //throw exceptions
    }

    /**
     * Execute raw SQL query.
     *
     * @param $sql
     * @return array
     */
    public function raw($sql)
    {
        $stmt = $this->connection->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Executes an SQL SELECT.
     *
     * @param $table
     * @param array $columns
     * @param string $id
     * @return array
     */
    public function select($table, array $columns = [], $id = '')
    {
        if (empty($columns)) {
            $sql = "SELECT * FROM $table";
        } else {
            $sql = "SELECT (" . implode(', ', $columns) . ") FROM $table";
        }
        $sql .= empty($id) ? '' : " WHERE id=$id";
        $stmt = $this->connection->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Select everything from a given table.
     *
     * @return array
     */
    public function selectAll($table)
    {
        $sql = "SELECT * FROM $table";
        $stmt = $this->connection->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Executes an SQL INSERT.
     *
     * @param $table
     * @param array $data
     */
    public function insert($table, array $data)
    {
        $sql = "INSERT INTO $table (" . implode(', ', array_keys($data)) . ") VALUES (";
        foreach ($data as $column => $value) {
            $sql .= ":$column, ";
            $binds[":$column"] = $value;
        }
        $sql = trim($sql, ' ,');
        $sql .= ');';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($binds);
    }

    /**
     * Executes an SQL UPDATE
     *
     * @param $table
     * @param array $data
     * @param $id
     * @throws \Exception
     */
    public function update($table, array $data, $id)
    {
        if (empty($id)) throw new \Exception('Specify a where clause');
        $sql = "UPDATE $table SET ";
        foreach ($data as $column => $value) {
            $sql .= "$column=:$column, ";
            $binds[":$column"] = $value;
        }
        $sql = trim($sql, ' ,');
        $sql .= " WHERE id=:id";
        $binds[':id'] = $id;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($binds);
    }

    /**
     * Executes an SQL DELETE.
     *
     * @param $table
     * @param $id
     */
    public function delete($table, $id)
    {
        $sql = "DELETE FROM $table WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }

    /**
     * Executes a prepared statement with parameters specified in $binds array
     *
     * @param $sql
     * @param $binds
     * @return array
     */
    public function prepared($sql, array $binds)
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($binds);
        return $stmt->fetchAll();
    }

    /**
     * Returns last inserted row's id.
     *
     * @return string
     */
    public function lastId() {
        return $this->connection->lastInsertId();
    }
}
