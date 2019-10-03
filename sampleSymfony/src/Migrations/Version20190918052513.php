<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190918052513 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

       $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
       $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, INDEX IDX_D34A04AD12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    //    $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    //    $this->addSql('DROP TABLE user_pratice');
    //    $this->addSql('ALTER TABLE user CHANGE password password VARCHAR(20) NOT NULL');
    //    $this->addSql('ALTER TABLE user_form ADD country VARCHAR(100) NOT NULL, CHANGE name name VARCHAR(255) NOT NULL, CHANGE email_id email_id VARCHAR(255) NOT NULL, CHANGE date_of_birth date_of_birth DATE NOT NULL, CHANGE comments comments LONGTEXT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    //     $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
    //     $this->addSql('CREATE TABLE user_pratice (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, deptartment_id VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
    //     $this->addSql('DROP TABLE category');
    //     $this->addSql('DROP TABLE product');
    //     $this->addSql('ALTER TABLE user CHANGE password password TEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    //     $this->addSql('ALTER TABLE user_form DROP country, CHANGE name name VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE email_id email_id VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE date_of_birth date_of_birth DATETIME NOT NULL, CHANGE comments comments LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci');
     }
}
