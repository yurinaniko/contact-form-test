@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="contact-form__content">
    <div class="contact-form__heading">
        <h2>Register</h2>
    </div>
</div>
<div class="register-container">
        <form method="POST" action="{{ route('register') }}">
        @csrf
            <div class="form-group">
                <label for="name">お名前</label>
                    <input id="name" type="text" name="name"
                    value="{{ old('name') }}"
                    placeholder="例: 山田 花子">
                    @error('name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
            </div>
            <div class="form-group">
                <label for="email">メールアドレス</label>
                    <input id="email" type="email" name="email"
                    value="{{ old('email') }}"
                    placeholder="例: test@example.com">
                    @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
            </div>
            <div class="form-group">
                <label for="password">パスワード</label>
                    <input id="password"
                    type="password" name="password" placeholder="例：coachtech1106">
                    @error('password')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
            </div>
            <button type="submit" class="register-btn">登録</button>
        </form>
        </div>
</div>
@endsection