# Eval_ProjetSymfony

Le projet est public mais deviendra privé une fois corrigé.

## Projet Symfony 

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


