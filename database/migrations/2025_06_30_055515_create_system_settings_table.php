<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name');
            $table->string('site_tagline');
            $table->string('site_email');
            $table->string('site_phone');
            $table->string('site_facebook_link');
            $table->longText('site_address');
            $table->text('meta_keywords');
            $table->text('meta_description');
            $table->string('meta_author');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
