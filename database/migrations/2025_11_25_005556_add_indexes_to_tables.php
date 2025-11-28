<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Indexing membuat pencarian data jadi instan (0.01 detik)
        Schema::table('tweets', function (Blueprint $table) {
            $table->index('policy_id'); // Mempercepat pencarian tweet per kebijakan
            $table->index('sentiment_label'); // Mempercepat hitung statistik
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->index('type'); // Mempercepat filter jenis soal
        });
    }

    public function down(): void
    {
        Schema::table('tweets', function (Blueprint $table) {
            $table->dropIndex(['policy_id']);
            $table->dropIndex(['sentiment_label']);
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->dropIndex(['type']);
        });
    }
};