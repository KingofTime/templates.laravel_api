restart:
	./vendor/bin/sail down
	./vendor/bin/sail up -d

install:
	sudo chmod -R 777 .
	./scripts/vendoring.sh
	cp .env.example .env
	./vendor/bin/sail up -d

scan:
	./vendor/bin/phpstan analyse

scan.generate_baseline:
	./vendor/bin/phpstan analyse --generate-baseline phpstan-baseline.php

project.prepare:
	./vendor/bin/sail artisan project:prepare

project.clear:
	./vendor/bin/sail artisan project:clear

project.cache:
	./vendor/bin/sail artisan project:cache

lint:
	./vendor/bin/pint --preset laravel

test:
	./vendor/bin/sail artisan test --parallel --recreate-databases

prune:
	docker-compose down --rmi all -v --remove-orphans

db.migrate:
	./vendor/bin/sail artisan migrate
