#!/bin/bash
pushd $(dirname $(which $0))
echo ; echo “Please restart fppd for new FPP Commands to be visible.” ; echo
setSetting restartFlag 1
popd