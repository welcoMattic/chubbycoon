#!/usr/bin/env bash

./bin/console doctrine:migrations:migrate -n
./bin/console ckeditor:install -n
./bin/console doctrine:fixtures:load -n

npm install
npm run build
