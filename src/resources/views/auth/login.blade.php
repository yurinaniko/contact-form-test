@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="contact-form__content">
    <div class="contact-form__heading">
        <h2>login</h2>
    </div>
</div>
<div class="login-container">
    @if (session('status'))
        <div class="status-message">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        {{-- メールアドレス --}}
        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="@error('email') error @enderror"
                placeholder="例：test@example.com"
                autocomplete="off"
            >
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- パスワード --}}
        <div class="form-group">
            <label for="password">パスワード</label>
            <input
            id="password"
            type="password"
            name="password"
            class="@error('password') error @enderror"
            placeholder="例：coachtech1106"
            autocomplete="new-password"
            >
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- ログインボタン --}}
        <div class="form-group button-area">
            <button type="submit" class="login-btn">ログイン</button>
        </div>
    </form>
</div>
@endsection