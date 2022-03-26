<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220320132102 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add default sequence';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('SELECT setval(\'contact_id_seq\', (SELECT MAX(id) FROM contact))');
        $this->addSql('ALTER TABLE contact ALTER id SET DEFAULT nextval(\'contact_id_seq\')');
        $this->addSql('SELECT setval(\'observation_id_seq\', (SELECT MAX(id) FROM observation))');
        $this->addSql('ALTER TABLE observation ALTER id SET DEFAULT nextval(\'observation_id_seq\')');
        $this->addSql('SELECT setval(\'post_id_seq\', (SELECT MAX(id) FROM post))');
        $this->addSql('ALTER TABLE post ALTER id SET DEFAULT nextval(\'post_id_seq\')');
        $this->addSql('SELECT setval(\'unit_id_seq\', (SELECT MAX(id) FROM unit))');
        $this->addSql('ALTER TABLE unit ALTER id SET DEFAULT nextval(\'unit_id_seq\')');
        $this->addSql('SELECT setval(\'user_id_seq\', (SELECT MAX(id) FROM "user"))');
        $this->addSql('ALTER TABLE "user" ALTER id SET DEFAULT nextval(\'user_id_seq\')');
        $this->addSql('SELECT setval(\'weather_data_id_seq\', (SELECT MAX(id) FROM weather_data))');
        $this->addSql('ALTER TABLE weather_data ALTER id SET DEFAULT nextval(\'weather_data_id_seq\')');
        $this->addSql('SELECT setval(\'weather_station_id_seq\', (SELECT MAX(id) FROM weather_station))');
        $this->addSql('ALTER TABLE weather_station ALTER id SET DEFAULT nextval(\'weather_station_id_seq\')');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE weather_data ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE contact ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE observation ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE unit ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE "user" ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE weather_station ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE post ALTER id DROP DEFAULT');
    }
}
