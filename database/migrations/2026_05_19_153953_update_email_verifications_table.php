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
        Schema::create('email_verifications', function (Blueprint $table) {
            $table->id();

            $table->string('email')->index();

            $table->string('otp');

            $table->timestamp('expires_at');

            $table->integer('attempts')->default(0);

            $table->timestamp('attempts_start_at')->nullable();

            $table->timestamp('last_sent_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
