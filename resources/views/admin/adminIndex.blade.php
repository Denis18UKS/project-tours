@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Управление турами</h1>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTourModal">
        Добавить новый тур
    </button>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Название</th>
                <th>Описание</th>
                <th>Местоположение</th>
                <th>Цена</th>
                <th>Статус</th>
                <th>Фото</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tours as $tour)
            <tr>
                <td>{{ $tour->name }}</td>
                <td>{{ $tour->description }}</td>
                <td>{{ $tour->location }}</td>
                <td>{{ $tour->price }}</td>
                <td>{{ $tour->status }}</td>
                <td>
                    @if($tour->image_url)
                    <img src="{{ asset($tour->image_url) }}" alt="Фото" width="100">
                    @else
                    Нет фото
                    @endif
                </td>
                <td>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editTourModal{{ $tour->id }}">
                        Редактировать
                    </button>

                    <form action="{{ route('tours.destroy', $tour) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </form>
                </td>
            </tr>

            <!-- Модальное окно для добавления тура -->
            <div class="modal fade" id="addTourModal" tabindex="-1" aria-labelledby="addTourModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="addTourModalLabel">Добавить новый тур</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('tours.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="name">Название тура</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Описание</label>
                                        <textarea name="description" class="form-control" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="location">Местоположение</label>
                                        <input type="text" name="location" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="duration">Длительность</label>
                                        <input type="number" name="duration" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="price">Цена</label>
                                        <input type="number" name="price" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="image_url">Фото тура</label>
                                        <input type="file" name="image_url" class="form-control" accept=".jpg, .jpeg, .png, .webp">
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Статус</label>
                                        <select name="status" class="form-control" required>
                                            <option value="active">Активный</option>
                                            <option value="inactive">Неактивный</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="available_dates">Доступные даты</label>
                                        <div id="available-dates-container">
                                            <input type="date" name="available_dates[]" class="form-control mb-2" min="{{ date('Y-m-d') }}">
                                        </div>
                                        <button type="button" class="btn btn-info mt-2"
                                            onclick="addDateField('available-dates-container')">
                                            Добавить дату
                                        </button>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                                    <button type="submit" class="btn btn-primary">Сохранить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Модальное окно для редактирования (уникальное для каждого тура) -->
            <div class="modal fade" id="editTourModal{{ $tour->id }}" tabindex="-1" aria-labelledby="editTourModalLabel{{ $tour->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editTourModalLabel{{ $tour->id }}">Редактировать тур</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('tours.update', $tour->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="edit_name{{ $tour->id }}">Название тура</label>
                                    <input type="text" name="name" id="edit_name{{ $tour->id }}" class="form-control" value="{{ $tour->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="edit_description{{ $tour->id }}">Описание</label>
                                    <textarea name="description" id="edit_description{{ $tour->id }}" class="form-control" required>{{ $tour->description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="edit_location{{ $tour->id }}">Местоположение</label>
                                    <input type="text" name="location" id="edit_location{{ $tour->id }}" class="form-control" value="{{ $tour->location }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="edit_duration{{ $tour->id }}">Длительность</label>
                                    <input type="number" name="duration" id="edit_duration{{ $tour->id }}" class="form-control" value="{{ $tour->duration }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="edit_price{{ $tour->id }}">Цена</label>
                                    <input type="number" name="price" id="edit_price{{ $tour->id }}" class="form-control" value="{{ $tour->price }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="edit_image_url{{ $tour->id }}">Фото тура</label>
                                    <input type="file" name="image_url" id="edit_image_url{{ $tour->id }}" class="form-control">
                                    @if($tour->image_url)
                                    <div class="mt-2">
                                        <img src="{{ url($tour->image_url) }}" alt="Фото" width="100">

                                    </div>
                                    @else
                                    <p>Нет фото</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="edit_status{{ $tour->id }}">Статус</label>
                                    <select name="status" id="edit_status{{ $tour->id }}" class="form-control" required>
                                        <option value="active" {{ $tour->status == 'active' ? 'selected' : '' }}>Активный</option>
                                        <option value="inactive" {{ $tour->status == 'inactive' ? 'selected' : '' }}>Неактивный</option>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                                    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @endforeach
        </tbody>
    </table>
</div>

<script>
    function addDateField(containerId) {
        const container = document.getElementById(containerId);
        const newDateField = document.createElement('input');
        newDateField.setAttribute('type', 'date');
        newDateField.setAttribute('name', 'available_dates[]');
        newDateField.setAttribute('class', 'form-control mb-2');
        container.appendChild(newDateField);
    }
</script>
@endsection
