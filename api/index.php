<?php

require __DIR__ . '/../public/index.php';
```

**3. Update `.gitignore` (PENTING)**
Buka file `.gitignore`. Pastikan baris-baris ini ada agar file sampah/rahasia tidak ikut ter-upload:

```text
/vendor
/node_modules
/public/hot
/public/storage
.env
.phpunit.result.cache
/chrome_data
/chrome_session_v2
scraper.js
scraper.cjs
sentiment_analyzer.cjs
```

---

### TAHAP 2: Upload ke GitHub

1.  Buka **Terminal** di folder proyek `policypulse`.
2.  Jalankan perintah ini satu per satu:

```bash
# 1. Inisialisasi Git (jika belum)
git init

# 2. Masukkan semua file ke antrian upload
git add .

# 3. Simpan perubahan
git commit -m "Siap deploy PolicyPulse ke Vercel"

# 4. Ganti nama branch utama
git branch -M main
```

3.  Buka website **[GitHub.com](https://github.com)**:
    * Login -> Klik tombol **+** di pojok kanan atas -> **New Repository**.
    * Nama Repository: `policypulse` (atau bebas).
    * Pilih **Public** atau **Private** (Terserah).
    * Klik **Create repository**.

4.  Salin link repository Anda (misal: `https://github.com/username/policypulse.git`).

5.  Kembali ke Terminal, jalankan perintah (ganti URL dengan milik Anda):

```bash
# Sambungkan ke GitHub
git remote add origin https://github.com/USERNAME_ANDA/policypulse.git

# Upload!
git push -u origin main