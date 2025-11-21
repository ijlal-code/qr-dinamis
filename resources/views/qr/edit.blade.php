@extends('layouts.app')

@section('title', 'Edit QR | QR Dinamis')

@section('content')
<section style="display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap;">
    <div>
        <div class="chip">Edit QR</div>
        <h1 style="margin:6px 0 4px;">Perbarui QR {{ $link->name }}</h1>
        <p class="muted" style="margin:0;">Sesuaikan nama atau tautan tujuan lalu simpan.</p>
    </div>
    <div class="actions">
        <a class="btn ghost" href="{{ route('dashboard') }}">Kembali</a>
        <a class="btn primary" href="{{ route('qr-links.create') }}">Buat QR baru</a>
    </div>
</section>

<section class="card" style="display:grid; gap:14px;">
    <form method="POST" action="{{ route('qr-links.update', $link) }}">
        @csrf
        @method('PUT')
        <div>
            <label for="name">Nama QR</label>
            <input id="name" name="name" type="text" class="input" value="{{ old('name', $link->name) }}" required>
            @error('name')<div class="muted" style="color:#dc2626; font-size:14px;">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="target_url">Tautan tujuan</label>
            <input id="target_url" name="target_url" type="url" class="input" value="{{ old('target_url', $link->target_url) }}" required>
            @error('target_url')<div class="muted" style="color:#dc2626; font-size:14px;">{{ $message }}</div>@enderror
        </div>
        <div class="actions">
            <button type="submit" class="btn primary">Simpan perubahan</button>
            <a class="btn ghost" href="{{ route('dashboard') }}">Batal</a>
        </div>
    </form>
</section>
@endsection
