<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211009170932 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add data request id and requested at properties to the user table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD data_request_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', ADD data_requested_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE email email VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6498D4B827C ON user (data_request_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX UNIQ_8D93D6498D4B827C ON user');
        $this->addSql('ALTER TABLE user DROP data_request_id, DROP data_requested_at, CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
