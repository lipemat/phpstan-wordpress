#!/usr/bin/env bash
#
# Generate CMB2 stubs from the vendor directory.
#
# Used via `%rootDir%/../../../stubs/cmb2-2.7.0.php` under `scanFiles`.

PLUGIN_VERSION="2.7.0"

vendor/bin/generate-stubs \
--force \
--header="//Stubs generated by \`../stub-generators/cmb2.sh\`." \
--functions \
--classes \
--interfaces \
--traits \
--out=stubs/cmb2-${PLUGIN_VERSION}.php \
./vendor/lipemat/cmb2/includes/
