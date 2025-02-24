@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Управление бронью</h1>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Пользователь</th>
                <th>Тур</th>
                <th>Дата</th>
                <th>Количестве человек</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->user->full_name }}</td> <!-- Имя пользователя -->
                <td>{{ $booking->tour->name }}</td> <!-- Название тура -->
                <td>{{date('d.m.Y', strtotime($booking->date))}}</td>
                <td>{{ $booking->seats_booked }}</td>
                <? if ($booking->status === 'pending') { ?>
                    <td>ожидание</td>
                <? } else if ($booking->status === 'confirmed') { ?>
                    <td>принято</td>
                <? }
                if ($booking->status === 'canceled') { ?>
                    <td>отклонено</td>
                <? } ?>

                <td>
                    <? if ($booking->status === 'pending') { ?>
                        <!-- Кнопки для смены статуса -->
                        <form action="{{ route('admin.changeStatus', $booking->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="confirmed">
                            <button type="submit" class="btn btn-success">Принять</button>
                        </form>

                        <form action="{{ route('admin.changeStatus', $booking->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="canceled">
                            <button type="submit" class="btn btn-danger">Отклонить</button>
                        </form>

                    <? } else { ?>
                        <i>Действия недоступны, так как статус был изменён</i>
                    <? } ?>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
