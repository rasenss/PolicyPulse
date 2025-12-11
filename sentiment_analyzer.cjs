/**
 * POLICYPULSE SENTIMENT ANALYZER v8.0
 * Ultra-Wide Coverage Indonesian Political Sentiment Analysis
 * With Naive Bayes Classifier
 * Maximum Accuracy for Research Publication
 */

// ==================== NAIVE BAYES CLASSIFIER ====================
class NaiveBayesClassifier {
    constructor() {
        this.classes = ['Positif', 'Negatif', 'Netral'];
        this.vocabulary = new Set();
        this.wordCounts = { Positif: {}, Negatif: {}, Netral: {} };
        this.classCounts = { Positif: 0, Negatif: 0, Netral: 0 };
        this.totalDocuments = 0;
        this.vocabularySize = 0;
        this.alpha = 1; // Laplace smoothing parameter
    }

    // Train dengan satu dokumen
    train(tokens, label) {
        if (!this.classes.includes(label)) return;
        
        this.classCounts[label]++;
        this.totalDocuments++;

        for (const token of tokens) {
            this.vocabulary.add(token);
            if (!this.wordCounts[label][token]) {
                this.wordCounts[label][token] = 0;
            }
            this.wordCounts[label][token]++;
        }
        this.vocabularySize = this.vocabulary.size;
    }

    // Train dengan batch data
    trainBatch(data) {
        for (const { tokens, label } of data) {
            this.train(tokens, label);
        }
    }

    // Hitung prior probability P(class)
    getPriorProbability(label) {
        if (this.totalDocuments === 0) return 1 / this.classes.length;
        return this.classCounts[label] / this.totalDocuments;
    }

    // Hitung total kata dalam class
    getTotalWordsInClass(label) {
        return Object.values(this.wordCounts[label]).reduce((a, b) => a + b, 0);
    }

    // Hitung likelihood P(word|class) dengan Laplace smoothing
    getLikelihood(word, label) {
        const wordCount = this.wordCounts[label][word] || 0;
        const totalWords = this.getTotalWordsInClass(label);
        // Laplace smoothing: (count + alpha) / (total + alpha * vocabularySize)
        return (wordCount + this.alpha) / (totalWords + this.alpha * this.vocabularySize);
    }

    // Klasifikasi dengan log probability untuk menghindari underflow
    classify(tokens) {
        if (tokens.length === 0) {
            return { label: 'Netral', probabilities: { Positif: 0.33, Negatif: 0.33, Netral: 0.34 } };
        }

        const logProbabilities = {};

        for (const label of this.classes) {
            // Log prior
            let logProb = Math.log(this.getPriorProbability(label) || 0.001);

            // Sum of log likelihoods
            for (const token of tokens) {
                const likelihood = this.getLikelihood(token, label);
                logProb += Math.log(likelihood || 0.0001);
            }

            logProbabilities[label] = logProb;
        }

        // Normalisasi ke probability (softmax-like)
        const maxLogProb = Math.max(...Object.values(logProbabilities));
        const expProbs = {};
        let sumExp = 0;

        for (const label of this.classes) {
            expProbs[label] = Math.exp(logProbabilities[label] - maxLogProb);
            sumExp += expProbs[label];
        }

        const probabilities = {};
        for (const label of this.classes) {
            probabilities[label] = expProbs[label] / sumExp;
        }

        // Cari label dengan probability tertinggi
        let bestLabel = 'Netral';
        let bestProb = 0;
        for (const label of this.classes) {
            if (probabilities[label] > bestProb) {
                bestProb = probabilities[label];
                bestLabel = label;
            }
        }

        return { label: bestLabel, probabilities, confidence: bestProb * 100 };
    }

    // Export model untuk persistensi
    exportModel() {
        return {
            wordCounts: this.wordCounts,
            classCounts: this.classCounts,
            totalDocuments: this.totalDocuments,
            vocabularySize: this.vocabularySize
        };
    }

    // Import model
    importModel(model) {
        this.wordCounts = model.wordCounts;
        this.classCounts = model.classCounts;
        this.totalDocuments = model.totalDocuments;
        this.vocabularySize = model.vocabularySize;
        // Rebuild vocabulary
        this.vocabulary = new Set();
        for (const label of this.classes) {
            for (const word of Object.keys(this.wordCounts[label])) {
                this.vocabulary.add(word);
            }
        }
    }
}

class ContextAwareSentimentAnalyzer {
    constructor() {
        this.buildLexicons();
        this.buildContextRules();
        this.buildCriticalPhrases();
        this.buildSlangDictionary();
        
        // Initialize Naive Bayes classifier
        this.naiveBayes = new NaiveBayesClassifier();
        this.trainNaiveBayesFromLexicons();
    }

    // Train Naive Bayes dengan data dari lexicon
    trainNaiveBayesFromLexicons() {
        // Generate training data dari kata-kata di lexicon
        const trainingData = [];

        // Kata negatif kuat -> banyak contoh negatif
        for (const word of this.strongNegativeWords) {
            trainingData.push({ tokens: [word], label: 'Negatif' });
            trainingData.push({ tokens: [word, 'banget'], label: 'Negatif' });
            trainingData.push({ tokens: [word, 'sekali'], label: 'Negatif' });
        }

        // Kata negatif sedang
        for (const word of this.moderateNegativeWords) {
            trainingData.push({ tokens: [word], label: 'Negatif' });
        }

        // Kata negatif ringan
        for (const word of this.mildNegativeWords) {
            trainingData.push({ tokens: [word], label: 'Negatif' });
        }

        // Kata positif kuat
        for (const word of this.strongPositiveWords) {
            trainingData.push({ tokens: [word], label: 'Positif' });
            trainingData.push({ tokens: [word, 'banget'], label: 'Positif' });
            trainingData.push({ tokens: [word, 'sekali'], label: 'Positif' });
        }

        // Kata positif sedang
        for (const word of this.moderatePositiveWords) {
            trainingData.push({ tokens: [word], label: 'Positif' });
        }

        // Kata positif ringan
        for (const word of this.mildPositiveWords) {
            trainingData.push({ tokens: [word], label: 'Positif' });
        }

        // Profanity -> sangat negatif
        for (const word of this.profanity) {
            trainingData.push({ tokens: [word], label: 'Negatif' });
            trainingData.push({ tokens: [word], label: 'Negatif' }); // double weight
        }

        // Tambah contoh netral
        const neutralWords = ['pemerintah', 'kebijakan', 'program', 'rapat', 'koordinasi', 
            'membahas', 'mengumumkan', 'menyatakan', 'menjelaskan', 'menteri', 'presiden',
            'dpr', 'anggota', 'partai', 'politik', 'ekonomi', 'sosial', 'masyarakat',
            'indonesia', 'jakarta', 'nasional', 'daerah', 'provinsi', 'kabupaten'];
        
        for (const word of neutralWords) {
            trainingData.push({ tokens: [word], label: 'Netral' });
        }

        // Contoh kalimat untuk training tambahan
        const sentenceExamples = [
            { tokens: ['korupsi', 'merajalela', 'dimana', 'mana'], label: 'Negatif' },
            { tokens: ['gagal', 'total', 'kebijakan', 'ini'], label: 'Negatif' },
            { tokens: ['luar', 'biasa', 'prestasi', 'membanggakan'], label: 'Positif' },
            { tokens: ['sukses', 'besar', 'program', 'ini'], label: 'Positif' },
            { tokens: ['rapat', 'koordinasi', 'dilaksanakan', 'hari', 'ini'], label: 'Netral' },
            { tokens: ['pemerintah', 'mengumumkan', 'kebijakan', 'baru'], label: 'Netral' },
            { tokens: ['omong', 'doang', 'tidak', 'ada', 'bukti'], label: 'Negatif' },
            { tokens: ['janji', 'palsu', 'pembohong'], label: 'Negatif' },
            { tokens: ['sangat', 'mengecewakan', 'kinerja', 'buruk'], label: 'Negatif' },
            { tokens: ['terima', 'kasih', 'sudah', 'membantu'], label: 'Positif' },
            { tokens: ['alhamdulillah', 'berhasil', 'dengan', 'baik'], label: 'Positif' },
            { tokens: ['kerja', 'bagus', 'lanjutkan'], label: 'Positif' },
        ];

        trainingData.push(...sentenceExamples);

        // Train model
        this.naiveBayes.trainBatch(trainingData);
    }

    // Tambahkan method untuk train dari data eksternal
    trainFromData(texts, labels) {
        for (let i = 0; i < texts.length; i++) {
            const tokens = this.tokenize(texts[i].toLowerCase());
            this.naiveBayes.train(tokens, labels[i]);
        }
    }

    buildLexicons() {
        // ==================== MAKIAN & KATA KASAR ====================
        this.profanity = new Set([
            'anjing', 'anjir', 'anjay', 'anj', 'ajg', 'anjg', 'anjrit',
            'bangsat', 'bgst', 'bngst', 'bajingan', 'bjngn',
            'brengsek', 'brngsk', 'keparat', 'kprt', 'kampret', 'kmprt',
            'kontol', 'kntl', 'memek', 'mmk', 'ngentot', 'ngtd', 'entot',
            'goblok', 'gblk', 'goblog', 'goblg', 'tolol', 'tll', 'tlol',
            'idiot', 'idi0t', 'dungu', 'dng', 'bego', 'bgo', 'begok', 'beg0',
            'bodoh', 'bdh', 'bod0h', 'pandir', 'oon', 'o\'on',
            'tai', 'taik', 't4i', 'tahi', 'bacot', 'bacod', 'babi', 'b4bi',
            'monyet', 'monyong', 'bangke', 'bangkai', 'sinting', 'sintink',
            'sarap', 'srap', 'geblek', 'gblk', 'pekok', 'pkk',
            'jancok', 'jancuk', 'jnck', 'cuk', 'cok', 'dancok',
            'asu', 'asw', 'bejat', 'bjt', 'bedebah', 'bdbh',
            'sialan', 'sial', 'laknat', 'terkutuk', 'iblis', 'setan',
            'sampah', 'smph', 'busuk', 'bobrok', 'brengsek',
        ]);

        // ==================== KATA NEGATIF KUAT (-7 to -10) ====================
        this.strongNegativeWords = new Set([
            // Korupsi & kejahatan
            'korupsi', 'koruptor', 'korup', 'corrupt', 'maling', 'malink',
            'pencuri', 'curi', 'nyuri', 'nyolong', 'penjahat', 'jahat',
            'kriminal', 'criminal', 'perampok', 'rampok', 'penipu', 'tipu',
            'nipu', 'menipu', 'penipuan', 'pembohong', 'bohong', 'boong', 'bohonk',
            'pengkhianat', 'khianat', 'hianat', 'munafik', 'munafiq',
            // Kekerasan & kekejaman
            'zalim', 'dzalim', 'kezaliman', 'kejam', 'kekejaman',
            'brutal', 'brutalitas', 'sadis', 'sadistis', 'biadab', 'biadap',
            // Kehancuran
            'hancur', 'hancurin', 'menghancurkan', 'kehancuran',
            'gagal', 'kegagalan', 'gagal total', 'bobrok', 'kebobrokan',
            'bangkrut', 'kebangkrutan', 'kolaps', 'collapse', 'ambruk',
            'runtuh', 'keruntuhan', 'musnah', 'pemusnahan',
            // Penderitaan
            'bencana', 'malapetaka', 'petaka', 'celaka', 'kecelakaan',
            'sengsara', 'kesengsaraan', 'menderita', 'penderitaan',
            'melarat', 'kemelaratan', 'miskin', 'kemiskinan', 'memiskinkan',
            'lapar', 'kelaparan', 'nestapa', 'pedih', 'kepedihan',
            // Pembodohan & manipulasi
            'pembodohan', 'dibodohi', 'membodohi', 'bodohi',
            'dikorbankan', 'korbankan', 'mengorbankan', 'korban',
            'manipulasi', 'manipulatif', 'dimanipulasi',
            // Hoax
            'hoax', 'hoaks', 'hoak', 'fitnah', 'memfitnah', 'palsu', 'pemalsuan',
            // Premanisme
            'preman', 'premanisme', 'pungli', 'pungutan', 'pemerasan', 'peras',
            'intimidasi', 'mengintimidasi', 'teror', 'meneror',
        ]);

        // ==================== KATA NEGATIF SEDANG (-4 to -6) ====================
        this.moderateNegativeWords = new Set([
            // Kekacauan
            'kacau', 'kekacauan', 'amburadul', 'berantakan', 'rusak', 'kerusakan',
            'buruk', 'memburuk', 'keburukan', 'parah', 'keparahan',
            'rugi', 'kerugian', 'merugi', 'merugikan',
            'boros', 'pemborosan', 'percuma', 'sia-sia', 'mubazir',
            // Emosi negatif
            'kecewa', 'mengecewakan', 'kekecewaan', 'dikecewakan',
            'menyesal', 'penyesalan', 'sedih', 'kesedihan', 'menyedihkan',
            'muak', 'mmuak', 'jijik', 'menjijikkan', 'benci', 'kebencian',
            'marah', 'kemarahan', 'geram', 'kesal', 'jengkel', 'dongkol', 'sebal',
            'takut', 'ketakutan', 'menakutkan', 'khawatir', 'kekhawatiran',
            'cemas', 'kecemasan', 'gelisah', 'kegelisahan', 'resah', 'keresahan',
            // Penolakan
            'tolak', 'menolak', 'penolakan', 'ditolak', 'protes', 'memprotes',
            'demo', 'demonstrasi', 'mogok', 'boikot', 'lawan', 'melawan',
            // Kritik
            'kritik', 'mengkritik', 'kritikan', 'dikritik', 'keluhan', 'mengeluh',
            'komplain', 'masalah', 'problem', 'problematik', 'bermasalah',
            // Penurunan
            'turun', 'menurun', 'penurunan', 'anjlok', 'jeblok', 'melorot',
            'merosot', 'kemerosotan', 'melemah', 'pelemahan',
            'mundur', 'kemunduran', 'surut', 'menyusut',
            // Penundaan & hambatan
            'tunda', 'ditunda', 'penundaan', 'tertunda', 'menunda',
            'batal', 'dibatalkan', 'pembatalan', 'hambat', 'terhambat', 'hambatan',
            'macet', 'kemacetan', 'mandek', 'mandeg', 'stuck', 'stagnan', 'stagnasi',
            // Pemotongan
            'potong', 'dipotong', 'pemotongan', 'memotong',
            'pangkas', 'dipangkas', 'pemangkasan', 'kurangi', 'dikurangi', 'pengurangan',
            'sunat', 'disunat', 'receh',
            // Bahaya
            'bahaya', 'berbahaya', 'membahayakan', 'ancaman', 'mengancam', 'terancam',
            'memaksakan', 'dipaksakan', 'paksaan',
            // Birokrasi buruk
            'ruwet', 'ribet', 'berbelit', 'belibet', 'lambat', 'kelambatan',
            'lama', 'kelamaan', 'telat', 'terlambat',
            // Tambahan
            'nambah', 'tambah', 'menambah', 'buang', 'membuang', 'terbuang',
        ]);

        // ==================== KATA NEGATIF RINGAN (-2 to -3) ====================
        this.mildNegativeWords = new Set([
            'sulit', 'kesulitan', 'menyulitkan', 'susah', 'kesusahan',
            'rumit', 'kerumitan', 'mahal', 'kemahalan', 'berat', 'memberatkan',
            'lemah', 'kelemahan', 'melemahkan', 'bingung', 'kebingungan',
            'kurang', 'kekurangan', 'minim', 'minimnya', 'sedikit',
            'terbatas', 'keterbatasan', 'ragu', 'meragukan', 'diragukan',
            'aneh', 'janggal', 'ganjil', 'payah',
        ]);

        // ==================== KATA POSITIF KUAT (+7 to +10) ====================
        this.strongPositiveWords = new Set([
            'luar biasa', 'luarbiasa', 'spektakuler', 'fenomenal',
            'gemilang', 'kegemilangan', 'cemerlang', 'kecemerlangan',
            'brilian', 'brilliant', 'sempurna', 'kesempurnaan',
            'terbaik', 'the best', 'juara', 'champion',
            'hebat', 'kehebatan', 'keren', 'kereen', 'mantap', 'mantapp', 'mantul',
            'top', 'toppp', 'amazing', 'amazingg', 'excellent', 'outstanding',
            'superb', 'fantastis', 'fantastic', 'wow', 'woww',
            'sukses', 'kesuksesan', 'berhasil', 'keberhasilan',
            'tercapai', 'pencapaian', 'terwujud', 'menang', 'kemenangan', 'pemenang',
            'prestasi', 'berprestasi', 'achievement',
            'salut', 'kagum', 'kekaguman', 'mengagumkan', 'terpesona', 'terkesan',
            'apresiasi', 'mengapresiasi', 'diapresiasi',
            'bangga', 'membanggakan', 'kebanggaan', 'proud',
            'unggul', 'keunggulan', 'prima', 'istimewa', 'keistimewaan',
        ]);

        // ==================== KATA POSITIF SEDANG (+4 to +6) ====================
        this.moderatePositiveWords = new Set([
            'baik', 'kebaikan', 'membaik', 'bagus', 'bagusss',
            'oke', 'okay', 'ok', 'nice', 'nicee', 'good', 'goodd', 'great',
            'positif', 'kepositifan', 'konstruktif', 'produktif', 'produktivitas',
            'efektif', 'efektivitas', 'efisien', 'efisiensi',
            'optimal', 'optimalisasi', 'maksimal',
            'dukung', 'mendukung', 'dukungan', 'didukung',
            'setuju', 'persetujuan', 'menyetujui', 'sepakat', 'kesepakatan',
            'maju', 'kemajuan', 'memajukan', 'berkembang', 'perkembangan',
            'tumbuh', 'pertumbuhan', 'meningkat', 'peningkatan', 'naik', 'kenaikan',
            'perbaikan', 'memperbaiki', 'progress', 'progres', 'improvement',
            'solusi', 'solutif', 'terobosan', 'breakthrough',
            'inovasi', 'inovatif', 'inovator', 'kreatif', 'kreativitas',
            'aman', 'keamanan', 'mengamankan', 'tertib', 'ketertiban',
            'stabil', 'stabilitas', 'menstabilkan', 'kondusif',
            'damai', 'kedamaian', 'tentram', 'ketentraman',
            'adil', 'keadilan', 'fair', 'transparan', 'transparansi',
            'akuntabel', 'akuntabilitas', 'jujur', 'kejujuran', 'bersih', 'integritas',
            'bantu', 'membantu', 'bantuan', 'dibantu', 'tolong', 'menolong',
            'manfaat', 'bermanfaat', 'berguna', 'faedah',
        ]);

        // ==================== KATA POSITIF RINGAN (+1 to +3) ====================
        this.mildPositiveWords = new Set([
            'lumayan', 'lumayanlah', 'cukup', 'boleh', 'bolehlah',
            'optimis', 'optimisme', 'harap', 'berharap', 'harapan', 'semoga',
            'amin', 'amiin', 'aamiin', 'insyaallah', 'insyallah',
            'alhamdulillah', 'alhamdulilah', 'syukur', 'bersyukur',
            'puas', 'kepuasan', 'senang', 'kesenangan', 'gembira', 'kegembiraan',
            'bahagia', 'kebahagiaan', 'suka', 'kesukaan', 'cinta', 'sayang',
            'cepat', 'kecepatan', 'tepat', 'ketepatan', 'akurat', 'lancar', 'kelancaran',
        ]);

        // ==================== NEGASI ====================
        this.negations = new Set([
            'tidak', 'tak', 'tiada', 'bukan', 'bukanlah', 'tanpa', 'belum',
            'jangan', 'janganlah', 'gak', 'ga', 'nggak', 'ngga', 'enggak', 'engga',
            'kagak', 'gk', 'g', 'tdk', 'blm', 'bkn', 'non', 'anti',
            'never', 'no', 'not', 'dont', "don't",
        ]);

        // ==================== KATA SINYAL KRITIK/SINISME ====================
        this.criticismSignals = new Set([
            'ternyata', 'rupanya', 'nyatanya', 'kenyataannya',
            'padahal', 'seharusnya', 'mestinya', 'harusnya', 'semestinya',
            'sayangnya', 'sayang', 'malah', 'justru', 'eh',
            'udahlah', 'sudahlah', 'yauda', 'yasudah',
            'masa', 'masak', 'masih', 'kok', 'lho', 'loh',
            'kenapa', 'mengapa', 'gimana', 'bagaimana', 'mana', 'kapan',
            'demi', 'cuma', 'hanya', 'sekedar', 'sekadar', 'doang', 'doank',
            'mulu', 'melulu', 'terus', 'lagi', 'aja', 'saja', 'toh', 'kan', 'sih',
            'katanya', 'konon', 'kabarnya', 'entah', 'ntah',
        ]);

        // ==================== KATA KETIDAKPUASAN ====================
        this.dissatisfactionWords = new Set([
            'omdo', 'omong', 'omongan', 'ngomong', 'bicara', 'janji',
            'doang', 'doank', 'aja', 'saja', 'mulu', 'melulu', 'terus',
            'belum', 'blm', 'kapan', 'sampai', 'masih', 'tetap', 'lagi',
            'mana', 'dimana', 'kemana', 'NATO',
        ]);
    }

    buildSlangDictionary() {
        // Normalisasi slang ke bentuk standar
        this.slangMap = {
            'gk': 'tidak', 'ga': 'tidak', 'gak': 'tidak', 'g': 'tidak',
            'tdk': 'tidak', 'gx': 'tidak', 'kaga': 'tidak', 'kagak': 'tidak',
            'blm': 'belum', 'blom': 'belum',
            'bkn': 'bukan', 'bkl': 'bakal',
            'tp': 'tapi', 'tpi': 'tapi',
            'yg': 'yang', 'ygbr': 'yang',
            'jg': 'juga', 'jga': 'juga',
            'jd': 'jadi', 'jdi': 'jadi',
            'sm': 'sama', 'sma': 'sama',
            'bs': 'bisa', 'bsa': 'bisa',
            'aj': 'saja', 'aja': 'saja',
            'udh': 'sudah', 'udah': 'sudah', 'sdh': 'sudah',
            'klo': 'kalau', 'kl': 'kalau', 'klu': 'kalau',
            'krn': 'karena', 'krna': 'karena',
            'utk': 'untuk', 'u/': 'untuk',
            'dgn': 'dengan', 'dg': 'dengan',
            'pd': 'pada', 'dr': 'dari',
            'org': 'orang', 'ornag': 'orang',
            'pmt': 'pemerintah', 'pmrntah': 'pemerintah',
            'mslh': 'masalah', 'mslah': 'masalah',
            'bgm': 'bagaimana', 'gmn': 'gimana', 'gmna': 'gimana',
            'gpp': 'tidak apa-apa', 'gapapa': 'tidak apa-apa',
            'wkwk': 'haha', 'wkwkwk': 'haha', 'wkwkwkwk': 'haha',
            'kwkw': 'haha', 'kwkwkw': 'haha',
            'btw': 'ngomong-ngomong',
            'emg': 'memang', 'emng': 'memang',
            'bgt': 'banget', 'bngt': 'banget',
            'bbrp': 'beberapa',
            'stlh': 'setelah',
            'sblm': 'sebelum',
            'trs': 'terus', 'trus': 'terus',
            'nnti': 'nanti', 'nti': 'nanti',
            'skrg': 'sekarang', 'skr': 'sekarang',
            'bsk': 'besok',
            'kmrn': 'kemarin', 'kmrin': 'kemarin',
            'hrs': 'harus',
            'kyk': 'kayak', 'ky': 'kayak',
            'ky': 'seperti', 'kya': 'seperti', 'kynya': 'sepertinya',
            'sprti': 'seperti', 'sprt': 'seperti',
            'jgn': 'jangan',
            'dlm': 'dalam',
            'thd': 'terhadap',
            'tsb': 'tersebut',
            'dll': 'dan lain-lain',
            'dsb': 'dan sebagainya',
            'dkk': 'dan kawan-kawan',
            'dll': 'dan lain-lain',
        };
    }

    buildContextRules() {
        this.contextRules = [
            // ===== KRITIK TERHADAP PEMERINTAH/APARAT =====
            
            { name: 'unnecessary_action', test: (text) => /(untuk\s+apa|ngapain|buat\s+apa|kok\s+masih).*(bentuk|bikin|buat)/i.test(text) || /masih\s+(bentuk|bikin|buat)\s+\w+\s+(kok|sih|ya)/i.test(text), score: -6 },
            { name: 'useless_authority', test: (text) => /(aparat|polisi|kepolisian|satpol|tni|tentara|pemerintah).*(ga|gak|tidak|tdk|gk)\s+(ada\s+)?(guna|berguna|fungsi|kerja|becus)/i.test(text) || /(ga|gak|tidak|gk)\s+(ada\s+)?(guna|berguna|becus).*(aparat|polisi|kepolisian|pemerintah)/i.test(text), score: -7 },
            { name: 'waste_budget', test: (text) => /(nambah|tambah|buang|hamburkan|hambur).*(anggaran|biaya|uang|duit|budget)\s*(aja|saja|doang|mulu)/i.test(text) || /(anggaran|biaya|uang|duit).*(terbuang|sia-sia|percuma)/i.test(text), score: -6 },
            { name: 'redundant_institution', test: (text) => /(sudah|udah|sdh|udh|pdhl|padahal).*(ada|punya).*(kepolisian|polisi|satpol|aparat|tni)/i.test(text) || /(kok|kenapa|ngapain|knp).*(masih|lagi).*(bentuk|bikin)/i.test(text), score: -5 },
            { name: 'no_result', test: (text) => /(berita|janji|omong|bicara|ngomong|wacana|rencana).*(mulu|melulu|terus|doang|aja).*(belum|blm|ga|gak|tidak|gk).*(ada\s+)?(hasil|bukti|aksi|realisasi)/i.test(text) || /belum\s+(ada\s+)?(hasil|bukti|aksi|tindakan|realisasi)/i.test(text) || /mana\s+(hasil|bukti|aksi|realisasi)/i.test(text), score: -6 },
            { name: 'empty_talk', test: (text) => /om(ong\s*)?do(ang)?|omong\s*(kosong|doang|aja|saja|mulu)|cuma\s+omong|NATO|janji\s*(doang|aja|kosong|manis|palsu)/i.test(text), score: -7 },
            { name: 'too_slow', test: (text) => /terlalu\s+(lama|lambat|berbelit|ribet|ruwet|lamban)/i.test(text) || /(lama|lambat)\s+(banget|bgt|sekali|amat)/i.test(text), score: -5 },
            { name: 'challenge_authority', test: (text) => /berani\s+(ga|gak|tidak|tdk|nggak|kagak|gk)/i.test(text) || /kalau\s+(ada\s+)?(nyali|berani)/i.test(text) || /(punya|ada|mana)\s+nyali/i.test(text), score: -5 },
            { name: 'disband_demand', test: (text) => /(bubarkan|tutup|larang|tangkap|penjarain|pecat|copot).*(ormas|organisasi|kelompok|geng|preman|pejabat|menteri)/i.test(text), score: -4 },
            { name: 'not_enough_action', test: (text) => /(jangan|jgn)\s+(cuma|hanya|sekedar).*(juga|sekalian)/i.test(text) || /jgn\s+cuma/i.test(text) || /(kurang|belum)\s+(tegas|keras|serius)/i.test(text), score: -5 },
            { name: 'profit_motive_criticism', test: (text) => /(yang\s+penting|yg\s+penting|pokoknya).*(untung|duit|uang|cuan|profit|kaya)/i.test(text), score: -6 },
            { name: 'white_collar_criminal', test: (text) => /preman\s+(berdasi|berjas|kantoran|elite|elit)/i.test(text) || /koruptor\s+(berdasi|berjas)/i.test(text), score: -5 },
            { name: 'institution_criticism', test: (text) => /(lembaga|institusi|aparat|kepolisian|pemerintah).*(tidak|ga|gak|tdk|gk).*(berjalan|bekerja|berfungsi|efektif|becus)/i.test(text) || /(bukti|tanda|indikasi).*(lembaga|institusi|aparat).*(gagal|tidak\s+berjalan)/i.test(text), score: -6 },
            { name: 'no_big_result', test: (text) => /belum\s+(ada\s+)?(hasil|tangkapan)\s*(kakap|besar|signifikan|nyata)/i.test(text) || /(hasil|tangkapan)\s+(kakap|besar).*(belum|blm|mana)/i.test(text) || /(tangkap|hukum).*(ikan\s+)?kecil\s*(doang|aja|saja)/i.test(text), score: -5 },
            
            // ===== KRITIK KEBIJAKAN =====
            
            { name: 'tidak_butuh_pattern', test: (text) => /(tidak|ga|gak|tdk|gk)\s+(butuh|perlu|usah)/i.test(text), score: -5 },
            { name: 'sacrifice_pattern', test: (text) => /demi\s+\w+.*(dikorbankan|dipotong|dikurangi|disunat|diabaikan)/i.test(text), score: -7 },
            { name: 'not_good_for', test: (text) => /(tidak|ga|gak|gk)\s+baik\s+(untuk|bagi|buat)/i.test(text), score: -5 },
            { name: 'replace_leader', test: (text) => /(presiden|menteri|mentri|pemerintah|pejabat).*(diganti|dicopot|mundur|turun)/i.test(text) || /diganti\s+sekalian/i.test(text) || /(ganti|copot)\s+(aja|saja).*(presiden|menteri|pejabat)/i.test(text), score: -7 },
            { name: 'stupidification', test: (text) => /pembodohan|membodohi|dibodohi|bodohin|ditipu|menipu\s+rakyat/i.test(text), score: -9 },
            { name: 'people_forbidden', test: (text) => /rakyat.*(tidak|ga|gak|tdk|gk)\s+boleh/i.test(text) || /(tidak|ga|gak)\s+boleh.*(pintar|cerdas|kritis|protes)/i.test(text), score: -8 },
            { name: 'danger_irony', test: (text) => /(pintar|cerdas|kritis).*(bahaya|ancaman|berbahaya|dilarang)/i.test(text), score: -8 },
            { name: 'rhetorical_skeptic', test: (text) => /(bagaimana|gimana|bgm|gmn|mana|kapan)\s+(bisa|mungkin|tercapai|terwujud)/i.test(text) && /\?/.test(text), score: -6 },
            { name: 'only_thinking', test: (text) => /(yang\s+dipikir(in|kan)?|cuma\s+mikir(in)?|pikir(an)?\s+sendiri)/i.test(text), score: -5 },
            { name: 'provision_cut', test: (text) => /(bekal|dana|anggaran|budget).*(dikurangi|dipotong|disunat|dipangkas|digerus)/i.test(text), score: -6 },
            { name: 'frustration', test: (text) => /^(udahlah|sudahlah|ya\s+sudah|yasudah|yauda)/i.test(text.trim()) || /(udahlah|sudahlah|capek|cape|lelah).*(gak|tidak|ga|gk)\s+(perlu|usah)/i.test(text), score: -5 },
            { name: 'more_complicated', test: (text) => /(tambah|makin|semakin|bertambah)\s+(ruwet|ribet|rumit|susah|kacau|parah|buruk)/i.test(text), score: -5 },
            { name: 'reshuffle_negative', test: (text) => /reshuffle/i.test(text) && /(gak|tidak|ga|gk)\s+perlu|sekalian|aja|mending/i.test(text), score: -5 },
            { name: 'elite_criticism', test: (text) => /(elit|elite)\s+(politik|penguasa|oligarki)/i.test(text) || /oligarki/i.test(text), score: -4 },
            { name: 'win_election_criticism', test: (text) => /biar.*(menang|terpilih|berkuasa|langgeng)/i.test(text) && /(butuh|perlu|mau|supaya|agar)/i.test(text), score: -5 },
            { name: 'positive_question_sarcasm', test: (text) => { const hasPositive = /(bagus|hebat|keren|mantap|sukses|berhasil|pinter|cerdas)/i.test(text); const hasQuestion = /\?{1,}$/.test(text.trim()); const hasSarcasmIndicator = /(emang|emg|memang|beneran|serius|yakin|wah|gitu)/i.test(text); return hasPositive && hasQuestion && hasSarcasmIndicator; }, score: -5 },
            
            // ===== KRITIK KINERJA =====
            
            { name: 'no_action', test: (text) => /(ga|gak|tidak|gk|belum)\s+(ada\s+)?(aksi|tindakan|langkah|action|gerak)/i.test(text) || /aksi\s+nyata\s+(mana|kapan)/i.test(text), score: -5 },
            { name: 'just_talk', test: (text) => /(cuma|hanya|sekedar)\s+(bicara|ngomong|omong|wacana|rencana)/i.test(text), score: -5 },
            { name: 'disappointed', test: (text) => /(sangat|amat|bgt|banget)\s+(kecewa|mengecewakan)/i.test(text) || /kecewa\s+(berat|banget|bgt|sekali)/i.test(text), score: -6 },
            { name: 'hopeless', test: (text) => /(tidak|ga|gak|gk)\s+(ada\s+)?(harapan|hope)/i.test(text) || /hopeless|putus\s+asa/i.test(text), score: -6 },
            { name: 'worse', test: (text) => /(makin|semakin|tambah)\s+(parah|buruk|kacau|hancur|bobrok)/i.test(text), score: -6 },
            { name: 'same_old', test: (text) => /(sama\s+aja|gitu-gitu\s+aja|begitu\s+terus|tidak\s+berubah|tetap\s+sama)/i.test(text), score: -4 },
            { name: 'useless', test: (text) => /(percuma|sia-sia|mubazir|buang\s+waktu|buang\s+tenaga)/i.test(text), score: -5 },
            
            // ===== SARKASME =====
            
            { name: 'sarcasm_laugh', test: (text) => /(wkwk|haha|hihi|kwkw|lol|lmao).*(pemerintah|kebijakan|program|menteri|presiden)/i.test(text) || /(pemerintah|kebijakan|program|menteri).*(wkwk|haha|hihi|kwkw|lol)/i.test(text), score: -5 },
            { name: 'sarcasm_emoji', test: (text) => /🙄|😏|🤡|💩|👎|😒|😑/.test(text), score: -3 },
            { name: 'sarcasm_quote', test: (text) => /"(bagus|hebat|keren|mantap|sukses|pinter|cerdas|canggih)"/.test(text), score: -5 },
        ];

        // Positive rules
        this.positiveRules = [
            { name: 'explicit_praise', test: (text) => /(luar\s+biasa|sangat\s+(bagus|baik|hebat|keren|mantap)|super\s+(bagus|keren))/i.test(text) && !this.hasSarcasmIndicator(text), score: 8 },
            { name: 'gratitude', test: (text) => /(alhamdulillah|puji\s+tuhan|syukur|terima\s+kasih|makasih|thanks)/i.test(text) && !this.hasSarcasmIndicator(text), score: 5 },
            { name: 'support_explicit', test: (text) => /(dukung\s+penuh|setuju\s+sekali|sepakat\s+total|100%\s+setuju|fully\s+support)/i.test(text), score: 6 },
            { name: 'success_genuine', test: (text) => /(sukses|berhasil|tercapai|terwujud|terealisasi)/i.test(text) && !/\?|bagaimana|gimana|kapan|mana|belum|kalau/.test(text) && !this.hasSarcasmIndicator(text), score: 5 },
            { name: 'good_job', test: (text) => /(kerja\s+bagus|good\s+job|nice\s+work|well\s+done)/i.test(text) && !this.hasSarcasmIndicator(text), score: 5 },
            { name: 'proud', test: (text) => /(bangga|membanggakan|proud)/i.test(text) && !this.hasSarcasmIndicator(text) && !/(tidak|ga|gak)\s+bangga/.test(text), score: 5 },
        ];
    }

    buildCriticalPhrases() {
        this.criticalPhrases = [
            // Omong kosong & janji palsu
            { pattern: /omdo/i, score: -7 },
            { pattern: /om(ong\s+)?doang/i, score: -7 },
            { pattern: /omong\s+kosong/i, score: -7 },
            { pattern: /omong\s+besar/i, score: -6 },
            { pattern: /janji\s+palsu/i, score: -7 },
            { pattern: /janji\s+manis/i, score: -5 },
            { pattern: /janji\s+doang/i, score: -6 },
            { pattern: /NATO/i, score: -6 },
            { pattern: /cuma\s+wacana/i, score: -5 },
            
            // Tidak ada hasil
            { pattern: /ga\s+ada\s+guna/i, score: -6 },
            { pattern: /gak\s+ada\s+guna/i, score: -6 },
            { pattern: /tidak\s+ada\s+guna/i, score: -6 },
            { pattern: /gak\s+berguna/i, score: -6 },
            { pattern: /tidak\s+berguna/i, score: -6 },
            { pattern: /percuma/i, score: -5 },
            { pattern: /sia-sia/i, score: -5 },
            { pattern: /belum\s+ada\s+hasil/i, score: -5 },
            { pattern: /mana\s+hasilnya/i, score: -5 },
            { pattern: /hasil\s+kakap/i, score: -4 },
            { pattern: /ikan\s+kecil\s+doang/i, score: -5 },
            
            // Anggaran & birokrasi
            { pattern: /nambah(i)?\s+anggaran/i, score: -5 },
            { pattern: /buang\s+anggaran/i, score: -6 },
            { pattern: /hamburkan\s+uang/i, score: -6 },
            { pattern: /tambah\s+ruwet/i, score: -5 },
            { pattern: /tambah\s+ribet/i, score: -5 },
            { pattern: /terlalu\s+lama/i, score: -4 },
            { pattern: /terlalu\s+berbelit/i, score: -5 },
            { pattern: /berbelit-belit/i, score: -5 },
            
            // Tantangan & tuntutan
            { pattern: /berani\s+ga/i, score: -4 },
            { pattern: /berani\s+gak/i, score: -4 },
            { pattern: /punya\s+nyali/i, score: -4 },
            { pattern: /kalau\s+ada\s+nyali/i, score: -5 },
            { pattern: /mana\s+nyalinya/i, score: -5 },
            
            // Kriminal kerah putih
            { pattern: /preman\s+berdasi/i, score: -5 },
            { pattern: /preman\s+berjas/i, score: -5 },
            { pattern: /koruptor\s+berdasi/i, score: -5 },
            { pattern: /mafia\s+/i, score: -4 },
            
            // Motif
            { pattern: /yang\s+penting\s+untung/i, score: -6 },
            { pattern: /yg\s+penting\s+untung/i, score: -6 },
            { pattern: /asal\s+bapak\s+senang/i, score: -5 },
            { pattern: /ABS/i, score: -4 },
            
            // Kritik institusi
            { pattern: /untuk\s+apa\s+aparat/i, score: -6 },
            { pattern: /buat\s+apa\s+polisi/i, score: -6 },
            { pattern: /ngapain\s+ada\s+polisi/i, score: -6 },
            { pattern: /polisi\s+tidur/i, score: -4 },
            
            // Perintah (menunjukkan ketidakpuasan)
            { pattern: /bubarkan/i, score: -3 },
            { pattern: /penjarakan/i, score: -3 },
            { pattern: /penjarain/i, score: -3 },
            { pattern: /tangkap/i, score: -2 },
            { pattern: /pecat/i, score: -3 },
            { pattern: /copot/i, score: -3 },
            { pattern: /turunkan/i, score: -3 },
            { pattern: /gulingkan/i, score: -4 },
            
            // Kritik kebijakan
            { pattern: /pembodohan/i, score: -8 },
            { pattern: /dikorbankan/i, score: -6 },
            { pattern: /dipotong/i, score: -4 },
            { pattern: /dikurangi/i, score: -4 },
            { pattern: /disunat/i, score: -5 },
            
            // Ekspresi frustrasi
            { pattern: /capek\s+deh/i, score: -4 },
            { pattern: /cape\s+deh/i, score: -4 },
            { pattern: /lelah\s+/i, score: -3 },
            { pattern: /bosen/i, score: -3 },
            { pattern: /muak/i, score: -5 },
            { pattern: /jijik/i, score: -5 },
            
            // Skeptis
            { pattern: /ga\s+percaya/i, score: -4 },
            { pattern: /gak\s+percaya/i, score: -4 },
            { pattern: /tidak\s+percaya/i, score: -4 },
            { pattern: /bohong\s+/i, score: -5 },
            { pattern: /pembohong/i, score: -6 },
            { pattern: /penipu/i, score: -6 },
        ];
    }

    hasSarcasmIndicator(text) {
        const lower = text.toLowerCase();
        const indicators = [
            /wkwk|wkwkwk|haha|hahaha|hihi|lol|lmao|kwkw|awkwk|xixi/i,
            /emang|emg|memang\s+/i,
            /yakin\s+(deh|banget|lo|lu|lah)/i,
            /serius\s+(nih|ni|lo|lu)/i,
            /beneran\s+(nih|ni)/i,
            /"[^"]+"/,
            /🙄|😏|🤡|👏.*👏|💩/,
            /\(sarcasm\)|\(sarkas\)/i,
        ];
        return indicators.some(pattern => pattern.test(lower) || pattern.test(text));
    }

    hasNegativeContext(text) {
        const lower = text.toLowerCase();
        let negCount = 0;
        for (const word of this.moderateNegativeWords) {
            if (lower.includes(word)) negCount++;
        }
        for (const signal of this.criticismSignals) {
            if (lower.includes(signal)) negCount++;
        }
        return negCount >= 1;
    }

    normalizeSlang(text) {
        let normalized = text.toLowerCase();
        for (const [slang, standard] of Object.entries(this.slangMap)) {
            const regex = new RegExp(`\\b${slang}\\b`, 'gi');
            normalized = normalized.replace(regex, standard);
        }
        return normalized;
    }

    analyze(text) {
        if (!text || typeof text !== 'string' || text.trim().length < 2) {
            return { score: 0, label: 'Netral', confidence: 0, method: 'empty' };
        }

        const originalText = text;
        const lowerText = text.toLowerCase();
        const normalizedText = this.normalizeSlang(lowerText);
        const tokens = this.tokenize(lowerText);
        const normalizedTokens = this.tokenize(normalizedText);

        // STEP 1: Check profanity (immediate return)
        for (const token of tokens) {
            if (this.profanity.has(token)) {
                return { score: -10, label: 'Negatif', confidence: 99, method: 'profanity' };
            }
        }

        // STEP 2: Rule-based analysis (untuk pattern yang jelas)
        const ruleResult = this.analyzeWithRules(lowerText, normalizedText, tokens, normalizedTokens, originalText);
        
        // STEP 3: Naive Bayes classification
        const nbResult = this.naiveBayes.classify(normalizedTokens);

        // STEP 4: Combine results dengan weighted voting
        const finalResult = this.combineResults(ruleResult, nbResult, tokens);

        return finalResult;
    }

    analyzeWithRules(lowerText, normalizedText, tokens, normalizedTokens, originalText) {
        // Check critical phrases
        let phraseScore = 0;
        for (const item of this.criticalPhrases) {
            if (item.pattern.test(lowerText) || item.pattern.test(normalizedText)) {
                phraseScore += item.score;
            }
        }

        // Apply context rules
        let contextScore = 0;
        for (const rule of this.contextRules) {
            if (rule.test(lowerText) || rule.test(normalizedText)) {
                contextScore += rule.score;
            }
        }

        // Check positive rules
        let positiveScore = 0;
        for (const rule of this.positiveRules) {
            if (rule.test(lowerText) || rule.test(normalizedText)) {
                positiveScore += rule.score;
            }
        }

        // Lexicon scoring
        let lexiconScore = this.calculateLexiconScore(tokens);
        let normalizedLexiconScore = this.calculateLexiconScore(normalizedTokens);
        lexiconScore = Math.min(lexiconScore, normalizedLexiconScore);

        // Combine scores
        let totalScore = contextScore + positiveScore + lexiconScore + phraseScore;

        // Additional adjustments
        const qCount = (originalText.match(/\?/g) || []).length;
        if (qCount > 0 && totalScore < 2) totalScore -= qCount * 1.5;

        const exclCount = (originalText.match(/!/g) || []).length;
        if (exclCount >= 2) totalScore *= 1.15;

        const capsRatio = (originalText.match(/[A-Z]/g) || []).length / Math.max(originalText.length, 1);
        if (capsRatio > 0.4) totalScore *= 1.2;

        if (/\.{2,}\s*$/.test(originalText)) totalScore -= 2;

        const negEmoji = (originalText.match(/[😢😭😤😡🤬😠👎💔😞😔🤮😒😑🙄💩🤡]/g) || []).length;
        if (negEmoji > 0) totalScore -= negEmoji * 2;

        const posEmoji = (originalText.match(/[😀😃😄😁😊🥰😍🤩👍👏🎉✨💪🔥❤️💯🙏]/g) || []).length;
        if (posEmoji > 0 && !this.hasSarcasmIndicator(originalText) && totalScore > 0) totalScore += posEmoji * 1.5;

        return this.determineLabel(totalScore);
    }

    combineResults(ruleResult, nbResult, tokens) {
        const ruleScore = ruleResult.score;
        const ruleConfidence = ruleResult.confidence;
        const nbConfidence = nbResult.confidence;

        // Jika rule-based sangat yakin (score ekstrim), prioritaskan rule
        if (Math.abs(ruleScore) >= 6 && ruleConfidence > 75) {
            return { 
                ...ruleResult, 
                method: 'rule-based',
                nbProbabilities: nbResult.probabilities 
            };
        }

        // Jika Naive Bayes sangat yakin dan rule tidak terlalu yakin
        if (nbConfidence > 70 && Math.abs(ruleScore) < 4) {
            // Weighted combination
            const weights = { rule: 0.4, nb: 0.6 };
            
            let combinedLabel;
            if (ruleResult.label === nbResult.label) {
                combinedLabel = ruleResult.label;
            } else if (nbConfidence > 80) {
                combinedLabel = nbResult.label;
            } else {
                combinedLabel = ruleResult.label;
            }

            const combinedConfidence = (ruleConfidence * weights.rule + nbConfidence * weights.nb);

            return {
                score: ruleScore,
                label: combinedLabel,
                confidence: Math.min(99, combinedConfidence),
                method: 'hybrid',
                nbProbabilities: nbResult.probabilities
            };
        }

        // Default: gunakan rule-based dengan info NB
        return { 
            ...ruleResult, 
            method: 'rule-based',
            nbProbabilities: nbResult.probabilities 
        };
    }

    calculateLexiconScore(tokens) {
        let score = 0;
        for (let i = 0; i < tokens.length; i++) {
            const token = tokens[i];
            let wordScore = 0;

            if (this.strongNegativeWords.has(token)) wordScore = -6;
            else if (this.moderateNegativeWords.has(token)) wordScore = -4;
            else if (this.mildNegativeWords.has(token)) wordScore = -2;
            else if (this.strongPositiveWords.has(token)) wordScore = 6;
            else if (this.moderatePositiveWords.has(token)) wordScore = 4;
            else if (this.mildPositiveWords.has(token)) wordScore = 2;
            else if (this.dissatisfactionWords.has(token)) wordScore = -2;

            if (wordScore !== 0 && this.hasNegationBefore(tokens, i)) {
                wordScore = wordScore > 0 ? -wordScore * 0.5 : Math.abs(wordScore) * 0.3;
            }

            score += wordScore;
        }

        if (tokens.length > 20) score = score / Math.sqrt(tokens.length / 10);
        return score;
    }

    hasNegationBefore(tokens, index) {
        for (let i = Math.max(0, index - 3); i < index; i++) {
            if (this.negations.has(tokens[i])) return true;
        }
        return false;
    }

    tokenize(text) {
        return text
            .toLowerCase()
            .replace(/https?:\/\/\S+/g, ' ')
            .replace(/@\w+/g, ' ')
            .replace(/#(\w+)/g, '$1')
            .replace(/[^\w\s]/g, ' ')
            .replace(/\s+/g, ' ')
            .trim()
            .split(/\s+/)
            .filter(t => t.length > 1);
    }

    determineLabel(score) {
        if (score >= 4) {
            return { score: parseFloat(score.toFixed(2)), label: 'Positif', confidence: Math.min(99, 55 + score * 4) };
        } else if (score <= -2) {
            return { score: parseFloat(score.toFixed(2)), label: 'Negatif', confidence: Math.min(99, 55 + Math.abs(score) * 4) };
        } else {
            return { score: parseFloat(score.toFixed(2)), label: 'Netral', confidence: Math.max(60, 80 - Math.abs(score) * 6) };
        }
    }

    analyzeBatch(texts) {
        return texts.map(t => this.analyze(t));
    }

    // Export Naive Bayes model
    exportNBModel() {
        return this.naiveBayes.exportModel();
    }

    // Import Naive Bayes model
    importNBModel(model) {
        this.naiveBayes.importModel(model);
    }
}

const analyzer = new ContextAwareSentimentAnalyzer();

module.exports = {
    analyze: (text) => analyzer.analyze(text),
    analyzeBatch: (texts) => analyzer.analyzeBatch(texts),
    trainFromData: (texts, labels) => analyzer.trainFromData(texts, labels),
    exportModel: () => analyzer.exportNBModel(),
    importModel: (model) => analyzer.importNBModel(model),
    ContextAwareSentimentAnalyzer,
    NaiveBayesClassifier
};

if (require.main === module) {
    console.log("🎯 SENTIMENT ANALYZER v8.0 - WITH NAIVE BAYES\n");
    
    const tests = [
        { text: "Omdo doang", expected: "Negatif" },
        { text: "Terlalu lama itu OMON-OMON, berani tutup ORMAS kalau ada NYALI", expected: "Negatif" },
        { text: "lembaga yang seharusnya menjaga keamanan tidak berjalan dengan baik", expected: "Negatif" },
        { text: "untuk apa aparat yang ada kok masih bentuk satgas kok nambahi anggaran saja, tambah ruwet ae", expected: "Negatif" },
        { text: "Aparat terkait ga ada gunanya ya pak, sampai bikin satgas. Yg penting untung", expected: "Negatif" },
        { text: "jgn cuma disikat pak, BUBARIN ORMASNYA - PENJARAIN PREMANnya lalu jgn ketinggalan jg pak preman berdasi", expected: "Negatif" },
        { text: "Berita mulu belum ada hasil kakap", expected: "Negatif" },
        { text: "Pemerintah terlalu berbelit-belit Pdhl sdh ada kepolisian, satpol PP", expected: "Negatif" },
        { text: "Pemerintah ga butuh anak2 pintar, mereka butuh anak2 senang biar mereka menang lagi", expected: "Negatif" },
        { text: "pembodohan terstruktur", expected: "Negatif" },
        { text: "Goblok banget pemerintah ini", expected: "Negatif" },
        { text: "Sangat kecewa dengan kebijakan ini", expected: "Negatif" },
        { text: "Janji doang, realisasi mana?", expected: "Negatif" },
        { text: "Sama aja gitu-gitu terus", expected: "Negatif" },
        { text: "Makin parah aja keadaannya", expected: "Negatif" },
        { text: "Capek deh ngurusin pemerintah", expected: "Negatif" },
        { text: "Luar biasa! Program ini sangat membantu rakyat", expected: "Positif" },
        { text: "Alhamdulillah berhasil dengan baik", expected: "Positif" },
        { text: "Pemerintah mengumumkan kebijakan baru", expected: "Netral" },
        { text: "Rapat koordinasi membahas anggaran", expected: "Netral" },
    ];

    let correct = 0;
    tests.forEach((t, i) => {
        const r = analyzer.analyze(t.text);
        const ok = r.label === t.expected;
        if (ok) correct++;
        console.log(`${ok ? '✅' : '❌'} ${i+1}. "${t.text.substring(0,55)}${t.text.length > 55 ? '...' : ''}"`);
        console.log(`   Expected: ${t.expected} | Got: ${r.label} (score: ${r.score}, method: ${r.method})`);
        if (r.nbProbabilities) {
            console.log(`   NB Probs: P=${(r.nbProbabilities.Positif*100).toFixed(1)}% N=${(r.nbProbabilities.Negatif*100).toFixed(1)}% Neu=${(r.nbProbabilities.Netral*100).toFixed(1)}%`);
        }
        console.log();
    });

    console.log(`\n📊 ACCURACY: ${correct}/${tests.length} (${(correct/tests.length*100).toFixed(1)}%)`);
    console.log(`\n📈 Naive Bayes Model Stats:`);
    console.log(`   Total training documents: ${analyzer.naiveBayes.totalDocuments}`);
    console.log(`   Vocabulary size: ${analyzer.naiveBayes.vocabularySize}`);
}