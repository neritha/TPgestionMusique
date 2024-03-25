<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240314125105 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE nationalite (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, drapeau VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artiste ADD nationalite_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE artiste ADD CONSTRAINT FK_9C07354F1B063272 FOREIGN KEY (nationalite_id) REFERENCES nationalite (id)');
        $this->addSql('CREATE INDEX IDX_9C07354F1B063272 ON artiste (nationalite_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artiste DROP FOREIGN KEY FK_9C07354F1B063272');
        $this->addSql('DROP TABLE nationalite');
        $this->addSql('DROP INDEX IDX_9C07354F1B063272 ON artiste');
        $this->addSql('ALTER TABLE artiste DROP nationalite_id');
    }
}
