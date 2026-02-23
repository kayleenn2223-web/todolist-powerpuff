#!/bin/bash
# TodoList PowerPuff - Quick Setup Script (for Linux/Mac)
# Windows users: Follow manual steps in SETUP_GUIDE.php

echo "📝 TodoList PowerPuff - Quick Setup"
echo "====================================="
echo ""

# Check if folder exists
if [ ! -d "data" ]; then
    echo "🔨 Creating data folder..."
    mkdir -p data
    chmod 755 data
    echo "✓ Data folder created"
else
    echo "✓ Data folder already exists"
fi

# Check if uploads folder exists
if [ ! -d "logs" ]; then
    echo "🔨 Creating logs folder..."
    mkdir -p logs
    chmod 755 logs
    echo "✓ Logs folder created"
else
    echo "✓ Logs folder already exists"
fi

# Create initial files
if [ ! -f "data/users.json" ]; then
    echo "🔨 Creating users database..."
    echo "[]" > data/users.json
    chmod 644 data/users.json
    echo "✓ Users database created"
else
    echo "✓ Users database already exists"
fi

echo ""
echo "✅ Setup complete!"
echo ""
echo "Next steps:"
echo "1. Open browser"
echo "2. Go to: http://localhost/todolist-powerpuff/"
echo "3. Run: SYSTEM_CHECK.php to verify setup"
echo "4. Click: 'Mulai Aplikasi (Login)'"
echo "5. Register a new account"
echo "6. Start managing your tasks!"
echo ""
echo "Need help? Open: SETUP_GUIDE.php"
echo ""
