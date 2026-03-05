<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subscription_id');
            $table->string('status');
            $table->dateTime('activated_to')->nullable();
            $table->boolean('added_manually')->default(true);
            $table->string('order_id')->nullable();
            $table->string('order_number')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->integer('period')->default(1);
            $table->integer('count')->nullable();
            $table->enum('type', ['package', 'slot'])->default('package');
            $table->json('response')->nullable();
            $table->timestamps();

            $table->foreign('subscription_id')->references('id')->on('subscriptions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_histories');
    }
}
