<?php

use App\Models\Cat;
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
            $table->smallInteger('gender')->default(Cat::GENDER_UNKNOWN);
            $table->text('story')->nullable();
            $table->date('date_of_arrival');
            $table->date('date_of_birth');
            $table->boolean('is_active');
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
        });
    }
}
