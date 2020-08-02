<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id');
            $table->string('contact_name', 255);
            $table->string('contact_email', 255);
            $table->string('contact_phone', 25);
            $table->string('serialcode', 25);
            $table->bigInteger('amount');
            $table->bigInteger('threshold');
            $table->bigInteger('paid');
            $table->text('about_invoice');
            $table->boolean('complete');
            $table->string('type');
            $table->timestamps();
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
        Schema::dropIfExists('invoices');
    }
}
