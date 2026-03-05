<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->index();
            $table->bigInteger('business_id')->nullable()->unsigned()->index();
            $table->bigInteger('business_product_id')->nullable()->unsigned()->index();
            $table->bigInteger('order_id')->nullable()->unsigned()->index();
            $table->bigInteger('offer_id')->nullable()->unsigned()->index();
            $table->bigInteger('subscribe_id')->nullable()->unsigned()->index();

            $table->bigInteger('notification_messages_id')->unsigned()->index();

            $table->boolean('is_customer')->default(0);
            $table->boolean('is_sendmail')->default(0);
            $table->boolean('is_new')->default(0);
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
        Schema::dropIfExists('notifications');
    }
}
