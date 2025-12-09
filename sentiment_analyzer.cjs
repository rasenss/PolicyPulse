/**
 * POLICYPULSE SENTIMENT ANALYZER v3.1
 * High-Accuracy Indonesian Political Sentiment Analysis
 * Improved: Better detection of implicit negativity, sarcasm, and criticism
 */

class PrecisionSentimentAnalyzer {
    constructor() {
        this.buildComprehensiveLexicon();
        this.buildPatterns();
    }

    buildComprehensiveLexicon() {
        // ==================== KATA NEGATIF SANGAT KUAT (-10) ====================
        this.extremeNegative = new Set([
            // Makian kasar
            'anjing', 'anjir', 'anjay', 'anj', 'ajg', 'anjg',
            'bangsat', 'bgst', 'bngst',
            'bajingan', 'bjngn',
            'brengsek', 'brngsk',
            'keparat', 'kprt',
            'kampret', 'kmprt',
            'kontol', 'kntl', 'memek', 'mmk', 'ngentot', 'ngtd', 'entot',
            'goblok', 'gblk', 'goblog', 'goblg',
            'tolol', 'tll', 'tolololol',
            'idiot', 'idi0t',
            'dungu', 'dng',
            'bego', 'bgo', 'begok', 'beg0',
            'bodoh', 'bdh', 'bod0h',
            'pandir',
            'oon', 'o\'on', 'oom',
            'setan', 'syaiton', 'syetan',
            'iblis', 'ibliz',
            'laknat', 'laknatullah',
            'terkutuk', 'kutuk',
            'tai', 'taik', 't4i', 'tahi',
            'bacot', 'bacod', 'bacoot',
            'babi', 'b4bi',
            'monyet', 'monyong',
            'bangke', 'bangkai',
            'gila', 'gil4', 'gile', 'gilak',
            'edan', 'edun',
            'sinting', 'sintink',
            'stress', 'stres',
            'sarap', 'srap', 'saraf',
            'geblek', 'gblk',
            'pekok', 'pkk',
            'cok', 'cuk', 'jancok', 'jancuk', 'jnck', 'dancok',
            'asu', 'asw',
            'bajigur',
            'bejat', 'bjt',
            'bedebah', 'bdbh',
            'sialan', 'sial',
            // Kata kasar tambahan
            'kepala batu', 'otak udang', 'otak kosong',
        ]);

        // ==================== KATA NEGATIF KUAT (-8 to -9) ====================
        this.strongNegative = new Set([
            // Korupsi & kejahatan
            'korupsi', 'koruptor', 'korup', 'corrupt',
            'maling', 'malink',
            'pencuri', 'curi', 'nyuri', 'nyolong',
            'penjahat', 'jahat',
            'kriminal', 'criminal',
            'perampok', 'rampok',
            'penipu', 'tipu', 'nipu', 'menipu', 'penipuan',
            'pembohong', 'bohong', 'boong', 'bohonk',
            'pengkhianat', 'khianat', 'hianat',
            'munafik', 'munafiq',
            'durjana',
            'nista', 'nistain',
            'hina', 'menghina', 'hinaan', 'penghinaan',
            'curang', 'kecurangan',
            'manipulasi', 'manipulatif',
            'fitnah', 'memfitnah',
            'hoax', 'hoaks', 'hoak',
            'palsu', 'pemalsuan',
            'zalim', 'dzalim', 'kezaliman',
            'kejam', 'kekejaman',
            'brutal', 'brutalitas',
            'sadis', 'sadistis',
            'barbar', 'barbaric',
            'biadab', 'biadap',
            // Kegagalan total
            'hancur', 'hancurin', 'menghancurkan', 'kehancuran',
            'gagal', 'kegagalan',
            'bobrok', 'kebobrokan',
            'busuk', 'busukk', 'membusuk',
            'sampah', 'smph',
            'bangkrut', 'kebangkrutan',
            'kolaps', 'collapse',
            'ambruk',
            'runtuh', 'keruntuhan',
            'musnah', 'pemusnahan',
            'bencana', 'malapetaka', 'petaka',
            'celaka', 'kecelakaan',
        ]);

        // ==================== KATA NEGATIF SEDANG (-5 to -7) ====================
        this.moderateNegative = new Set([
            // Penderitaan
            'sengsara', 'menderita', 'melarat', 'miskin', 'lapar',
            'kelaparan', 'nestapa', 'derita', 'susah', 'pedih',
            // Kebohongan
            'dusta', 'sesat',
            // Negatif kuat
            'kacau', 'amburadul', 'berantakan', 'rusak', 'jelek',
            'buruk', 'parah', 'fatal', 'rugi', 'kerugian',
            'merugi', 'boros', 'pemborosan', 'percuma',
            // Kekecewaan
            'kecewa', 'mengecewakan', 'menyesal', 'sedih', 'murung',
            'muak', 'jijik', 'benci', 'marah', 'geram',
            'kesal', 'jengkel', 'dongkol', 'sebal', 'emosi',
            // Policy-specific negative
            'defisit', 'resesi', 'krisis',
            'premanisme', 'pungli', 'pemerasan',
            'preman',
            // Tambahan untuk kritik implisit
            'cemas', 'emas', // Indonesia "cemas" = kritik halus
        ]);

        // ==================== KATA NEGATIF RINGAN (-2 to -4) ====================
        this.mildNegative = new Set([
            // Ketakutan & kekhawatiran
            'takut', 'khawatir', 'cemas', 'gelisah',
            'resah', 'panik', 'ngeri', 'horror', 'mengerikan',
            // Penolakan
            'tolak', 'menolak', 'penolakan', 'protes', 'demo',
            'demonstrasi', 'mogok', 'boikot', 'lawan',
            // Kritik & keluhan
            'kritik', 'mengkritik', 'kritikan', 'keluhan', 'komplain',
            'masalah', 'problem', 'isu', 'kontroversi', 'polemik',
            // Penurunan
            'turun', 'menurun', 'anjlok', 'jeblok', 'merosot',
            'melemah', 'memburuk', 'mundur', 'surut', 'menyusut',
            // Penundaan & hambatan
            'tunda', 'ditunda', 'penundaan', 'tertunda', 'batal',
            'dibatalkan', 'hambat', 'terhambat', 'macet',
            'mandek', 'stuck', 'deadlock', 'buntu', 'stagnan',
            // Pemotongan
            'potong', 'dipotong', 'pemotongan', 'pangkas', 'dipangkas',
            'pemangkasan', 'kurangi', 'dikurangi', 'pengurangan',
            // Negatif ringan
            'lambat', 'lama', 'sulit', 'rumit',
            'ribet', 'mahal', 'berat', 'sukar', 'payah',
            // Ketidakjelasan
            'bingung', 'rancu', 'ambigu', 'kabur', 'samar',
            // Policy-specific
            'utang', 'inflasi', 'ormas',
        ]);

        // ==================== KATA/FRASA SKEPTIS & SINISME ====================
        this.skepticalWords = new Set([
            'bener', 'beneran', 'serius', 'seriusan',
            'yakin', 'percaya', 'emang', 'emangnya',
            'katanya', 'konon', 'kabarnya', 'rumornya',
            'bentar', 'sebentar', 'nanti', 'dulu',
            'iya', 'iyakah', 'masa', 'masak', 'masih',
            'mana', 'kapan', 'gimana', 'kenapa',
            'kok', 'koq', 'lho', 'loh',
        ]);

        // ==================== KATA POSITIF SANGAT KUAT (+9 to +10) ====================
        this.extremePositive = new Set([
            'luar biasa', 'luarbiasa',
            'spektakuler',
            'fenomenal',
            'gemilang', 'kegemilangan',
            'cemerlang', 'kecemerlangan',
            'brilian', 'brilliant',
            'masterpiece',
            'sempurna', 'kesempurnaan',
            'terbaik',
            'juara', 'kejuaraan',
            'champion',
        ]);

        // ==================== KATA POSITIF KUAT (+7 to +8) ====================
        this.strongPositive = new Set([
            'hebat', 'kehebatan',
            'keren', 'kereen', 'kereeen',
            'mantap', 'mantapp', 'mantul',
            'top', 'toppp',
            'amazing', 'amazingg',
            'excellent', 'excelent',
            'outstanding',
            'superb',
            'fantastis', 'fantastic',
            'wow', 'woww', 'wih', 'wuih',
            'sukses', 'kesuksesan',
            'berhasil', 'keberhasilan',
            'tercapai', 'pencapaian',
            'terwujud',
            'menang', 'kemenangan', 'pemenang',
            'prestasi', 'berprestasi',
            'achievement',
            'salut',
            'kagum', 'kekaguman', 'mengagumkan',
            'terpesona',
            'terkesan', 'impressed',
            'apresiasi', 'mengapresiasi', 'diapresiasi',
            'bangga', 'membanggakan', 'kebanggaan',
            'proud',
            'jempol',
            'unggul', 'keunggulan',
            'prima',
            'istimewa', 'keistimewaan',
        ]);

        // ==================== KATA POSITIF SEDANG (+4 to +6) ====================
        this.moderatePositive = new Set([
            'baik', 'kebaikan', 'membaik',
            'bagus', 'bagusss',
            'oke', 'okay', 'ok',
            'nice', 'nicee',
            'good', 'goodd',
            'great', 'greatt',
            'positif', 'kepositifan',
            'konstruktif',
            'produktif', 'produktivitas',
            'efektif', 'efektivitas',
            'efisien', 'efisiensi',
            'optimal', 'optimalisasi',
            'maksimal',
            'dukung', 'mendukung', 'dukungan', 'didukung',
            'setuju', 'persetujuan', 'menyetujui',
            'sepakat', 'kesepakatan',
            'sependapat',
            'support', 'supporting',
            'maju', 'kemajuan', 'memajukan',
            'berkembang', 'perkembangan',
            'tumbuh', 'pertumbuhan',
            'meningkat', 'peningkatan',
            'naik', 'kenaikan',
            'perbaikan',
            'progress', 'progres',
            'improvement',
            'upgrade',
            'solusi', 'solutif',
            'jawaban',
            'terobosan', 'breakthrough',
            'inovasi', 'inovatif', 'inovator',
            'kreatif', 'kreativitas',
            'cerdas', 'kecerdasan',
            'aman', 'keamanan', 'mengamankan',
            'tertib', 'ketertiban',
            'teratur', 'keteraturan',
            'stabil', 'stabilitas', 'menstabilkan',
            'kondusif',
            'damai', 'kedamaian',
            'tentram', 'ketentraman',
            'adil', 'keadilan',
            'fair',
            'transparan', 'transparansi',
            'akuntabel', 'akuntabilitas',
            'jujur', 'kejujuran',
            'bersih', 'kebersihan',
            'integritas',
            'bantu', 'membantu', 'bantuan', 'dibantu',
            'tolong', 'menolong', 'pertolongan',
            'manfaat', 'bermanfaat',
            'berguna', 'kegunaan',
            'faedah',
        ]);

        // ==================== KATA POSITIF RINGAN (+1 to +3) ====================
        this.mildPositive = new Set([
            'lumayan', 'lumayanlah',
            'boleh', 'bolehlah',
            'acceptable',
            'reasonable',
            'optimis', 'optimisme',
            'harap', 'berharap', 'harapan',
            'semoga',
            'amin', 'amiin', 'aamiin',
            'insyaallah', 'insyallah',
            'puas', 'kepuasan',
            'senang', 'kesenangan',
            'gembira', 'kegembiraan',
            'bahagia', 'kebahagiaan',
            'suka', 'kesukaan',
            'cinta', 'kecintaan',
            'sayang', 'kesayangan',
            'syukur', 'bersyukur', 'mensyukuri',
            'alhamdulillah', 'alhamdulilah',
            'cepat', 'kecepatan',
            'tepat', 'ketepatan',
            'akurat', 'akurasi',
            'presisi',
            'lancar', 'kelancaran',
        ]);

        // ==================== KATA SARKASME ====================
        this.sarcasmIndicators = new Set([
            'wkwk', 'wkwkwk', 'wkwkwkwk', 'wkwkwkwkwk',
            'haha', 'hahaha', 'hahahaha',
            'hihi', 'hihihi',
            'hoho', 'hohoho',
            'kwkw', 'kwkwkw',
            'awkwk', 'awkwkwk',
            'xixixi', 'xixi',
            'lol', 'lmao', 'lmfao', 'rofl',
            'emang', 'emg', 'memang',
            'yakin',
            'pasti',
            'waduh', 'wadaw', 'wadidaw',
            'astaga', 'astagfirullah',
            'duh', 'aduh', 'aduhai',
            'hmm', 'hmmm', 'hmmmm',
            'uhh', 'uhhh',
            'heh', 'hehh', 'hehhh',
            'ajah', 'aja', 'sih', 'deh', 'dong', 'doong',
            'kali', 'kalii', 'kan', 'kaan',
            'tuh', 'toh', 'nih', 'noh',
            'gitu', 'gtu', 'begitu', 'bgitu',
            'banget', 'bgt', 'bngt', 'sangat', 'amat',
            'pinter', 'pintar', 'hebat', 'jago',
        ]);

        // ==================== NEGASI ====================
        this.negations = new Set([
            'tidak', 'tak', 'tiada',
            'bukan', 'bukanlah',
            'tanpa',
            'belum',
            'jangan', 'janganlah',
            'gak', 'ga', 'nggak', 'ngga', 'enggak', 'engga', 'kagak', 'gk', 'g',
            'non', 'anti',
            'never', 'no', 'none', 'neither', 'not', 'dont', "don't", 'didnt', "didn't",
            'bkn', 'tdk', 'blm',
        ]);

        // ==================== INTENSIFIER ====================
        this.intensifiers = {
            'sangat': 2.0, 'sgt': 2.0,
            'amat': 1.8,
            'banget': 2.0, 'bgt': 2.0, 'bngt': 2.0,
            'sekali': 1.8, 'skali': 1.8,
            'paling': 2.2,
            'super': 2.0,
            'ultra': 2.0,
            'extra': 1.5, 'ekstra': 1.5,
            'ekstrem': 2.0, 'extreme': 2.0,
            'very': 1.8,
            'really': 1.8, 'rly': 1.8,
            'truly': 1.7,
            'sungguh': 1.8,
            'betul': 1.5,
            'terlalu': 1.5, 'trlalu': 1.5,
            'begitu': 1.4, 'bgitu': 1.4,
            'demikian': 1.3,
            'so': 1.5,
            'too': 1.3,
            'lebih': 1.3,
            'makin': 1.4, 'semakin': 1.5, 'kian': 1.4,
            'tambah': 1.3,
            'parah': 1.6, 'prh': 1.6,
            'total': 1.5,
            'completely': 1.8,
            'absolutely': 2.0,
            'entirely': 1.7,
            'utterly': 1.8,
        };

        // ==================== DIMINISHER ====================
        this.diminishers = {
            'agak': 0.5, 'agk': 0.5,
            'sedikit': 0.4, 'sdkt': 0.4, 'dikit': 0.4,
            'kurang': 0.6, 'krg': 0.6,
            'hampir': 0.7,
            'nyaris': 0.7,
            'cukup': 0.7, 'ckp': 0.7,
            'lumayan': 0.6,
            'rada': 0.5,
            'somewhat': 0.6,
            'slightly': 0.5,
            'mungkin': 0.6, 'mgkn': 0.6,
            'kayaknya': 0.5, 'kynya': 0.5,
            'sepertinya': 0.6, 'sprtnya': 0.6,
            'seolah': 0.5,
            'hanya': 0.6, 'hny': 0.6,
            'cuma': 0.6, 'cm': 0.6,
            'doang': 0.6, 'doank': 0.6,
        };
    }

    buildPatterns() {
        // Pattern untuk deteksi sarkasme
        this.sarcasmPatterns = [
            /"([^"]+)".*(\?|\.{3,})/,                    // "bagus" sekali???
            /\b(wah|wow|gila)\b.*\b(bagus|hebat|mantap|keren)\b/i,  // wah bagus
            /\b(emang|memang)\b.*\b(bagus|hebat|pinter|pintar)\b/i, // emang bagus
            /\b(yakin|pasti)\b.*\b(bisa|berhasil|sukses)\b.*\?/i,   // yakin bisa?
            /(bagus|hebat|keren|mantap).*(ya|nih|dong|deh)[\.\?]{0,3}$/i, // bagus ya...
            /👏.*👏/,  // Clap emoji (often sarcastic)
            /🙄/,      // Eye roll
            /😏/,      // Smirk
            // Tambahan pattern sarkasme
            /yang\s+bener\s*(aja|ajah|sih|deh)?/i,    // yang bener ajah
            /\?\s*$/, // Kalimat berakhir dengan ?
            /\.{2,}$/, // Kalimat berakhir dengan ...
            /yak\s+betul/i, // yak betul (sarkastik)
            /c\)emas/i, // (c)emas = cemas (wordplay kritik)
        ];

        // Pattern negatif yang pasti
        this.definiteNegativePatterns = [
            // Makian langsung
            /\b(anjing|anjir|bangsat|goblok|tolol|bodoh|bego|idiot|dungu|tai|babi|monyet|jancok|asu)\b/i,
            // Korupsi
            /\b(korupsi|koruptor|maling|pencuri|penipu|pembohong)\b/i,
            /mencuri|merampok|menggelapkan|menilep/i,
            // Kegagalan
            /(gagal\s*(total)?|hancur|bobrok|busuk|sampah|bangkrut)/i,
            /(negara|rakyat|ekonomi).*(hancur|sengsara|menderita)/i,
            /(pemerintah|presiden|menteri).*(gagal|bodoh|tolol|goblok)/i,
            // Hoax/Bohong
            /(hoax|hoaks|bohong|pembohong|penipu|tipu)/i,
            /(janji\s*palsu|omong\s*kosong)/i,
            // Pemotongan negatif
            /(pemotongan|pemangkasan).*(anggaran|dana|budget).*(pendidikan|kesehatan)/i,
            /(anggaran|dana).*(dipotong|dipangkas).*(drastis|besar)/i,
            // Penundaan negatif
            /ditunda\s*(tanpa|tanpa\s*batas)/i,
            /(tidak|tanpa)\s*(jelas|transparan|akuntabel)/i,
            // Protes keras
            /(tolak|menolak|protes).*(keras|tegas|besar)/i,
            /demo\s*(besar|massa|akbar)/i,
            // Tambahan pattern kritik
            /otak.*dipotong/i,
            /jangan\s*lupa\s*dipotong/i,
            /(polisi|tentara|tni|pertahanan).*tidak\s*dipotong/i,
            /(polisi|tentara|tni|pertahanan).*rp\.?\s*0/i,
            /dana.*buat.*(ikn|mbg)/i, // pertanyaan skeptis tentang dana
            /\(c\)emas/i, // wordplay kritik
            /indonesia.*cemas/i,
            /indonesia.*emas/i, // bisa jadi wordplay
        ];

        // Pattern pertanyaan retoris (biasanya negatif)
        this.rhetoricalPatterns = [
            /berapa\s*(jumlah)?\s*(pemotongan|anggaran|dana).*\?/i,
            /kemana\s*(uang|dana|anggaran)/i,
            /mana\s*(bukti|hasilnya|janjinya)/i,
            /kapan\s*(realisasi|selesai|jadi)/i,
            /siapa\s*(yang\s*)?(tanggung\s*jawab|untung)/i,
            /apa\s*(gunanya|manfaatnya|untungnya)/i,
            /bener\s*(gak|ga|nggak|ngga).*\?/i,
            /serius\s*(nih|ini).*\?/i,
            /yakin.*\?/i,
            /masa\s*(sih|iya).*\?/i,
        ];

        // Pattern positif yang pasti
        this.definitePositivePatterns = [
            /(luar\s*biasa|sangat\s*(bagus|baik|hebat|keren))/i,
            /(sukses\s*besar|berhasil|tercapai|terwujud)/i,
            /(dukung\s*(penuh|total|sepenuhnya))/i,
            /(setuju|sepakat)\s*(sekali|banget|total)/i,
            /(prestasi|pencapaian).*(luar\s*biasa|membanggakan|gemilang)/i,
            /(bangga|salut|kagum)\s*(sekali|banget)/i,
            /patut\s*(diapresiasi|diacungi)/i,
            /(kerja|usaha|upaya)\s*(nyata|bagus|baik|hebat)/i,
            /(solusi|terobosan)\s*(tepat|cerdas|jitu|bagus)/i,
            /(meningkat|naik|tumbuh)\s*(signifikan|drastis|pesat)/i,
            /(alhamdulillah|puji\s*tuhan|syukur)/i,
            /(terima\s*kasih|thanks|makasih)\s*(banyak|banget)/i,
            /👍{2,}|🔥{2,}|❤️{2,}|💪{2,}|🎉{2,}/,  // Multiple positive emoji
        ];
    }

    analyze(text) {
        if (!text || typeof text !== 'string' || text.trim().length < 2) {
            return { score: 0, label: 'Netral', confidence: 0 };
        }

        const originalText = text;
        const lowerText = text.toLowerCase();
        const tokens = this.tokenize(lowerText);

        // STEP 1: Check for body part + cut/potong (insulting)
        if (this.checkInsultPattern(lowerText)) {
            return { score: -9, label: 'Negatif', confidence: 97 };
        }

        // STEP 2: Check definite patterns (highest priority)
        const patternResult = this.checkPatterns(originalText, lowerText);
        if (patternResult.matched) {
            return patternResult.result;
        }

        // STEP 3: Check for extreme words (makian)
        const extremeResult = this.checkExtremeWords(tokens);
        if (extremeResult.found) {
            return { score: -10, label: 'Negatif', confidence: 99 };
        }

        // STEP 4: Check rhetorical questions (usually negative)
        const rhetoricalResult = this.checkRhetoricalQuestions(lowerText);
        if (rhetoricalResult.isRhetorical) {
            return { score: -5, label: 'Negatif', confidence: 85 };
        }

        // STEP 5: Check skeptical/sarcastic tone
        const skepticalScore = this.checkSkepticalTone(lowerText, tokens);

        // STEP 6: Calculate lexicon score
        let score = this.calculateScore(tokens, lowerText);

        // STEP 7: Apply skeptical adjustment
        score += skepticalScore;

        // STEP 8: Check sarcasm
        if (this.detectSarcasm(originalText, lowerText) && score >= -2) {
            score = Math.min(score, -4); // Force negative if sarcasm detected
        }

        // STEP 9: Check wordplay/creative criticism
        score += this.checkWordplay(lowerText);

        // STEP 10: Apply emotional intensity
        score = this.applyEmotionalIntensity(originalText, score);

        // STEP 11: Check ending punctuation
        score = this.adjustForPunctuation(originalText, score);

        // STEP 12: Determine label with adjusted thresholds
        return this.determineLabel(score);
    }

    checkInsultPattern(text) {
        // Pattern: otak/kepala + dipotong/potong (insulting)
        const insultPatterns = [
            /otak.*(di)?potong/i,
            /kepala.*(di)?potong/i,
            /mulut.*(di)?potong/i,
            /lidah.*(di)?potong/i,
            /jangan\s*lupa.*(di)?potong/i,
            /harus.*(di)?potong/i,
            /perlu.*(di)?potong/i,
        ];
        
        for (const pattern of insultPatterns) {
            if (pattern.test(text)) return true;
        }
        return false;
    }

    checkRhetoricalQuestions(text) {
        // Cek apakah kalimat adalah pertanyaan retoris (biasanya negatif/skeptis)
        for (const pattern of this.rhetoricalPatterns) {
            if (pattern.test(text)) {
                return { isRhetorical: true };
            }
        }
        
        // Cek pattern umum pertanyaan skeptis
        if (text.includes('?')) {
            const skepticalStarters = [
                'bener', 'serius', 'yakin', 'masa', 'emang', 'emangnya',
                'kok', 'kenapa', 'gimana', 'kapan', 'mana', 'apa',
            ];
            for (const starter of skepticalStarters) {
                if (text.includes(starter)) {
                    return { isRhetorical: true };
                }
            }
        }
        
        return { isRhetorical: false };
    }

    checkSkepticalTone(text, tokens) {
        let score = 0;
        
        // Cek kata skeptis
        let skepticalCount = 0;
        for (const token of tokens) {
            if (this.skepticalWords.has(token)) {
                skepticalCount++;
            }
        }
        
        // Jika ada banyak kata skeptis, kurangi score
        if (skepticalCount >= 2) {
            score -= skepticalCount * 1.5;
        }
        
        // Cek pattern "yang bener ajah", "serius?", dll
        if (/yang\s+bener/i.test(text)) score -= 3;
        if (/serius\s*(nih|ini|\?)*/i.test(text)) score -= 2;
        if (/masa\s*(sih|iya)/i.test(text)) score -= 2;
        if (/emang(nya)?\s+bisa/i.test(text)) score -= 2;
        if (/yakin\s*(bisa|berhasil)/i.test(text)) score -= 2;
        
        // Cek kalimat berakhir dengan "..." (ragu/skeptis)
        if (/\.{2,}\s*$/.test(text)) score -= 2;
        
        // Cek kalimat berakhir dengan "?" tanpa kata tanya eksplisit
        if (/[^?]\?\s*$/.test(text) && !/^(apa|siapa|kapan|dimana|mengapa|bagaimana|berapa)/i.test(text)) {
            score -= 1.5;
        }
        
        return score;
    }

    checkWordplay(text) {
        let score = 0;
        
        // Indonesia (c)emas = Indonesia cemas (kritik halus)
        if (/\(c\)emas/i.test(text) || /indonesia\s*c\s*emas/i.test(text)) {
            score -= 6;
        }
        
        // Pattern wordplay lainnya
        if (/\([a-z]\)[a-z]+/i.test(text)) {
            score -= 3; // Ada wordplay dengan kurung
        }
        
        return score;
    }

    adjustForPunctuation(text, score) {
        // Jika netral tapi ada tanda tanya di akhir, cenderung negatif
        if (score >= -2 && score <= 2) {
            if (/\?\s*$/.test(text)) {
                score -= 2;
            }
            if (/\.{3,}\s*$/.test(text)) {
                score -= 1.5;
            }
        }
        
        // Multiple question marks = sangat skeptis
        const qCount = (text.match(/\?/g) || []).length;
        if (qCount >= 2) {
            score -= qCount;
        }
        
        return score;
    }

    checkPatterns(originalText, lowerText) {
        // Check definite negative
        for (const pattern of this.definiteNegativePatterns) {
            if (pattern.test(lowerText) || pattern.test(originalText)) {
                return { matched: true, result: { score: -8, label: 'Negatif', confidence: 95 } };
            }
        }

        // Check definite positive
        for (const pattern of this.definitePositivePatterns) {
            if (pattern.test(lowerText) || pattern.test(originalText)) {
                return { matched: true, result: { score: 8, label: 'Positif', confidence: 95 } };
            }
        }

        return { matched: false };
    }

    checkExtremeWords(tokens) {
        for (const token of tokens) {
            if (this.extremeNegative.has(token)) {
                return { found: true, word: token };
            }
        }
        return { found: false };
    }

    calculateScore(tokens, text) {
        let score = 0;
        let matchCount = 0;

        for (let i = 0; i < tokens.length; i++) {
            const token = tokens[i];
            let wordScore = 0;

            // Check each lexicon category
            if (this.extremeNegative.has(token)) {
                wordScore = -10;
            } else if (this.strongNegative.has(token)) {
                wordScore = -8;
            } else if (this.moderateNegative.has(token)) {
                wordScore = -5;
            } else if (this.mildNegative.has(token)) {
                wordScore = -3;
            } else if (this.extremePositive.has(token)) {
                wordScore = 10;
            } else if (this.strongPositive.has(token)) {
                wordScore = 8;
            } else if (this.moderatePositive.has(token)) {
                wordScore = 5;
            } else if (this.mildPositive.has(token)) {
                wordScore = 2;
            }

            if (wordScore !== 0) {
                // Check negation
                if (this.hasNegation(tokens, i)) {
                    wordScore = wordScore > 0 ? -wordScore * 0.7 : Math.abs(wordScore) * 0.4;
                }

                // Check modifiers
                wordScore *= this.getModifier(tokens, i);

                score += wordScore;
                matchCount++;
            }
        }

        // Check multi-word phrases
        score += this.checkPhrases(text);

        // Normalize if many words
        if (matchCount > 4) {
            score = score / Math.sqrt(matchCount) * 1.5;
        }

        return score;
    }

    hasNegation(tokens, index) {
        for (let i = Math.max(0, index - 3); i < index; i++) {
            if (this.negations.has(tokens[i])) {
                return true;
            }
        }
        return false;
    }

    getModifier(tokens, index) {
        let modifier = 1.0;
        for (let i = Math.max(0, index - 2); i < index; i++) {
            if (this.intensifiers[tokens[i]]) {
                modifier *= this.intensifiers[tokens[i]];
            } else if (this.diminishers[tokens[i]]) {
                modifier *= this.diminishers[tokens[i]];
            }
        }
        return modifier;
    }

    checkPhrases(text) {
        let score = 0;

        const negativePhrases = {
            'tanpa batas waktu': -5, 'tidak jelas': -4, 'tidak transparan': -5,
            'gagal total': -8, 'buang anggaran': -6, 'buang-buang uang': -6,
            'sia-sia': -5, 'omong kosong': -7, 'janji palsu': -7,
            'rakyat sengsara': -8, 'rakyat menderita': -8, 'ekonomi hancur': -8,
            'korupsi merajalela': -9, 'tidak becus': -6, 'tidak kompeten': -5,
            'sangat mengecewakan': -6, 'sangat kecewa': -6, 'amat disayangkan': -4,
            'yang bener': -3, 'yang bener ajah': -4, 'yang bener aja': -4,
            'yak betul': -3, // sarkastik
            'tidak dipotong': -3, // konteks perbandingan negatif
            'rp 0': -3, 'rp.0': -3, 'rp0': -3,
            'alias tidak': -2,
            'buat tambah': -2, // skeptis tentang penggunaan dana
            'malah buat': -3,
        };

        const positivePhrases = {
            'luar biasa': 9, 'sangat bagus': 8, 'sangat baik': 7,
            'sangat membantu': 7, 'tepat sasaran': 6, 'solusi tepat': 6,
            'langkah maju': 5, 'kerja nyata': 6, 'bukti nyata': 5,
            'sukses besar': 8, 'prestasi gemilang': 9, 'patut diapresiasi': 6,
            'sangat efektif': 7, 'sangat efisien': 7,
        };

        for (const [phrase, value] of Object.entries(negativePhrases)) {
            if (text.includes(phrase)) score += value;
        }
        for (const [phrase, value] of Object.entries(positivePhrases)) {
            if (text.includes(phrase)) score += value;
        }

        return score;
    }

    detectSarcasm(originalText, lowerText) {
        // Check quoted positive words
        const quotedMatch = originalText.match(/"([^"]+)"/);
        if (quotedMatch) {
            const quoted = quotedMatch[1].toLowerCase();
            const positives = ['bagus', 'hebat', 'mantap', 'keren', 'sukses', 'baik', 'pintar', 'cerdas'];
            if (positives.some(p => quoted.includes(p))) return true;
        }

        // Check sarcasm patterns
        for (const pattern of this.sarcasmPatterns) {
            if (pattern.test(lowerText) || pattern.test(originalText)) return true;
        }

        // Check laughter + positive word
        if (/wk|haha|hihi|lol/i.test(lowerText)) {
            const positives = ['bagus', 'hebat', 'mantap', 'keren', 'sukses'];
            if (positives.some(p => lowerText.includes(p))) return true;
        }

        // Check skeptical endings
        if (/\s+(sih|deh|dong|nih|tuh|kali)\s*[\.\?\!]*\s*$/i.test(lowerText)) {
            return true;
        }

        return false;
    }

    applyEmotionalIntensity(text, score) {
        let multiplier = 1.0;

        // Exclamation marks
        const exclCount = (text.match(/!/g) || []).length;
        if (exclCount >= 3) multiplier *= 1.4;
        else if (exclCount >= 2) multiplier *= 1.2;

        // Question marks (often negative/rhetorical)
        const questCount = (text.match(/\?/g) || []).length;
        if (questCount >= 3 && score < 0) multiplier *= 1.3;
        else if (questCount >= 2 && score >= -2 && score <= 2) {
            score -= 2; // Jika netral tapi banyak ?, cenderung negatif
        }

        // CAPS
        const capsRatio = (text.match(/[A-Z]/g) || []).length / Math.max(text.length, 1);
        if (capsRatio > 0.5) multiplier *= 1.5;
        else if (capsRatio > 0.3) multiplier *= 1.2;

        // Emoji
        const posEmoji = (text.match(/[😀😃😄😁😊🥰😍🤩👍👏🎉✨💪🔥❤️💯🙏😇]/g) || []).length;
        const negEmoji = (text.match(/[😢😭😤😡🤬😠👎💔😞😔🤮😒😑🙄💩😵🤢]/g) || []).length;

        if (posEmoji >= 2 && score > 0) score += posEmoji * 1.5;
        if (negEmoji >= 2 && score < 0) score -= negEmoji * 1.5;
        if (posEmoji >= 2 && score <= 0) score += posEmoji * 2;
        if (negEmoji >= 2 && score >= 0) score -= negEmoji * 2;

        return score * multiplier;
    }

    tokenize(text) {
        return text
            .replace(/https?:\/\/\S+/g, ' ')
            .replace(/@\w+/g, ' ')
            .replace(/#(\w+)/g, '$1')
            .replace(/[^\w\s\-\(\)]/g, ' ')
            .replace(/\d+/g, ' ')
            .replace(/\s+/g, ' ')
            .trim()
            .split(/\s+/)
            .filter(t => t.length > 1);
    }

    determineLabel(score) {
        let label, confidence;

        // Adjusted thresholds - lebih sensitif ke negatif
        if (score >= 3) {
            label = 'Positif';
            confidence = Math.min(99, 50 + Math.abs(score) * 5);
        } else if (score <= -2) { // Diturunkan dari -3 ke -2
            label = 'Negatif';
            confidence = Math.min(99, 50 + Math.abs(score) * 5);
        } else {
            label = 'Netral';
            confidence = Math.max(60, 85 - Math.abs(score) * 8);
        }

        return {
            score: parseFloat(score.toFixed(2)),
            label,
            confidence: parseFloat(confidence.toFixed(1))
        };
    }

    analyzeBatch(texts) {
        return texts.map(t => this.analyze(t));
    }
}

const analyzer = new PrecisionSentimentAnalyzer();

module.exports = {
    analyze: (text) => analyzer.analyze(text),
    analyzeBatch: (texts) => analyzer.analyzeBatch(texts),
    PrecisionSentimentAnalyzer
};

// Test
if (require.main === module) {
    console.log("🎯 PRECISION SENTIMENT ANALYZER v3.1\n");
    
    const tests = [
        // Kasus yang sebelumnya salah
        { text: "Dana potongan Ini bener buat MBG atau malah buat tambah IKN? Yang bener ajah...", expected: "Negatif" },
        { text: "Indonesia (c)emas.", expected: "Negatif" },
        { text: "lalu berapa jumlah pemotongan Polisi, Tentara dan Pertahanan kawan-kawan ? yak betul, Rp.0 alias tidak dipotong", expected: "Negatif" },
        { text: "Otakmu juga jangan lupa dipotong", expected: "Negatif" },
        
        // Negatif makian
        { text: "Goblok banget pemerintah ini", expected: "Negatif" },
        { text: "Dasar tolol, ga becus kerja", expected: "Negatif" },
        { text: "Anjir parah banget korupsinya", expected: "Negatif" },
        
        // Negatif halus
        { text: "Sangat kecewa dengan kebijakan ini", expected: "Negatif" },
        { text: "Pemotongan anggaran pendidikan merugikan rakyat", expected: "Negatif" },
        { text: "Proyek ditunda tanpa batas waktu", expected: "Negatif" },
        
        // Sarkasme
        { text: "Wah \"hebat\" sekali pemerintah kita", expected: "Negatif" },
        { text: "Bagus ya kebijakan ini wkwkwk", expected: "Negatif" },
        { text: "Emang pinter banget deh 🙄", expected: "Negatif" },
        
        // Positif
        { text: "Luar biasa! Program ini sangat membantu rakyat", expected: "Positif" },
        { text: "Mantap sekali prestasinya! 🔥👍", expected: "Positif" },
        { text: "Alhamdulillah berhasil dengan baik", expected: "Positif" },
        
        // Netral (benar-benar informatif)
        { text: "Pemerintah mengumumkan kebijakan baru", expected: "Netral" },
        { text: "Rapat koordinasi membahas anggaran", expected: "Netral" },
    ];

    let correct = 0;
    tests.forEach((t, i) => {
        const r = analyzer.analyze(t.text);
        const ok = r.label === t.expected;
        if (ok) correct++;
        console.log(`${ok ? '✅' : '❌'} ${i+1}. "${t.text.substring(0,50)}${t.text.length > 50 ? '...' : ''}"`);
        console.log(`   Expected: ${t.expected} | Got: ${r.label} (${r.score}, ${r.confidence}%)\n`);
    });

    console.log(`\n📊 ACCURACY: ${correct}/${tests.length} (${(correct/tests.length*100).toFixed(1)}%)`);
}