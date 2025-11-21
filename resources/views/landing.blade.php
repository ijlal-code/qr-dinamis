@extends('layouts.app')

@section('title', 'QR Dinamis | Ringan dan praktis')

@section('content')
<section class="card" style="display:grid; gap:10px;">
    <div class="chip">Versi ringan</div>
    <h1 style="margin:0; font-size:26px; letter-spacing:-0.02em;">QR code dinamis yang simpel</h1>
    <p class="muted" style="margin:0; max-width:720px; line-height:1.6;">Kelola tautan QR Anda, ubah targetnya kapan saja, dan bagikan ke mana pun. Masuk untuk melihat dashboard dan membuat QR baru.</p>
    <div class="actions" style="margin-top:4px; align-items:center; flex-wrap:wrap; gap:12px;">
        <a class="btn primary" href="{{ route('register') }}">Daftar sekarang</a>
        <a class="btn ghost" href="{{ route('login') }}">Sudah punya akun</a>
    </div>
</section>
@endsection
