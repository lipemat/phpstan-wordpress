#!/bin/bash
#
# Generate WooCommerce Subscriptions stubs from the source directory.
#
# @note Must copy/paste woocommerce-subscriptions directory under source before running.
#       DO not include in GIT as is a premium plugin!
#
# @example `bash dev/stub-generators/woocommerce-subscriptions.sh`
#
# 1. Copy the generated file to your local project.
# 2. Add `dev/stubs/woocommerce-subscriptions-<PLUGIN_VERSION>.php` to `scanFiles` in `phpstan.neon`.
#
PLUGIN_VERSION="6.5"

## @todo Switch to finder for exclude. See `generate-stubs --finder`.
Get_legacy_files() {
    # Already in WC
    echo "dev/source/woocommerce-subscriptions/woo-includes"
    # Legacy
    echo "dev/source/woocommerce-subscriptions/includes/api/legacy"

    echo "dev/source/woocommerce-subscriptions/vendor/woocommerce/subscriptions-core/includes/legacy"
}

# Delete class files
Get_legacy_files | xargs -- rm -v -r

dev/source/vendor/bin/generate-stubs \
    --force \
    --header="//Stubs generated by \`../stub-generators/woocommerce-subscriptions.sh\`." \
    --functions \
    --classes \
    --interfaces \
    --traits \
    --out=stubs/woocommerce-subscriptions/woocommerce-subscriptions-${PLUGIN_VERSION}.php \
    ./dev/source/woocommerce-subscriptions
