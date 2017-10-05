<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_users', function (Blueprint $table) {
            $table -> increments('id');
            $table -> string('fullname');
            $table -> string('title');
            $table -> string('email')->unique();
            $table -> text('address');
            $table -> string('postcode');
        });

        Schema::create('test_payments', function(Blueprint $table){
            $table -> increments('id');
            $table -> decimal('amount', 10, 2);
            $table -> integer('test_user_id');
            $table -> dateTime('payment_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('test_users');
        Schema::drop('test_payments');
    }
}
