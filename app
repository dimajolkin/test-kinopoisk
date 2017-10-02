#!/bin/bash

if [[ $1 = "start" ]]
then
docker-compose up -d web
exit 1
fi

if [[ $1 = "stop" ]]
then
docker-compose stop web
exit 1
fi

if [[ $1 = "build" ]]
then
docker-compose build && docker-compose run web sh -c 'composer install && npm i && npm run build'
exit 1
fi

if [[ $1 = "migrate" ]]
then
docker-compose stop web
exit 1
fi
