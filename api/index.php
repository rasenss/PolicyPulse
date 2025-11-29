<?php

require __DIR__ . '/../public/index.php';
```

### 3. Konfigurasi "Project Settings" di Dashboard Vercel

Ini langkah paling krusial untuk mengatasi error `npm run build` yang gagal.

1.  Buka Dashboard Vercel -> Pilih Project Anda -> **Settings**.
2.  Masuk ke menu **Build & Development Settings**.
3.  Ubah pengaturan berikut:
    * **Framework Preset:** Pilih `Other` (JANGAN pilih Vite, React, atau Laravel default jika ada).
    * **Build Command:** *Override* dan biarkan **KOSONG** (hapus teks apapun di sana).
        * *Kenapa?* Karena Laravel PHP tidak butuh "npm run build" untuk backend-nya di Vercel Serverless. Aset frontend (Tailwind) sudah kita compile lokal atau pakai CDN.
    * **Output Directory:** *Override* dan isi dengan `public`.
    * **Install Command:** *Override* dan biarkan **KOSONG** (atau isi `composer install --no-dev --prefer-dist --optimize-autoloader` jika Anda ingin install dependensi PHP di server, tapi biasanya untuk Vercel PHP Runtime, ini ditangani otomatis atau lewat `api/index.php`).

    **Rekomendasi Aman:**
    Set **Build Command** menjadi: `mkdir -p public` (Perintah dummy agar Vercel tidak bingung).

### 4. Push Ulang ke GitHub

Setelah mengubah `vercel.json` dan settingan di dashboard Vercel:

1.  Commit dan Push lagi.
    ```bash
    git add vercel.json
    git commit -m "Fix vercel output directory"
    git push origin main