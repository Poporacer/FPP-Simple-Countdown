#!/bin/bash
pushd $(dirname $(which $0))
target_PWD=$(readlink -f .)
echo ; echo “Please restart fppd for new FPP Commands to be visible.” ; echo
setSetting restartFlag 1
popd
