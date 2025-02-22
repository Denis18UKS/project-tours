@extends('layouts.app')

@section('title', 'Туры для наблюдения за китами в России')

@section('content')
<div class="img-dolphins"></div>
<div class="container">
    <h1 class="page-title">Туры для наблюдения за китами в России</h1>

    <form action="{{ route('index') }}" method="GET" id="filter-form">
        <div class="filters-container">

            <div class="filters">
                <!-- Фильтры -->
                <div class="filter__group">
                    <h3 class="filter__title">Дата путешествия</h3>
                    <input type="date" name="date" class="filter__input" value="{{ request('date') }}" id="date-input" aria-label="Дата путешествия">
                </div>

                <div class="filter__group">
                    <h3 class="filter__title">Длительность (часы)</h3>
                    <div style="display: flex; gap: 10px;">
                        <input type="number" name="duration_min" placeholder="От" class="filter__input"
                            value="{{ request('duration_min', 3) }}" aria-label="Минимальная длительность">
                        <input type="number" name="duration_max" placeholder="До" class="filter__input"
                            value="{{ request('duration_max', 20) }}" aria-label="Максимальная длительность">
                    </div>
                </div>

                <div class="filter__group">
                    <h3 class="filter__title">Бюджет (₽)</h3>
                    <div style="display: flex; gap: 10px;">
                        <input type="number" name="price_min" placeholder="От" class="filter__input"
                            value="{{ request('price_min') }}" aria-label="Минимальная цена">
                        <input type="number" name="price_max" placeholder="До" class="filter__input"
                            value="{{ request('price_max') }}" aria-label="Максимальная цена">
                    </div>
                </div>
            </div>

            <div class="filters">
                <!-- Поиск -->
                <div class="filter__group">
                    <h3 class="filter__title">Поиск</h3>
                    <input type="text" name="search" class="filter__input" placeholder="Поиск по названию или локации"
                        value="{{ request('search') }}" aria-label="Поиск">
                </div>
            </div>

            <div class="filters">
                <!-- Сортировка -->
                <div class="filter__group">
                    <h3 class="filter__title">Сортировка</h3>
                    <select name="sort" class="filter__input" aria-label="Сортировка">
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>По возрастанию цены</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>По убыванию цены</option>
                        <option value="duration" {{ request('sort') == 'duration' ? 'selected' : '' }}>По длительности</option>
                    </select>
                </div>

                <button type="submit" class="filter__button">Применить фильтры</button>
                <button type="button" id="reset-filters" class="filter__button">Сбросить фильтры</button>
            </div>
        </div>
    </form>

    <div class="view-controls">
        <div>Найдено {{ $tours->total() }} туров</div>
    </div>

    <div class="tours-grid" id="tours-container">
        @foreach($tours as $tour)
        <div class="card mb-4 shadow-sm">
            <img src="{{ asset($tour->image_url) }}" class="card-img-top" alt="{{ $tour->name }}">
            <div class="card-body">
                <h5 class="card-title">{{ $tour->name }}</h5>
                <p class="card-text">{{ Str::limit($tour->description, 100) }}</p>
                <p class="tour-info"><strong>Локация:</strong> {{ $tour->location }}</p>
                <p class="tour-info"><strong>Длительность:</strong>
                    {{ $tour->duration }}
                    @if($tour->duration % 10 == 1 && $tour->duration != 11)
                    час
                    @elseif(in_array($tour->duration % 10, [2, 3, 4]) && !in_array($tour->duration % 100, [12, 13, 14]))
                    часа
                    @else
                    часов
                    @endif
                </p>
                <p class="tour-info"><strong>Цена:</strong> {{ number_format($tour->price, 0, ',', ' ') }} ₽</p>

                @if(!empty($tour->available_dates))
                <p class="tour-info"><strong>Дата:</strong> {{ \Carbon\Carbon::parse($tour->available_dates[0])->format('d.m.Y') }}</p>
                @endif

                @if($tour->status === 'active')
                <a href="{{ route('tour.show', $tour->id) }}" class="btn btn-primary w-100 mt-3">Подробнее</a>
                @else
                <button class="btn btn-secondary w-100 mt-3" disabled>Недоступен</button>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    {{ $tours->links() }}
</div>

<footer class="footer" id="footer">
    <div class="footer__container">
        <div class="footer__left">
            <div class="footer__scroll-top">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 19V5M12 5L5 12M12 5L19 12" stroke="white" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>
            <div class="footer__company-info">
                <div>© 2005–2025 RussiaDiscovery</div>
                <div>115432, Москва, ул. 5-я Кожуховская, д. 10</div>
                <div>ИНН: 7729729154</div>
                <div>ОГРН: 1127747289471</div>
            </div>
        </div>

        <div class="footer__center">
            Полное или частичное копирование изображений и текстов<br>
            возможно только с указанием активной ссылки на сайт<br>
            RussiaDiscovery
        </div>

        <div class="footer__right">
            <a href="/agreement" class="footer__link">Пользовательское соглашение</a>
            <a href="/privacy" class="footer__link">Политика конфиденциальности</a>
            <a href="/personal-data" class="footer__link">Политика обработки персональных данных</a>
            <a href="/cookies" class="footer__link">Политика использования Cookie файлов</a>
        </div>
    </div>
</footer>

<style>
    .filters-container {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
    }

    .filters {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .filters .filter__group {
        width: 250px;
    }

    .tours-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .tours-list .card {
        display: grid;
        grid-template-columns: 200px 1fr;
        gap: 20px;
    }

    .tours-list .card-img-top {
        height: 100%;
        object-fit: cover;
    }

    .available-dates {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 8px;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 4px;
    }

    .tour-info {
        font-size: 0.875rem;
        line-height: 1.5;
        margin: 5px 0;
    }

    .tour-info strong {
        font-weight: 600;
    }

    .card-body p {
        margin-bottom: 8px;
    }

    @media (max-width: 768px) {
        .tours-list .card {
            grid-template-columns: 1fr;
        }

        .filters {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    document.getElementById('reset-filters').addEventListener('click', function() {
        document.getElementById('filter-form').reset();
        window.location.href = window.location.pathname; // сброс параметров URL
    });
</script>

@endsection
