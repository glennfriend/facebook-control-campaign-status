<?php
namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

class Version00000000 extends AbstractMigration
{
    public function preUp(Schema $schema)
    {
    }

    public function up(Schema $schema)
    {
        $table = $schema->createTable('users');
        $table->addColumn('id', 'integer', [
            'unsigned'      => true,
            'autoincrement' => true
        ]);
        $table->addColumn('account', 'string', [
            'length'        => 32
        ]);
        $table->addColumn('password', 'string', [
            'length'        => 72
        ]);
        $table->addColumn('role_ids', 'string', [
            'length'        => 72
        ]);
        $table->addColumn('email', 'string', [
            'length'        => 100
        ]);
        $table->addColumn('status', 'integer', [
            'unsigned'      => true,
            'length'        => 2
        ]);
        $table->addColumn('create_time', 'timestamp');  // TODO: 不支援
        $table->addColumn('update_time', 'timestamp');  // TODO: 不支援
        $table->addColumn('properties',  'text');
        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema)
    {
        $schema->dropTable('users');
    }
}
