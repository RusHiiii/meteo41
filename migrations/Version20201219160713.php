<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201219160713 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE observation CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE post CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE unit CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE weather_data CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE weather_station CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact CHANGE created_at created_at DATE NOT NULL');
        $this->addSql('ALTER TABLE observation CHANGE created_at created_at DATE NOT NULL, CHANGE updated_at updated_at DATE NOT NULL');
        $this->addSql('ALTER TABLE post CHANGE created_at created_at DATE NOT NULL, CHANGE updated_at updated_at DATE NOT NULL');
        $this->addSql('ALTER TABLE unit CHANGE created_at created_at DATE NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE created_at created_at DATE NOT NULL, CHANGE updated_at updated_at DATE NOT NULL');
        $this->addSql('ALTER TABLE weather_data CHANGE created_at created_at DATE NOT NULL');
        $this->addSql('ALTER TABLE weather_station CHANGE created_at created_at DATE NOT NULL, CHANGE updated_at updated_at DATE NOT NULL');
    }
}
