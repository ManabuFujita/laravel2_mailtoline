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
        Schema::create('sendlogs', function (Blueprint $table) {
            $table->id();
            $table->string('line_id')->unique();
            $table->string('email')->unique();
            $table->string('mail_id')->unique();
            $table->timestamp('senddate')->unique();
            $table->string('title')->nullable();
            $table->string('from')->nullable();
            $table->string('body')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sendlogs');
    }
};
