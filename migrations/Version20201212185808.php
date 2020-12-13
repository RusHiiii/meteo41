<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201212185808 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, email VARCHAR(32) NOT NULL, subject VARCHAR(50) NOT NULL, message LONGTEXT NOT NULL, created_at DATE NOT NULL, INDEX email (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE observation (id INT NOT NULL, user_id INT DEFAULT NULL, weather_station_id INT NOT NULL, message VARCHAR(255) NOT NULL, created_at DATE NOT NULL, updated_at DATE NOT NULL, INDEX IDX_C576DBE0A76ED395 (user_id), INDEX IDX_C576DBE09E475DA2 (weather_station_id), INDEX message (message), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, created_at DATE NOT NULL, updated_at DATE NOT NULL, INDEX IDX_5A8A6C8DA76ED395 (user_id), INDEX name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unit (id INT AUTO_INCREMENT NOT NULL, temperature_unit VARCHAR(5) NOT NULL, speed_unit VARCHAR(5) NOT NULL, rain_unit VARCHAR(5) NOT NULL, solar_radiation_unit VARCHAR(5) NOT NULL, pm_unit VARCHAR(5) NOT NULL, humidity_unit VARCHAR(5) NOT NULL, type VARCHAR(32) NOT NULL, created_at DATE NOT NULL, INDEX type (type), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, created_at DATE NOT NULL, updated_at DATE NOT NULL, INDEX email (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE weather_data (id INT AUTO_INCREMENT NOT NULL, unit_id INT NOT NULL, weather_station_id INT NOT NULL, temperature NUMERIC(3, 1) NOT NULL, humidity INT NOT NULL, relative_pressure NUMERIC(5, 1) NOT NULL, absolute_pressure NUMERIC(5, 1) NOT NULL, wind_direction INT NOT NULL, wind_direction_avg INT NOT NULL, wind_speed NUMERIC(4, 1) NOT NULL, wind_speed_avg NUMERIC(4, 1) NOT NULL, wind_gust NUMERIC(4, 1) NOT NULL, wind_max_daily_gust NUMERIC(4, 1) NOT NULL, rain_rate NUMERIC(4, 1) NOT NULL, rain_event NUMERIC(4, 1) NOT NULL, rain_hourly NUMERIC(4, 1) NOT NULL, rain_daily NUMERIC(4, 1) NOT NULL, rain_weekly NUMERIC(4, 1) NOT NULL, rain_monthly NUMERIC(4, 1) NOT NULL, rain_yearly NUMERIC(5, 1) NOT NULL, solar_radiation NUMERIC(5, 1) NOT NULL, uv INT NOT NULL, pm25 NUMERIC(4, 1) NOT NULL, pm25_avg NUMERIC(4, 1) NOT NULL, humidex INT NOT NULL, dew_point NUMERIC(3, 1) NOT NULL, wind_chill NUMERIC(3, 1) DEFAULT NULL, cloud_base INT NOT NULL, last_rain DATE NOT NULL, beaufort_scale INT NOT NULL, aqi INT NOT NULL, aqi_avg INT NOT NULL, created_at DATE NOT NULL, INDEX IDX_3370691AF8BD700D (unit_id), INDEX IDX_3370691A9E475DA2 (weather_station_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE weather_station (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, short_description VARCHAR(255) NOT NULL, country VARCHAR(100) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(100) NOT NULL, lat NUMERIC(6, 4) NOT NULL, lng NUMERIC(6, 4) NOT NULL, api_token VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, elevation VARCHAR(10) NOT NULL, created_at DATE NOT NULL, updated_at DATE NOT NULL, INDEX name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE observation ADD CONSTRAINT FK_C576DBE0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE observation ADD CONSTRAINT FK_C576DBE09E475DA2 FOREIGN KEY (weather_station_id) REFERENCES weather_station (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE weather_data ADD CONSTRAINT FK_3370691AF8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE weather_data ADD CONSTRAINT FK_3370691A9E475DA2 FOREIGN KEY (weather_station_id) REFERENCES weather_station (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE weather_data DROP FOREIGN KEY FK_3370691AF8BD700D');
        $this->addSql('ALTER TABLE observation DROP FOREIGN KEY FK_C576DBE0A76ED395');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DA76ED395');
        $this->addSql('ALTER TABLE observation DROP FOREIGN KEY FK_C576DBE09E475DA2');
        $this->addSql('ALTER TABLE weather_data DROP FOREIGN KEY FK_3370691A9E475DA2');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE observation');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE unit');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE weather_data');
        $this->addSql('DROP TABLE weather_station');
    }
}
