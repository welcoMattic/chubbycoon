#!/usr/bin/env bash

mkdir -p public/build/css
mkdir -p public/build/js
mkdir -p public/build/images
mkdir -p public/build/fonts

# temp build fix
/usr/bin/composer.phar install --prefer-dist
rm composer.json
