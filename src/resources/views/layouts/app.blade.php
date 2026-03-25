<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Flea Market')</title>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a href="{{ url('/') }}" class="header__logo">
                <img class="header__logo-img" src="{{ asset('img/header-logo.png') }}" alt="代替テキスト">
            </a>

            <form action="{{ url('/') }}" method="GET" class="header__search-form">
                <input
                    type="text"
                    name="keyword"
                    value="{{ request('keyword') }}"
                    placeholder="なにをお探しですか？"
                    class="header__search-input"
                >
                @if(request('tab'))
                    <input type="hidden" name="tab" value="{{ request('tab') }}">
                @endif
            </form>

            <nav class="header__nav">
                @auth
                    <form action="{{ route('logout') }}" method="POST" class="header__logout-form">
                        @csrf
                        <button type="submit" class="header__link header__logout-button">ログアウト</button>
                    </form>
                @else
                    <a href="{{ url('/login') }}" class="header__link">ログイン</a>
                @endauth
                    <a href="{{ url('/mypage') }}" class="header__link">マイページ</a>
                    <a href="{{ url('/sell') }}" class="header__button">出品</a>
            </nav>
        </div>
    </header>

    <main class="main">
        @if(session('success'))
            <div class="flash flash--success">
                {{ session('success') }}
            </div>
        @endif
        @if (count($errors) > 0)
        <ul>
        @foreach ($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
        </ul>
        @endif

        @yield('content')
    </main>
</body>
</html>