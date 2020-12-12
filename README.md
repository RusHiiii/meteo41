# Projet Symfony - Meteo41
Damiens Florent - 2020

# Présentation du projet
TODO

## Durée du projet
TODO

## Les outils
De multiples outils ont été utilisés dans le but d'améliorer la qualité du code. On note la présence de:
* PHPStan: outils d'analyse statique du code
* Infection: mutation testing
* Behat: framework de test en langage naturel
* PHPunit: Pour les tests

## Documentation :
* Analyse de la base de données: MCD et MLD
* Maquette HTML/CSS 
* Mise en place de test unitaire, d'intégration et fonctionnel
		
## ToolKit
Pour lancer PHPStan:
`vendor/bin/phpstan analyse -l 4 src tests`

Pour lancer PHPUnit:
`bin/phpunit --group=XXX [--filter=functionName]`

Pour lancer Behat:
`vendor/bin/behat --format=progress [--name=scenario]`

Pour lancer Infection:
`vendor/bin/infection --threads=4 --min-msi=48`