<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->smallInteger('gender')->nullable();
            $table->text('story')->nullable();
            $table->date('date_of_arrival_mh')->nullable();
            $table->date('date_of_arrival_boter')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_group')->default(false);
            $table->timestamps();
            $table->string('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cats');
    }
}
