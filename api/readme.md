## Laravel API 

Laravel API starter Kit will provide you with the tools for making API's that everyone will love, API Authentication is already provided with passport. 

Here is a list of the packages installed:

- [Dingo API](https://github.com/dingo/api)
- [Laravel Passport](https://laravel.com/docs/5.4/passport)
- [Laravel Permission](https://github.com/spatie/laravel-permission)
- [Laravel Uuid](https://github.com/webpatser/laravel-uuid)

## Installation

Modify the .env file to suit your needs

```
APP_ENV=local
APP_DEBUG=true
APP_KEY=base64:JqyMTmt5qr1CW6BH+GG+4iKfU4RiNjZTLy33TdTT7+4=

API_STANDARDS_TREE=vnd
API_SUBTYPE=api
API_PREFIX=api
API_VERSION=v1
API_DEBUG=true

DB_HOST=localhost
DB_DATABASE=laravel_api
DB_USERNAME=homestead
DB_PASSWORD=secret

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

MAIL_DRIVER=smtp
MAIL_HOST=mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
```

When you have the .env with your database connection set up you can run your migrations

```bash
php artisan migrate
```
Then run `php artisan passport:install`

Run `php artisan app:install` and fill out the information of the admin user.

Handle **CORS** with `\Barryvdh\Cors\HandleCors::class`
 in `app/Http/Kernel.php`
 
`/app/Http/Middleware/VerifyCsrfToken.php`

     protected $except = [//
        'oauth/clients'
     ];

added *"barryvdh/laravel-cors": "^0.11.0"* in composer 

## Generate Documentation 
+ API Blueprint Documentation
https://github.com/dingo/api/wiki/API-Blueprint-Documentation

+ Create beautiful document from md files
https://github.com/danielgtaylor/aglio 

     `npm install -g aglio`
     
     `aglio -i input.apib -o output.html`

Install npm package without sudo 
https://docs.npmjs.com/getting-started/fixing-npm-permissions 
 
## Tests

Navigate to the project root and run `vendor/bin/phpunit` after installing all the composer dependencies and after the .env file was created.

## License

The Laravel API Starter kit is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
