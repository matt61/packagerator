#!/usr/bin/env bash
vendor/bin/propel build --output-dir src/model
vendor/bin/propel config:convert --output-dir config
vendor/bin/propel sql:build --output-dir sql --overwrite
vendor/bin/propel sql:insert --sql-dir sql