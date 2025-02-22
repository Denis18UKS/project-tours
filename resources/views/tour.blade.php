@extends('layouts.app')

@section('title', 'Туры для наблюдения за китами в России')

@section('content')
<div class="container">
    <h1>Туры по России</h1>

    <div class="tours-grid">
        @foreach($tours as $tour)
        <div class="card mb-4 shadow-sm">
            <img src="{{ asset($tour->image_url) }}" class="card-img-top" alt="{{ $tour->name }}">
            <div class="card-body">
                <h5 class="card-title">{{ $tour->name }}</h5>
                <p class="card-text">{{ Str::limit($tour->description, 100) }}</p>
                <p class="text-muted"><strong>Локация:</strong> {{ $tour->location }}</p>
                <p class="tour-info"><strong>Длительность:</strong>
                    {{ $tour->duration }}
                    @if($tour->duration % 10 == 1 && $tour->duration % 100 != 11)
                    час
                    @elseif(in_array($tour->duration % 10, [2, 3, 4]) && !in_array($tour->duration % 100, [12, 13, 14]))
                    часа
                    @else
                    часов
                    @endif
                </p>

                <p><strong>Цена:</strong> {{ number_format($tour->price, 2) }} ₽</p>
                <a href="{{ route('tour.show', $tour->id) }}" class="btn btn-primary w-100">Подробнее</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
