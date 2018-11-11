#!/usr/bin/env bash

echo ""
echo ">>> POST BUILD SCRIPT"
echo ""

./bin/console doctrine:database:drop --force --if-exists
./bin/console doctrine:database:create --if-not-exists
./bin/console doctrine:migrations:migrate -n
./bin/console doctrine:fixtures:load -n
./bin/console ckeditor:install -n --no-progress-bar
./bin/console assets:install public

npm install
npm run build
