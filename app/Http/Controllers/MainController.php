<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Policy;
use App\Models\Tweet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class MainController extends Controller
{
    public function index()
    {
        // --- MODE DEMO: SIMULASI LOADING 10 DETIK ---
        // Website akan sengaja 'hang' selama 10 detik agar Loading Bar terlihat
        sleep(10); 

        $data = Cache::rememberForever('dashboard_stats', function () {
            $policies = Policy::select('id', 'title', 'description', 'official_tweet_url')
                        ->withCount('tweets')
                        ->get();
            
            $total = Tweet::count();
            
            $stats = Tweet::select('sentiment_label', DB::raw('count(*) as total'))
                ->groupBy('sentiment_label')
                ->pluck('total', 'sentiment_label')
                ->toArray();
            
            return compact('policies', 'total', 'stats');
        });

        return view('dashboard', $data);
    }

    public function policy($id)
    {
        // --- MODE DEMO: SIMULASI LOADING 10 DETIK ---
        sleep(10);

        $data = Cache::rememberForever("policy_page_{$id}", function () use ($id) {
            $policy = Policy::with(['tweets' => function($q) {
                $q->latest()
                  ->limit(30)
                  ->select('id', 'policy_id', 'username', 'full_text', 'sentiment_label', 'likes', 'retweets', 'created_at_twitter');
            }])->findOrFail($id);

            $stats = $policy->tweets()
                ->select('sentiment_label', DB::raw('count(*) as total'))
                ->groupBy('sentiment_label')
                ->pluck('total', 'sentiment_label')
                ->toArray();
            
            return compact('policy', 'stats');
        });

        return view('detail', $data);
    }

    public function quiz()
    {
        // --- MODE DEMO: SIMULASI LOADING 10 DETIK ---
        sleep(10);

        $data = Cache::rememberForever('quiz_content', function () {
            $mcqs = DB::table('questions')
                    ->select('id', 'question_text', 'options')
                    ->where('type', 'mcq')
                    ->limit(40)
                    ->get();

            $essays = DB::table('questions')
                    ->select('id', 'question_text')
                    ->where('type', 'essay')
                    ->limit(10)
                    ->get();
            
            return compact('mcqs', 'essays');
        });
        
        return view('quiz', $data);
    }

    public function submit(Request $request)
    {
        // Untuk submit kita beri 5 detik saja biar tidak terlalu lama menunggu hasil
        sleep(5);

        $score = 0;
        $answers = $request->input('ans', []);
        
        $keys = Cache::rememberForever('quiz_keys', function() {
            return DB::table('questions')->where('type', 'mcq')->pluck('correct_answer', 'id');
        });

        foreach($answers as $id => $ans) {
            if(isset($keys[$id]) && $keys[$id] === $ans) {
                $score++;
            }
        }

        $final = ($score / 40) * 100; 
        $grade = $final >= 85 ? 'Expert Analyst' : ($final >= 50 ? 'Junior Analyst' : 'Trainee');

        return view('result', compact('final', 'grade'));
    }
}