#!/usr/bin/env bash

echo ""
echo ">>> POST BUILD SCRIPT"
echo ""

./bin/console doctrine:migrations:migrate -n
./bin/console ckeditor:install -n --no-progress-bar
./bin/console assets:install public

npm install
npm run build
