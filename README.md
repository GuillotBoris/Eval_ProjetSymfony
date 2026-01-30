# Eval_ProjetSymfony

Le projet est public mais deviendra privé une fois corrigé.

On 3 types d'utilisateur:
- Administrateur : ROLE_ADMIN A droit a tout 
- Personnel de l’agence : ROLE_USER Doit avoir un compte (dans AppFixtures 3 exemples)  accéder à la liste de tickets, les visualiser et modifier le statut
- Clients ou Visiteur : N'a pas de compte, a droit de creer des tickets : e-mail, description et categorie  

## Realisation 

Etape par etape pour l'Eval - liste des commandes realiser 

### 1. Version 

```bash
> php -v
PHP 8.4.13 (cli) (built: Sep 23 2025 15:17:09) (ZTS Visual C++ 2022 x64)
Copyright (c) The PHP Group
Zend Engine v4.4.13, Copyright (c) Zend Technologies

> symfony version
Symfony CLI version 5.16.1 (c) 2021-2026 Fabien Potencier (2025-11-25T07:30:20Z - stable)
 
> composer --version
Composer version 2.9.4 2026-01-22 14:08:50
PHP version 8.4.13  
Run the "diagnose" command to get more detailed diagnostics output. 
```

### 2. Creation de projet et installation de la page d'acceuil

```bash
symfony new Eval_ProjetSymfony --version="6.4.*" --webapp
```

Installation twig 
```bash
composer require symfony/twig-bundle 
```

Creation du controleur du fichier de test aussi
```bash
php bin/console make:controller HomeController 
```

Installation librairie Form pour les formulaires
```bash
composer require symfony/form
```

Creation du entity Ticket
```bash
symfony console make:entity Ticket
```

Creation du formulaire TicketType
```bash
symfony console make:form TicketType
>Ticket
```

# 3. Installation ORM (orm-pack), Validator (validator) et Sécurité (SecurityBundle) 

Installation 
ORM (orm-pack), 
Validator (validator) 
et Sécurité (SecurityBundle) 

```bash
composer require symfony/orm-pack
composer require symfony/validator
composer require symfony/security-bundle
```

MakerBundle de Symfony creer automatiquement la classe user et le systeme d'authentification avec
```bash
symfony console make:user
>User 
>yes 
>email 
>yes 
```

Probleme de connexion mySQL pour cela recherche et modification du php.ini (extension=pdo_mysql)
```bash
php --ini
php -m
```

Dans le .env changer DATABASE_URL avec la base de donnee bdEvalSymfony en mysql
```bash
DATABASE_URL="mysql://root:@127.0.0.1:3306/bdEvalSymfony?serverVersion=8.0.32&charset=utf8mb4"
```

Creation de la base de donnee
```bash
php bin/console doctrine:database:create
```

Migration avec preparation et realisation 
```bash
symfony console make:migration
symfony console doctrine:migration:migrate
>yes
```

La base de donnee bdEvalSymfony est bien creer avec les tables :  	
- doctrine_migration_versions	
- messenger_messages
- ticket
- user

Hash un mot de passe
```bash
symfony console security:hash-password
```

Insertion Execute requete SQL 
```bash 
symfony console dbal:run-sql "INSERT INTO user (email, roles, password) VALUES ('admin@eval.local','[\"ROLE_ADMIN\"]', 'Hash pwd')"

symfony console dbal:run-sql "SELECT * FROM user"
```

install Fixtures (jeu de test sur la base de donnee) et chargement 
```bash 
composer require orm-fixtures --dev
symfony console make:fixture
>AppFixtures
symfony console debug:autowiring password
symfony console doctrine:fixtures:load
>y
```

La derniere insertion a été effacer car on mis yes
On va maintenant faire le formulaire d'Authentification 
```bash
symfony console make:auth
> 1
> LoginAuthenticator
> SecurityController
> yes
> yes
> 1
```

On modifie DataFixtures\AppFixtures.php pour un jeu de test et on relance 
```bash
symfony console doctrine:fixtures:load
```
L'insertion du jeux de test est ok 
Maintenant on peut testé https://127.0.0.1:8000/login apres modification onAuthenticationSuccess 
Ajout du logout dans la page d'acceuil 

# 4. Modification du code et creation d'une page formulaire pour l'admin 
- Modification du code pour la class Ticket pour avoir tous les champs 

Creation du formulaire TicketAdminType
```bash
symfony console make:form TicketAdminType
>Ticket
```

Creation du controlleur 
```bash
symfony console make:controller TicketAdminController
>yes 
```

Modification ticket_admin/index.html.twig avec 
le meme principe que le fichier home/index.html.twig avec plus de champ

Regeneration de la migration 
```bash
 php bin/console make:migration
 php bin/console doctrine:migrations:migrate
```
La base de donnee ticket contient les nouveaux champs 
 
Creation des chemins pour creation, edition, modification, suppression du formulaire ... fichier
- nouveau.html.twig
- edit.html.twig  

5. Modification du code et creation d'une page formulaire pour le Personnel de l’agence 

- Modification du code pour la class Ticket pour avoir tous les champs 

Creation du formulaire TicketUserType
```bash
symfony console make:form TicketUserType
>Ticket
```

Creation du controlleur 
```bash
symfony console make:controller TicketUserController
>yes 
```
7. Ajustement Et netoyage du code  

- Ajout du menu et des oublies sur les controles et mise a jour des dates  


## Enonce Projet Symfony 

Contexte

Vous avez été embauché·e par une agence web, et votre responsable vous confie un premier projet.

Il s’agit d’un projet interne à l’agence, qui a pour but de suivre les tickets que peuvent créer les clients.

Il y aura une partie accessible à tout visiteur. Elle ne contiendra qu’une page, qui sera la page d’accueil, comprenant :

    un bouton de connexion ;
    un formulaire permettant de saisir un ticket.

Chaque ticket aura les propriétés suivantes :

    auteur (adresse e-mail du client) ;
    date d’ouverture (automatiquement renseignée à la création du ticket) ;
    date de clôture (renseignée par votre responsable lorsqu’il validera la fermeture du ticket) ;
    description (zone de saisie de type « textarea » – de 20 à 250 caractères) ;
    catégorie : elle devra se présenter sous la forme d’une liste déroulante et contenir les valeurs suivantes : « Incident », « Panne », « Évolution », « Anomalie », « Information ». Cette liste devra pouvoir être modifiée par l’administrateur ;
    statut : il devra se présenter sous la forme d’une liste déroulante et contenir les valeurs suivantes : « Nouveau », « Ouvert », « Résolu », « Fermé ». Cette liste devra pouvoir être modifiée par l’administrateur ;
    responsable : il s’agit de la personne chargée de traiter le ticket.

Le client ne pourra renseigner que :

    son adresse e-mail ;
    la description ;
    la catégorie.

L’administrateur doit pouvoir créer et modifier tous les types de données (statut, catégorie, responsable, ticket).

Le personnel de l’agence peut uniquement accéder à la liste de tickets, les visualiser et modifier le statut.

Les utilisateurs connectés (administrateur et personnel de l’agence) doivent pouvoir accéder aux différentes parties via un menu et se déconnecter.

## Objectif 

Votre mission

Vous devrez réaliser cette application en utilisant Symfony, tout en appliquant les (bonnes) pratiques de l’agence :

    les modifications du schéma de la base de données sont réalisées à l’aide des migrations ;
    les étapes significatives font systématiquement l’objet de commits. Ces derniers sont poussés sur GitHub ;
    un jeu d’essais est mis à disposition sous forme de fixtures ;
    les valeurs saisies devront impérativement être vérifiées en back ;
    l’utilisation de Bootstrap est recommandée ;
    le code devra être correctement indenté, les commentaires pertinents sont les bienvenus.

## Livrable

Vous transmettrez un fichier PDF contenant :

    le lien du dépôt GitHub sur lequel vous avez déposé votre projet ;
    l’identifiant et le mot de passe du compte administrateur.
