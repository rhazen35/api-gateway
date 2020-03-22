<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200322125936 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE groups_roles DROP FOREIGN KEY FK_E79D4963FE54D947');
        $this->addSql('ALTER TABLE user_groups_groups DROP FOREIGN KEY FK_CF0950B61ED93D47');
        $this->addSql('ALTER TABLE user_groups_groups DROP FOREIGN KEY FK_CF0950B67453A4E3');
        $this->addSql('ALTER TABLE users_groups DROP FOREIGN KEY FK_FF8AB7E0FE54D947');
        $this->addSql('CREATE TABLE service_registry (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, host VARCHAR(255) NOT NULL, port INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_security_group (id INT AUTO_INCREMENT NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE security_groups_security_roles (group_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_1CB32AC3FE54D947 (group_id), INDEX IDX_1CB32AC3D60322AC (role_id), PRIMARY KEY(group_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_security_groups_security_groups (user_group_id INT NOT NULL, child_group_id INT NOT NULL, INDEX IDX_78A0B0671ED93D47 (user_group_id), INDEX IDX_78A0B0677453A4E3 (child_group_id), PRIMARY KEY(user_group_id, child_group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_security_groups (user_id INT NOT NULL, group_id INT NOT NULL, INDEX IDX_7DF730FFA76ED395 (user_id), INDEX IDX_7DF730FFFE54D947 (group_id), PRIMARY KEY(user_id, group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_security_roles (user_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_243A54D8A76ED395 (user_id), INDEX IDX_243A54D8D60322AC (role_id), PRIMARY KEY(user_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE security_groups_security_roles ADD CONSTRAINT FK_1CB32AC3FE54D947 FOREIGN KEY (group_id) REFERENCES user_security_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE security_groups_security_roles ADD CONSTRAINT FK_1CB32AC3D60322AC FOREIGN KEY (role_id) REFERENCES user_security_role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_security_groups_security_groups ADD CONSTRAINT FK_78A0B0671ED93D47 FOREIGN KEY (user_group_id) REFERENCES user_security_group (id)');
        $this->addSql('ALTER TABLE user_security_groups_security_groups ADD CONSTRAINT FK_78A0B0677453A4E3 FOREIGN KEY (child_group_id) REFERENCES user_security_group (id)');
        $this->addSql('ALTER TABLE users_security_groups ADD CONSTRAINT FK_7DF730FFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_security_groups ADD CONSTRAINT FK_7DF730FFFE54D947 FOREIGN KEY (group_id) REFERENCES user_security_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_security_roles ADD CONSTRAINT FK_243A54D8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_security_roles ADD CONSTRAINT FK_243A54D8D60322AC FOREIGN KEY (role_id) REFERENCES user_security_role (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE groups_roles');
        $this->addSql('DROP TABLE user_group');
        $this->addSql('DROP TABLE user_groups_groups');
        $this->addSql('DROP TABLE users_groups');
        $this->addSql('DROP TABLE users_roles');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE security_groups_security_roles DROP FOREIGN KEY FK_1CB32AC3FE54D947');
        $this->addSql('ALTER TABLE user_security_groups_security_groups DROP FOREIGN KEY FK_78A0B0671ED93D47');
        $this->addSql('ALTER TABLE user_security_groups_security_groups DROP FOREIGN KEY FK_78A0B0677453A4E3');
        $this->addSql('ALTER TABLE users_security_groups DROP FOREIGN KEY FK_7DF730FFFE54D947');
        $this->addSql('CREATE TABLE groups_roles (group_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_E79D4963FE54D947 (group_id), INDEX IDX_E79D4963D60322AC (role_id), PRIMARY KEY(group_id, role_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_group (id INT AUTO_INCREMENT NOT NULL, role VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_groups_groups (user_group_id INT NOT NULL, child_group_id INT NOT NULL, INDEX IDX_CF0950B61ED93D47 (user_group_id), INDEX IDX_CF0950B67453A4E3 (child_group_id), PRIMARY KEY(user_group_id, child_group_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE users_groups (user_id INT NOT NULL, group_id INT NOT NULL, INDEX IDX_FF8AB7E0A76ED395 (user_id), INDEX IDX_FF8AB7E0FE54D947 (group_id), PRIMARY KEY(user_id, group_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE users_roles (user_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_51498A8EA76ED395 (user_id), INDEX IDX_51498A8ED60322AC (role_id), PRIMARY KEY(user_id, role_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE groups_roles ADD CONSTRAINT FK_E79D4963D60322AC FOREIGN KEY (role_id) REFERENCES user_security_role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groups_roles ADD CONSTRAINT FK_E79D4963FE54D947 FOREIGN KEY (group_id) REFERENCES user_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_groups_groups ADD CONSTRAINT FK_CF0950B61ED93D47 FOREIGN KEY (user_group_id) REFERENCES user_group (id)');
        $this->addSql('ALTER TABLE user_groups_groups ADD CONSTRAINT FK_CF0950B67453A4E3 FOREIGN KEY (child_group_id) REFERENCES user_group (id)');
        $this->addSql('ALTER TABLE users_groups ADD CONSTRAINT FK_FF8AB7E0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_groups ADD CONSTRAINT FK_FF8AB7E0FE54D947 FOREIGN KEY (group_id) REFERENCES user_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_roles ADD CONSTRAINT FK_51498A8EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_roles ADD CONSTRAINT FK_51498A8ED60322AC FOREIGN KEY (role_id) REFERENCES user_security_role (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE service_registry');
        $this->addSql('DROP TABLE user_security_group');
        $this->addSql('DROP TABLE security_groups_security_roles');
        $this->addSql('DROP TABLE user_security_groups_security_groups');
        $this->addSql('DROP TABLE users_security_groups');
        $this->addSql('DROP TABLE users_security_roles');
    }
}
