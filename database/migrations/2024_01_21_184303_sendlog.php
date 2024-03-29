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
            $table->string('line_id');
            $table->string('email');
            $table->string('mail_id');
            $table->timestamp('senddate');
            $table->string('title')->nullable();
            $table->string('mail_from')->nullable();
            $table->string('body')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->unique(['line_id', 'email', 'mail_id']);
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
