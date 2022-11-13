#!/bin/sh
./vendor/bin/phpunit -d memory_limit=512M \
--configuration ./phpunit.xml \
--log-junit=build/phpunit/phpunit_log.xml \
--coverage-clover=build/phpunit/coverage-clover.xml \
--coverage-html=build/phpunit/coverage-web