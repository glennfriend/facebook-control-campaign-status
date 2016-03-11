##執行所有未執行的 migration
```sh
cd migration/
php artisan migrate
```

##create article (範例)
```sh
php artisan make:migration articles --table=articles
```

##還原上一次的 migration
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

##Note
- [mysql transaction 無法處理 create table(DDL) 的 rollback](http://dev.mysql.com/doc/refman/5.7/en/cannot-roll-back.html)
- [laravel schema document](https://laravel.com/docs/5.0/schema)
- [laravel migrations document](https://laravel.tw/docs/5.2/migrations)

