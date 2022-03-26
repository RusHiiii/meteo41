# Projet Symfony - Meteo41
Damiens Florent - 2020/2021

# Installation

See my installation procedure [here](documentation/INSTALLATION.md).

# Présentation du projet
Site de météo pour les stations supportant le protocole Ecowitt, les données du site sont MàJ chaque minute. Le site supporte plusieurs stations.

## Technologies
- PHP 7.4
- React 17
- Symfony 4.4
- PostgreSQL

Déploiement et build de PR automatique via Github Action. Utilisation de OpenVPN pour le déploiement sur mon serveur. J'utilise Proxmox pour mon infrastructure, le serveur Web est une des machines de mon sous-réseau. 

## Durée du projet
Le projet a été commencé à partir de Juillet 2020.

| Type            |               Temps                |
|-----------------|:----------------------------------:|
| Back-End        | Novembre 2020 - Avril 2021         |
| Front-End       | Avril 2021 - Juillet 2021          |
| Mise en ligne   | Juillet 2021                       |

## Les outils
De multiples outils ont été utilisés dans le but d'améliorer la qualité du code. On note la présence de:
* PHPStan: outils d'analyse statique du code
* Infection: mutation testing
* Behat: framework de test en langage naturel
* PHPunit: Pour les tests
* CI/CD: Utilisation des Github Actions

## Documentation :
* Analyse de la base de données: MCD et MLD
* Maquette HTML/CSS 
* Mise en place de tests (unitaire, intégration et fonctionnel)
		
## ToolKit Back
Pour lancer PHPStan:
`vendor/bin/phpstan analyse -l 4 src tests`

Pour lancer PHPUnit:
`bin/phpunit --group=XXX [--filter=functionName]`

Pour lancer Behat:
`vendor/bin/behat --format=progress [--name=scenario]`

Pour lancer Infection:
`vendor/bin/infection --threads=4 --min-msi=48`

Pour lancer PHPCS:
`vendor/bin/phpcs --standard=PSR12 src/ --warning-severity=0`

Pour lancer PHPCBF:
`vendor/bin/phpcbf --standard=PSR12 src/`

Pour lancer le serveur:
`symfony server:start`

## ToolKit Front
Pour lancer le build:
`yarn encore dev --watch`

Pour prettier les fichiers:
`yarn prettier`