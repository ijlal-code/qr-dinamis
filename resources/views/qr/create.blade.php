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
    <form method="POST" action="{{ route('qr-links.store') }}" data-create-form>
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
        <div class="muted" data-form-status></div>
    </form>
</section>

<section class="card" data-live-preview style="display:none; gap:12px;">
    <div style="display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap;">
        <h2 style="margin:0;">Pratinjau QR terbaru</h2>
        <span class="badge" data-preview-label>QR siap dipakai</span>
    </div>
    <div style="display:flex; align-items:center; gap:16px; flex-wrap:wrap;">
        <div class="qr-box" data-live-qr style="width:220px; height:220px; display:none;"></div>
        <div style="flex:1; min-width:240px; display:grid; gap:10px;">
            <div style="font-weight:700;">Tautan dinamis</div>
            <div class="muted" data-preview-url style="word-break:break-all;"></div>
            <div class="actions">
                <button class="btn primary" type="button" data-preview-copy disabled>Salin link</button>
                <button class="btn ghost" type="button" data-preview-download disabled>Unduh QR PNG</button>
            </div>
        </div>
    </div>
</section>

<section class="card" style="display:grid; gap:12px;">
    <div style="display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap;">
        <h2 style="margin:0;">Riwayat QR</h2>
        <span class="badge" data-total-count>Total: {{ $links->count() }}</span>
    </div>
    <div style="display:grid; gap:10px;" data-history-list>
        @forelse($links as $link)
            <div class="history-item" style="padding:12px; border:1px solid var(--border); border-radius:12px; display:flex; flex-wrap:wrap; gap:10px; justify-content:space-between; align-items:center; background:#fdfdfd;">
                <div>
                    <div style="font-weight:700;">{{ $link->name }}</div>
                    <div class="muted" style="word-break:break-all;">{{ $link->target_url }}</div>
                    <div style="margin-top:6px;" class="badge">Slug: {{ $link->slug }}</div>
                </div>
                <div class="actions" data-qr-card data-url="{{ route('qr.redirect', $link->slug) }}">
                    <button class="btn ghost" type="button" data-toggle>Lihat QR</button>
                    <div class="qr-preview card" data-preview style="display:none; margin-top:12px; width:100%; gap:14px;">
                        <div style="display:flex; align-items:center; gap:16px; flex-wrap:wrap;">
                            <div class="qr-box" style="width:220px; height:220px; display:none;"></div>
                            <div style="flex:1; min-width:240px; display:grid; gap:10px;">
                                <div style="font-weight:700;">Pratinjau QR</div>
                                <div class="muted" style="word-break:break-all;">{{ route('qr.redirect', $link->slug) }}</div>
                                <div class="actions">
                                    <button class="btn primary" type="button" data-copy>Salin link</button>
                                    <button class="btn ghost" type="button" data-download>Unduh QR PNG</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty" data-empty-state>Belum ada QR yang disimpan.</div>
        @endforelse
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" integrity="sha512-LrM3t4YkSg8wPpVdZYkTfLZNVVRFlE0YyqS/fWznuaCG2lLBVmOAXoJ1i8LojRxurx8WcNKGqC5h0n0QY6tYKg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    const initializeQrCard = (card) => {
        const url = card.getAttribute('data-url');
        const toggleBtn = card.querySelector('[data-toggle]');
        const copyBtn = card.querySelector('[data-copy]');
        const downloadBtn = card.querySelector('[data-download]');
        const preview = card.querySelector('[data-preview]');
        const qrBox = card.querySelector('.qr-box');

        if (!url || !qrBox || !preview || !toggleBtn) return;

        let isRendered = false;

        toggleBtn?.addEventListener('click', () => {
            const isHidden = preview.style.display === 'none';
            preview.style.display = isHidden ? 'block' : 'none';

            if (isHidden && !isRendered) {
                new QRCode(qrBox, { text: url, width: 220, height: 220, correctLevel: QRCode.CorrectLevel.H });
                qrBox.style.display = 'block';
                isRendered = true;
            }
        });

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
    };

    document.querySelectorAll('[data-qr-card]').forEach(initializeQrCard);

    const form = document.querySelector('[data-create-form]');
    const formStatus = document.querySelector('[data-form-status]');
    const previewCard = document.querySelector('[data-live-preview]');
    const previewUrl = document.querySelector('[data-preview-url]');
    const previewQrBox = document.querySelector('[data-live-qr]');
    const copyPreviewBtn = document.querySelector('[data-preview-copy]');
    const downloadPreviewBtn = document.querySelector('[data-preview-download]');
    const historyList = document.querySelector('[data-history-list]');
    const emptyState = document.querySelector('[data-empty-state]');
    const totalBadge = document.querySelector('[data-total-count]');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    let currentPreviewUrl = '';

    const setStatus = (message) => {
        if (formStatus) formStatus.textContent = message ?? '';
    };

    const togglePreviewActions = (enabled) => {
        if (copyPreviewBtn) copyPreviewBtn.disabled = !enabled;
        if (downloadPreviewBtn) downloadPreviewBtn.disabled = !enabled;
    };

    const generatePreview = (text) => {
        if (!previewQrBox || !previewCard) return;
        previewQrBox.innerHTML = '';
        new QRCode(previewQrBox, { text, width: 220, height: 220, correctLevel: QRCode.CorrectLevel.H });
        previewQrBox.style.display = 'block';
        previewCard.style.display = 'grid';
        if (previewUrl) previewUrl.textContent = text;
        currentPreviewUrl = text;
        togglePreviewActions(true);
    };

    const addHistoryItem = (data) => {
        if (!historyList || !data?.redirect_url) return;
        const item = document.createElement('div');
        item.className = 'history-item';
        item.style.cssText = 'padding:12px; border:1px solid var(--border); border-radius:12px; display:flex; flex-wrap:wrap; gap:10px; justify-content:space-between; align-items:center; background:#fdfdfd;';
        item.innerHTML = `
            <div>
                <div style="font-weight:700;">${data.name ?? 'QR baru'}</div>
                <div class="muted" style="word-break:break-all;">${data.target_url ?? ''}</div>
                <div style="margin-top:6px;" class="badge">Slug: ${data.slug ?? ''}</div>
            </div>
            <div class="actions" data-qr-card data-url="${data.redirect_url}">
                <button class="btn ghost" type="button" data-toggle>Lihat QR</button>
                <div class="qr-preview card" data-preview style="display:none; margin-top:12px; width:100%; gap:14px;">
                    <div style="display:flex; align-items:center; gap:16px; flex-wrap:wrap;">
                        <div class="qr-box" style="width:220px; height:220px; display:none;"></div>
                        <div style="flex:1; min-width:240px; display:grid; gap:10px;">
                            <div style="font-weight:700;">Pratinjau QR</div>
                            <div class="muted" style="word-break:break-all;">${data.redirect_url}</div>
                            <div class="actions">
                                <button class="btn primary" type="button" data-copy>Salin link</button>
                                <button class="btn ghost" type="button" data-download>Unduh QR PNG</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        historyList?.prepend(item);
        const card = item.querySelector('[data-qr-card]');
        if (card) initializeQrCard(card);
    };

    const updateTotalBadge = () => {
        if (!totalBadge) return;
        const currentText = totalBadge.textContent ?? '';
        const matched = currentText.match(/\d+/);
        const currentNumber = matched ? Number(matched[0]) : 0;
        totalBadge.textContent = `Total: ${currentNumber + 1}`;
    };

    form?.addEventListener('submit', async (event) => {
        event.preventDefault();
        setStatus('Menyimpan...');
        togglePreviewActions(false);

        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                body: formData,
            });

            if (!response.ok) {
                const data = await response.json().catch(() => null);
                setStatus(data?.message ?? 'Gagal menyimpan QR. Periksa isian Anda.');
                return;
            }

            const data = await response.json();
            generatePreview(data.redirect_url);
            setStatus(data.message ?? 'QR berhasil disimpan dan siap dipakai.');
            updateTotalBadge();
            if (emptyState) emptyState.style.display = 'none';
            addHistoryItem({
                name: data.name ?? formData.get('name'),
                target_url: formData.get('target_url'),
                slug: data.slug,
                redirect_url: data.redirect_url,
            });
        } catch (error) {
            setStatus('Terjadi kesalahan jaringan.');
        }
    });

    copyPreviewBtn?.addEventListener('click', async () => {
        if (!currentPreviewUrl) return;
        try {
            await navigator.clipboard.writeText(currentPreviewUrl);
            setStatus('Tautan disalin.');
        } catch (error) {
            setStatus('Clipboard tidak tersedia.');
        }
    });

    downloadPreviewBtn?.addEventListener('click', () => {
        if (!currentPreviewUrl || !previewQrBox) return;
        const canvas = previewQrBox.querySelector('canvas');
        const image = previewQrBox.querySelector('img');
        const link = document.createElement('a');

        if (canvas) {
            link.href = canvas.toDataURL('image/png');
        } else if (image) {
            link.href = image.src;
        } else {
            setStatus('QR belum siap.');
            return;
        }

        link.download = 'qr-link.png';
        link.click();
    });
</script>
@endpush
