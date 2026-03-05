<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->integer('account_type')->lenght(1)->default(1)->comment('[0] - root; [1] - admin; [2] - client; [3] - partner');
            $table->string('profile_number')->nullable();
            $table->string('profile_number_seller')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('photo')->nullable();
            $table->string('address')->nullable();
            $table->double('map_latitude')->nullable();
            $table->double('map_longitude')->nullable();
            $table->double('map_zoom')->nullable();
            $table->double('map_rotate')->nullable();
            $table->double('marker_latitude')->nullable();
            $table->double('marker_longitude')->nullable();
            $table->boolean('enabled')->default(false);
            $table->integer('is_customer_service_review')->default(0);
            $table->integer('is_business_service_review')->default(0);

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

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
