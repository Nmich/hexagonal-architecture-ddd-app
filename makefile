# Executables (local)
DOCKER_COMP = docker compose

# Executables
PHP      = $(DOCKER_COMP) exec php
COMPOSER = $(DOCKER_COMP) exec php composer
SYMFONY  = $(PHP) bin/console

# Misc
.DEFAULT_GOAL = help
.PHONY        : help build up start down logs composer vendor sf cc test testio cs database

## —— 🎵 🐳 The Symfony Docker Makefile 🐳 🎵 ——————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9\./_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— Docker 🐳 ————————————————————————————————————————————————————————————————
build: ## Builds the Docker images
	@$(DOCKER_COMP) build --pull --no-cache

up: ## Start the docker hub in detached mode (no logs)
	@$(DOCKER_COMP) up --detach

start: build up ## Build and start the containers

down: ## Stop the docker hub
	@$(DOCKER_COMP) down --remove-orphans

logs: ## Show live logs
	@$(DOCKER_COMP) logs --tail=0 --follow

## —— Tests 🛂 —————————————————————————————————————————————————————————————————
phpunit.xml:
	@cp phpunit.xml.dist phpunit.xml

test: phpunit.xml ## Start tests with Pest, pass the parameter "c=" to add options to phpunit, example: make test c="--group e2e --stop-on-failure"
	@$(eval c ?=)
	@$(DOCKER_COMP) run --rm -e APP_ENV=test php ./vendor/bin/pest --testsuite test $(c)

testio:  phpunit.xml## Start tests with Pest, pass the parameter "c=" to add options to phpunit, example: make test c="--group e2e --stop-on-failure"
	@$(eval c ?=)
	@$(DOCKER_COMP) run --rm -e APP_ENV=test_io php ./vendor/bin/pest --testsuite test_io $(c)

## —— Utils 🔧 —————————————————————————————————————————————————————————————————
cs: ## Run PHP CS Fixer
	@$(PHP) ./vendor/bin/php-cs-fixer fix ./src

database: ## Create the database
	@$(SYMFONY) doctrine:database:create
	@$(SYMFONY) doctrine:schema:create

database-update: ## Update the database schema
	@$(SYMFONY) doctrine:schema:update --force

## —— Composer 🧙 ——————————————————————————————————————————————————————————————
composer: ## Run composer, pass the parameter "c=" to run a given command, example: make composer c='req symfony/orm-pack'
	@$(eval c ?=)
	@$(COMPOSER) $(c)

vendor: ## Install vendors according to the current composer.lock file
vendor: c=install --prefer-dist --no-dev --no-progress --no-scripts --no-interaction
vendor: composer

## —— Symfony 🎵 ———————————————————————————————————————————————————————————————
sf: ## List all Symfony commands or pass the parameter "c=" to run a given command, example: make sf c=about
	@$(eval c ?=)
	@$(SYMFONY) $(c)

cc: c=c:c ## Clear the cache
cc: sf
