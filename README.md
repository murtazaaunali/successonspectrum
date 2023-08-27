# PROJECT README

## Technical Requirements
- nginx (Recommended) or Apache
- PHP >= 7.1.3
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- BCMath PHP Extension
- Composer
- NodeJS >= 10.15
---
## Important Information
- Only write SASS instead of Plain CSS in `resources/sass`
- Only write JS code in `resources/js`
- Compile CSS/JS assets using `yarn dev` (Local or Staging) or `yarn prod` (Production)
---
## Deployments
### Project Setup (Local Environment)
- Clone Project Repository in your Coding working directory
    * `git clone git@bitbucket.org:accunityllc/nd-sos-application.git`
- Install PHP & Node Dependencies
    * `composer install`
    * `yarn install`
- Compile the CSS & JS assets
    * `yarn dev`
- Create the `.env` file from `.env.example`
    * `cp .env.example .env`
- Change the value of `SOS_APP_ENV` in `.env` file to `local`
- Generate the Application Encryption Key
    * `php artisan key:generate`
- Link the Storage Directory
    * `php artisan storage:link`
- Create the `sos` database in Local MySQL Server (Check Collation in `config/database.php`) and run the initial migrations & seeders
    * `php artisan migrate --seed`
---
### Project Setup (Staging Environment)
- Clone Project Repository in your Coding working directory
    * `git clone git@bitbucket.org:accunityllc/nd-sos-application.git`
- Install PHP & Node Dependencies
    * `composer install --no-dev`
    * `yarn install`
- Compile the CSS & JS assets
    * `yarn dev`
- Create the `.env` file from `.env.example`
    * `cp .env.example .env`
- Change the value of `SOS_APP_ENV` in `.env` file to `staging`
- Generate the Application Encryption Key
    * `php artisan key:generate`
- Link the Storage Directory
    * `php artisan storage:link`
- Create the `sos` database in Local MySQL Server (Check Collation in `config/database.php`) and run the initial migrations & seeders
    * `php artisan migrate --seed`
- Create a `robots.txt` in `public` directory with the following content
    * `User-agent: *`
    * `Disallow: /`
---
### Project Setup (Production Environment)
- Clone Project Repository in your Coding working directory
    * `git clone git@bitbucket.org:accunityllc/nd-sos-application.git`
- Install PHP & Node Dependencies
    * `composer install --no-dev`
    * `yarn install`
- Compile the CSS & JS assets
    * `yarn prod`
- Create the `.env` file from `.env.example`
    * `cp .env.example .env`
- Change the value of `SOS_APP_ENV` in `.env` file to `production`
- Generate the Application Encryption Key
    * `php artisan key:generate`
- Link the Storage Directory
    * `php artisan storage:link`
- Create the `sos` database in Local MySQL Server (Check Collation in `config/database.php`) and run the initial migrations & seeders
    * `php artisan migrate --seed`
