#!/usr/bin/env bash

./bin/console doctrine:migrations:migrate -n
./bin/console ckeditor:install -n
./bin/console assets:install public

npm install
npm run build
