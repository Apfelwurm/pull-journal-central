# detect compose version
ifeq ($(OS),Windows_NT)
  DOCKER_COMPOSE=docker compose
else
ifneq ($(shell docker compose version 2>/dev/null),)
  DOCKER_COMPOSE=docker compose
else
  DOCKER_COMPOSE=docker-compose
endif
endif

# pull up dev environment from scratch
dev: env-file-dev composer-install npm-install use-dev-file cache-clear permissions key-generate sail-up-deattached npm-run-dev-deattached wait-mysql db-regenerate

#pull up prd environment from scratch (please use make env-file-prd and edit your .env file, then run this!)
prd-locl: composer-install npm-install use-prd-locl-file key-generate prd-up-locl

#pull up prd environment from scratch (please use make env-file-prd and edit your .env file, then run this!)
prd: use-prd-file key-generate prd-up

# Make .env
env-file-dev:
	cp .env.dev.example .env

# Make .env
env-file-prd:
	cp .env.prd.example .env

# Install PHP Dependencies via Composer usage make composer-command command="insert command"
composer-command:
	docker run --rm --name compose-maintainence --interactive \
    --volume $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/app \
    --user $(shell id -u):$(shell id -g) \
    composer $(command)

# Install PHP Dependencies via Composer
composer-install:
	docker run --rm --name compose-maintainence --interactive \
    --volume $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/app \
    --user $(shell id -u):$(shell id -g) \
    composer install --ignore-platform-reqs --no-scripts

# require PHP Dependencies via Composer usage make composer-require module=modulename
composer-require:
	docker run --rm --name compose-maintainence --interactive \
    --volume $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/app \
    --user $(shell id -u):$(shell id -g) composer require $(module) --ignore-platform-reqs --no-scripts

# remove PHP Dependencies via Composer usage make composer-remove module=modulename
composer-remove:
	docker run --rm --name compose-maintainence --interactive \
    --volume $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/app \
    --user $(shell id -u):$(shell id -g) composer remove $(module)

# check for outdated PHP Dependencies via Composer
composer-outdated:
	docker run --rm --name compose-maintainence --interactive \
    --volume $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/app \
    --user $(shell id -u):$(shell id -g) composer outdated

# check for outdated PHP Dependencies via Composer
composer-update:
	docker run --rm --name compose-maintainence --interactive \
    --volume $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/app \
    --user $(shell id -u):$(shell id -g) composer update --ignore-platform-reqs --no-scripts

# link dev no Proxy Compose file
use-dev-file:
	[ -f docker-compose.yml ] && rm -rf docker-compose.yml ; true
	docker run --rm --name devfile --interactive \
	-v $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/app \
    --user $(shell id -u):$(shell id -g) php:8-fpm-alpine /bin/sh -c "cd /app && php artisan sail:install --with mysql,redis,meilisearch,selenium"

# link prd no Proxy Compose file
use-prd-file:
	[ -f docker-compose.yml ] && rm -rf docker-compose.yml ; true
	ln -s docker-compose_prd.yml docker-compose.yml

# link prd locl no Proxy Compose file
use-prd-locl-file:
	[ -f docker-compose.yml ] && rm -rf docker-compose.yml ; true
	ln -s docker-compose_prd_locl.yml docker-compose.yml

# Permissions - docker Dev
permissions:
	chown -R 1000:1000 storage bootstrap/cache
	chown -R 1000:1000 .env
	chgrp -R 1000 storage bootstrap/cache
	chmod -R ug+rwx storage bootstrap/cache

# Permissions custom - usage make permissions-custom user=username group=groupname
permissions-custom:
	chown -R $(user):$(group) storage bootstrap/cache
	chgrp -R $(group) storage bootstrap/cache
	chmod -R ug+rwx storage bootstrap/cache

# clear cache
cache-clear:
	docker run --rm --name compkeygen --interactive \
	-v $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/app \
    --user $(shell id -u):$(shell id -g) php:8-fpm-alpine /bin/sh -c "cd /app && php artisan cache:clear && rm -rf bootstrap/cache/*.php"

#sail shell
sail-shell:
	$(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))/vendor/laravel/sail/bin/sail shell

#sail up
sail-up:
	$(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))/vendor/laravel/sail/bin/sail up

#sail down
sail-down:
	$(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))/vendor/laravel/sail/bin/sail down

#sail up deattached
sail-up-deattached:
	$(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))/vendor/laravel/sail/bin/sail up -d

#sail ps
sail-ps:
	$(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))/vendor/laravel/sail/bin/sail ps

#sail logs
sail-logs:
	$(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))/vendor/laravel/sail/bin/sail logs

#sail logs
sail-logs-follow:
	$(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))/vendor/laravel/sail/bin/sail logs -f

#sail command - usage make sail-command command="artisan migrate"
sail-command:
	$(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))/vendor/laravel/sail/bin/sail $(command)

#sail migrate
sail-migrate:
	$(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))/vendor/laravel/sail/bin/sail artisan migrate

#sail artisan test
test:
	$(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))/vendor/laravel/sail/bin/sail artisan test

#sail artisan test - usage make test-specific test="ExampleTest"
test-specific:
	$(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))/vendor/laravel/sail/bin/sail artisan test --filter $(test)

#sail artisan test coverage
test-coverage:
	$(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))/vendor/laravel/sail/bin/sail artisan test --coverage

#test coverage docker
test-coverage-docker:
	docker run --rm --name compkeygen --interactive \
	-e DB_CONNECTION="sqlite" -e DB_DATABASE="db/database.sqlite" \
	-v $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/app \
    --user $(shell id -u):$(shell id -g) jitesoft/phpunit:latest /bin/sh -c "cd /app && mkdir -p db && touch db/database.sqlite && php artisan test --coverage; rm -rf db"

prd-up-locl:
	$(DOCKER_COMPOSE) up -d --build

prd-up:
	$(DOCKER_COMPOSE) up -d

# Install JS Dependencies via NPM "make npm-install module=modulename" or  "make npm-install"
npm-install:
	docker run --rm --name js-maintainence --interactive \
	-v $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/usr/src/app \
	-w /usr/src/app \
	node:latest /bin/bash -ci "npm install $(module) --no-audit"

npm-run-prd:
	docker run --rm --name js-run-prd --interactive \
	--network host \
	-v $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/usr/src/app \
	-w /usr/src/app \
	node:latest /bin/bash -ci "npm run production"

npm-stop-prd:
	docker stop js-run-prd || true

npm-run-prd-deattached:
	docker run --rm -d --name js-run-prd --interactive \
	--network host \
	-v $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/usr/src/app \
	-w /usr/src/app \
	node:latest /bin/bash -ci "npm run production"

npm-run-dev:
	docker run --rm --name js-run-dev --interactive \
	--network host \
	-v $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/usr/src/app \
	-w /usr/src/app \
	node:latest /bin/bash -ci "npm run dev"

npm-stop-dev:
	docker stop js-run-dev || true

npm-run-dev-deattached:
	docker run --rm -d --name js-run-dev --interactive \
	--network host \
	-v $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/usr/src/app \
	-w /usr/src/app \
	node:latest /bin/bash -ci "npm run dev"

# List outdated npm dependencies
npm-outdated:
	docker run --rm --name js-maintainence-dev --interactive \
	-v $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/usr/src/app \
	-w /usr/src/app \
	node:latest /bin/bash -ci "npm outdated"

# update outdated npm dependencies usage either  "make npm-update module=modulename" or "make npm-update"
npm-update:
	docker run --rm --name js-maintainence-dev --interactive \
	-v $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/usr/src/app \
	-w /usr/src/app \
	node:latest /bin/bash -ci "npm update $(module)"

# update outdated npm dependencies and save usage either  "make npm-update module=modulename" or "make npm-update"
npm-update-save:
	docker run --rm --name js-maintainence-dev --interactive \
	-v $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/usr/src/app \
	-w /usr/src/app \
	node:latest /bin/bash -ci "npm update $(module) --save"

# rollback all migrations (DELETES EVERYTHING!!!) and migrating and seeding database
db-regenerate:
	./vendor/laravel/sail/bin/sail artisan migrate:reset \
    && ./vendor/laravel/sail/bin/sail artisan migrate \
    && ./vendor/laravel/sail/bin/sail artisan db:seed


# execute mysql command usage make database-command command=sqlcommandhere
db-command:
	echo "use pull-journal-central; $(command)" | $(DOCKER_COMPOSE) exec -T mysql mysql -u pull-journal-centraluser -p'password'

# Purge Containers
purge-containers: npm-stop-dev npm-stop-prd
	$(DOCKER_COMPOSE) down || true
	$(DOCKER_COMPOSE) rm || true
	docker volume rm pull-journal-central_sail-meilisearch || true
	docker volume rm pull-journal-central_sail-mysql || true
	docker volume rm pull-journal-central_sail-redis || true

# Purge Caches
purge-cache:
	docker run --rm --name purgecache --interactive \
	-v $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/src \
    $(user) php:8-fpm-alpine /bin/sh -c " \
	rm -rf /src/storage/framework/cache/* && \
	rm -rf /src/storage/framework/views/* && \
	rm -rf /src/storage/framework/sessions/* && \
	rm -rf /src/bootstrap/cache/* && \
	rm -rf /src/storage/debugbar/* "

# Purge Files
purge-files:
	docker run --rm --name purgefiles --interactive \
	-v $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/src \
    $(user) php:8-fpm-alpine /bin/sh -c " \
	rm -rf /src/vendor/ ; \
	rm -rf /src/node_modules/ ; \
	rm -rf /src/public/css/* ; \
	rm -rf /src/storage/logs/* ; \
	rm -rf /src/public/storage || true"


###############
# DANGER ZONE #
###############
# Clean ALL! DANGEROUS!
purge-all:
	echo 'This is dangerous!'
	echo 'This will totally remove all data and information stored in your app!'
	@echo -n "Are you sure? [y/N] " && read ans && [ $${ans:-N} = y ]
	make purge-all-force

purge-all-force: purge-containers purge-cache purge-files


show-laravellog-prd:
	$(DOCKER_COMPOSE) exec -T pull-journal-central /bin/sh -c "cat storage/logs/laravel.log"

follow-laravellog-prd:
	$(DOCKER_COMPOSE) exec -T pull-journal-central /bin/sh -c "tail -f storage/logs/laravel.log"

#generate  key:
key-generate:
	docker run --rm --name compkeygen --interactive \
	-v $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/app \
    --user $(shell id -u):$(shell id -g) php:8-fpm-alpine /bin/sh -c "cd /app && php artisan key:generate"

get-wait:
ifneq ("$(wildcard $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))/docker/resources/wait)","")
	echo "wait exists"
else
	docker run --rm --name mysqlwaiter --interactive --network="pull-journal-central_sail" \
	-v $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/usr/src/app \
	$(user) php:8-fpm-alpine /bin/sh -c " \
	wget -O /usr/src/app/docker/resources/wait https://github.com/ufoscout/docker-compose-wait/releases/latest/download/wait && \
	chmod +x /usr/src/app/docker/resources/wait"
endif

# Wait for mysql to initialize
wait-mysql: get-wait
	docker run --rm --name mysqlwaiter --interactive --network="pull-journal-central_sail" \
	-e WAIT_HOSTS="pull-journal-central-mysql-1:3306" \
	-v $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/usr/src/app \
	$(user) php:8-fpm-alpine /bin/sh -c " \
	/usr/src/app/docker/resources/wait &&\
	sleep 45"


# Build docs container
docs-build:
	docker pull sphinxdoc/sphinx:latest
	docker build -t pull-journal-central_docs docs
# Make Documentation
docs-html:
	docker run --rm -v $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))/docs:/docs pull-journal-central_docs make html
