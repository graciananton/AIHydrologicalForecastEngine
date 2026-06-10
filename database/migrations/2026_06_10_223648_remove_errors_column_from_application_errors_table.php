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
        Schema::table('application_errors', function (Blueprint $table) {
            $table->dropColumn('errors');
        });
    }
    /* reverse the remove by adding errors */
    public function down(): void
    {
        Schema::table('application_errors', function (Blueprint $table) {
            $table->text('errors')->nullable();
        });
    }
};
