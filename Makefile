DOCKER ?= docker
DOCKER_COMPOSE ?= docker-compose
RUN_PHP ?= $(DOCKER_COMPOSE) run --rm --no-deps app
EXECUTE_APP ?= $(DOCKER_COMPOSE) exec app

all: up composer-install db-create ps

envfile: ## [Install] Creates .env file
	envsubst < .env.dist > .env
.PHONY: envfile

test: ## [App] Run tests
	$(RUN_PHP) bin/phpunit
.PHONY: test

# Composer
composer-install: ## [Composer] Install composer dependencies
	$(RUN_PHP) composer install
.PHONY: composer-install

composer-update: ## [Composer] Update composer dependencies
	$(RUN_PHP) composer update $(package)
.PHONY: composer-update

composer-update-lock: ## [Composer] Update composer lock file
	$(RUN_PHP) composer update --lock
.PHONY: composer-update-lock

composer-show: ## [Composer] Show installed composer packages
	$(RUN_PHP) composer show
.PHONY: composer-show

# Database
db-create: ## [Database] Creates the configured database
	$(RUN_PHP) bin/console doctrine:database:create --if-not-exists
	$(RUN_PHP) bin/console doctrine:schema:create
.PHONY: db-create

db-drop: ## [Database] Drops the configured database
	$(RUN_PHP) bin/console doctrine:database:drop --force --if-exists
.PHONY: db-drop

db-schema: ## [Database] Creates schema
	$(RUN_PHP) bin/console doctrine:schema:create
.PHONY: db-schema

db-update: ## [Database] Updates schema
	$(RUN_PHP) bin/console doctrine:schema:update --force
.PHONY: db-update

# Docker
up: ## [Docker] Builds, (re)creates, and start docker containers in detached mode
	$(DOCKER_COMPOSE) up --remove-orphans -d
.PHONY: up

down: ## [Docker] Stop containers and remove containers, networks, volumes, and images created by "up"
	$(DOCKER_COMPOSE) down --remove-orphans
.PHONY: down

restart: down up ## [Docker] Restart docker containers
.PHONY: restart

clean: ## [Docker] Stop and remove containers
	$(DOCKER_COMPOSE) rm --force --stop
.PHONY: clean

ps: ## [Docker] List containers
	$(DOCKER_COMPOSE) ps
.PHONY: ps

logs: ## [Docker] Print logs from containers
	$(DOCKER_COMPOSE) logs -f
.PHONY: logs

ssh: ## [Docker] SSH into container
	@$(EXECUTE_APP) bash
.PHONY: ssh

help: ## Display this help message
	@cat $(MAKEFILE_LIST) | grep -e "^[a-zA-Z_\-]*: *.*## *" | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'