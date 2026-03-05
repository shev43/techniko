<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('seller_id')->unsigned()->index();
            $table->bigInteger('order_id')->unsigned()->index();
            $table->bigInteger('machine_id')->unsigned()->index();
            $table->bigInteger('technic_id')->unsigned()->index();
            $table->string('contact_id');

            $table->string('offer_number')->nullable();

            $table->string('name')->nullable();
            $table->string('photo')->nullable();
            $table->integer('hours')->nullable();

            $table->smallInteger('count')->nullable();
            $table->decimal('price', 8, 0)->nullable();

            $table->enum('status', ['new', 'canceled'])->default('new');
            $table->enum('canceled_by', ['client', 'seller', 'cron'])->nullable();
            $table->string('canceled_comment')->nullable();

            $table->timestamps();

            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            $table->unique(['order_id', 'seller_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
