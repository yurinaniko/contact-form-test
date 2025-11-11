@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="contact-form__content">
    <div class="contact-form__heading">
        <h2>Contact</h2>
    </div>

    <form class="form" action="{{ route('contact.confirm') }}" method="post">
        @csrf

        {{-- お名前 --}}
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">お名前 </span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--name">
                    <div class="form__input--last">
                        <input type="text" name="last_name" placeholder="例：田中" value="{{ old('last_name') }}">
                            <div class="form__error">
                            @error('last_name')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                            </div>
                    </div>
                    <div class="form__input--first">
                        <input type="text" name="first_name" placeholder="例：太郎" value="{{ old('first_name') }}">
                            <div class="form__error">
                            @error('first_name')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                            </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 性別 --}}
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">性別</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--gender">
                    <label>
                        <input type="radio" name="gender" value="1"
                        {{ old('gender', isset($inputs['gender']) ? $inputs['gender'] : '') == '1' ? 'checked' : '' }}>男性
                    </label>

                    <label>
                        <input type="radio" name="gender" value="2"
                        {{ old('gender', isset($inputs['gender']) ? $inputs['gender'] : '') == '2' ? 'checked' : '' }}>女性
                    </label>

                    <label>
                        <input type="radio" name="gender" value="3"
                        {{ old('gender', isset($inputs['gender']) ? $inputs['gender'] : '') == '3' ? 'checked' : '' }}>その他
                    </label>
                </div>
                <div class="form__error">
                @error('gender')
                    <p class="error-message">{{ $message }}</p>
                @enderror
                </div>
            </div>
        </div>

        {{-- メールアドレス --}}
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">メールアドレス</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="email" name="email" placeholder="例：example@example.com" value="{{ old('email') }}">
                </div>
                <div class="form__error">
                @error('email')
                    <p class="error-message">{{ $message }}</p>
                @enderror
                </div>
            </div>
        </div>

        {{-- 電話番号 --}}
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">電話番号</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--tel">
                    <input type="text" name="tel1" maxlength="4" placeholder="090" value="{{ old('tel1') }}">
                    <span>-</span>
                    <input type="text" name="tel2" maxlength="4" placeholder="1234" value="{{ old('tel2') }}">
                    <span>-</span>
                    <input type="text" name="tel3" maxlength="4" placeholder="5678" value="{{ old('tel3') }}">
                </div>
                @if ($errors->has('tel1') || $errors->has('tel2') || $errors->has('tel3'))
                    <div class="form__error">
                        <p class="error-message">
                        {{ $errors->first('tel1') ?? $errors->first('tel2') ?? $errors->first('tel3') }}
                        </p>
                    </div>
                @endif
            </div>
        </div>

        {{-- 住所 --}}
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">住所</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="address" placeholder="例：東京都渋谷区千駄ヶ谷1-2-3" value="{{ old('address') }}">
                </div>
                <div class="form__error">
                @error('address')
                    <p class="error-message">{{ $message }}</p>
                @enderror
                </div>
            </div>
        </div>

        {{-- 建物名 --}}
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">建物名</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="building" placeholder="例：千駄ヶ谷マンション101" value="{{ old('building') }}">
                </div>
            </div>
        </div>

        {{-- お問い合わせの種類 --}}
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">お問い合わせの種類</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--select">
                    <select name="category_id">
                        <option value="" disabled selected>選択してください</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->content }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form__error">
                @error('category_id')
                    <p class="error-message">{{ $message }}</p>
                @enderror
                </div>
            </div>
        </div>

        {{-- お問い合わせ内容 --}}
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">お問い合わせ内容</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--textarea">
                    <textarea name="detail" placeholder="お問い合わせ内容をご記入ください">{{ old('detail') }}</textarea>
                </div>
                <div class="form__error">
                @error('detail')
                    <p class="error-message">{{ $message }}</p>
                @enderror
                </div>
            </div>
        </div>

        {{-- 送信ボタン --}}
        <div class="form__button">
            <button class="form__button-submit" type="submit">確認画面</button>
        </div>
    </form>
</div>
@endsection
