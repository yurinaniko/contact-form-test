<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionablyLate</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inika&display=swap" rel="stylesheet">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header_inner">
            <h1 class="logo">FashionablyLate</h1>

                <nav class="nav">
                    @auth
                    {{-- ログイン中のみ表示 --}}
                        <form method="POST" action="{{ route('logout') }}">
                        @csrf
                            <button type="submit" class="nav-btn">logout</button>
                        </form>
                    @endauth

                    @guest
                        @php
                            $hidePages = [
                                    'contact',
                                    'contact/confirm',
                                    'contact/thanks',
                            ];
                        @endphp

                        {{-- login ボタン --}}
                        @if (!Request::is($hidePages) && !Request::is('login'))
                            <a href="{{ route('login') }}" class="nav-btn">login</a>
                        @endif

                        {{-- register ボタン --}}
                        @if (!Request::is($hidePages) && !Request::is('register'))
                            <a href="{{ route('register') }}" class="nav-btn">register</a>
                        @endif
                    @endguest
                </nav>
        </div>
    </header>

    <main>
    @yield('content')
    </main>
</body>
</html>
