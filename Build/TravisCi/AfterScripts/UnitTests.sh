#!/usr/bin/env bash

#
# Safe way of propagating the exit code of all commands through the script.
# Without this line, commands could fail/exit 1 and the script itself would
# complete and exit with code 0.
#
set -e

#
# This file serves as the after_script for the TravisCI `UnitTests` TEST_SUITE environment.
# The script will be executed in the package working directory.
#

# Publish the code coverage to codeclimate.com once the tests have passed.
if [ -n "$CODECLIMATE_REPO_TOKEN" ]; then
    npm install -g codeclimate-test-reporter
    mv Coverage/**/lcov.info .
    codeclimate-test-reporter < lcov.info
fi
