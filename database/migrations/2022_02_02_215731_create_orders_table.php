<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->nullable()->unsigned()->index();
            $table->bigInteger('seller_id')->nullable()->unsigned()->index();
            $table->bigInteger('offers_id')->nullable()->unsigned()->index();
            $table->bigInteger('machine_id')->unsigned()->index();
            $table->bigInteger('technic_id')->unsigned()->index();


            $table->boolean('is_tender')->default(false);

            $table->boolean('is_driver')->default(false);

            $table->string('order_number')->nullable();

            $table->string('name')->nullable();
            $table->string('photo')->nullable();
            $table->integer('hours')->nullable();

            $table->smallInteger('count')->nullable();
            $table->decimal('min_price', 8, 0)->nullable();
            $table->decimal('max_price', 8, 0)->nullable();

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->text('comment')->nullable();

            $table->enum('type_of_delivery', ['self', 'business'])->default('business');

            $table->date('date_of_delivery')->nullable();
            $table->date('start_date_of_delivery')->nullable();
            $table->date('end_date_of_delivery')->nullable();

            $table->string('address')->nullable();

            $table->double('map_latitude')->nullable();
            $table->double('map_longitude')->nullable();
            $table->double('map_zoom')->nullable();
            $table->double('map_rotate')->nullable();

            $table->double('marker_latitude')->nullable();
            $table->double('marker_longitude')->nullable();

            $table->enum('status', ['new', 'accepted', 'executed', 'done', 'expired', 'canceled'])->default('new');

            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
