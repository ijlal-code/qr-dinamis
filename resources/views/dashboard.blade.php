@extends('layouts.app')

@section('title', 'Dashboard | QR Dinamis')

@section('content')
<section style="display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap;">
    <div>
        <div class="chip">Dashboard</div>
        <h1 style="margin:6px 0 4px;">Selamat datang, {{ auth()->user()->name }}</h1>
        <p class="muted" style="margin:0;">Lihat QR yang sudah dibuat, edit atau hapus sesuai kebutuhan.</p>
    </div>
    <div class="actions">
        <a class="btn primary" href="{{ route('qr-links.create') }}">Buat QR baru</a>
    </div>
</section>

<section class="card">
    @if (session('status'))
        <div class="alert" style="margin-bottom:12px;">{{ session('status') }}</div>
    @endif
    <div style="display:flex; align-items:center; justify-content:space-between; gap:8px; flex-wrap:wrap; margin-bottom:12px;">
        <h2 style="margin:0;">Daftar QR Anda</h2>
        <span class="badge">Total: {{ $links->count() }}</span>
    </div>
    @if($links->isEmpty())
        <div class="empty">
            Belum ada QR yang disimpan. <a href="{{ route('qr-links.create') }}">Buat QR pertama Anda</a>.
        </div>
    @else
        <div style="overflow-x:auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Tautan</th>
                        <th>Slug</th>
                        <th>Scan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($links as $link)
                    <tr>
                        <td>{{ $link->name }}</td>
                        <td><div class="muted" style="max-width:340px; word-break:break-all;">{{ $link->target_url }}</div></td>
                        <td><code>{{ $link->slug }}</code></td>
                        <td>{{ $link->visit_count }}</td>
                        <td>
                            <div class="actions">
                                <a class="btn ghost" href="{{ route('qr.redirect', $link->slug) }}" target="_blank" rel="noopener">Lihat</a>
                                <a class="btn primary" href="{{ route('qr-links.edit', $link) }}">Edit</a>
                                <form method="POST" action="{{ route('qr-links.destroy', $link) }}" onsubmit="return confirm('Hapus QR ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn danger">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</section>
@endsection
