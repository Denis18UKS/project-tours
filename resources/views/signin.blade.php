@extends('layouts.app')

@section('title', 'Вход')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h1 class="text-center mb-4">Вход в систему</h1>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->has('auth'))
                        <div class="alert alert-danger">
                            {{ $errors->first('auth') }}
                        </div>
                    @endif

                    <form action="{{ route('signin') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   required
                                   autofocus>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Пароль</label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password"
                                   required>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <button type="submit" class="btn btn-primary w-100 mb-3">Войти</button>
                        

                        <div class="text-center">
                            Нет аккаунта? <a href="{{ route('signup') }}" class="text-decoration-none">Зарегистрироваться</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}
</style>
@endsection