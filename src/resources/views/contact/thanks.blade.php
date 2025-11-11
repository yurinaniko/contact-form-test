@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<div class="thanks__content">
    <div class="thanks__background">
        <span>Thank you</span>
    </div>

    <div class="thanks__message">
        <p>お問い合わせありがとうございました</p>
    </div>

    <div class="thanks__button">
    <a href="{{ route('contact.index') }}">HOME</a>
    </div>
</div>
@endsection