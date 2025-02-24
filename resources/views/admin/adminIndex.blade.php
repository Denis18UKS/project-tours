@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Управление турами</h1>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTourModal"
        data-bs-whatever="@mdo">Добавить новый тур</button>

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
                <? if ($tour->status === 'active') { ?>
                    <td>активен</td>
                <? } else if ($tour->status === 'inactive') { ?>
                    <td>неактивен</td>
                <? } ?>
                <td>
                    @if($tour->image_url)
                    <img src="{{ asset($tour->image_url) }}" alt="Фото" width="100">
                    @else
                    Нет фото
                    @endif
                </td>
                <td>
                    <button type="button" class="btn btn-warning edit-tour-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#editTourModal"
                        data-id="{{ $tour->id }}"
                        data-name="{{ $tour->name }}"
                        data-description="{{ $tour->description }}"
                        data-location="{{ $tour->location }}"
                        data-duration="{{ $tour->duration }}"
                        data-price="{{ $tour->price }}"
                        data-status="{{ $tour->status }}"
                        data-image="{{ asset($tour->image_url) }}"
                        data-dates="{{ json_encode($tour->available_dates) }}">
                        Редактировать
                    </button>


                    <form action="{{ route('tours.destroy', $tour) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Модальное окно для добавления -->
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
                            <input type="number" name="price" class="form-control" min='0' required>
                        </div>
                        <div class="form-group">
                            <label for="image_url">Фото тура</label>
                            <input type="file" name="image_url" class="form-control">
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
                                <input type="date" name="available_dates[]" class="form-control mb-2">
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

<!-- Модальное окно для редактирования -->
<div class="modal fade" id="editTourModal" tabindex="-1" aria-labelledby="editTourModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editTourModalLabel">Редактировать тур</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Форма для редактирования -->
                <form action="{{ route('tours.update', $tour->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- Метод PUT для обновления -->
                    <div class="form-group">
                        <label for="edit_name">Название тура</label>
                        <input type="text" name="name" id="edit_name" class="form-control" value="{{ $tour->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_description">Описание</label>
                        <textarea name="description" id="edit_description" class="form-control" required>{{ $tour->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_location">Местоположение</label>
                        <input type="text" name="location" id="edit_location" class="form-control" value="{{ $tour->location }}" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_duration">Длительность</label>
                        <input type="number" name="duration" id="edit_duration" class="form-control" value="{{ $tour->duration }}" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_price">Цена</label>
                        <input type="number" name="price" id="edit_price" min='0' class="form-control" value="{{ $tour->price }}" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_image_url">Фото тура</label>
                        <input type="file" name="image_url" id="edit_image_url" class="form-control">
                        @if($tour->image_url)
                        <div class="mt-2">
                            <img src="{{ asset($tour->image_url) }}" alt="Текущая фото" width="100">
                        </div>
                        @else
                        <p>Нет фото</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="edit_status">Статус</label>
                        <select name="status" id="edit_status" class="form-control" required>
                            <option value="active" {{ $tour->status == 'active' ? 'selected' : '' }}>Активный</option>
                            <option value="inactive" {{ $tour->status == 'inactive' ? 'selected' : '' }}>Неактивный</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_available_dates">Доступные даты</label>
                        <div id="edit-available-dates-container">
                            @foreach($tour->available_dates as $date)
                            <input type="date" name="available_dates[]" class="form-control mb-2" value="{{ $date }}">
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-info mt-2" onclick="addDateField('edit-available-dates-container')">Добавить дату</button>
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


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const today = new Date().toISOString().split("T")[0]; // Получаем сегодняшнюю дату в формате YYYY-MM-DD

        document.querySelectorAll('input[type="date"]').forEach(input => {
            input.setAttribute("min", today); // Устанавливаем минимальное значение даты
        });

        // Автоматически применять min-дату при добавлении новых полей
        function addDateField(containerId) {
            const container = document.getElementById(containerId);
            const newDateField = document.createElement("input");
            newDateField.setAttribute("type", "date");
            newDateField.setAttribute("name", "available_dates[]");
            newDateField.setAttribute("class", "form-control mb-2");
            newDateField.setAttribute("min", today);
            container.appendChild(newDateField);
        }

        // Подключаем к глобальной области видимости
        window.addDateField = addDateField;
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let editTourModal = document.getElementById("editTourModal");

        editTourModal.addEventListener("show.bs.modal", function(event) {
            let button = event.relatedTarget; // Кнопка, которая вызвала модалку

            // Получаем данные из data-* атрибутов
            let id = button.getAttribute("data-id");
            let name = button.getAttribute("data-name");
            let description = button.getAttribute("data-description");
            let location = button.getAttribute("data-location");
            let duration = button.getAttribute("data-duration");
            let price = button.getAttribute("data-price");
            let status = button.getAttribute("data-status");
            let image = button.getAttribute("data-image");
            let dates = JSON.parse(button.getAttribute("data-dates"));

            // Заполняем форму в модальном окне
            document.querySelector("#editTourModal form").setAttribute("action", `/tours/${id}`);
            document.getElementById("edit_name").value = name;
            document.getElementById("edit_description").value = description;
            document.getElementById("edit_location").value = location;
            document.getElementById("edit_duration").value = duration;
            document.getElementById("edit_price").value = price;
            document.getElementById("edit_status").value = status;

            // Подставляем изображение
            let imgElement = document.querySelector("#editTourModal img");
            if (image) {
                imgElement.src = image;
                imgElement.style.display = "block";
            } else {
                imgElement.style.display = "none";
            }

            // Обновляем доступные даты
            let datesContainer = document.getElementById("edit-available-dates-container");
            datesContainer.innerHTML = ""; // Очищаем перед вставкой
            dates.forEach(date => {
                let input = document.createElement("input");
                input.type = "date";
                input.name = "available_dates[]";
                input.classList.add("form-control", "mb-2");
                input.value = date;
                datesContainer.appendChild(input);
            });
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('input[name="price"]').forEach(input => {
            input.addEventListener("input", function() {
                if (this.value < 0) {
                    this.value = 0; // Автоматически сбрасывает цену до 0
                }
            });
        });
    });
</script>



@endsection
