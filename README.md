## Laravel - API

Laravel-api to provide [react-app](https://github.com/aanimation/react-app) endpoint
Made by Laravel v8.83.27 (PHP v7.3.33)

## Endpoint

- login (admin only)
- user list
- create user
- detail user (param user id)
- update user (param user id)
- delete user (param user id)
- logout

## Quick Installation
* clone from repo
```sh
git clone https://github.com/aanimation/laravel-api.git
cd laravel-api
composer install
```
* copy `.env.example` to `.env`
* adjust database on the `.env`

* run application
```sh
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

### Login as admin with params:
```
email: admin@example.com
password: admin
```
