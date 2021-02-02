<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToCatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cats', function (Blueprint $table) {
            $table->smallInteger('gender')->nullable();
            $table->text('story')->nullable();
            $table->date('date_of_arrival')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_group')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cats', function (Blueprint $table) {
            $table->dropColumn('gender');
            $table->dropColumn('story');
            $table->dropColumn('date_of_arrival');
            $table->dropColumn('date_of_birth');
            $table->dropColumn('is_active');
            $table->dropColumn('is_group');
        });
    }
}
