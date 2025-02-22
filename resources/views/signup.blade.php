@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h1 class="text-center mb-4">Регистрация</h1>

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('signup') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label for="full_name" class="form-label">ФИО</label>
                            <input type="text" 
                                   name="full_name" 
                                   class="form-control @error('full_name') is-invalid @enderror" 
                                   id="full_name" 
                                   value="{{ old('full_name') }}" 
                                   required>
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Телефон</label>
                            <input type="tel" 
                                   name="phone_number" 
                                   class="form-control @error('phone_number') is-invalid @enderror" 
                                   id="phone_number" 
                                   value="{{ old('phone_number') }}"  
                                   pattern="^\+7\d{10}$" 
                                   placeholder="+7XXXXXXXXXX"
                                   required>
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Формат: +7XXXXXXXXXX</div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" 
                                   name="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   value="{{ old('email') }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Пароль</label>
                            <input type="password" 
                                   name="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   required 
                                   minlength="6">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Минимум 6 символов</div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3">Зарегистрироваться</button>
                        
                        <div class="text-center">
                            Уже есть аккаунт? <a href="{{ route('signin') }}">Войти</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('phone_number').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 0 && value[0] !== '+') {
        if (value.length === 11 && value[0] === '7') {
            value = '+' + value;
        } else {
            value = '+7' + value.slice(-10);
        }
    }
    e.target.value = value;
});

// Валидация формы на стороне клиента
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
})()
</script>

<style>
.card {
    border: none;
    border-radius: 10px;
}

.form-control:focus {
    box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25);
    border-color: #86b7fe;
}

.btn-primary {
    padding: 0.8rem;
    font-size: 1.1rem;
}

.invalid-feedback {
    font-size: 0.875rem;
}

.form-text {
    font-size: 0.875rem;
    color: #6c757d;
}
</style>
@endsection