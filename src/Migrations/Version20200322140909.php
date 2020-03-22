<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200322140909 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE service_registry_tokens (service_registry_id INT NOT NULL, api_token_id INT NOT NULL, INDEX IDX_AE202A6E802D2141 (service_registry_id), UNIQUE INDEX UNIQ_AE202A6E92E52D36 (api_token_id), PRIMARY KEY(service_registry_id, api_token_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE api_token (id INT AUTO_INCREMENT NOT NULL, token VARCHAR(255) NOT NULL, valid DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE service_registry_tokens ADD CONSTRAINT FK_AE202A6E802D2141 FOREIGN KEY (service_registry_id) REFERENCES service_registry (id)');
        $this->addSql('ALTER TABLE service_registry_tokens ADD CONSTRAINT FK_AE202A6E92E52D36 FOREIGN KEY (api_token_id) REFERENCES api_token (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE service_registry_tokens DROP FOREIGN KEY FK_AE202A6E92E52D36');
        $this->addSql('DROP TABLE service_registry_tokens');
        $this->addSql('DROP TABLE api_token');
    }
}
