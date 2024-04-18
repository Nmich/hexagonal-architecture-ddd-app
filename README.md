# Architecture hexagonale et DDD

Voici notre projet exemple qui illustre l'utilisation dans un contexte avancé, intégrant l'architecture hexagonale et les principes du Domain-Driven Design (DDD).

**Qu'y découvrir ?**

**Architecture Hexagonale :** Découvre comment cette architecture facilite la séparation des responsabilités techniques ou non et améliore la testabilité et la maintenabilité de ton application.

**Patterns tactiques du DDD :** Découvre la manière de modéliser le cœur de ton application pour qu'elle réponde précisément aux exigences métier, rendant ainsi ton code à la fois plus clair et plus adaptable.

J'ai également utilisé le pattern 'command & command handler', un modèle utile pour représenter les cas d'usage utilisateurs.

**En bonus :** Tu pourras remarquer qu'il y a deux modèles Map ! Ce projet utilise CQRS, tel qu'exprimé par Greg Young. Si tu es curieux d'en savoir plus sur CQRS ou si tu souhaites que nous approfondissions ce sujet dans notre formation, fais-le-moi savoir !

Curieux de voir comment ces approches se traduisent en code ?

## Architecture hexagonale

L'**architecture hexagonale**, aussi connue sous le nom d'architecture ports et adaptateurs, est conçue pour découpler efficacement le code métier des aspects techniques tels que les frameworks et outils externes. Cette approche rend votre logique métier complètement indépendante, permettant sa réutilisation à travers diverses technologies sans effort. En conséquence, cela simplifie significativement les tests de votre application, en assurant une meilleure maintenabilité et évolutivité.

Pour comprendre en détail comment fonctionne cette architecture, je t’iinvite à lire mon article sur [l'architecture hexagonale](https://www.arnaudlanglade.com/hexagonal-architect-by-example.html).

## Les patterns tactiques du DDD
 
* Les **entities :** Ce sont les éléments de ton application qui ont une identité unique, comme la `Map` ou le `Marker`. Même si leurs propriétés changent, tu peux toujours les reconnaître

*  Les **Value Objects :** Ils représentent des caractéristiques sans identité propre, comme une date ou une adresse. Ils décrivent plutôt des aspects des entités.

* Les **Aggregates :** Imagine-les comme des groupes d'entités et d'objets de valeur qui représentent un concept métier. Ils rendent le travail sur de grandes quantités de données plus gérable en les divisant en morceaux plus petits.

* Le **repository :** Ils agissent comme des bibliothèques où tu peux stocker et retrouver tes entités. Cela te permet de séparer la façon dont tu conserves les données de la logique principale de ton application. Pour aller plus loin dans ta compréhension de ce pattern et découvrir comment les appliquer concrètement, je t’encourage à consulter mes articles dédiés à ce [sujet sur mon blog](https://www.arnaudlanglade.com/tag/repository).

## CQRS

**Command Query Responsibility Segregation**, tel que défini par Greg Young, consiste à créer deux objets distincts là où il n'en existait qu'un seul auparavant.  Cette séparation se base sur la nature de la méthode utilisée, soit une **commande** soit une **query**. C'est le principe de CQS qui définit ces deux termes : une query renvoie un résultat sans modifier l'état de l'objet, tandis qu'une command modifie l'état de l'objet sans renvoyer de résultat.

Pour plus d'informations sur le sujet, j'ai écrit un article expliquant les différences entre [CQS et CQRS](https://www.arnaudlanglade.com/what-is-the-difference-between-cqs-and-cqrs-patterns.html)

Avec le temps, d'autres développeurs ont enrichi ce pattern pour répondre à des problématiques plus complexes. Dans cette application, nous n'utiliserons pas de projection, d'event sourcing, ni plusieurs bases de données.

## Command & Command handlers

Dans ce projet, les actions des utilisateurs sont gérées par des **commandes**, des objets qui encapsulent toutes les informations nécessaires à l'exécution d'une action. Chaque commande est traitée par un **command handler**, une fonction dédiée qui exécute l'ensemble des opérations requises pour accomplir l'action demandée par l'utilisateur.

Nous utilisons Symfony Messenger comme command bus pour orchestrer la prise en charge des commandes.

Pour une compréhension plus approfondie de ces concepts, je vous invite à consulter mes articles dédiés à ce sujet [ici](https://www.arnaudlanglade.com/tag/command-bus).


## Getting Started

Ce projet utilise Docker pour lancer l'application. Si ce n'est pas déjà fait, veuillez  [installer Docker Compose](https://docs.docker.com/compose/install/) (v2.10+).

Toutes les commandes du projet sont exécutées via make. Pour consulter toutes les commandes disponibles, utilisez la commande suivante :

```
make help
```
## Installation du projet

Exécutez `make build` pour construire de nouvelles images.
Exécutez `make up` pour démarrer le projet.
Exécutez `make database` pour créer la base de données.

Note : 
* Pour arrêter les conteneurs Docker, utilisez la commande `make down`.
* Pour installer les dépendances du projet, utilisez la commande `make composer c=install` (les vendors sont normalement installés au build de l'image Docker).

## Lancer les tests

Pour exécuter les tests couvrant le Domain et la UserInterface, utilisez la commande suivante :

```
make test
```

Pour les tests concernant l'Infra, utilisez la commande :

```
make testio
```

Attention, la base de données doit être activée pour exécuter les tests de l'Infra. Pour lancer la base de données, utilisez :

```
make up
```
