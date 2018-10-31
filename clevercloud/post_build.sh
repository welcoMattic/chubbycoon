#!/usr/bin/env bash

npm install
npm run build

./bin/console doc:mig:mig -n
