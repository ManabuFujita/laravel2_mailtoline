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
            $table->string('line_id');
            $table->string('email');
            $table->integer('no')->nullable();
            $table->string('mail_from')->nullable();
            $table->string('subject')->nullable();
            $table->rememberToken();
            $table->timestamps();

            // 複合キー
            // $table->unique(['line_id', 'email', 'mail_from', 'subject']);
            $table->primary(['line_id', 'email', 'mail_from', 'subject']);

            // 外部キー制約
            $table->foreign('line_id')->references('line_id')->on('users');
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
