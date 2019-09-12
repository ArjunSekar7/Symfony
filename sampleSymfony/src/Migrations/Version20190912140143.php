<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190912140143 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_pratice');
        $this->addSql('ALTER TABLE user ADD dateofjoin DATE NOT NULL, CHANGE password password VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE user_form CHANGE date_of_birth date_of_birth DATE NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_pratice (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, deptartment_id VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user DROP dateofjoin, CHANGE password password TEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user_form CHANGE date_of_birth date_of_birth DATE DEFAULT NULL');
    }
}
