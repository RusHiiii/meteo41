<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220227142138 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX windDirectionAvg ON weather_data');
        $this->addSql('DROP INDEX solarRadiation ON weather_data');
        $this->addSql('DROP INDEX windSpeedAvg ON weather_data');
        $this->addSql('DROP INDEX windMaxDailyGust ON weather_data');
        $this->addSql('DROP INDEX rainEvent ON weather_data');
        $this->addSql('DROP INDEX heatIndex ON weather_data');
        $this->addSql('DROP INDEX rainDaily ON weather_data');
        $this->addSql('DROP INDEX relativePressure ON weather_data');
        $this->addSql('DROP INDEX rainMonthly ON weather_data');
        $this->addSql('DROP INDEX aqiAvg ON weather_data');
        $this->addSql('DROP INDEX pm25 ON weather_data');
        $this->addSql('DROP INDEX humidex ON weather_data');
        $this->addSql('DROP INDEX windChill ON weather_data');
        $this->addSql('DROP INDEX beaufortScale ON weather_data');
        $this->addSql('DROP INDEX rainYearly ON weather_data');
        $this->addSql('DROP INDEX windSpeed ON weather_data');
        $this->addSql('DROP INDEX uv ON weather_data');
        $this->addSql('DROP INDEX windGust ON weather_data');
        $this->addSql('DROP INDEX rainRate ON weather_data');
        $this->addSql('DROP INDEX temperature ON weather_data');
        $this->addSql('DROP INDEX rainHourly ON weather_data');
        $this->addSql('DROP INDEX humidity ON weather_data');
        $this->addSql('DROP INDEX rainWeekly ON weather_data');
        $this->addSql('DROP INDEX windDirection ON weather_data');
        $this->addSql('DROP INDEX pm25Avg ON weather_data');
        $this->addSql('DROP INDEX dewPoint ON weather_data');
        $this->addSql('DROP INDEX cloudBase ON weather_data');
        $this->addSql('DROP INDEX aqi ON weather_data');
        $this->addSql('DROP INDEX createdAt ON weather_data');
        $this->addSql('ALTER TABLE weather_data ADD year INT NOT NULL, ADD month INT NOT NULL, ADD day INT NOT NULL');
        $this->addSql('CREATE INDEX createdAt ON weather_data (year, month, day)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX createdAt ON weather_data');
        $this->addSql('ALTER TABLE weather_data DROP year, DROP month, DROP day');
        $this->addSql('CREATE INDEX windDirectionAvg ON weather_data (wind_direction_avg)');
        $this->addSql('CREATE INDEX solarRadiation ON weather_data (solar_radiation)');
        $this->addSql('CREATE INDEX windSpeedAvg ON weather_data (wind_speed_avg)');
        $this->addSql('CREATE INDEX windMaxDailyGust ON weather_data (wind_max_daily_gust)');
        $this->addSql('CREATE INDEX rainEvent ON weather_data (rain_event)');
        $this->addSql('CREATE INDEX heatIndex ON weather_data (heat_index)');
        $this->addSql('CREATE INDEX rainDaily ON weather_data (rain_daily)');
        $this->addSql('CREATE INDEX relativePressure ON weather_data (relative_pressure)');
        $this->addSql('CREATE INDEX rainMonthly ON weather_data (rain_monthly)');
        $this->addSql('CREATE INDEX aqiAvg ON weather_data (aqi_avg)');
        $this->addSql('CREATE INDEX pm25 ON weather_data (pm25)');
        $this->addSql('CREATE INDEX humidex ON weather_data (humidex)');
        $this->addSql('CREATE INDEX windChill ON weather_data (wind_chill)');
        $this->addSql('CREATE INDEX beaufortScale ON weather_data (beaufort_scale)');
        $this->addSql('CREATE INDEX rainYearly ON weather_data (rain_yearly)');
        $this->addSql('CREATE INDEX windSpeed ON weather_data (wind_speed)');
        $this->addSql('CREATE INDEX uv ON weather_data (uv)');
        $this->addSql('CREATE INDEX windGust ON weather_data (wind_gust)');
        $this->addSql('CREATE INDEX rainRate ON weather_data (rain_rate)');
        $this->addSql('CREATE INDEX temperature ON weather_data (temperature)');
        $this->addSql('CREATE INDEX rainHourly ON weather_data (rain_hourly)');
        $this->addSql('CREATE INDEX humidity ON weather_data (humidity)');
        $this->addSql('CREATE INDEX rainWeekly ON weather_data (rain_weekly)');
        $this->addSql('CREATE INDEX windDirection ON weather_data (wind_direction)');
        $this->addSql('CREATE INDEX pm25Avg ON weather_data (pm25_avg)');
        $this->addSql('CREATE INDEX dewPoint ON weather_data (dew_point)');
        $this->addSql('CREATE INDEX cloudBase ON weather_data (cloud_base)');
        $this->addSql('CREATE INDEX aqi ON weather_data (aqi)');
        $this->addSql('CREATE INDEX createdAt ON weather_data (created_at)');
    }
}
