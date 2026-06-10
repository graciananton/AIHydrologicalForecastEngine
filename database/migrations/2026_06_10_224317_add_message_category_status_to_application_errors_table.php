<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('application_errors', function (Blueprint $table) {
            $table->string('category', 1000)->nullable();
            $table->string('status', 1000)->nullable();
            $table->string('message', 1000)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('application_errors', function (Blueprint $table) {
            $table->dropColumn([
                'category',
                'status',
                'message',
            ]);
        });
    }
};
