#!/usr/bin/env bash

./bin/console doctrine:migrations:migrate -n

npm install
npm run build
