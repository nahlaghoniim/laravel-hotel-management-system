<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Grand Horizon Hotels — Where Every Stay Becomes a Story')</title>
    <meta name="description" content="Grand Horizon Hotels — luxury five-star stays across 12 cities. Book your stay online.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    {{-- Font Awesome — use CDN so it works without local vendor files --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Per-page extra CSS (e.g. from home.blade.php) --}}
    @yield('extra_css')
</head>
<body>

    {{-- ══════════════════════════════════════
         FLASH MESSAGES (global)
    ══════════════════════════════════════ --}}
    @if(session('success'))
        <div style="position:fixed;top:1rem;right:1rem;z-index:9999;padding:12px 20px;background:#2e7d4f;color:#fff;border-radius:6px;font-size:13px;box-shadow:0 4px 16px rgba(0,0,0,0.2)">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="position:fixed;top:1rem;right:1rem;z-index:9999;padding:12px 20px;background:#8b3a2a;color:#fff;border-radius:6px;font-size:13px;box-shadow:0 4px 16px rgba(0,0,0,0.2)">
            {{ session('error') }}
        </div>
    @endif

    {{-- ══════════════════════════════════════
         MAIN PAGE CONTENT
    ══════════════════════════════════════ --}}
    @yield('content')

    {{-- ══════════════════════════════════════
         PER-PAGE SCRIPTS
    ══════════════════════════════════════ --}}
    @yield('extra_js')

    {{-- Auto-dismiss flash messages --}}
    <script>
        (function () {
            var flashes = document.querySelectorAll('[style*="position:fixed"][style*="z-index:9999"]');
            flashes.forEach(function (el) {
                setTimeout(function () {
                    el.style.transition = 'opacity 0.5s';
                    el.style.opacity = '0';
                    setTimeout(function () { el.remove(); }, 500);
                }, 4000);
            });
        })();
    </script>

</body>
</html>