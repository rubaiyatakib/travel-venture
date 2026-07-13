#!/bin/bash
# One-click deployment script

echo "=========================================="
echo "  Deploying Travel Venture Theme Updates  "
echo "=========================================="

# 1. Package the theme using python (optional, matches zip_theme.py workflow)
if [ -f "../zip_theme.py" ]; then
    echo "Packaging theme to ZIP..."
    python ../zip_theme.py
fi

# 2. Git Commit and Push
echo "Adding changes to Git..."
git add .

# Default commit message if not provided
commit_msg="feat: Add Google Maps hotel sync importer and CLI script"
read -p "Enter commit message [$commit_msg]: " input_msg
if [ ! -z "$input_msg" ]; then
    commit_msg="$input_msg"
fi

echo "Committing changes..."
git commit -m "$commit_msg"

echo "Pushing updates to GitHub..."
git push origin main

echo "=========================================="
echo "  Deploy completed! Checked and updated.  "
echo "=========================================="
