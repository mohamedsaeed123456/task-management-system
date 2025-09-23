#!/bin/bash

# Task Management System - Setup Script
# This script sets up the Laravel application with Sail

echo "🚀 Setting up Task Management System..."

# Check if .env exists, if not copy from .env.example
if [ ! -f .env ]; then
    echo "📝 Creating .env file..."
    cp .env.example .env
else
    echo "✅ .env file already exists"
fi

# Install Composer dependencies
echo "📦 Installing Composer dependencies..."
composer install

# Generate application key
echo "🔑 Generating application key..."
php artisan key:generate

# Start Sail containers
echo "🐳 Starting Laravel Sail containers..."
./vendor/bin/sail up -d

# Wait for database to be ready
echo "⏳ Waiting for database to be ready..."
sleep 10

# Run migrations
echo "🗄️ Running database migrations..."
./vendor/bin/sail artisan migrate --force

# Run seeders
echo "🌱 Running database seeders..."
./vendor/bin/sail artisan db:seed --force

echo "✅ Setup complete!"
echo ""
echo "🌐 Access your application:"
echo "   Web App: http://localhost"
echo "   API: http://localhost/api"
echo ""
echo "🔐 Default users:"
echo "   Manager: manager@example.com / password"
echo "   User: user@example.com / password"
echo ""
echo "📚 Available Sail commands:"
echo "   ./vendor/bin/sail up -d     # Start containers"
echo "   ./vendor/bin/sail down     # Stop containers"
echo "   ./vendor/bin/sail artisan   # Run artisan commands"
echo "   ./vendor/bin/sail test     # Run tests"
