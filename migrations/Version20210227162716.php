<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210227162716 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE weather_data ADD heat_index NUMERIC(3, 1) NOT NULL');
        $this->addSql('ALTER TABLE weather_station ADD prefered_unit_id INT NOT NULL');
        $this->addSql('ALTER TABLE weather_station ADD CONSTRAINT FK_3B061BFAF246D619 FOREIGN KEY (prefered_unit_id) REFERENCES unit (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_3B061BFAF246D619 ON weather_station (prefered_unit_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE weather_data DROP heat_index');
        $this->addSql('ALTER TABLE weather_station DROP FOREIGN KEY FK_3B061BFAF246D619');
        $this->addSql('DROP INDEX IDX_3B061BFAF246D619 ON weather_station');
        $this->addSql('ALTER TABLE weather_station DROP prefered_unit_id');
    }
}
