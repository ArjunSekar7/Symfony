<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190918121942 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user ADD id INT AUTO_INCREMENT NOT NULL, ADD mail_id VARCHAR(40) NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE sub_category ADD sub_category_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user_form CHANGE name name VARCHAR(255) NOT NULL, CHANGE email_id email_id VARCHAR(255) NOT NULL, CHANGE comments comments LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE product ADD product_name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product DROP product_name');
        $this->addSql('ALTER TABLE sub_category DROP sub_category_name');
        $this->addSql('ALTER TABLE user MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE user DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE user DROP id, DROP mail_id');
        $this->addSql('ALTER TABLE user_form CHANGE name name VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE email_id email_id VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE comments comments LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
