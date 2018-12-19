## Installation

    $ git clone https://perin011@iut-info.univ-reims.fr/gitlab/perin011/Symfony_quote-machine.git

    $ cd Symfony_quote-machine

    $ composer install

    $ npm install

## Modifier ensuite les variables d'environnement du fichier .env selon votre environnement local.

DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name

## Création, migration, fixtures de la base de données

    $ php bin/console doctrine:database:create

    $ php bin/console doctrine:migrations:migrate

    $ php bin/console doctrine:fixtures:load

## lancer le serveur

    $ php bin/console server:start

## Fonctionnalité

### log de test

en tant qu'admin -> login: admin password: admin
en tant que user -> login: test password: test

### Quotes

Possibilité de rechercher une quote contenant certain mot

Une personne non connecté peut seulement rechercher et consulter les quotes

Un user peut ajouter une quote et modifier ou supprimer celles qu'il a posté

Un admin peut modifier ou supprimer n'importe quelle quote

### Catégorie

Une catégorie regroupe plusieurs quotes

Possibilité de voir les quotes appartenants à une catégorie

Un admin peut ajouter / modifier / supprimer une quotes

###Commande

Afficher une quote random

    $ php bin/console app:getRandomQuote

Afficher une quote random appartenant à une catégorie spécifique

    $ php bin/console app:getRandomQuote categ1

###Tests
ne passe plus après l'ajout des rôles

    $ php bin/phpunit
