<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk | QR Dinamis</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', system-ui, -apple-system, sans-serif; margin: 0; background: #f8fafc; color: #0f172a; }
        .wrapper { min-height: 100vh; display: grid; place-items: center; padding: 24px; }
        .card { width: min(420px, 100%); background: #fff; border-radius: 16px; padding: 24px; box-shadow: 0 12px 30px rgba(15,23,42,0.08); border: 1px solid #e2e8f0; }
        h1 { margin: 0 0 8px; font-size: 24px; }
        p { margin: 0 0 18px; color: #475569; }
        label { display: block; font-weight: 600; margin-bottom: 6px; }
        input[type=email], input[type=password] { width: 100%; padding: 12px 14px; border-radius: 12px; border: 1px solid #e2e8f0; background: #f8fafc; }
        input:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.15); background: #fff; }
        .actions { display: flex; flex-direction: column; gap: 12px; margin-top: 14px; }
        button { border: none; background: #2563eb; color: #fff; padding: 12px 16px; border-radius: 12px; font-weight: 700; cursor: pointer; }
        .link { text-align: center; font-size: 14px; }
        a { color: #2563eb; font-weight: 600; text-decoration: none; }
        .error { color: #dc2626; font-size: 14px; margin-top: 4px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <h1>Masuk</h1>
            <p>Login untuk mulai membuat dan mengelola QR dinamis.</p>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div>
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div style="margin-top:12px;">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>
                    @error('password')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div style="margin-top:12px; display:flex; gap:8px; align-items:center;">
                    <input type="checkbox" id="remember" name="remember" style="width:16px; height:16px;">
                    <label for="remember" style="margin:0; font-weight:500;">Ingat saya</label>
                </div>
                <div class="actions">
                    <button type="submit">Masuk</button>
                </div>
                <div class="link">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></div>
            </form>
        </div>
    </div>
</body>
</html>
