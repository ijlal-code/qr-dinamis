@extends('layouts.app')

@section('title', 'Buat QR | QR Dinamis')

@section('content')
<section style="display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap;">
    <div>
        <div class="chip">Buat QR</div>
        <h1 style="margin:6px 0 4px;">QR baru tanpa ribet</h1>
        <p class="muted" style="margin:0;">Isi nama dan tautan, lalu simpan. Riwayat langsung muncul di bawah.</p>
    </div>
    <a class="btn ghost" href="{{ route('dashboard') }}">Kembali ke dashboard</a>
</section>

<section class="card" style="display:grid; gap:14px;">
    @if (session('status'))
        <div class="alert">{{ session('status') }}</div>
    @endif
    <form method="POST" action="{{ route('qr-links.store') }}">
        @csrf
        <div>
            <label for="name">Nama QR</label>
            <input id="name" name="name" type="text" class="input" placeholder="Contoh: Landing Page Promo" value="{{ old('name') }}" required>
            @error('name')<div class="muted" style="color:#dc2626; font-size:14px;">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="target_url">Tautan tujuan</label>
            <input id="target_url" name="target_url" type="url" class="input" placeholder="https://contoh.com/halaman" value="{{ old('target_url') }}" required>
            @error('target_url')<div class="muted" style="color:#dc2626; font-size:14px;">{{ $message }}</div>@enderror
        </div>
        <div class="actions">
            <button type="submit" class="btn primary">Buat QR</button>
        </div>
    </form>
</section>

<section class="card" style="display:grid; gap:12px;">
    <div style="display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap;">
        <h2 style="margin:0;">Riwayat QR</h2>
        <span class="badge">Total: {{ $links->count() }}</span>
    </div>
    @if($links->isEmpty())
        <div class="empty">Belum ada QR yang disimpan.</div>
    @else
        <div style="display:grid; gap:10px;">
            @foreach($links as $link)
                <div class="history-item" style="padding:12px; border:1px solid var(--border); border-radius:12px; display:flex; flex-wrap:wrap; gap:10px; justify-content:space-between; align-items:center; background:#fdfdfd;">
                    <div>
                        <div style="font-weight:700;">{{ $link->name }}</div>
                        <div class="muted" style="word-break:break-all;">{{ $link->target_url }}</div>
                        <div style="margin-top:6px;" class="badge">Slug: {{ $link->slug }}</div>
                    </div>
                    <div class="actions" data-qr-card data-url="{{ route('qr.redirect', $link->slug) }}">
                        <a class="btn ghost" href="{{ route('qr.redirect', $link->slug) }}" target="_blank" rel="noopener">Lihat QR</a>
                        <button class="btn primary" type="button" data-copy>Salin link</button>
                        <button class="btn ghost" type="button" data-download>Unduh QR</button>
                        <div class="qr-box" style="display:none;"></div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" integrity="sha512-LrM3t4YkSg8wPpVdZYkTfLZNVVRFlE0YyqS/fWznuaCG2lLBVmOAXoJ1i8LojRxurx8WcNKGqC5h0n0QY6tYKg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    document.querySelectorAll('[data-qr-card]').forEach((card) => {
        const url = card.getAttribute('data-url');
        const copyBtn = card.querySelector('[data-copy]');
        const downloadBtn = card.querySelector('[data-download]');
        const qrBox = card.querySelector('.qr-box');

        if (!url || !qrBox) return;

        new QRCode(qrBox, { text: url, width: 220, height: 220, correctLevel: QRCode.CorrectLevel.H });

        copyBtn?.addEventListener('click', async () => {
            try {
                await navigator.clipboard.writeText(url);
                alert('Tautan disalin.');
            } catch (error) {
                alert('Clipboard tidak tersedia.');
            }
        });

        downloadBtn?.addEventListener('click', () => {
            const canvas = qrBox.querySelector('canvas');
            const image = qrBox.querySelector('img');
            const link = document.createElement('a');

            if (canvas) {
                link.href = canvas.toDataURL('image/png');
            } else if (image) {
                link.href = image.src;
            } else {
                alert('QR belum siap.');
                return;
            }

            link.download = 'qr-link.png';
            link.click();
        });
    });
</script>
@endpush
