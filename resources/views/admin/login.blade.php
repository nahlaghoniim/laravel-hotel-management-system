<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Staff Login · {{ config('app.name', 'Hotel Management') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #f5f0e8;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        /* Subtle background pattern */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80'%3E%3Ccircle cx='40' cy='40' r='1' fill='%23c9a84c' opacity='0.12'/%3E%3C/svg%3E");
            pointer-events: none;
        }

        .card {
            display: flex;
            width: 100%;
            max-width: 900px;
            min-height: 560px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 24px 80px rgba(30, 18, 4, 0.18), 0 4px 16px rgba(30, 18, 4, 0.1);
            position: relative;
        }

        /* ── Left decorative panel ── */
        .panel-left {
            flex: 1.1;
            background: linear-gradient(160deg, #1a1208 0%, #2e1f08 50%, #3d2a0c 100%);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 2.5rem;
            overflow: hidden;
        }

        .panel-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60'%3E%3Cpath d='M30 5 L35 20 L50 20 L38 29 L43 44 L30 35 L17 44 L22 29 L10 20 L25 20Z' fill='none' stroke='%23c9a84c' stroke-width='0.5' opacity='0.2'/%3E%3C/svg%3E") repeat;
        }

        .panel-left::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 30% 70%, rgba(201,168,76,0.12) 0%, transparent 70%);
        }

        .panel-content { position: relative; z-index: 1; }

        .hotel-monogram {
            font-family: 'Cormorant Garamond', serif;
            font-size: 64px;
            font-weight: 300;
            color: #c9a84c;
            line-height: 1;
            letter-spacing: 6px;
            margin-bottom: 0.25rem;
        }

        .hotel-name {
            font-size: 11px;
            color: rgba(201,168,76,0.6);
            letter-spacing: 3.5px;
            text-transform: uppercase;
            margin-bottom: 2rem;
        }

        .gold-line {
            width: 48px;
            height: 1px;
            background: linear-gradient(90deg, transparent, #c9a84c, transparent);
            margin-bottom: 1.5rem;
        }

        .panel-heading {
            font-family: 'Cormorant Garamond', serif;
            font-size: 30px;
            font-weight: 300;
            color: #f5e6c8;
            line-height: 1.4;
        }

        .panel-sub {
            margin-top: 0.75rem;
            font-size: 11px;
            color: rgba(201,168,76,0.5);
            letter-spacing: 0.5px;
        }

        /* ── Right form panel ── */
        .panel-right {
            flex: 1;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3rem 2.5rem;
        }

        .form-heading {
            font-family: 'Cormorant Garamond', serif;
            font-size: 30px;
            font-weight: 500;
            color: #1a1208;
            margin-bottom: 0.25rem;
        }

        .form-sub {
            font-size: 13px;
            color: #888070;
            margin-bottom: 2.25rem;
        }

        /* Alert messages */
        .alert {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 1.5rem;
        }
        .alert-danger { background: #fef2f0; color: #c0392b; border: 1px solid #f5c6c2; }
        .alert-success { background: #f0faf4; color: #1e7a44; border: 1px solid #b7dfca; }

        .form-group { margin-bottom: 1.5rem; }

        .form-label {
            display: block;
            font-size: 10.5px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #888070;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            border: none;
            border-bottom: 1.5px solid #e0d8cc;
            border-radius: 0;
            background: transparent;
            padding: 10px 0;
            font-size: 14.5px;
            color: #1a1208;
            font-family: 'DM Sans', sans-serif;
            outline: none;
            transition: border-color 0.25s;
        }

        .form-control:focus { border-bottom-color: #c9a84c; }
        .form-control::placeholder { color: #c0b8a8; }

        .form-control.is-invalid { border-bottom-color: #e74c3c; }
        .invalid-feedback { font-size: 12px; color: #e74c3c; margin-top: 4px; }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 1.75rem;
        }

        .remember-row input[type="checkbox"] {
            accent-color: #c9a84c;
            width: 15px;
            height: 15px;
            cursor: pointer;
        }

        .remember-row label {
            font-size: 13px;
            color: #888070;
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: #1a1208;
            border: none;
            color: #c9a84c;
            font-family: 'DM Sans', sans-serif;
            font-size: 11px;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            font-weight: 500;
            cursor: pointer;
            border-radius: 4px;
            transition: background 0.2s, color 0.2s, transform 0.1s;
        }

        .btn-login:hover { background: #c9a84c; color: #1a1208; }
        .btn-login:active { transform: scale(0.99); }

        .form-links {
            display: flex;
            justify-content: space-between;
            margin-top: 1.5rem;
        }

        .form-links a {
            font-size: 12px;
            color: #888070;
            text-decoration: none;
            letter-spacing: 0.2px;
            transition: color 0.2s;
        }

        .form-links a:hover { color: #c9a84c; }

        /* ── Responsive ── */
        @media (max-width: 640px) {
            .panel-left { display: none; }
            .panel-right { padding: 2.5rem 1.75rem; }
        }
    </style>
</head>
<body>

<div class="card">

    {{-- Left decorative panel --}}
    <div class="panel-left">
        <div class="panel-content">
            <div class="hotel-monogram">GH</div>
            <div class="hotel-name">Grand Horizon Hotels</div>
            <div class="gold-line"></div>
            <div class="panel-heading">
                Where every detail<br>is a luxury
            </div>
            <div class="panel-sub">Staff management portal &middot; Restricted access</div>
        </div>
    </div>

    {{-- Right form panel --}}
    <div class="panel-right">

        <div class="form-heading">Staff Login</div>
        <div class="form-sub">Enter your credentials to access the dashboard</div>

        {{-- Session errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST" novalidate>
            @csrf

            <div class="form-group">
                <label class="form-label" for="email">Email address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    placeholder="your@email.com"
                    value="{{ old('email') }}"
                    autofocus
                    autocomplete="email"
                >
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="••••••••"
                    autocomplete="current-password"
                >
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="remember-row">
                <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">Keep me signed in</label>
            </div>

            <button type="submit" class="btn-login">Sign in to portal</button>

        </form>

        <div class="form-links">
            <a href="#">Forgot password?</a>
            <a href="mailto:it@yourdomain.com">Request access</a>
        </div>

    </div>
</div>

</body>
</html>