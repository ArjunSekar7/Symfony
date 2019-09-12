<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190912104248 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_form (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, email_id VARCHAR(100) NOT NULL, date_of_birth DATETIME NOT NULL, gender VARCHAR(10) NOT NULL, comments LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_pratice (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, deptartment_id VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user CHANGE password password VARCHAR(20) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_form');
        $this->addSql('DROP TABLE user_pratice');
        $this->addSql('ALTER TABLE user CHANGE password password TEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
