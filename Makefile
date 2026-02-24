# TaskFlow — Makefile for local development with Laravel Sail
# Usage: make [target]
# Example: make init && make artisan cmd="report:tasks"

# Use ./vendor/bin/sail if SAIL is not set (e.g. in PATH)
SAIL ?= ./vendor/bin/sail

.PHONY: up down init artisan reset sail-install

# Start containers (Sail in background)
up:
	$(SAIL) up -d

# Stop containers
down:
	$(SAIL) down

# Install dependencies, copy .env, start Sail, run migrations & seeders.
# Run once after clone. Ensures docker-compose exists via sail:install if missing.
# Sail default stack includes mysql + mailpit (for capturing mail). For Mailhog, add it to docker-compose manually.
init:
	composer install
	@if [ ! -f .env ]; then cp .env.example .env; echo "Created .env from .env.example"; fi
	@if [ ! -f docker-compose.yml ]; then php artisan sail:install --no-interaction; fi
	$(SAIL) up -d
	@echo "Waiting for MySQL..."
	@sleep 5
	$(SAIL) artisan key:generate --no-interaction 2>/dev/null || true
	$(SAIL) artisan migrate --force
	$(SAIL) artisan db:seed --force
	@echo "Done. App: http://localhost  Mail (Mailpit): http://localhost:8025"

# Run an Artisan command. Example: make artisan cmd="report:tasks"
artisan:
	$(SAIL) artisan $(cmd)

# Rebuild and reinitialize: tear down with volumes, start fresh, migrate & seed
reset:
	$(SAIL) down -v
	$(SAIL) up -d
	@echo "Waiting for MySQL..."
	@sleep 5
	$(SAIL) artisan migrate:fresh --seed --force
	@echo "Reset complete. App: http://localhost  Mail (Mailpit): http://localhost:8025"

# One-time: publish Sail docker-compose (optional; init does this if missing)
sail-install:
	php artisan sail:install --no-interaction
