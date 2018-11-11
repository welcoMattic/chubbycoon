db:
	./bin/console doctrine:database:drop --force --if-exists
	./bin/console doctrine:database:create --if-not-exists
	./bin/console doctrine:migrations:migrate -n
	./bin/console doctrine:fixtures:load -n
