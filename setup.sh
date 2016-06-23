#!/usr/bin/env bash
vendor/bin/propel build --output-dir src
vendor/bin/propel config:convert --output-dir config
vendor/bin/propel sql:build --output-dir sql
vendor/bin/propel sql:insert --sql-dir sql
#php -S localhost:8080 -c ../php.ini