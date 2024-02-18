<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240218144811 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add lightning sensor';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE weather_data ADD lightning_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE weather_data ADD lightning_distance INT DEFAULT NULL');
        $this->addSql('ALTER TABLE weather_data ADD lightning_daily INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE weather_data DROP lightning_date');
        $this->addSql('ALTER TABLE weather_data DROP lightning_distance');
        $this->addSql('ALTER TABLE weather_data DROP lightning_daily');
    }
}
