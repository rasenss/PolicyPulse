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
        // Cache Dashboard 60 menit
        $data = Cache::remember('dashboard_stats', 60*60, function () {
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
        // JANGAN CACHE agar data selalu fresh, dan ambil SEMUA tweets
        $policy = Policy::with(['tweets' => function($q) {
            $q->latest('created_at_twitter')
              ->select('id', 'policy_id', 'username', 'full_text', 'sentiment_label', 'sentiment_score', 'likes', 'retweets', 'created_at_twitter');
            // TIDAK ADA LIMIT - ambil semua
        }])->findOrFail($id);

        $stats = $policy->tweets()
            ->select('sentiment_label', DB::raw('count(*) as total'))
            ->groupBy('sentiment_label')
            ->pluck('total', 'sentiment_label')
            ->toArray();
        
        return view('detail', compact('policy', 'stats'));
    }

    public function education()
    {
        return view('education');
    }

    public function quiz()
    {
        // JANGAN DI-CACHE AGAR SELALU ACAK/FRESH SETIAP RELOAD
        // Ambil 40 soal MCQ secara acak
        $mcqs = DB::table('questions')
                ->select('id', 'question_text', 'options')
                ->where('type', 'mcq')
                ->inRandomOrder() // Acak urutan
                ->limit(40)
                ->get();

        // Ambil 10 soal Essay secara acak
        $essays = DB::table('questions')
                ->select('id', 'question_text')
                ->where('type', 'essay')
                ->inRandomOrder() // Acak urutan
                ->limit(10)
                ->get();
        
        return view('quiz', compact('mcqs', 'essays'));
    }

    public function submit(Request $request)
    {
        $userAnswers = $request->input('ans', []);
        $essayAnswers = $request->input('essay', []);
        
        $score = 0;
        $totalMcq = 40;
        $review = [];

        // Ambil semua soal MCQ yang dijawab
        $mcqIds = array_keys($userAnswers);
        $mcqQuestions = [];
        if(!empty($mcqIds)) {
            $mcqQuestions = DB::table('questions')
                ->whereIn('id', $mcqIds)
                ->get()
                ->keyBy('id');
        }

        // Hitung Skor MCQ & Siapkan Review
        foreach($userAnswers as $id => $ans) {
            if(isset($mcqQuestions[$id])) {
                $q = $mcqQuestions[$id];
                $isCorrect = ($q->correct_answer === $ans);
                
                if($isCorrect) {
                    $score++;
                }

                $review[] = [
                    'type' => 'mcq',
                    'question' => $q->question_text,
                    'user_answer' => $ans,
                    'correct_answer' => $q->correct_answer,
                    'is_correct' => $isCorrect,
                    'explanation' => $q->explanation,
                    'options' => json_decode($q->options, true),
                    'score' => $isCorrect ? 100 : 0,
                ];
            }
        }

        // Ambil soal Essay yang dijawab
        $essayIds = array_keys($essayAnswers);
        if(!empty($essayIds)) {
            $essayQuestions = DB::table('questions')
                ->whereIn('id', $essayIds)
                ->get()
                ->keyBy('id');

            foreach($essayAnswers as $id => $ans) {
                if(isset($essayQuestions[$id])) {
                    $q = $essayQuestions[$id];
                    
                    // Skor essay sederhana berdasarkan panjang jawaban (bisa diganti AI grading)
                    $essayScore = 0;
                    $wordCount = str_word_count($ans);
                    if($wordCount >= 100) $essayScore = 80;
                    elseif($wordCount >= 50) $essayScore = 60;
                    elseif($wordCount >= 20) $essayScore = 40;
                    elseif($wordCount > 0) $essayScore = 20;

                    $review[] = [
                        'type' => 'essay',
                        'question' => $q->question_text,
                        'user_answer' => $ans,
                        'correct_answer' => $q->correct_answer,
                        'is_correct' => $essayScore >= 60,
                        'explanation' => $q->explanation,
                        'options' => null,
                        'score' => $essayScore,
                        'feedback' => $wordCount > 0 ? "Jawaban Anda: {$wordCount} kata." : "Tidak dijawab.",
                    ];
                }
            }
        }

        // Hitung Nilai Akhir (MCQ saja untuk skor utama)
        $final = ($score / $totalMcq) * 100;
        
        // Tentukan Predikat
        $grade = 'Pemula';
        if($final >= 85) $grade = 'Ahli Strategi (Expert)';
        elseif($final >= 70) $grade = 'Analis Senior';
        elseif($final >= 50) $grade = 'Analis Junior';

        return view('result', compact('final', 'grade', 'score', 'totalMcq', 'review'));
    }
}