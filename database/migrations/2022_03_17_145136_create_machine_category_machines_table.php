<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machine_category_machines', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('machine_id')->unsigned()->index();
            $table->bigInteger('category_id')->unsigned()->index();
            $table->boolean('is_main')->nullable();
            $table->integer('order')->unsigned()->default(1);

            $table
                ->foreign('machine_id')
                ->references('id')
                ->on('machines')
                ->onDelete('cascade');

            $table
                ->foreign('category_id')
                ->references('id')
                ->on('machine_categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('machine_category_machines');
    }
};
