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
        Schema::create('mail_gmails', function (Blueprint $table) {
            $table->string('line_id'); 
            $table->string('email');
            $table->string('name')->nullable();;
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('provider')->nullable();
            $table->string('access_token')->nullable();
            $table->string('refresh_token')->nullable();
            $table->integer('expires_in')->nullable();
            $table->text('id_token')->nullable();
            $table->timestamp('created')->nullable();
            $table->rememberToken();
            $table->timestamps();

            // 複合キー
            // $table->unique(['line_id', 'email']);
            $table->primary(['line_id', 'email']);

            // 外部キー制約
            $table->foreign('line_id')->references('line_id')->on('users'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_gmails');
    }
};
