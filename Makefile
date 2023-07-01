# pull up dev environment from scratch
dev: env-file-dev composer-install npm-install-dev use-dev-file cache-clear permissions key-generate sail-up-deattached db-regenerate

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
    --user $(shell id -u):$(shell id -g) php:8-fpm-alpine /bin/sh -c "cd /app && php artisan sail:install --with mysql,redis,meilisearch,mailhog,selenium"

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
	docker-compose up -d --build

prd-up:
	docker-compose up -d

# Install JS Dependencies via NPM
npm-install:
	docker run --rm --name js-maintainence --interactive \
	-v $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/usr/src/app \
	-w /usr/src/app \
	node:latest /bin/bash -ci "npm install --no-audit && npm run production"

# Install Dev JS Dependencies via NPM
npm-install-dev:
	docker run --rm --name js-maintainence-dev --interactive \
	-v $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/usr/src/app \
	-w /usr/src/app \
	node:latest /bin/bash -ci "npm install --no-audit && npm run dev"

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
	echo "use pull-journal-central; $(command)" | docker-compose exec -T mysql mysql -u pull-journal-centraluser -p'password'


show-laravellog-prd:
	docker-compose exec -T pull-journal-central /bin/sh -c "cat storage/logs/laravel.log"

follow-laravellog-prd:
	docker-compose exec -T pull-journal-central /bin/sh -c "tail -f storage/logs/laravel.log"

#generate  key:
key-generate:
	docker run --rm --name compkeygen --interactive \
	-v $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/app \
    --user $(shell id -u):$(shell id -g) php:8-fpm-alpine /bin/sh -c "cd /app && php artisan key:generate"

# Build docs container
docs-build:
	docker pull sphinxdoc/sphinx:latest
	docker build -t pull-journal-central_docs docs
# Make Documentation
docs-html:
	docker run --rm -v $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))/docs:/docs pull-journal-central_docs make html
