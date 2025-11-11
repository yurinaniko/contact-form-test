@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')
<div class="confirm__content">
    <div class="contact-form__heading">
        <h2>Confirm</h2>
    </div>
    <form class="form" action="{{ route('contact.thanks') }}" method="post">
    @csrf
        <table class="form__table">
            <tr>
                <th>お名前</th>
                <td>{{ $inputs['last_name'] }} {{ $inputs['first_name'] }}</td>
            </tr>
            <tr>
                <th>性別</th>
                <td>{{ $genderText }}</td>
            </tr>
            <tr>
                <th>メールアドレス</th>
                <td>{{ $inputs['email'] }}</td>
            </tr>
            <tr>
                <th>電話番号</th>
                <td>{{ $inputs['tel'] }}</td>
            </tr>
            <tr>
                <th>住所</th>
                <td>{{ $inputs['address'] }}</td>
            </tr>
            <tr>
                <th>建物名</th>
                <td>{{ $inputs['building'] }}</td>
            </tr>
            <tr>
                <th>お問い合わせの種類</th>
                <td>{{ $category_name }}</td>
            </tr>
            <tr>
                <th>お問い合わせ内容</th>
                <td>{{ $inputs['detail'] }}</td>
            </tr>
        </table>

    {{-- hidden（非表示）で全データを再送 --}}
    @foreach ($inputs as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach

        <div class="form__buttons">
            <button type="submit" name="back" class="form__btn--gray">修正</button>
            <button type="submit" class="form__btn--brown">送信</button>
        </div>
    </form>
</div>
@endsection