<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QR Dinamis</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >
    <style>
        :root {
            color-scheme: light;
            --bg: #f6f7fb;
            --card: #ffffff;
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --text: #0f172a;
            --muted: #475569;
            --border: #e2e8f0;
            --shadow: 0 15px 40px rgba(15, 23, 42, 0.08);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: radial-gradient(circle at 10% 20%, rgba(37, 99, 235, 0.08), transparent 25%),
                radial-gradient(circle at 90% 10%, rgba(16, 185, 129, 0.08), transparent 22%),
                var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .page {
            width: min(1100px, 100%);
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 24px;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
            box-shadow: var(--shadow);
        }

        h1 {
            margin: 0 0 8px;
            font-size: 28px;
            letter-spacing: -0.02em;
        }

        p.lead {
            margin: 0 0 20px;
            color: var(--muted);
            line-height: 1.6;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        label {
            font-weight: 600;
            color: var(--text);
        }

        input[type='url'] {
            width: 100%;
            padding: 12px 14px;
            border-radius: 12px;
            border: 1px solid var(--border);
            font-size: 15px;
            background: #f8fafc;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        input[type='url']:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
            background: #fff;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        button {
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            padding: 12px 16px;
            font-size: 15px;
            transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.2s ease;
        }

        button.primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.3);
        }

        button.primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        button.secondary {
            background: #eef2ff;
            color: var(--text);
            border: 1px solid #c7d2fe;
        }

        button.secondary:hover {
            background: #e0e7ff;
            transform: translateY(-1px);
        }

        .preview-card {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
        }

        .qr-box {
            width: 260px;
            height: 260px;
            display: grid;
            place-items: center;
            background: #f8fafc;
            border-radius: 16px;
            border: 1px dashed var(--border);
            margin: 0 auto;
            padding: 14px;
        }

        .status {
            min-height: 22px;
            color: var(--muted);
            font-size: 14px;
        }

        .tips {
            display: grid;
            gap: 8px;
            margin-top: 16px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
        }

        @media (max-width: 900px) {
            .page {
                grid-template-columns: 1fr;
            }

            body {
                padding: 18px;
            }
        }

        @media (max-width: 540px) {
            body {
                padding: 14px;
            }

            .card {
                padding: 18px;
            }

            h1 {
                font-size: 24px;
            }

            .qr-box {
                width: 220px;
                height: 220px;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <section class="card">
            <h1>QR Dinamis</h1>
            <p class="lead">Buat tautan QR yang cepat, ringan, dan siap dibagikan. Sesuaikan tautan, lalu simpan atau salin kapan pun dibutuhkan.</p>
            <form id="qr-form">
                <div>
                    <label for="target-url">Tautan tujuan</label>
                    <input
                        id="target-url"
                        name="target-url"
                        type="url"
                        inputmode="url"
                        placeholder="https://contoh.com/halaman"
                        required
                        value="{{ url('/go/contoh') }}"
                    >
                </div>
                <div class="actions">
                    <button type="submit" class="primary">Perbarui QR</button>
                    <button type="button" id="copy-link" class="secondary">Salin Link</button>
                    <button type="button" id="download-qr" class="secondary">Download Gambar</button>
                </div>
                <div class="status" id="status"></div>
            </form>
            <div class="tips">
                <div>• Pastikan tautan sudah lengkap dengan https:// agar pemindaian berhasil.</div>
                <div>• Tombol Salin Link akan menyimpan tautan yang sama dengan QR.</div>
                <div>• Download menghasilkan gambar PNG sehingga mudah ditempel ke materi promosi.</div>
            </div>
        </section>

        <section class="card preview-card">
            <div class="qr-box" id="qr-box">
                <div id="qr-preview"></div>
            </div>
            <div class="status" id="preview-text"></div>
        </section>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" integrity="sha512-LrM3t4YkSg8wPpVdZYkTfLZNVVRFlE0YyqS/fWznuaCG2lLBVmOAXoJ1i8LojRxurx8WcNKGqC5h0n0QY6tYKg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const form = document.getElementById('qr-form');
        const urlInput = document.getElementById('target-url');
        const qrContainer = document.getElementById('qr-preview');
        const statusText = document.getElementById('status');
        const previewText = document.getElementById('preview-text');
        const copyButton = document.getElementById('copy-link');
        const downloadButton = document.getElementById('download-qr');

        let currentValue = urlInput.value.trim();
        let qrInstance;

        const setStatus = (message) => {
            statusText.textContent = message;
        };

        const setPreviewText = (message) => {
            previewText.textContent = message;
        };

        const generateQr = (text) => {
            if (!text) {
                setStatus('Isi tautan terlebih dahulu.');
                return;
            }

            qrContainer.innerHTML = '';
            qrInstance = new QRCode(qrContainer, {
                text,
                width: 230,
                height: 230,
                correctLevel: QRCode.CorrectLevel.H,
            });
            currentValue = text;
            setStatus('QR berhasil diperbarui.');
            setPreviewText(text);
        };

        form.addEventListener('submit', (event) => {
            event.preventDefault();
            generateQr(urlInput.value.trim());
        });

        copyButton.addEventListener('click', async () => {
            if (!currentValue) return;
            try {
                await navigator.clipboard.writeText(currentValue);
                setStatus('Link sudah disalin ke clipboard.');
            } catch (error) {
                setStatus('Clipboard tidak tersedia di browser ini.');
            }
        });

        downloadButton.addEventListener('click', () => {
            if (!currentValue) return;
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
            setStatus('Gambar QR berhasil diunduh.');
        });

        // Hasil awal
        generateQr(currentValue);
    </script>
</body>
</html>
