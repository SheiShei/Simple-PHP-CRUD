<?php

class BaseModel
{
    protected PDO $connection;
    protected string $tableName;

    public function __construct(string $tableName)
    {
        $this->connection = (new Database())->getConnection();
        $this->tableName = $tableName;
    }

    public function create(array $data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = rtrim(str_repeat('?, ', count($data)), ', ');

        $query = "INSERT INTO {$this->tableName} ($columns) VALUES ($placeholders)";
        $statement = $this->connection->prepare($query);
        $values = array_values($data);
        $statement->execute($values);

        $recordId = $this->connection->lastInsertId();
        return $this->read($recordId);
    }

    public function read(int $id)
    {
        $query = "SELECT * FROM {$this->tableName} WHERE id = ?";
        $statement = $this->connection->prepare($query);
        $statement->execute([$id]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function update(int $id, array $data)
    {
        $setClause = implode(' = ?, ', array_keys($data)) . ' = ?';

        $query = "UPDATE {$this->tableName} SET $setClause WHERE id = ?";
        $statement = $this->connection->prepare($query);
        $values = array_values($data);
        $values[] = $id;
        $statement->execute($values);

        return $this->read($id);
    }

    public function delete(int $id): bool
    {
        $query = "DELETE FROM {$this->tableName} WHERE id = ?";
        $statement = $this->connection->prepare($query);
        $statement->execute([$id]);
        return $statement->rowCount() > 0;
    }
}