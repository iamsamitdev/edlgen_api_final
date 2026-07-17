<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ  EDL-GEN</title>
    <link rel="icon" href="{{ asset('images/logo-edl-gen.jpg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anuphan:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --surface-1: #fcfcfb;
            --page-plane: #f4f5f3;
            --text-primary: #0b0b0b;
            --text-secondary: #52514e;
            --text-muted: #898781;
            --border: rgba(11,11,11,0.10);
            --card-shadow: 0 1px 2px rgba(11,11,11,0.04), 0 8px 30px rgba(11,11,11,0.08);
            --series-1: #2a78d6;
            --bad: #c9463c;
            --bad-wash: rgba(201,70,60,0.10);
        }
        @media (prefers-color-scheme: dark) {
            :root {
                --surface-1: #1a1a19;
                --page-plane: #0d0d0d;
                --text-primary: #ffffff;
                --text-secondary: #c3c2b7;
                --text-muted: #898781;
                --border: rgba(255,255,255,0.10);
                --card-shadow: 0 1px 2px rgba(0,0,0,0.3), 0 8px 30px rgba(0,0,0,0.4);
                --series-1: #3987e5;
                --bad: #e2695f;
                --bad-wash: rgba(226,105,95,0.14);
            }
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            background: var(--page-plane);
            color: var(--text-primary);
            font-family: 'Inter', 'Anuphan', sans-serif;
            -webkit-font-smoothing: antialiased;
            padding: 20px;
        }
        .login-card {
            width: 100%; max-width: 380px;
            background: var(--surface-1);
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            padding: 32px 28px;
        }
        .login-card .brand { display: flex; flex-direction: column; align-items: center; gap: 10px; margin-bottom: 24px; }
        .login-card .brand img { width: 64px; height: 64px; border-radius: 50%; }
        .login-card .brand h1 { margin: 0; font-size: 18px; font-weight: 700; }
        .login-card .brand p { margin: 0; font-size: 12.5px; color: var(--text-muted); }
        .field { margin-bottom: 16px; display: flex; flex-direction: column; gap: 6px; }
        .field label { font-size: 12.5px; font-weight: 600; color: var(--text-secondary); }
        .field input {
            font-family: inherit; font-size: 14px; padding: 10px 12px;
            border: 1px solid var(--border); border-radius: 8px; background: var(--page-plane); color: var(--text-primary);
        }
        .field input:focus { outline: 2px solid var(--series-1); outline-offset: 1px; }
        .remember { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--text-secondary); margin-bottom: 18px; }
        .btn-submit {
            width: 100%; font-family: inherit; font-size: 14px; font-weight: 700; cursor: pointer;
            padding: 11px; border-radius: 8px; border: none; background: var(--series-1); color: #fff;
        }
        .btn-submit:hover { filter: brightness(0.95); }
        .error-box {
            background: var(--bad-wash); color: var(--bad); border-radius: 8px;
            padding: 10px 12px; font-size: 13px; margin-bottom: 16px;
        }
        .hint { margin-top: 18px; font-size: 12px; color: var(--text-muted); text-align: center; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="brand">
            <img src="{{ asset('images/logo-edl-gen.jpg') }}" alt="EDL-GEN">
            <h1>EDL-GEN Dashboard</h1>
            <p>เข้าสู่ระบบเพื่อดูข้อมูลแจ้งเหตุ</p>
        </div>

        @if ($errors->any())
            <div class="error-box">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="field">
                <label for="email">อีเมล</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            </div>
            <div class="field">
                <label for="password">รหัสผ่าน</label>
                <input type="password" id="password" name="password" required autocomplete="current-password">
            </div>
            <label class="remember">
                <input type="checkbox" name="remember" style="width:auto;">
                จดจำการเข้าสู่ระบบ
            </label>
            <button type="submit" class="btn-submit">เข้าสู่ระบบ</button>
        </form>
        <p class="hint">EDL-GEN &mdash; ระบบติดตามข้อมูลแจ้งเหตุ</p>
    </div>
</body>
</html>
