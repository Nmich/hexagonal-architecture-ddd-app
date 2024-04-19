<?php

namespace App\Infra;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class Database
{
    public function __construct(private readonly Connection $connection)
    {
    }

    /**
     * @throws Exception
     */
    public function truncateAllTables(): void
    {
        $schemaManager = $this->connection->createSchemaManager();
        $tables = $schemaManager->listTables();

        foreach ($tables as $table) {
            $this->connection->executeQuery(
                "TRUNCATE TABLE \"{$table->getName()}\" CASCADE"
            );
        }
    }
}
