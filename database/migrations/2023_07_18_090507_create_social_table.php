<?php

use Cornatul\Feeds\Models\Feed;
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
    public function up(): void
    {
        Schema::create('social_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            //table string
            $table->string('account');
            $table->timestamps();
            // Define foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('social_accounts_configuration', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('social_account_id');
            $table->string('type');
            $table->json('configuration');
            $table->json('information')->nullable();
            //timestamps
            $table->timestamps();
            // Define foreign key constraints
            $table->foreign('social_account_id')->references('id')->on('social_accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('social_accounts');
        Schema::dropIfExists('social_accounts_configuration');
    }
};
