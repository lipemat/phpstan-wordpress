#!/bin/bash
set -e

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"

echo "Setting up Project..."

echo "→ Installing composer dependencies..."
(
  cd "${ROOT_DIR}"
  composer install --no-interaction
)

echo ""
echo "✓ Setup complete!"
