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
        Schema::create('product_models', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 50);
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('style_id');
            $table->string('size', 30)->nullable(true);
            $table->float('weight')->default(0);
            $table->float('price')->default(0);
            $table->float('old_price')->default(0);
            $table->text('description')->nullable(true);
            $table->integer('viewed')->default(0);
            $table->integer('sold')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_models');
    }
};
