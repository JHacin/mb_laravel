<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAmountAndIsAnonymousFieldsToSponsorshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sponsorships', function (Blueprint $table) {
            $table->boolean('is_anonymous')->default(false);
            $table->decimal('monthly_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sponsorships', function (Blueprint $table) {
            $table->dropColumn('is_anonymous');
            $table->dropColumn('monthly_amount');
        });
    }
}
