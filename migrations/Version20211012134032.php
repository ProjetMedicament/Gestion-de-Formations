<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211012134032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE film ADD studio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE film ADD CONSTRAINT FK_8244BE22446F285F FOREIGN KEY (studio_id) REFERENCES studio (id)');
        $this->addSql('CREATE INDEX IDX_8244BE22446F285F ON film (studio_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE film DROP FOREIGN KEY FK_8244BE22446F285F');
        $this->addSql('DROP INDEX IDX_8244BE22446F285F ON film');
        $this->addSql('ALTER TABLE film DROP studio_id');
    }
}
