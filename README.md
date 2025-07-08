# Test technique ClubFunding partie backend

La partie backend est réalisée avec Laravel 9 comme demandé dans le document de test technique. 

Il s'agit d'une API RESTful permet de gérer des projets et leurs tâches associées. Elle offre des fonctionnalités complètes de CRUD, pagination, filtrage et validation.

Pour la partie frontend, une application React est disponible dans un dépôt séparé. ici : https://github.com/maximilien-regnier/test-clubfunding-frontend
Consultez le README de ce dépôt pour les instructions d'installation et d'utilisation.

## Prérequis

- Docker et Docker Compose
- Git
- Composer
- PHP


## Installation

1. Cloner le dépôt

```bash
git clone git@github.com:maximilien-regnier/test-clubfunding-api.git
cd test-clubfunding-api
```

2. Installer les dépendances avec Laravel Sail

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install
```

3. Configurer les variables d'environnement

Si utilisation avec Docker + Laravel Sail alors il suffit de copier le fichier .env.example en .env

```bash
cp .env.example .env
```

4. Démarrer les conteneurs Docker

```bash
./vendor/bin/sail up -d
```

5. Générer la clé d'application

```bash
./vendor/bin/sail artisan key:generate
```

6. Exécuter les migrations et les seeders

```bash
./vendor/bin/sail artisan migrate --seed
```

Les seeders permettent d'avoir déjà quelques projets et tâches dans la base de données.

## Tests

Exécuter les tests PHPUnit:

```bash
./vendor/bin/sail artisan test
```

## Utilisation de l'API

### Endpoints Disponibles

#### Projets

- `GET /api/projects` - Liste des projets (avec pagination et filtrage)
- `POST /api/projects` - Créer un nouveau projet
- `GET /api/projects/{id}` - Détails d'un projet
- `PUT /api/projects/{id}` - Modifier un projet
- `DELETE /api/projects/{id}` - Supprimer un projet
- `GET /api/projects/{id}/tasks` - Tâches d'un projet spécifique

#### Tâches

- `GET /api/tasks` - Liste des tâches (avec pagination et filtrage)
- `POST /api/tasks` - Créer une nouvelle tâche
- `GET /api/tasks/{id}` - Détails d'une tâche
- `PUT /api/tasks/{id}` - Modifier une tâche
- `DELETE /api/tasks/{id}` - Supprimer une tâche

### Paramètres de Filtrage

#### Projets

- `name` - Recherche par nom (insensible à la casse)
- `created_from` - Projets créés à partir de cette date
- `created_to` - Projets créés jusqu'à cette date
- `sort_by` - Tri par: `id`, `name`, `created_at`, `updated_at`
- `sort_order` - Ordre: `asc`, `desc`
- `per_page` - Éléments par page (1-100)
- `page` - Numéro de page

#### Tâches

- `status` - Filtrer par statut: `pending`, `completed`
- `project_id` - Filtrer par projet
- `title` - Recherche par titre (insensible à la casse)
- `created_from` - Tâches créées à partir de cette date
- `created_to` - Tâches créées jusqu'à cette date
- `sort_by` - Tri par: `id`, `title`, `status`, `created_at`, `updated_at`
- `sort_order` - Ordre: `asc`, `desc`
- `per_page` - Éléments par page (1-100)
- `page` - Numéro de page

## Frontend React

Un frontend React est disponible dans un dépôt séparé. Consultez le README de ce dépôt pour les instructions d'installation et d'utilisation.

## Commandes Planifiées

Une commande est planifiée pour s'exécuter quotidiennement à 9h00 et envoyer des rappels pour les tâches en attente depuis plus de 7 jours:

```bash
./vendor/bin/sail artisan tasks:send-overdue-reminders
```

Pour tester manuellement cette commande:

```bash
./vendor/bin/sail artisan tasks:send-overdue-reminders
```