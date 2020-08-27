<?php declare(strict_types=1);

namespace BackupPlugin\Migration;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1588600037SomeNewTables extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1588600037;
    }
    
    public function update(Connection $connection): void
    {
        // implement update
    }
    
    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
    
    
    /*******************************************
     * Functions executed by MigrationService
     ********************************************/
    
    public function installMigration(Connection $connection, string $contextName)
    {
        $connection->executeQuery(<<<SQL
            CREATE TABLE `some_new_table` (
            `id` binary(16) NOT NULL,
            `some_new_field` varchar(255) NOT NULL,
            `created_at` datetime(3) NOT NULL,
            `updated_at` datetime(3),
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL
        );
    }
    
    /**
     * @param Connection $connection
     *
     * @throws DBALException
     */
    public function uninstallMigration(Connection $connection)
    {
        $connection->executeQuery('DROP TABLE IF EXISTS `some_new_table`');
    }
    
}
