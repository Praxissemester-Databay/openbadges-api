<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211007091959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE badge (id INT AUTO_INCREMENT NOT NULL, badge_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, issuer_id INT NOT NULL, image VARCHAR(255) DEFAULT NULL, criteria LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assignment (id INT AUTO_INCREMENT NOT NULL, badge_id_id INT NOT NULL, recipient_id_id INT NOT NULL, image VARCHAR(255) DEFAULT NULL, narrative VARCHAR(255) DEFAULT NULL, issued_on DATETIME DEFAULT NULL, INDEX IDX_30C544BA1B8B387B (badge_id_id), INDEX IDX_30C544BA2B6945EC (recipient_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE issuer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipient (id INT AUTO_INCREMENT NOT NULL, hashed TINYINT(1) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, identity VARCHAR(255) DEFAULT NULL, salt VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_30C544BA1B8B387B FOREIGN KEY (badge_id_id) REFERENCES badge (id)');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_30C544BA2B6945EC FOREIGN KEY (recipient_id_id) REFERENCES recipient (id)');
        $this->addSql('ALTER TABLE badge ADD issuer_id_id INT NOT NULL, DROP badge_id, DROP issuer_id');
        $this->addSql('ALTER TABLE badge ADD CONSTRAINT FK_FEF0481DA9E6A0B0 FOREIGN KEY (issuer_id_id) REFERENCES issuer (id)');
        $this->addSql('CREATE INDEX IDX_FEF0481DA9E6A0B0 ON badge (issuer_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE badge DROP FOREIGN KEY FK_FEF0481DA9E6A0B0');
        $this->addSql('ALTER TABLE assignment DROP FOREIGN KEY FK_30C544BA2B6945EC');
        $this->addSql('DROP TABLE assignment');
        $this->addSql('DROP TABLE issuer');
        $this->addSql('DROP TABLE recipient');
        $this->addSql('DROP INDEX IDX_FEF0481DA9E6A0B0 ON badge');
        $this->addSql('ALTER TABLE badge ADD issuer_id INT NOT NULL, CHANGE issuer_id_id badge_id INT NOT NULL');
    }
}
