# Setup

## Requirements

### Laravel 11.x

#### `PHP >= 8.2`

#### Enabled PHP Extensions:
* Ctype PHP Extension (enabled by default: https://www.php.net/manual/en/ctype.installation.php)
* cURL PHP Extension (`extension=curl`: https://www.php.net/manual/en/curl.installation.php)
* DOM PHP Extension (enabled by default: https://www.php.net/manual/en/dom.installation.php)
* Fileinfo PHP Extension (`extension=fileinfo` suppousedly enabled by default: https://www.php.net/manual/en/fileinfo.installation.php)
* Filter PHP (enabled by default: https://www.php.net/manual/en/filter.installation.php)
* Hash PHP Extension (core PHP extension, always enabled: https://www.php.net/manual/en/hash.installation.php)
* Mbstring PHP Extension (enable on php install: https://www.php.net/manual/en/mbstring.installation.php)
* OpenSSL PHP Extension (enable on php install: https://www.php.net/manual/en/openssl.installation.php)
* PCRE PHP Extension (core PHP extension, always enabled: https://www.php.net/manual/en/pcre.installation.php)
* PDO PHP Extension (configure on php install: https://www.php.net/manual/en/pdo.installation.php)
* Session PHP Extension (enabled by default: https://www.php.net/manual/en/session.installation.php)
* Tokenizer PHP Extension (enabled by default: https://www.php.net/manual/en/tokenizer.installation.php)
* XML PHP Extension (enabled by default: https://www.php.net/manual/en/xml.installation.php)

enable `curl` & `fileinfo` PHP extensions in `php.ini` file
```
extension=curl
extension=fileinfo
```
source: https://laravel.com/docs/11.x/deployment#server-requirements

## Generate environment variables file:
Copy and customize repository `.env.example` as `.env`.

## Install composer dependencies
```
composer install
```

## Generate App key:
```
php artisan key:generate
```
Adds generated key to `.env` file.

## Run migrations
```
php artisan migrate
```

## Run seeders
```
php artisan db:seed
```
Seeds user with the `.env` (`USER_*`) data

# Application
## routes
- `GET` `/` (sanctum authenticated)
- `POST` `/auth/login` `{ "email": "user@conwork.io", "password": "password" }`
- `GET` `/auth/logout` (sanctum authenticated)

# Tasks
## 1. Create `Article` migration & model
Props:
- `title: string (255)`
- `article: text`

Relations:
- `Article->author()`
- `User->articles()`

## 2. Create `Article` routes (sanctum authenticated)
`Article` input validation:
- `title`: required && max-length: 255
- `article`: required

Routes:  
- List articles:  
`GET` `/articles`
- Create article (author is the authenticated-request-user):  
`POST` `/articles`
- Show article:  
`GET` `/articles/{article}`
- Update article (optional: authorize only if author is the authenticated-request-user):  
`PUT | PATCH` `/articles/{article}`
- Delete article (optional: authorize only if author is the authenticated-request-user):  
`DELETE /articles/{article}`

## 3. Create `UserPreferences` middleware and apply to sanctum auth routes
Get preferences from authenticated request user (`$user->preferences`), check for `locale` preference and change app lang / locale correspondingly.

`config('app.available_locales')` contains the application available languages: `['en', 'es']`

Prepared translations for `Article` routes responses can be found under:
- `/lang/en/article.php | /lang/es/article.php`:
    - `article.index.success`
    - `article.store.success`
    - `article.show.success`
    - `article.update.success`
    - `article.delete.success`

## 4. Create `app:revoke-all-user-tokens {--user_id=}` command
Delete all `User` personal access tokens for the given `--user_id`.
