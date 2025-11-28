<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('policies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('keyword_query'); // Keyword untuk Scraper Python
            $table->text('description');
            $table->string('source_link')->nullable(); // Link Artikel Berita
            $table->string('official_tweet_url')->nullable(); // Link Langsung ke X (Twitter)
            $table->timestamps();
        });

        Schema::create('tweets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('policy_id')->constrained()->onDelete('cascade');
            $table->string('tweet_id')->unique();
            $table->text('full_text');
            $table->string('username');
            $table->integer('likes')->default(0);
            $table->integer('retweets')->default(0);
            $table->string('created_at_twitter');
            $table->float('sentiment_score')->default(0);
            $table->string('sentiment_label');
            $table->timestamps();
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['mcq', 'essay']);
            $table->text('question_text');
            $table->json('options')->nullable();
            $table->string('correct_answer')->nullable();
            $table->text('explanation')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
        Schema::dropIfExists('tweets');
        Schema::dropIfExists('policies');
    }
};