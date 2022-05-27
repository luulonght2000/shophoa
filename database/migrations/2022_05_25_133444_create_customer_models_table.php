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
        Schema::create('customer_models', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('fullname', 30);
            $table->boolean('sex')->default(true);
            $table->date('DOB')->nullable(true);
            $table->string('address', 200)->nullable(true);
            $table->string("phone", 30)->nullable(true);
            $table->string('email', 100)->nullable(true);
            $table->text('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_models');
    }
};
