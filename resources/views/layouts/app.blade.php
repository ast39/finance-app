@php
    use App\Libs\Icons;
@endphp

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('logo.png') }}">

    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef"/>
    <link rel="apple-touch-icon" href="{{ asset('/logo.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Fa Icons CSS (CDN) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img class="me-2 mb-2" src="{{ asset('/logo.png') }}" width="30" height="30" />
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @if (Route::has('deposit.calc.create'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('deposit.calc.create') }}">{!! Icons::get(Icons::CHECK_UP) !!} {{ __('Рассчитать вклад') }}</a>
                            </li>
                        @endif

                        @if (Route::has('credit.calc.create'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('credit.calc.create') }}">{!! Icons::get(Icons::CHECK_DOWN) !!} {{ __('Рассчитать кредит') }}</a>
                            </li>
                        @endif

                        @if (Route::has('credit.check.create'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('credit.check.create') }}">{!! Icons::get(Icons::CHECK) !!} {{ __('Проверить кредит') }}</a>
                            </li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            @if (Route::has('wall.index'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('wall.index') }}">{!! Icons::get(Icons::CALENDAR) !!} {{ __('События') }}</a>
                                </li>
                            @endif

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {!! Icons::get(Icons::USER) !!} {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @if (Route::has('wallet.index'))
                                        <a class="dropdown-item" href="{{ route('wallet.index') }}">{!! Icons::get(Icons::WALLET) !!} {{ __('Кошельки') }}</a>
                                    @endif

                                    @if (Route::has('credit.index'))
                                        <a class="dropdown-item" href="{{ route('credit.index') }}">{!! Icons::get(Icons::CREDITS) !!}  {{ __('Кредиты') }}</a>
                                    @endif

                                    @if (Route::has('deposit.index'))
                                        <a class="dropdown-item" href="{{ route('deposit.index') }}">{!! Icons::get(Icons::DEPOSITS) !!} {{ __('Вклады') }}</a>
                                    @endif

                                    @if (Route::has('spend.index'))
                                        <a class="dropdown-item" href="{{ route('spend.index') }}">{!! Icons::get(Icons::SPEND) !!} {{ __('Траты') }}</a>
                                    @endif

                                    @if (Route::has('spend.category.index'))
                                        <a class="dropdown-item" href="{{ route('spend.category.index') }}">{!! Icons::get(Icons::CATEGORY) !!} {{ __('Категории') }}</a>
                                    @endif

                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {!! Icons::get(Icons::LOGOUT) !!} {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Footer -->
    <footer class="text-center text-lg-start bg-light text-muted">
        <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
            <div>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-google"></i>
                </a>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-linkedin"></i>
                </a>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-github"></i>
                </a>
            </div>
        </section>

        <section class="">
            <div class="container text-center text-md-start mt-5">
                <div class="row mt-3">
                    <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                        <h6 class="text-uppercase fw-bold mb-4">
                            <i class="fas fa-gem me-3"></i>MyFinances
                        </h6>
                        <p>
                            Это персональное финансовое приложение, разработанное как PWA (Progressive Web Application)
                            на основе Laravel.
                            <br /><br />
                            Актуальная версия приложения 2.0.1
                        </p>
                    </div>

                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                        <h6 class="text-uppercase fw-bold mb-4">
                            Открытые модули
                        </h6>
                        <p>Кредитный калькулятор</p>
                        <p>Калькулятор вкладов</p>
                        <p>Проверка кредита</p>
                    </div>

                    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                        <h6 class="text-uppercase fw-bold mb-4">
                            Закрытые модули
                        </h6>
                        <p>Домашняя бухгалтерия</p>
                        <p>Учет расходов</p>
                        <p>Финансовый менеджер</p>
                    </div>

                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                        <h6 class="text-uppercase fw-bold mb-4">Контакты</h6>
                        <p><i class="fas fa-home me-3">Адрес: </i> Россия, Калининград, 236048</p>
                        <p><i class="fas fa-envelope me-3">Email:</i> alexandr.status@gmail.com</p>
                        <p><i class="fas fa-phone me-3">Тел.:</i> +7 911 487 7251</p>
                    </div>
                </div>
            </div>
        </section>

        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2022-{{ date('Y', time()) }} Copyright:
            <a class="text-reset fw-bold" href="#">ASt Group</a>
        </div>
    </footer>

@stack('js')

<script src="{{ asset('/sw.js') }}"></script>
<script>
    if (!navigator.serviceWorker.controller) {
        navigator.serviceWorker.register("/sw.js").then(function (reg) {
            console.log("Service Worker был зарегистрирован для области действия: " + reg.scope);
        });
    }
</script>
</body>
</html>
