<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('sale');
            $table->boolean('rent');
            $table->unsignedInteger('owner');
            $table->boolean('owner_spouse')->nullable();
            $table->unsignedInteger('owner_company')->nullable();
            $table->unsignedInteger('acquirer');
            $table->boolean('acquirer_spouse')->nullable();
            $table->unsignedInteger('acquirer_company')->nullable();
            $table->unsignedInteger('property');
            $table->decimal('price', 10, 2);
            $table->decimal('tribute', 10, 2);
            $table->decimal('condominium', 10, 2);
            $table->unsignedInteger('due_date');
            $table->unsignedInteger('deadline');
            $table->date('start_at');
            $table->timestamps();

            $table->foreign('owner')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('owner_company')->references('id')->on('companies')->onDelete('CASCADE');
            $table->foreign('acquirer')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('acquirer_company')->references('id')->on('companies')->onDelete('CASCADE');
            $table->foreign('property')->references('id')->on('properties')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
