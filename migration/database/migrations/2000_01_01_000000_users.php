<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createTable();

        DB::beginTransaction();

            $name = 'sample_' . date('ymdhis');
            DB::insert(
                'insert into users (account, password, email, status) values (?, ?, ?, ?)',
                [$name, 'xxxx', "{$name}@localhost.com.tw", 0]
            );

        DB::commit();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::beginTransaction();

        Schema::drop('users');

        DB::commit();
    }

    /**
     *  請注意!
     *
     *      mysql Transaction 無法處理 create table 的 rollback
     *      
     */
    private function createTable()
    {
        Schema::create('users', function(Blueprint $table) {
            $table->increments('id');
            $table
                ->string('account', 32)
                ->unique();
            $table->char('password', 77);
            $table->string('role_ids', 30);
            $table->string('email', 100);
            $table
                ->tinyInteger('status')
                ->unsigned();
            $table
                ->timestamp('create_time')
                ->default('0000-00-00 00:00:00');
            $table
                ->timestamp('update_time')
                ->default('0000-00-00 00:00:00');

            $table->text('properties');

            // $table->engine = 'InnoDB';   // myISAM, InnoDB
        });

        DB::statement('ALTER TABLE `users` CHANGE `password` `password` CHAR(77) BINARY CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL');
    }

}
