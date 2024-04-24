clear:
	php bin/console cache:clear

diff:
	php bin/console doctrine:migrations:diff

migrate:
	php bin/console doctrine:migrations:migrate