#!/bin/bash
set -e

# Build your application
echo "Building application..."
# Add your build commands here, for example:
# npm run build

# Deploy to Fly.io
echo "Deploying to Fly.io..."
flyctl deploy
