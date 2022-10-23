init:
	docker-compose up -d
	docker exec -it a3f_php /bin/bash -c "composer install"
	docker exec -it a3f_php /bin/bash -c "vendor/bin/codecept build"

test:
	docker exec -it a3f_php /bin/bash -c "vendor/bin/codecept run"

parse:
	docker exec -it a3f_php /bin/bash -c "php bin/console.php parser"