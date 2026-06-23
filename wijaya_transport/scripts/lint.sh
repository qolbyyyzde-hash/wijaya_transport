#!/usr/bin/env bash
set -euo pipefail

echo "Running PHP lint across project..."
find . -name '*.php' -not -path './vendor/*' -print0 | xargs -0 -n1 php -l

echo "Lint completed."
