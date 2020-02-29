#!/bin/sh

rm -rf vendor/orchestra/testbench-dusk
composer install --no-interaction --no-suggest
php vendor/orchestra/testbench-dusk/create-sqlite-db
vendor/bin/dusk-updater detect update -q -y

vendor/bin/phpunit tests/Unit
vendor/bin/phpunit tests/Feature
# vendor/bin/phpunit tests/Browser