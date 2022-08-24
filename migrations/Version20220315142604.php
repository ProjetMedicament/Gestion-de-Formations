<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220315142604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE acteur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE film (id INT AUTO_INCREMENT NOT NULL, studio_id INT DEFAULT NULL, levisa_id INT DEFAULT NULL, titre VARCHAR(50) NOT NULL, date_sortie DATE NOT NULL, resume VARCHAR(255) NOT NULL, INDEX IDX_8244BE22446F285F (studio_id), UNIQUE INDEX UNIQ_8244BE22C0FE6519 (levisa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE film_acteur (film_id INT NOT NULL, acteur_id INT NOT NULL, INDEX IDX_8108EE68567F5183 (film_id), INDEX IDX_8108EE68DA6F574A (acteur_id), PRIMARY KEY(film_id, acteur_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE studio (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, pays VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visa (id INT AUTO_INCREMENT NOT NULL, numero INT NOT NULL, pays VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE film ADD CONSTRAINT FK_8244BE22446F285F FOREIGN KEY (studio_id) REFERENCES studio (id)');
        $this->addSql('ALTER TABLE film ADD CONSTRAINT FK_8244BE22C0FE6519 FOREIGN KEY (levisa_id) REFERENCES visa (id)');
        $this->addSql('ALTER TABLE film_acteur ADD CONSTRAINT FK_8108EE68567F5183 FOREIGN KEY (film_id) REFERENCES film (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE film_acteur ADD CONSTRAINT FK_8108EE68DA6F574A FOREIGN KEY (acteur_id) REFERENCES acteur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employe DROP FOREIGN KEY FK_F804D3B95DAC5993');
        $this->addSql('DROP INDEX IDX_F804D3B95DAC5993 ON employe');
        $this->addSql('ALTER TABLE employe DROP inscription_id');
        $this->addSql('ALTER TABLE formation ADD min_inscrits INT NOT NULL, ADD description VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE inscription ADD id INT AUTO_INCREMENT NOT NULL, CHANGE employe_id employe_id INT DEFAULT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D61B65292 FOREIGN KEY (employe_id) REFERENCES employe (id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D61B65292 ON inscription (employe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE film_acteur DROP FOREIGN KEY FK_8108EE68DA6F574A');
        $this->addSql('ALTER TABLE film_acteur DROP FOREIGN KEY FK_8108EE68567F5183');
        $this->addSql('ALTER TABLE film DROP FOREIGN KEY FK_8244BE22446F285F');
        $this->addSql('ALTER TABLE film DROP FOREIGN KEY FK_8244BE22C0FE6519');
        $this->addSql('DROP TABLE acteur');
        $this->addSql('DROP TABLE film');
        $this->addSql('DROP TABLE film_acteur');
        $this->addSql('DROP TABLE studio');
        $this->addSql('DROP TABLE visa');
        $this->addSql('ALTER TABLE employe ADD inscription_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE employe ADD CONSTRAINT FK_F804D3B95DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (employe_id)');
        $this->addSql('CREATE INDEX IDX_F804D3B95DAC5993 ON employe (inscription_id)');
        $this->addSql('ALTER TABLE formation DROP min_inscrits, DROP description');
        $this->addSql('ALTER TABLE inscription MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D61B65292');
        $this->addSql('DROP INDEX IDX_5E90F6D61B65292 ON inscription');
        $this->addSql('ALTER TABLE inscription DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE inscription DROP id, CHANGE employe_id employe_id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE inscription ADD PRIMARY KEY (employe_id)');
    }
}
