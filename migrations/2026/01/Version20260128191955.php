<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260128191955 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users (id UUID NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY (id))');
        $this->addSql('ALTER TABLE urls ADD url VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE urls ADD user_id UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE urls ADD CONSTRAINT FK_2A9437A1A76ED395 FOREIGN KEY (user_id) REFERENCES urls (id)');
        $this->addSql('CREATE INDEX IDX_2A9437A1A76ED395 ON urls (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE users');
        $this->addSql('ALTER TABLE urls DROP CONSTRAINT FK_2A9437A1A76ED395');
        $this->addSql('DROP INDEX IDX_2A9437A1A76ED395');
        $this->addSql('ALTER TABLE urls DROP url');
        $this->addSql('ALTER TABLE urls DROP user_id');
    }
}
