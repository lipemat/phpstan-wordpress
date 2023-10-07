#!/bin/bash

#######################################################################################
#
# Create symbolic links to scripts in ./../git-hooks which are run on git events.
#
# @version 1.2.0
#
# @notice For this to work on windows you must add "Everyone" to the following policy
#         gpedit.ext -> Computer Configuration -> Windows Settings -> Local Policies -> User Rights Assignment -> Create symbolic links
#         You must then reboot the system
# @notice If the symbolic links still don't work on windows:
#          1. Re-install git bash with "Enable symbolic links" checkbox checked.
#          2. Add "symlinks = true" under "[core]" in `.gitconfig`
#
#####################################################################################

GREEN="$(tput setaf 2)"
WHITE="$(tput setaf 7)"
YELLOW="$(tput setaf 3)"
RESET_COLOR="$(tput sgr0)"

PROJECT=$(php -r "echo dirname(realpath('$0'), 3);")

## Fix windows paths
PROJECT=${PROJECT//\\//}

HOOKS=(
    pre-commit
)

# Cross platform symlink creation function
# @since 2019-03-22
link() {
    ## Clear out old ones
    rm -f "$1"
    ## Create new ones
    if [[ "msys" == "$OSTYPE" ]]; then
        cmd <<<"mklink \"${1//\//\\}\" \"${2//\//\\}\"" >/dev/null
    else
        ln -sf "$2" "$1"
    fi
}

for hook in "${HOOKS[@]}"; do
    link "${PROJECT}/.git/hooks/${hook#*/}" "${PROJECT}/dev/git-hooks/${hook}"
    echo "${YELLOW}[npm-post-install]${GREEN} ${hook} Git hook has been symbolic linked.${WHITE}"
done

echo "${RESET_COLOR}"

exit 0
