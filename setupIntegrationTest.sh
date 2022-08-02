#!/bin/bash

docker exec -i klaxoon_php sh -c 'php bin/console --env=test doctrine:database:create'
docker exec -i klaxoon_php sh -c 'php bin/console --env=test doctrine:schema:create'