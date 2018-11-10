#!/usr/bin/env bash

./bin/console doctrine:migrations:migrate -n
./bin/console ckeditor:install -n

npm install
npm run build
