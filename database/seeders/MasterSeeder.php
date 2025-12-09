<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('TRUNCATE TABLE questions RESTART IDENTITY CASCADE');
        DB::statement('TRUNCATE TABLE policies RESTART IDENTITY CASCADE');

        // 1. DATA KEBIJAKAN
        $policies = [
            [
                'title' => 'Pemotongan Anggaran Kemendikdasmen Rp8 T',
                'keyword_query' => '"Anggaran Pendidikan" OR "Kemendikdasmen" lang:id',
                'description' => 'Pemerintah memangkas anggaran Kemendikdasmen Rp8 triliun sebagai bagian dari reformasi anggaran nasional.',
                'source_link' => null,
                'official_tweet_url' => 'https://x.com/CNNIndonesia/status/1888026349023150378'
            ],
            [
                'title' => 'Penundaan ASN ke IKN Tanpa Batas Waktu',
                'keyword_query' => '"ASN IKN" OR "Pindah IKN" lang:id',
                'description' => 'Pemindahan ASN ke IKN ditunda tanpa jadwal pasti terkait blokir anggaran IKN.',
                'source_link' => null,
                'official_tweet_url' => 'https://x.com/CNNIndonesia/status/1885312911129837627'
            ],
            [
                'title' => 'Realokasi Infrastruktur ke Makan Bergizi Gratis',
                'keyword_query' => '"Makan Bergizi Gratis" OR "Anggaran Infrastruktur" lang:id',
                'description' => 'Anggaran infrastruktur dipangkas untuk program MBG dengan alokasi Rp71 triliun.',
                'source_link' => null,
                'official_tweet_url' => 'https://x.com/CNNIndonesia/status/1879486753125671225'
            ],
            [
                'title' => 'Satgas Penanganan Premanisme & Ormas',
                'keyword_query' => '"Satgas Premanisme" OR "Ormas Investasi" lang:id',
                'description' => 'Satgas dibentuk untuk menangani premanisme dan ormas yang mengganggu investasi.',
                'source_link' => null,
                'official_tweet_url' => 'https://x.com/kompascom/status/1919945765968822307'
            ],
            [
                'title' => 'Badan Pengelola Investasi Danantara',
                'keyword_query' => '"Danantara" OR "BUMN" lang:id',
                'description' => 'Danantara dibentuk untuk mengelola aset BUMN dengan target dana Rp14 ribu triliun.',
                'source_link' => null,
                'official_tweet_url' => 'https://x.com/CNNIndonesia/status/1916842782238654631'
            ],
        ];
        DB::table('policies')->insert($policies);

        // 2. SOAL MCQ - HUMAN-WRITTEN STYLE (40 Soal)
        $mcqs = [
            // ========== BLOK 1: ANGGARAN PENDIDIKAN (8 Soal) ==========
            [
                'type' => 'mcq',
                'question_text' => 'Bayangkan situasi ini: pemerintah bilang "kami potong anggaran pendidikan Rp8 T demi efisiensi." Tapi anehnya, anggaran untuk program lain malah dinaikkan. Kalau dipikir-pikir, ada yang janggal dari alasan ini. Apa itu?',
                'options' => json_encode([
                    'A' => 'Alasannya sudah masuk akal, efisiensi memang perlu',
                    'B' => 'Kalau memang efisiensi, harusnya semua sektor kena potong dong, kenapa cuma pendidikan?',
                    'C' => 'Wajar saja, efisiensi boleh pilih-pilih sektor',
                    'D' => 'Pemotongan anggaran pasti berarti penghematan',
                    'E' => 'Argumennya sudah sempurna'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Logikanya begini: kalau alasannya efisiensi, penghematan harusnya merata di semua sektor. Tapi kalau satu dipotong, yang lain dinaikkan, berarti ini bukan efisiensi melainkan geser prioritas.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'Coba ikuti alur berpikir ini: anggaran pendidikan dipotong → kualitas sekolah merosot → lulusan jadi kurang kompeten → terus apa lagi yang bakal terjadi 15-20 tahun ke depan?',
                'options' => json_encode([
                    'A' => 'Ekonomi langsung membaik karena pengeluaran berkurang',
                    'B' => 'Tenaga kerja kita kalah saing, produktivitas rendah, pertumbuhan ekonomi melambat',
                    'C' => 'Pendidikan dan ekonomi tidak ada hubungannya',
                    'D' => 'Ekspor kita langsung meningkat',
                    'E' => 'Investor asing berbondong-bondong masuk'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Rantainya sambung-menyambung: pendidikan bagus → SDM berkualitas → produktivitas tinggi → ekonomi tumbuh. Kalau mata rantai awal (pendidikan) rusak, efeknya menjalar ke seluruh rantai.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'Pemerintah punya dilema: uangnya terbatas. Opsi A: potong pendidikan buat program yang populer sekarang. Opsi B: pertahankan pendidikan tapi program populer ditunda dulu. Dari kacamata keadilan untuk anak cucu kita, mana yang lebih fair?',
                'options' => json_encode([
                    'A' => 'Opsi A dong, yang penting generasi sekarang senang dulu',
                    'B' => 'Opsi B, karena generasi mendatang juga punya hak yang sama untuk dapat pendidikan layak',
                    'C' => 'Dua-duanya sama saja',
                    'D' => 'Ngapain mikirin generasi mendatang',
                    'E' => 'Opsi A karena pendidikan bisa ditunda'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Ada konsep namanya keadilan antar-generasi: kita nggak boleh mengorbankan masa depan anak cucu demi keuntungan sesaat. Pendidikan itu hak dasar setiap generasi.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'Ada pejabat ngomong gini: "Tenang saja, pemotongan anggaran pendidikan nggak akan berdampak kok. Kualitas itu kan bukan soal uang." Kira-kira, apa yang salah dari pernyataan ini?',
                'options' => json_encode([
                    'A' => 'Pernyataannya benar dan logis',
                    'B' => 'Ini menyederhanakan masalah: memang uang bukan satu-satunya faktor, tapi uang tetap penting buat gaji guru, fasilitas, beasiswa',
                    'C' => 'Tidak ada yang salah',
                    'D' => 'Pejabat pasti lebih paham',
                    'E' => 'Uang memang tidak penting untuk pendidikan'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Ini namanya false dichotomy, menyederhanakan masalah jadi hitam-putih. Kualitas pendidikan memang dipengaruhi banyak hal, tapi uang tetap krusial untuk gaji guru yang layak, gedung yang bagus, dan beasiswa.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'Fakta: negara-negara maju menggelontorkan 5-7% PDB untuk pendidikan. Indonesia? Cuma 3%. Sekarang malah mau dipotong lagi. Kalau dipikir pakai logika, apa yang bakal terjadi?',
                'options' => json_encode([
                    'A' => 'Indonesia bakal cepat jadi negara maju',
                    'B' => 'Jarak kualitas SDM kita dengan negara maju bakal makin jauh',
                    'C' => 'Pemotongan tidak akan berdampak apa-apa',
                    'D' => 'Negara maju pasti salah mengalokasikan anggaran',
                    'E' => 'Data itu tidak bisa dipercaya'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Kalau kita sudah ketinggalan (3% vs 5-7%), lalu malah dikurangi lagi, ya makin ketinggalan dong. Logikanya, untuk mengejar ketertinggalan, harusnya investasi ditambah, bukan dikurangi.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'Setiap rupiah yang dipotong dari pendidikan pasti dialihkan ke program lain. Dalam ekonomi, ini namanya opportunity cost. Nah, siapa yang paling menanggung beban dari keputusan ini?',
                'options' => json_encode([
                    'A' => 'Pengusaha kaya yang bisa sekolahkan anaknya di mana saja',
                    'B' => 'Anak-anak dari keluarga tidak mampu yang cuma bisa andalkan sekolah negeri',
                    'C' => 'Pejabat pemerintah',
                    'D' => 'Pensiunan yang sudah tidak sekolah',
                    'E' => 'Investor asing'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Anak-anak dari keluarga miskin bergantung penuh pada pendidikan publik. Keluarga kaya? Mereka bisa pindah ke sekolah swasta. Yang tidak punya pilihan lain, mereka yang paling dirugikan.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'Sering dengar argumen ini kan: "Banyak orang sukses tanpa sekolah tinggi, jadi pendidikan itu nggak penting." Apa yang keliru dari cara berpikir ini?',
                'options' => json_encode([
                    'A' => 'Argumennya valid dan bisa diterima',
                    'B' => 'Ini namanya survivorship bias: kita cuma lihat yang sukses, padahal jutaan lainnya gagal tanpa pendidikan',
                    'C' => 'Argumennya berdasarkan data lengkap',
                    'D' => 'Tidak ada yang keliru',
                    'E' => 'Pendidikan memang tidak penting'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Ini jebakan berpikir namanya survivorship bias. Kita cuma melihat segelintir orang sukses tanpa pendidikan, tapi mengabaikan mayoritas besar yang tidak sukses. Secara statistik, pendidikan meningkatkan peluang sukses.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'Misalkan pemerintah memang harus hemat Rp8 T tapi tidak mau merugikan pendidikan. Langkah apa yang paling masuk akal?',
                'options' => json_encode([
                    'A' => 'Potong pendidikan saja, tidak ada jalan lain',
                    'B' => 'Pangkas birokrasi yang boros, kurangi perjalanan dinas mewah, tunda proyek seremonial',
                    'C' => 'Tambah utang luar negeri sebanyak-banyaknya',
                    'D' => 'Cetak uang saja',
                    'E' => 'Tidak bayar gaji PNS'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Banyak pos pengeluaran yang bisa dipangkas tanpa mengorbankan layanan publik: perjalanan dinas berlebihan, gedung kantor mewah, acara seremonial. Penghematan pintar itu yang begini.'
            ],

            // ========== BLOK 2: IKN (8 Soal) ==========
            [
                'type' => 'mcq',
                'question_text' => 'Pemerintah sudah habiskan Rp50 T untuk IKN, tapi proyeknya ditunda entah sampai kapan. Ada ekonom bilang: "Lanjutkan saja, sayang kalau dihentikan." Apa yang salah dari saran ini?',
                'options' => json_encode([
                    'A' => 'Sarannya masuk akal, harus diikuti',
                    'B' => 'Ini jebakan sunk cost fallacy: uang yang sudah keluar tidak bisa balik, keputusan harus berdasarkan prospek ke depan',
                    'C' => 'Tidak ada yang salah',
                    'D' => 'Semakin banyak uang keluar, proyeknya semakin bagus',
                    'E' => 'Uang yang sudah keluar pasti bisa dikembalikan'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Ini namanya sunk cost fallacy. Uang Rp50 T yang sudah keluar itu gone, tidak balik apapun keputusannya. Keputusan rasional harus lihat prospek ke depan, bukan "sayang kalau berhenti".'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'Investor asing melihat proyek IKN digantung tanpa kepastian. Kalau kamu jadi investor yang berpikir rasional, apa yang bakal kamu lakukan?',
                'options' => json_encode([
                    'A' => 'Langsung investasi lebih banyak, siapa tahu dapat diskon',
                    'B' => 'Minta imbal hasil lebih tinggi atau tunda dulu sampai ada kepastian',
                    'C' => 'Ketidakpastian bukan masalah',
                    'D' => 'Investasi tanpa pikir panjang',
                    'E' => 'Ketidakpastian justru bikin investasi lebih aman'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Investor benci ketidakpastian. Mereka pasti minta kompensasi lebih tinggi (risk premium) atau menunggu sampai situasi jelas. Ketidakpastian itu biaya tambahan bagi investor.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'IKN itu proyek kompleks yang melibatkan banyak pihak: Kemenkeu (anggaran), PUPR (konstruksi), KemenPAN (ASN), KLHK (lingkungan). Kalau satu bagian macet, misalnya anggaran, apa yang terjadi pada yang lain?',
                'options' => json_encode([
                    'A' => 'Bagian lain jalan terus, tidak terpengaruh',
                    'B' => 'Efek dominonya panjang: konstruksi terhambat, ASN tidak bisa pindah, infrastruktur menganggur',
                    'C' => 'Cuma anggaran yang bermasalah',
                    'D' => 'Bagian lain otomatis sukses',
                    'E' => 'Tidak ada hubungan antar bagian'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Proyek besar itu sistem yang saling terkait. Satu bagian macet, yang lain ikut kena. Ini namanya efek domino atau cascading failure.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'IKN sudah setengah jalan. Ada tiga opsi: (A) lanjutkan dengan biaya tambahan, (B) tunda tanpa kejelasan kapan dilanjutkan, (C) hentikan dan terima kerugian. Dari sudut pandang manajemen proyek, mana yang paling parah?',
                'options' => json_encode([
                    'A' => 'Opsi A, lanjutkan dengan penyesuaian',
                    'B' => 'Opsi B, digantung tanpa kepastian. Ini paling buruk karena biaya terus jalan tapi progress nol',
                    'C' => 'Opsi C, hentikan dan cut losses',
                    'D' => 'Semua opsi sama baiknya',
                    'E' => 'Tidak ada opsi yang buruk'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Menggantung proyek itu opsi terburuk: biaya maintenance terus jalan, investor kabur, SDM nganggur, tapi tidak ada kemajuan. Lebih baik ambil keputusan tegas: lanjut atau stop.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'Pendukung IKN bilang: "Jakarta sudah terlalu padat, harus pindah!" Penentang bilang: "IKN cuma buang-buang uang!" Posisi yang seimbang itu seperti apa?',
                'options' => json_encode([
                    'A' => 'Pendukung pasti benar 100%',
                    'B' => 'Dua-duanya ada benarnya: Jakarta memang bermasalah, tapi IKN bukan satu-satunya solusi',
                    'C' => 'Penentang pasti benar 100%',
                    'D' => 'Keduanya pasti salah total',
                    'E' => 'Tidak perlu analisis lebih lanjut'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Berpikir kritis itu menghindari ekstrem hitam-putih. Jakarta memang bermasalah (fakta), tapi ada alternatif lain selain IKN (desentralisasi, revitalisasi). IKN bukan satu-satunya jalan keluar.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'Kalau IKN dibatalkan total setelah sudah berjalan, siapa yang paling dirugikan?',
                'options' => json_encode([
                    'A' => 'Warga Jakarta yang tidak pernah rencana pindah',
                    'B' => 'Investor dan kontraktor yang sudah keluarkan modal, plus warga lokal Kaltim yang sudah berharap banyak',
                    'C' => 'Turis asing yang tidak ada hubungannya',
                    'D' => 'Negara lain',
                    'E' => 'Tidak ada yang dirugikan'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Yang paling kena dampak: investor/kontraktor yang kontraknya batal, dan warga Kaltim yang sudah mengubah hidup mereka (jual tanah, ekspektasi ekonomi) berdasarkan janji pemerintah.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'Dari kisah IKN yang digantung ini, pelajaran apa yang harus diterapkan untuk proyek-proyek raksasa di masa depan?',
                'options' => json_encode([
                    'A' => 'Jangan pernah bikin proyek besar lagi',
                    'B' => 'Wajib ada studi kelayakan mendalam, komitmen anggaran lintas pemerintahan, dan rencana cadangan kalau situasi berubah',
                    'C' => 'Langsung eksekusi tanpa rencana',
                    'D' => 'Tidak perlu belajar dari pengalaman',
                    'E' => 'Proyek besar pasti selalu gagal'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Proyek mega butuh: (1) studi kelayakan matang, (2) komitmen fiskal yang mengikat lintas periode pemerintahan, (3) exit strategy kalau kondisi berubah. Bukan berarti proyek besar dilarang.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'Coba bayangkan: kalau dari awal IKN dirancang bertahap, misalnya pindahkan 10% ASN dulu, evaluasi, baru lanjut. Apa bedanya dengan pendekatan sekarang?',
                'options' => json_encode([
                    'A' => 'Tidak ada bedanya',
                    'B' => 'Risiko lebih terukur, beban anggaran lebih ringan, dan bisa dievaluasi sebelum scale up',
                    'C' => 'Proyek tetap akan gagal',
                    'D' => 'Biaya justru lebih mahal',
                    'E' => 'Pendekatan bertahap tidak mungkin'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Pendekatan bertahap (phased approach) memungkinkan: pilot testing, evaluasi, perbaikan, beban anggaran tersebar. Lebih aman daripada langsung all-in.'
            ],

            // ========== BLOK 3: MBG (8 Soal) ==========
            [
                'type' => 'mcq',
                'question_text' => 'MBG katanya untuk menurunkan stunting. Setelah 2 tahun jalan, anggarannya habis tapi angka stunting tidak turun signifikan. Kesimpulan apa yang bisa ditarik?',
                'options' => json_encode([
                    'A' => 'Program sukses karena anggarannya habis terserap',
                    'B' => 'Ada yang salah di desain atau pelaksanaannya, tujuannya sendiri tidak salah',
                    'C' => 'Stunting memang tidak bisa diatasi',
                    'D' => 'Tambah anggaran 10 kali lipat tanpa evaluasi',
                    'E' => 'Data stuntingnya pasti salah'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Anggaran terserap itu output, stunting turun itu outcome. Kalau outcome tidak tercapai, perlu dievaluasi: targetingnya salah? Kualitas makanannya kurang? Distribusinya bermasalah?'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'MBG berasumsi: "Anak stunting karena tidak makan di sekolah." Tapi ada fakta ilmiah yang bikin asumsi ini patut dipertanyakan. Apa itu?',
                'options' => json_encode([
                    'A' => 'Asumsinya benar',
                    'B' => 'Stunting terbentuk di 1000 hari pertama kehidupan (0-2 tahun), jauh sebelum anak masuk sekolah',
                    'C' => 'Semua anak stunting sudah bersekolah',
                    'D' => 'Makan di sekolah pasti mencegah stunting',
                    'E' => 'Tidak ada masalah dengan asumsi ini'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Fakta medis: stunting terbentuk di 1000 hari pertama, dari kehamilan sampai usia 2 tahun. Anak usia sekolah (6+ tahun) sudah terlambat. MBG lebih tepat untuk cegah anemia dan tingkatkan konsentrasi.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'MBG butuh: (1) data penerima yang akurat, (2) vendor makanan yang berkualitas, (3) distribusi tepat waktu, (4) pengawasan ketat. Kalau satu saja gagal, apa yang terjadi?',
                'options' => json_encode([
                    'A' => 'Program tetap sukses',
                    'B' => 'Seluruh sistem terancam: makanan bisa salah sasaran, kualitasnya jelek, atau tidak sampai',
                    'C' => 'Tidak ada dampak',
                    'D' => 'Komponen lain otomatis memperbaiki',
                    'E' => 'Kegagalan satu komponen tidak masalah'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Sistem kompleks itu rentan di titik terlemahnya. Data salah? Makanan ke orang yang tidak berhak. Vendor buruk? Makanan tidak bergizi. Distribusi gagal? Makanan basi.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'Dana MBG Rp71 T diambil dari anggaran infrastruktur. Coba pikir: kalau jalan di daerah terpencil tidak dibangun, apa dampak berantainya?',
                'options' => json_encode([
                    'A' => 'Tidak ada dampak, infrastruktur tidak penting',
                    'B' => 'Akses ekonomi tertutup, petani tidak bisa jual hasil panen, pendapatan rendah, anak tetap kurang gizi',
                    'C' => 'Daerah terpencil otomatis maju tanpa jalan',
                    'D' => 'Makanan gratis menggantikan semua kebutuhan',
                    'E' => 'Infrastruktur dan gizi tidak ada hubungannya'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Ironis: memotong infrastruktur bisa memperburuk masalah gizi. Tanpa jalan, petani tidak bisa jual hasil, pendapatan rendah, tidak mampu beli makanan bergizi.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'Untuk menilai keberhasilan MBG, indikator mana yang paling valid dan bisa dipertanggungjawabkan?',
                'options' => json_encode([
                    'A' => 'Jumlah foto anak makan yang diunggah ke medsos',
                    'B' => 'Penurunan angka anemia dan peningkatan nilai ujian anak penerima dibanding kelompok kontrol',
                    'C' => 'Jumlah porsi makanan yang didistribusikan',
                    'D' => 'Kepuasan vendor makanan',
                    'E' => 'Frekuensi berita positif di TV'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Indikator valid itu outcome yang terukur: anemia turun (hasil kesehatan), nilai ujian naik (hasil pendidikan), dengan kelompok pembanding. Jumlah porsi cuma output, bukan hasil.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'Ada yang bilang: "MBG pasti sukses karena niatnya baik." Apa kekeliruan dari pernyataan ini?',
                'options' => json_encode([
                    'A' => 'Pernyataannya logis',
                    'B' => 'Niat baik tidak menjamin hasil baik. Yang menentukan itu desain dan pelaksanaannya',
                    'C' => 'Tidak ada kekeliruan',
                    'D' => 'Niat baik selalu menghasilkan hasil baik',
                    'E' => 'Pelaksanaan tidak penting, yang penting niat'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Ini jebakan appeal to intention. Banyak kebijakan niatnya baik tapi gagal karena desain buruk atau pelaksanaan korup. Yang dinilai itu hasil, bukan niat.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'MBG rawan salah sasaran: keluarga mampu bisa ikut makan gratis. Solusi apa yang paling masuk akal untuk mengatasi ini?',
                'options' => json_encode([
                    'A' => 'Kasih ke semua orang tanpa seleksi',
                    'B' => 'Verifikasi pakai data DTKS, bukti penghasilan, mekanisme pengaduan, dan update data berkala',
                    'C' => 'Percaya saja pada kejujuran semua orang',
                    'D' => 'Andalkan laporan RT/RW saja',
                    'E' => 'Tidak perlu targeting, semua berhak'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Targeting efektif butuh verifikasi berlapis: data DTKS, means test (bukti penghasilan), mekanisme pengaduan kalau ada penyimpangan, dan update berkala.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'Selain bagi-bagi makanan gratis, cara lain yang lebih fundamental untuk atasi masalah gizi anak itu apa?',
                'options' => json_encode([
                    'A' => 'Makanan gratis sudah cukup',
                    'B' => 'Tingkatkan pendapatan keluarga miskin supaya mereka bisa beli makanan bergizi sendiri',
                    'C' => 'Tidak ada alternatif lain',
                    'D' => 'Impor semua makanan dari luar negeri',
                    'E' => 'Biarkan saja, nanti selesai sendiri'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Prinsipnya: beri kail, bukan ikan. Solusi fundamental itu meningkatkan pendapatan keluarga (akses kerja, pendidikan ibu, infrastruktur ekonomi) supaya mereka mandiri beli makanan bergizi.'
            ],

            // ========== BLOK 4: SATGAS PREMANISME (8 Soal) ==========
            [
                'type' => 'mcq',
                'question_text' => 'Premanisme marak karena: kemiskinan, pengangguran, backing dari oknum, dan hukum yang lemah. Untuk solusi jangka panjang, apa yang harus diprioritaskan?',
                'options' => json_encode([
                    'A' => 'Tangkap preman saja sudah cukup',
                    'B' => 'Atasi akar masalahnya: berdayakan ekonomi, tegakkan hukum konsisten, putus rantai backing',
                    'C' => 'Tidak ada yang bisa dilakukan',
                    'D' => 'Biarkan saja, sudah jadi budaya',
                    'E' => 'Perbanyak preman biar seimbang'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Tangkap preman itu cuma obati gejala. Solusi jangka panjang harus menyasar akar: ekonomi (supaya tidak perlu jadi preman), hukum (supaya ada efek jera), sistem (supaya backing terputus).'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'Coba ikuti alur ini: premanisme berhasil diberantas → biaya usaha turun → investor tertarik → lalu apa lagi?',
                'options' => json_encode([
                    'A' => 'Tidak ada perubahan',
                    'B' => 'Investasi naik → lapangan kerja bertambah → pengangguran turun → potensi orang jadi preman berkurang',
                    'C' => 'Investasi justru turun',
                    'D' => 'Premanisme bakal balik lebih kuat',
                    'E' => 'Investor tidak peduli soal premanisme'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Ini namanya siklus positif: keamanan meningkat → investasi masuk → lapangan kerja terbuka → pengangguran turun → kriminalitas berkurang → keamanan makin baik. Saling memperkuat.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'Banyak preman punya backing dari orang-orang berpengaruh. Kenapa ini jadi hambatan paling berat untuk diberantas?',
                'options' => json_encode([
                    'A' => 'Backing tidak berpengaruh',
                    'B' => 'Penegak hukum jadi takut atau tidak berdaya melawan orang berpengaruh, hukum tidak ditegakkan adil',
                    'C' => 'Backing justru membantu penegakan hukum',
                    'D' => 'Tidak ada hubungan backing dengan penegakan hukum',
                    'E' => 'Semua preman tidak punya backing'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Backing menciptakan kekebalan hukum. Preman yang punya backing sulit ditangkap karena ada tekanan dari atas. Ini merusak rule of law dan bikin preman lain makin berani.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'Satgas klaim sukses dengan menangkap 1000 preman bulan ini. Kenapa ini bukan ukuran keberhasilan yang tepat?',
                'options' => json_encode([
                    'A' => 'Indikatornya sudah tepat',
                    'B' => 'Jumlah tangkapan itu output (aktivitas), yang penting itu outcome: apakah pungli turun dan pengusaha merasa lebih aman',
                    'C' => 'Makin banyak tangkapan makin sukses',
                    'D' => 'Tidak perlu indikator',
                    'E' => 'Jumlah tangkapan satu-satunya indikator valid'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Jumlah tangkapan itu output. Yang penting itu outcome: apakah kasus pungli berkurang? Apakah pengusaha merasa lebih aman? Bisa saja tangkapan banyak tapi yang ditangkap cuma ikan kecil.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'Ada yang bilang: "Premanisme itu sudah budaya, tidak mungkin diberantas." Apa yang salah dari cara berpikir ini?',
                'options' => json_encode([
                    'A' => 'Argumennya benar, harus diterima',
                    'B' => 'Ini menyerah sebelum mencoba. Singapura, Taiwan, Korea berhasil mengurangi kejahatan terorganisir yang dulunya marak',
                    'C' => 'Premanisme memang kodrat manusia',
                    'D' => 'Budaya tidak bisa diubah',
                    'E' => 'Tidak perlu berusaha memberantas'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Ini defeatist fallacy: menyerah sebelum mencoba. Negara lain membuktikan kejahatan terorganisir bisa dikurangi drastis dengan strategi dan konsistensi yang tepat.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'Kalau Satgas berhasil berantas premanisme, siapa yang paling dirugikan?',
                'options' => json_encode([
                    'A' => 'Masyarakat umum',
                    'B' => 'Oknum yang selama ini dapat setoran dari preman',
                    'C' => 'Pengusaha yang tidak pernah diperas',
                    'D' => 'Investor asing',
                    'E' => 'Pekerja formal dengan gaji tetap'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Yang rugi kalau premanisme hilang: (1) preman itu sendiri, (2) oknum yang dapat setoran atau fee backing. Makanya resistensi terbesar datang dari dalam sistem.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'Satgas pilot project di Jawa Barat. Kalau berhasil, langkah selanjutnya yang paling tepat apa?',
                'options' => json_encode([
                    'A' => 'Langsung copy paste ke semua provinsi',
                    'B' => 'Evaluasi apa yang berhasil/gagal, sesuaikan dengan konteks lokal, lalu perluas bertahap',
                    'C' => 'Hentikan karena pilot sudah cukup',
                    'D' => 'Tidak perlu ekspansi',
                    'E' => 'Bubarkan Satgas'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Scaling up yang efektif: evaluasi lesson learned dari pilot, adaptasi konteks lokal (tiap daerah beda), ekspansi bertahap supaya terkontrol.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'Pedagang kecil diperas preman tapi takut melapor karena khawatir dibalas. Mekanisme apa yang dibutuhkan?',
                'options' => json_encode([
                    'A' => 'Pedagang harus berani sendiri',
                    'B' => 'Perlindungan pelapor: identitas dirahasiakan, hotline anonim, relokasi kalau perlu',
                    'C' => 'Tidak ada yang bisa dilakukan',
                    'D' => 'Bayar saja premannya',
                    'E' => 'Tutup usaha dan pindah'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Tanpa perlindungan, korban takut melapor dan premanisme terus berlanjut. Whistleblower protection: kerahasiaan identitas, hotline anonim, perlindungan fisik, relokasi kalau nyawa terancam.'
            ],

            // ========== BLOK 5: DANANTARA (8 Soal) ==========
            [
                'type' => 'mcq',
                'question_text' => 'Danantara akan kelola aset negara Rp14.000 T dengan beberapa pejabat yang rangkap jabatan. Risiko terbesar dari struktur begini apa?',
                'options' => json_encode([
                    'A' => 'Tidak ada risiko',
                    'B' => 'Conflict of interest: pejabat bisa buat keputusan yang menguntungkan posisinya di tempat lain',
                    'C' => 'Efisiensi meningkat',
                    'D' => 'Koordinasi lebih baik',
                    'E' => 'Rangkap jabatan selalu menguntungkan'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Conflict of interest terjadi kalau seseorang punya kepentingan ganda yang bisa bertentangan. Misalnya: sebagai pengawas sekaligus yang diawasi, bisa buat keputusan yang menguntungkan satu sisi tapi merugikan sisi lain.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'Kalau Danantara dikelola tidak transparan, apa dampak berantainya?',
                'options' => json_encode([
                    'A' => 'Kepercayaan publik meningkat',
                    'B' => 'Korupsi gampang disembunyikan → kerugian negara → APBN terbebani → layanan publik terganggu',
                    'C' => 'Tidak ada dampak',
                    'D' => 'Transparansi tidak penting untuk lembaga sebesar ini',
                    'E' => 'Ketidaktransparan justru melindungi aset'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Tanpa transparansi, pengawasan susah. Korupsi bisa tersembunyi sampai kerugian besar terungkap. Kerugian BUMN jadi beban APBN yang akhirnya ngurangin anggaran kesehatan, pendidikan.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'Ada yang bilang: "Danantara harus dikelola tertutup supaya rahasia bisnis tidak bocor ke kompetitor." Apa yang salah dari argumen ini?',
                'options' => json_encode([
                    'A' => 'Argumennya valid',
                    'B' => 'Ini mengalihkan isu. Yang diminta itu transparansi ke publik dan DPR, bukan buka rahasia dagang ke kompetitor',
                    'C' => 'Kerahasiaan total memang diperlukan',
                    'D' => 'Publik tidak berhak tahu',
                    'E' => 'Tidak ada yang perlu dievaluasi'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Ini straw man argument: mengalihkan isu. Transparansi yang diminta itu ke DPR, BPK, dan publik soal kinerja keuangan. Bukan buka rahasia dagang ke kompetitor. Dua hal berbeda.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'Temasek Singapura sukses karena: independen, profesional, transparan, diaudit ketat. Kalau Danantara TIDAK mengadopsi prinsip ini, apa yang kemungkinan terjadi?',
                'options' => json_encode([
                    'A' => 'Danantara bakal lebih sukses dari Temasek',
                    'B' => 'Risiko korupsi tinggi, kinerja buruk, kepercayaan rendah',
                    'C' => 'Tidak ada bedanya',
                    'D' => 'Prinsip Temasek tidak bisa diterapkan di Indonesia',
                    'E' => 'Indonesia tidak perlu belajar dari Singapura'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Best practice dari lembaga serupa yang sukses itu referensi valid. Kalau mengabaikan prinsip yang terbukti berhasil, risiko kegagalan meningkat. Belajar dari pengalaman orang lain itu cara efisien.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'Ada argumen: "Danantara perlu karena BUMN selama ini tidak efisien." Kalau premisnya benar, apakah kesimpulannya otomatis benar?',
                'options' => json_encode([
                    'A' => 'Kesimpulannya pasti benar',
                    'B' => 'Belum tentu. BUMN tidak efisien tidak otomatis berarti Danantara solusinya. Bisa jadi masalahnya di tata kelola BUMN sendiri',
                    'C' => 'Tidak perlu dianalisis',
                    'D' => 'Danantara pasti solusi semua masalah BUMN',
                    'E' => 'Premis dan kesimpulan selalu terhubung'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Ini non-sequitur: kesimpulan tidak otomatis ikut premis. Kalau BUMN tidak efisien, solusinya bisa: reformasi tata kelola langsung, privatisasi parsial, atau holding sektoral. Danantara bukan satu-satunya opsi.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'Danantara bisa menguntungkan atau merugikan tergantung pengelolaannya. Kondisi apa yang bikin Danantara menguntungkan?',
                'options' => json_encode([
                    'A' => 'Dikelola tertutup tanpa pengawasan',
                    'B' => 'Dikelola independen, profesional, transparan, ada pengawasan ketat, dan tidak boleh rangkap jabatan',
                    'C' => 'Dikelola untuk kepentingan politik jangka pendek',
                    'D' => 'Tidak perlu kondisi apapun, pasti untung',
                    'E' => 'Kondisi tidak mempengaruhi hasil'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Danantara itu alat, tergantung cara pakainya. Bisa menguntungkan kalau: independen dari politik, dikelola profesional (bukan titipan), transparan, dan ada checks and balances yang kuat.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'Supaya Danantara tidak jadi sarang korupsi, mekanisme pengawasan berlapis apa yang perlu diterapkan?',
                'options' => json_encode([
                    'A' => 'Diawasi presiden saja sudah cukup',
                    'B' => 'DPR (politik) + BPK (audit) + Dewan Pengawas Independen (profesional) + Laporan publik wajib',
                    'C' => 'Tidak perlu pengawasan, percaya saja',
                    'D' => 'Media sosial sudah cukup',
                    'E' => 'Pengawasan internal saja cukup'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Multi-layer oversight mencegah satu pihak berkuasa mutlak: DPR (wakil rakyat), BPK (profesional audit), Dewan Pengawas Independen (pakar non-politik), Laporan publik (transparansi). Checks and balances.'
            ],
            [
                'type' => 'mcq',
                'question_text' => 'Skenario terburuk: investasi Danantara rugi besar, misalnya Rp500 T. Siapa yang akhirnya menanggung kerugian?',
                'options' => json_encode([
                    'A' => 'Pengelola Danantara secara pribadi',
                    'B' => 'Rakyat Indonesia melalui APBN yang harus menambal kerugian',
                    'C' => 'Investor asing',
                    'D' => 'Tidak ada yang menanggung',
                    'E' => 'Kerugian hilang sendiri'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'BUMN/SWF itu milik negara. Kalau rugi besar dan perlu diselamatkan (bailout), dananya dari APBN yang sumbernya pajak rakyat. Jadi risiko akhir ditanggung rakyat lewat berkurangnya anggaran layanan publik.'
            ],
        ];

        foreach ($mcqs as &$mcq) {
            $mcq['created_at'] = now();
            $mcq['updated_at'] = now();
        }
        DB::table('questions')->insert($mcqs);

        // 3. SOAL ESSAY - HUMAN-WRITTEN STYLE (10 Soal)
        $essays = [
            [
                'type' => 'essay',
                'question_text' => 'Pemerintah punya uang terbatas dan harus pilih: (A) potong pendidikan Rp8 T buat program yang populer sekarang, atau (B) pertahankan pendidikan tapi program populer ditunda. Kalau kamu mikir dari sudut pandang keadilan untuk generasi mendatang, pilihan mana yang lebih fair? Jelaskan alasanmu.',
                'options' => null,
                'correct_answer' => 'Pendidikan prioritas karena keadilan antar-generasi. Anak cucu kita berhak dapat kesempatan yang sama.',
                'explanation' => 'Dinilai: pemahaman keadilan antar-generasi, pertimbangan jangka pendek vs panjang, kekuatan argumentasi.'
            ],
            [
                'type' => 'essay',
                'question_text' => 'Gambarkan rantai dampak kalau anggaran pendidikan dipotong Rp8 T. Mulai dari efek langsung, lalu terus ikuti sampai 20 tahun ke depan. Bagaimana ujung-ujungnya berdampak ke ekonomi nasional?',
                'options' => null,
                'correct_answer' => 'Anggaran turun → kualitas turun → SDM kurang kompeten → produktivitas rendah → daya saing lemah → ekonomi lambat.',
                'explanation' => 'Dinilai: kemampuan memetakan hubungan sebab-akibat, perspektif jangka panjang, pemahaman investasi SDM.'
            ],
            [
                'type' => 'essay',
                'question_text' => 'IKN sudah habiskan Rp50 T tapi sekarang digantung. Kasih 3 opsi keputusan yang mungkin diambil, jelaskan konsekuensi masing-masing, lalu rekomendasikan mana yang menurutmu paling tepat dan kenapa.',
                'options' => null,
                'correct_answer' => '(1) Lanjut dengan revisi skala, (2) Tunda dengan jadwal jelas, (3) Stop dan terima kerugian. Rekomendasikan dengan alasan.',
                'explanation' => 'Dinilai: kemampuan menyusun opsi, analisis konsekuensi, rekomendasi berbasis logika.'
            ],
            [
                'type' => 'essay',
                'question_text' => 'MBG berasumsi kalau anak stunting karena tidak makan di sekolah. Coba evaluasi asumsi ini secara kritis. Kalau asumsinya salah, apa implikasinya terhadap desain program?',
                'options' => null,
                'correct_answer' => 'Asumsi kurang valid. Stunting terbentuk 0-2 tahun (sebelum sekolah). MBG lebih tepat untuk anemia/konsentrasi.',
                'explanation' => 'Dinilai: kemampuan identifikasi asumsi, evaluasi validitas, implikasi untuk perbaikan.'
            ],
            [
                'type' => 'essay',
                'question_text' => 'Premanisme susah diberantas karena banyak yang punya backing dari oknum. Rancang strategi 4 langkah untuk memutus rantai kolusi ini secara sistematis.',
                'options' => null,
                'correct_answer' => '(1) Rotasi aparat, (2) Perlindungan pelapor, (3) Sanksi tegas untuk backing, (4) Pengawasan independen.',
                'explanation' => 'Dinilai: pemahaman masalah sistemik, solusi struktural, kelayakan implementasi.'
            ],
            [
                'type' => 'essay',
                'question_text' => 'Danantara kelola Rp14.000 T dengan pejabat yang rangkap jabatan. Identifikasi 3 risiko utama dan rancang cara mitigasinya masing-masing.',
                'options' => null,
                'correct_answer' => 'Risiko: (1) conflict of interest → larang rangkap, (2) korupsi → audit ketat, (3) kerugian → diversifikasi.',
                'explanation' => 'Dinilai: kemampuan identifikasi risiko, pemahaman tata kelola, solusi mitigasi.'
            ],
            [
                'type' => 'essay',
                'question_text' => 'Kalau kamu punya Rp71 T untuk atasi masalah gizi anak, selain bagi-bagi makanan gratis, strategi fundamental apa yang bisa dilakukan? Jelaskan logikanya.',
                'options' => null,
                'correct_answer' => 'Tingkatkan pendapatan keluarga miskin (lapangan kerja, pendidikan ibu, infrastruktur) supaya mandiri beli gizi.',
                'explanation' => 'Dinilai: berpikir melampaui yang obvious, solusi akar masalah, logika "ajarkan memancing vs beri ikan".'
            ],
            [
                'type' => 'essay',
                'question_text' => 'Dari kelima kebijakan (pendidikan, IKN, MBG, Satgas, Danantara), identifikasi pola kelemahan yang berulang muncul. Lalu kasih rekomendasi perbaikan untuk kebijakan publik Indonesia ke depan.',
                'options' => null,
                'correct_answer' => 'Pola: kurang studi kelayakan, minim transparansi, lemah akuntabilitas. Rekomendasi: evidence-based, partisipasi publik, audit ketat.',
                'explanation' => 'Dinilai: kemampuan sintesis, identifikasi pola, rekomendasi sistemik.'
            ],
            [
                'type' => 'essay',
                'question_text' => 'Sebagai warga biasa, bagaimana caranya kamu bisa efektif mengawasi kelima kebijakan ini? Kasih 4 cara konkret beserta alasan kenapa cara itu efektif.',
                'options' => null,
                'correct_answer' => '(1) Akses info PPID, (2) Lapor Ombudsman/KPK, (3) Aktif di LSM pemantau, (4) Diskusi konstruktif di medsos.',
                'explanation' => 'Dinilai: pemahaman partisipasi warga, mekanisme demokrasi, efektivitas tiap channel.'
            ],
            [
                'type' => 'essay',
                'question_text' => 'Dari kelima kebijakan, mana yang paling butuh perbaikan segera dan kenapa? Kasih rekomendasi konkret yang bisa diterapkan dalam 6 bulan.',
                'options' => null,
                'correct_answer' => 'Prioritas berdasarkan risiko x dampak. Contoh: Danantara (aset besar + tata kelola lemah = risiko tinggi).',
                'explanation' => 'Dinilai: kemampuan prioritas berbasis risiko, rekomendasi konkret dan terukur.'
            ],
        ];

        foreach ($essays as &$essay) {
            $essay['created_at'] = now();
            $essay['updated_at'] = now();
        }
        DB::table('questions')->insert($essays);
    }
}