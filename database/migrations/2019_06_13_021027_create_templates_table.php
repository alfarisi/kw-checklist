<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description');
            $table->integer('due_interval');
            $table->enum('due_unit', ['minute', 'hour', 'day', 'week', 'month']);
            $table->timestamps();
        });
        
        Schema::create('templates_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('template_id');
            $table->foreign('template_id')->references('id')->on('templates')->onDelete('cascade');
            $table->string('description');
            $table->integer('urgency');
            $table->integer('due_interval');
            $table->enum('due_unit', ['minute', 'hour', 'day', 'week', 'month']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('templates_items');
        Schema::dropIfExists('templates');
    }
}
