<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221015191539 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add nullable for PM2.5';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE weather_data ALTER pm25 DROP NOT NULL');
        $this->addSql('ALTER TABLE weather_data ALTER pm25_avg DROP NOT NULL');
        $this->addSql('ALTER TABLE weather_data ALTER aqi DROP NOT NULL');
        $this->addSql('ALTER TABLE weather_data ALTER aqi_avg DROP NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE weather_data ALTER pm25 SET NOT NULL');
        $this->addSql('ALTER TABLE weather_data ALTER pm25_avg SET NOT NULL');
        $this->addSql('ALTER TABLE weather_data ALTER aqi SET NOT NULL');
        $this->addSql('ALTER TABLE weather_data ALTER aqi_avg SET NOT NULL');
    }
}
