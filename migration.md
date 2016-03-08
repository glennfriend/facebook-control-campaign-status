##執行所有未執行的 migration
```sh
cd migration/
php artisan migrate
```

##create article
```sh
php artisan make:migration articles --table=articles
```

##還原
```sh
composer update
php artisan migrate:rollback
```

##install migration
```sh
cd migration
cp .env.example .env
vi .env
```
