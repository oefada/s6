BORG_CREATE_BUNDLE ?= 0

DOCKER_COMPOSE_PROJECT_SUFFIX ?= default
DOCKER_COMPOSE_PROJECT = society6_$(DOCKER_COMPOSE_PROJECT_SUFFIX)
DOCKER_COMPOSE_SHARED_FLAGS = -p $(DOCKER_COMPOSE_PROJECT)

UNAME := $(shell uname -s)

.PHONY: bundle

help:
	@printf "\e[48;5;22m%-40s\e[38;5;256m\e[1mSociety6 Backend Coding Exercise%-40s\e[0m\n"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "   \033[01m%-30s\033[0m %s\n", $$1, $$2}'

install: _add_hosts_entry _copy_env_file build_workspace composer_install _setup_mysql build migrate up  ## Sets up local environment, builds containers, runs composer install, migrates databases, and brings it online
	@echo "install complete!"

up: ## Starts containers in daemon mode
	@echo "Starting containers..."
	@cd docker && docker-compose $(DOCKER_COMPOSE_SHARED_FLAGS) up -d nginx php-worker workspace

down: ## Stops containers
	@echo "Stopping containers..."
	@cd docker && docker-compose $(DOCKER_COMPOSE_SHARED_FLAGS) down -v

logs: ## Follows log output from all containers
	@cd docker && docker-compose $(DOCKER_COMPOSE_SHARED_FLAGS) logs -f --tail="all"

stats: ## Running usage stats for each container
	@docker stats

console: _workspace_up ## Starts a console in the workspace container
	@cd docker && docker-compose $(DOCKER_COMPOSE_SHARED_FLAGS) exec workspace zsh

build:  ## Builds all Docker containers
	@cd docker && docker-compose $(DOCKER_COMPOSE_SHARED_FLAGS) build

build_workspace: ## Build only Docker workspace container
	@cd docker && docker-compose $(DOCKER_COMPOSE_SHARED_FLAGS) build workspace

test: _workspace_up ## Runs full test suite
	@cd docker && docker-compose $(DOCKER_COMPOSE_SHARED_FLAGS) exec workspace ./vendor/bin/phpunit

composer_install: _workspace_up ## Runs composer install
	@cd docker && docker-compose $(DOCKER_COMPOSE_SHARED_FLAGS) exec workspace composer install

migrate: _workspace_up ## Runs migrations
	@cd docker && docker-compose $(DOCKER_COMPOSE_SHARED_FLAGS) exec workspace php artisan migrate

test_coverage_report: _workspace_up ## Builds test coverage report
	@cd docker && docker-compose $(DOCKER_COMPOSE_SHARED_FLAGS) exec workspace ./vendor/bin/phpunit --dump-xdebug-filter tests/report/xdebug-filter.php
	@cd docker && docker-compose $(DOCKER_COMPOSE_SHARED_FLAGS) exec workspace ./vendor/bin/phpunit --prepend tests/report/xdebug-filter.php --coverage-html tests/report/coverage-report
	open ./tests/report/coverage-report/index.html

_copy_env_file:
	@test -f ".env" || cp .env.example .env

_add_hosts_entry:
ifeq ($(UNAME),$(filter $(UNAME),Darwin Linux))
	@grep -q society6.localhost /etc/hosts || (echo "Adding society6.localhost host entry to /etc/hosts..." && echo "\n127.0.0.1 society6.localhost" | sudo tee -a  /etc/hosts)
else
	echo "Please add following to your /etc/hosts or equivalent file\n   127.0.0.1 society6.localhost\n"
endif

_workspace_up:
	@cd docker && docker-compose $(DOCKER_COMPOSE_SHARED_FLAGS) up -d workspace

_setup_mysql: _workspace_up
	@cd docker && docker-compose $(DOCKER_COMPOSE_SHARED_FLAGS) up -d mysql
	@cd docker && docker-compose $(DOCKER_COMPOSE_SHARED_FLAGS) exec workspace wait-for-it.sh -t 0 mysql:3306
	@cd docker && docker-compose $(DOCKER_COMPOSE_SHARED_FLAGS) exec mysql mysql_upgrade -uroot -proot 2> /dev/null || echo "MySQL data up to date"
