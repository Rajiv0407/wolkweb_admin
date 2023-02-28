<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('users', function (Blueprint $table) {
            // $table->string('Profile_Image');
            // $table->string('Country');
            // $table->string('State');
            // $table->string('City');
            // $table->string('Zipcode');
            // $table->string('House_Number');
            // $table->string('LandMark');
            // $table->string('Mobile_Code');
            // $table->string('Mobile_Number');
           // $table->tinyInteger('IsAgreeTC');
           //$table->timestamps();

     });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
