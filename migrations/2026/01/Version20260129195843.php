<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260129195843 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE urls DROP CONSTRAINT fk_2a9437a1a76ed395');
        $this->addSql('ALTER TABLE urls ADD CONSTRAINT FK_2A9437A1A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE urls DROP CONSTRAINT FK_2A9437A1A76ED395');
        $this->addSql('ALTER TABLE urls ADD CONSTRAINT fk_2a9437a1a76ed395 FOREIGN KEY (user_id) REFERENCES urls (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
