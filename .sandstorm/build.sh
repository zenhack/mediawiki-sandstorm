#!/bin/bash

set -euo pipefail
cd /opt/app/localhost-proxy
CGO_ENABLED=0 go build
