<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technics', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('business_id')->unsigned()->index();
            $table->bigInteger('machine_id')->unsigned()->index();
            $table->string('related_categories')->nullable();
            $table->boolean('is_driver')->default(0);
            $table->string('slug')->nullable();
            $table->string('product_number')->nullable();

            $table->string('region')->nullable();

            $table->string('name')->nullable();

            $table->decimal('price', 8, 2)->nullable();
            $table->integer('hours')->nullable();
            $table->text('description')->nullable();
            $table->enum('type_of_delivery', ['self', 'business'])->default('business');

            $table->string('address')->nullable();
            $table->double('map_latitude')->nullable();
            $table->double('map_longitude')->nullable();
            $table->double('map_zoom')->nullable();
            $table->double('map_rotate')->nullable();
            $table->double('marker_latitude')->nullable();
            $table->double('marker_longitude')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('technics');
    }
}
