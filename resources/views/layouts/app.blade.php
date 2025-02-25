<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Russia Discovery - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/app.css">
</head>

<body>
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="header__wrapper">
                    <div class="header__schedule">
                        Пн-Пт: 10:00-20:00 | Сб: 11:00-18:00
                    </div>
                </div>
            </div>
        </div>
        <div class="header__main">
            <div class="container">
                <div class="header__wrapper">
                    <a href="/" class="logo">Наблюдение за китами</a>
                    <nav class="nav">
                        <ul class="nav__menu">
                            @guest
                            <li><a href="{{route('tour')}}" class="nav__link">Туры</a></li>
                            <li><a href="#" class="nav__link" data-bs-toggle="modal" data-bs-target="#contactModal">Контакты</a></li>
                            <li><a href="{{route('signin')}}" class="nav__link">Войти</a></li>
                            @endguest
                            @auth
                            @if (auth()->user()->role === 'admin')
                            <li><a href="{{route('adminIndex')}}" class="nav__link">Управление турами</a></li>
                            <li><a href="{{route('AdminApp')}}" class="nav__link">Бронь туров</a></li>
                            <li>({{ auth()->user()->full_name }})</li>
                            @else
                            <li><a href="{{route('tour')}}" class="nav__link">Туры</a></li>
                            <li><a href="#" class="nav__link" data-bs-toggle="modal" data-bs-target="#contactModal">Контакты</a></li>
                            <li><a href="{{route('home')}}" class="nav__link">Личный кабинет ({{ auth()->user()->full_name }})</a></li>

                            @endif
                            <li><a href="{{route('logout')}}" class="nav__link">Выйти</a></li>
                            @endauth
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- Modal -->
    <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactModalLabel">Контактная информация</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Телефон:</strong> +7 123 456 7890</p>
                    <p><strong>Электронная почта:</strong> info@russiadiscovery.com</p>
                    <p><strong>Адрес:</strong> Москва, ул. Пушкина, д. 10</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>

    <main class="main">
        @yield('content')
    </main>

</body>

</html>
<script>
    document.querySelector('.footer__scroll-top').addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
</script>
