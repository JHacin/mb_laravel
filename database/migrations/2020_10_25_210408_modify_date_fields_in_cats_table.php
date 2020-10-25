<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyDateFieldsInCatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cats', function (Blueprint $table) {
            $table->renameColumn('date_of_arrival', 'date_of_arrival_mh');
            $table->date('date_of_arrival_boter')->nullable();
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
            $table->renameColumn('date_of_arrival_mh', 'date_of_arrival');
            $table->dropColumn('date_of_arrival_boter');
        });
    }
}
