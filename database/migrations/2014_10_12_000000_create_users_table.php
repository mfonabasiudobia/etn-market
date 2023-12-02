<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('first_name')->nullable();
            $table->string('other_name')->nullable();
            $table->string('last_name')->nullable();

            $table->string('unique_id')->unique();

            $table->string('mother_maiden_name')->nullable();
            $table->string('mobile_number1')->nullable();
            $table->string('mobile_number2')->nullable();

            $table->string('blood_group')->nullable();
            $table->string('genotype')->nullable();
            $table->string('nationality')->nullable();
            $table->string('state_of_origin')->nullable();
            $table->string('lga')->nullable();
            $table->string('national_identification_number')->nullable();


            $table->string('residential_address')->nullable();
            $table->string('residential_country')->nullable();
            $table->string('residential_state')->nullable();
            $table->string('residential_zipcode')->nullable();
            $table->string('residential_lga')->nullable();


            $table->string('emergency_address')->nullable();
            $table->string('emergency_name')->nullable();
            $table->string('emergency_mobile_number1')->nullable();
            $table->string('emergency_mobile_number2')->nullable();

            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_verified')->default(0);
            $table->string('profile_image')->default("images/blank-profile-circle.png");
            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
};
