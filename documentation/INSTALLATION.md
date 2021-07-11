# How to install this project ?

# Requirement
- PHP >= 7.4 + extensions (json, xml, simplexml, mysql, ctype, iconv, dom)
- MYSQL
- Google MAP API and Geocoding API key (free)
- OpenWeatherMap API (free)
		
## Installation
- ```git clone https://github.com/RusHiiii/meteo41.git```
- ```echo "create database meteo41" | mysql -uroot -p```
- ```echo "create database meteo41_test" | mysql -uroot -p```
- ```composer install```
- ```npm install```
- ```bin/console doctrine:migration:migrate```

Don't forget to setup MYSQL connection (password, username) with .env file
Don't forget to setup JWT private and public key [here](https://symfonycasts.com/screencast/symfony-rest4/lexikjwt-authentication-bundle#generating-the-public-and-private-key).

NB: A setup file has been created, you can import it [here](/documentation/data.sql) (username: test@test.fr // password: pass123*)

## Toolkit

Launch PHPStan:
`vendor/bin/phpstan analyse -l 4 src`

Launch PHPUnit:
`bin/phpunit --group=XXX [--filter=functionName]`

Launch Behat:
`vendor/bin/behat --format=progress [--name=scenario]`

Launch Infection:
`vendor/bin/infection --threads=4 --min-msi=48`

Launch PHPCS:
`vendor/bin/phpcs --standard=PSR12 src/ --warning-severity=0`

Launch PHPCBF:
`vendor/bin/phpcbf --standard=PSR12 src/`

Launch server:
`symfony server:start`

Launch build:
`yarn encore dev --watch`

Launch prettier:
`yarn prettier`