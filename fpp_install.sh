#!/bin/bash
pushd $(dirname $(which $0))
target_PWD=$(readlink -f .)
/opt/fpp/scripts/update_plugin ${target_PWD##*/}
echo ; echo “Please restart fppd for new FPP Commands to be visible.” ; echo
. /opt/fpp/scripts/common
setSetting restartFlag 1
popd
