#!/bin/sh
./vendor/bin/phpunit -d memory_limit=512M \
 --configuration ./phpunit.xml \
 --no-coverage \
 --log-junit=build/phpunit/phpunit_log.xml