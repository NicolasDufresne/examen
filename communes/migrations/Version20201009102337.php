<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201009102337 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C5969B77A FOREIGN KEY (communes_id) REFERENCES communes (id)');
        $this->addSql('CREATE INDEX IDX_6A2CA10C5969B77A ON media (communes_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C5969B77A');
        $this->addSql('DROP INDEX IDX_6A2CA10C5969B77A ON media');
    }
}
