<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique();
            $table->string('business_name', 255);
            $table->string('business_type', 255);
            $table->text('business_about');
            $table->string('business_serial', 255);
            $table->string('business_image', 255);
            $table->boolean('business_approved')->default(false);
            $table->string('account_balance', 255);
            $table->string('account_total', 255);
            $table->string('bank_name', 255);
            $table->string('account_number', 255);
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('businesses');
    }
}
