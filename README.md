# Geldsack

## How to build

### Prerequisites
- PHP 8.3+
- Composer
- npm

### Steps
1. Clone repo
2. Copy `.env.example` to `.env` and adjust database settings
3. Install composer dependencies `composer install`
4. Install npm dependencies `npm install`
5. Run migrations `php artisan migrate`
6. Run dev server `composer run dev`
