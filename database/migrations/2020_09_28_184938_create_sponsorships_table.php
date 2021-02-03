<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSponsorshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponsorships', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('cat_id')->nullable()->constrained('cats')->nullOnDelete();
            $table->foreignId('person_data_id')->nullable()->constrained('person_data')->nullOnDelete();
            $table->boolean('is_anonymous')->default(false);
            $table->decimal('monthly_amount')->nullable();
            $table->boolean('is_active')->default(false);
            $table->date('ended_at')->nullable();
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
        Schema::dropIfExists('sponsorships');
    }
}
