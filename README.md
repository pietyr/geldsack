# Geldsack

## How to build

### Prerequisites
- PHP 8.3+
- Composer
- npm

### Steps
1. Clone repo
2. Copy `.env.example` to `.env` and adjust database settings
3. Generate key `php artisan key:generate`
4. Install composer dependencies `composer install`
5. Install npm dependencies `npm install`
6. Run migrations `php artisan migrate`
7. Run dev server `composer run dev`
