#!/usr/bin/env bash
# Full first-time go-live for RepairCares (Hostinger).
set -euo pipefail

cd ~/domains/digitalcreatorss.com/repaircares

if [[ ! -d .git ]]; then
  git clone https://github.com/ramniks05/repaircares-laravel.git .
fi

if [[ ! -f .env ]]; then
  cp .env.hostinger.example .env
  echo "Edit .env (MySQL + APP_URL), then run this script again."
  exit 0
fi

bash deploy/hostinger/post-deploy.sh
