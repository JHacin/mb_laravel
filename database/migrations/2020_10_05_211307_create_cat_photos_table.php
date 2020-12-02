<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCatPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_photos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('filename');
            $table->string('alt')->nullable();
            $table->integer('index');
            $table->foreignId('cat_id')->constrained('cats');
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
        Schema::dropIfExists('cat_photos');
    }
}
