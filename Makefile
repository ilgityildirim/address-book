build:
	docker-compose build

up:
	docker-compose up -d

stop:
	docker-compose stop

down:
	docker-compose down

start: build up

restart: down up

create_database:
	docker-compose run --rm php bin/console doctrine:database:create && docker-compose run --rm php bin/console doctrine:schema:create

assets:
	docker-compose run --rm php bin/console assets:install public --symlink --relative

composer_install:
	docker-compose run --rm composer install

init: start composer_install create_database assets

fix_permissions:
	echo "Changing orwnership of project files to current user, require sudo"
	sudo chown $(USER):$(USER) . -R
