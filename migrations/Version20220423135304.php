<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220423135304 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add new sensor';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE weather_data ADD soil_temperature NUMERIC(3, 1) DEFAULT NULL');
        $this->addSql('ALTER TABLE weather_data ADD leaf_wetness INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE weather_data DROP soil_temperature');
        $this->addSql('ALTER TABLE weather_data DROP leaf_wetness');
    }
}
