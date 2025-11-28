<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Policy;
use App\Models\Tweet;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class FetchTweets extends Command
{
    protected $signature = 'tweets:fetch';
    protected $description = 'Scrape Twitter Agresif via Chrome Manual (File Based)';

    public function handle()
    {
        $this->info('🚀 Memulai Scraper Agresif (Target 300/kebijakan)...');

        $policies = Policy::whereNotNull('official_tweet_url')->get();

        if ($policies->isEmpty()) {
            $this->error('❌ Data kebijakan kosong. Jalankan seeder dulu.');
            return;
        }

        foreach ($policies as $policy) {
            $this->info("\n------------------------------------------------");
            $this->info("🔍 Target: {$policy->title}");
            $this->info("🔗 URL: {$policy->official_tweet_url}");
            
            // Nama file sementara unik untuk setiap proses
            $tempFile = base_path("tweets_temp_{$policy->id}.json");
            
            // Hapus file lama jika ada
            if (File::exists($tempFile)) {
                File::delete($tempFile);
            }

            // Panggil Node.js dengan argumen tambahan: path file output
            $process = Process::timeout(0)->run("node scraper.cjs \"{$policy->official_tweet_url}\" \"{$policy->id}\" \"{$tempFile}\"");
            
            // Tampilkan log progress (stderr)
            $this->comment($process->errorOutput());

            // CEK APAKAH FILE JSON TERBENTUK
            if (File::exists($tempFile)) {
                $jsonString = File::get($tempFile);
                $data = json_decode($jsonString, true);

                if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
                    $count = count($data);
                    
                    if ($count > 0) {
                        $this->info("✅ SUKSES: Membaca file ({$count} tweet).");
                        $this->info("💾 Menyimpan ke database...");
                        
                        $chunks = array_chunk($data, 50);
                        $bar = $this->output->createProgressBar(count($chunks));
                        $bar->start();

                        foreach ($chunks as $chunk) {
                            foreach ($chunk as $row) {
                                Tweet::updateOrCreate(
                                    ['tweet_id' => $row['tweet_id']], 
                                    [
                                        'policy_id' => $row['policy_id'],
                                        'full_text' => $row['full_text'],
                                        'username' => $row['username'],
                                        'likes' => $row['likes'],
                                        'retweets' => $row['retweets'],
                                        'created_at_twitter' => $row['created_at_twitter'],
                                        'sentiment_score' => $row['sentiment_score'],
                                        'sentiment_label' => $row['sentiment_label'],
                                    ]
                                );
                            }
                            $bar->advance();
                        }
                        $bar->finish();
                        $this->newLine();
                        
                        // Hapus cache & file temp
                        Cache::forget("policy_detail_{$policy->id}");
                        Cache::forget("policy_page_{$policy->id}");
                        File::delete($tempFile);
                        
                    } else {
                        $this->warn("⚠️ File JSON kosong (0 Data).");
                    }
                } else {
                    $this->error("⚠️ Gagal decode JSON dari file.");
                }
            } else {
                $this->error("❌ Gagal! File output tidak ditemukan. Node.js crash?");
            }
        }
        
        Cache::flush();
        $this->info("\n🎉 SELESAI! Refresh website sekarang.");
    }
}