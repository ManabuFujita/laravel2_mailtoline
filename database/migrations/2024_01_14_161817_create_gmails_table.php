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
        Schema::create('gmails', function (Blueprint $table) {
            $table->id();
            $table->string('line_id');
            $table->string('email')->nullable();
            $table->string('name')->nullable();;
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('provider')->nullable();
            $table->string('access_token')->nullable();
            $table->string('refresh_token')->nullable();
            $table->integer('expires_in')->nullable();
            $table->string('id_token')->nullable();
            $table->timestamp('created')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->unique(['line_id', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gmails');
    }
};
