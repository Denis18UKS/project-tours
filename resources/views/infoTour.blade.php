@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Основная информация о туре -->
        <div class="col-md-8">

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h1 class="card-title">{{ $tour->name }}</h1>
                    <p class="text-muted"><i class="fas fa-map-marker-alt"></i> {{ $tour->location }}</p>
                    <p class="lead">{{ $tour->description }}</p>
                </div>
                <img src="{{ asset($tour->image_url) }}" class="card-img-top rounded" alt="{{ $tour->name }}">

            </div>


        </div>

        <!-- Боковая панель с ценой и датами -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h4 class="text-success fw-bold">{{ number_format($tour->price, 2) }} ₽</h4>
                    <p><strong><i class="fas fa-clock"></i> Длительность:</strong> {{ $tour->duration }}
                        @if($tour->duration % 10 == 1 && $tour->duration % 100 != 11)
                        час
                        @elseif(in_array($tour->duration % 10, [2, 3, 4]) && !in_array($tour->duration % 100, [12, 13, 14]))
                        часа
                        @else
                        часов
                        @endif
                    </p>

                    <p><strong><i class="fas fa-calendar-alt"></i> Доступные даты:</strong></p>

                    @php
                    $dates = is_string($tour->available_dates) ? json_decode($tour->available_dates, true) : $tour->available_dates;
                    @endphp

                    <ul class="list-group mb-3">
                        @foreach($dates as $date)
                        <li class="list-group-item">{{ date('d.m.Y', strtotime($date)) }}</li>

                        @endforeach
                    </ul>
                    <form action="{{ route('bookings.store', $tour->id) }}" method="POST">
                        @csrf

                        <!-- Список доступных дат -->
                        <div class="mb-3">
                            <label for="booking_date" class="form-label">Выберите дату:</label>
                            <select name="booking_date" id="booking_date" class="form-control" required>
                                <option value="" disabled selected>Выберите дату</option>
                                @foreach($dates as $date)
                                <option value="{{ $date }}">{{ date('d.m.Y', strtotime($date)) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Количество мест -->
                        <input type="number" name="seats_booked" class="form-control mb-2" placeholder="Количество мест"
                            required>
                        @auth
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-check-circle"></i> Забронировать
                        </button>
                        @endauth
                        @guest
                        <p>Для брони авторизируйтесь</p>
                        @endguest

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
