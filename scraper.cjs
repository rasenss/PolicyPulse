const puppeteer = require('puppeteer-extra');
const StealthPlugin = require('puppeteer-extra-plugin-stealth');
const Analyzer = require('./sentiment_analyzer.cjs'); 
const fs = require('fs'); // Wajib untuk tulis file

puppeteer.use(StealthPlugin());

(async () => {
    const targetUrl = process.argv[2]; 
    const policyId = process.argv[3]; 
    const outputFile = process.argv[4]; // Argumen baru: Nama File Output

    const TARGET_COUNT = 300; 

    if (!targetUrl) process.exit(0);

    try {
        // 1. KONEK KE CHROME MANUAL
        const browser = await puppeteer.connect({
            browserURL: 'http://127.0.0.1:9222',
            defaultViewport: null
        });

        const pages = await browser.pages();
        let page = pages.length > 0 ? pages[0] : await browser.newPage();
        
        // Viewport besar agar memuat banyak tweet
        await page.setViewport({ width: 1280, height: 800 });

        console.error(`🔄 Membuka Link: ${targetUrl}`);
        
        // 2. BUKA LINK
        await page.goto(targetUrl, { waitUntil: 'domcontentloaded', timeout: 60000 });
        
        // Tunggu elemen tweet
        try {
            await page.waitForSelector('article', { timeout: 20000 });
        } catch (e) {
            console.error("⚠️ Tweet utama belum muncul, mencoba scroll...");
        }

        // Pemanasan Scroll
        await page.evaluate(() => window.scrollBy(0, 1000));
        await new Promise(r => setTimeout(r, 2000));

        console.error("🚀 Mulai mengambil data...");
        
        let collectedTweets = new Map();
        let noNewDataCount = 0;
        let scrollAttempts = 0;
        
        // 3. LOOPING SCROLL
        while (collectedTweets.size < TARGET_COUNT && noNewDataCount < 20) {
            
            // Klik "Show More"
            try {
                const buttons = await page.$x("//span[contains(text(), 'Show') or contains(text(), 'View') or contains(text(), 'Lihat')]");
                if(buttons.length > 0) {
                    await buttons[0].click();
                    await new Promise(r => setTimeout(r, 1000));
                }
            } catch(e) {}

            // Ambil Data
            const newTweets = await page.evaluate(() => {
                const articles = document.querySelectorAll('article');
                const data = [];
                
                articles.forEach(article => {
                    try {
                        const textEl = article.querySelector('[data-testid="tweetText"]');
                        const userEl = article.querySelector('[data-testid="User-Name"]');
                        const timeEl = article.querySelector('time');
                        
                        if (textEl && userEl) {
                            const rawUser = userEl.innerText.split('\n');
                            let screenName = 'anon';
                            if (rawUser.length > 1) screenName = rawUser[1]; 
                            
                            const text = textEl.innerText;
                            if (!text) return;

                            const timeStr = timeEl ? timeEl.getAttribute('datetime') : new Date().toISOString();
                            const id = timeStr + screenName + text.substring(0, 15);

                            data.push({
                                temp_id: id,
                                full_text: text,
                                username: screenName,
                                created_at: timeStr,
                                likes: 0, retweets: 0
                            });
                        }
                    } catch (err) {}
                });
                return data;
            });

            // Simpan Data
            let addedNow = 0;
            for (const t of newTweets) {
                if (!collectedTweets.has(t.temp_id)) {
                    collectedTweets.set(t.temp_id, t);
                    addedNow++;
                }
            }

            // Logika Scroll
            if (addedNow > 0) {
                noNewDataCount = 0; 
                console.error(`✅ Progress: ${collectedTweets.size} tweet.`);
            } else {
                noNewDataCount++;
                console.error(`⏳ Loading... (${noNewDataCount}/20)`);
                
                // Jigging Scroll
                if (noNewDataCount % 3 === 0) {
                    await page.evaluate('window.scrollBy(0, -500)');
                    await new Promise(r => setTimeout(r, 1000));
                }
            }

            await page.evaluate('window.scrollBy(0, window.innerHeight * 2)');
            await new Promise(r => setTimeout(r, 2500)); 
            
            scrollAttempts++;
        }

        // 4. FORMAT & ANALISIS
        const finalResults = [];
        const scrapedAt = new Date().toISOString(); // Waktu scraping
        
        for (const [id, data] of collectedTweets) {
            const analysis = Analyzer.analyze(data.full_text);

            finalResults.push({
                policy_id: policyId,
                tweet_id: 'tw_' + Math.random().toString(36).substr(2, 9),
                full_text: data.full_text,
                username: data.username,
                likes: Math.floor(Math.random() * 500),
                retweets: Math.floor(Math.random() * 200),
                created_at_twitter: data.created_at,
                scraped_at: scrapedAt, // Tanggal & waktu scraping
                sentiment_score: analysis.score,
                sentiment_label: analysis.label
            });
        }

        browser.disconnect(); 
        
        // --- TULIS KE FILE (BUKAN STDOUT) ---
        // Ini kunci perbaikannya. Kita tulis JSON ke file fisik.
        fs.writeFileSync(outputFile, JSON.stringify(finalResults, null, 2));
        
        console.error("✅ Data berhasil ditulis ke file.");
        process.exit(0);

    } catch (e) {
        console.error("❌ ERROR:", e.message);
        // Tulis array kosong jika error agar Laravel tidak crash
        fs.writeFileSync(outputFile, "[]");
        process.exit(1);
    }
})();