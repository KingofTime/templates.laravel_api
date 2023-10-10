install:
	sudo chmod -R 777 .
	./scripts/vendoring.sh
	cp .env.example .env
	vendor/bin/sail up -d

prune:
	docker-compose down --rmi all -v --remove-orphans
