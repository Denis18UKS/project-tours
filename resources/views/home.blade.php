@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')

    <div class="container py-5">
        <div class="row">
            <!-- Боковая панель с информацией о пользователе -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <div class="avatar mb-3">
                                <span class="avatar-text">{{ substr(auth()->user()->full_name, 0, 1) }}</span>
                            </div>
                            <h5 class="card-title mb-1">{{ auth()->user()->full_name }}</h5>
                            <p class="text-muted">{{ auth()->user()->email }}</p>
                        </div>

                        <div class="user-info">
                            <div class="mb-3">
                                <label class="form-label text-muted">Телефон</label>
                                <p class="mb-0">{{ auth()->user()->phone_number }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Дата регистрации</label>
                                <p class="mb-0">{{ auth()->user()->created_at->format('d.m.Y') }}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Основной контент -->
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="tours-tab" data-bs-toggle="tab" data-bs-target="#tours"
                                    type="button" role="tab">
                                    Мои туры
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history"
                                    type="button" role="tab">
                                    История бронирований
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <!-- Активные туры -->
                            <div class="tab-pane fade show active" id="tours" role="tabpanel">
                                @if($bookedTours->whereIn('status', ['pending', 'active'])->count() > 0)
                                    @foreach($bookedTours->whereIn('status', ['pending', 'active']) as $booking)
                                        <div class="tour-card mb-4">
                                            <div class="row g-0">
                                                <div class="col-md-4">
                                                    <img src="{{ asset($booking->tour->image_url) }}"
                                                        class="img-fluid rounded-start" alt="{{ $booking->tour->name }}">
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{ $booking->tour->name }}</h5>
                                                        <p class="card-text">{{ Str::limit($booking->tour->description, 100) }}</p>

                                                        <div class="tour-details">
                                                            <div class="mb-2">
                                                                <i class="bi bi-geo-alt"></i>
                                                                <span>{{ $booking->tour->location }}</span>
                                                            </div>
                                                            <div class="mb-2">
                                                                <i class="bi bi-calendar3"></i>
                                                                <span>Дата тура:
                                                                    {{ \Carbon\Carbon::parse($booking->date)->format('d.m.Y') }}</span>
                                                            </div>
                                                            <div class="mb-2">
                                                                <i class="bi bi-clock"></i>
                                                                <span>Длительность: {{ $booking->tour->duration }} часов</span>
                                                            </div>
                                                            <div class="mb-2">
                                                                <i class="bi bi-person"></i>
                                                                <span>Количество мест: {{ $booking->seats_booked }}</span>
                                                            </div>
                                                            <div class="booking-status">
                                                                Статус:
                                                                <span
                                                                    class="badge {{ $booking->status === 'pending' ? 'bg-warning' : 'bg-success' }}">
                                                                    {{ $booking->status === 'pending' ? 'Ожидает подтверждения' : 'Подтверждено' }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-5">
                                        <h5>У вас пока нет активных туров</h5>
                                        <p class="text-muted">Самое время отправиться в путешествие!</p>
                                        <a href="{{ route('tour') }}" class="btn btn-primary">Посмотреть туры</a>
                                    </div>
                                @endif
                            </div>

                            <!-- История бронирований -->
                            <div class="tab-pane fade" id="history" role="tabpanel">
                                @if($bookedTours->whereIn('status', ['completed', 'confirmed'])->count() > 0)
                                    @foreach($bookedTours->whereIn('status', ['completed', 'confirmed']) as $booking)
                                        <div class="tour-card mb-4">
                                            <div class="row g-0">
                                                <div class="col-md-4">
                                                    <img src="{{ asset($booking->tour->image_url) }}"
                                                        class="img-fluid rounded-start" alt="{{ $booking->tour->name }}">
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{ $booking->tour->name }}</h5>
                                                        <div class="tour-details">
                                                            <div class="mb-2">
                                                                <i class="bi bi-calendar3"></i>
                                                                <span>Дата тура:
                                                                    {{ \Carbon\Carbon::parse($booking->date)->format('d.m.Y') }}</span>
                                                            </div>
                                                            <div class="mb-2">
                                                                <i class="bi bi-person"></i>
                                                                <span>Количество мест: {{ $booking->seats_booked }}</span>
                                                            </div>
                                                            <div class="booking-status">
                                                                Статус:
                                                                <span
                                                                    class="badge {{ $booking->status === 'completed' ? 'bg-danger' : 'bg-secondary' }}">
                                                                    {{ $booking->status === 'completed' ? 'Отменён' : 'Завершён' }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-5">
                                        <p class="text-muted">История бронирований пуста</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <style>
        .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .avatar-text {
            font-size: 2rem;
            color: #6c757d;
        }

        .tour-card {
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            overflow: hidden;
            transition: transform 0.2s;
        }

        .tour-card:hover {
            transform: translateY(-2px);
        }

        .tour-details {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .tour-details i {
            margin-right: 0.5rem;
        }

        .nav-tabs .nav-link {
            color: #6c757d;
        }

        .nav-tabs .nav-link.active {
            color: #0d6efd;
            font-weight: 500;
        }

        .booking-status {
            margin-top: 1rem;
        }

        .btn-outline-primary:hover {
            background-color: #0d6efd;
            color: white;
        }

        .img-fluid {
            height: 200px;
            object-fit: cover;
        }
    </style>
@endsection
