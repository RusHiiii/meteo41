<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220319144306 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Setup DB for postrgesql';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE contact_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE observation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE post_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE unit_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE weather_data_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE weather_station_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE contact (id INT NOT NULL, name VARCHAR(50) NOT NULL, email VARCHAR(32) NOT NULL, subject VARCHAR(50) NOT NULL, message TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE observation (id INT NOT NULL, user_id INT DEFAULT NULL, weather_station_id INT NOT NULL, message VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C576DBE0A76ED395 ON observation (user_id)');
        $this->addSql('CREATE INDEX IDX_C576DBE09E475DA2 ON observation (weather_station_id)');
        $this->addSql('CREATE TABLE post (id INT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, description TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DA76ED395 ON post (user_id)');
        $this->addSql('CREATE TABLE unit (id INT NOT NULL, temperature_unit VARCHAR(5) NOT NULL, speed_unit VARCHAR(5) NOT NULL, pressure_unit VARCHAR(5) NOT NULL, rain_unit VARCHAR(5) NOT NULL, solar_radiation_unit VARCHAR(5) NOT NULL, pm_unit VARCHAR(5) NOT NULL, humidity_unit VARCHAR(5) NOT NULL, cloud_base_unit VARCHAR(5) NOT NULL, wind_dir_unit VARCHAR(5) NOT NULL, type VARCHAR(32) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX unit_type ON unit (type)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX user_email ON "user" (email)');
        $this->addSql('CREATE TABLE weather_data (id INT NOT NULL, unit_id INT NOT NULL, weather_station_id INT NOT NULL, temperature NUMERIC(3, 1) NOT NULL, heat_index NUMERIC(3, 1) NOT NULL, humidity INT NOT NULL, relative_pressure NUMERIC(5, 1) NOT NULL, absolute_pressure NUMERIC(5, 1) NOT NULL, wind_direction INT NOT NULL, wind_direction_avg INT NOT NULL, wind_speed NUMERIC(4, 1) NOT NULL, wind_speed_avg NUMERIC(4, 1) NOT NULL, wind_gust NUMERIC(4, 1) NOT NULL, wind_max_daily_gust NUMERIC(4, 1) NOT NULL, rain_rate NUMERIC(4, 1) NOT NULL, rain_event NUMERIC(4, 1) NOT NULL, rain_hourly NUMERIC(4, 1) NOT NULL, rain_daily NUMERIC(4, 1) NOT NULL, rain_weekly NUMERIC(4, 1) NOT NULL, rain_monthly NUMERIC(4, 1) NOT NULL, rain_yearly NUMERIC(5, 1) NOT NULL, solar_radiation NUMERIC(5, 1) NOT NULL, uv INT NOT NULL, pm25 NUMERIC(4, 1) NOT NULL, pm25_avg NUMERIC(4, 1) NOT NULL, humidex NUMERIC(3, 1) NOT NULL, dew_point NUMERIC(3, 1) NOT NULL, wind_chill NUMERIC(3, 1) DEFAULT NULL, cloud_base INT NOT NULL, beaufort_scale INT NOT NULL, aqi INT NOT NULL, aqi_avg INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3370691AF8BD700D ON weather_data (unit_id)');
        $this->addSql('CREATE INDEX IDX_3370691A9E475DA2 ON weather_data (weather_station_id)');
        $this->addSql('CREATE TABLE weather_station (id INT NOT NULL, prefered_unit_id INT NOT NULL, name VARCHAR(50) NOT NULL, description TEXT NOT NULL, short_description TEXT NOT NULL, country VARCHAR(100) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(100) NOT NULL, reference VARCHAR(100) NOT NULL, lat NUMERIC(6, 4) NOT NULL, lng NUMERIC(6, 4) NOT NULL, api_token VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, elevation VARCHAR(10) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3B061BFAAEA34913 ON weather_station (reference)');
        $this->addSql('CREATE INDEX IDX_3B061BFAF246D619 ON weather_station (prefered_unit_id)');
        $this->addSql('ALTER TABLE observation ADD CONSTRAINT FK_C576DBE0A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE observation ADD CONSTRAINT FK_C576DBE09E475DA2 FOREIGN KEY (weather_station_id) REFERENCES weather_station (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE weather_data ADD CONSTRAINT FK_3370691AF8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE weather_data ADD CONSTRAINT FK_3370691A9E475DA2 FOREIGN KEY (weather_station_id) REFERENCES weather_station (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE weather_station ADD CONSTRAINT FK_3B061BFAF246D619 FOREIGN KEY (prefered_unit_id) REFERENCES unit (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE weather_data DROP CONSTRAINT FK_3370691AF8BD700D');
        $this->addSql('ALTER TABLE weather_station DROP CONSTRAINT FK_3B061BFAF246D619');
        $this->addSql('ALTER TABLE observation DROP CONSTRAINT FK_C576DBE0A76ED395');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT FK_5A8A6C8DA76ED395');
        $this->addSql('ALTER TABLE observation DROP CONSTRAINT FK_C576DBE09E475DA2');
        $this->addSql('ALTER TABLE weather_data DROP CONSTRAINT FK_3370691A9E475DA2');
        $this->addSql('DROP SEQUENCE contact_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE observation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE post_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE unit_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE weather_data_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE weather_station_id_seq CASCADE');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE observation');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE unit');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE weather_data');
        $this->addSql('DROP TABLE weather_station');
    }
}
