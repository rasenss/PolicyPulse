// sentiment_analyzer.cjs
// EXPERT SYSTEM V3.5: ADVANCED CONTEXTUAL SENTIMENT ENGINE
// Fitur: Deteksi Sarkasme Politik, Retorika Negatif, Hate Speech, & Slang Normalizer

class ExpertAnalyzer {
    constructor() {
        // 1. KAMUS NORMALISASI (SLANG DICTIONARY)
        // Mengubah bahasa gaul/singkatan menjadi kata baku agar bisa diproses logika
        this.slang = {
            'gk': 'tidak', 'ga': 'tidak', 'gak': 'tidak', 'nggak': 'tidak', 'kaga': 'tidak', 'ora': 'tidak', 'tak': 'tidak',
            'yg': 'yang', 'utk': 'untuk', 'dgn': 'dengan', 'bgt': 'sangat', 'krn': 'karena', 'tp': 'tapi',
            'kl': 'kalau', 'klo': 'kalau', 'jd': 'jadi', 'jgn': 'jangan', 'sy': 'saya', 'gw': 'saya', 'aku': 'saya',
            'lu': 'kamu', 'lo': 'kamu', 'baja': 'saja', 'aja': 'saja', 'doang': 'saja', 'cuman': 'saja',
            'sdh': 'sudah', 'udh': 'sudah', 'sm': 'sama', 'bkn': 'bukan', 'tak': 'tidak', 'blm': 'belum',
            'mulyono': 'jokowi_sarkas', 'samsul': 'gibran_sarkas', 'fufufafa': 'gibran_sarkas',
            'konoha': 'indonesia_sarkas', 'wakanda': 'indonesia_sarkas', 'plonga': 'plongo',
            'gemoy': 'prabowo', 'bazer': 'buzzer', 'bazerp': 'buzzer'
        };

        // 2. KAMUS BOBOT & KATEGORI (LEXICON)
        // Format: { score: angka, type: kategori_opsional }
        this.lexicon = {
            // --- TARGET SARKASME (TRIGGER UTAMA) ---
            'jokowi_sarkas': { score: -5, type: 'TARGET_SARCASM' },
            'gibran_sarkas': { score: -5, type: 'TARGET_SARCASM' },
            'indonesia_sarkas': { score: -2, type: 'TARGET_SARCASM' },
            'buzzer': { score: -5, type: 'TARGET_HATE' },
            'penjilat': { score: -5, type: 'TARGET_HATE' },
            'cebong': { score: -4, type: 'TARGET_HATE' },
            'kadrun': { score: -4, type: 'TARGET_HATE' },
            'kampret': { score: -4, type: 'TARGET_HATE' },
            'antek': { score: -5, type: 'TARGET_HATE' },
            'boneka': { score: -5, type: 'TARGET_HATE' },
            'petugas': { score: -3, type: 'TARGET_SARCASM' },

            // --- NEGATIF KERAS (HATE SPEECH & MAKIAN) ---
            'anjing': -5, 'bangsat': -5, 'tahi': -5, 'sampah': -5, 'biadab': -5, 'setan': -5,
            'iblis': -5, 'bajingan': -5, 'laknat': -5, 'jahanam': -5, 'bunuh': -5, 'gantung': -5,
            'mampus': -5, 'tolol': -5, 'goblok': -5, 'dungu': -5, 'bego': -5, 'idiot': -5, 'bloon': -5,
            'dosa': -5, 'azab': -5, 'neraka': -5, 'zalim': -5, 'kejam': -5, 'jahat': -5, 'sesat': -5,

            // --- NEGATIF POLITIK & KEBIJAKAN ---
            'korupsi': -5, 'maling': -5, 'rampok': -5, 'garong': -5, 'tikus': -4, 'suap': -5,
            'gagal': -5, 'hancur': -5, 'rusak': -5, 'kacau': -5, 'bobrok': -5, 'amburadul': -5,
            'bohong': -5, 'tipu': -5, 'palsu': -5, 'hoax': -5, 'pencitraan': -4, 'drama': -4,
            'sengsara': -5, 'miskin': -5, 'lapar': -5, 'melarat': -5, 'cekik': -5, 'matikan': -5,
            'susah': -4, 'mahal': -5, 'naik': -3, 'beban': -4, 'berat': -4, 'rugi': -4, 'utang': -4,
            'bangkrut': -5, 'phk': -4, 'pengangguran': -4,
            'kecewa': -4, 'muak': -5, 'capek': -3, 'lelah': -3, 'bingung': -2, 'aneh': -3,
            'nyembah': -5, 'berhala': -5, 'klenik': -5, 'mistis': -4, 'manuk': -4, // Konteks IKN
            'mangkrak': -5, 'candi': -4, 'banjir': -3, 'macet': -3,
            'wacana': -3, 'omdo': -4, 'janji': -2, 'kritik': -2, 'masalah': -2, 'kendala': -2,

            // --- POSITIF (DUKUNGAN) ---
            'mantap': 5, 'keren': 5, 'hebat': 5, 'top': 5, 'juara': 5, 'salut': 5,
            'bangga': 5, 'cinta': 5, 'respek': 5, 'sukses': 5, 'berhasil': 5, 'maju': 5,
            'sejahtera': 5, 'makmur': 5, 'adil': 5, 'aman': 4, 'damai': 4, 'tenang': 3,
            'bersih': 4, 'jujur': 5, 'transparan': 4, 'akuntabel': 4, 'tegas': 5, 'berani': 5,
            'dukung': 5, 'setuju': 5, 'sepakat': 4, 'lanjut': 4, 'gas': 4, 'kawal': 4,
            'bismillah': 3, 'alhamdulillah': 4, 'berkah': 5, 'amin': 3,
            'optimis': 5, 'yakin': 5, 'percaya': 5, 'terbaik': 5, 'menyala': 4,
            'solusi': 4, 'bantu': 4, 'manfaat': 4, 'gratis': 3, 'murah': 3, 'terjangkau': 4
        };

        // 3. POLA FRASA (LOGIC PATTERNS)
        // Mendeteksi struktur kalimat yang mengubah makna
        this.patterns = {
            // RETORIS: Pertanyaan yang sebenarnya adalah pernyataan negatif
            // Contoh: "Mana ada yang bener?" -> Artinya "Tidak ada yang bener"
            rhetorical: [
                'mana ada', 'emang ada', 'emang bisa', 'apa bisa', 'kok bisa', 
                'yakin dek', 'logikanya dimana', 'kapan lagi', 'masa sih', 
                'mana mungkin', 'apa iya', 'emang bener', 'siapa bilang'
            ],
            
            // NEGASI: Pembalik makna (Positif -> Negatif)
            negation: [
                'tidak', 'bukan', 'jangan', 'tak', 'kurang', 'belum', 'anti', 
                'kagak', 'ora', 'gah', 'salah', 'stop'
            ],
            
            // BOOSTER: Penguat makna (Sangat jelek = 1.5x Jelek)
            booster: [
                'sangat', 'banget', 'sekali', 'super', 'terlalu', 'paling', 
                'amat', 'parah', 'kali', 'abis', 'benar', 'bener'
            ],
            
            // KERAGUAN: Mengurangi nilai positif
            doubt: [
                'katanya', 'janjinya', 'wacana', 'omdo', 'teori', 'konsep doang', 
                'gimmick', 'pencitraan', 'cuma janji'
            ],
            
            // TAWA: Bisa berarti senang, atau ejekan (tergantung konteks)
            laugh: [
                'wkwk', 'haha', 'hehe', 'hihi', 'lol', 'ngakak', 'lucu', 'kocak', 'lawak'
            ]
        };
    }

    analyze(text) {
        // Jika teks kosong/null
        if (!text) return { score: 0, label: 'Netral' };

        // STEP 1: PRE-PROCESSING
        // Bersihkan simbol, lowercase, dan normalisasi slang
        let cleanText = text.toLowerCase()
            .replace(/[^\w\s]/gi, ' ') // Hapus simbol aneh
            .replace(/\s+/g, ' ')      // Hapus spasi ganda
            .trim();
        
        let rawWords = cleanText.split(' ');
        let words = rawWords.map(w => this.slang[w] || w);
        let normalizedText = words.join(' ');

        // STEP 2: CONTEXT FLAGS (Mengumpulkan Bukti)
        let ctx = {
            score: 0,
            wordCount: 0,
            negativeWords: 0,
            positiveWords: 0,
            
            // Flags Khusus
            hasSarcasticTarget: false, // Ada Mulyono?
            hasRhetorical: false,      // Ada "Mana ada"?
            hasLaugh: false,           // Ada "wkwk"?
            hasDoubt: false,           // Ada "Katanya"?
            hasNegation: false,        // Ada "Tidak"?
            isHateSpeech: false        // Ada kata kasar parah?
        };

        // Deteksi Pola Frasa (Phrase Scanning)
        this.patterns.rhetorical.forEach(p => { 
            if (normalizedText.includes(p)) {
                ctx.hasRhetorical = true;
                ctx.score -= 3; // Default penalti untuk pertanyaan retoris sinis
            }
        });
        
        this.patterns.doubt.forEach(p => { 
            if (normalizedText.includes(p)) {
                ctx.hasDoubt = true;
                ctx.score -= 2; 
            }
        });
        
        this.patterns.laugh.forEach(p => { 
            if (normalizedText.includes(p)) ctx.hasLaugh = true; 
        });

        // STEP 3: WORD SCORING LOOP
        for (let i = 0; i < words.length; i++) {
            let word = words[i];
            let val = 0;
            let type = null;

            // Cek Kamus Lexicon
            if (this.lexicon[word]) {
                if (typeof this.lexicon[word] === 'object') {
                    val = this.lexicon[word].score;
                    type = this.lexicon[word].type;
                } else {
                    val = this.lexicon[word];
                }
            }

            // Flagging Entity (Deteksi Target Sarkasme)
            if (type === 'TARGET_SARCASM' || type === 'TARGET_HATE') {
                ctx.hasSarcasticTarget = true;
                // Bobot target sarkas langsung negatif, tidak peduli konteks
                ctx.score += val; 
            }

            // Flagging Hate Speech
            if (val <= -10) ctx.isHateSpeech = true;

            // Proses Bobot Kata (Jika ada nilainya)
            if (val !== 0) {
                let contextMult = 1;

                // Lookbehind (Cek 2 kata sebelumnya)
                let prev1 = i > 0 ? words[i-1] : '';
                let prev2 = i > 1 ? words[i-2] : '';

                // Rule Negasi (Logic Reversal)
                // "Tidak Bagus" -> -5 (Bukan 5)
                if (this.patterns.negation.includes(prev1) || this.patterns.negation.includes(prev2)) {
                    val = -val; 
                    ctx.hasNegation = true;
                }

                // Rule Booster (Logic Amplifier)
                // "Sangat Hancur" -> -5 * 1.5 = -7.5
                if (this.patterns.booster.includes(prev1)) {
                    contextMult = 1.5;
                }

                // Tambahkan ke Skor Total
                ctx.score += (val * contextMult);

                // Hitung jumlah kata positif/negatif murni untuk logika nanti
                if (val > 0) ctx.positiveWords++;
                if (val < 0) ctx.negativeWords++;
            }
            
            ctx.wordCount++;
        }

        // STEP 4: EXPERT LOGIC (PENERAPAN ATURAN CERDAS)
        
        // RULE 1: THE PARADOX (SARKASME POLITIK)
        // IF (Target = BazeRp) AND (Ada Kata Positif) -> THEN (Sentimen = SARKAS BERAT)
        // Alasan: Tidak mungkin orang memuji tulus menggunakan julukan ejekan.
        // Contoh: " hebat banget" -> Skor dibanting jadi -15.
        if (ctx.hasSarcasticTarget && ctx.positiveWords > 0) {
            ctx.score = -15; // Hukuman berat sarkasme
        }

        // RULE 2: LAUGHING AT DISASTER (MENERTAWAKAN KEGAGALAN)
        // IF (Ada Tawa 'wkwk') AND (Ada Kata Negatif) -> THEN (Sentimen = NEGATIF)
        // Reason: "Negara hancur wkwk" adalah ejekan/keputusasaan, bukan kegembiraan.
        if (ctx.hasLaugh && ctx.negativeWords > 0) {
            ctx.score -= 4;
        }

        // RULE 3: RHETORICAL SARCASM (RETORIS SINIS)
        // IF (Pertanyaan Retoris) AND (Ada Kata Positif) -> THEN (Sentimen = NEGATIF)
        // Contoh: "Mana ada yang bagus?" -> 'Bagus' dibalik maknanya jadi jelek.
        if (ctx.hasRhetorical && ctx.positiveWords > 0) {
            // Skor dibalik menjadi negatif dan diperparah
            ctx.score = -Math.abs(ctx.score) - 5;
        }

        // RULE 4: DOUBTFUL POSITIVE (PUJIAN RAGU)
        // IF (Ada Keraguan) AND (Ada Kata Positif) -> THEN (Kurangi Nilai Positif)
        // Contoh: "Katanya sih bagus" -> Nilai positifnya tidak valid.
        if (ctx.hasDoubt && ctx.positiveWords > 0) {
            ctx.score -= 5; // Kurangi poin positifnya drastis
        }

        // STEP 5: FINAL LABELING (PENENTUAN KEPUTUSAN)
        let label = 'Netral';

        // Threshold (Ambang Batas)
        if (ctx.score >= 2) label = 'Positif';
        else if (ctx.score <= -2) label = 'Negatif';
        else {
            // GRAY AREA RESOLUTION (-1 s/d 1)
            // Logic breaker untuk menghindari terlalu banyak "Netral" palsu
            
            // 1. Jika menyebut target sarkas (Mulyono), otomatis Negatif
            if (ctx.hasSarcasticTarget) label = 'Negatif'; 
            
            // 2. Jika kalimatnya ragu-ragu/wacana, otomatis Negatif
            else if (ctx.hasDoubt) label = 'Negatif'; 
            
            // 3. Jika ada kata negatif walau sedikit, dan tidak ada kata positif kuat -> Bias ke Negatif
            else if (ctx.negativeWords > 0 && ctx.positiveWords === 0) label = 'Negatif';
            
            // 4. Jika ada "Tidak" + "Kata Positif" (e.g. "Tidak jelas"), jadikan Negatif
            else if (ctx.hasNegation && ctx.positiveWords > 0) label = 'Negatif';

            // 5. Default Netral hanya untuk pertanyaan murni
            else if (text.includes('?')) label = 'Netral';
        }

        return { score: ctx.score, label: label };
    }
}

// INSTANTIATION & EXPORT
const analyzer = new ExpertAnalyzer();

module.exports = { 
    analyze: (text) => analyzer.analyze(text) 
};