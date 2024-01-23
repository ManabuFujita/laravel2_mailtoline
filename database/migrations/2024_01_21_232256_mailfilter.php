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
        Schema::create('mailfilters', function (Blueprint $table) {
            $table->id();
            $table->string('line_id');
            $table->string('email');
            $table->integer('no')->nullable();
            $table->string('mail_from')->nullable();
            $table->string('title')->nullable();
            $table->rememberToken();
            $table->timestamps();

            // $table->unique(['line_id', 'email', 'no']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mailfilters');
    }
};
