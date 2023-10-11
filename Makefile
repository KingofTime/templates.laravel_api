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

lint:
	./vendor/bin/pint --preset psr12

test:
	./vendor/bin/sail artisan test --parallel --recreate-databases

prune:
	docker-compose down --rmi all -v --remove-orphans

db.migrate:
	./vendor/bin/sail artisan migrate
