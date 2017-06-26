<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('display')->default('');
            $table->string('name')->default('');
            $table->string('last_name')->default('');
            $table->string('email')->unique();
            $table->bigInteger('phone')->default(0);
            $table->string('password');
            $table->string('image')->default('');
            $table->string('device_token')->default('');
            $table->string('device_type')->default('');
            $table->rememberToken();
            $table->string('auth_token')->default('');
            $table->text('roles');
            $table->float('lat',10,2)->default(0);
            $table->float('long',10,2)->default(0);
            $table->text('status');
            $table->integer('order_limit')->default(0);
            $table->integer('balance')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
