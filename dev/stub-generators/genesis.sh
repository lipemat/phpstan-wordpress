#!/usr/bin/env bash
#
# Generate Genesis stubs from the source directory.
#
# @note Must copy/paste genesis directory under source before running.
#       DO not include in GIT as is a premium theme!
#
# Used via `%rootDir%/../../../stubs/genesis/genesis-2.10.php` under `scanFiles`.

THEME_VERSION="3.5"

if [[ ! $(php -v | grep "PHP 7.4") ]]; then
    echo "Must be run via PHP 7.4 or will be missing 1/3 of classes."
    exit 1
fi

dev/source/vendor/bin/generate-stubs \
    --force \
    --header="//Stubs generated by \`../stub-generators/genesis.sh\`." \
    --functions \
    --classes \
    --interfaces \
    --traits \
    --out=stubs/genesis/genesis-${THEME_VERSION}.php \
    ./dev/source/genesis
