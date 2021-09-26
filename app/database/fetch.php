<?php

function fetchAll(string $table_name, string $columns = '*')
{
    try
    {
        $connection = connect();

        $query = $connection->query("SELECT {$columns} FROM {$table_name}");
        return $query->fetchAll();
    }
    catch (\PDOException $exception)
    {
        var_dump($exception->getMessage());
    }
}

function findBy(string $by, $value, string $table_name, string $columns = '*')
{
    try
    {
        $connection = connect();
        $statement = $connection->prepare("SELECT {$columns} FROM {$table_name} WHERE {$by} = :by");
        $statement->execute(
            [
                'by' => $value
            ]
        );

        return $statement->fetch();

    }
    catch (\PDOException $exception)
    {
        var_dump($exception->getMessage());
    }
}
