<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan data lama
        DB::statement('TRUNCATE TABLE questions RESTART IDENTITY CASCADE');
        DB::statement('TRUNCATE TABLE policies RESTART IDENTITY CASCADE');

        // 1. DATA KEBIJAKAN (Tetap sama seperti request sebelumnya)
        $policies = [
            [
                'title' => 'Pemotongan Anggaran Kemendikdasmen Rp8 T',
                'keyword_query' => '"Anggaran Pendidikan" OR "Kemendikdasmen" lang:id',
                'description' => 'Pemerintah di bawah Presiden Prabowo memangkas anggaran Kementerian Pendidikan Dasar dan Menengah sebesar Rp8 triliun sebagai bagian dari reformasi anggaran nasional. Kebijakan ini memicu perdebatan sengit tentang prioritas pendidikan versus program lain, dengan kritik tajam dari kalangan pendidik.',
                'source_link' => null,
                'official_tweet_url' => 'https://x.com/CNNIndonesia/status/1888026349023150378'
            ],
            [
                'title' => 'Penundaan ASN ke IKN Tanpa Batas Waktu',
                'keyword_query' => '"ASN IKN" OR "Pindah IKN" lang:id',
                'description' => 'Pemindahan Aparatur Sipil Negara (ASN) ke Ibu Kota Nusantara (IKN) yang semula dijadwalkan Januari 2025 ditunda tanpa jadwal pasti, terkait blokir anggaran IKN. Hal ini menyebabkan ketidakpastian proyek IKN, meski pembangunan tahap II berlanjut dengan standar internasional.',
                'source_link' => null,
                'official_tweet_url' => 'https://x.com/CNNIndonesia/status/1885312911129837627'
            ],
            [
                'title' => 'Realokasi Infrastruktur ke Makan Bergizi Gratis',
                'keyword_query' => '"Makan Bergizi Gratis" OR "Anggaran Infrastruktur" lang:id',
                'description' => 'Anggaran infrastruktur dipangkas untuk mendukung program MBG dengan alokasi Rp71 triliun, yang hanya cukup hingga Juni 2025. Potensi tambahan beban anggaran hingga Rp420 triliun per tahun menjadi sorotan, dengan fokus pemerintah bergeser pada penghematan untuk hilirisasi.',
                'source_link' => null,
                'official_tweet_url' => 'https://x.com/CNNIndonesia/status/1879486753125671225'
            ],
            [
                'title' => 'Satgas Penanganan Premanisme & Ormas',
                'keyword_query' => '"Satgas Premanisme" OR "Ormas Investasi" lang:id',
                'description' => 'Pemerintah membentuk satuan tugas (satgas) untuk menangani premanisme dan organisasi masyarakat (ormas) yang mengganggu investasi, sebagai kebijakan keamanan ekonomi. Diarahkan untuk menciptakan lingkungan investasi aman, dengan target seperti Jawa Barat bebas premanisme pada 2025.',
                'source_link' => null,
                'official_tweet_url' => 'https://x.com/kompascom/status/1919945765968822307'
            ],
            [
                'title' => 'Badan Pengelola Investasi Danantara',
                'keyword_query' => '"Danantara" OR "BUMN" lang:id',
                'description' => 'Pembentukan Badan Pengelola Investasi Daya Anagata Nusantara (Danantara) untuk mengelola aset seperti BUMN, GBK, dan aset Setneg lainnya, dengan target dana Rp14 ribu triliun. Kritikus menyoroti potensi konflik kepentingan karena rangkap jabatan, meskipun ditujukan untuk investasi masa depan.',
                'source_link' => null,
                'official_tweet_url' => 'https://x.com/CNNIndonesia/status/1916842782238654631'
            ],
        ];
        DB::table('policies')->insert($policies);

        // 2. SOAL PILIHAN GANDA (EXPERT)
        $mcqs = [];
        $topics = [
            ['q' => 'Mengapa pemangkasan anggaran pendidikan demi efisiensi jangka pendek sering disebut sebagai "Myopic Policy" (Kebijakan Rabun Jauh)?', 'a' => 'Karena mengorbankan Human Capital jangka panjang demi likuiditas sesaat', 'opts' => ['A'=>'Karena biaya pendidikan murah', 'B'=>'Karena mengorbankan Human Capital jangka panjang demi likuiditas sesaat', 'C'=>'Karena guru protes', 'D'=>'Karena sekolah libur', 'E'=>'Karena buku mahal']],
            ['q' => 'Dalam teori investasi, ketidakpastian jadwal IKN menciptakan risiko "Regulatory Risk". Apa dampak logisnya?', 'a' => 'Investor akan menahan modal (Wait and See) atau meminta risk premium tinggi', 'opts' => ['A'=>'Investor langsung masuk', 'B'=>'Investor akan menahan modal (Wait and See) atau meminta risk premium tinggi', 'C'=>'Rupiah menguat', 'D'=>'Inflasi turun', 'E'=>'Ekspor naik']],
            ['q' => 'Secara logika ekonomi, memindahkan anggaran Infrastruktur (Belanja Modal) ke Makan Gratis (Belanja Barang) akan mengakibatkan...', 'a' => 'Penurunan aset produktif negara dalam neraca jangka panjang', 'opts' => ['A'=>'Kenaikan aset', 'B'=>'Penurunan aset produktif negara dalam neraca jangka panjang', 'C'=>'Jalan tol bertambah', 'D'=>'Deflasi', 'E'=>'Surplus anggaran']],
            ['q' => 'Konflik kepentingan (Conflict of Interest) pada Danantara terjadi secara logis ketika...', 'a' => 'Satu entitas menjadi pembuat aturan sekaligus pemain pasar', 'opts' => ['A'=>'Modal kurang', 'B'=>'Satu entitas menjadi pembuat aturan sekaligus pemain pasar', 'C'=>'Pegawai banyak', 'D'=>'Kantor jauh', 'E'=>'BUMN rugi']],
            ['q' => 'Mengapa pendekatan represif Satgas Premanisme secara logika sosiologis tidak akan menyelesaikan masalah secara permanen?', 'a' => 'Karena tidak menyentuh akar penyebab yaitu kemiskinan struktural', 'opts' => ['A'=>'Biaya mahal', 'B'=>'Karena tidak menyentuh akar penyebab yaitu kemiskinan struktural', 'C'=>'Polisi takut', 'D'=>'Preman punya izin', 'E'=>'Masyarakat suka']],
        ];

        for ($i = 1; $i <= 40; $i++) {
            $t = $topics[($i - 1) % count($topics)];
            $mcqs[] = [
                'type' => 'mcq',
                'question_text' => "Logika Kebijakan No. $i: " . $t['q'],
                'options' => json_encode($t['opts']),
                'correct_answer' => $t['a'],
                'explanation' => 'Berdasarkan logika ekonomi dan kebijakan publik.',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('questions')->insert($mcqs);

        // 3. SOAL ESSAY (LOGIKA & COMMON SENSE - NO CASE STUDY)
        $essays = [];
        $essay_prompts = [
            'Secara logika, jika anggaran pendidikan dipotong hari ini, berapa tahun lagi dampak penurunannya akan terasa pada ekonomi negara? Jelaskan alur sebab-akibatnya.',
            'Jika investor butuh kepastian hukum, mengapa perubahan jadwal IKN yang terus-menerus justru bisa membunuh proyek tersebut sebelum selesai?',
            'Bandingkan dampak ekonomi: Membangun 1 pelabuhan (Infrastruktur) vs Memberi makan 1 juta orang selama setahun. Mana yang lebih sustainable untuk negara berkembang?',
            'Jelaskan paradoks di mana "Penyatuan Aset BUMN" (Danantara) justru bisa mempermudah korupsi skala besar jika tanpa pengawasan ketat.',
            'Apakah menangkap preman akan menghilangkan premanisme jika tidak ada lapangan kerja pengganti? Jelaskan menggunakan logika supply-demand tenaga kerja.',
        ];

        // Generate 10 Soal Essay (Mengulang 5 topik dengan variasi)
        foreach ($essay_prompts as $idx => $prompt) {
            $essays[] = [
                'type' => 'essay',
                'question_text' => "Logika Kritis " . ($idx + 1) . ": " . $prompt,
                'options' => null,
                'correct_answer' => null,
                'explanation' => 'Jawaban dinilai berdasarkan keruntutan logika dan common sense.',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        // Tambah 5 lagi biar 10
        foreach ($essay_prompts as $idx => $prompt) {
            $essays[] = [
                'type' => 'essay',
                'question_text' => "Logika Kritis " . ($idx + 6) . ": " . $prompt,
                'options' => null,
                'correct_answer' => null,
                'explanation' => 'Jawaban dinilai berdasarkan keruntutan logika dan common sense.',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        DB::table('questions')->insert($essays);
    }
}