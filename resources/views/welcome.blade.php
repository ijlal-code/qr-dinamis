<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>QR Dinamis</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f8fafc;
            --card: #ffffff;
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --text: #0f172a;
            --muted: #475569;
            --border: #e2e8f0;
            --shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: 'Inter', system-ui, -apple-system, sans-serif; background: var(--bg); color: var(--text); }
        a { color: var(--primary); text-decoration: none; }
        header { position: sticky; top: 0; z-index: 10; background: rgba(248,250,252,0.98); backdrop-filter: blur(8px); border-bottom: 1px solid var(--border); }
        nav { max-width: 1080px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; gap: 16px; }
        .brand { font-weight: 800; letter-spacing: -0.02em; display: flex; align-items: center; gap: 10px; }
        .brand span { display: inline-block; padding: 8px 10px; background: #e0e7ff; color: #1d4ed8; border-radius: 10px; font-size: 14px; }
        .nav-actions { display: flex; align-items: center; gap: 10px; }
        .btn { border: none; border-radius: 12px; padding: 10px 14px; font-weight: 700; cursor: pointer; transition: transform 0.15s ease, box-shadow 0.15s ease; }
        .btn.primary { background: var(--primary); color: #fff; box-shadow: 0 8px 22px rgba(37,99,235,0.25); }
        .btn.primary:hover { background: var(--primary-dark); transform: translateY(-1px); }
        .btn.ghost { background: #e2e8f0; color: var(--text); }
        main { max-width: 1080px; margin: 0 auto; padding: 18px; display: grid; gap: 16px; }
        .hero { background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 18px 20px; box-shadow: var(--shadow); display: grid; gap: 10px; }
        .hero h1 { margin: 0; font-size: 26px; letter-spacing: -0.02em; }
        .hero p { margin: 0; color: var(--muted); line-height: 1.6; }
        .layout { display: grid; grid-template-columns: 1.05fr 0.95fr; gap: 16px; align-items: start; }
        .card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 18px; box-shadow: var(--shadow); }
        form { display: grid; gap: 14px; }
        label { font-weight: 600; color: var(--text); }
        input[type="text"], input[type="url"] { width: 100%; padding: 12px 14px; border-radius: 12px; border: 1px solid var(--border); background: #f8fafc; font-size: 15px; transition: border-color 0.2s ease, box-shadow 0.2s ease; }
        input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,0.15); background: #fff; }
        .actions { display: flex; flex-wrap: wrap; gap: 10px; }
        .status { min-height: 22px; color: var(--muted); font-size: 14px; }
        .preview { display: grid; gap: 14px; text-align: center; }
        .qr-box { width: 240px; height: 240px; display: grid; place-items: center; background: #f8fafc; border-radius: 14px; border: 1px dashed var(--border); margin: 0 auto; padding: 12px; }
        .history { display: grid; gap: 10px; margin-top: 8px; }
        .history-item { padding: 12px; border: 1px solid var(--border); border-radius: 12px; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 10px; background: #fdfdfd; }
        .history-title { font-weight: 700; }
        .tag { display: inline-flex; align-items: center; gap: 6px; background: #e0f2fe; color: #0c4a6e; border-radius: 10px; padding: 6px 10px; font-size: 13px; }
        .muted { color: var(--muted); font-size: 14px; }
        .empty { text-align: center; color: var(--muted); padding: 12px 6px; }
        footer { text-align: center; color: var(--muted); padding: 16px; font-size: 14px; }
        @media (max-width: 900px) { .layout { grid-template-columns: 1fr; } nav { flex-wrap: wrap; } }
        @media (max-width: 520px) {
            nav { padding: 12px 14px; }
            .hero { padding: 16px; }
            .card { padding: 16px; }
            .qr-box { width: 200px; height: 200px; }
            .actions { flex-direction: column; }
        }
    </style>
</head>
<body>
<header>
    <nav>
        <div class="brand">QR Dinamis <span>ringan</span></div>
        <div class="nav-actions">
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn ghost" type="submit">Keluar</button>
                </form>
            @endauth
            @guest
                <a class="btn ghost" href="{{ route('login') }}">Masuk</a>
                <a class="btn primary" href="{{ route('register') }}">Daftar</a>
            @endguest
        </div>
    </nav>
</header>
<main>
    <section class="hero">
        <h1>QR code ringan untuk tautan dinamis</h1>
        <p>Bangun QR dengan cepat, simpan ke akun Anda, lalu bagikan atau unduh PNG-nya. Desain responsif sehingga nyaman dipakai di ponsel.</p>
    </section>

    @auth
    <section class="layout">
        <div class="card">
            <h2 style="margin:0 0 10px;">Buat QR baru</h2>
            <p class="muted" style="margin:0 0 8px;">Isi judul dan tautan, kami simpan ke akun Anda.</p>
            <form id="qr-form">
                <div>
                    <label for="qr-name">Judul</label>
                    <input id="qr-name" name="name" type="text" placeholder="Contoh: Landing Page Promo" required>
                </div>
                <div>
                    <label for="target-url">Tautan tujuan</label>
                    <input id="target-url" name="target_url" type="url" inputmode="url" placeholder="https://contoh.com/halaman" required>
                </div>
                <div class="actions">
                    <button type="submit" class="btn primary">Simpan &amp; Perbarui QR</button>
                    <button type="button" id="copy-link" class="btn ghost" disabled>Salin tautan</button>
                    <button type="button" id="download-qr" class="btn ghost" disabled>Unduh QR</button>
                </div>
                <div class="status" id="status">Masukkan tautan lalu simpan.</div>
            </form>
            <div class="history">
                <div class="history-title">Riwayat terbaru</div>
                @if($recentLinks->isEmpty())
                    <div class="empty">Belum ada QR yang disimpan.</div>
                @else
                    @foreach($recentLinks as $link)
                        <div class="history-item">
                            <div>
                                <div class="history-title">{{ $link->name }}</div>
                                <div class="muted">{{ $link->target_url }}</div>
                            </div>
                            <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                                <span class="tag">Scan: {{ $link->visit_count }}</span>
                                <button class="btn ghost copy-existing" data-copy="{{ route('qr.redirect', $link->slug) }}">Salin</button>
                                <a class="btn primary" href="{{ route('qr.redirect', $link->slug) }}" target="_blank" rel="noopener">Buka</a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="card preview">
            <h3 style="margin:0;">Pratinjau QR</h3>
            <div class="qr-box" id="qr-box"><div id="qr-preview"></div></div>
            <div class="status" id="preview-text"></div>
        </div>
    </section>
    @endauth

    @guest
    <section class="card" style="text-align:center;">
        <h2 style="margin:0 0 10px;">Masuk untuk membuat QR</h2>
        <p class="muted" style="margin:0 0 14px;">Simpan tautan, kelola riwayat scan, dan unduh QR Anda.</p>
        <div class="actions" style="justify-content:center;">
            <a class="btn primary" href="{{ route('register') }}">Daftar gratis</a>
            <a class="btn ghost" href="{{ route('login') }}">Sudah punya akun</a>
        </div>
    </section>
    @endguest
</main>
<footer>Ringan, responsif, dan siap dibagikan.</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" integrity="sha512-LrM3t4YkSg8wPpVdZYkTfLZNVVRFlE0YyqS/fWznuaCG2lLBVmOAXoJ1i8LojRxurx8WcNKGqC5h0n0QY6tYKg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    const form = document.getElementById('qr-form');
    const nameInput = document.getElementById('qr-name');
    const urlInput = document.getElementById('target-url');
    const qrContainer = document.getElementById('qr-preview');
    const statusText = document.getElementById('status');
    const previewText = document.getElementById('preview-text');
    const copyButton = document.getElementById('copy-link');
    const downloadButton = document.getElementById('download-qr');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    let currentValue = '';
    let qrInstance;

    const setStatus = (message) => { if (statusText) statusText.textContent = message; };
    const setPreviewText = (message) => { if (previewText) previewText.textContent = message; };

    const toggleActions = (enabled) => {
        if (copyButton) copyButton.disabled = !enabled;
        if (downloadButton) downloadButton.disabled = !enabled;
    };

    const generateQr = (text) => {
        if (!qrContainer) return;
        qrContainer.innerHTML = '';
        qrInstance = new QRCode(qrContainer, { text, width: 220, height: 220, correctLevel: QRCode.CorrectLevel.H });
        currentValue = text;
        setPreviewText(text);
        toggleActions(true);
    };

    const handleErrors = async (response) => {
        try {
            const data = await response.json();
            setStatus(data.message ?? 'Terjadi kesalahan.');
        } catch (error) {
            setStatus('Gagal menyimpan data.');
        }
    };

    if (form) {
        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            setStatus('Menyimpan...');
            toggleActions(false);

            const formData = new FormData(form);

            const response = await fetch('{{ route('qr-links.store') }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                body: formData,
            });

            if (!response.ok) {
                if (response.status === 401) {
                    setStatus('Silakan login terlebih dahulu.');
                } else {
                    await handleErrors(response);
                }
                return;
            }

            const data = await response.json();
            generateQr(data.redirect_url);
            setStatus(data.message);
        });
    }

    copyButton?.addEventListener('click', async () => {
        if (!currentValue) return;
        try {
            await navigator.clipboard.writeText(currentValue);
            setStatus('Tautan disalin ke clipboard.');
        } catch (error) {
            setStatus('Clipboard tidak diizinkan di browser ini.');
        }
    });

    downloadButton?.addEventListener('click', () => {
        if (!currentValue || !qrContainer) return;
        const canvas = qrContainer.querySelector('canvas');
        const image = qrContainer.querySelector('img');
        const link = document.createElement('a');

        if (canvas) {
            link.href = canvas.toDataURL('image/png');
        } else if (image) {
            link.href = image.src;
        } else {
            setStatus('QR belum dibuat.');
            return;
        }

        link.download = 'qr-link.png';
        link.click();
        setStatus('Gambar QR diunduh.');
    });

    document.querySelectorAll('.copy-existing').forEach((button) => {
        button.addEventListener('click', async () => {
            const target = button.getAttribute('data-copy');
            if (!target) return;
            try {
                await navigator.clipboard.writeText(target);
                setStatus('Tautan riwayat disalin.');
            } catch (error) {
                setStatus('Clipboard tidak tersedia.');
            }
        });
    });
</script>
</body>
</html>
