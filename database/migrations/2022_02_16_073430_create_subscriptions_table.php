<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('business_id');
            $table->boolean('added_manually')->default(false);
            $table->string('order_id')->nullable();
            $table->string('status');
            $table->string('order_number')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->integer('period')->default(1);
            $table->integer('count')->nullable();
            $table->enum('type', ['package', 'slot'])->default('package');
            $table->json('response')->nullable();
            $table->datetime('active_to')->nullable();
            $table->timestamps();

            $table->foreign('business_id')->references('id')->on('businesses');
            $table->foreign('seller_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}
