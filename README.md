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
