<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211007093359 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assignment DROP FOREIGN KEY FK_30C544BA1B8B387B');
        $this->addSql('ALTER TABLE assignment DROP FOREIGN KEY FK_30C544BA2B6945EC');
        $this->addSql('DROP INDEX IDX_30C544BA2B6945EC ON assignment');
        $this->addSql('DROP INDEX IDX_30C544BA1B8B387B ON assignment');
        $this->addSql('ALTER TABLE assignment ADD badge_id INT NOT NULL, ADD recipient_id INT NOT NULL, DROP badge_id_id, DROP recipient_id_id');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_30C544BAF7A2C2FC FOREIGN KEY (badge_id) REFERENCES badge (id)');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_30C544BAE92F8F78 FOREIGN KEY (recipient_id) REFERENCES recipient (id)');
        $this->addSql('CREATE INDEX IDX_30C544BAF7A2C2FC ON assignment (badge_id)');
        $this->addSql('CREATE INDEX IDX_30C544BAE92F8F78 ON assignment (recipient_id)');
        $this->addSql('ALTER TABLE badge DROP FOREIGN KEY FK_FEF0481DA9E6A0B0');
        $this->addSql('DROP INDEX IDX_FEF0481DA9E6A0B0 ON badge');
        $this->addSql('ALTER TABLE badge CHANGE issuer_id_id issuer_id INT NOT NULL');
        $this->addSql('ALTER TABLE badge ADD CONSTRAINT FK_FEF0481DBB9D6FEE FOREIGN KEY (issuer_id) REFERENCES issuer (id)');
        $this->addSql('CREATE INDEX IDX_FEF0481DBB9D6FEE ON badge (issuer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assignment DROP FOREIGN KEY FK_30C544BAF7A2C2FC');
        $this->addSql('ALTER TABLE assignment DROP FOREIGN KEY FK_30C544BAE92F8F78');
        $this->addSql('DROP INDEX IDX_30C544BAF7A2C2FC ON assignment');
        $this->addSql('DROP INDEX IDX_30C544BAE92F8F78 ON assignment');
        $this->addSql('ALTER TABLE assignment ADD badge_id_id INT NOT NULL, ADD recipient_id_id INT NOT NULL, DROP badge_id, DROP recipient_id');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_30C544BA1B8B387B FOREIGN KEY (badge_id_id) REFERENCES badge (id)');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_30C544BA2B6945EC FOREIGN KEY (recipient_id_id) REFERENCES recipient (id)');
        $this->addSql('CREATE INDEX IDX_30C544BA2B6945EC ON assignment (recipient_id_id)');
        $this->addSql('CREATE INDEX IDX_30C544BA1B8B387B ON assignment (badge_id_id)');
        $this->addSql('ALTER TABLE badge DROP FOREIGN KEY FK_FEF0481DBB9D6FEE');
        $this->addSql('DROP INDEX IDX_FEF0481DBB9D6FEE ON badge');
        $this->addSql('ALTER TABLE badge CHANGE issuer_id issuer_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE badge ADD CONSTRAINT FK_FEF0481DA9E6A0B0 FOREIGN KEY (issuer_id_id) REFERENCES issuer (id)');
        $this->addSql('CREATE INDEX IDX_FEF0481DA9E6A0B0 ON badge (issuer_id_id)');
    }
}
